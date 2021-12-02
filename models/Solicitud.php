<?php

namespace app\models;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "solicitud".
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
 * @property int $id_estudio
 * @property int $id_estado
 *
 * @property Estado $estado
 * @property Estudio $estudio
 * @property Medico $medico
 * @property Paciente $paciente
 * @property Materialsolicitud $materialsolicitud
 * @property Procedencia $procedencia
 */
class Solicitud extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitud';
    }
    public static function modelo()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_procedencia', 'id_medico', 'fecharealizacion', 'fechadeingreso', 'id_estudio', 'id_estado'], 'required'],
            [['id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'id_estudio', 'id_estado'], 'integer'],
            [['fecharealizacion', 'fechadeingreso'], 'safe'],
            [['fechadeingreso'], 'required'],
            [['observacion'], 'string'],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_estudio'], 'exist', 'skipOnError' => true, 'targetClass' => Estudio::className(), 'targetAttribute' => ['id_estudio' => 'id']],
            [['id_medico'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['id_medico' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_materialsolicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Materialsolicitud::className(), 'targetAttribute' => ['id_materialsolicitud' => 'id']],
            [['id_procedencia'], 'exist', 'skipOnError' => true, 'targetClass' => Procedencia::className(), 'targetAttribute' => ['id_procedencia' => 'id']],
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
            'id_procedencia' => 'Procedencia',
            'id_medico' => 'Id Medico',
            'id_materialsolicitud' => 'Id materialsolicitud',
            'fecharealizacion' => 'Fecha de realizacion',
            'fechadeingreso' => 'Fecha de ingreso',
            'observacion' => 'Observacion',
            'protocolo' => 'Protocolo',
            'id_estudio' => 'Estudio',
            'id_estado' => 'Estado',
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
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'protocolo',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'fechadeingreso',
              'format' => ['date', 'd/M/Y'],
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'paciente',
                'width' => '170px',
                'value' => 'getLink',
                 'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Ingrese DNI o apellido'],
                 'format' => 'raw',


            ],
        //   [
        //       'class'=>'\kartik\grid\DataColumn',
        //       'attribute'=>'procedencia',
        //       'label'=> 'Procedencia',
        //       'value'=>'procedencia.nombre'
        //   ],
          [
            'attribute' => 'id_procedencia',
            'label' => 'Procedencia',
            'value' => 'procedencia.nombre',

            'filter'=>ArrayHelper::map(Procedencia::find()->all(), 'id','nombre'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
         ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'medico',
              'width' => '170px',
              'value' => 'getLinkdos',
               'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Ingrese DNI o apellido'],
               'format' => 'raw',

          ],

          // [
              // 'class'=>'\kartik\grid\DataColumn',
              // 'attribute'=>'idplantillamaterialb',
          // ],
          // [
              // 'class'=>'\kartik\grid\DataColumn',
              // 'attribute'=>'fecharealizacion',
          // ],

        //  [
        //       'class'=>'\kartik\grid\DataColumn',
        //       'attribute'=>'id_estudio',
        //       'label'=> 'Estudio',
        //       'value'=>'estudio.descripcion',
        //   ],
          [
            'attribute' => 'id_estudio',
            'label' => 'Estudio',
            'value' => 'estudio.descripcion',

            'filter'=>ArrayHelper::map(Estudio::find()->all(), 'id','descripcion'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],

        [
            'attribute' => 'id_estado',
            'label' => 'Estado',
            'value' => 'estado.descripcion',

            'filter'=>ArrayHelper::map(Estado::find()->all(), 'id','descripcion'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
          [
            //nombre
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'fecharealizacion',
            'label'=> 'Fecha de realización',
            'value'=>'fecharealizacion',
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
              'attribute'=>'observacion',
          ],
          // [
              // 'class'=>'\kartik\grid\DataColumn',
              // 'attribute'=>'informe',
          // ],

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
    public function getEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'id_estudio']);
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
    public function getMaterialsolicitud()
    {
        return $this->hasOne(Materialsolicitud::className(), ['id' => 'id_materialsolicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcedencia(){
        return $this->hasOne(Procedencia::className(), ['id' => 'id_procedencia']);
    }


    public function obtenerProtocolo()  {
        $anioprotocolo= AnioProtocolo::find()->andWhere(['and' ,"activo=true" ])->one();
        if ($anioprotocolo!== NULL){
          $solicitud= Solicitud::find()
          ->andWhere(['and' ,' "fechadeingreso"::text  like '. "'%".$anioprotocolo->anio."%'"])
          ->orderBy(['protocolo' => SORT_DESC])->one();

        }
        if ($solicitud == NULL){
          $protocolo=0;
        }else {
          $protocolo=$solicitud->protocolo;

        }
        return $protocolo+ 1;

    }
    public function estados() {
        //PATRON STATE;
        if (!isset ($this->estado)){
          //Estado pendiente por defecto
            $this->id_estado=5;
        }
        $namespace="app\models\\";
        $e= $namespace.$this->estado->descripcion;
        $estado= new $e();
        return $estado->estadosSolicitud();
    }

    public function idEstudio(){
        $estudio=Estudio::find()->where(['modelo'=>$this->modelo()])->all();
        return $estudio[0]->id;

    }
    public function getMaterialsolicitudes() {
        $id_estudio= $this->idEstudio();
        return ArrayHelper::map(Materialsolicitud::find()->where(['id_estudio' => $id_estudio])->all(), 'id','descripcion');

    }
    public function getSolicitudesAnio($nio) {
        $cantidad= Solicitud::find()->andWhere(['and' ,' "fechadeingreso"::text  like '. "'%".$nio."%'"])->count();
        if ($cantidad >0){
          return true;
        }else {
          return false;
         }
    }
}
