<?php

namespace app\controllers;

use Yii;
use app\models\Plantillamaterial;
use app\models\PlantillamaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;
use yii\filters\AccessControl;
use app\components\Seguridad\Seguridad;
use yii\helpers\Json;

/**
 * PlantillamaterialController implements the CRUD actions for Plantillamaterial model.
 */
class PlantillamaterialController extends Controller
{


    /**
     * Lists all Plantillamaterial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model= new Plantillamaterial();

        $searchModel = new PlantillamaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=7;
        // $columnas=Metodos::obtenerColumnas($model);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'columns' => $columnas,
              ]);
    }
    public function actionPlantillamb()
    {
      $this->layout = 'main3';

        $model= new Plantillamaterial();

        $searchModel = new PlantillamaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=7;
        // $columnas=Metodos::obtenerColumnas($model);

        return $this->render('plantillamb', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columnas,
              ]);
    }


    /**
     * Displays a single Plantillamaterial model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            //Yii::$app->session->setFlash('error', 'Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.');
            return [

                    'title'=> "Plantilla material #".$id,
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

    /**
     * Creates a new Plantillamaterial model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Plantillamaterial();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nueva Plantilla material",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Crear nueva Plantilla material",
                    'content'=>'<span class="text-success">Create Plantillamaterial success</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear más',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Crear nueva Plantilla material",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Plantillamaterial model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar Plantilla material #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Plantilla material #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Actualizar Plantilla material #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Plantillamaterial model.
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
     * Delete multiple existing Plantillamaterial model.
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

    /**
     * Finds the Plantillamaterial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plantillamaterial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plantillamaterial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Personalizar vista del grid por usuario. model VISTA.
     * For ajax request will return json object
     * and for non-ajax request process la vistat
     * @param model $seleccion
     * @return mixed
     */
    public function actionSelect()
    {
        $request = Yii::$app->request;
        $model = new Plantillamaterial();
        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;

            if(isset($_POST['seleccion'])){
                // recibo datos de lo seleccionado, reconstruyo columnas
                $seleccion=$_POST['seleccion'];

                $columnAdmin=$model->attributeColumns();
                $columnSearch=[];
                $columnas=[];
                foreach($columnAdmin as $value){
                    $columnSearch[]=$value['attribute'];
                }

                foreach($seleccion as $key) {
                    $indice=array_search($key, $columnSearch);
                    if ($indice!==null){
                        $columnas[]=$columnAdmin[$indice];
                    }
                }

                // guardo esa informacion, sin controles ni excepciones, no es importante
                $vista = \app\models\Vista::findOne(['id_usuario'=>Yii::$app->user->id,'modelo'=>$model->classname()]);

                if($vista==null){
                    $vista = new \app\models\Vista();
                    $vista->id_usuario=Yii::$app->user->id;
                    $vista->modelo=$model->classname();
                }
                $vista->columna=serialize($columnas);
                 $vista->save();

                return [$vista,'forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];

            }

            // columnas mostradas actualmente
            $columnas=Metodos::obtenerColumnas($model);
            // attributos de las columnas mostradas
            $seleccion=Metodos::obtenerAttributosColumnas($columnas);
            // todas las etiquetas
            $etiquetas=Metodos::obtenerEtiquetasColumnas($model,$seleccion);

            return [
                'title'=> "Personalizar Lista",
                'content'=>$this->renderAjax('/../components/Vistas/_select', [
                    'seleccion' => $seleccion,
                    'etiquetas' => $etiquetas,
                ]),
                'footer'=> Html::button('Cancelar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
            ];

        }else{
            // Process for non-ajax request
            return $this->redirect(['index']);
        }
    }

}
