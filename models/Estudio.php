<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudio".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $modelo
 * @property string $codigo
 *
 * @property Materialsolicitud[] $materialsolicituds
 * @property Plantilladiagnostico[] $plantilladiagnosticos
 * @property Plantillafrase[] $plantillafrases
 * @property Solicitud[] $solicituds
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Estudio extends \yii\db\ActiveRecord
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
        return 'estudio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'modelo', 'codigo'], 'string'],
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
             'codigo' => 'Codigo',
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
    public function getSolicituds()
 		   {
 		       return $this->hasMany(Solicitud::className(), ['id_estudio' => 'id']);
 		   }

}
