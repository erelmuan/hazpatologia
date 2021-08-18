<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Solicitud;

/**
 * SolicitudSearch represents the model behind the search form about `app\models\Solicitud`.
 */
class SolicitudSearch extends Solicitud
{
  public $paciente;
  public $medico;
  public $procedencia;
    /**
     * @inheritdoc
     */



    public function rules()
    {
        return [
            //tiene que estar aqui para que esten los filtros
            [['id', 'protocolo', 'id_paciente',  'id_medico', 'id_materialsolicitud', 'id_estudio', 'id_estado','id_procedencia'], 'integer'],
            // [['fecharealizacion'], 'date'],
            ['fecharealizacion', 'date', 'format' => 'dd/MM/yyyy'],
            ['fechadeingreso', 'date', 'format' => 'dd/MM/yyyy'],
            [[ 'observacion','solicitud'], 'safe'],
            [['paciente','medico','procedencia'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params )
    {
        //HACER CONDICIONALES SI ES UN PAP BIOPSIA O SI NO SE ENVIA NADA.
      //  $query = Solicitud::find();
    //   if ($estudio=='biopsia'){
    //    $query = Solicitud::find()
    //    ->leftJoin('procedencia', 'procedencia.id = solicitud.id_procedencia')
    //    ->leftJoin('biopsia', 'solicitud.id = biopsia.id_solicitud')
    //    ->where(['and', "biopsia.id is NULL", "solicitud.estado='PENDIENTE'","solicitud.estudio='BIOPSIA'"]);
    //  }
    //  elseif ($estudio=='pap'){
    //    $query = Solicitud::find()
    //    ->leftJoin('procedencia', 'procedencia.id = solicitud.id_procedencia')
    //    ->leftJoin('pap', 'solicitud.id = pap.id_solicitud')
    //    ->where(['and', "pap.id is NULL", "solicitud.estado='PENDIENTE'","solicitud.estudio='PAP'"]);
    //  }else {
       // $query = Solicitud::find()
       // ->orderBy(['fechadeingreso' => SORT_DESC,]);
       $query = Solicitud::find()->innerJoinWith('procedencia', true)
       ->innerJoinWith('paciente', 'paciente.id = solicitud.id_paciente')
       ->innerJoinWith('medico', 'medico.id = solicitud.id_medico')
       ->innerJoinWith('estado', 'estado.id = solicitud.id_estado')

       ->orderBy(['fechadeingreso' => SORT_DESC,]);


     //}
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'protocolo' => $this->protocolo,
            'id_estudio' => $this->id_estudio,
            'id_estado' => $this->id_estado,
            'id_procedencia' => $this->id_procedencia,

            // 'id_paciente' => $this->id_paciente,
             // 'procedencia' => $this->procedencia,
            // 'id_medico' => $this->id_medico,
            'id_materialsolicitud' => $this->id_materialsolicitud,
            // 'fecharealizacion' => $this->fecharealizacion,
            // 'fechadeingreso' => $this->fechadeingreso,
        ]) ;
          $query->andFilterWhere(['=', 'fecharealizacion', $this->fecharealizacion]);
          $query->andFilterWhere(['=', 'fechadeingreso', $this->fechadeingreso]);

        $query->andFilterWhere(['ilike', 'observacion', $this->observacion]);
        if (is_numeric($this->paciente)){
            $query->orFilterWhere(["paciente.num_documento"=>$this->paciente]);
             }
        else {
            $query->andFilterWhere(['ilike', '("paciente"."apellido")',strtolower($this->paciente)]);

        }
        if (is_numeric($this->medico)){
            $query->orFilterWhere(["medico.num_documento"=>$this->medico]);
             }
        else {
            $query->andFilterWhere(['ilike', '("medico"."apellido")',strtolower($this->medico)]);

        }

        $query->andFilterWhere(['like', 'observacion', $this->observacion]);
        
        return $dataProvider;
    }
}
