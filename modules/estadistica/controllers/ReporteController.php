<?php

namespace app\modules\estadistica\controllers;

use Yii;
use yii\web\Controller;
use app\modules\estadistica\models\SolicitudesSearch;
use app\modules\estadistica\services\ReporteSolicitudesService;

class ReporteController extends Controller
{

    public function actionSolicitudes()
    {

        $searchModel = new SolicitudesSearch();

        $resultado = [];

        if ($searchModel->load(Yii::$app->request->get()) && $searchModel->validate()) {

            $service = new ReporteSolicitudesService();

            $resultado = $service->buscar($searchModel);

        }

        return $this->render('solicitudes',[
            'searchModel'=>$searchModel,
            'resultado'=>$resultado
        ]);

    }

}
