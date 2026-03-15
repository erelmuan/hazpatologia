<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barrio".
 *
 * @property int $id
 * @property string $nombre
 * @property int $id_localidad
 *
 * @property Localidad $localidad
 * @property Domicilio[] $domicilios
 */
class Barrio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barrio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'id_localidad'], 'required'],
            [['nombre'], 'string'],
            [['id_localidad'], 'default', 'value' => null],
            [['id_localidad'], 'integer'],
            [['nombre', 'id_localidad'], 'unique', 'targetAttribute' => ['nombre', 'id_localidad']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'id_localidad' => 'Id Localidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomicilios()
    {
        return $this->hasMany(Domicilio::className(), ['id_barrio' => 'id']);
    }
}
