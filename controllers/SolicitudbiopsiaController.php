<?php
namespace app\controllers;
use Yii;
use app\models\Solicitudbiopsia;
use app\models\SolicitudbiopsiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\PacienteSearch;
use app\models\Paciente;
use app\models\MedicoSearch;
use app\models\Medico;
use app\components\Metodos\Metodos;
/**
 * SolicitudbiopsiaController implements the CRUD actions for Solicitudbiopsia model.
 */
class SolicitudbiopsiaController extends SolicitudController {
    public function actionIndex() {
        $model = new Solicitudbiopsia();
        $searchModel = new SolicitudbiopsiaSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request->queryParams, '');
        $dataProvider
            ->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }
    /**
     * Finds the Solicitudbiopsia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitudbiopsia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Solicitudbiopsia::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    function returnModel() {
        return new Solicitudbiopsia();
    }
    function returnModelSearch() {
        return new SolicitudbiopsiaSearch();
    }
}
