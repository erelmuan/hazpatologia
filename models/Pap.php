<?php

namespace app\models;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "pap".
 *
 * @property string $id_calificacion
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
 * @property bool $Informado
 * @property bool $Pagado
 * @property string $topografia
 * @property int $cantidad
 * @property int $id
 * @property int $id_solicitudpap
 * @property int $id_plantilladiagnostico
 * @property string $fechalisto
 * @property string $observacion
 * @property int $id_estado
 * @property string $frase

 * @property Estado $estado
 * @property Plantilladiagnostico $plantilladiagnostico
 * @property Solicitudpap $solicitudpap
 * @property Solicitudpap $solicitudpap0
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
            [['descripcion', 'calificacion', 'hormonal', 'flora', 'aspecto', 'pavimentosas', 'glandulares', 'diagnostico', 'observaciones', 'topografia', 'observacion','frase'], 'string'],
            [['eosinofilas', 'cianofilas', 'intermedias', 'parabasales', 'indicepicnotico', 'cantidad', 'id_solicitudpap', 'id_plantilladiagnostico', 'id_estado'], 'default', 'value' => null],
            [['eosinofilas', 'cianofilas', 'intermedias', 'parabasales', 'indicepicnotico', 'cantidad', 'id_solicitudpap', 'id_plantilladiagnostico', 'id_estado'], 'integer'],
            [['Informado', 'Pagado'], 'boolean'],
            [['fechalisto'], 'safe'],
            [['id_calificacion', 'indicedemaduracion'], 'string', 'max' => 8],
            [['plegamiento', 'agrupamiento', 'leucocitos', 'hematies', 'histiocitos', 'detritus', 'citolisis'], 'string', 'max' => 4],
            [['id_solicitudpap'], 'unique'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_plantilladiagnostico'], 'exist', 'skipOnError' => true, 'targetClass' => Plantilladiagnostico::className(), 'targetAttribute' => ['id_plantilladiagnostico' => 'id']],
            [['id_solicitudpap'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudpap::className(), 'targetAttribute' => ['id_solicitudpap' => 'id']],
            [['id_solicitudpap'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitudpap::className(), 'targetAttribute' => ['id_solicitudpap' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_calificacion' => 'Id Calificacion',
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
            'Informado' => 'Informado',
            'Pagado' => 'Pagado',
            'topografia' => 'Topografia',
            'cantidad' => 'Cantidad',
            'id' => 'ID',
            'id_solicitudpap' => 'Id Solicitudpap',
            'id_plantilladiagnostico' => 'Id Plantilladiagnostico',
            'fechalisto' => 'Fechalisto',
            'observacion' => 'Observacion',
            'id_estado' => 'Estado',
            'frase' => 'Frase',

        ];
    }
    public function attributeColumns()
    {


        return [
          [
              'attribute' => 'protocolo',
              'value' => 'solicitudpap.protocolo',
              'width' => '50px',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'paciente',
              'width' => '170px',
              'value' => 'getlink',
               'filterInputOptions' => ['placeholder' => 'Ingrese DNI o apellido'],
               'format' => 'raw',

          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'medico',
              'width' => '170px',
              'value' => 'getLinkdos',
               'filterInputOptions' => ['placeholder' => 'Ingrese DNI o apellido'],
               'format' => 'raw',

          ],
          [
              //nombre
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fecharealizacion',
              'label'=> 'Fecha de realización',
              'value'=>'solicitudpap.fecharealizacion',
              'format' => ['date', 'd/M/Y'],

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
    public function getSolicitudpap()
    {
        return $this->hasOne(Solicitudpap::className(), ['id' => 'id_solicitudpap']);
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


}
