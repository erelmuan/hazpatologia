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
class Plantillaglandular extends \yii\db\ActiveRecord
{
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
