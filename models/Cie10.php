<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cie10".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $codigo
 *
 * @property Biopsia[] $biopsias
 * @property Pap[] $paps
 */
class Cie10 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cie10';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'codigo'], 'required'],
            [['descripcion'], 'string', 'max' => 75],
            [['codigo'], 'string', 'max' => 6],
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
            'codigo' => 'Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsias()
    {
        return $this->hasMany(Biopsia::className(), ['id_cie10' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaps()
    {
        return $this->hasMany(Pap::className(), ['id_cie10' => 'id']);
    }
}
