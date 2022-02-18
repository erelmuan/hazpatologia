<?php
namespace app\controllers;
use Yii;
use app\models\Solicitud;
use app\models\Procedencia;
use app\models\ProcedenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
// use app\components\behaviors\AuditoriaBehaviors;

/**
 * ProcedenciaController implements the CRUD actions for Procedencia model.
 */
class ProcedenciaController extends Controller {
    /**
     * Lists all Procedencia models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProcedenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $dataProvider
            ->pagination->pageSize = 7;
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Procedencia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Procedencia #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new Procedencia model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Procedencia();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nueva Procedencia", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Crear nueva Procedencia", 'content' => '<span class="text-success">Create Procedencia success</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Crear más', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nueva Procedencia", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
    /**
     * Updates an existing Procedencia model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Actualizar Procedencia #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Procedencia #" . $id, 'content' => $this->renderAjax('view', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Actualizar Procedencia #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
                return $this->render('update', ['model' => $model, ]);
            }
        }
    }
    /**
     * Delete an existing Procedencia model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
          if (Solicitud::find()->where(['id_procedencia'=>$id])->count()>0 ){
            return ['title' => "Eliminar procedencia #" . $id, 'content' => 'No se puede eliminar la procedencia porque esta asociado a una o más solicitudes', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
          }
            $this->findModel($id)->delete();
            if ($request->isAjax) {
                /*
                 *   Process for ajax request
                */
                Yii::$app
                    ->response->format = Response::FORMAT_JSON;
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            else {
                /*
                 *   Process for non-ajax request
                */
                return $this->redirect(['index']);
            }
      }
    /**
     * Finds the Procedencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Procedencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Procedencia::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
