<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property int $nro_cuenta
 * @property string $estado
 * @property string $tipocliente
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido'], 'string'],
            [['nro_cuenta'], 'default', 'value' => null],
            [['nro_cuenta'], 'integer'],
            [['estado'], 'string', 'max' => 10],
            [['tipocliente'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'nro_cuenta' => 'Nro Cuenta',
            'estado' => 'Estado',
            'tipocliente' => 'Tipocliente',
        ];
    }
}
