<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "plantillafrase".
 *
 * @property int $id
 * @property string $codigo
 * @property string $frase
 * @property int $id_estudio
 *
 * @property Estudio $estudio
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantillafrase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantillafrase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frase'], 'string'],
            [['id_estudio'], 'default', 'value' => null],
            [['id_estudio'], 'integer'],
            [['codigo'], 'string', 'max' => 8],
            [['id_estudio'], 'exist', 'skipOnError' => true, 'targetClass' => Estudio::className(), 'targetAttribute' => ['id_estudio' => 'id']],
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
            'frase' => 'Frase',
            'id_estudio' => 'Id Estudio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'id_estudio']);
    }
    public function getEstudios() {
        return ArrayHelper::map(Estudio::find()->all(), 'id','descripcion');

    }
}
