<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estado_pendiente".
 *
 * @property int $id
 * @property string $descripcion
 * @property bool $solicitud
 * @property bool $biopsia
 * @property bool $pap
 * @property bool $ver_informe_solicitud
 * @property bool $ver_informe_estudio
 */
class EstadoPendiente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado_pendiente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['solicitud', 'biopsia', 'pap', 'ver_informe_solicitud', 'ver_informe_estudio'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'solicitud' => 'Solicitud',
            'biopsia' => 'Biopsia',
            'pap' => 'Pap',
            'ver_informe_solicitud' => 'Ver Informe Solicitud',
            'ver_informe_estudio' => 'Ver Informe Estudio',
        ];
    }
}
