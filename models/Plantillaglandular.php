<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillaglandular".
 *
 * @property int $id
 * @property string $codigo
 * @property string $glandular
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillaglandular extends \yii\db\ActiveRecord
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
        return 'plantillaglandular';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['glandular'], 'string'],
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
            'glandular' => 'Glandular',
        ];
    }
}
