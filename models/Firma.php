<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "firma".
 *
 * @property int $id
 * @property string $imagen
 * @property int $id_usuario
 *
 * @property Usuario $usuario
 */
class Firma extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'firma';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario'], 'integer'],
            [['id_usuario'], 'required',  'message' => 'El campo usuario no puede estar vacío.'],
            [['imagen'], 'required',  'message' => 'El campo imagen no puede estar vacío.'],
            [['id_usuario'], 'unique'],

            [['imagen'], 'string', 'max' => 75],
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
            'imagen' => 'Imagen',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
