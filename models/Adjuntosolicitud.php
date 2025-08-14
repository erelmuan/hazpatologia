<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adjuntosolicitud".
 *
 * @property int $id
 * @property string $nombre_archivo
 * @property string $nombre_asignado
 * @property bool $baja_logica
 * @property int $id_solicitud
 * @property string $observacion
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Adjuntosolicitud extends \yii\db\ActiveRecord
{

    public function behaviors()
    {

      return array(
             'AuditoriaBehaviors'=>array(
                    'class'=>AuditoriaBehaviors::className(),
                    ),
        );
   }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjuntosolicitud';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_archivo', 'nombre_asignado', 'baja_logica', 'id_solicitud'], 'required'],
            [['nombre_archivo', 'nombre_asignado', 'observacion'], 'string'],
            [['baja_logica'], 'boolean'],
            [['id_solicitud'], 'default', 'value' => null],
            [['id_solicitud'], 'integer'],
            [['nombre_archivo', 'id_solicitud'], 'unique', 'targetAttribute' => ['nombre_archivo', 'id_solicitud']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_archivo' => 'Nombre del Archivo',
            'nombre_asignado' => 'Nombre asignado',
            'baja_logica' => 'Baja Logica',
            'id_solicitud' => 'Id Solicitud',
            'observacion' => 'Observacion',
        ];
    }
}
