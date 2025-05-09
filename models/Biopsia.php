<?php

namespace app\models;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "biopsia".
 *
 * @property string $material
 * @property string $macroscopia
 * @property string $microscopia
 * @property bool $ihq
 * @property string $frase
 * @property int $id_usuario Se registra el usuario con rol de patologo, cuando el mismo pasa de estado pendiente a LISTO.
 * @property string $diagnostico
 * @property bool $firmado
 * @property bool $Pagado
 * @property int $id
 * @property int $id_solicitudbiopsia
 * @property int $id_plantillamaterial
 * @property string $fechalisto
 * @property string $observacion
 * @property int $id_estado
 	* @property int $id_usuario Se registra el usuario con rol de patologo, cuando el mismo pasa de estado pendiente a LISTO.
 * @property Estado $estado
 * @property Plantillamaterial $plantillamaterial
 * @property Solicitudbiopsia $solicitudbiopsia
 * @property Usuario $usuario
 * @property biopsiacie10[] $biopsiacie10s
 * @property Inmunohistoquimica $inmunohistoquimica
* @property InmunohistoquimicaEscaneada $inmunohistoquimicaEscaneada
 */
use app\components\behaviors\AuditoriaBehaviors;

class Biopsia extends \yii\db\ActiveRecord
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
        return 'biopsia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['material', 'macroscopia', 'microscopia',  'diagnostico',  'observacion', 'frase'], 'string'],
           [['ihq', 'firmado', 'Pagado'], 'boolean'],
           [['id_solicitudbiopsia', 'id_plantillamaterial',  'id_estado', 'id_usuario'], 'default', 'value' => null],
            [['id_solicitudbiopsia', 'id_plantillamaterial', 'id_estado', 'id_usuario'], 'integer'],
            [['fechalisto'], 'safe'],
            // [['ID_Diagnostico'], 'string', 'max' => 55],
            [['id_solicitudbiopsia'], 'unique'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_plantillamaterial'], 'exist', 'skipOnError' => true, 'targetClass' => Plantillamaterial::className(), 'targetAttribute' => ['id_plantillamaterial' => 'id']],
            [['id_solicitudbiopsia'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudbiopsia::className(), 'targetAttribute' => ['id_solicitudbiopsia' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'material' => 'Material',
            'macroscopia' => 'Macroscopia',
            'microscopia' => 'Microscopia',
            'ihq' => 'Ihq',
            // 'ID_Diagnostico' => 'Id  Diagnostico',
            'diagnostico' => 'Diagnostico',
            'firmado' => 'Firmado',
            'Pagado' => 'Pagado',
            'usuario' => 'Patólogo',
            'id' => 'ID',
            'id_solicitudbiopsia' => 'Id Solicitudbiopsia',
            'id_plantillamaterial' => 'Id Plantillamaterial',
            'fechalisto' => 'Fechalisto',
            'observacion' => 'Observacion',
            'id_estado' => 'Estado',
            'frase' => 'Frase',
            'fecharealizacion' => 'Fecha de realizacion',
            'fechadeingreso' => 'Fecha de ingreso',


        ];
    }
    public function attributeColumns()
    {


        return [
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'id',
              'contentOptions'=>['style'=>'width:80px;'] ,

          ],
          [
              'attribute' => 'protocolo',
              'value' => 'solicitudbiopsia.protocolo',
              'width' => '50px',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'paciente',
              'width' => '170px',
              'value' => 'solicitudbiopsia.pacienteurl',
               'filterInputOptions' => ['class' => 'form-control',  'placeholder' => 'DNI o apellido'],
               'format' => 'raw',
               'contentOptions' => ['style' => 'white-space: nowrap;'],
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'medico',
              'width' => '185px',
              'value' => 'solicitudbiopsia.medicourl',
               'filterInputOptions' => ['class' => 'form-control','placeholder' => 'matricula o apellido'],
               'format' => 'raw',
               'contentOptions' => ['style' => 'white-space: nowrap;'],
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fecharealizacion',
              'label'=> 'Fecha de realización',
              'value'=>'solicitudbiopsia.fecharealizacion',
              'format' => ['date', 'php:d/m/Y'],
              'filterInputOptions' => [
                  'id' => 'fecha1',
                  'class' => 'form-control',
                  'autoclose'=>true,
                  'format' => 'dd/mm/yyyy',
                  'startView' => 'year',
                  'placeholder' => 'd/m/aaaa'

              ]

          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fechadeingreso',
              'label'=> 'Fecha de ingreso',
              'value'=>'solicitudbiopsia.fechadeingreso',
              'format' => ['date', 'php:d/m/Y'],
              'filterInputOptions' => [
                  'id' => 'fecha1',
                  'class' => 'form-control',
                  'autoclose'=>true,
                  'format' => 'dd/mm/yyyy',
                  'startView' => 'year',
                  'placeholder' => 'd/m/aaaa'
              ]

          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'sexo',
              'label'=> 'Sexo',
              'value'=>'solicitudbiopsia.paciente.sexo',

          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'procedencia',
              'label'=> 'Procedencia',
              'value'=>'solicitudbiopsia.procedencia.nombre'
          ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'material',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'macroscopia',
          ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'diagnostico',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute' => 'estado',
            'label' => 'Estado',
            'value' => 'estado.descripcion',

        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'usuario',
            'value'=>'usuario.nombre'
        ],
        [
            'class'=>'\kartik\grid\BooleanColumn',
            'attribute'=>'ihq',
            'trueLabel' => 'Sí',
            'falseLabel' => 'No',
             'trueIcon' => '<span class="label label-success" ">Sí</span>',
             'falseIcon' => '<span class="label label-danger" ">No</span>',
             'filterInputOptions' => [
               'class' => 'form-control',
                'prompt' => 'Seleccionar'
             ],
        ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'id_estado']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlantillamaterial()
    {
        return $this->hasOne(Plantillamaterial::className(), ['id' => 'id_plantillamaterial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudbiopsia()
    {
        return $this->hasOne(Solicitudbiopsia::className(), ['id' => 'id_solicitudbiopsia']);
    }
    public function estados() {
        return Estado::estadosEstudio();
    }

      /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getUsuario()
		   {
		       return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
		   }

     		/**
     	   * @return \yii\db\ActiveQuery
    	  */
      public function getInmunohistoquimica()
      {
        return $this->hasOne(Inmunohistoquimica::className(), ['id_biopsia' => 'id']);
     }
     /**
   		 * @return \yii\db\ActiveQuery
       */
	   public function getInmunohistoquimicaEscaneada()
	   {
	       return $this->hasOne(InmunohistoquimicaEscaneada::className(), ['id_biopsia' => 'id']);
	   }
         /**
     * @return \yii\db\ActiveQuery
     */
     public function getBiopsiacie10s()
    {
         return $this->hasMany(Biopsiacie10::className(), ['id_biopsia' => 'id']);
    }
    public function getBiopsiacie10()
   {
     return $this->hasOne(Biopsiacie10::className(), ['id_biopsia' => 'id']);
   }


  }
