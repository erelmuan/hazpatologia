<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pacientecheckos".
 *
 * @property int $id
 * @property int $id_paciente
 * @property string $fechahora
 * @property bool $tiene_os
 *
 * @property Paciente $paciente
 */
class Pacientecheckos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pacientecheckos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'fechahora', 'tiene_os'], 'required'],
            [['id_paciente'], 'default', 'value' => null],
            [['id_paciente'], 'integer'],
            [['fechahora'], 'safe'],
            [['tiene_os'], 'boolean'],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'fechahora' => 'Fechahora',
            'tiene_os' => 'Tiene Os',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }
}
