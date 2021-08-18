<?php

namespace app\models;
use app\components\behaviors\AuditoriaBehaviors;

use Yii;

/**
 * This is the model class for table "carnet_os".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_obrasocial
 * @property string $nroafiliado
 *
 * @property Obrasocial $obrasocial
 * @property Paciente $paciente
 */
class CarnetOs extends \yii\db\ActiveRecord
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
        return 'carnet_os';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_obrasocial'], 'default', 'value' => null],
            [['id_paciente', 'id_obrasocial'], 'integer'],
            [['nroafiliado'], 'string'],
            [['id_obrasocial'], 'exist', 'skipOnError' => true, 'targetClass' => Obrasocial::className(), 'targetAttribute' => ['id_obrasocial' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'id_paciente' => 'Id_paciente',
            'id_obrasocial' => 'Id_ obrasocial',
            'nroafiliado' => 'Nroafiliado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObrasocial()
    {
        return $this->hasOne(Obrasocial::className(), ['id' => 'id_obrasocial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }
}
