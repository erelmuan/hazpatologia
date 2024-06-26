<?php
namespace app\controllers;
use Yii;
use app\models\AnioProtocolo;
use app\models\AnioProtocoloSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Solicitud;
use app\models\ConfiguracionAniosUsuario;


/**
 * AnioProtocoloController implements the CRUD actions for AnioProtocolo model.
 */
class AnioProtocoloController extends Controller {
  // behaviors heredado

    /**
     * Lists all AnioProtocolo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AnioProtocoloSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single AnioProtocolo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "AnioProtocolo #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new AnioProtocolo model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new AnioProtocolo();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nuevo Protocolo Año", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Crear nuevo Protocolo Año", 'content' => '<span class="text-success">Éxito al crear anioprotocolo</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Crear más', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nuevo Protocolo Año", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
        }
        else {
            /*
             *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('create', ['model' => $model, ]);
            }
        }
    }
    public function validar($valor_enviado, $model) {
        if ($valor_enviado["activo"] == false && $model->activo == true) {
            $this->setearMensajeError('NO SE PUEDE DESELECCIONAR DIRECTAMENTE EL ACTIVO, DEBE SELECCIONAR ACTIVO OTRO AÑO ');
            return false;
        }
        if ($valor_enviado["activo"] == true && $model->activo == false) {
            $model->actualizarEstado();
        }
        return true;
        //si tiene solicitudes no se podra modificar el año

    }
    /**
     * Updates an existing AnioProtocolo model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($this->request->isPost) {
            //Si no se valida entonces mostrar $mensaje
            if (!$this->validar($_POST["AnioProtocolo"], $model)) {
                return $this->render('update', ['model' => $model, ]);
            }
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else {
            return $this->render('update', ['model' => $model, ]);
        }
    }
    /**
     * Delete an existing AnioProtocolo model.
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
         if (Solicitud::getSolicitudesAnio($model->anio)) {
            $this->setearMensajeError('No se puede eliminar porque hay solicitudes ese año.');
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax' ,'metodo'=>'delete'];

         }
         if (ConfiguracionAniosUsuario::find()->where(['id_anio_protocolo'=>$id])->count()>0 ){
           $this->setearMensajeError('No se puede eliminar porque hay configuraciones de usuario con ese año.');
           return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax' ,'metodo'=>'delete'];
       }
          $this->findModel($id)->delete();
          return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];

      }else {
        return $this->redirect(['index']);
       }
    }

    /**
     * Finds the AnioProtocolo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnioProtocolo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AnioProtocolo::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
