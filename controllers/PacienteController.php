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
use yii\db\Schema;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\db\Query;
use yii\widgets\ActiveForm;
use app\models\Domicilio;
use app\models\Contacto;
use app\models\Tipocontacto;
use app\models\Tipouso;
use app\models\Nacionalidad;
use app\models\Genero;
use app\models\Tipodoc;
use app\models\Tipodom;
use app\base\Model;
/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends AppController {
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
        $model = $this->findModel($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['title' => "Paciente #" . $id,
            'content' => $this->renderAjax('view', ['model' => $model ]) ,
             'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left',
              'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $model ]);
        }
    }

    protected function devolverArray($model) {

      return [
              // El modelo sabe cómo filtrarse y mapearse
              'provincias'      => Provincia::getMap(),
              'localidades'     => Localidad::getMapByProvincia($model->id_provincia),
              'obrasociales'    => Obrasocial::getMap(),
              // Datos específicos del carnet (esto sí puede ir aquí o en el modelo Paciente)
              'valorObrasocial' => CarnetOs::getMapIdsByPaciente($model->id),
              'afiliado'        => CarnetOs::getMapAfiliadosByPaciente($model->id),
              // Estructuras para Tabular Input
              'tiposContacto'   => Tipocontacto::getMap(),
              'tipoDomicilios' =>Tipodom::getMap(),
              'tiposUso'        => Tipouso::getMap(),
              'nacionalidades' => Nacionalidad::getMap(),
              'generos' => Genero::getMap(),
              'tipoDocumentos' => Tipodoc::getMap(),
          ];

    }



    private function guardarPaciente($model, $modelsDomicilios, $modelsContactos,$modelsCarnetOs,$registrarChequeo)
    {
        $validPaciente   = $model->validate();
        $validDomicilios = Model::validateMultiple($modelsDomicilios);
        $validContactos  = Model::validateMultiple($modelsContactos);
        $validCarnetOs = Model::validateMultiple($modelsCarnetOs);

        if (!($validPaciente && $validDomicilios && $validContactos && $validCarnetOs)) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {

            if (!$model->save(false)) {
                $transaction->rollBack();
                return false;
            }

            foreach ($modelsDomicilios as $d) {
                $d->id_paciente = $model->id;
                if (!$d->save(false)) {
                    $transaction->rollBack();
                    return false;
                }
            }

            foreach ($modelsContactos as $c) {
                $c->id_paciente = $model->id;
                if (!$c->save(false)) {
                    $transaction->rollBack();
                    return false;
                }
            }
            foreach ($modelsCarnetOs as $ca) {
                $ca->id_paciente = $model->id;
                if (!$ca->save(false)) {
                    $transaction->rollBack();
                    return false;
                }
            }
            if ($registrarChequeo) {
                 if (!$model->registrarChequeo()) {
                     throw new \Exception('Error registrando chequeo');
                 }
             }
            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
    /**
     * Creates a new Paciente model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $request = Yii::$app->request;
         $model = new Paciente();
         $modelsDomicilios = [];
         $modelsContactos  = [];
         $modelsCarnetOs  = [];
         if ($request->isAjax) {
             Yii::$app->response->format = Response::FORMAT_JSON;
             if ($model->load($request->post())) {
                 $modelsDomicilios = Model::createMultiple(Domicilio::classname());
                 $modelsContactos  = Model::createMultiple(Contacto::classname());
                 $modelsCarnetOs  = Model::createMultiple(CarnetOs::classname());
                 Model::loadMultiple($modelsDomicilios, $request->post());
                 Model::loadMultiple($modelsContactos,  $request->post());
                 Model::loadMultiple($modelsCarnetOs,  $request->post());
                 $registrar = Yii::$app->request->post('obra_social_check') ? true : false;
                 if ($this->guardarPaciente($model, $modelsDomicilios, $modelsContactos,$modelsCarnetOs,$registrar)) {

                     return [
                         'forceReload' => '#crud-datatable-pjax',
                         'title' => "Crear nuevo Paciente",
                         'content' => '<span class="text-success">Éxito al crear paciente</span>',
                         'footer' =>
                             Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                             Html::a('Crear otro',['create'],['class'=>'btn btn-primary','role'=>'modal-remote']),
                     ];
                 }
             }

             return [
                 'title' => "Crear nuevo paciente",
                 'content' => $this->renderAjax('_form', [
                     'model'=>$model,
                     'estructuraArray'=>$this->devolverArray($model),
                     'modelsDomicilios'=>$modelsDomicilios,
                     'modelsContactos'=>$modelsContactos,
                     'modelsCarnetOs'=>$modelsCarnetOs

                 ]),
                 'footer' =>
                     Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                     Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"]),
             ];
         }

         // POST normal
         if ($model->load($request->post())) {
             $modelsDomicilios = Model::createMultiple(Domicilio::classname());
             $modelsContactos  = Model::createMultiple(Contacto::classname());
             $modelsCarnetOs  = Model::createMultiple(CarnetOs::classname());
             Model::loadMultiple($modelsDomicilios, $request->post());
             Model::loadMultiple($modelsContactos,  $request->post());
             Model::loadMultiple($modelsCarnetOs,  $request->post());
             $registrar = Yii::$app->request->post('obra_social_check') ? true : false;

             if ($this->guardarPaciente($model, $modelsDomicilios, $modelsContactos,$modelsCarnetOs,$registrar)) {
                 return $this->redirect(['view','id'=>$model->id]);
             }
         }
         return $this->render('_form', [
             'model'=>$model,
             'estructuraArray'=>$this->devolverArray($model),
             'modelsDomicilios'=>$modelsDomicilios,
             'modelsContactos'=>$modelsContactos,
             'modelsCarnetOs'=>$modelsCarnetOs

         ]);
     }



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



    private function actualizarPaciente($model, $modelsDomicilios, $modelsContactos, $modelsCarnetOs,$registrarChequeo)
    {
        $validPaciente   = $model->validate();
        $validDomicilios = Model::validateMultiple($modelsDomicilios);
        $validContactos  = Model::validateMultiple($modelsContactos);
        $validCarnetOs   = Model::validateMultiple($modelsCarnetOs);

        if (!($validPaciente && $validDomicilios && $validContactos && $validCarnetOs)) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!$model->save(false)) {
                $transaction->rollBack();
                return false;
            }

            // IDs que vienen del form (los que el usuario dejó)
            $idsDom = array_filter(array_map(fn($m) => $m->id, $modelsDomicilios));
            $idsCon = array_filter(array_map(fn($m) => $m->id, $modelsContactos));
            $idsOs  = array_filter(array_map(fn($m) => $m->id, $modelsCarnetOs));

            // Eliminar los que ya no están
            Domicilio::deleteAll(['AND', ['id_paciente' => $model->id], ['NOT IN', 'id', array_merge([0], $idsDom)]]);
            Contacto::deleteAll(['AND', ['id_paciente' => $model->id], ['NOT IN', 'id', array_merge([0], $idsCon)]]);
            CarnetOs::deleteAll(['AND', ['id_paciente' => $model->id], ['NOT IN', 'id', array_merge([0], $idsOs)]]);

            foreach ($modelsDomicilios as $d) {
                $d->id_paciente = $model->id;
                if (!$d->save(false)) { $transaction->rollBack(); return false; }
            }

            foreach ($modelsContactos as $c) {
                $c->id_paciente = $model->id;
                if (!$c->save(false)) { $transaction->rollBack(); return false; }
            }

            foreach ($modelsCarnetOs as $ca) {
                $ca->id_paciente = $model->id;
                if (!$ca->save(false)) { $transaction->rollBack(); return false; }
            }

            if ($registrarChequeo) {
                 if (!$model->registrarChequeo()) {
                     throw new \Exception('Error registrando chequeo');
                 }
             }
            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsDomicilios = $model->domicilios;
        $modelsContactos  = $model->contactos;
        $modelsCarnetOs   = $model->carnetOs;

        if ($request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->load($request->post())) {

                // ← sin Model::loadMultiple después, cargarModelos ya carga todo
                $modelsDomicilios = Model::cargarModelos(Domicilio::class, 'Domicilio', $request->post());
                $modelsContactos  = Model::cargarModelos(Contacto::class,  'Contacto',  $request->post());
                $modelsCarnetOs   = Model::cargarModelos(CarnetOs::class,  'CarnetOs',  $request->post());
                $registrar = Yii::$app->request->post('obra_social_check') ? true : false;

                if ($this->actualizarPaciente($model, $modelsDomicilios, $modelsContactos, $modelsCarnetOs,$registrar)) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title'   => "Actualizar Paciente",
                        'content' => '<span class="text-success">Paciente actualizado correctamente</span>',
                        'footer'  =>
                            Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::a('Ver paciente', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']),
                    ];
                }
            }

            return [
                'title'   => "Actualizar Paciente",
                'content' => $this->renderAjax('_form', [
                    'model'            => $model,
                    'estructuraArray'  => $this->devolverArray($model),
                    'modelsDomicilios' => $modelsDomicilios,
                    'modelsContactos'  => $modelsContactos,
                    'modelsCarnetOs'   => $modelsCarnetOs,
                ]),
                'footer' =>
                    Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                    Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => 'submit']),
            ];
        }

        // POST normal
        if ($model->load($request->post())) {

            // ← mismo cambio acá
            $modelsDomicilios = Model::cargarModelos(Domicilio::class, 'Domicilio', $request->post());
            $modelsContactos  = Model::cargarModelos(Contacto::class,  'Contacto',  $request->post());
            $modelsCarnetOs   = Model::cargarModelos(CarnetOs::class,  'CarnetOs',  $request->post());
            $registrar = Yii::$app->request->post('obra_social_check') ? true : false;

            if ($this->actualizarPaciente($model, $modelsDomicilios, $modelsContactos, $modelsCarnetOs,$registrar )) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('_form', [
            'model'            => $model,
            'estructuraArray'  => $this->devolverArray($model),
            'modelsDomicilios' => $modelsDomicilios,
            'modelsContactos'  => $modelsContactos,
            'modelsCarnetOs'   => $modelsCarnetOs,
        ]);
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
