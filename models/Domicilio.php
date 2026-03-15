<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "domicilio".
 *
 * @property int $id
 * @property string $calle
 * @property int $id_barrio
 * @property int $id_paciente
 * @property int $id_provincia
 * @property int $id_localidad
 * @property int $id_tipodom
 * @property string $fechabaja
 * @property bool $principal
 * @property string $numero
 * @property string $piso
 * @property string $departamento
 * @property string $codigopostal
 *
 * @property Barrio $barrio
 * @property Localidad $localidad
 * @property Paciente $paciente
 * @property Provincia $provincia
 * @property Tipodom $tipodom
 */
class Domicilio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'domicilio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calle', 'id_localidad'], 'required'],
            [['calle', 'numero', 'piso', 'departamento', 'codigopostal'], 'string'],
            [['id_barrio', 'id_paciente', 'id_provincia', 'id_localidad', 'id_tipodom'], 'default', 'value' => null],
            [['id_barrio', 'id_paciente', 'id_provincia', 'id_localidad', 'id_tipodom'], 'integer'],
            [['fechabaja'], 'safe'],
            [['principal'], 'boolean'],
            [['id_barrio'], 'exist', 'skipOnError' => true, 'targetClass' => Barrio::className(), 'targetAttribute' => ['id_barrio' => 'id']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
            // [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
            [['id_tipodom'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodom::className(), 'targetAttribute' => ['id_tipodom' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calle' => 'Calle',
            'id_barrio' => 'Id Barrio',
            'id_paciente' => 'Id Paciente',
            'id_provincia' => 'Provincia',
            'id_localidad' => 'Localidad',
            'id_tipodom' => 'Tipo de domicilio',
            'fechabaja' => 'Fecha de baja',
            'principal' => 'Principal',
            'numero' => 'Numero',
            'piso' => 'Piso',
            'departamento' => 'Departamento',
            'codigopostal' => 'Codigopostal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarrio()
    {
        return $this->hasOne(Barrio::className(), ['id' => 'id_barrio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
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
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodom()
    {
        return $this->hasOne(Tipodom::className(), ['id' => 'id_tipodom']);
    }
    public function getLocalidades($id_provincia)
    {
        return ArrayHelper::map(Localidad::find()->where(['id_provincia'=>$id_provincia])->orderBy(['nombre' => SORT_ASC])->all(), 'id','nombre');
    }
    public function getBarrios($id_localidad)
    {
        $barrios=Barrio::find()->where(['id_localidad'=>$id_localidad])->orderBy(['nombre' => SORT_ASC])->all();
        if(count($barrios)==0){
          return[null,null];
        }else {
          return ArrayHelper::map($barrios, 'id','nombre');

        }
    }

}
