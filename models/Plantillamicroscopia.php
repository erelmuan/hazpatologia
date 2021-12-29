<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillamicroscopia".
 *
 * @property int $id
 * @property string $codigo
 * @property string $microscopia
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillamicroscopia extends \yii\db\ActiveRecord
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
        return 'plantillamicroscopia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['microscopia'], 'string'],
            [['codigo'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'microscopia' => 'Microscopia',
        ];
    }
}
