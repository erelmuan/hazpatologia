<?php
namespace app\controllers;
use Yii;
use app\models\Solicitud;
use app\models\SolicitudSearch;
use app\models\Biopsia;
use app\models\Solicitudpap;
use app\models\Solicitudbiopsia;
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
use app\models\CarnetOs;
use app\components\Metodos\Metodos;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
/**
 * SolicitudController implements the CRUD actions for Solicitud model.
 */
class SolicitudController extends Controller {
  // behaviors heredado


    public function actionIndex() {
        $model = new Solicitud();
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null);
        $dataProvider->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }
    public function actionAnulado() {
        $model = new Solicitud();
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'anulado');
        $dataProvider->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('anulado', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }


    public function actionConsulta() {
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'consulta');
        $dataProvider->pagination->pageSize = 7;
        return $this->render('consulta', ['searchModel' => $searchModel,
         'dataProvider' => $dataProvider ]);
    }

    public function actionAutocomplete()
    {
        $searchModel = new SolicitudSearch();
        $searchModel->term = Yii::$app->request->get('term'); // Acceder al valor enviado
        $searchModel->load(Yii::$app->request->queryParams);
        // Realiza la búsqueda en la base de datos para obtener los resultados del autocompletado
        $results = $searchModel->searchAutocomplete();
        $data = [];
        foreach ($results as $result) {
            // Define la estructura de datos que se enviará como respuesta en formato JSON
            $data[] = [
                'value' => $result->paciente->apellido.' ,'.$result->paciente->nombre, // Valor que se mostrará en el campo de autocompletado
                'id_paciente' => $result->paciente->id, // ID asociado al valor seleccionado (opcional)
            ];
        }
        // Devuelve los resultados en formato JSON
        return Json::encode($data);
    }

    public function actionViewconsulta($id)
    {
        $request = Yii::$app->request;
        $namespace="app\models\\";
        $solicitud = $this->findModel($id);
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            //Si es distinto de un estado listo
            if ($solicitud->id_estado !==2){
              return ['title' => "ESTUDIO ".$solicitud->estado->descripcion ,
              'content' => '<h3>'.$solicitud->estado->explicacion.'</h3>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];

            }
            $Model= $namespace.ucfirst($solicitud->estudio->modelo);
            //Puede ser una solicitud de biopsia o de pap
            $estudio = $Model::findOne(['id_solicitud'.$solicitud->estudio->modelo=>$id]);

            return [
                    'title'=> "ESTUDIO DE ".strtoupper($solicitud->estudio->modelo)." - ".$solicitud->estado->descripcion. " #".$estudio->id,
                    'content'=>$this->renderAjax('/'.$solicitud->estudio->modelo.'/view', [
                        'model' => $estudio
                    ]),

                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
        }
    }

      public function actionSeleccionar() {
        //El metodo Seleccionar es invocado desde la clase hija
        //por eso puede usar el metodo returnModelSearch que esta en la misma y no el de solicitudController
        $searchModel = $this->returnModelSearch();
        //En el modelo de solicitudes de pap y biopsias solo busca la solicitudes que no tienen informes asociados
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        if (isset($_POST['idsol'])) {
            if ($_POST['idsol'] == '') {
                $this->setearMensajeError('DEBE ELEGIR UNA OPCION');
                return $this->redirect(['/' . $searchModel->tableName() . '/seleccionar']);
            }
            else {
                $data = Yii::$app->request->post();
                $id = explode(":", $data['idsol']);
                $id = $id[0];
                $model = $this->findModel($id);
                $modelestudio = $model->estudio->modelo;
                //En caso que esten trabajando en forma concurrente, valida la apropiacin de la solicitud
                //es decir si alguien hizo uso de la misma, otro no pueda reutilizarla
                if ($model->$modelestudio !== null) {
                    $this->setearMensajeError('La solicitud que eligio ya fue agregada a un formulario de un informe');
                    return $this->redirect(['/' . $searchModel->tableName() . '/seleccionar']);
                }
                else {
                    return $this->redirect([$modelestudio . '/create', 'idsol' => $_POST['idsol']]);
                }
            }
        }
        return $this->render('/solicitud/seleccionar', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }

    /**
     * Displays a single Solicitud model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['title' => "SOLICITUD " . $model
                ->estudio->descripcion . " #" . $id, 'content' => $this->renderAjax('view', ['model' => $model ]) ,
                'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $model ]);
        }
    }
    public function validar($fecha) {
        //Si no encuentra protocolo año vigente para la fecha
        if (!AnioProtocolo::getAnioProtocoloActivo($fecha)) {
            $this->setearMensajeError('NO SE PUEDE CREAR LA SOLICITUD SI FECHA DE REALIZACION NO COINCIDE CON EL AÑO DE PROTOCOLO ACTIVO ');
            return false;
        }
        return true;
    }
    public function actionBuscarprotocolo() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            return Json::encode(["protocolo" => Solicitud::obtenerProtocolo() ]);
        }
    }


    public function devolverModelos(){
      ////////////PACIENTE/////////////////
      $modelPac = new Paciente();
      $searchModelPac = new PacienteSearch();
      $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams,false);
      $dataProviderPac->pagination->pageSize = 7;
      ////////////MEDICO/////////////////
      $modelMed = new Medico();
      $searchModelMed = new MedicoSearch();
      $dataProviderMed = $searchModelMed->search(Yii::$app->request->queryParams,false);
      $dataProviderMed->pagination->pageSize = 7;
      return [
              'modelPac' => $modelPac,
              'searchModelPac' => $searchModelPac,
              'dataProviderPac' => $dataProviderPac,
              'modelMed' => $modelMed,
              'searchModelMed' => $searchModelMed,
              'dataProviderMed' => $dataProviderMed,
          ];
    }

    /**
     * Creates a new Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (Yii::$app->user->identity->id_pantalla == 1) { //Principal
            $this->layout = 'main3';
        }
        $request = Yii::$app->request;
        $model = $this->returnModel();
        $model->scenario = 'create'; //es para validar el protocolo unico por año
        $modelos = $this->devolverModelos();

        if ($this->request->isPost) {
            //Si no valida
            if (!$this->validar($_POST[$model->classNameM() ]["fechadeingreso"])) {
                return $this->redirect([$model->tableName() . "/create"]);
            }
            $anioprotocolo = AnioProtocolo::anioprotocoloActivo();
            $model->id_anio_protocolo = $anioprotocolo->id;
            //si protocolo automatico esta activado si o si va insertar el valor que obtiene de la base
            // con esto me aseguro que por mas que se edite el campo va editar
            //ESTA FUNCIONALIDAD NO ESTA FUNCIONANDO PERO SE ACTIVARA CUANDO SE INCORPORE EL PROTOCOLO AUTOMATICO
            //PROTOCOLO_INSERTAR NO TIENE INCIDENCIA
            if ($_POST[$model->classNameM() ]["protocolo_automatico"] == "1") {
                unset($_POST[$model->classNameM() ]["protocolo"]);
                $model->protocolo = Solicitud::obtenerProtocolo();
            }
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('_form', ['model' => $model,
                'searchModelPac' => $modelos['searchModelPac'],
                'dataProviderPac' => $modelos['dataProviderPac'],
                'modelPac' => $modelos['modelPac'],
                'searchModelMed' => $modelos['searchModelMed'],
                'dataProviderMed' => $modelos['dataProviderMed'],
                'modelMed' => $modelos['modelMed'],
                'protocolo_insertar' => $model->protocolo, ]);
            }
        }
        else {
            return $this->render('_form', ['model' => $model,
            'searchModelPac' => $modelos['searchModelPac'],
            'dataProviderPac' => $modelos['dataProviderPac'],
            'modelPac' => $modelos['modelPac'],
            'searchModelMed' => $modelos['searchModelMed'],
            'dataProviderMed' => $modelos['dataProviderMed'],
            'modelMed' => $modelos['modelMed'],
              'protocolo_insertar' => Solicitud::obtenerProtocolo() , ]);
        }
    }


    /**
     * Updates an existing Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        if (Yii::$app->user->identity->id_pantalla == 1) { //Principal
            $this->layout = 'main3';
        }
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->scenario = 'update'; //es para validar el protocolo unico por año
        $modelestudio = $model->estudio->modelo;
        $modelos = $this->devolverModelos();
        /*
         *   Process for non-ajax request
        */
        if ($this->request->isPost) {
            if (!$this->validar($_POST[$model->classNameM() ]["fechadeingreso"])) {
                return $this->render('_form', ['model' => $model,
                'searchModelPac' => $modelos['searchModelPac'],
                 'dataProviderPac' => $modelos['dataProviderPac'],
                 'modelPac' => $modelos['modelPac'],
                 'searchModelMed' => $modelos['searchModelMed'],
                 'dataProviderMed' => $modelos['dataProviderMed'],
                 'modelMed' => $modelos['modelMed'],
               ]);
            }
            if ($model->load($request->post()) && $model->validate()) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('_form', ['model' => $model,
                'searchModelPac' => $modelos['searchModelPac'],
                'dataProviderPac' => $modelos['dataProviderPac'],
                 'modelPac' => $modelos['modelPac'],
                 'searchModelMed' =>$modelos['searchModelMed'],
                 'dataProviderMed' => $modelos['dataProviderMed'],
                  'modelMed' => $modelos['modelMed'], ]);
            }
        }
        else {
            return $this->render('_form', ['model' => $model,
            'searchModelPac' => $modelos['searchModelPac'],
            'dataProviderPac' => $modelos['dataProviderPac'],
             'modelPac' => $modelos['modelPac'],
             'searchModelMed' =>$modelos['searchModelMed'],
             'dataProviderMed' => $modelos['dataProviderMed'],
              'modelMed' => $modelos['modelMed'],]);
        }
    }

    /**
     * Finds the Solicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Solicitud::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function contieneEstudio($id_solicitud){
      $modelbiopsia = Biopsia::find()->where(['and', 'biopsia.id_solicitudbiopsia = ' . $id_solicitud])->one();
      $modelpap = Pap::find()->where(['and', 'pap.id_solicitudpap = ' . $id_solicitud])->one();
       if (isset($modelbiopsia) || isset($modelpap)) {
         return true;
       }else {
         return false;
       }
    }


    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
       if ($this->contieneEstudio($id)) {
            $this->setearMensajeError("No se puede eliminar la solicitud porque tiene un informe asociado");
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];

       }
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            try {
                if ($model->delete()) {
                  $this->setearMensajeExito('El registro se eliminó correctamente.');
                  return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];
                }
            }
            catch(yii\db\Exception $e) {
                Yii::$app->response->format = Response::FORMAT_HTML;
                throw new NotFoundHttpException('Error en la base de datos. La solicitud esta asociada a un estudio', 500);
            }
        }
        else {
            // el metodo es invocado desde la clase hija,
            // pero quiero se redireccione a la clase controller del padre
            return $this->redirect(['solicitud/index']);
        }
    }

    function returnModel() {
    }
    function returnModelSearch() {
    }
    public function actionDocumento($id) {
        $request = Yii::$app->request;
        // Si entra en el if es porque el estudio esta en estado EN_PROCESO
        //Ver el view de biopsia donde se accde al informe
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['forceReload' => '#crud-datatable-pjax', 'title' => "AVISO!", 'content' => 'EL SIGUIENTE DOCUMENTO TIENE UN ESTADO <b>EN PROCESO</b> (NO ESTA TERMINADO) CONFIRME SI DESEA GENERAR EL DOCUMENTO', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Confirmar', ['/biopsia/informe', 'id' => $id], ['class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'target' => '_blank', 'title' => 'Se abrirá el archivo PDF generado en una nueva ventana']) ];
        }
        else {
            //Esto es correcto?? revisar el id
            $solicitud = $this->findModel($id);
            return $this->render('documento', ['model' => $solicitud ]);
        }
    }
    public function actionFos($tipoSolicitud,$id, $id_carnet=null) {
        $request = Yii::$app->request;
        $modelsolicitud = $tipoSolicitud::find()->where(['and', 'id = ' . $id])->one();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
                return ['title' => "Obra Social - FOS", 'content' => $this->renderAjax('fosobrasocial',
                 ['solicitud' => $modelsolicitud, 'tipoSolicitud'=>$tipoSolicitud]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])  ];
          }
        if ($id_carnet !=null && $modelsolicitud->estado->descripcion ==="LISTO"){

          $carnet= CarnetOs::findOne($id_carnet);
          return $this->render('fos', ['solicitud' => $modelsolicitud, 'carnet' =>$carnet ]);
        }

    }
}
