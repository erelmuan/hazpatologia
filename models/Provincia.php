<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property int $id
 * @property string $nombre
 * @property string $codigo
 *
 * @property Departamento[] $departamentos
 * @property Localidad[] $localidads
 * @property Paciente[] $pacientes
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'codigo'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['codigo'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidads()
    {
       return $this->hasMany(Localidad::className(), ['id_provincia' => 'id']);
         }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
      return $this->hasMany(Paciente::className(), ['id_provincia' => 'id']);
    }
}
