<?php
namespace app\controllers;
use Yii;
use app\models\Obrasocial;
use app\models\ObrasocialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
/**
 * ObrasocialController implements the CRUD actions for Obrasocial model.
 */
class ObrasocialController extends Controller {
    /**
     * Lists all Obrasocial models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ObrasocialSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Obrasocial model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Obrasocial #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new Obrasocial model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Obrasocial();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nueva obra social", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Crear nueva obra social", 'content' => '<span class="text-success">Create Obrasocial success</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nueva obra social", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
     * Updates an existing Obrasocial model.
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
                return ['title' => "Actualizar Obra social #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Obrasocial #" . $id, 'content' => $this->renderAjax('view', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Actualizar Obra social #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
     * Finds the Obrasocial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Obrasocial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Obrasocial::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function findModelall() {
        if (($model = Obrasocial::find()->all()) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
