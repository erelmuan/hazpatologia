<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillaflora".
 *
 * @property int $id
 * @property string $codigo
 * @property string $flora
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillaflora extends \yii\db\ActiveRecord
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
        return 'plantillaflora';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flora'], 'string'],
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
            'flora' => 'Flora',
        ];
    }
}
