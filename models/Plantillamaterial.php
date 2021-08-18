<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillamateria".
 *
 * @property int $id
 * @property string $codigo
 * @property string $material
 * @property string $materialdiagnostico
 */
class Plantillamaterial extends \yii\db\ActiveRecord
{
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
            [['codigo'], 'string', 'max' => 8],
            [['material', 'materialdiagnostico'], 'string', 'max' => 40],
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
            'materialdiagnostico' => 'Materialdiagnostico',
        ];
    }

    public function attributeColumns()
    {
        return [
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'id',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'codigo',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'material',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'materialdiagnostico',
          ]
        ];
    }
}
