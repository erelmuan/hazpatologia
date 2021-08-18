<?php

namespace app\models;

use Yii;
 
/**
 * This is the model class for table "funcionarios".
 *
 * @property int $numero
 * @property string $nombres
 * @property string $apellidos
 * @property string $direccion
 * @property string $telefono
 * @property string $fecha_nacim
 * @property string $cargo
 * @property string $departamento
 * @property string $fecha_ing
 */
class Funcionarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funcionarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacim', 'fecha_ing'], 'safe'],
            [['nombres', 'apellidos'], 'string', 'max' => 50],
            [['direccion'], 'string', 'max' => 200],
            [['telefono'], 'string', 'max' => 20],
            [['cargo', 'departamento'], 'string', 'max' => 25],
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
            'cargo' => 'Cargo',
            'departamento' => 'Departamento',
            'fecha_ing' => 'Fecha Ing',
        ];
    }
}
