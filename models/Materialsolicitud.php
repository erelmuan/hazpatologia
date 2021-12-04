<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "materialsolicitud".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $id_estudio
* @property Solicitud[] $solicituds
 * @property Estudio $estudio
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Materialsolicitud extends \yii\db\ActiveRecord
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
        return 'materialsolicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['id_estudio'], 'default', 'value' => null],
            [['id_estudio'], 'integer'],
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
            'descripcion' => 'Descripcion',
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

    public function getestudios() {
        return ArrayHelper::map(Estudio::find()->all(), 'id','descripcion');

    }
     /**
	 * @return \yii\db\ActiveQuery
    */
     public function getSolicituds()
     {
       return $this->hasMany(Solicitud::className(), ['id_materialsolicitud' => 'id']);
      }
}
