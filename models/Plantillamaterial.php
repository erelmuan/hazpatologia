<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillamateria".
 *
 * @property int $id
 * @property string $codigo
 * @property string $material
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillamaterial extends \yii\db\ActiveRecord
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
      return 'plantillamaterial';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
      return [
          [['material'], 'string'],
          [['codigo'], 'string', 'max' => 10],
          [['id'], 'unique'],
      ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
      return [
          'id' => 'Id',
          'codigo' => 'Codigo',
          'material' => 'Material',
      ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getBiopsias()
  {
      return $this->hasMany(Biopsia::className(), ['id_plantillamaterial' => 'id']);
  }
}
