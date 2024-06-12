<?php
namespace app\controllers;
use Yii;
use app\models\Firma;
use app\models\FirmaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Usuario;
use app\models\UsuarioSearch;
use app\models\Biopsia;
use app\models\Pap;
use yii\web\UploadedFile;
use yii\imagine\Image;
use app\components\Metodos\Metodos;
/**
 * FirmaController implements the CRUD actions for Firma model.
 */
class FirmaController extends Controller {
  // behaviors heredado

    /**
     * Lists all Firma models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new FirmaSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Firma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Firma #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }

    //Parametros pasados por referencia
    private function guadarImagen(&$model,&$image){
      $ext = explode(".", $image->name);
      $ext = end($ext);
      Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/firmas/';
      $nombreEncriptadoImagen = Yii::$app->security->generateRandomString() . ".{$ext}";
      $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
      $model->imagen = $nombreEncriptadoImagen;

      $image->saveAs($path);
      // Redimensionamiento de la imagen (opcional)
      Image::thumbnail(Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen, 120, 120)
          ->save(Yii::$app->params['uploadPath'] . 'lg_' . $nombreEncriptadoImagen, ['quality' => 100]);
      Image::thumbnail(Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen, 30, 30)
          ->save(Yii::$app->params['uploadPath'] . 'sm_' . $nombreEncriptadoImagen, ['quality' => 100]);
    }

    /**
     * Creates a new Firma model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Firma();
        $modelUsu = new Usuario();
        $searchModelUsu = new UsuarioSearch();
        $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
        $dataProviderUsu->pagination->pageSize = 7;

        if ($this->request->isPost && $model->load($request->post())) {
            $image = UploadedFile::getInstance($model, 'imagen');
            // Manejar la subida de la imagen si está presente
            if (!is_null($image) && $image !== "") {
                $this->guadarImagen($model, $image);
            }
            if ($model->save()) {
                if (!is_null($image) && $image !== "") {
                    if ($model->save()) {
                      $this->setearMensajeExito('Datos guardados correctamente');
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('create', ['searchModelUsu' => $searchModelUsu, 'dataProviderUsu' => $dataProviderUsu, 'model' => $model, 'imagen' => $image, ]);
            }
        }
        else {
            return $this->render('create', ['searchModelUsu' => $searchModelUsu, 'dataProviderUsu' => $dataProviderUsu, 'model' => $model, 'imagen' => null]);
        }
    }
    /**
     * Updates an existing Firma model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $modelUsu = new Usuario();
        $searchModelUsu = new UsuarioSearch();
        $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
        $dataProviderUsu->pagination->pageSize = 7;

        if ($this->request->isPost && $model->load($request->post()) ) {
          $modelbiopsia = Biopsia::find()->where(['and', 'biopsia.id_usuario = ' . $this->findModel($id)->id_usuario])->one();
          $modelpap = Pap::find()->where(['and', 'pap.id_usuario = ' . $model->id_usuario])->one();
          if (isset($modelbiopsia) || isset($modelpap)) {
              $this->setearMensajeError('No se puede modificar la firma porque esta asociada a estudios');
              return $this->redirect(['update', "id"=>$id]); // Redirigir a la misma página después de guardar con éxito
          }
            $image = UploadedFile::getInstance($model, 'imagen');
            // Manejar la subida de la imagen si está presente
            if (!is_null($image) && $image !== "") {
                $this->guadarImagen($model, $image);
              }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('update', ['searchModelUsu' => $searchModelUsu, 'dataProviderUsu' => $dataProviderUsu, 'model' => $model, 'imagen' => $image, ]);
            }
        }
        else {
            return $this->render('update', ['searchModelUsu' => $searchModelUsu, 'dataProviderUsu' => $dataProviderUsu, 'model' => $model, ]);
        }
    }
    /**
     * Delete an existing Firma model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        $modelbiopsia = Biopsia::find()->where(['and', 'biopsia.id_usuario = ' . $this->findModel($id)->id_usuario])->one();
        $modelpap = Pap::find()->where(['and', 'pap.id_usuario = ' . $this->findModel($id)->id_usuario])->one();
        if (isset($modelbiopsia) || isset($modelpap)) {
            return ['title' => "Eliminar firma  #" . $id, 'content' => "No se puede eliminar la firma porque esta asociada a estudios", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        if ($request->isAjax) {
          $this->findModel($id)->delete();

            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        }
        else {
            return $this->redirect(['index']);
        }
    }
    /**
     * Finds the Firma model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Firma the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Firma::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
