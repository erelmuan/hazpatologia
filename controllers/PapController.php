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
use app\components\helpers\Metodos;
use app\components\behaviors\AuditoriaBehaviors;
use app\models\Auditoria;
/**
 * PapController implements the CRUD actions for Pap model.
 */
class PapController extends AppController {
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



    private function procesarVph(Pap $model)
    {
        if (!$model->vph && $model->vphEscaneado) {
            $model->inmunohistoquimicaescaneado->baja_logica = true;
            $model->inmunohistoquimicaescaneado->save(false);
        }

        if ($model->vph) {
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
    /**
     * Creates a new Pap model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $request = Yii::$app->request;
         $post      = $request->post();
         $solicitud = Solicitudpap::findOne($request->get('idsol'));
         if (!$solicitud) {
             throw new \yii\web\NotFoundHttpException('Solicitud no encontrada.');
         }
         $papExistente = Pap::find()
           ->where(['id_solicitudpap' => $solicitud->id])
           ->one();

       if ($papExistente !== null) {
           return $this->redirect([
             'view',
             'id' => $papExistente->id,
             ]);
       }
         $model = new Pap();
         $estructura = $this->cargarEstructuras($solicitud->id_estudio);
         if ($model->load($post)) {
             // Asociación segura desde el servidor
             $model->id_solicitudpap = $solicitud->id;
             // Si quiere quedar LISTO, validamos contraseña
             if (!$this->comprobarEstado($model, $post)) {
                 return $this->renderForm($model, $estructura, $solicitud);
             }
             $transaction = Yii::$app->db->beginTransaction();
             try {
                 if ($model->save()) {
                     $solicitud->cambiarEstado((int)$model->id_estado);
                     $respuesta = $this->procesarVph($model);
                     $transaction->commit();
                     if ($respuesta !== null) {
                         return $respuesta;
                     }
                     return $this->redirect(['view', 'id' => $model->id]);
                 }
                 $transaction->rollBack();
                 return $this->renderForm($model, $estructura, $solicitud);
             } catch (\Throwable $e) {
                 $transaction->rollBack();
                 throw $e;
             }
         }
         return $this->renderForm($model, $estructura, $solicitud);
     }


     private function comprobarEstado(Pap $model, array $post): bool
     {
         if (!$model->estaListo() && !$model->estaAnulado()) {
             return true;
         }
         $contrasenia = trim((string)($post['contrasenia'] ?? ''));
         if ($contrasenia === '') {
             $this->setearMensajeError('EN ESTADO LISTO O ANULADO, DEBE ESCRIBIR LA CONTRASEÑA');
             return false;
         }
         $usuario = Yii::$app->user->identity;
         if (!$usuario->validarContrasenia($contrasenia)) {
             $this->setearMensajeError('CONTRASEÑA INCORRECTA');
             return false;
         }

         return true;
     }
    /**
     * Updates an existing Pap model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */


    /**
     * Updates an existing Pap model.
     */
     public function actionUpdate($id)
   {
       $request = Yii::$app->request;
       $post = $request->post();
       $model = $this->findModel($id);
       $estructura = $this->cargarEstructuras(
           $model->solicitudpap->id_estudio
       );
       if ($model->load($post)) {
           if (!$this->comprobarEstado($model, $post)) {
               return $this->renderForm(
                   $model,
                   $estructura,
                   $model->solicitudpap
               );
           }
           $transaction = Yii::$app->db->beginTransaction();
           try {
               if ($model->save()) {
                   if ( $model->solicitudpap->id_estado !== (int)$model->id_estado ) {
                       $model->solicitudpap->cambiarEstado($model->id_estado);
                   }
                   $respuesta = $this->procesarVph($model);
                   $transaction->commit();
                   if ($respuesta !== null) {
                       return $respuesta;
                   }
                   return $this->redirect(['view','id' => $model->id ]);
               }
               $transaction->rollBack();
               return $this->renderForm(
                   $model,
                   $estructura,
                   $model->solicitudpap
               );
           } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
           }
       }

       return $this->renderForm(
           $model,
           $estructura,
           $model->solicitudpap
       );
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
