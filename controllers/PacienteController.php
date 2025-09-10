<?php
namespace app\controllers;
use Yii;
use app\models\Paciente;
use app\models\PacienteSearch;
use app\models\Provincia;
use app\models\Localidad;
use app\models\Solicitud;
use app\models\Obrasocial;
use app\models\CarnetOs;
use app\models\Pacientecheckos;
use app\controllers\CarnetOsController;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\components\Metodos\Metodos;
use yii\db\Schema;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\db\Query;

/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends Controller {
  // behaviors heredado


    public function actionSearch() {
        $searchModelPac = new PacienteSearch();
        $searchModelPac->scenario = "search";
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $searchModelPac->load(\Yii::$app->request->get());
            if ($searchModelPac->validate()) {
                $dataProviderPac = $searchModelPac->search(\Yii::$app->request->get());
                if ($dataProviderPac->totalCount == 0) return Json::encode(['status' => 'error', 'mensaje' => "No se encontro el paciente"]);
                else return Json::encode(["nombre" => $dataProviderPac->getModels() [0]['nombre'], "apellido" => $dataProviderPac->getModels() [0]['apellido'], "id" => $dataProviderPac->getModels() [0]['id']]);
            }
            else {
                $errors = $searchModelPac->getErrors();
                return Json::encode(['status' => 'error', 'mensaje' => $errors['num_documento'][0]]);
            }
        }
    }
    /**
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Paciente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        $carnet = CarnetOsController::findidpacModel($id);
        $model = $this->findModel($id);
        $model->fecha_nacimiento = date('d/m/Y', strtotime($model->fecha_nacimiento));
        $lastCheck = \app\models\Pacientecheckos::find()
        ->where(['id_paciente' => $model->id])
        ->orderBy(['fechahora' => SORT_DESC])
        ->one();
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Paciente #" . $id,
            'content' => $this->renderAjax('view', ['model' => $model, 'carnet' => $carnet, 'lastCheck' => $lastCheck, ]) ,
             'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left',
              'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $model, 'carnet' => $carnet, 'lastCheck' => $lastCheck, ]);
        }
    }

    protected function devolverArray($model, &$provincias, &$localidades, &$valorObrasocial, &$afiliado, &$obrasociales) {
        $provincias = ArrayHelper::map(Provincia::find()->all() , 'id', 'nombre');
        $valorObrasocial = ArrayHelper::map(CarnetOs::Find()->where(['id_paciente' => $model
            ->id])
            ->all() , 'id_obrasocial', 'id_obrasocial');
        $afiliado = ArrayHelper::map(CarnetOs::Find()->where(['id_paciente' => $model
            ->id])
            ->all() , 'id_obrasocial', 'nroafiliado');
        $obrasociales = ArrayHelper::map(Obrasocial::find()->all() , 'id', 'denominacion');
        $Arraylocalidades = LocalidadController::findidproModel($model->id_provincia);
        foreach ($Arraylocalidades as $key => $value) {
            $localidades[$value['id']] = $value['nombre'];
        }
    }

    private function registrarChequeo($checkbox ,$model){
        // al guardar paciente
        $tieneOs = $model->getCarnetOs()->exists();
        // buscar si ya existe registro en pacientecheckos
        $checkOS = Pacientecheckos::find()->where(['id_paciente' => $model->id])->one();

        if (!$checkOS) {
            // si no existe, se crea uno nuevo
            $checkOS = new Pacientecheckos();
            $checkOS->id_paciente = $model->id;
        }

        // si tiene obra social -> setear true
        if ($tieneOs) {
            $checkOS->tiene_os = true;
        }else {
          $checkOS->tiene_os = false;

        }

        $checkOS->fechahora = date('Y-m-d H:i:s');
        $checkOS->save(false);
    }


    /**
     * Creates a new Paciente model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Paciente();
        $valorObrasocial = [];
        $afiliado = [];
        $provincias = [];
        $localidades = [];
        $obrasociales = [];
        $lastCheck = null;
        $this->chequeoOs( $lastCheck ,$model);
        $this->devolverArray($model, $provincias, $localidades, $valorObrasocial, $afiliado, $obrasociales);
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nuevo Paciente",
                'content' => $this->renderAjax('_form', ['model' => $model, 'provincias' => $provincias,
                'localidades' => $localidades, 'obrasociales' => $obrasociales,
                 'valorObrasocial' => $valorObrasocial, 'afiliado' => $afiliado,'lastCheck' => $lastCheck ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                if (isset($_POST['id_obrasocial'])) {
                    CarnetOsController::createParametros($model->id, $_POST['id_obrasocial'], $_POST['nroafiliado']);
                }
                // regla: si tiene OS registrar siempre, si no tiene OS registrar solo si checkbox está marcado
                 $tieneOs = $model->getCarnetOs()->exists();
                 $checkbox = Yii::$app->request->post('obra_social_check');
                 if ($tieneOs || $checkbox) {
                     $this->registrarChequeo(true, $model);
                 }
                return [
                // comentado para que funcione cuando llamo desde la vista de solicitudes en la creacion
                // 'forceReload'=>'#crud-datatable-pjax',
                'title' => "Crear nuevo Paciente", 'content' => '<span class="text-success">Éxito al crear paciente</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Crear otro', ['_form'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nuevo paciente", 'content' => $this->renderAjax('_form', ['model' => $model,
                'provincias' => $provincias, 'localidades' => $localidades,
                 'obrasociales' => $obrasociales, 'valorObrasocial' => $valorObrasocial,
                  'afiliado' => $afiliado, 'lastCheck' => $lastCheck]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
        }
        else {
            /*
             *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                if (isset($_POST['id_obrasocial'])) {
                    CarnetOsController::createParametros($model->id, $_POST['id_obrasocial'], $_POST['nroafiliado']);
                    // regla: si tiene OS registrar siempre, si no tiene OS registrar solo si checkbox está marcado
                }
                $tieneOs = $model->getCarnetOs()->exists();
                $checkbox = Yii::$app->request->post('obra_social_check');

                if ($tieneOs || $checkbox) {
                  die();
                    $this->registrarChequeo(true, $model);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('_form', ['model' => $model, 'provincias' => $provincias,
                'localidades' => $localidades, 'obrasociales' => $obrasociales,
                'valorObrasocial' => $valorObrasocial, 'afiliado' => $afiliado,
                'lastCheck' => $lastCheck ]);
            }
        }
    }
    ////////////////////////////////////
    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_provincia = $parents[0];
                //obtener todas las localidades por el id de la provincia
                $Arraylocalidades = Localidad::findall(['id_provincia' => $id_provincia]);
                ArrayHelper::multisort($Arraylocalidades, ['nombre'], [SORT_ASC]);
                $i = 0;
                $localidades = [];
                foreach ($Arraylocalidades as $key => $value) {
                    $localidades[$i] = array(
                        'id' => $value['id'],
                        'name' => $value['nombre']
                    );
                    $i = $i + 1;
                }
                $out = [['id' => '<sub-cat-id-1>', 'name' => '<sub-cat-name1>'], ['id' => '<sub-cat_id_2>', 'name' => '<sub-cat-name2>']];
                return Json::encode(['output' => $localidades]);
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }


    private function chequeoOs( &$lastCheck ,$model){
      if (isset($model->id) && $model->id) {
          // ¿hay al menos un registro de chequeo para este paciente?
          $lastCheck = (new Query())
              ->from('pacientecheckos')
              ->where(['id_paciente' => $model->id])
              ->orderBy(['fechahora' => SORT_DESC])
              ->one();
      }
    }

    /**
     * Updates an existing Paciente model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        // $model = new Paciente();
        $model = $this->findModel($id);
        // $model->fecha_nacimiento = date('d/m/Y',strtotime($model->fecha_nacimiento));
        $valorObrasocial = [];
        $afiliado = [];
        $provincias = [];
        $localidades = [];
        $obrasociales = [];
        $this->devolverArray($model, $provincias, $localidades, $valorObrasocial, $afiliado, $obrasociales);
        $todasOsAntes = $model->getCarnetOs()->select('id_obrasocial')->column();
        $lastCheck = null;
        $this->chequeoOs($lastCheck ,$model);

        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Actualizar Paciente #" . $id,
                'content' => $this->renderAjax('_form', ['model' => $model,
                 'provincias' => $provincias, 'localidades' => $localidades,
                 'obrasociales' => $obrasociales, 'valorObrasocial' => $valorObrasocial,
                  'afiliado' => $afiliado,'lastCheck' => $lastCheck ]) ,
                   'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                $obraSocial = [];
                $nroAfiliado = [];
                if (isset($_POST['id_obrasocial'])) {
                    $obraSocial = $_POST['id_obrasocial'];
                    $nroAfiliado = $_POST['nroafiliado'];
                }
                CarnetOsController::updateParametros($model->id, $obraSocial, $nroAfiliado);
                $todasOsDespues = $model->getCarnetOs()->select('id_obrasocial')->column();
                // solo registrar si el checkbox vino marcado
                $checkbox = Yii::$app->request->post('obra_social_check');
                // regla actualización:
                // - si cambió el conjunto de OS → registrar siempre
                // - si es igual → registrar solo si checkbox
                if (($todasOsAntes !== $todasOsDespues) || $checkbox) {

                    $this->registrarChequeo(true, $model);
                }
                $carnet = CarnetOsController::findidpacModel($model->id);

                $this->chequeoOs($lastCheck ,$model);

                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Paciente #" . $id,
                'content' => $this->renderAjax('view', ['model' => $model,
                  'lastCheck' => $lastCheck]) ,
                  'footer' => Html::button('Cerrar',
                  ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                   Html::a('Editar', ['update', 'id' => $id], ['class' => 'btn btn-primary',
                   'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Actualizar Paciente #" . $id,
                 'content' => $this->renderAjax('_form',
                 ['model' => $model, 'provincias' => $provincias,
                 'localidades' => $localidades, 'valorObrasocial' => $valorObrasocial,
                 'afiliado' => $afiliado, 'obrasociales' => $obrasociales,'lastCheck' => $lastCheck ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
        }
        else {
            /*
             *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $obraSocial = [];
                $nroAfiliado = [];
                if (isset($_POST['id_obrasocial'])) {
                    $obraSocial = $_POST['id_obrasocial'];
                    $nroAfiliado = $_POST['nroafiliado'];
                }
                CarnetOsController::updateParametros($model->id, $obraSocial, $nroAfiliado);
                $todasOsDespues = $model->getCarnetOs()->select('id_obrasocial')->column();
                // solo registrar si el checkbox vino marcado
                $checkbox = Yii::$app->request->post('obra_social_check');
                // regla actualización:
                // - si cambió el conjunto de OS → registrar siempre
                // - si es igual → registrar solo si checkbox
                if ($todasOsAntes !== $todasOsDespues || $checkbox) {
                    $this->registrarChequeo(true, $model);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('_form', ['model' => $model, 'provincias' => $provincias,
                 'localidades' => $localidades, 'obrasociales' => $obrasociales,
                 'valorObrasocial' => $valorObrasocial, 'afiliado' => $afiliado,'lastCheck' => $lastCheck ]);
            }
        }
    }


    //delete hereda de Controller

    public function actionPuco()
    {
        if (Yii::$app->request->isAjax) {
            if (!empty($_POST['dni'])) {

                $data = Yii::$app->request->post();
                $dni = explode(":", $data['dni'])[0];
                $urlPuco = Yii::$app->params['urlPuco'] ?? null;

                $url = $urlPuco.$dni;

                $ch = curl_init($url);
                $payload = json_encode([
                    'usuario' => Yii::$app->params['usuarioPuco'],
                    'clave'   => Yii::$app->params['clavePuco']
                ]);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ⚠️ Cambiar a true cuando actualices certificados
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);

                $result = curl_exec($ch);
                $curlError = curl_error($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // Si hubo error de conexión
                if ($curlError) {
                    echo Json::encode(["error" => "Error de conexión: $curlError"]);
                    return;
                }

                // Si el servicio respondió con código distinto de 200
                if ($httpCode !== 200) {
                    echo Json::encode(["error" => "HTTP Code: $httpCode", "respuesta" => $result]);
                    return;
                }

                // Si la respuesta está vacía
                if (empty($result)) {
                    echo Json::encode(["error" => "Respuesta vacía del servicio"]);
                    return;
                }

                // Intentar parsear como XML
                libxml_use_internal_errors(true);
                $oXML = simplexml_load_string($result);

                if ($oXML === false) {
                    // No es XML válido, devolvemos el texto plano
                    echo Json::encode(["resultado" => trim($result)]);
                    return;
                }

                // Si el XML dice OK, procesamos obras sociales
                if (isset($oXML->resultado) && (string)$oXML->resultado === "OK") {
                    $items = "";
                    $cant = 1;
                    $obrasoc = [];

                    foreach ($oXML->puco as $puco) {
                        if (!in_array(trim($puco[0]->coberturaSocial), $obrasoc)) {
                            $obrasoc[$cant] = $puco[0]->coberturaSocial;
                            $items .= "Obra social $cant: {$obrasoc[$cant]}\r\n";
                            $cant++;
                        }
                    }

                    if (trim($items) === "") {
                        // No hay obras sociales
                        echo Json::encode(["resultado" => "NO_ENCONTRADO"]);
                    } else {
                        echo Json::encode([$items]);
                    }
                    return;
                }

                // Si el XML no es OK, devolvemos el resultado
                echo Json::encode(["resultado" => (string)$oXML->resultado]);
                return;

            } else {
                echo Json::encode(["error" => "No se completó el campo Nº doc."]);
                return;
            }
        }
    }


    public function actionRenaper()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $dni = Yii::$app->request->post('dni');
        $sexo = Yii::$app->request->post('sexo');

        // Validar que se recibieron los parámetros necesarios
        if (empty($dni) || empty($sexo)) {
            return ['success' => false, 'error' => 'DNI y sexo son requeridos'];
        }

        // Obtener credenciales desde params
        $usuario = Yii::$app->params['usuarioRenaper'] ?? null;
        $clave = Yii::$app->params['claveRenaper'] ?? null;
        $area = Yii::$app->params['areaHospital'] ?? null;
        $urlRenaper = Yii::$app->params['urlRenaper'] ?? null;


        if (!$usuario || !$clave) {
            return ['success' => false, 'error' => 'Credenciales no configuradas'];
        }

        // Construir URL del endpoint
        $url = "$urlRenaper&id_area=$area&dni=$dni&sexo=$sexo";

        try {
            // Inicializar cURL
            $ch = curl_init();

            // Configurar opciones de cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$usuario:$clave");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Solo para desarrollo, en producción debería ser true
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            // Ejecutar la solicitud
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Verificar errores
            if (curl_errno($ch)) {
                throw new Exception('Error en la conexión: ' . curl_error($ch));
            }

            // Cerrar la conexión
            curl_close($ch);

            // Verificar código de respuesta HTTP
            if ($httpCode !== 200) {
                return [
                    'success' => false,
                    'error' => "Error en el servicio. Código HTTP: $httpCode"
                ];
            }

            // Decodificar la respuesta JSON
            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'error' => 'Error al decodificar la respuesta del servicio'
                ];
            }

            // Devolver los datos obtenidos
            return [
                'success' => true,
                'data' => $data
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }


    /**
     * Finds the Paciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Paciente::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
