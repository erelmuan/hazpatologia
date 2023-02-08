<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudiocie10".
 *
 * @property int $id
 * @property int $id_cie10
 * @property bool $verificado
 * @property int $id_usuario
 * @property int $id_estudio
 *
 * @property Cie10 $cie10
 * @property Estudio $estudio
 * @property Usuario $usuario
 */
class Estudiocie10 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estudiocie10';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cie10', 'id_usuario', 'id_estudio'], 'default', 'value' => null],
            [['id_cie10', 'id_usuario', 'id_estudio'], 'integer'],
            [['verificado'], 'boolean'],
            [['id_cie10'], 'exist', 'skipOnError' => true, 'targetClass' => Cie10::className(), 'targetAttribute' => ['id_cie10' => 'id']],
            [['id_estudio'], 'exist', 'skipOnError' => true, 'targetClass' => Estudio::className(), 'targetAttribute' => ['id_estudio' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
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
            'id_estudio' => 'Id Estudio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getcie10()
    {
        return $this->hasOne(Cie10::className(), ['id' => 'id_cie10']);
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
