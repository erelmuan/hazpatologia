<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cirugiaprevia".
 *
 * @property int $id
 * @property string $descripcion
 *
 * @property Solicitudpap[] $solicitudpaps
 */
class Cirugiaprevia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cirugiaprevia';
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
            'id' => 'ID',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudpaps()
    {
        return $this->hasMany(Solicitudpap::className(), ['id_cirugia_previa' => 'id']);
    }
}
