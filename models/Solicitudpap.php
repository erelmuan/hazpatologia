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
 * @property int $id_anio_protocolo
* @property bool $protocolo_automatico
 * @property Pap $pap
 * @property Cirugiaprevia $cirugiaPrevia
 * @property Metodoanticonceptivo $metodoAnticonceptivo
 * @property Tipomuestra $tipoMuestra

 */
 use app\components\behaviors\AuditoriaBehaviors;


class Solicitudpap extends Solicitud
{
  public function behaviors()
  {

    return [

           'AuditoriaBehaviors'=>[
                  'class'=>AuditoriaBehaviors::className(),
                ],
      ];
 }

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
    public static function classNameM()
    {
        return 'Solicitudpap';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente'], 'required',  'message' => 'El campo paciente no puede estar vacío.'],
            [['id_medico'], 'required',  'message' => 'El campo medico no puede estar vacío.'],
            [['id_procedencia'], 'required',  'message' => 'Procedencia no puede estar vacío.'],

        //     [['protocolo'], 'required',  'whenClient' => "function (attribute, value) {
        //     return $('#solicitudpap-protocolo_automatico').val() == 0;
        // }"],
         // [['protocolo','protocolo_automatico'], 'required'],
         [['protocolo'], 'required'],

            [['id_paciente','id_medico',  'fechadeingreso', 'id_estudio', 'id_estado'], 'required'],
            [['id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'id_tipo_muestra', 'id_metodo_anticonceptivo', 'id_cirugia_previa', 'id_estudio', 'id_estado','protocolo'], 'integer'],
            [['fecharealizacion', 'fechadeingreso', 'fecha_ult_parto'], 'safe'],
            [['observacion', 'resultado_pap_previo', 'resultado_biopsia_previo', 'fum', 'datos_clinicos_de_interes', 'conclusion'], 'string'],
            [['pap_previo', 'biopsia_previa', 'embarazo_actual', 'menopausia', 'tratamiento_radiante', 'quimioterapia', 'colposcopia', 'protocolo_automatico'], 'boolean'],
            [['id_cirugia_previa'], 'exist', 'skipOnError' => true, 'targetClass' => Cirugiaprevia::className(), 'targetAttribute' => ['id_cirugia_previa' => 'id']],
            [['id_metodo_anticonceptivo'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoanticonceptivo::className(), 'targetAttribute' => ['id_metodo_anticonceptivo' => 'id']],
            [['id_tipo_muestra'], 'exist', 'skipOnError' => true, 'targetClass' => Tipomuestra::className(), 'targetAttribute' => ['id_tipo_muestra' => 'id']],
             [ 'protocolo', 'validacion_protocolo_anio'],
            // [['id_anio_protocolo', 'protocolo',],  'compare','message' => 'El numero de protocolo ya fue asignado para el año seleccionado','targetAttribute' => ['id_anio_protocolo', 'protocolo']],
            [['id_anio_protocolo', 'protocolo'], 'unique','message' => 'El numero de protocolo ya fue asignado para el año seleccionado','targetAttribute' => ['id_anio_protocolo', 'protocolo']],

        ];
    }
    public function validacion_protocolo_anio($attribute, $params){
        // add custom validation
        $solbiopsia=Solicitudbiopsia::find()->where(['protocolo' =>$this->protocolo,'id_anio_protocolo' => $this->id_anio_protocolo])->one();
        if(isset($solbiopsia)){
          $this->addError('protocolo','El numero de protocolo ya fue asignado para el año seleccionado');

        }
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
            'fecharealizacion' => 'Fecha de realizacion',
            'fechadeingreso' => 'Fecha de ingreso',
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
        return ArrayHelper::map(Tipomuestra::find()->orderBy(['id' => SORT_ASC])->all(), 'id','descripcion');

    }

}
