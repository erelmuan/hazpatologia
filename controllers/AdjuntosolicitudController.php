<?php

namespace app\controllers;

use Yii;
use app\models\Adjuntosolicitud;
use app\models\AdjuntosolicitudSearch;
use app\models\Solicitud;
use app\models\patronState\EstadoBase;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * AdjuntosolicitudController implements the CRUD actions for Adjuntosolicitud model.
 */
class AdjuntosolicitudController extends Controller
{
  // behaviors heredado


    /**
     * Lists all Adjuntosolicitud models.
     * @return mixed
     */
    public function actionIndex($id_solicitud)
    {
        $model = new Adjuntosolicitud();
        $model->id_solicitud = $id_solicitud;
        $model->baja_logica = false;
        $dataProvider = new ActiveDataProvider([
            'query' => Adjuntosolicitud::find()->where(['id_solicitud' => $id_solicitud]),
            'pagination' => ['pageSize' => 10],
        ]);
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'id_solicitud' => $id_solicitud,
        ]);

    }


    /**
     * Displays a single Adjuntosolicitud model.
     * @param integer $id
     * @return mixed
     */
     public function actionViewFiles($id_solicitud)
      {
          $request = Yii::$app->request;
          if($request->isAjax){
              Yii::$app->response->format = Response::FORMAT_JSON;
              $dataProvider = new ActiveDataProvider([
                  'query' => Adjuntosolicitud::find()->where(['id_solicitud' => $id_solicitud, 'baja_logica' => false]),
                  'pagination' => [
                      'pageSize' => 10,
                  ],
              ]);

              return [
                      'title'=> "Adjuntos de la solicitud",
                      'content'=>$this->renderAjax('view-files', [
                          // 'model' => $this->findModel($id),
                          'dataProvider' => $dataProvider,

                      ]),
                      'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                  ];

            }
      }
      public function actionView($id)
      		   {
      		       $request = Yii::$app->request;
      		       if($request->isAjax){
      		           Yii::$app->response->format = Response::FORMAT_JSON;
      		           return [
      		                   'title'=> "AdjuntosSolicitud #".$id,
      		                   'content'=>$this->renderAjax('view', [
      		                       'model' => $this->findModel($id),
      		                   ]),
      		                   'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
      		                           Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
      		               ];
      		       }else{
      		           return $this->render('view', [
      		               'model' => $this->findModel($id),
      		           ]);
      		       }
      		   }

    private function guardarDocumento($model,$solicitud){
      $file = UploadedFile::getInstance($model, 'nombre_archivo');
      $ext = (explode(".", $file->name));
      $ext = end($ext);
      if ($file) {
        if ($solicitud->id_estado==EstadoBase::DERIVADO || $solicitud->id_estado==EstadoBase::DERIVADO_LISTO ){
          $directorio = Yii::getAlias('@webroot/uploads/adjuntos/derivados/');
        }elseif ($solicitud->id_estado==EstadoBase::NO_REALIZADO || $solicitud->id_estado==EstadoBase::DERIVADO_NO_REALIZADO){
          $directorio = Yii::getAlias('@webroot/uploads/adjuntos/no-realizados/') ;
        }
        $model->nombre_archivo = $file->name;

        // Verificar si el archivo ya existe en la carpeta
        if (file_exists($directorio.$model->nombre_asignado)) {
            $i = 1;
            while (file_exists($directorio.$model->nombre_asignado."(".$i .")" )) {
                $i++;
            }
            $resguardo =  $model->nombre_asignado ."(".$i .")" ;
            // Renombrar el archivo, rename (nombre_actual, nombre nuevo)
            rename($directorio. $model->nombre_asignado,$directorio.$resguardo);
        }

        $file->saveAs($directorio. $model->nombre_asignado.".{$ext}");
      }

    }
    private function actualizarDocumento($model,$nombre_asignadoAnterior){
      if ($model->nombre_asignado !== $nombre_asignadoAnterior) {
              $solicitud= Solicitud::findOne($model->id_solicitud);
              $ext = pathinfo($model->nombre_archivo, PATHINFO_EXTENSION);
              if ($solicitud->id_estado==EstadoBase::DERIVADO || $solicitud->id_estado==EstadoBase::DERIVADO_LISTO ){
                $rutaBase = Yii::getAlias('@webroot/uploads/adjuntos/derivados/');
              }elseif ($solicitud->id_estado==EstadoBase::NO_REALIZADO || $solicitud->id_estado==EstadoBase::DERIVADO_NO_REALIZADO ){
                $rutaBase = Yii::getAlias('@webroot/uploads/adjuntos/no-realizados/') ;
              }
              $archivoAnterior = $rutaBase . $nombre_asignadoAnterior . '.' . $ext;
              $archivoNuevo    = $rutaBase . $model->nombre_asignado . '.' . $ext;
              if (file_exists($archivoAnterior)) {
                  rename($archivoAnterior, $archivoNuevo);
              }
          }
    }

    /**
     * Creates a new AdjuntosSolicitud model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate($id_solicitud)
     {
         $model = new Adjuntosolicitud();
         $model->id_solicitud = $id_solicitud;
         $solicitud= Solicitud::findOne($id_solicitud);
         $model->baja_logica = false;
         $dataProvider = new ActiveDataProvider([
             'query' => Adjuntosolicitud::find()->where(['id_solicitud' => $id_solicitud]),
             'pagination' => ['pageSize' => 10],
         ]);

         if ($model->load(Yii::$app->request->post())) {
            $this->guardarDocumento($model,$solicitud);
             if ($model->save()) {
               $this->setearMensajeExito('Archivo cargado exitosamente.');
             }
             return $this->redirect(['index' ,'id_solicitud'=>$id_solicitud]);

         }

     }


    /**
     * Updates an existing Adjuntosolicitud model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => Adjuntosolicitud::find()->where(['id_solicitud' => $model->id_solicitud]),
            'pagination' => ['pageSize' => 10],
        ]);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $nombre_asignadoAnterior = $model->getOldAttribute('nombre_asignado');
            if($request->isGet){
                return [
                    'title'=> "Actualizar Adjunto solicitud #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                    $this->actualizarDocumento($model,$nombre_asignadoAnterior);
                  return ['forceReload' => '#crud-datatable-pjax', 'title' => "Archivo adjunto #" .
                  $id, 'content' => $this->renderAjax('view',
                  ['model' => $model,]) ,
                  'footer' => Html::button('Cerrar',
                  ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                   .Html::a('Editar', ['update', 'id' => $id],
                    ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];

            }else{
                 return [
                    'title'=> "Actualizar Adjuntos Solicitud #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    /**
     * Delete an existing Adjuntosolicitud model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $id_solicitud=$this->findModel($id)->id_solicitud;
        $solicitud= Solicitud::findOne($id_solicitud);


        if($request->isAjax){
            if($solicitud->id_estado==EstadoBase::DERIVADO_LISTO){
              $mensaje= 'No se puede eliminar el archivo adjunto en estado DERIVADO LISTO';
            }else {
              $mensaje= 'El registro se eliminó correctamente';
              $this->findModel($id)->delete();
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            $this->setearMensajeExito($mensaje);

            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
          if($solicitud->id_estado==EstadoBase::DERIVADO_LISTO){
            $this->setearMensajeError('No se puede eliminar el archivo adjunto en estado DERIVADO LISTO');

          }else {
            $this->setearMensajeExito('El registro se eliminó correctamente');

            $this->findModel($id)->delete();
          }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return $this->redirect(['index' ,'id_solicitud'=>$id_solicitud]);
        }


    }

     /**
     * Delete multiple existing Adjuntosolicitud model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

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


    public function actionDescargar($id) {
        $model = $this->findModel($id);
        $solicitud= Solicitud::findOne($model->id_solicitud);
        if ($solicitud->id_estado==EstadoBase::DERIVADO || $solicitud->id_estado==EstadoBase::DERIVADO_LISTO ){
          $carpeta = 'derivados/';
        }elseif ($solicitud->id_estado==EstadoBase::NO_REALIZADO || $solicitud->id_estado==EstadoBase::DERIVADO_NO_REALIZADO  ){
          $carpeta = 'no-realizados/';
        }
        $ext = pathinfo($model->nombre_archivo, PATHINFO_EXTENSION);
        $filePath = Yii::getAlias("@webroot/uploads/adjuntos/{$carpeta}{$model->nombre_asignado}.{$ext}");
        $fileUrl = Yii::getAlias("@web/uploads/adjuntos/{$carpeta}{$model->nombre_asignado}.{$ext}");

        if (file_exists($filePath)) {
            // Si el archivo existe, se accede al mismo.
              return Yii::$app->response->sendFile($filePath, $model->nombre_asignado.".{$ext}", ['inline' => true]);
        } else {
            $this->setearMensajeError('EL ARCHIVO NO EXISTE O HA SIDO MOVIDO.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    /**
     * Finds the AdjuntosSolicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adjuntosolicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adjuntosolicitud::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
