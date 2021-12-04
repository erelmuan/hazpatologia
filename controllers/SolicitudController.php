<?php

namespace app\controllers;

use Yii;
use app\models\Solicitud;
use app\models\SolicitudSearch;
use app\models\Biopsia;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\PacienteSearch;
use app\models\Paciente;

use app\models\MedicoSearch;
use app\models\Medico;
use app\models\Pap;
use app\models\AnioProtocolo;


use app\components\Metodos\Metodos;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
/**
 * SolicitudController implements the CRUD actions for Solicitud model.
 */
class SolicitudController extends Controller
{


    public function actionIndex()
    {
      // if (Yii::$app->user->identity->id_pantalla==1){ //Principal
      //   $this->layout = 'main3';
      // }
        $model= new Solicitud();
        $model->fecharealizacion = date('d/m/Y',strtotime($model->fecharealizacion));
        $model->fechadeingreso = date('d/m/Y',strtotime($model->fechadeingreso));
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams );
        $dataProvider->pagination->pageSize=7;
        $columnas=Metodos::obtenerColumnas($model);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columnas,

        ]);
    }
    public function actionSeleccionar()
    {
        $searchModel = $this->returnModelSearch();
       //En el modelo de solicitude de pap y biopsias solo busca la solicitudes que no tienen informes asociados
       $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);

        if (isset($_POST['idsol']) ) {
          if ($_POST['idsol'] =='' ){
            $this->setearMensajeError('DEBE ELEGIR UNA OPCION');
            return $this->redirect(['/'.$searchModel->tableName().'/seleccionar']);
          }else
          {

              $data = Yii::$app->request->post();
              $id= explode(":", $data['idsol']);
              $id= $id[0];
              $model = $this->findModel($id);
              $modelestudio= $model->estudio->modelo;
            //En caso que esten trabajando en forma concurrente, valida la apropiacin de la solicitud
            //es decir si alguien hizo uso de la misma, otro no pueda reutilizarla
            if ($model->$modelestudio !==null ){
              $this->setearMensajeError('La solicitud que eligio ya fue agregada a un formulario de un informe');
                return $this->redirect(['/'.$searchModel->tableName().'/seleccionar']);

            }else {

              return $this->redirect([$modelestudio.'/create', 'idsol' => $_POST['idsol']]);
            }
          }
        }

        return $this->render('/solicitud/seleccionar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);

    }
    public function actionSeleccionarmod()
    {
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $exibirEligir=false;
        $exibirUsado=false;
        if (isset($_POST['idsol']) ) {
          if ($_POST['idsol'] =='' ){
            $exibirEligir=true;
            $exibirUsado=false;


          }else
          {

              $data = Yii::$app->request->post();
              $id= explode(":", $data['idsol']);
              $id= $id[0];
              $models = Biopsia::find()->where('id_solicitud = '.$id)->all();
              if (count($models)==1 ){
              $searchModel = new SolicitudSearch();
              $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
              $exibirEligir=false;
              $exibirUsado=true;
            }else {

              return $this->redirect(['biopsia/update', 'id' => 15,'idsol' => $_POST['idsol']]);
            }
          }
        }

        return $this->render('seleccionarmod', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'exibirEligir' =>$exibirEligir,
            'exibirUsado' =>$exibirUsado,
        ]);

    }
    function calcular_edad($id){

      $Solicitud =  Solicitud::findOne($id);
      list($ano,$mes,$dia) = explode("-",$Solicitud->paciente->fecha_nacimiento);
      list($anoR,$mesR,$diaR) = explode("-",$Solicitud->fechadeingreso);


      $ano_diferencia  = $anoR - $ano;
      $mes_diferencia = $mesR - $mes;
      $dia_diferencia   = $diaR - $dia;
      if ( $mes_diferencia < 0)
      {
        $ano_diferencia--;
      }
      elseif ( $mes_diferencia == 0){
        if ( $dia_diferencia < 0)
            $ano_diferencia--;
        }
        return $ano_diferencia;
      }
  /**
     * Displays a single Solicitud model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $request = Yii::$app->request;
        //Esto lo agregue el viernes 28 antes de ir a lo de mama :P
        //esto se deberia corregir ya que no deberia acceder al modelo
        //sino que desde el controlador de biopsia deberia hacer esta accion
        //ESTE COMENTARIO ES POSTERIOR AL ESCRITO EN MINUSCULA, EN REALIDAD
        //DEBERIA CREAR UN METODO EN BIOPSIAS E INVOCARLO DESDE EL MODELO

        $edad = $this->calcular_edad($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                        'title'=> "SOLICITUD ". $model->estudio->descripcion." #".$id,
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                            'edad'=>$edad,
                            //Esto lo agregue el viernes 28 antes de ir a lo de mama :P
                            //ESTO LO COMENTO UN 27 DE OCTUBRE DEL 2019
                            //ESTA MAL EL ID, TIENE QUE SER EL ID DE BIOPSIA NO DE Solicitud
                            //'idbiopsia'=>$id
                            //Esto lo modifico despues del partido de river q perdio con flamenco



                        ]),
                        'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                    ];
        }else{

           // return $this->render('viewV', [
            return $this->render('view', [
                'model' => $model,
                'edad'=>$edad,


            ]);
          }

    }

    public function validar ($fecha){
      //Si no encuentra protocolo año vigente para la fecha
       if(!AnioProtocolo::getAnioProtocoloActivo($fecha)){
           $this->setearMensajeError('NO SE PUEDE CREAR LA SOLICITUD SI FECHA DE REALIZACION NO COINCIDE CON EL AÑO DE PROTOCOLO ACTIVO ');
           return false;
         }
         return true;
    }
    public function actionBuscarprotocolo()
    {
        $request = Yii::$app->request;
      if ($request->isAjax) {
         return Json::encode(["protocolo"=>Solicitud::obtenerProtocolo()]);
        }
    }
    /**
     * Creates a new Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      if (Yii::$app->user->identity->id_pantalla==1){ //Principal
        $this->layout = 'main3';
      }
        $request = Yii::$app->request;
        $model = $this->returnModel();
        // $model = new Solicitud();

        ////////////PACIENTE/////////////////
        $modelPac= new Paciente();
        $searchModelPac = new PacienteSearch();
        $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
        $dataProviderPac->pagination->pageSize=7;

        ////////////MEDICO/////////////////
        $modelMed= new Medico();
        $searchModelMed = new MedicoSearch();
        $dataProviderMed = $searchModelMed->search(Yii::$app->request->queryParams);
        $dataProviderMed->pagination->pageSize=7;


            /*
            *   Process for non-ajax request
            */
          //  $pacientemodel= new Paciente();
          //  $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
        if($this->request->isPost ){
          //Si no valida
          if (!$this->validar($_POST[$model->classNameM()]["fechadeingreso"]))  {
              return $this->redirect([$model->tableName()."/create" ]);

          }
          $anioprotocolo= AnioProtocolo::anioprotocoloActivo();
          $model->id_anio_protocolo=$anioprotocolo->id;
            if ($model->load($request->post()) && $model->save()) {
              //si protocolo automatico esta activado si o si va insertar el valor que obtiene de la base
              // con esto me aseguro que por mas que se edite el campo va editar
              //SE PUEDE MEJORAR CAMBIANDO EL VALOR DE REQUEST POST
                if ($_POST[$model->classNameM()]["protocolo_automatico"] ==	"1"){
                  $model->protocolo=Solicitud::obtenerProtocolo();
                  $model->save();

                }

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
              return $this->redirect([$model->tableName()."/create" ]);

            }
      }
         else {
            return $this->render('_form', [
              'model' => $model,
              'searchModelPac' => $searchModelPac,
              'dataProviderPac' => $dataProviderPac,
              'modelPac' => $modelPac,
              'searchModelMed' => $searchModelMed,
              'dataProviderMed' => $dataProviderMed,
              'modelMed' => $modelMed,
              'protocolo_insertar'=> Solicitud::obtenerProtocolo(),
              ]);
          }
    }

    /**
     * Updates an existing Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      if (Yii::$app->user->identity->id_pantalla==1){ //Principal
        $this->layout = 'main3';
      }
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        $modelestudio= $model->estudio->modelo;
        if (isset($model->$modelestudio) && $model->$modelestudio->estado->descripcion=='LISTO'){
          $this->setearMensajeError('No se puede modificar una solicitud con informe listo.');
           return $this->redirect(['solicitud/index', 'listo' => false]);
        }

         ////////////PACIENTE/////////////////
        $modelPac= new Paciente();
        $searchModelPac = new PacienteSearch();
        $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
        $dataProviderPac->pagination->pageSize=7;

        ////////////MEDICO/////////////////
        $modelMed= new Medico();
        $searchModelMed = new MedicoSearch();
        $dataProviderMed = $searchModelMed->search(Yii::$app->request->queryParams);
        $dataProviderMed->pagination->pageSize=7;

            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('_form', [
                    'model' => $model,
                    'searchModelPac' => $searchModelPac,
                    'dataProviderPac' => $dataProviderPac,
                    'modelPac' => $modelPac,
                    'searchModelMed' => $searchModelMed,
                    'dataProviderMed' => $dataProviderMed,
                    'modelMed' => $modelMed,
                ]);
            }

    }

    /**
     * Delete an existing Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

     public function beforeSave($insert)
     {
         // tareas antes de encontrar el objeto
         if (parent::beforeSave($insert)) {
             // Place your custom code here
             return true;
         } else {
             return false;
         }
     }

    public function actionSelect()
    {
        $request = Yii::$app->request;
        $model = new Solicitud();
        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(isset($_POST['seleccion'])){
                // recibo datos de lo seleccionado, reconstruyo columnas
                $seleccion=$_POST['seleccion'];

                $columnAdmin=$model->attributeColumns();
                $columnSearch=[];
                $columnas=[];
                foreach($columnAdmin as $value){
                    $columnSearch[]=$value['attribute'];
                }

                foreach($seleccion as $key) {
                    $indice=array_search($key, $columnSearch);
                    if ($indice!==null){
                        $columnas[]=$columnAdmin[$indice];
                    }
                }

                // guardo esa informacion, sin controles ni excepciones, no es importante
                $vista = \app\models\Vista::findOne(['id_usuario'=>Yii::$app->user->id,'modelo'=>$model->classname()]);

                if($vista==null){
                    $vista = new \app\models\Vista();
                    $vista->id_usuario=Yii::$app->user->id;
                    $vista->modelo=$model->classname();
                }
                $vista->columna=serialize($columnas);
                 $vista->save();

                return [$vista,'forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];

            }

            // columnas mostradas actualmente
            $columnas=Metodos::obtenerColumnas($model);
            // attributos de las columnas mostradas
            $seleccion=Metodos::obtenerAttributosColumnas($columnas);
            // todas las etiquetas
            $etiquetas=Metodos::obtenerEtiquetasColumnas($model,$seleccion);

            return [
                'title'=> "Personalizar Lista",
                'content'=>$this->renderAjax('/../components/Vistas/_select', [
                    'seleccion' => $seleccion,
                    'etiquetas' => $etiquetas,
                ]),
                'footer'=> Html::button('Cancelar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
            ];

        }else{
            // Process for non-ajax request
            return $this->redirect(['index']);


        }
    }

    /**
     * Finds the Solicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Solicitud::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // public function save($runValidation = true, $attributeNames = null)
    // {
    //   $transaction = Solicitud::getDb()->beginTransaction();
    //   try {
    //     $db = Yii::$app->db;
    //     $protocolo = $db->createCommand('SELECT last_value FROM solicitud_protocolo_seq')
    //                 ->queryColumn();
    //
    //       if ( $protocolo && date("d")==26 && date("m") ==11 && $protocolo[0] !== 1)
    //       {
    //         $db->createCommand('ALTER SEQUENCE solicitud_protocolo_seq RESTART WITH 1')->execute();
    //       //    $db->createCommand('UPDATE solicitud SET idsolicitud=nextval("solicitud_idsolicitud_seq")')->execute();
    //
    //       }
    //     if ($this->getIsNewRecord()) {
    //         return $this->insert($runValidation, $attributeNames);
    //
    //     }
    //     $transaction->commit();
    //     return $this->update($runValidation, $attributeNames) !== false;
    //   }
    //
    // catch(\Exception $e) {
    //     $transaction->rollBack();
    //     throw $e;
    // }

// }
    function returnModel()

    {

    }
    function returnModelSearch()

    {

    }

    public function actionDocumento($id) {
        $request = Yii::$app->request;
        // Si entra en el if es porque el estudio esta en estado EN_PROCESO
        //Ver el view de biopsia donde se accde al informe
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
              'forceReload'=>'#crud-datatable-pjax',
                'title'=> "AVISO!",
                'content'=>'EL SIGUIENTE DOCUMENTO TIENE UN ESTADO <b>EN PROCESO</b> (NO ESTA TERMINADO) CONFIRME SI DESEA GENERAR EL DOCUMENTO',
                'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Confirmar', ['/biopsia/informe', 'id' => $id], [
                        'class'=>'btn btn-primary',
                        'data-toggle'=>'tooltip',
                        'target'=>'_blank',
                        'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
                    ])
            ];

          }else {
            //Esto es correcto?? revisar el id
              $solicitud=$this->findModel($id);
              return $this->render('documento',['model' => $solicitud, 'edad'=> $this->calcular_edad($solicitud->id) ]);
          }
    }


}
