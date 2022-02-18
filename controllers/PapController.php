<?php
namespace app\controllers;
use Yii;
use app\models\Pap;
use app\models\PapSearch;
use app\models\PlantillafloraSearch;
use app\models\PlantillaaspectoSearch;
use app\models\PlantillaglandularSearch;
use app\models\PlantillapavimentosaSearch;
use app\models\PlantilladiagnosticoSearch;
use app\models\PlantillafraseSearch;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Solicitudpap;
use app\components\Metodos\Metodos;
use app\components\behaviors\AuditoriaBehaviors;
use app\models\Auditoria;
/**
 * PapController implements the CRUD actions for Pap model.
 */
class PapController extends Controller {
    /**
     * Lists all Pap models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new Pap();
        $searchModel = new PapSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        $dataProvider
            ->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }
    /**
     * Displays a single Pap model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        $pap = $this->findModel($id);
        $edad = $this->calcular_edad($pap->id_solicitudpap);
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Pap #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , 'edad' => $edad, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('viewV', ['model' => $this->findModel($id) , 'edad' => $edad, ]);
        }
    }
    public function cargarEstructuras(&$search, &$array, &$provider, $id_estudio) {
        //Tendrian que acceder a los modelos por medio de sus controller!!!
        ////////////Flora/////////////////
        $searchModelFlora = new PlantillafloraSearch();
        $arrayflora = $searchModelFlora::find()->all();
        $dataProviderFlora = $searchModelFlora->search(Yii::$app
            ->request
            ->queryParams);
        $dataProviderFlora
            ->pagination->pageSize = 7;
        $search['searchModelFlora'] = $searchModelFlora;
        $array['arrayflora'] = $arrayflora;
        $provider['dataProviderFlora'] = $dataProviderFlora;
        ////////////Aspecto/////////////////
        $searchModelAsp = new PlantillaaspectoSearch();
        $arrayaspecto = $searchModelAsp::find()->all();
        $dataProviderAsp = $searchModelAsp->search(Yii::$app
            ->request
            ->queryParams);
        $dataProviderAsp
            ->pagination->pageSize = 7;
        $search['searchModelAsp'] = $searchModelAsp;
        $array['arrayaspecto'] = $arrayaspecto;
        $provider['dataProviderAsp'] = $dataProviderAsp;
        ////////////Glandular/////////////////
        $searchModelGland = new PlantillaglandularSearch();
        $arrayglandular = $searchModelGland::find()->all();
        $dataProviderGland = $searchModelGland->search(Yii::$app
            ->request
            ->queryParams);
        $dataProviderGland
            ->pagination->pageSize = 7;
        $search['searchModelGland'] = $searchModelGland;
        $array['arrayglandular'] = $arrayglandular;
        $provider['dataProviderGland'] = $dataProviderGland;
        ////////////Pavimentosas/////////////////
        $searchModelPav = new PlantillapavimentosaSearch();
        $arraypavimentosa = $searchModelPav::find()->all();
        $dataProviderPav = $searchModelPav->search(Yii::$app
            ->request
            ->queryParams);
        $dataProviderPav
            ->pagination->pageSize = 7;
        $search['searchModelPav'] = $searchModelPav;
        $array['arraypavimentosa'] = $arraypavimentosa;
        $provider['dataProviderPav'] = $dataProviderPav;
        ////////////Diagnostico/////////////////
        $searchModelDiag = new PlantilladiagnosticoSearch();
        //id_estudio=1 es del estudio de pap
        $arraydiagnostico = $searchModelDiag::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderDiag = $searchModelDiag->search(Yii::$app
            ->request->queryParams, $id_estudio);
        $dataProviderDiag
            ->pagination->pageSize = 7;
        $search['searchModelDiag'] = $searchModelDiag;
        $array['arraydiagnostico'] = $arraydiagnostico;
        $provider['dataProviderDiag'] = $dataProviderDiag;
        ////////////Frase/////////////////
        $searchModelFra = new PlantillafraseSearch();
        //id_estudio=1 es del estudio de pap
        $arrayfrase = $searchModelFra::find()->where(['id_estudio' => $id_estudio])->all();
        $dataProviderFra = $searchModelFra->search(Yii::$app
            ->request->queryParams, $id_estudio);
        $dataProviderFra
            ->pagination->pageSize = 7;
        $search['searchModelFra'] = $searchModelFra;
        $array['arrayfrase'] = $arrayfrase;
        $provider['dataProviderFra'] = $dataProviderFra;
    }
    /**
     * Creates a new Pap model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $post = $request->post();
        $modelUsuario = Usuario::find()->where(["id" => Yii::$app
            ->user
            ->identity
            ->getId() ])
            ->one();
        $model = new Pap();
        if (isset($_GET['idsol']) && $_GET['idsol'] != '') {
            $Solicitud = Solicitudpap::findOne($_GET['idsol']);
            $_SESSION['solicitudp'] = $Solicitud;
        }
        $search = [];
        $array = [];
        $provider = [];
        $this->cargarEstructuras($search, $array, $provider, $_SESSION['solicitudp']->id_estudio);
        if (isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] != 2) {
            unset($post['Pap']['firmado']);
        }
        if (Usuario::isPatologo() && isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] == 2) {
            //validar contraseñar
            $model->load($post);
            if ($post['Pap']['firmado'] !== "1") {
                $model->id_estado = 5;
                Yii::$app->getSession()
                    ->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "EN ESTADO LISTO, DEBE POSEER LA FIRMA", 'title' => 'NOTIFICACIÓN', 'positonY' => 'top', 'positonX' => 'right']);
                unset($post['Pap']['id_estado']);
                return $this->render('_form', ['model' => $model, 'dataSol' => $_SESSION['solicitudb'], 'search' => $search, 'array' => $array, 'provider' => $provider, 'edadDelPaciente' => Solicitudpap::calcular_edad($_SESSION['solicitudb']->id) , ]);
            }
            if (!$this->validarContraseña($_POST["contrasenia"])) {
                $model->id_estado = 5;
                return $this->render('_form', ['model' => $model, 'dataSol' => $_SESSION['solicitudp'], 'search' => $search, 'array' => $array, 'provider' => $provider, 'edadDelPaciente' => $this->calcular_edad($_SESSION['solicitudp']->id) , ]);
            }
            $model->fechalisto = date("Y-m-d h:i:s");
            $model->id_usuario = $modelUsuario->id;
            $Solicitud = Solicitudpap::findOne($model->id_solicitudpap);
            $Solicitud->id_estado = $model->id_estado;
            $Solicitud->save();
        }
        if ($model->load($post) && $model->save()) {
            // Estado EN PROCESO
            if ($model->id_estado == 1) {
                $Solicitud->id_estado = $model->id_estado;
                $Solicitud->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            $edad = $this->calcular_edad($_SESSION['solicitudp']->id);
            return $this->render('_form', ['search' => $search, 'array' => $array, 'provider' => $provider, 'model' => $model, 'dataSol' => $_SESSION['solicitudp'], 'edadDelPaciente' => $edad, ]);
        }
    }
    //la fecha tiene que estar en formato d-m-y
    function calcular_edad($id) {
        $Solicitud = Solicitudpap::findOne($id);
        list($ano, $mes, $dia) = explode("-", $Solicitud
            ->paciente
            ->fecha_nacimiento);
        list($anoR, $mesR, $diaR) = explode("-", $Solicitud->fechadeingreso);
        $ano_diferencia = $anoR - $ano;
        $mes_diferencia = $mesR - $mes;
        $dia_diferencia = $diaR - $dia;
        if ($mes_diferencia < 0) {
            $ano_diferencia--;
        }
        elseif ($mes_diferencia == 0) {
            if ($dia_diferencia < 0) $ano_diferencia--;
        }
        return $ano_diferencia;
    }
    public function validarContraseña($contrasenia) {
        $modelUsuario = Usuario::find()->where(["id" => Yii::$app
            ->user
            ->identity
            ->getId() ])
            ->one();
        if ($modelUsuario->contrasenia <> md5($contrasenia)) {
            Yii::$app->getSession()
                ->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "CONTRASEÑA INCORRECTA", 'title' => 'NOTIFICACIÓN', 'positonY' => 'top', 'positonX' => 'right']);
            return false;
        }
        else {
            return true;
        }
    }
    /**
     * Updates an existing Pap model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $post = $request->post();
        $search = [];
        $array = [];
        $provider = [];
        $modelUsuario = Usuario::find()->where(["id" => Yii::$app
            ->user
            ->identity
            ->getId() ])
            ->one();
        $this->cargarEstructuras($search, $array, $provider, $model
            ->solicitudpap
            ->id_estudio);
        //Se agrego la validacion !Usuario::isPatologo(), para que aunque se edite el html el diagnostico sea cambiado solo por el patologo
        if ($model->estado->descripcion == 'LISTO' && !Usuario::isPatologo()) {
            unset($post['Pap']['diagnostico']);
        }
        if (isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] != 2) {
            unset($post['Pap']['firmado']);
        }
        //si esta el estudio  en estado listo, ['pap']['id_estado'] no estara definido por lo tanto no entra al if
        if (Usuario::isPatologo() && isset($post['Pap']['id_estado']) && $post['Pap']['id_estado'] == 2) {
            if (!$this->validarContraseña($_POST["contrasenia"])) {
                unset($post['Pap']['id_estado']);
                $model->load($post);
                return $this->render('_form', ['model' => $model, 'dataSol' => $_SESSION['solicitudp'], 'search' => $search, 'array' => $array, 'provider' => $provider, 'edadDelPaciente' => $this->calcular_edad($_SESSION['solicitudp']->id) , ]);
            }
            if ($post['Pap']['firmado'] !== "1") {
                Yii::$app->getSession()
                    ->setFlash('warning', ['type' => 'danger', 'duration' => 5000, 'icon' => 'fa fa-warning', 'message' => "EN ESTADO LISTO, DEBE POSEER LA FIRMA", 'title' => 'NOTIFICACIÓN', 'positonY' => 'top', 'positonX' => 'right']);
                unset($post['Pap']['id_estado']);
                $model->load($post);
                return $this->render('_form', ['model' => $model, 'dataSol' => $_SESSION['solicitudp'], 'search' => $search, 'array' => $array, 'provider' => $provider, 'edadDelPaciente' => Solicitudpap::calcular_edad($_SESSION['solicitudp']->id) , ]);
            }
            $Solicitud = Solicitudpap::findOne($model->id_solicitudpap);
            //puede pasar a estado en proceso
            $Solicitud->id_estado = $post['Pap']['id_estado'];
            $Solicitud->save();
            //fecha cuando esta listo el informe de la pap
            $model->fechalisto = date("Y-m-d  h:i:s");
            $model->id_usuario = $modelUsuario->id;
        }
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            if (isset($_GET['idsol']) && $_GET['idsol'] != '') $Solicitud = Solicitudpap::findOne($_GET['idsol']);
            else $Solicitud = Solicitudpap::findOne($model->id_solicitudpap);
            $_SESSION['solicitudp'] = $Solicitud;
            $edad = $this->calcular_edad($_SESSION['solicitudp']->id);
            return $this->render('_form', ['model' => $model, 'dataSol' => $_SESSION['solicitudp'], 'search' => $search, 'array' => $array, 'provider' => $provider, 'edadDelPaciente' => $this->calcular_edad($_SESSION['solicitudp']->id) , ]);
        }
    }
    /**
     * Delete an existing Pap model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model
            ->estado->descripcion == 'LISTO') {
            return ['title' => "Eliminar informe Pap #" . $id, 'content' => "No se puede eliminar informe en estado listo", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        $request = Yii::$app->request;
        $clonedModel = clone $model->solicitudpap;
        $solicitud = $model->solicitudpap;
        $solicitud->id_estado = 5; //Vuelve al estado PENDIENTE
        $solicitud->save();
        AuditoriaBehaviors::actualizarEstadosolicitud($clonedModel, $solicitud, "solicitudpap");
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
    public function actionSelect() {
        $request = Yii::$app->request;
        $model = new Pap();
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
        // return [$vista,'forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['forceReload' => '#crud-datatable-pjax', 'title' => "AVISO!", 'content' => 'EL SIGUIENTE DOCUMENTO TIENE UN ESTADO <b>EN PROCESO</b> (NO ESTA VERIFICADO) CONFIRME SI DESEA GENERAR EL DOCUMENTO', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Confirmar', ['/pap/informe', 'id' => $id], ['class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'target' => '_blank', 'title' => 'Se abrirá el archivo PDF generado en una nueva ventana']) ];
        }
        else {
            $pap = $this->findModel($id);
            return $this->render('informePatologia', ['model' => $pap, 'edad' => $this->calcular_edad($pap->id_solicitudpap) ]);
        }
    }
    /**
     * Finds the Pap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Pap::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
