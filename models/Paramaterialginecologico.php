<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paramaterialginecologico".
 *
 * @property int $id
 * @property string $fecha_ult_mestruacion
 * @property string $ciclos
 * @property string $fecha_ult_parto
 * @property string $tratamiento_hormonal
 * @property string $pap_previo
 *
 * @property Solicitudbiopsia[] $solicitudbiopsias
 */
class Paramaterialginecologico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paramaterialginecologico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_ult_mestruacion', 'fecha_ult_parto'], 'safe'],
            [['ciclos', 'tratamiento_hormonal', 'pap_previo'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_ult_mestruacion' => 'Fecha Ult Mestruacion',
            'ciclos' => 'Ciclos',
            'fecha_ult_parto' => 'Fecha Ult Parto',
            'tratamiento_hormonal' => 'Tratamiento Hormonal',
            'pap_previo' => 'Pap Previo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudbiopsias()
    {
        return $this->hasMany(Solicitudbiopsia::className(), ['id_materialginecologico' => 'id']);
    }
}
