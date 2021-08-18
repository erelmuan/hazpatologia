<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auditoria".
 *
 * @property int $iid
 * @property int $id_usuario
 * @property string $accion
 * @property string $tabla
 * @property string $fecha
 * @property string $hora
 * @property string $ip
 * @property string $informacion_usuario
 * @property string $cambios
 *
 * @property Usuario $usuario
 */
class Auditoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auditoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario'], 'required'],
            [['id_usuario'], 'default', 'value' => null],
            [['id_usuario'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['informacion_usuario', 'cambios'], 'string'],
            [['accion', 'ip'], 'string', 'max' => 15],
            [['tabla'], 'string', 'max' => 25],
            //tomar como refencia en cuanto relaciones
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'id_usuario' => 'Id_usuario',
            'accion' => 'Accion',
            'tabla' => 'Tabla',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'ip' => 'Ip',
            'informacion_usuario' => 'Informacion Usuario',
            'cambios' => 'Cambios',
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
