<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "viewestudio".
 *
 * @property int $id_solicitud
 * @property int $id_biopsia
 * @property int $id_pap
 * @property string $modelo
 * @property int $protocolo
 * @property string $fechadeingreso
 * @property string $paciente
 * @property string $tipo_documento
 * @property string $num_documento
 * @property string $procedencia
 * @property string $estudio
 * @property string $estado
 * @property string $medico
 */
class Viewestudio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewestudio';
    }
    public static function primaryKey()
    {
    return ['id_solicitud'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_solicitud', 'id_biopsia', 'id_pap', 'protocolo'], 'default', 'value' => null],
            [['id_solicitud', 'id_biopsia', 'id_pap', 'protocolo'], 'integer'],
            [['modelo', 'paciente', 'tipo_documento', 'num_documento', 'estudio', 'estado', 'medico'], 'string'],
            [['fechadeingreso'], 'safe'],
            [['procedencia'], 'string', 'max' => 18],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_solicitud' => 'Id Solicitud',
            'id_biopsia' => 'Id Biopsia',
            'id_pap' => 'Id Pap',
            'modelo' => 'Modelo',
            'protocolo' => 'Protocolo',
            'fechadeingreso' => 'Fechadeingreso',
            'paciente' => 'Paciente',
            'tipo_documento' => 'Tipo Documento',
            'num_documento' => 'Num Documento',
            'procedencia' => 'Procedencia',
            'estudio' => 'Estudio',
            'estado' => 'Estado',
            'medico' => 'Medico',
        ];
    }
}
