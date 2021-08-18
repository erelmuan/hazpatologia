<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipomuestra".
 *
 * @property string $descripcion
 * @property int $id
 *
 * @property Solicitudpap[] $solicitudpaps
 */
class Tipomuestra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipomuestra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'descripcion' => 'Descripcion',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudpaps()
    {
        return $this->hasMany(Solicitudpap::className(), ['id_tipomuestra' => 'id']);
    }
}
