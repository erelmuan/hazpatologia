<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantilladiagnosticop".
 *
 * @property int $id
 * @property string $codigo
 * @property string $diagnostico
 */
class Plantilladiagnosticop extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantilladiagnosticop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diagnostico'], 'string'],
            [['codigo'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'codigo' => 'Codigo',
            'diagnostico' => 'Diagnóstico',
        ];
    }
}
