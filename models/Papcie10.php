<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "papcie10".
 *
 * @property int $id
 * @property bool $verificado
 * @property int $id_usuario
 * @property int $id_pap
 * @property int $id_estudio
 *
 * @property Pap $pap
 */
class Papcie10 extends Estudiocie10
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'papcie10';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'id_usuario', 'id_pap', 'id_estudio'], 'default', 'value' => null],
            [[ 'id_usuario', 'id_pap', 'id_estudio'], 'integer'],
            [['verificado'], 'boolean'],
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
            'verificado' => 'Verificado',
            'id_usuario' => 'Id Usuario',
            'id_pap' => 'Id Pap',
            'id_estudio' => 'Id Estudio',
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
