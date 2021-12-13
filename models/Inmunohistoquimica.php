<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inmunohistoquimica".
 *
 * @property int $id
 * @property string $microscopia
 * @property string $diagnostico
 * @property string $observacion
 * @property int $id_biopsia
 *
 * @property Biopsia $biopsia
 */
class Inmunohistoquimica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inmunohistoquimica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['microscopia', 'diagnostico', 'observacion'], 'string'],
            [['id_biopsia'], 'default', 'value' => null],
            [['id_biopsia'], 'integer'],
            [['id_biopsia'], 'unique'], 
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
            'microscopia' => 'Microscopia',
            'diagnostico' => 'Diagnostico',
            'observacion' => 'Observacion',
            'id_biopsia' => 'Id Biopsia',
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
