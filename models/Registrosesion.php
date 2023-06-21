<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registrosesion".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $inicio_sesion
 * @property string $ip
 * @property string $informacion_usuario
 * @property string $cookie
 * @property string $cierre_sesion
 *
 * @property Usuario $usuario
 */
class Registrosesion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registrosesion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'inicio_sesion'], 'required'],
            [['id_usuario'], 'default', 'value' => null],
            [['id_usuario'], 'integer'],
            [['inicio_sesion', 'cierre_sesion'], 'safe'],
            [['ip', 'informacion_usuario', 'cookie'], 'string'],
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
            'id_usuario' => 'Id Usuario',
            'inicio_sesion' => 'Inicio Sesion',
            'ip' => 'Ip',
            'informacion_usuario' => 'Informacion Usuario',
            'cookie' => 'Cookie',
            'cierre_sesion' => 'Cierre Sesion',
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
