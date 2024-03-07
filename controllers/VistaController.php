<?php

namespace app\controllers;

use Yii;
use app\models\Vista;
use app\models\VistaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;

/**
 * VistaController implements the CRUD actions for Vista model.
 */
class VistaController extends Controller
{
    
    public function actionSelect($modelo) {
        $request = Yii::$app->request;
        $model = new $modelo;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
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
                $vista = \app\models\Vista::findOne(['id_usuario' => Yii::$app->user->id, 'modelo' => $model->classname() ]);
                if ($vista == null) {
                    $vista = new \app\models\Vista();
                    $vista->id_usuario = Yii::$app->user->id;
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
            return ['title' => "Personalizar Lista",
            'content' => $this->renderAjax('/../components/Vistas/_select',
            ['seleccion' => $seleccion, 'etiquetas' => $etiquetas, ]) ,
            'footer' => Html::button('Cancelar',
            ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
            . Html::button('Guardar', ['class' => 'btn btn-primary',
            'type' => "submit"]) ];
        }
        else {
            // Process for non-ajax request
            return $this->redirect(['index']);
        }
    }






}
