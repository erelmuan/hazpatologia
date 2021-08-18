<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "localidad".
 *
 * @property int $id
 * @property int $id_provincia
 * @property string $nombre
 * @property int $codigopostal
 *
 * @property Provincia $provincia
 * @property Paciente[] $pacientes
 */
class Localidad extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_provincia', 'codigopostal'], 'default', 'value' => null],
            [['id', 'id_provincia', 'codigopostal'], 'integer'],
            [['nombre'], 'string', 'max' => 65],
            [['id'], 'unique'],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'id_provincia' => 'Provincia',
            'nombre' => 'Nombre',
            'codigopostal' => 'Codigo postal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['id_localidad' => 'id']);
    }
}
