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
use yii\web\UploadedFile;
use yii\imagine\Image;
use app\components\Metodos\Metodos;


/**
 * FirmaController implements the CRUD actions for Firma model.
 */
class FirmaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Firma models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FirmaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Firma model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Firma #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Firma model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Firma();
        $modelUsu= new Usuario();
        $searchModelUsu = new UsuarioSearch();
        $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
        $dataProviderUsu->pagination->pageSize=7;
            /*
            *   Process for non-ajax request
            */
            if($this->request->isPost ){
                $post=$request->post();
                //verificar porque hay que agregar el indice [0] a diferencia cuando se sube una imagen de perfil
                $image = UploadedFile::getInstances($model, 'imagen')[0];
                unset($post['Firma']['imagen']);

                if ($model->load($request->post()) && $model->save()) {

                  if (!is_null($image) && $image !=="") {

                          // save with image
                           // store the source file name
                         //  $model->imagen = $image->name;
                          $ext = (explode(".", $image->name));
                          $ext= end($ext);
                          // generate a unique file name to prevent duplicate filenames
                         //  $model->avatar = Yii::$app->security->generateRandomString().".{$ext}";
                          // the path to save file, you can set an uploadPath
                          // in Yii::$app->params (as used in example below)
                          Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/avatar/';
                          $nombreEncriptadoImagen=Yii::$app->security->generateRandomString().".{$ext}";
                         // $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
                          $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
                          // $model->id = Yii::$app->user->getId();
                          $model->imagen= $nombreEncriptadoImagen;
                            $image->saveAs($path);
                            //Redimensionar
                            Image::thumbnail(Yii::$app->params['uploadPath'].$nombreEncriptadoImagen, 120, 120)
                            ->save(Yii::$app->params['uploadPath'].'sqr_'.$nombreEncriptadoImagen, ['quality' => 100]);
                            Image::thumbnail(Yii::$app->params['uploadPath'].$nombreEncriptadoImagen, 30, 30)
                                   ->save(Yii::$app->params['uploadPath'].'sm_'.$nombreEncriptadoImagen, ['quality' => 100]);

                         if ($model->save()) {
                           Yii::$app->getSession()->setFlash('success', [
                               'type' => 'success',
                               'duration' => 5000,
                               'icon' => 'fa fa-success',
                               'message' => "Datos guardados correctamente",
                               'title' => 'NOTIFICACIÓN',
                               'positonY' => 'top',
                               'positonX' => 'right'
                           ]);

                         }

                     }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else {
                     return $this->render('create', [
                       'searchModelUsu' => $searchModelUsu,
                       'dataProviderUsu' => $dataProviderUsu,
                         'model' => $model,
                         'imagen'=> $image,
                     ]);
                 }

           }else {
                return $this->render('create', [
                  'searchModelUsu' => $searchModelUsu,
                  'dataProviderUsu' => $dataProviderUsu,
                    'model' => $model,
                    'imagen'=> null
                ]);
            }

    }

    /**
     * Updates an existing Firma model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelUsu= new Usuario();
        $searchModelUsu = new UsuarioSearch();
        $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
        $dataProviderUsu->pagination->pageSize=7;
            /*
            *   Process for non-ajax request
            */
            if($this->request->isPost ){
                $post=$request->post();
                //verificar porque hay que agregar el indice [0] a diferencia cuando se sube una imagen de perfil
                $image = UploadedFile::getInstances($model, 'imagen')[0];
                unset($post['Firma']['imagen']);

                if ($model->load($request->post()) && $model->save()) {

                  if (!is_null($image) && $image !=="") {

                          // save with image
                           // store the source file name
                         //  $model->imagen = $image->name;
                          $ext = (explode(".", $image->name));
                          $ext= end($ext);
                          // generate a unique file name to prevent duplicate filenames
                         //  $model->avatar = Yii::$app->security->generateRandomString().".{$ext}";
                          // the path to save file, you can set an uploadPath
                          // in Yii::$app->params (as used in example below)
                          Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/avatar/';
                          $nombreEncriptadoImagen=Yii::$app->security->generateRandomString().".{$ext}";
                         // $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
                          $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
                          // $model->id = Yii::$app->user->getId();
                          $model->imagen= $nombreEncriptadoImagen;
                            $image->saveAs($path);
                            //Redimensionar
                            Image::thumbnail(Yii::$app->params['uploadPath'].$nombreEncriptadoImagen, 120, 120)
                            ->save(Yii::$app->params['uploadPath'].'sqr_'.$nombreEncriptadoImagen, ['quality' => 100]);
                            Image::thumbnail(Yii::$app->params['uploadPath'].$nombreEncriptadoImagen, 30, 30)
                                   ->save(Yii::$app->params['uploadPath'].'sm_'.$nombreEncriptadoImagen, ['quality' => 100]);

                         if ($model->save()) {
                           Yii::$app->getSession()->setFlash('success', [
                               'type' => 'success',
                               'duration' => 5000,
                               'icon' => 'fa fa-success',
                               'message' => "Datos guardados correctamente",
                               'title' => 'NOTIFICACIÓN',
                               'positonY' => 'top',
                               'positonX' => 'right'
                           ]);

                         }

                     }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else {
                     return $this->render('update', [
                       'searchModelUsu' => $searchModelUsu,
                       'dataProviderUsu' => $dataProviderUsu,
                         'model' => $model,
                         'imagen'=> $image,
                     ]);
                 }

           } else {
                return $this->render('update', [
                  'searchModelUsu' => $searchModelUsu,
                  'dataProviderUsu' => $dataProviderUsu,
                    'model' => $model,
                ]);
            }
    }

    /**
     * Delete an existing Firma model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
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
    protected function findModel($id)
    {
        if (($model = Firma::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
