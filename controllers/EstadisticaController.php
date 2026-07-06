<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\services\EstadisticaService;

class EstadisticaController extends AppController
{
    public function actionIndex()
    {
        $datos = EstadisticaService::dashboard();

        return $this->render('index', [
            'datos' => $datos
        ]);
    }

    public function actionGraficos()
    {
        return $this->render('graficos');
    }

    public function actionReportes()
    {
        return $this->render('reportes');
    }

    public function actionExportar()
    {
        return $this->render('exportar');
    }

    public function actionIndicadores()
    {
        return $this->render('indicadores');
    }

    public function actionProcedencia()
    {
        return $this->render('procedencia');
    }

    public function actionProfesionales()
    {
        return $this->render('profesionales');
    }
    public function actionReportepdf()
    {
        return $this->render('reportepdf');
    }

    public function actionTiempos()
    {
        return $this->render('tiempos');
    }
}
