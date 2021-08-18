<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudio".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $modelo
 *
 * @property Materialsolicitud[] $materialsolicituds
 * @property Plantilladiagnostico[] $plantilladiagnosticos
 * @property Plantillafrase[] $plantillafrases
 * @property Plantillamaterial[] $plantillamaterials
 */
class Estudio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estudio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'modelo'], 'string'],
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
            'modelo' => 'Modelo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialsolicituds()
    {
        return $this->hasMany(Materialsolicitud::className(), ['id_estudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlantilladiagnosticos()
    {
        return $this->hasMany(Plantilladiagnostico::className(), ['id_estudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlantillafrases()
    {
        return $this->hasMany(Plantillafrase::className(), ['id_estudio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlantillamaterials()
    {
        return $this->hasMany(Plantillamaterial::className(), ['id_estudio' => 'id']);
    }
}
