<?php

namespace app\models;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "biopsia".
 *
 * @property string $topografia
 * @property string $macroscopia
 * @property string $microscopia
 * @property string $ihq
 * @property string $frase
 * @property string $diagnostico
 * @property bool $Inmuno
 * @property bool $firmado
 * @property bool $Pagado
 * @property int $id
 * @property int $id_solicitudbiopsia
 * @property int $id_plantillatopografia
 * @property int $id_plantilladiagnostico
 * @property string $fechalisto
 * @property string $ubicacion
 * @property string $observacion
 * @property int $id_estado
 	* @property int $id_usuario Se registra el usuario con rol de patologo, cuando el mismo pasa de estado pendiente a LISTO.
 * @property Estado $estado
 * @property Plantilladiagnostico $plantilladiagnostico
 * @property Plantillatopografia $plantillatopografia
 * @property Solicitudbiopsia $solicitudbiopsia
 * @property Usuario $usuario
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
            [['topografia', 'macroscopia', 'microscopia', 'ihq', 'diagnostico', 'ubicacion', 'observacion', 'frase'], 'string'],
            [['Inmuno', 'firmado', 'Pagado'], 'boolean'],
            [['id_solicitudbiopsia', 'id_plantillatopografia', 'id_plantilladiagnostico', 'id_estado', 'id_usuario'], 'default', 'value' => null],
            [['id_solicitudbiopsia', 'id_plantillatopografia', 'id_plantilladiagnostico', 'id_estado', 'id_usuario'], 'integer'],
            [['fechalisto'], 'safe'],
            // [['ID_Diagnostico'], 'string', 'max' => 55],
            [['id_solicitudbiopsia'], 'unique'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_plantilladiagnostico'], 'exist', 'skipOnError' => true, 'targetClass' => Plantilladiagnostico::className(), 'targetAttribute' => ['id_plantilladiagnostico' => 'id']],
            [['id_plantillatopografia'], 'exist', 'skipOnError' => true, 'targetClass' => Plantillatopografia::className(), 'targetAttribute' => ['id_plantillatopografia' => 'id']],
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
            'topografia' => 'Topografia',
            'macroscopia' => 'Macroscopia',
            'microscopia' => 'Microscopia',
            'ihq' => 'Ihq',
            // 'ID_Diagnostico' => 'Id  Diagnostico',
            'diagnostico' => 'Diagnostico',
            'Inmuno' => 'Inmuno',
            'firmado' => 'Firmado',
            'Pagado' => 'Pagado',
            'id' => 'ID',
            'id_solicitudbiopsia' => 'Id Solicitudbiopsia',
            'id_plantillatopografia' => 'Id Plantillatopografia',
            'id_plantilladiagnostico' => 'Id Plantilladiagnostico',
            'fechalisto' => 'Fechalisto',
            'ubicacion' => 'Ubicacion',
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
              'attribute' => 'protocolo',
              'value' => 'solicitudbiopsia.protocolo',
              'width' => '50px',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'paciente',
              'width' => '170px',
              'value' => 'getLink',
               'filterInputOptions' => ['class' => 'form-control',  'placeholder' => 'Ingrese DNI o apellido'],
               'format' => 'raw',

          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'medico',
              'width' => '170px',
              'value' => 'getLinkdos',
               'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Ingrese DNI o apellido'],
               'format' => 'raw',

          ],
          [
              //nombre
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fecharealizacion',
              'label'=> 'Fecha de realización',
              'value'=>'solicitudbiopsia.fecharealizacion',
              'format' => ['date', 'd/M/Y'],
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
              //nombre
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fechadeingreso',
              'label'=> 'Fecha de ingreso',
              'value'=>'solicitudbiopsia.fechadeingreso',
              'format' => ['date', 'd/M/Y'],
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
              'value'=>'solicitudbiopsia.paciente.sexo'
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'procedencia',
              'label'=> 'Procedencia',
              'value'=>'solicitudbiopsia.procedencia.nombre'
          ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'topografia',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'macroscopia',
          ],
          // [
          //     'class'=>'\kartik\grid\DataColumn',
          //     'attribute'=>'id_plantilladiagnostico',
          // ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'diagnostico',
          ],
          [
            'attribute' => 'id_estado',
            'label' => 'Estado',
            'value' => 'estado.descripcion',
            'filter'=>$this->estados(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
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
    public function getPlantilladiagnostico()
    {
        return $this->hasOne(Plantilladiagnostico::className(), ['id' => 'id_plantilladiagnostico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlantillatopografia()
    {
        return $this->hasOne(Plantillatopografia::className(), ['id' => 'id_plantillatopografia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudbiopsia()
    {
        return $this->hasOne(Solicitudbiopsia::className(), ['id' => 'id_solicitudbiopsia']);
    }
    public function estados() {
        //PATRON STATE;
        // if (!isset ($this->estado)){
        //   //Estado en pendiente por defecto
        //     $this->id_estado=5;
        // }
        // $namespace="app\models\\";
        // $e= $namespace.$this->estado->descripcion;
        // $estado= new $e();
        return Estado::estadosEstudio();
    }
    /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getUsuario()
		   {
		       return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
		   }
}
