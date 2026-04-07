<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "localidad".
 *
 * @property int $id
 * @property int $id_provincia
 * @property string $nombre
 * @property string $codigopostal
 *
 * @property Provincia $provincia
 * @property Paciente[] $pacientes
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Localidad extends \yii\db\ActiveRecord
{

  public function behaviors()
  {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
 }
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
            [[ 'id_provincia', 'codigopostal'], 'default', 'value' => null],
            [[ 'id_provincia'], 'integer'],
            [['nombre', 'codigopostal'], 'string', 'max' => 65],
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
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->nombre = strtoupper($this->nombre);
        return true;
    }
    public static function getMapByProvincia($id_provincia){
      return ArrayHelper::map(self::find()->where(['id_provincia'=>$id_provincia])
      ->orderBy('nombre')->all(),'id','nombre');
    }
}
