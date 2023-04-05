<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "biopsiacie10".
 *
 * @property int $id
 * @property int $id_cie10
 * @property bool $verificado
 * @property int $id_usuario
 * @property int $id_biopsia
 * @property int $id_estudio
 *
 * @property Biopsia $biopsia
 */
class Biopsiacie10 extends Estudiocie10
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biopsiacie10';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cie10', 'id_usuario', 'id_biopsia', 'id_estudio'], 'default', 'value' => null],
            [['id_cie10', 'id_usuario', 'id_biopsia', 'id_estudio'], 'integer'],
            [['verificado'], 'boolean'],
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
            'id_cie10' => 'Id Cie10',
            'verificado' => 'Verificado',
            'id_usuario' => 'Id Usuario',
            'id_biopsia' => 'Id Biopsia',
            'id_estudio' => 'Id Estudio',
        ];
    }
    public function getcie10s() {
        return ArrayHelper::map(Cie10::find()->all(), 'id','descripcion','codigo');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsia()
    {
        return $this->hasOne(Biopsia::className(), ['id' => 'id_biopsia']);
    }
}
