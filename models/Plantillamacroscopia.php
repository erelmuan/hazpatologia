<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillamacroscopia".
 *
 * @property int $id
 * @property string $codigo
 * @property string $macroscopia
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillamacroscopia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantillamacroscopia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['macroscopia'], 'string'],
            [['codigo'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'macroscopia' => 'Macroscopia',
        ];
    }
}
