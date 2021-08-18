<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "estado".
 *
 * @property int $id
 * @property string $descripcion
 * @property bool $solicitud
 * @property bool $biopsia
 * @property bool $pap
 * @property bool $ver_informe_solicitud
 * @property bool $ver_informe_estudio
 */
class RECHAZADO extends Estado
{

    public function estadosSolicitud(){
        return ArrayHelper::map(Estado::find()->where(['and', "solicitud=true"])
        ->all(), 'id','descripcion');
    }
}
