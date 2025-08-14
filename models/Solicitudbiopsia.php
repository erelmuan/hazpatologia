<?php

namespace app\models;

use Yii;
use app\components\behaviors\AuditoriaBehaviors;
use app\models\patronState\EstadoBase;
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
 * @property Adjuntosolicitud[] $adjuntosolicituds
 * @property int $protocolo
 * @property string $sitio_prec_toma
 * @property string $datos_clin_interes
 * @property string $diagnostico_presuntivo
 * @property string $biopsia_anterior_resultado
 * @property int $id_materialginecologico
 * @property int $id_estudio
 * @property int $id_estado
 * @property int $id_anio_protocolo
 * @property bool $protocolo_automatico
 * @property Medico $medico
 * @property Paciente $paciente
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
               [['id_paciente'], 'required',  'message' => 'El campo paciente no puede estar vacío.'],
               [['id_medico'], 'required',  'message' => 'El campo medico no puede estar vacío.'],
               [['id_procedencia'], 'required',  'message' => 'Procedencia no puede estar vacío.'],
               [['id_paciente', 'id_procedencia', 'id_medico',  'fechadeingreso', 'id_estudio', 'id_estado'], 'required'],
               [['protocolo'], 'required'],
               [['id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'id_materialginecologico', 'id_estudio', 'id_estado'], 'integer'],
               [['fecharealizacion', 'fechadeingreso'], 'safe'],
               [['observacion', 'sitio_prec_toma', 'datos_clin_interes', 'diagnostico_presuntivo', 'biopsia_anterior_resultado'], 'string'],
               [['id_materialginecologico'], 'exist', 'skipOnError' => true, 'targetClass' => Paramaterialginecologico::className(), 'targetAttribute' => ['id_materialginecologico' => 'id']],
               [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
               [['id_medico'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['id_medico' => 'id']],
               [['protocolo'], 'validacion_protocolo', 'on' => ['create', 'update']],
               [['fechadeingreso'] ,'validacion_fechainicio', 'on'=>['create','update']],
               [['fecharealizacion'], 'validacion_fecharealizacion' ,'on'=>['create','update']],
               [['id_estado'], 'validarAdjuntoSiDerivado', 'on' =>['update']]

        ];
    }
    public function validarAdjuntoSiDerivado($attribute)
    {
        // Si id_estado == el valor numérico correspondiente a DERIVADO_LISTO
        if ($this->$attribute == EstadoBase::DERIVADO_LISTO) {
            if (empty($this->adjuntosolicituds) || count($this->adjuntosolicituds) === 0) {
                $this->addError($attribute, 'Debe adjuntar al menos un archivo para poder establecer el estado DERIVADO LISTO.');
            }
        }
    }

      public function validacion_protocolo($attribute, $unusedParams = [])
      {
          $query = Solicitud::find()
              ->where([
                  'protocolo' => $this->protocolo,
                  'id_anio_protocolo' => $this->id_anio_protocolo
              ])
              ->andWhere(['<>', 'id_estado', EstadoBase::ANULADO]); // Excluir estado ANULADO
          // Si estamos en el contexto `update`, se debe excluir el registro actual
          if (!$this->isNewRecord) {
              $query->andWhere(['<>', 'id', $this->id]);
          }
          $solicitud = $query->one();
          if ($solicitud) {
              $this->addError($attribute, 'El número de protocolo ya fue asignado para el año seleccionado.');
          }
      }
      public function validacion_fechainicio($attribute, $unusedParams = []) {
          //valida si el año de la fecha es el mismo al año del protocolo vigente
          $fechaValida = AnioProtocolo::getAnioProtocoloActivo($this->fechadeingreso);
          if (!$fechaValida) {
              $this->addError($attribute, 'No se puede crear la solicitud. La fecha de inicio debe coincidir con un año de protocolo activo.');
          }
      }
      public function validacion_fecharealizacion($attribute, $unusedParams = []){
          if($this->fecharealizacion < $this->fechadeingreso){
            $this->addError($attribute,'La fecha de realizacion debe ser mayor o igual a la fecha de inicio');
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
            'sitio_prec_toma' => 'Sitio Prec Toma',
            'datos_clin_interes' => 'Datos Clin Interes',
            'diagnostico_presuntivo' => 'Diagnostico Presuntivo',
            'biopsia_anterior_resultado' => 'Biopsia Anterior Resultado',
            'id_materialginecologico' => 'Id Materialginecologico',
            'id_estudio' => 'Id Estudio',
            'id_estado' => 'Estado',
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
      public function getMedico()
      {
          return $this->hasOne(Medico::className(), ['id' => 'id_medico']);
      }

   	  /**
   	  * @return \yii\db\ActiveQuery
   		  */
      public function getPaciente()
   	   {
  	      return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
  	   }
       /**
        * @return \yii\db\ActiveQuery
        */
       public function getAdjuntosolicituds()
       {
           return $this->hasMany(Adjuntosolicitud::className(), ['id_solicitud' => 'id']);
       }

}
