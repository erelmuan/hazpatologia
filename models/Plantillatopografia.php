<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillatopografia".
 *
 * @property int $id
 * @property string $codigo
 * @property string $topografia
 *
 * @property Biopsia[] $biopsias
 */
class Plantillatopografia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantillatopografia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topografia'], 'string'],
            [['codigo'], 'string', 'max' => 10],
            [['id'], 'unique'],
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
            'topografia' => 'Topografia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsias()
    {
        return $this->hasMany(Biopsia::className(), ['id_plantillatopografia' => 'id']);
    }
}
