<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "plantilladiagnostico".
 *
 * @property int $id
 * @property string $codigo
 * @property string $diagnostico
 * @property int $id_estudio
 *
 * @property Biopsia[] $biopsias
 * @property Pap[] $paps
 * @property Estudio $estudio
 */
class Plantilladiagnostico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantilladiagnostico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diagnostico'], 'string'],
            [['id_estudio'], 'default', 'value' => null],
            [['id_estudio'], 'integer'],
            [['codigo'], 'string', 'max' => 18],
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
            'diagnostico' => 'Diagnostico',
            'id_estudio' => 'Id Estudio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsias()
    {
        return $this->hasMany(Biopsia::className(), ['id_plantilladiagnostico' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaps()
    {
        return $this->hasMany(Pap::className(), ['id_plantilladiagnostico' => 'id']);
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
