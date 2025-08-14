<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "materialsolicitud_solicitud".
 *
 * @property int $id_solicitud
 * @property int $id_materialsolicitud
 * @property int $id
 * @property int $id_estudio
 *
 * @property Estudio $estudio
 * @property Materialsolicitud $materialsolicitud
 * @property Solicitud $solicitud.
 */
 use app\components\behaviors\AuditoriaBehaviors;

class MaterialsolicitudSolicitud extends \yii\db\ActiveRecord
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
        return 'materialsolicitud_solicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_solicitud', 'id_materialsolicitud', 'id_estudio'], 'required'],
            [['id_solicitud', 'id_materialsolicitud', 'id_estudio'], 'default', 'value' => null],
            [['id_solicitud', 'id_materialsolicitud', 'id_estudio'], 'integer'],
            [['id_estudio'], 'exist', 'skipOnError' => true, 'targetClass' => Estudio::className(), 'targetAttribute' => ['id_estudio' => 'id']],
            [['id_materialsolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Materialsolicitud::className(), 'targetAttribute' => ['id_materialsolicitud' => 'id']],
            [['id_solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitud::className(), 'targetAttribute' => ['id_solicitud' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_solicitud' => 'Id Solicitud',
            'id_materialsolicitud' => 'Id Materialsolicitud',
            'id' => 'ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialsolicitud()
    {
        return $this->hasOne(Materialsolicitud::className(), ['id' => 'id_materialsolicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::className(), ['id' => 'id_solicitud']);
    }
}
