<?php

namespace app\models;

use Yii;
use app\components\behaviors\AuditoriaBehaviors;

/**
 * This is the model class for table "solicitudbiopsia".
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
 * @property string $sitio_prec_toma
 * @property string $datos_clin_interes
 * @property string $diagnostico_presuntivo
 * @property string $biopsia_anterior_resultado
 * @property int $id_materialginecologico
 * @property int $id_estudio
 * @property int $id_estado
 *
 * @property Biopsia $biopsia
 * @property Paramaterialginecologico $materialginecologico
 */

class Solicitudbiopsia extends Solicitud
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
        return 'solicitudbiopsia';
    }
    public static function labelName()
    {
        return 'solicitud de biopsia';
    }
    public static function modelo()
    {
        return 'biopsia';
    }
    public static function classNameM()
    {
        return 'Solicitudbiopsia';
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
               [['id_paciente', 'id_procedencia', 'id_medico',  'fechadeingreso', 'id_estudio', 'id_estado'], 'required'],
               [['protocolo'], 'required',  'whenClient' => "function (attribute, value) {
               return $('#solicitudbiopsia-protocolo_automatico').val() == 0;
           }"],
               ///////
            //[['id_paciente', 'id_procedencia', 'id_medico', 'id_plantillamaterial', 'id_materialginecologico', 'id_estudio', 'id_estado'], 'default', 'value' => null],
            [['id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'id_materialginecologico', 'id_estudio', 'id_estado'], 'integer'],
            [['fecharealizacion', 'fechadeingreso'], 'safe'],
            [['fechadeingreso','protocolo_automatico'], 'required'],
            [['observacion', 'sitio_prec_toma', 'datos_clin_interes', 'diagnostico_presuntivo', 'biopsia_anterior_resultado'], 'string'],
            [['id_materialginecologico'], 'exist', 'skipOnError' => true, 'targetClass' => Paramaterialginecologico::className(), 'targetAttribute' => ['id_materialginecologico' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
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
            'fecharealizacion' => 'Fecha de realizacion',
            'fechadeingreso' => 'Fecha de ingreso',
            'observacion' => 'Observacion',
            'protocolo' => 'Protocolo',
            'sitio_prec_toma' => 'Sitio Prec Toma',
            'datos_clin_interes' => 'Datos Clin Interes',
            'diagnostico_presuntivo' => 'Diagnostico Presuntivo',
            'biopsia_anterior_resultado' => 'Biopsia Anterior Resultado',
            'id_materialginecologico' => 'Id Materialginecologico',
            'id_estudio' => 'Id Estudio',
            'id_estado' => 'Id Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsia()
    {
        return $this->hasOne(Biopsia::className(), ['id_solicitudbiopsia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialginecologico()
    {
        return $this->hasOne(Paramaterialginecologico::className(), ['id' => 'id_materialginecologico']);
    }
    /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getPaciente()
		   {
		       return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
		   }


}
