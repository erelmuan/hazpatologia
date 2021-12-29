<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillapavimentosa".
 *
 * @property int $id
 * @property string $codigo
 * @property string $pavimentosa
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillapavimentosa extends \yii\db\ActiveRecord
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
        return 'plantillapavimentosa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pavimentosa'], 'string'],
            [['codigo'], 'string', 'max' => 8],
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
            'pavimentosa' => 'Pavimentosa',
        ];
    }
}
