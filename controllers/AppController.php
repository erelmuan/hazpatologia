<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\Json;
use yii\filters\AccessControl;
use app\components\Seguridad\Seguridad;
use yii\filters\VerbFilter;
class AppController extends Controller
{

    public function behaviors()
      {
          return [
              'access' => [
                  'class' => AccessControl::className(),
                  // 'only' => ['debug'], //Se agrego porque si no aparecia el debug
                  //'only' => ['view','create','update','delete','export','select','list','index','createdetalle','listdetalle','addaccion','informe','documento'],

                  'rules' => [
                      [
                          'actions' => ['login', 'error'],
                          'allow' => true,
                          'roles' => ['?'],
                      ],
                      [
                          'actions' => ['logout'],
                          'allow' => true,
                          'roles' => ['@'],
                      ],

                      [
                          'actions' => [],
                          'allow' => true,
                          'roles' => ['@'],
                          'matchCallback' => function ($rule, $action) {
                              if (!Yii::$app->user->identity->activo ){
                                  Yii::$app->user->logout();
                                }

                          }
                      ],
                      [
                          //El administrador tiene permisos sobre las siguientes acciones
                       //   'actions' => ['view','create','update','delete','export','select','list','index'],
                          //Esta propiedad establece que tiene permisos
                          'allow' => Seguridad::tienePermiso(),   //la accion esta permitida (true o false)
                          //Usuarios autenticados, el signo ? es para invitados
                          'roles' => ['@'],
                      ],
                  ],
              ],
                      'verbs' => [
                          'class' => VerbFilter::className(),
                          'actions' => [
                              'logout' => ['post'],
                          ],
                      ],
                  ];
      }
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->isGuest) {
            return true;
        }

        $usuario = Yii::$app->user->identity;
        $rutaActual = Yii::$app->controller->route;

        $rutasPermitidas = [
            'site/login',
            'site/logout',
            'site/error',
            'usuario/cambiarcontrasenia',
        ];

        if ($usuario->cambioforzadocontrasenia && !in_array($rutaActual, $rutasPermitidas)) {

            $url = Url::to(['/usuario/cambiarcontrasenia']);

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                Yii::$app->response->data = ['forceRedirect' => $url];
                return false;
            }

            return $this->redirect($url);
        }

        return true;
    }

    //sirve para la ingresar los valores de las plantillas a las biopsias y paps
    public function actionBuscaregistro()  {
      if (Yii::$app->request->isAjax) {
        $out = [];
        if (isset($_POST['id'])) {
            $data = Yii::$app->request->post();
            $id= explode(":", $data['id']);
            $id= $id[0];
            if ($id != null) {
              if (($out = $this->findModel($id)) !== null) {
                echo Json::encode([$out]);
                return;
              } else {
                  throw new NotFoundHttpException('The requested page does not exist.');
                  }
            }
        }
     }
  }
    public function setearMensajeError($mensaje){
        Yii::$app->getSession()->setFlash('warning', [
            'type' => 'danger',
            'duration' => 6500,
            'icon' => 'fas fa-warning',
            'message' => $mensaje,
            'title' => 'NOTIFICACIÓN',
            'positonY' => 'top',
            'positonX' => 'right'
        ]);

      }
    public function setearMensajeExito($mensaje){
          Yii::$app->getSession()->setFlash('success', [
              'type' => 'success',
              'duration' => 5000,
              'icon' => 'fas fa-check-circle',
              'message' => $mensaje,
              'title' => 'NOTIFICACIÓN',
              'positonY' => 'top',
              'positonX' => 'right'
          ]);
        }

        public function obtenerTablasQueReferencian($model)
        {
            $schema = Yii::$app->db->schema; // Obtener el esquema completo de la base de datos
            $tablaActual = $model->tableName(); // Obtener el nombre de la tabla del modelo
            $tablasQueReferencian = [];

            foreach ($schema->tableSchemas as $tabla) {
                foreach ($tabla->foreignKeys as $claveForanea) {
                    if ($claveForanea[0] === $tablaActual) {
                        // Si la clave foránea apunta a la tabla actual, agregarla a la lista
                        $tablasQueReferencian[] = $tabla->name;
                    }
                }
            }

            // Eliminar duplicados del arreglo
            return array_unique($tablasQueReferencian); // Retorna un array sin duplicados
        }



        /**
         * Delete an existing Paciente model.
         * For ajax request will return json object
         * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
         public function actionDelete($id)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            try {
                $model = $this->findModel($id);
                $model->delete();
                $this->setearMensajeExito('El registro se eliminó correctamente.');
            } catch (\yii\db\Exception $e) {
                $errorInfo = $e->errorInfo;
                if ($errorInfo[0] === '23503') { // Violación de clave foránea
                    $tablasRelacionadas = $this->obtenerTablasQueReferencian($model);

                    if (!empty($tablasRelacionadas)) {
                        $mensajeTablas = implode(', ', $tablasRelacionadas); // Combina las tablas en un mensaje
                        $this->setearMensajeError("No se puede eliminar el registro, está vinculado con la/s tabla/s: {$mensajeTablas}.");
                    } else {
                        $this->setearMensajeError("No se puede eliminar el registro debido a una relación de clave foránea.");
                    }
                } else {
                    $this->setearMensajeError("Ocurrió un error inesperado: " . $e->getMessage());
                }
            }

            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];
        } else {
            return $this->redirect(['index']);
        }
    }
}

?>
