<?php
namespace app\controllers;
use Yii;
use app\models\Rol;
use app\models\RolSearch;
use app\models\Modulo;
use app\models\ModuloSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\PermisoSearch;
use app\models\Permiso;
use app\models\AccionSearch;
use app\models\Accion;
use app\components\Metodos\Metodos;
/**
 * RolController implements the CRUD actions for Rol model.
 */
class RolController extends Controller {
    /**
     * Lists all Rol models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RolSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Rol model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Rol #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new Rol model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Rol();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nuevo Rol", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Crear nuevo Rol", 'content' => '<span class="text-success">Create Rol success</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Crear más', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nuevo Rol", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
     * Updates an existing Rol model.
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
            if ($model->id == 1) {
                return ['title' => "Actualizar Rol #" . $id, 'content' => "El rol administrador no se puede actualizar", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
            if ($model->id == 4) {
                return ['title' => "Actualizar Rol #" . $id, 'content' => "El rol patologo no se puede actualizar", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
            if ($request->isGet) {
                return ['title' => "Actualizar Rol #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Rol #" . $id, 'content' => $this->renderAjax('view', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Actualizar Rol #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
        }
    }
    /**
     * Delete an existing Rol model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        if ($id == 1) {
            return ['title' => "Eliminar Rol #" . $id, 'content' => "El rol administrador no se puede eliminar", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        if ($id == 4) {
            return ['title' => "Eliminar Rol #" . $id, 'content' => "El rol patologo no se puede eliminar", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        if (Permiso::find()->where(['id_rol'=>$id])->count()>0 ){
            return ['title' => "Eliminar rol #" . $id, 'content' => 'No se puede eliminar la rol porque esta asociado a uno o más permisos', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
          }
        $this->findModel($id)->delete();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'success' => 'reloadDetalle(' . $id_maestro . ')'];
        }
        else {
            /*
             *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }
    public function actionCreatedetalle() {
        // Verifico si es el POST de createdetalle con la seleccion
        if (isset($_POST['keylist']) and isset($_POST['id_maestro'])) {
            $lerror = false;
            $id_maestro = $_POST['id_maestro'];
            foreach ($_POST['keylist'] as $value) {
                if ($modelPermiso = new Permiso()) {
                    $modelPermiso->id_rol = $id_maestro;
                    $modelPermiso->id_modulo = $value;
                    if (!$modelPermiso->save()) {
                        $lerror = true;
                        break;
                    }
                }
                else {
                    $lerror = true;
                    break;
                }
            }
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($lerror) {
                return ['status' => 'error'];
            }
            return ['status' => 'success'];
            Yii::$app->end();
        }
        $modelDetalle = new Modulo();
        $searchModel = new ModuloSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $columnas = Metodos::obtenerColumnas($modelDetalle);
        // Respuesta para el GET de filter y sort
        if (isset($_GET['_pjax'])) {
            return $this->renderAjax('_createDetalle', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, 'id_maestro' => $_GET['id_maestro']]);
        }
        else {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => 'Agregar Modulo', 'content' => $this->renderAjax('_createDetalle', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, 'id_maestro' => $_GET['id_maestro'], ]) , ];
        }
    }
    public function actionDeletedetalle($id_detalle, $id_maestro) {
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        try {
            if ($modelpermiso = Permiso::findOne($id_detalle)) {
                // borro registro en este caso por que es una relacion NN
                if ($modelpermiso->delete())
                // return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
                return ['forceClose' => true, 'success' => 'reloadDetalle(' . $id_maestro . ')'];
            }
        }
        catch(yii\db\Exception $e) {
            return ['forceClose' => false, 'title' => '<p style="color:red">ERROR</p>', 'content' => '<div style=" font-size: 14px">Errores en la operacion indicada. Verifique.</div>', 'success' => 'reloadDetalle(' . $id_maestro . ')'];
        }
    }
    public function actionAddaccion() {
        // Verifico si es el POST de createdetalle con la seleccion
        if (isset($_POST['keylist']) and isset($_POST['id_permiso'])) {
            $lerror = false;
            // $id_permiso = $_POST['id_permiso'];
            $request = Yii::$app->request;
            if ($model = new Permiso()) {
                $modelPermiso = $model::findOne($_POST['id_permiso']);
                $modelPermiso->id_accion = $_POST['keylist'];
                if (!$modelPermiso->save()) {
                    $lerror = true;
                }
            }
            else {
                $lerror = true;
            }
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($lerror) {
                return ['status' => 'error'];
            } //el maestro es el rol
            return ['status' => 'success', 'id_maestro' => $modelPermiso->id_rol];
            Yii::$app->end();
        }
        $modelDetalle = new Accion();
        $searchModel = new AccionSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $columnas = Metodos::obtenerColumnas($modelDetalle);
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        return ['title' => 'Agregar Accion', 'content' => $this->renderAjax('_addaccion', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, 'id_permiso' => $_GET['id_permiso'],
        //  'id_maestro' => $_GET['id_maestro'],
        ]) , ];
    }
    /**
     * Delete multiple existing Rol model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionListdetalle() {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = new PermisoSearch();
            $dataProvider = $searchModel->search(Yii::$app
                ->request
                ->queryParams);
            $dataProvider
                ->query
                ->where(['id_rol' => $_POST['expandRowKey']]);
            $dataProvider->setPagination(false);
            $dataProvider->setSort(false);
            return $this->renderPartial('_listDetalle', ['id_maestro' => $_POST['expandRowKey'], 'searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
        }
        else {
            return '<div>No se encontraron resultados</div>';
        }
    }

    /**
     * Finds the Rol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Rol::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
