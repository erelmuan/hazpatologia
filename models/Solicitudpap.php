<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "solicitudpap".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_procedencia
 * @property int $id_medico
 * @property int $id_materialsolicitud
 * @property string $fecharealizacion
 * @property string $fechadeingreso
 * @property string $observacion
 * @property int $protocolo
 * @property int $id_tipo_muestra
 * @property bool $pap_previo
 * @property string $resultado_pap_previo
 * @property bool $biopsia_previa
 * @property string $resultado_biopsia_previo
 * @property string $fum
 * @property bool $embarazo_actual
 * @property bool $menopausia
 * @property string $fecha_ult_parto
 * @property int $id_metodo_anticonceptivo
 * @property int $id_cirugia_previa
 * @property bool $tratamiento_radiante
 * @property bool $quimioterapia
 * @property string $datos_clinicos_de_interes  
 * @property bool $colposcopia
 * @property string $conclusion
 * @property int $id_estudio
 * @property int $id_estado
 *
 * @property Pap $pap
 * @property Cirugiaprevia $cirugiaPrevia
 * @property Metodoanticonceptivo $metodoAnticonceptivo
 * @property Tipomuestra $tipoMuestra
 */
class Solicitudpap extends Solicitud
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitudpap';
    }
    public static function labelName()
    {
        return 'solicitud de pap';
    }
    public static function modelo()
    {
        return 'pap';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ///////
            [['id_paciente'], 'required',  'message' => 'El campo paciente no puede estar vacío.'],
            [['id_medico'], 'required',  'message' => 'El campo medico no puede estar vacío.'],
            [['id_paciente', 'id_procedencia', 'id_medico', 'fecharealizacion', 'fechadeingreso', 'id_estudio', 'id_estado'], 'required'], 

            ///////
            [['id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'id_tipo_muestra', 'id_metodo_anticonceptivo', 'id_cirugia_previa', 'id_estudio', 'id_estado'], 'integer'],
            [['fecharealizacion', 'fechadeingreso', 'fecha_ult_parto'], 'safe'],
            [['observacion', 'resultado_pap_previo', 'resultado_biopsia_previo', 'fum', 'datos_clinicos_de_interes', 'conclusion'], 'string'],
            [['pap_previo', 'biopsia_previa', 'embarazo_actual', 'menopausia', 'tratamiento_radiante', 'quimioterapia', 'colposcopia'], 'boolean'],
            [['id_cirugia_previa'], 'exist', 'skipOnError' => true, 'targetClass' => Cirugiaprevia::className(), 'targetAttribute' => ['id_cirugia_previa' => 'id']],
            [['id_metodo_anticonceptivo'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoanticonceptivo::className(), 'targetAttribute' => ['id_metodo_anticonceptivo' => 'id']],
            [['id_tipo_muestra'], 'exist', 'skipOnError' => true, 'targetClass' => Tipomuestra::className(), 'targetAttribute' => ['id_tipo_muestra' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'id_procedencia' => 'Id Procedencia',
            'id_medico' => 'Id Medico',
            'id_materialsolicitud' => 'Id Solicitud material',
            'fecharealizacion' => 'Fecharealizacion',
            'fechadeingreso' => 'Fechadeingreso',
            'observacion' => 'Observacion',
            'protocolo' => 'Protocolo',
            'id_tipo_muestra' => 'Id Tipo Muestra',
            'pap_previo' => 'Pap Previo',
            'resultado_pap_previo' => 'Resultado Pap Previo',
            'biopsia_previa' => 'Biopsia Previa',
            'resultado_biopsia_previo' => 'Resultado Biopsia Previo',
            'fum' => 'Fum',
            'embarazo_actual' => 'Embarazo Actual',
            'menopausia' => 'Menopausia',
            'fecha_ult_parto' => 'Fecha Ult Parto',
            'id_metodo_anticonceptivo' => 'Id Metodo Anticonceptivo',
            'id_cirugia_previa' => 'Id Cirugia Previa',
            'tratamiento_radiante' => 'Tratamiento Radiante',
            'quimioterapia' => 'Quimioterapia',
            'datos_clinicos_de_interes' => 'Datos Clinicos De Interes',
            'colposcopia' => 'Colposcopia',
            'conclusion' => 'Conclusion',
            'id_estudio' => 'Id Estudio',
            'id_estado' => 'Id Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPap()
    {
        return $this->hasOne(Pap::className(), ['id_solicitudpap' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaPrevia()
    {
        return $this->hasOne(Cirugiaprevia::className(), ['id' => 'id_cirugia_previa']);
    }
    public function getCirugiaPrevias() {
        return ArrayHelper::map(Cirugiaprevia::find()->all(), 'id','descripcion');

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoAnticonceptivo()
    {
        return $this->hasOne(Metodoanticonceptivo::className(), ['id' => 'id_metodo_anticonceptivo']);
    }
    public function getMetodoAnticonceptivos() {
        return ArrayHelper::map(Metodoanticonceptivo::find()->all(), 'id','descripcion');

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoMuestra()
    {
        return $this->hasOne(Tipomuestra::className(), ['id' => 'id_tipo_muestra']);
    }
    public function getTipoMuestras() {
        return ArrayHelper::map(Tipomuestra::find()->all(), 'id','descripcion');

    }

}
