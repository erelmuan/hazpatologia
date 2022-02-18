<?php
namespace app\controllers;
use Yii;
use app\models\Firma;
use app\models\Auditoria;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Usuariorol;
use app\models\UsuariorolSearch;
use app\models\RolSearch;
use app\models\Rol;
use app\components\Metodos\Metodos;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\imagine\Image;
/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller {
    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $request = Yii::$app->request;
        if ($request->isAjax) { // modal para cambiar contraseña
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            $model = Usuariorol::findOne(['id_usuario' => Yii::$app
                ->user
                ->identity->id, 'id_rol' => 1, //id rol admin
            ]);
            if ($model == null) {
                return ['title' => "Cambiar contraseña #", 'content' => "No puede cambiar una contraseña si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
            $model = $this->findModel($_GET['id']);
            if ($dato = $request->post()) {
                $model->pass_new = $dato['Usuario']['pass_new'];
                try {
                    // cambiar solo contraseña
                    $model->contrasenia = md5($model->pass_new);
                    if ($model->save()) {
                        $content = '<span class="text-success">Contraseña cambiada correctamente</span>';
                        return ['title' => "Cambiar Contraseña", 'content' => $content, ];
                    }
                    else {
                        $content = '<span class="text-success">Recuerde que tiene que estar activo</span>';
                        return ['title' => "Cambiar Contraseña", 'content' => $content, ];
                    }
                }
                catch(yii\db\Exception $e) {
                    Yii::$app
                        ->response->format = Response::FORMAT_HTML;
                    throw new NotFoundHttpException('Error en la base de datos.', 500);
                }
            }
            return ['title' => "Resetear Contraseña", 'content' => $this->renderAjax('_contraseniaReset', ['model' => $model, ]) , 'footer' => Html::button('Cancelar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
        }
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Usuario #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Usuario();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nuevo Usuario", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Crear nuevo Usuario", 'content' => '<span class="text-success">Create Usuario success</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Crear más', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nuevo Usuario", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
     * Updates an existing Usuario model.
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
            $modeluser = Usuariorol::findOne(['id_usuario' => Yii::$app
                ->user
                ->identity->id, 'id_rol' => 1, //id rol admin
            ]);
            if ($modeluser == null) {
                return ['title' => "Cambiar contraseña #", 'content' => "No puede editar si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
            if ($request->isGet) {
                return ['title' => "Actualizar Usuario #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Usuario #" . $id, 'content' => $this->renderAjax('view', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Actualizar Usuario #" . $id, 'content' => $this->renderAjax('update', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
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
     * Delete an existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        if (Yii::$app
            ->user
            ->identity->id == $id) {
            return ['title' => "Eliminar Rol #" . $id, 'content' => "No puede eliminarse a si mismo", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        $model = Usuariorol::findOne(['id_usuario' => Yii::$app
            ->user
            ->identity->id, 'id_rol' => 1, //id rol admin
        ]);
        if ($model == null) {
            return ['title' => "Eliminar Rol #" . $id, 'content' => "No puede eliminar usuario si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        $request = Yii::$app->request;

        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Firma::find()->where(['id_usuario'=>$id])->count()>0 ){
            return ['title' => "Eliminar usuario #" . $id, 'content' =>'No se puede eliminar el usuario porque esta asociado a una firma', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
          }
          if (Auditoria::find()->where(['id_usuario'=>$id])->count()>0 ){
              return ['title' => "Eliminar usuario #" . $id, 'content' =>'No se puede eliminar el usuario porque esta asociado a una o más auditorias', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
        $this->findModel($id)->delete();
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
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
     * Delete multiple existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete() {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }
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
    public function actionListdetalle() {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = new UsuariorolSearch();
            $dataProvider = $searchModel->search(Yii::$app
                ->request
                ->queryParams);
            $dataProvider
                ->query
                ->where(['id_usuario' => $_POST['expandRowKey']]);
            $dataProvider->setPagination(false);
            $dataProvider->setSort(false);
            return $this->renderPartial('_listDetalle', ['id_maestro' => $_POST['expandRowKey'], 'searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
        }
        else {
            return '<div>No se encontraron resultados</div>';
        }
    }
    public function actionAddrol() {
        if (isset($_POST['keylist']) and isset($_POST['id_usuario'])) {
            $lerror = false;
            $id_usuario = $_POST['id_usuario'];
            foreach ($_POST['keylist'] as $value) {
                if ($modelUsuarioRol = new Usuariorol()) {
                    $modelUsuarioRol->id_usuario = $id_usuario;
                    $modelUsuarioRol->id_rol = $value;
                    if (!$modelUsuarioRol->save()) {
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
        $modelDetalle = new Rol();
        $searchModel = new RolSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $columnas = Metodos::obtenerColumnas($modelDetalle);
        // Respuesta para el GET de filter y sort
        // if (isset($_GET['_pjax'])) {
        //
        //     return $this->renderAjax('_addrol', [
        //         'searchModel' => $searchModel,
        //         'dataProvider' => $dataProvider,
        //         'columns' => $columnas,
        //         'id_maestro' => $_GET['id_maestro']
        //     ]);
        //
        // } else {
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        return ['title' => 'Agregar Rol', 'content' => $this->renderAjax('_addrol', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, 'id_usuario' => $_GET['id_maestro'], ]) , ];
        //
        // }

    }
    public function actionDeletedetalle($id_detalle, $id_maestro) {
        //detalle=usuariorol
        //maestro =usuario
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        if (Yii::$app
            ->user
            ->identity->id == $id_maestro) {
            return ['title' => "Eliminar Rol #" . $id_maestro, 'content' => "No puede eliminarse el rol usted mismo", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        $model = Usuariorol::findOne(['id_usuario' => Yii::$app
            ->user
            ->identity->id, 'id_rol' => 1, //id rol admin
        ]);
        if ($model == null) {
            return ['title' => "Eliminar Rol #" . $id, 'content' => "No puede eliminar un rol si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        try {
            if ($modelUsuarioRol = Usuariorol::findOne($id_detalle)) {
                // borro registro en este caso por que es una relacion NN
                if ($modelUsuarioRol->delete()) return ['forceClose' => true, 'success' => 'reloadDetalle(' . $id_maestro . ')'];
            }
        }
        catch(yii\db\Exception $e) {
            return ['forceClose' => false, 'title' => '<p style="color:red">ERROR</p>', 'content' => '<div style=" font-size: 14px">Errores en la operacion indicada. Verifique.</div>', 'success' => 'reloadDetalle(' . $id_maestro . ')'];
        }
    }
    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPerfil() {
        $request = Yii::$app->request;
        $id = Yii::$app
            ->user
            ->identity
            ->getId();
        $model = $this->findModel($id);
        if ($request->isAjax) { // modal para cambiar contraseña
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($dato = $request->post()) {
                $model->pass_ctrl = $dato['Usuario']['pass_ctrl'];
                $model->pass_new = $dato['Usuario']['pass_new'];
                $model->pass_new_check = $dato['Usuario']['pass_new_check'];
                if ($model->pass_new <> $model->pass_new_check) {
                    $model->addError('pass_new', 'La contraseña ingresada no coincide.');
                    $model->addError('pass_new_check', 'La contraseña ingresada no coincide.');
                }
                else {
                    if (md5($model->pass_ctrl) <> $model->contrasenia) {
                        $model->addError('pass_ctrl', 'La contraseña ingresada no es correcta.');
                    }
                    else {
                        try {
                            // cambiar solo contraseña
                            $model->contrasenia = md5($model->pass_new);
                            if ($model->save()) {
                                $content = '<span class="text-success">Contraseña cambiada correctamente</span>';
                                return ['title' => "Cambiar Contraseña", 'content' => $content, ];
                            }
                        }
                        catch(yii\db\Exception $e) {
                            Yii::$app
                                ->response->format = Response::FORMAT_HTML;
                            throw new NotFoundHttpException('Error en la base de datos.', 500);
                        }
                    }
                }
            }
            return ['title' => "Cambiar Contraseña", 'content' => $this->renderAjax('_contrasenia', ['model' => $model, ]) , 'footer' => Html::button('Cancelar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
        }
        else {
            if (!$request->post()) {
                return $this->render('perfil', ['model' => $model, ]);
            }
            $post = $request->post();
            $image = UploadedFile::getInstance($model, 'imagen');
            // unset($post[s'Usuario']['imagen']);
            if ($model->load($post) && $model->save()) {
                if (!is_null($image) && $image !== "") {
                    // save with image
                    // store the source file name
                    //  $model->imagen = $image->name;
                    $ext = (explode(".", $image->name));
                    $ext = end($ext);
                    // generate a unique file name to prevent duplicate filenames
                    //  $model->avatar = Yii::$app->security->generateRandomString().".{$ext}";
                    // the path to save file, you can set an uploadPath
                    // in Yii::$app->params (as used in example below)
                    Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/avatar/';
                    $nombreEncriptadoImagen = Yii::$app
                        ->security
                        ->generateRandomString() . ".{$ext}";
                    // $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
                    $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
                    $model->id = Yii::$app
                        ->user
                        ->getId();
                    $model->imagen = $nombreEncriptadoImagen;
                    $image->saveAs($path);
                    //Redimensionar
                    Image::thumbnail(Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen, 120, 120)->save(Yii::$app->params['uploadPath'] . 'sqr_' . $nombreEncriptadoImagen, ['quality' => 100]);
                    Image::thumbnail(Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen, 30, 30)->save(Yii::$app->params['uploadPath'] . 'sm_' . $nombreEncriptadoImagen, ['quality' => 100]);
                    if ($model->save()) {
                        Yii::$app->getSession()
                            ->setFlash('success', ['type' => 'success', 'duration' => 5000, 'icon' => 'fa fa-success', 'message' => "Datos guardados correctamente", 'title' => 'NOTIFICACIÓN', 'positonY' => 'top', 'positonX' => 'right']);
                    }
                }
                return $this->refresh();
            }
            return $this->render('perfil', ['model' => $model, ]);
        }
    }
}
