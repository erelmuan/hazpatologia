<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "viewestudio".
 *
 * @property int $id_solicitud
 * @property int $id_estudio_modelo
 * @property string $modelo
 * @property int $protocolo
 * @property string $fechadeingreso
 * @property string $pacientenomb
 * @property string $pacienteapel
 * @property string $tipo_documento
 * @property string $num_documento
 * @property string $procedencia
 * @property string $estudio
 * @property string $estado
 * @property string $mediconomb
 * @property string $medicoeapel
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
            [['id_solicitud', 'id_estudio_modelo', 'protocolo'], 'default', 'value' => null],
            [['id_solicitud', 'id_estudio_modelo', 'protocolo'], 'integer'],
            [['modelo', 'pacientenomb', 'pacienteapel', 'tipo_documento', 'num_documento', 'estudio', 'estado', 'mediconomb', 'medicoeapel'], 'string'],
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
            'id_estudio_modelo' => 'Id Estudio Modelo',
            'modelo' => 'Modelo',
            'protocolo' => 'Protocolo',
            'fechadeingreso' => 'Fechadeingreso',
            'pacientenomb' => 'Pacientenomb',
            'pacienteapel' => 'Pacienteapel',
            'tipo_documento' => 'Tipo Documento',
            'num_documento' => 'Num Documento',
            'procedencia' => 'Procedencia',
            'estudio' => 'Estudio',
            'estado' => 'Estado',
            'mediconomb' => 'Mediconomb',
            'medicoeapel' => 'Medicoeapel',
        ];
    }
}
