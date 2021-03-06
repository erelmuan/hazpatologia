<?php
namespace app\controllers;
use Yii;
use app\models\Biopsia;
use app\models\BiopsiaSearch;
use app\models\PlantillamaterialSearch;
use app\models\PlantillamacroscopiaSearch;
use app\models\PlantillamicroscopiaSearch;
use app\models\PlantilladiagnosticoSearch;
use app\models\PlantillafraseSearch;
use app\models\Usuario;
use app\models\Inmunostoquimica;
use app\models\Solicitudbiopsia;
use app\models\CarnetOs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;
use app\components\behaviors\AuditoriaBehaviors;
use yii\filters\AccessControl;
use app\components\Seguridad\Seguridad;
/**
 * BiopsiaController implements the CRUD actions for Biopsia model.
 */
class BiopsiaController extends Controller {
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
            return $this->render('viewV', ['model' => $this->findModel($id)  ]);
        }
    }
    public function cargarEstructuras(&$search, &$array, &$provider, $id_estudio) {
        //Tendrian que acceder a los modelos por medio de sus controller!!!
        ////////////Material/////////////////
        $searchModelMat = new PlantillamaterialSearch();
        $arraymaterial = $searchModelMat::find()->all();
        $dataProviderMat = $searchModelMat->search(Yii::$app->request->queryParams);
        $dataProviderMat->pagination->pageSize = 7;
        $search['searchModelMat'] = $searchModelMat;
        $array['arraymaterial'] = $arraymaterial;
        $provider['dataProviderMat'] = $dataProviderMat;
        ////////////Macroscopia/////////////////
        $searchModelMac = new PlantillamacroscopiaSearch();
        $arraymacroscopia = $searchModelMac::find()->all();
        $dataProviderMac = $searchModelMac->search(Yii::$app->request->queryParams);
        $dataProviderMac->pagination->pageSize = 7;
        $search['searchModelMac'] = $searchModelMac;
        $array['arraymacroscopia'] = $arraymacroscopia;
        $provider['dataProviderMac'] = $dataProviderMac;
        ////////////Microscopia/////////////////
        $searchModelMic = new PlantillamicroscopiaSearch();
        $arraymicroscopia = $searchModelMic::find()->all();
        $dataProviderMic = $searchModelMic->search(Yii::$app->request->queryParams);
        $dataProviderMic->pagination->pageSize = 7;
        $search['searchModelMic'] = $searchModelMic;
        $array['arraymicroscopia'] = $arraymicroscopia;
        $provider['dataProviderMic'] = $dataProviderMic;
        ////////////Diagnostico/////////////////
        $searchModelDiag = new PlantilladiagnosticoSearch();
        //id_estudio=2 es del estudio biopsia
        $arraydiagnostico = $searchModelDiag::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderDiag = $searchModelDiag->search(Yii::$app->request->queryParams, $id_estudio);
        $dataProviderDiag->pagination->pageSize = 7;
        $search['searchModelDiag'] = $searchModelDiag;
        $array['arraydiagnostico'] = $arraydiagnostico;
        $provider['dataProviderDiag'] = $dataProviderDiag;
        ////////////Frase/////////////////
        $searchModelFra = new PlantillafraseSearch();
        //id_estudio=2 es del estudio biopsia
        $arrayfrase = $searchModelFra::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderFra = $searchModelFra->search(Yii::$app->request->queryParams, $id_estudio);
        $dataProviderFra->pagination->pageSize = 7;
        $search['searchModelFra'] = $searchModelFra;
        $array['arrayfrase'] = $arrayfrase;
        $provider['dataProviderFra'] = $dataProviderFra;
    }
    public function validar($post) {
        if (Yii::$app->user->identity->password <> md5($post['contrasenia'])) {
            Yii::$app->getSession()->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "CONTRASE??A INCORRECTA", 'title' => 'NOTIFICACI??N', 'positonY' => 'top', 'positonX' => 'right']);
            return false;
        }
        if ($post['Biopsia']['firmado'] !== "1") {
            Yii::$app->getSession()->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "EN ESTADO LISTO, DEBE POSEER LA FIRMA", 'title' => 'NOTIFICACI??N', 'positonY' => 'top', 'positonX' => 'right']);
        }
        else {
            return true;
        }
    }
    /**
     * Creates a new Biopsia model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Biopsia();
        $Solicitud = Solicitudbiopsia::findOne($_GET['idsol']);
        $search = [];  $array = [];  $provider = [];
        $this->cargarEstructuras($search, $array, $provider, $Solicitud->id_estudio);
        if (isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] != 2) {
            unset($post['Biopsia']['firmado']);
        }
        if (Usuario::isPatologo() && isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] == 2) {
            if (!$this->validar($post)) {
                unset($post['Biopsia']['id_estado']);
                $model->load($post);
                return $this->render('_form', ['model' => $model, 'solicitud' => $Solicitud, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
            }
            $model->fechalisto = date("Y-m-d  H:i:s");
            $model->id_usuario = Yii::$app->user->identity->getId();
        }
        if ($model->load($post) && $model->save()) {
            // cambio de estados
            if ($Solicitud->id_estado !== $model->id_estado) {
                $Solicitud->id_estado = $model->id_estado;
                $Solicitud->save();
            }
            if ($model->ihq) {
                return $this->redirect(['inmunohistoquimica-escaneada/create', 'id_biopsia' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('_form', ['model' => $model, 'search' => $search, 'array' => $array, 'provider' => $provider, 'solicitud' => $Solicitud]);
        }
    }




    /**
     * Updates an existing Biopsia model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $post = $request->post();
        $search = [];  $array = [];  $provider = [];
        $this->cargarEstructuras($search, $array, $provider, $model->solicitudbiopsia->estudio->id);
        if (isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] != 2) {
            unset($post['Biopsia']['firmado']);
        }
        //si esta el estudio  en estado listo, ['Biopsia']['id_estado'] no estara definido por lo tanto no entra al if
        if (Usuario::isPatologo() && isset($post['Biopsia']['id_estado']) && $post['Biopsia']['id_estado'] == 2) {
            if (!$this->validar($post)) {
                unset($post['Biopsia']['id_estado']);
                $model->load($post);
                return $this->render('_form', ['model' => $model, 'solicitud' => $model->solicitudbiopsia, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
            }
            //fecha cuando esta listo el informe de la biopsia
            $model->fechalisto = date("Y-m-d  H:i:s");
            $model->id_usuario = Yii::$app->user->identity->getId();
        }
        if ($model->load($post) && $model->save()) {
          // cambio de estados
            if ($model->solicitudbiopsia->id_estado !== $model->id_estado) {
                $model->solicitudbiopsia->id_estado = $model->id_estado;
                $model->solicitudbiopsia->save();
            }
            if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)) {
                return $this->redirect(['inmunohistoquimica-escaneada/update', 'id' => $model->inmunohistoquimicaEscaneada->id]);
            }
            elseif ($model->ihq) {
                return $this->redirect(['inmunohistoquimica-escaneada/create', 'id_biopsia' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('_form', ['model' => $model, 'solicitud' =>$model->solicitudbiopsia, 'search' => $search, 'array' => $array, 'provider' => $provider ]);
        }
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
        if ($model->estado->descripcion == 'LISTO') {
            return ['title' => "Eliminar informe Biopsia #" . $id, 'content' => "No se puede eliminar informe en estado listo", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        $request = Yii::$app->request;
        $model->solicitudbiopsia->id_estado=5;//Vuelve al estado PENDIENTE
        $model->solicitudbiopsia->save();
        if (isset($model->inmunohistoquimicaEscaneada)) {
            $model->inmunohistoquimicaEscaneada->delete();
        }
        $model->delete();
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
    public function actionSelect() {
        $request = Yii::$app->request;
        $model = new Biopsia();
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if (isset($_POST['seleccion'])) {
                // recibo datos de lo seleccionado, reconstruyo columnas
                $seleccion = $_POST['seleccion'];
                $columnAdmin = $model->attributeColumns();
                $columnSearch = [];
                $columnas = [];
                foreach ($columnAdmin as $value) {
                    $columnSearch[] = $value['attribute'];
                }
                foreach ($seleccion as $key) {
                    $indice = array_search($key, $columnSearch);
                    if ($indice !== null) {
                        $columnas[] = $columnAdmin[$indice];
                    }
                }
                // guardo esa informacion, sin controles ni excepciones, no es importante
                $vista = \app\models\Vista::findOne(['id_usuario' => Yii::$app
                    ->user->id, 'modelo' => $model->classname() ]);
                if ($vista == null) {
                    $vista = new \app\models\Vista();
                    $vista->id_usuario = Yii::$app
                        ->user->id;
                    $vista->modelo = $model->classname();
                }
                $vista->columna = serialize($columnas);
                $vista->save();
                return [$vista, 'forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            // columnas mostradas actualmente
            $columnas = Metodos::obtenerColumnas($model);
            // attributos de las columnas mostradas
            $seleccion = Metodos::obtenerAttributosColumnas($columnas);
            // todas las etiquetas
            $etiquetas = Metodos::obtenerEtiquetasColumnas($model, $seleccion);
            return ['title' => "Personalizar Lista", 'content' => $this->renderAjax('/../components/Vistas/_select', ['seleccion' => $seleccion, 'etiquetas' => $etiquetas, ]) , 'footer' => Html::button('Cancelar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
        }
        else {
            // Process for non-ajax request
            return $this->redirect(['index']);
        }
    }
    public function actionInforme($id) {
        $request = Yii::$app->request;
        // Si entra en el if es porque el estudio esta en estado EN_PROCESO
        //Ver el view de biopsia donde se accde al informe
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceReload' => '#crud-datatable-pjax', 'title' => "AVISO!", 'content' => 'EL SIGUIENTE DOCUMENTO TIENE UN ESTADO <b>EN PROCESO</b> (NO ESTA VERIFICADO) CONFIRME SI DESEA GENERAR EL DOCUMENTO', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Confirmar', ['/biopsia/informe', 'id' => $id], ['class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'target' => '_blank', 'title' => 'Se abrir?? el archivo PDF generado en una nueva ventana']) ];
        }
        else {
            $biopsia = $this->findModel($id);
            return $this->render('informePatologia', ['model' => $biopsia ]);
        }
    }
    public function actionEnviarcorreo($id) {
        // $mpdf=new mPDF();
        // $mpdf->WriteHTML($this->renderPartial('pdf',['model' => $model])); //pdf is a name of view file responsible for this pdf document
        // $path = $mpdf->Output('', 'S');
        $path = $this->actionInforme($id);
        Yii::$app->mailer->compose()->attachContent($path, ['fileName' => 'Invoice #sdas.pdf', 'contentType' => 'application/pdf']);
    }

}
