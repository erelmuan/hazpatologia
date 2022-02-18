<?php

namespace app\models;
use yii\helpers\Html;

use Yii;

/**
 * This is the model class for table "tipodoc".
 *
 * @property int $id
 * @property string $documento
 *
 * @property Paciente[] $pacientes
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Tipodoc extends \yii\db\ActiveRecord
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
        return 'tipodoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'documento' => 'Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['id_tipodoc' => 'id']);
    }
    public static function getListTipodoc()
 {
    return Html::dropDownList(Tipodoc::find()->all(),['id'=>'documento']);
 }
}
