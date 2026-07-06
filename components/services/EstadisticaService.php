<?php

namespace app\components\services;

use app\models\Estudio;
use app\models\Procedencia;
use app\models\Medico;
use app\models\Solicitudbiopsia;

class EstadisticaService
{
    public static function dashboard()
    {
        return [
            'total_estudios' => Estudio::find()->count(),
            'pendientes' => Solicitudbiopsia::find()->where(['id_estado' => 1])->count(),
            'finalizados' => Solicitudbiopsia::find()->where(['id_estado' => 1])->count(),
            'procedencias' => Procedencia::find()->count(),
            'profesionales' => Medico::find()->count(),
        ];
    }
}
