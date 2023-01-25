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
 * @property int $id_cie10
 * @property Biopsia[] $biopsias
 * @property Pap[] $paps
 * @property Estudio $estudio
 * @property cie10 $cie10
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Plantilladiagnostico extends \yii\db\ActiveRecord
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
        return 'plantilladiagnostico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo','diagnostico'], 'string'],
            [['id_estudio', 'id_cie10'], 'default', 'value' => null],
            [['id_estudio', 'id_cie10'], 'integer'],
            [['codigo'], 'string', 'max' => 18],
            [['id_cie10'], 'exist', 'skipOnError' => true, 'targetClass' => cie10::className(), 'targetAttribute' => ['id_cie10' => 'id']],
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
            'id_cie10' => 'Id Cie10',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
 		*/
    public function getcie10()
      {
        return $this->hasOne(cie10::className(), ['id' => 'id_cie10']);
     }
     public function getcie10s() {
         return ArrayHelper::map(cie10::find()->all(), 'id','descripcion','codigo');
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
