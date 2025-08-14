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
use app\models\patronState\EstadoBase;
use app\models\patronState\EstadoFactory;
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
            return $this->render('view', ['model' => $this->findModel($id)]);
        }
    }
    private function cargarEstructuras(int $id_estudio): array
    {
        $result = [];
        $modelos = [
            'Flora'       => PlantillafloraSearch::class,
            'Aspecto'     => PlantillaaspectoSearch::class,
            'Glandular'   => PlantillaglandularSearch::class,
            'Pavimentosa' => PlantillapavimentosaSearch::class,
            'Diagnostico' => PlantilladiagnosticoSearch::class,
            'Frase'       => PlantillafraseSearch::class,
            'Cie'         => Cie10Search::class,
        ];
        foreach ($modelos as $key => $searchClass) {
            $searchModel = new $searchClass();
            if (in_array($key, ['Diagnostico', 'Frase'])) {
                $array = $searchModel::find()->where(['id_estudio' => $id_estudio])->all();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id_estudio);
            } else {
                $array = $searchModel::find()->all();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            }
            $dataProvider->pagination->pageSize = 7;
            $result['search']["searchModel{$key}"] = $searchModel;
            $result['array']["array" . strtolower($key)] = $array;
            $result['provider']["dataProvider{$key}"] = $dataProvider;
        }

        return $result;
    }

    private function validar($post) {
        if (Yii::$app->user->identity->contrasenia <> md5($post['contrasenia'])) {
          $this->setearMensajeError('CONTRASEÑA INCORRECTA');
            return false;
        }
        if ($post['Pap']['firmado'] !== "1") {
          $this->setearMensajeError('EN ESTADO LISTO, DEBE POSEER LA FIRMA');
        }
        else {
            return true;
        }
    }
    /**
     * Elimina el flag 'firmado' si el estado no es 2.
     */
    private function prepararEstado(array &$post)
    {
        if (isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] != EstadoBase::LISTO) {
            unset($post['Pap']['firmado']);
        }
    }

    /**
     * Valida y ajusta el estado antes de cargar el modelo.
     */
    private function aplicarFirma(array &$post, $model)
    {
        if (Usuario::esPatologo() && isset($post['Pap']['id_estado'])
         && $post['Pap']['id_estado'] == EstadoBase::LISTO) {
            if (!$this->validar($post)) {
                unset($post['Pap']['id_estado']);
                return false;
            }
                $post['Pap']['fechalisto'] = date('Y-m-d H:i:s');
                $post['Pap']['id_usuario']  = Yii::$app->user->identity->getId();
        }
          return true;
    }

    /**
     * Sincroniza estado de solicitud y maneja escaneados VPH.
     */
    private function actualizarRelaciones($model, $transaction)
    {
        if (!$model->vph && $model->vphEscaneado) {
            $model->vphEscaneado->baja_logica = true;
            $model->vphEscaneado->save(false);
        }

        if ($model->vph) {
            $transaction->commit();
            if ($model->vphEscaneado) {
                return $this->redirect([
                    'vph-escaneado/update',
                    'id' => $model->vphEscaneado->id
                ]);
            }
            return $this->redirect([
                'vph-escaneado/create',
                'id_pap' => $model->id
            ]);
        }

        return null;
    }

      private function renderForm($model, $estructura,$solicitud)
    {
        $stateOptions = \app\models\patronState\EstadoFactory::getAvailableTransitions(
            $model->id_estado,
            Yii::$app->user->identity,
            $model
        );
        $viewData = array_merge(
            ['model'          => $model,
            'solicitud'          => $solicitud,
            'stateOptions'   => $stateOptions,],
            $estructura
        );
        return $this->render('_form', $viewData);
    }

    /**
     * Creates a new Pap model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $request    = Yii::$app->request;
         $model      = new Pap();
         $solicitud  = Solicitudpap::findOne($_GET['idsol']);
         // Cargamos estructuras de plantillas para el estudio
         $estructura   = $this->cargarEstructuras($solicitud->id_estudio);
         $post       = $request->post();
         // Reutilizamos lógica de firma y estado
         $this->prepararEstado($post);
         if(!$this->aplicarFirma($post, $model)){
           $model->load($post);
           return $this->renderForm($model, $estructura,$solicitud);
         };
         $transaction = Yii::$app->db->beginTransaction();
         try {
             if ($model->load($post) && $model->save()) {
               // Sincronizamos estado de solicitud
               if ($solicitud->id_estado !== $model->id_estado) {
                   $solicitud->cambiarEstado($model->id_estado);
               }
                 // Manejamos VPH vía actualizarRelaciones
                 $resultado = $this->actualizarRelaciones($model, $transaction);
                 if ($resultado !== null) {
                     return $resultado;
                 }
                 $transaction->commit();
                 return $this->redirect(['view', 'id' => $model->id]);
             } else {
                 $transaction->rollBack();
                 return $this->renderForm($model, $estructura,$solicitud);
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

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model   = $this->findModel($id);
        $post = $request->post();
        $solicitud = $model->solicitudpap;
        // Cargamos estructuras de plantillas para el estudio
        $estructura = $this->cargarEstructuras($model->solicitudpap->id_estudio);
        // Reutilizamos lógica de firma y estado
        $this->prepararEstado($post);
        if(!$this->aplicarFirma($post, $model)){
          $model->load($post);
          return $this->renderForm($model, $estructura,$model->solicitudpap);
        };
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load($post) && $model->save()) {
              // Sincronizamos estado de solicitud
                if ($model->solicitudpap->id_estado !== $model->id_estado) {
                    $model->solicitudpap->cambiarEstado($model->id_estado);
                }
                $resultado = $this->actualizarRelaciones($model, $transaction);
                if ($resultado !== null) {
                    return $resultado;
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
                return $this->renderForm($model, $estructura, $solicitud);
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
      $request = Yii::$app->request;
      if ($request->isAjax) {
        if ($model->estado->id == EstadoBase::LISTO) {
          $this->setearMensajeError("No se puede eliminar informe en estado listo.");
          return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
        }
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->solicitudpap->cambiarEstado(EstadoBase::PENDIENTE);//Vuelve al estado PENDIENTE
            if (isset($model->vphEscaneado)) {
                $model->vphEscaneado->delete();
            }
            $this->findModel($id)->delete();
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
         }
         else {
             return $this->redirect(['index']);
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
