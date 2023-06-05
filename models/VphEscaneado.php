<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vph_escaneado".
 *
 * @property int $id
 * @property string $documento
 * @property int $id_pap
 * @property string $observacion
 * @property string $nombre_archivo
 * @property bool $baja_logica
 *
 * @property Pap $pap
 */
 use app\components\behaviors\AuditoriaBehaviors;

class VphEscaneado extends \yii\db\ActiveRecord
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
        return 'vph_escaneado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documento', 'observacion','nombre_archivo'], 'string'],
            [['id_pap'], 'default', 'value' => null],
            [['id_pap'], 'integer'],
            [['baja_logica'], 'boolean'],
            [['documento'], 'unique'],
            [['id_pap'], 'unique'],
            [['id_pap'], 'exist', 'skipOnError' => true, 'targetClass' => Pap::className(), 'targetAttribute' => ['id_pap' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'documento' => 'Documento',
            'id_pap' => 'Id Pap',
            'observacion' => 'Observacion',
            'nombre_archivo' => 'Nombre Archivo',
            'baja_logica' => 'Baja Logica',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPap()
    {
        return $this->hasOne(Pap::className(), ['id' => 'id_pap']);
    }
}
