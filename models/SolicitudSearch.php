<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Solicitud;
use app\models\AnioProtocolo;



/**
 * SolicitudSearch represents the model behind the search form about `app\models\Solicitud`.
 */
class SolicitudSearch extends Solicitud
{
  public $paciente;
  public $medico;
  public $procedencia;
  public $estado;
  public $estudio;

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
            [['paciente','medico','procedencia','estudio','estado'], 'safe'],

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

       $query = Solicitud::find()->innerJoinWith('procedencia', true)
       ->innerJoinWith('paciente', 'paciente.id = solicitud.id_paciente')
       ->innerJoinWith('medico', 'medico.id = solicitud.id_medico')
       ->innerJoinWith('estado', 'estado.id = solicitud.id_estado')
       ->innerJoinWith('estudio', 'estudio.id = solicitud.id_estudio');
       
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['protocolo','id']]

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'solicitud.id' => $this->id,
            'protocolo' => $this->protocolo,
            'id_materialsolicitud' => $this->id_materialsolicitud,
        ]) ;
          $query->andFilterWhere(['=', 'fecharealizacion', $this->fecharealizacion]);
          $query->andFilterWhere(['=', 'fechadeingreso', $this->fechadeingreso]);
          $paciente= trim($this->paciente);
        if (is_numeric($paciente)){
            $query->orFilterWhere(["paciente.num_documento"=>$paciente]);
             }
        else {
            $apellidonombreP = explode(",", $paciente);
            $query->andFilterWhere(['ilike', '("paciente"."apellido")',strtolower(trim($apellidonombreP[0]))]);
            if (isset($apellidonombreP[1])){
              $query->andFilterWhere(['ilike', '("paciente"."nombre")',strtolower(trim($apellidonombreP[1]))]);
            }
        }
        $medico= trim($this->medico);
        if (is_numeric($medico)){
            $query->orFilterWhere(["medico.matricula"=>$medico]);
             }
        else {
            $apellidonombreM = explode(",", $medico);
            $query->andFilterWhere(['ilike', '("medico"."apellido")',strtolower(trim($apellidonombreM[0]))]);
            if (isset($apellidonombreM[1])){
              $query->andFilterWhere(['ilike', '("medico"."nombre")',strtolower(trim($apellidonombreM[1]))]);
            }
        }

        $query->andFilterWhere(['ilike', 'observacion', $this->observacion])
        ->andFilterWhere(['ilike', 'estado.descripcion', $this->estado])
        ->andFilterWhere(['ilike', 'estudio.descripcion', $this->estudio])
        ->andFilterWhere(['ilike', 'procedencia.nombre', $this->procedencia])

        ;

        return $dataProvider;
    }
}
