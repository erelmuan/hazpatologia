<?php
namespace app\controllers;
use Yii;
use app\models\Pap;
use app\models\AnioProtocolo;
use app\models\ConfiguracionAniosUsuario;
use app\models\PapSearch;
use app\models\PlantillafloraSearch;
use app\models\PlantillaaspectoSearch;
use app\models\PlantillaglandularSearch;
use app\models\PlantillapavimentosaSearch;
use app\models\PlantilladiagnosticoSearch;
use app\models\PlantillafraseSearch;
use app\models\Cie10Search;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Solicitudpap;
use app\components\Metodos\Metodos;
use app\components\behaviors\AuditoriaBehaviors;
use app\models\Auditoria;
/**
 * PapController implements the CRUD actions for Pap model.
 */
class PapController extends Controller {
    /**
     * Lists all Pap models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new Pap();
        $searchModel = new PapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }
    /**
     * Displays a single Pap model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        $pap = $this->findModel($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['title' => "Pap #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id)  ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('viewV', ['model' => $this->findModel($id)]);
        }
    }
    public function cargarEstructuras(&$search, &$array, &$provider, $id_estudio) {
        //Tendrian que acceder a los modelos por medio de sus controller!!!
        ////////////Flora/////////////////
        $searchModelFlora = new PlantillafloraSearch();
        $arrayflora = $searchModelFlora::find()->all();
        $dataProviderFlora = $searchModelFlora->search(Yii::$app->request->queryParams);
        $dataProviderFlora->pagination->pageSize = 7;
        $search['searchModelFlora'] = $searchModelFlora;
        $array['arrayflora'] = $arrayflora;
        $provider['dataProviderFlora'] = $dataProviderFlora;
        ////////////Aspecto/////////////////
        $searchModelAsp = new PlantillaaspectoSearch();
        $arrayaspecto = $searchModelAsp::find()->all();
        $dataProviderAsp = $searchModelAsp->search(Yii::$app->request->queryParams);
        $dataProviderAsp->pagination->pageSize = 7;
        $search['searchModelAsp'] = $searchModelAsp;
        $array['arrayaspecto'] = $arrayaspecto;
        $provider['dataProviderAsp'] = $dataProviderAsp;
        ////////////Glandular/////////////////
        $searchModelGland = new PlantillaglandularSearch();
        $arrayglandular = $searchModelGland::find()->all();
        $dataProviderGland = $searchModelGland->search(Yii::$app->request->queryParams);
        $dataProviderGland->pagination->pageSize = 7;
        $search['searchModelGland'] = $searchModelGland;
        $array['arrayglandular'] = $arrayglandular;
        $provider['dataProviderGland'] = $dataProviderGland;
        ////////////Pavimentosas/////////////////
        $searchModelPav = new PlantillapavimentosaSearch();
        $arraypavimentosa = $searchModelPav::find()->all();
        $dataProviderPav = $searchModelPav->search(Yii::$app->request->queryParams);
        $dataProviderPav->pagination->pageSize = 7;
        $search['searchModelPav'] = $searchModelPav;
        $array['arraypavimentosa'] = $arraypavimentosa;
        $provider['dataProviderPav'] = $dataProviderPav;
        ////////////Diagnostico/////////////////
        $searchModelDiag = new PlantilladiagnosticoSearch();
        //id_estudio=1 es del estudio de pap
        $arraydiagnostico = $searchModelDiag::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderDiag = $searchModelDiag->search(Yii::$app->request->queryParams, $id_estudio);
        $dataProviderDiag->pagination->pageSize = 7;
        $search['searchModelDiag'] = $searchModelDiag;
        $array['arraydiagnostico'] = $arraydiagnostico;
        $provider['dataProviderDiag'] = $dataProviderDiag;
        ////////////Frase/////////////////
        $searchModelFra = new PlantillafraseSearch();
        //id_estudio=1 es del estudio de pap
        $arrayfrase = $searchModelFra::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderFra = $searchModelFra->search(Yii::$app->request->queryParams, $id_estudio);
        $dataProviderFra->pagination->pageSize = 7;
        $search['searchModelFra'] = $searchModelFra;
        $array['arrayfrase'] = $arrayfrase;
        $provider['dataProviderFra'] = $dataProviderFra;
        ////////////Cie10/////////////////
        $searchModelCie = new Cie10Search();
        $arraycie10 = $searchModelCie::find()->all();
        $dataProviderCie = $searchModelCie->search(Yii::$app->request->queryParams);
        $dataProviderCie->pagination->pageSize = 7;
        $search['searchModelCie'] = $searchModelCie;
        $array['arraycie10'] = $arraycie10;
        $provider['dataProviderCie'] = $dataProviderCie;
    }
    public function validar($post) {
        if (Yii::$app->user->identity->contrasenia <> md5($post['contrasenia'])) {
            Yii::$app->getSession()->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "CONTRASEÑA INCORRECTA", 'title' => 'NOTIFICACIÓN', 'positonY' => 'top', 'positonX' => 'right']);
            return false;
        }
        if ($post['Pap']['firmado'] !== "1") {
            Yii::$app->getSession()->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "EN ESTADO LISTO, DEBE POSEER LA FIRMA", 'title' => 'NOTIFICACIÓN', 'positonY' => 'top', 'positonX' => 'right']);
        }
        else {
            return true;
        }
    }

    /**
     * Creates a new Pap model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Pap();
        $solicitud = Solicitudpap::findOne($_GET['idsol']);
        $search = [];  $array = [];  $provider = [];
        $this->cargarEstructuras($search, $array, $provider, $solicitud->id_estudio);
        if (isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] != 2) {
            unset($post['Pap']['firmado']);
        }
        if (Usuario::isPatologo() && isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] == 2) {
          if (!$this->validar($post)) {
              unset($post['Pap']['id_estado']);
              $model->load($post);
              return $this->render('_form', ['model' => $model, 'solicitud' => $solicitud, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
          }
          $model->fechalisto = date("Y-m-d  H:i:s");
          $model->id_usuario = Yii::$app->user->identity->getId();
        }
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($model->load($post) && $model->save()) {
                // cambio de estados
                if ($solicitud->id_estado !== $model->id_estado) {
                    $solicitud->id_estado = $model->id_estado;
                    $solicitud->scenario = 'update';
                    $solicitud->save();
                }

                if ($model->vph) {
                    $transaction->commit();
                    return $this->redirect(['vph-escaneado/create', 'id_pap' => $model->id]);
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
                return $this->render('_form', ['search' => $search, 'array' => $array, 'provider' => $provider, 'model' => $model, 'solicitud' => $solicitud]);
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }



    /**
     * Updates an existing Pap model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($model->estado->descripcion =="ANULADO"){
          return $this->redirect(['index']);
        }
        $post = $request->post();
        $search = [];$array = [];$provider = [];
        $this->cargarEstructuras($search, $array, $provider, $model->solicitudpap->id_estudio);
        if (isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] != 2) {
            unset($post['Pap']['firmado']);
        }
        //si esta el estudio  en estado listo, ['pap']['id_estado'] no estara definido por lo tanto no entra al if
        if (Usuario::isPatologo() && isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] == 2) {
          if (!$this->validar($post)) {
              unset($post['Pap']['id_estado']);
              $model->load($post);
              return $this->render('_form', ['model' => $model, 'solicitud' => $model->solicitudpap, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
          }
          if(isset($post['Pap']['anulado']) && $post['Pap']['anulado']=="1"){
            unset($post['Pap']['id_estado']);
            $model->id_estado=6; //estado anulado
          }else {
            //fecha cuando esta listo el informe de la biopsia
            $model->fechalisto = date("Y-m-d  H:i:s");
            $model->id_usuario = Yii::$app->user->identity->getId();
          }
        }
        $transaction = Yii::$app->db->beginTransaction();

         try {
             if ($model->load($post) && $model->save()) {
                 if ($model->solicitudpap->id_estado !== $model->id_estado) {
                     $model->solicitudpap->id_estado = $model->id_estado;
                     $model->solicitudpap->scenario = 'update';
                     $model->solicitudpap->save();
                 }

                 if (!$model->vph && isset($model->vphEscaneado)) {
                     $model->vphEscaneado->baja_logica = true;
                     $model->vphEscaneado->save();
                 }

                 if ($model->vph && isset($model->vphEscaneado)) {
                     $transaction->commit();
                     return $this->redirect(['vph-escaneado/update', 'id' => $model->vphEscaneado->id]);
                 } elseif ($model->vph) {
                     $transaction->commit();
                     return $this->redirect(['vph-escaneado/create', 'id_pap' => $model->id]);
                 }

                 $transaction->commit();
                 return $this->redirect(['view', 'id' => $model->id]);
             } else {
                 $transaction->rollBack();
                 return $this->render('_form', ['model' => $model, 'solicitud' => $model->solicitudpap, 'search' => $search, 'array' => $array, 'provider' => $provider]);
             }
         } catch (\Exception $e) {
             $transaction->rollBack();
             throw $e;
         }
}
    /**
     * Delete an existing Pap model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model->estado->descripcion == 'LISTO') {
            return ['title' => "Eliminar informe Pap #" . $id, 'content' => "No se puede eliminar informe en estado listo", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $request = Yii::$app->request;
            $model->solicitudpap->id_estado=5;//Vuelve al estado PENDIENTE
            $model->solicitudpap->save();
            if (isset($model->vphEscaneado)) {
                $model->vphEscaneado->delete();
            }
            $this->findModel($id)->delete();
            if ($request->isAjax) {
                $transaction->commit();
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            else {
                $transaction->commit();
                return $this->redirect(['index']);
            }
          } catch (\Exception $e) {
             $transaction->rollBack();
             throw $e;
           } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
           }

    }

    public function actionAnioselect() {
        $request = Yii::$app->request;
        $id_estudio = Solicitudpap::find()
            ->select(['id_estudio'])
            ->scalar();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            // Cargar los años disponibles
            $aniosDisponibles = AnioProtocolo::aniosDisponibles();
            if (isset($_POST['seleccion'])) {
              // recibo datos de lo seleccionado, reconstruyo columnas
              $seleccionAnios = $_POST['seleccion'];
              ConfiguracionAniosUsuario::deleteAll(["id_usuario"=> Yii::$app->user->id,"id_estudio"=>$id_estudio]);
            foreach ($seleccionAnios as $anio) {
                $modelConfAnio= new ConfiguracionAniosUsuario();
                $modelConfAnio->id_anio_protocolo = $anio;
                $modelConfAnio->id_usuario= Yii::$app->user->id;
                $modelConfAnio->id_estudio=$id_estudio;
                $modelConfAnio->save();
            }
            return [$modelConfAnio, 'forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
          }else {
            // Obtener los años seleccionados por el usuario
              $id_usuario = Yii::$app->user->id;
              $aniosSeleccionados = ConfiguracionAniosUsuario::getSeleccionAnios($id_usuario, $id_estudio);
                  return ['success' => true,
                  'message' => 'Configuración de años guardada correctamente.',
                   'title' => "Configuración personalizada",
                   'content' => $this->renderAjax('/../components/Vistas/_anioselect',
                    ['aniosDisponibles' => $aniosDisponibles,
                    'aniosSeleccionados'=>$aniosSeleccionados]) ,
                   'footer' => Html::button('Cancelar',
                   ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                   . Html::button('Guardar', ['class' => 'btn btn-primary',
                   'type' => "submit"]) ];
          }
        } else {
            $this->redirect("index");
        }
    }
    public function actionInforme($id) {
        $request = Yii::$app->request;
        $pap = $this->findModel($id);
        return $this->render('informePatologia', ['model' => $pap ]);
    }
    /**
     * Finds the Pap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Pap::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
