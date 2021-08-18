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
class Plantillaflora extends \yii\db\ActiveRecord
{
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
