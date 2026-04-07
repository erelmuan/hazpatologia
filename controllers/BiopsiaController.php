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
use app\models\patronState\EstadoBase;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\helpers\Metodos;
use app\components\behaviors\AuditoriaBehaviors;
use yii\filters\AccessControl;
use app\components\Seguridad\Seguridad;
/**
 * BiopsiaController implements the CRUD actions for Biopsia model.
 */
class BiopsiaController extends AppController {
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

    public function validar($post) {

        if ($post['Biopsia']['firmado'] !== "1") {
          $this->setearMensajeError('EN ESTADO LISTO, DEBE POSEER LA FIRMA');
          return false;
        }
        if(empty($post['contrasenia'])){
          $this->setearMensajeError("EN ESTADO LISTO, DEBE ESCRIBIR LA CONTRASEÑA");
          return false;
        }
      if (!Yii::$app->security->validatePassword($post['contrasenia'], Yii::$app->user->identity->contrasenia)) {
          $this->setearMensajeError('CONTRASEÑA INCORRECTA');
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Creates a new Biopsia model.
     */
    public function actionCreate()
    {
        $request  = Yii::$app->request;
        $model = new Biopsia();
        $solicitud = Solicitudbiopsia::findOne($request->get('idsol'));
        // Cargamos estructuras de plantillas para el estudio
        $estructura  = $this->cargarEstructuras($solicitud->id_estudio);
        $post = $request->post();
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
                // Manejamos IHQ vía actualizarRelaciones
                $resultado = $this->actualizarRelaciones($model, $transaction);
                if ($resultado !== null) {
                    return $resultado;
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $transaction->rollBack();
            // Usamos renderForm para create
            return $this->renderForm($model,$estructura,$solicitud);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Updates an existing Biopsia model.
     */
    public function actionUpdate($id)
    {
        $request   = Yii::$app->request;
        $model     = $this->findModel($id);
        $post      = $request->post();
        // Cargamos estructuras de plantillas para el estudio
        $estructura = $this->cargarEstructuras($model->solicitudbiopsia->id_estudio);
        // Reutilizamos lógica de firma y estado
        $this->prepararEstado($post);
        if(!$this->aplicarFirma($post, $model)){
          $model->load($post);
          return $this->renderForm($model, $estructura,$model->solicitudbiopsia);
        };
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load($post) && $model->save()) {
              // Sincronizamos estado de solicitud
                if ($model->solicitudbiopsia->id_estado !== $model->id_estado) {
                    $model->solicitudbiopsia->cambiarEstado($model->id_estado);
                }
                $resultado = $this->actualizarRelaciones($model, $transaction);
                if ($resultado !== null) {
                    return $resultado;
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $transaction->rollBack();
            // Usamos renderForm para update (adaptado para que reutilizarla en la func create- se agrego el campo solicitud)
            return $this->renderForm($model, $estructura,$model->solicitudbiopsia);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Elimina el flag 'firmado' si el estado no es 2.
     */
    private function prepararEstado(array &$post)
    {
        if (isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] != EstadoBase::LISTO) {
            unset($post['Biopsia']['firmado']);
        }
    }

    /**
     * Valida y ajusta el estado antes de cargar el modelo.
     */
    private function aplicarFirma(array &$post, $model)
    {
        if (Usuario::esPatologo() && isset($post['Biopsia']['id_estado'])
         && $post['Biopsia']['id_estado'] == EstadoBase::LISTO) {
            if (!$this->validar($post)) {
                unset($post['Biopsia']['id_estado']);
                return false;
            }
                $post['Biopsia']['fechalisto'] = date('Y-m-d H:i:s');
                $post['Biopsia']['id_usuario']  = Yii::$app->user->identity->getId();
        }
          return true;
    }

    /**
     * Sincroniza estado de solicitud y maneja escaneados IHQ.
     */
    private function actualizarRelaciones($model, $transaction)
    {
        if (!$model->ihq && $model->inmunohistoquimicaEscaneada) {
            $model->inmunohistoquimicaEscaneada->baja_logica = true;
            $model->inmunohistoquimicaEscaneada->save(false);
        }

        if ($model->ihq) {
            $transaction->commit();
            if ($model->inmunohistoquimicaEscaneada) {
                return $this->redirect([
                    'inmunohistoquimica-escaneada/update',
                    'id' => $model->inmunohistoquimicaEscaneada->id
                ]);
            }
            return $this->redirect([
                'inmunohistoquimica-escaneada/create',
                'id_biopsia' => $model->id
            ]);
        }

        return null;
    }

    /**
     * Renderiza el formulario con datos y estructuras necesarias.
     */
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
      * Carga las estructuras de plantillas según el estudio
      */
      private function cargarEstructuras( $id_estudio)
      {
          $result = [];
          $modelos = [
              'Material'  => PlantillamaterialSearch::class,
              'Macroscopia'  => PlantillamacroscopiaSearch::class,
              'Microscopia'  => PlantillamicroscopiaSearch::class,
              'Diagnostico' => PlantilladiagnosticoSearch::class,
              'Frase'  => PlantillafraseSearch::class,
          ];
          foreach ($modelos as $key => $searchClass) {
              $searchModel = new $searchClass();
              // Solo Diagnóstico y Frase tienen filtro por id_estudio
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
            if ($model->estado->id == EstadoBase::LISTO) {
                $this->setearMensajeError("No se puede eliminar informe en estado listo.");
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->solicitudbiopsia->cambiarEstado(EstadoBase::PENDIENTE);//Vuelve al estado PENDIENTE
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
        $path = $this->actionInforme($id);
        Yii::$app->mailer->compose()->attachContent($path, ['fileName' => 'Invoice #sdas.pdf', 'contentType' => 'application/pdf']);
    }

}
