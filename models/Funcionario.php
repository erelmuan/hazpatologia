<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "funcionario".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property string $cargo
 * @property string $departamento
 * @property string $fecha_ing
 */
class Funcionario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'funcionario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido'], 'string'],
            [['fecha_ing'], 'safe'],
            [['cargo', 'departamento'], 'string', 'max' => 25],
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
            'cargo' => 'Cargo',
            'departamento' => 'Departamento',
            'fecha_ing' => 'Fecha Ing',
        ];
    }
}
