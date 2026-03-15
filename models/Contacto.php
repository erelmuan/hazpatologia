<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacto".
 *
 * @property int $id
 * @property int $id_tipocontacto
 * @property string $valor
 * @property int $id_tipouso
 * @property string $fechabaja
 * @property int $id_paciente
 * @property Tipocontacto $tipocontacto
 * @property Paciente $paciente
 * @property Tipouso $tipouso
 */
class Contacto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipocontacto', 'valor', 'id_tipouso'], 'required'],
            // id_paciente ya no está en required
            [['id_tipocontacto', 'id_tipouso', 'id_paciente'], 'default', 'value' => null],
            [['id_tipocontacto', 'id_tipouso', 'id_paciente'], 'integer'],
            [['valor'], 'string'],
            [['fechabaja'], 'safe'],
            // [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_tipocontacto'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocontacto::className(), 'targetAttribute' => ['id_tipocontacto' => 'id']],
            [['id_tipouso'], 'exist', 'skipOnError' => true, 'targetClass' => Tipouso::className(), 'targetAttribute' => ['id_tipouso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipocontacto' => 'Tipo de contacto',
            'valor' => 'Valor',
            'id_tipouso' => 'Tipo de uso',
            'fechabaja' => 'Fecha de baja',
            'id_paciente' => 'Id Paciente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipouso()
    {
        return $this->hasOne(Tipouso::className(), ['id' => 'id_tipouso']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipocontacto()
    {
        return $this->hasOne(Tipocontacto::className(), ['id' => 'id_tipocontacto']);
    }
}
