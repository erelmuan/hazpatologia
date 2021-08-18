<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property int $numero
 * @property string $nombres
 * @property string $apellidos
 * @property string $direccion
 * @property string $telefono
 * @property string $fecha_nacim
 * @property int $nro_cuenta
 * @property string $estado
 * @property string $tipocliente
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacim'], 'safe'],
            [['nro_cuenta'], 'default', 'value' => null],
            [['nro_cuenta'], 'integer'],
            [['nombres', 'apellidos'], 'string', 'max' => 50],
            [['direccion'], 'string', 'max' => 200],
            [['telefono'], 'string', 'max' => 20],
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
            'numero' => 'Numero',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'fecha_nacim' => 'Fecha Nacim',
            'nro_cuenta' => 'Nro Cuenta',
            'estado' => 'Estado',
            'tipocliente' => 'Tipocliente',
        ];
    }
}
