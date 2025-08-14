<?php
namespace app\controllers;
use Yii;
use app\models\Solicitud;
use app\models\SolicitudSearch;
use app\models\Biopsia;
use app\models\Solicitudpap;
use app\models\Solicitudbiopsia;
use app\models\Procedencia;
use app\models\Plantillamaterial;
use app\models\PacienteSearch;
use app\models\Paciente;
use app\models\MedicoSearch;
use app\models\Medico;
use app\models\Pap;
use app\models\AnioProtocolo;
use app\models\CarnetOs;
use app\models\patronState\EstadoBase;
use app\models\Materialsolicitud;
use app\models\MaterialsolicitudSolicitud;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\models\patronState\EstadoFactory;
use yii\helpers\ArrayHelper;


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
            //muestros la vista de la solicitud, en los casos donde el administrativo finaliza el estudio
            // y carga el adjunto del estudio que realizan en otro laboratorio
            if ($solicitud->id_estado == EstadoBase::DERIVADO_LISTO && !empty($solicitud->adjuntosolicituds)){
              //tengo que ver si tiene adjunto, si tiene adjunto MOSTRAR EL ARCHIVO.
              return [
                       'title'=> "ESTUDIO DE ".strtoupper($solicitud->estudio->modelo)." - ".$solicitud->estado->descripcion,
                      'content' => $this->renderAjax(
                             '/solicitud' . ($solicitud->estudio->modelo) . '/view',
                             ['model' => $solicitud]
                         ),
                      'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                  ];
            }
            else {
              //Si es distinto de un estado listo
              if ($solicitud->id_estado !==EstadoBase::LISTO){
                return ['title' => "ESTUDIO ".$solicitud->estado->descripcion ,
                'content' => '<h3>'.$solicitud->estado->explicacion.'</h3>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
              }
            }
            $Model= $namespace.ucfirst($solicitud->estudio->modelo);
            //Puede ser una solicitud de biopsia o de pap
            $estudio = $Model::findOne(['id_solicitud'.$solicitud->estudio->modelo=>$id]);
            //muestro la vista de las BIOPSIAS o PAPS
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
        //En el modelo de solicitudes de pap y biopsias solo busca la solicitudes
        //que estan en estado PENDIENTE
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
                //En caso que estén trabajando en forma concurrente, valida la apropiación de la solicitud
                //es decir si alguíen hizo uso de la misma, otro no pueda reutilizarla
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
                'searchModelPac' => $searchModelPac,
                'dataProviderPac' => $dataProviderPac,
                'searchModelMed' => $searchModelMed,
                'dataProviderMed' => $dataProviderMed,
            ];
      }
    /**
     * Renderiza el formulario con todos los datos necesarios
     * @param ActiveRecord $model
     * @return string
     */
    private function renderForm($model) {
        // Calculamos las opciones de estado
        $stateOptions = \app\models\patronState\EstadoFactory::getAvailableTransitions(
            $model->id_estado,
            Yii::$app->user->identity,
            $model
        );
        // Preparamos los datos para los dropdowns

        $viewData = [
            'model' => $model,
            'modelosDat' => $this->devolverModelos(),
            'mapprocedencia' => ArrayHelper::map(Procedencia::find()->all(), 'id', 'nombre'),
            'materialesSolicitud' => ArrayHelper::map(Materialsolicitud::find()
            ->where([ 'id_estudio'=> $model->idEstudio()])
            ->all(), 'id', 'descripcion'),
            'valorMateriales' => ArrayHelper::map(MaterialsolicitudSolicitud::find()
            ->where(['id_solicitud' => $model->id ])
                ->all() , 'id_materialsolicitud', 'id_materialsolicitud'),

            'stateOptions' => $stateOptions,
        ];

        return $this->render('_form', $viewData);
    }

    /**
     * Registra materiales asociados a un modelo.
     *
     * @param Model $model Modelo que contiene id_estudio e id
     * @param array $arrayMaterial Lista de IDs de materiales a registrar
     * @return void
     */
     private function registrarMaterial($model, $arrayMaterial): void
     {
         // Asegurar que $arrayMaterial sea un array, incluso si es null
         $arrayMaterial = is_array($arrayMaterial) ? $arrayMaterial : [];

         // Obtener materiales actuales asociados a esta solicitud
         $materialesActuales = MaterialsolicitudSolicitud::find()
             ->select('id_materialsolicitud')
             ->where([
                 'id_estudio' => $model->id_estudio,
                 'id_solicitud' => $model->id,
             ])
             ->column();

         // Calcular diferencias
         $aAgregar = array_diff($arrayMaterial, $materialesActuales);
         $aEliminar = array_diff($materialesActuales, $arrayMaterial);

         // Agregar nuevos materiales
         foreach ($aAgregar as $materialId) {
             $materialSolicitud = new MaterialsolicitudSolicitud([
                 'id_materialsolicitud' => $materialId,
                 'id_estudio' => $model->id_estudio,
                 'id_solicitud' => $model->id,
             ]);

             if (!$materialSolicitud->save()) {
                 Yii::error("Error al guardar material ID: $materialId - " . json_encode($materialSolicitud->errors));
             }
         }

         // Eliminar materiales que ya no están en el nuevo array
         if (!empty($aEliminar)) {
             MaterialsolicitudSolicitud::deleteAll([
                 'id_estudio' => $model->id_estudio,
                 'id_solicitud' => $model->id,
                 'id_materialsolicitud' => $aEliminar,
             ]);
         }
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

        if ($request->isPost) {
            $anioprotocolo = AnioProtocolo::anioprotocoloActivo();
            $model->id_anio_protocolo = $anioprotocolo->id;
            if ($model->load($request->post()) && $model->save()) {
                $this->registrarMaterial($model,$request->post('MaterialArray'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->renderForm($model);
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
        if ($this->request->isPost) {
            if ($model->load($request->post()) && $model->save()) {
              $this->registrarMaterial($model,$request->post('MaterialArray'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->renderForm($model);
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

    private function contieneEstudio($id_solicitud)
    {
        return Biopsia::find()
                ->where(['id_solicitudbiopsia' => $id_solicitud])
                ->exists()
            ||
            Pap::find()
                ->where(['id_solicitudpap' => $id_solicitud])
                ->exists();
    }


    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);

       if ($this->contieneEstudio($id)) {
            $this->setearMensajeError("No se puede eliminar la solicitud porque tiene un informe asociado");
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];

       }

       if (!empty($model->adjuntosolicituds)){
            $this->setearMensajeError("No se puede eliminar la solicitud porque tiene archivos adjuntos");
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];
       }
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
                throw new NotFoundHttpException($e->getMessage(), 500);
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
