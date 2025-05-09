<?php

namespace app\models;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "pap".
 *
 * @property string $descripcion
 * @property string $calificacion
 * @property int $eosinofilas
 * @property int $cianofilas
 * @property int $intermedias
 * @property int $parabasales
 * @property int $indicepicnotico
 * @property string $indicedemaduracion
 * @property string $plegamiento
 * @property string $agrupamiento
 * @property string $leucocitos
 * @property string $hematies
 * @property string $hormonal
 * @property string $flora
 * @property string $histiocitos
 * @property string $detritus
 * @property string $citolisis
 * @property string $aspecto
 * @property string $pavimentosas
 * @property string $glandulares
 * @property string $diagnostico
 * @property string $observaciones
* @property bool $firmado
 * @property bool $vph
 * @property string $topografia
 * @property int $cantidad
 * @property int $id
 * @property int $id_solicitudpap
 * @property string $fechalisto
 * @property int $id_estado
 * @property string $frase
 * @property Estado $estado
 * @property Solicitudpap $solicitudpap
 * @property Solicitudpap $solicitudpap0
 * @property Usuario $usuario
 * @property papcie10[] $papcie10s
 * @property VphEscaneado $vphEscaneado
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Pap extends \yii\db\ActiveRecord
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
        return 'pap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'calificacion', 'hormonal', 'flora', 'aspecto', 'pavimentosas', 'glandulares', 'diagnostico', 'observaciones', 'topografia', 'frase'], 'string'],
            [['eosinofilas', 'cianofilas', 'intermedias', 'parabasales', 'indicepicnotico', 'cantidad', 'id_solicitudpap', 'id_estado', 'id_usuario' ], 'default', 'value' => null],
            [['eosinofilas', 'cianofilas', 'intermedias', 'parabasales', 'indicepicnotico', 'cantidad', 'id_solicitudpap',  'id_estado', 'id_usuario'], 'integer'],
            [['firmado', 'vph'], 'boolean'],
            [['fechalisto'], 'safe'],
            [[ 'indicedemaduracion'], 'string', 'max' => 8],
            [['plegamiento', 'agrupamiento', 'leucocitos', 'hematies', 'histiocitos', 'detritus', 'citolisis'], 'string', 'max' => 4],
            [['id_solicitudpap'], 'unique'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_solicitudpap'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudpap::className(), 'targetAttribute' => ['id_solicitudpap' => 'id']],
            [['id_solicitudpap'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudpap::className(), 'targetAttribute' => ['id_solicitudpap' => 'id']],
           [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'descripcion' => 'Descripcion',
            'calificacion' => 'Calificacion',
            'eosinofilas' => 'Eosinofilas',
            'cianofilas' => 'Cianofilas',
            'intermedias' => 'Intermedias',
            'parabasales' => 'Parabasales',
            'indicepicnotico' => 'Indicepicnotico',
            'indicedemaduracion' => 'Indicedemaduracion',
            'plegamiento' => 'Plegamiento',
            'agrupamiento' => 'Agrupamiento',
            'leucocitos' => 'Leucocitos',
            'hematies' => 'Hematies',
            'hormonal' => 'Hormonal',
            'flora' => 'Flora',
            'histiocitos' => 'Histiocitos',
            'detritus' => 'Detritus',
            'citolisis' => 'Citolisis',
            'aspecto' => 'Aspecto',
            'pavimentosas' => 'Pavimentosas',
            'glandulares' => 'Glandulares',
            'diagnostico' => 'Diagnostico',
            'observaciones' => 'Observaciones',
            'firmado' => 'Firmado',
            'vph' => 'vph',
            'topografia' => 'Topografia',
            'cantidad' => 'Cantidad',
            'id' => 'ID',
            'id_solicitudpap' => 'Id Solicitudpap',
            'fechalisto' => 'Fechalisto',
            'id_estado' => 'Estado',
            'frase' => 'Frase',
            'fecharealizacion' => 'Fecha de realizacion',
            'fechadeingreso' => 'Fecha de ingreso',
            'usuario'=>'Patólogo'


        ];
    }
    public function attributeColumns()
    {


        return [
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'id',
          ],
          [
              'attribute' => 'protocolo',
              'value' => 'solicitudpap.protocolo',
              'width' => '50px',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'paciente',
              'width' => '170px',
              'value' => 'solicitudpap.pacienteurl',
               'filterInputOptions' => [ 'class' => 'form-control','placeholder' => 'DNI o apellido'],
               'format' => 'raw',
               'contentOptions' => ['style' => 'white-space: nowrap;'],
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'medico',
              'width' => '185px',
              'value' => 'solicitudpap.medicourl',
               'filterInputOptions' => ['class' => 'form-control' ,'placeholder' => 'matricula o apellido'],
               'format' => 'raw',
               'contentOptions' => ['style' => 'white-space: nowrap;'],
          ],
          [
              //nombre
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fecharealizacion',
              'label'=> 'Fecha de realización',
              'value'=>'solicitudpap.fecharealizacion',
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
              //nombre
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fechadeingreso',
              'label'=> 'Fecha de ingreso',
              'value'=>'solicitudpap.fechadeingreso',
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
              'value'=>'solicitudpap.paciente.sexo'
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'procedencia',
              'label'=> 'Procedencia',
              'value'=>'solicitudpap.procedencia.nombre'
          ],

          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'flora',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'aspecto',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'pavimentosas',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'glandulares',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'diagnostico',
          ],
          [
              'class'=>'\kartik\grid\BooleanColumn',
              'attribute'=>'vph',
              'trueLabel' => 'Sí',
              'falseLabel' => 'No',
               'trueIcon' => '<span class="label label-success" ">Sí</span>',
               'falseIcon' => '<span class="label label-danger" ">No</span>',
               'filterInputOptions' => [
                 'class' => 'form-control',
                  'prompt' => 'Seleccionar'
               ],
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
            'label'=> 'Patólogo',
            'value'=>'usuario.nombre'
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
    public function getSolicitudpap()
     {
        return $this->hasOne(Solicitudpap::className(), ['id' => 'id_solicitudpap']);
     }

      /**
    	   * @return \yii\db\ActiveQuery
      */
    public function getUsuario()
    	 {
         return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
       }


    public function estados() {
        //PATRON STATE;
        // if (!isset ($this->estado)){
        //   //Estado pendiente por defecto
        //   $this->id_estado=5;
        // }
        // $namespace="app\models\\";
        // $e= $namespace.$this->estado->descripcion;
        // $estado= new $e();
        return Estado::estadosEstudio();
    }
    public function estadoSinRestriccion() {
        return Estado::estadosEstudioAdminYpat();
    }
    /**
      * @return \yii\db\ActiveQuery
      */
     public function getPapcie10s()
     {
         return $this->hasMany(papcie10::className(), ['id_pap' => 'id']);
     }
     public function getPapcie10()
    {
      return $this->hasOne(Papcie10::className(), ['id_pap' => 'id']);
    }

     /**
      * @return \yii\db\ActiveQuery
      */
     public function getVphEscaneado()
     {
         return $this->hasOne(VphEscaneado::className(), ['id_pap' => 'id']);
     }
}
