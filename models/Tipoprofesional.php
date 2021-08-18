<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoprofesional".
 *
 * @property int $id
 * @property string $profesion
 *
 * @property Medico[] $medicos
 */
class Tipoprofesional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoprofesional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profesion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profesion' => 'Profesion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medico::className(), ['id_tipoprofesional' => 'id']);
    }
}
