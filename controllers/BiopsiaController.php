<?php
namespace app\controllers;
use Yii;
use app\models\Biopsia;
use app\models\AnioProtocolo;
use app\models\ConfiguracionAniosUsuario;
use app\models\BiopsiaSearch;
use app\models\PlantillamaterialSearch;
use app\models\PlantillamacroscopiaSearch;
use app\models\PlantillamicroscopiaSearch;
use app\models\PlantilladiagnosticoSearch;
use app\models\PlantillafraseSearch;
use app\models\Cie10Search;
use app\models\Biopsiacie10;
use app\models\Usuario;
use app\models\Inmunostoquimica;
use app\models\Solicitudbiopsia;
use app\models\CarnetOs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;
use app\components\behaviors\AuditoriaBehaviors;
use yii\filters\AccessControl;
use app\components\Seguridad\Seguridad;
/**
 * BiopsiaController implements the CRUD actions for Biopsia model.
 */
class BiopsiaController extends Controller {
  // behaviors heredado

    /**
     * Lists all Biopsia models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new Biopsia();
        $searchModel = new BiopsiaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }
    /**
     * Displays a single Biopsia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        $biopsia = $this->findModel($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['title' => "Biopsia #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id)  ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id)  ]);
        }
    }
    public function cargarEstructuras(&$search, &$array, &$provider, $id_estudio) {
        //Tendrian que acceder a los modelos por medio de sus controller!!!
        ////////////Material/////////////////
        $searchModelMat = new PlantillamaterialSearch();
        $arraymaterial = $searchModelMat::find()->all();
        $dataProviderMat = $searchModelMat->search(Yii::$app->request->queryParams);
        $dataProviderMat->pagination->pageSize = 7;
        $search['searchModelMat'] = $searchModelMat;
        $array['arraymaterial'] = $arraymaterial;
        $provider['dataProviderMat'] = $dataProviderMat;
        ////////////Macroscopia/////////////////
        $searchModelMac = new PlantillamacroscopiaSearch();
        $arraymacroscopia = $searchModelMac::find()->all();
        $dataProviderMac = $searchModelMac->search(Yii::$app->request->queryParams);
        $dataProviderMac->pagination->pageSize = 7;
        $search['searchModelMac'] = $searchModelMac;
        $array['arraymacroscopia'] = $arraymacroscopia;
        $provider['dataProviderMac'] = $dataProviderMac;
        ////////////Microscopia/////////////////
        $searchModelMic = new PlantillamicroscopiaSearch();
        $arraymicroscopia = $searchModelMic::find()->all();
        $dataProviderMic = $searchModelMic->search(Yii::$app->request->queryParams);
        $dataProviderMic->pagination->pageSize = 7;
        $search['searchModelMic'] = $searchModelMic;
        $array['arraymicroscopia'] = $arraymicroscopia;
        $provider['dataProviderMic'] = $dataProviderMic;
        ////////////Diagnostico/////////////////
        $searchModelDiag = new PlantilladiagnosticoSearch();
        //id_estudio=2 es del estudio biopsia
        $arraydiagnostico = $searchModelDiag::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderDiag = $searchModelDiag->search(Yii::$app->request->queryParams, $id_estudio);
        $dataProviderDiag->pagination->pageSize = 7;
        $search['searchModelDiag'] = $searchModelDiag;
        $array['arraydiagnostico'] = $arraydiagnostico;
        $provider['dataProviderDiag'] = $dataProviderDiag;
        ////////////Frase/////////////////
        $searchModelFra = new PlantillafraseSearch();
        //id_estudio=2 es del estudio biopsia
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
          $this->setearMensajeError('CONTRASEÑA INCORRECTA');
            return false;
        }
        if ($post['Biopsia']['firmado'] !== "1") {
          $this->setearMensajeError('EN ESTADO LISTO, DEBE POSEER LA FIRMA');
        }
        else {
            return true;
        }
    }
    public function saveBiopsiacie10($id_cie10,$id_biopsia){
        $biopsiacie10= new Biopsiacie10();
        $biopsiacie10->id_cie10= ($id_cie10==null)?1:$id_cie10 ;
        $biopsiacie10->verificado= false;
        $biopsiacie10->id_usuario=Yii::$app->user->identity->getId();
        $biopsiacie10->id_estudio=2;
        $biopsiacie10->id_biopsia=$id_biopsia;
        $biopsiacie10->save();
    }
    /**
     * Creates a new Biopsia model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Biopsia();
        $solicitud = Solicitudbiopsia::findOne($_GET['idsol']);
        $search = [];  $array = [];  $provider = [];
        $this->cargarEstructuras($search, $array, $provider, $solicitud->id_estudio);
        if (isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] != 2) {
            unset($post['Biopsia']['firmado']);
        }
        if (Usuario::isPatologo() && isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] == 2) {
            if (!$this->validar($post)) {
                unset($post['Biopsia']['id_estado']);
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
                    if ($model->fechalisto != null) {
                        // Creacion de biopsiacie10
                        // $this->saveBiopsiacie10($post['Biopsia']['id_cie10'], $model->id);
                    }
                    if ($model->ihq) {
                        $transaction->commit();
                        return $this->redirect(['inmunohistoquimica-escaneada/create', 'id_biopsia' => $model->id]);
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                    return $this->render('_form', ['model' => $model, 'search' => $search, 'array' => $array, 'provider' => $provider, 'solicitud' => $solicitud]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
    }




    /**
     * Updates an existing Biopsia model.
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
        $search = [];  $array = [];  $provider = [];
        $this->cargarEstructuras($search, $array, $provider, $model->solicitudbiopsia->estudio->id);
        if (isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] != 2) {
            unset($post['Biopsia']['firmado']);
        }
        //si esta el estudio  en estado listo, ['Biopsia']['id_estado'] no estara definido por lo tanto no entra al if
        if (Usuario::isPatologo() && isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] == 2) {
            if (!$this->validar($post)) {
                unset($post['Biopsia']['id_estado']);
                $model->load($post);
                return $this->render('_form', ['model' => $model, 'solicitud' => $model->solicitudbiopsia, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
            }
            if(isset($post['Biopsia']['anulado']) && $post['Biopsia']['anulado']=="1"){
              unset($post['Biopsia']['id_estado']);
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
                  if ($model->solicitudbiopsia->id_estado !== $model->id_estado) {
                      $model->solicitudbiopsia->id_estado = $model->id_estado;
                      $model->solicitudbiopsia->scenario = 'update';
                      $model->solicitudbiopsia->save();
                  }
                  if (!$model->ihq && isset($model->inmunohistoquimicaEscaneada)) {
                      $model->inmunohistoquimicaEscaneada->baja_logica=true;
                      $model->inmunohistoquimicaEscaneada->save();
                  }
                  if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)) {
                      $transaction->commit();
                      return $this->redirect(['inmunohistoquimica-escaneada/update', 'id' => $model->inmunohistoquimicaEscaneada->id]);
                  }
                  elseif ($model->ihq) {
                      $transaction->commit();
                      return $this->redirect(['inmunohistoquimica-escaneada/create', 'id_biopsia' => $model->id]);
                  }
                  $transaction->commit();
                  return $this->redirect(['view', 'id' => $model->id]);
              }
              else {
                  $transaction->rollBack();
                  return $this->render('_form', ['model' => $model, 'solicitud' =>$model->solicitudbiopsia, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
              }
          } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
    }
    /**
     * Delete an existing Biopsia model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {

            if ($model->estado->descripcion == 'LISTO') {
                $this->setearMensajeError("No se puede eliminar informe en estado listo.");
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
            }
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $model->solicitudbiopsia->id_estado=5;//Vuelve al estado PENDIENTE
                $model->solicitudbiopsia->save();
                if (isset($model->inmunohistoquimicaEscaneada)) {
                    $model->inmunohistoquimicaEscaneada->delete();
                }
                $model->delete();
                if ($request->isAjax) {
                    $transaction->commit();
                    $this->setearMensajeExito('El registro se eliminó correctamente');
                    return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
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
        }else {
          return $this->redirect(['index']);
         }
    }
    /**
     * Finds the Biopsia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Biopsia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Biopsia::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionInforme($id) {
        $request = Yii::$app->request;
        $biopsia = $this->findModel($id);
        return $this->render('informePatologia', ['model' => $biopsia ]);
    }

    public function actionEnviarcorreo($id) {
        // $mpdf=new mPDF();
        // $mpdf->WriteHTML($this->renderPartial('pdf',['model' => $model])); //pdf is a name of view file responsible for this pdf document
        // $path = $mpdf->Output('', 'S');
        $path = $this->actionInforme($id);
        Yii::$app->mailer->compose()->attachContent($path, ['fileName' => 'Invoice #sdas.pdf', 'contentType' => 'application/pdf']);
    }

}
