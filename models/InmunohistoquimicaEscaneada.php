<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inmunohistoquimica_escaneada".
 *
 * @property int $id
 * @property string $documento
 * @property int $id_biopsia
 * @property string $observacion
 *
 * @property Biopsia $biopsia
 */
 use app\components\behaviors\AuditoriaBehaviors;

class InmunohistoquimicaEscaneada extends \yii\db\ActiveRecord
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
        return 'inmunohistoquimica_escaneada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['documento', 'observacion'], 'string'],
             [['observacion'], 'string'],
            [['id_biopsia'], 'default', 'value' => null],
            [['id_biopsia'], 'integer'],
            [['id_biopsia'], 'unique'],
            [['documento'], 'unique'],
            [['documento'], 'file', 'skipOnEmpty' => true, 'extensions'=>'pdf'],
            [['id_biopsia'], 'exist', 'skipOnError' => true, 'targetClass' => Biopsia::className(), 'targetAttribute' => ['id_biopsia' => 'id']],
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
            'id_biopsia' => 'Id Biopsia',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsia()
    {
        return $this->hasOne(Biopsia::className(), ['id' => 'id_biopsia']);
    }
}
