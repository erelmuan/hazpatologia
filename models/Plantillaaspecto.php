<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillaaspecto".
 *
 * @property int $id
 * @property string $codigo
 * @property string $aspecto
 */
class Plantillaaspecto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantillaaspecto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aspecto'], 'string'],
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
            'aspecto' => 'Aspecto',
        ];
    }
}
