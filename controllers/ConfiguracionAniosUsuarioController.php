<?php

namespace app\controllers;

use Yii;
use app\models\ConfiguracionAniosUsuario;
use app\models\ConfiguracionAniosUsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AnioProtocolo;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;
use yii\filters\AccessControl;
/**
 * ConfiguracionAniosUsuarioController implements the CRUD actions for ConfiguracionAniosUsuario model.
 */
class ConfiguracionAniosUsuarioController extends Controller
{
  

    public function actionAnioselect($modelo) {
            $request = Yii::$app->request;
            $id_estudio = $modelo::find()
                ->select(['id_estudio'])
                ->scalar();
            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                // Cargar los años disponibles
                $aniosDisponibles = AnioProtocolo::aniosDisponibles();
                if (isset($_POST['seleccion'])) {
                  // recibo datos de lo seleccionado, reconstruyo columnas
                  $seleccionAnios = $_POST['seleccion'];
                  ConfiguracionAniosUsuario::deleteAll(["id_usuario"=> Yii::$app->user->id,"id_estudio"=>$id_estudio]);
                foreach ($seleccionAnios as $anio) {
                    $modelConfAnio= new ConfiguracionAniosUsuario();
                    $modelConfAnio->id_anio_protocolo = $anio;
                    $modelConfAnio->id_usuario= Yii::$app->user->id;
                    $modelConfAnio->id_estudio=$id_estudio;
                    $modelConfAnio->save();
                }
                return [$modelConfAnio, 'forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
              }else {
                // Obtener los años seleccionados por el usuario
                  $id_usuario = Yii::$app->user->id;
                  $aniosSeleccionados = ConfiguracionAniosUsuario::getSeleccionAnios($id_usuario , $id_estudio);
                      return ['success' => true,
                      'message' => 'Configuración de años guardada correctamente.',
                       'title' => "Configuración personalizada",
                       'content' => $this->renderAjax('/../components/Vistas/_anioselect',
                        ['aniosDisponibles' => $aniosDisponibles,
                        'aniosSeleccionados'=>$aniosSeleccionados]) ,
                       'footer' => Html::button('Cancelar',
                       ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                       . Html::button('Guardar', ['class' => 'btn btn-primary',
                       'type' => "submit"]) ];
              }
            } else {
                $this->redirect("index");
            }
        }

    /**
     * Deletes an existing ConfiguracionAniosUsuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ConfiguracionAniosUsuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfiguracionAniosUsuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfiguracionAniosUsuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
