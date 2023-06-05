<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Solicitud;
use app\models\AnioProtocolo;
use DateTime;


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
  public $num_documento;
  public $term; // Agrega el atributo "term" al modelo
  public $id_tipodoc; // Propiedad para paciente.id_tipodoc
  public $fecha_desde;
  public $fecha_hasta;
    /**
     * @inheritdoc
     */



    public function rules()
    {
        return [
            //tiene que estar aqui para que esten los filtros
            [['id', 'protocolo', 'id_paciente',  'id_medico', 'id_materialsolicitud', 'id_estudio', 'id_estado','id_procedencia','num_documento'], 'integer'],
            // [['fecharealizacion'], 'date'],
            ['fecharealizacion', 'date', 'format' => 'dd/MM/yyyy'],
            ['fechadeingreso', 'date', 'format' => 'dd/MM/yyyy'],
            [[ 'fecha_desde','fecha_hasta','observacion','solicitud'], 'safe'],
            [['paciente','medico','procedencia','estudio','estado' ,'num_documento'], 'safe'],
            [['id_tipodoc'], 'safe'],

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

    public function arrayVacios($searchModelAttributes){
        foreach ($searchModelAttributes as $attribute => $value) {
              if ($value !== null) {
                return false;
              }
            }
        return true;
    }

    public function searchConsulta($params ,$query,$dataProvider){

        // Verificar si solo se proporciona la fecha_desde y no los campos num_documento ni paciente
        if (!$this->validate() || ((empty(trim($this->num_documento)) && empty($this->paciente))
        && (empty($this->fecha_hasta) && empty($this->fecha_desde)))) {
          $searchModelAttributes = $this->getAttributes();

          if (!$this->arrayVacios($searchModelAttributes) ) {
               $desde = date('d/m/Y', strtotime('-7 days'));
               $query->andWhere(['>=', 'fechadeingreso', $desde])
                  ->orderBy(['id' => SORT_DESC]);
               $this->fecha_desde=$desde;
               $this->fecha_hasta=date('d/m/Y');
          }

        }else {
          if (!empty(trim($this->num_documento)) || !empty($this->paciente)){
            $query->andFilterWhere(['>=', 'fechadeingreso', $this->fecha_desde]);
            $query->andFilterWhere(['<=', 'fechadeingreso', $this->fecha_hasta]);
          }
            else {
              //tengo que tener un logica de 7 dias entre estos dias
                 if (!empty($this->fecha_desde) && !empty($this->fecha_hasta)) { // A partir de la fecha desde, un máximo de 7 días
                     $ft =DateTime::createFromFormat('d/m/Y', $this->fecha_desde);
                     $ft->modify('+7 days');
                     $fh =DateTime::createFromFormat('d/m/Y', $this->fecha_hasta);
                     $this->fecha_hasta = $fh <= $ft ?  $fh->format('d/m/Y') : $ft->format('d/m/Y');
                 } elseif (empty($this->fecha_desde)) { // Un día, el establecido en hasta
                     $$this->fecha_desde = $this->fecha_hasta;
                 } else { // Un día, el establecido en desde
                     $this->fecha_hasta = $this->fecha_desde;
                 }
                 $query->andFilterWhere(['>=', 'fechadeingreso', $this->fecha_desde]);
                 $query->andFilterWhere(['<=', 'fechadeingreso', $this->fecha_hasta]);
            }
          }

       return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$consulta )
    {
       $query = Solicitud::find()->innerJoinWith('procedencia', true)
       ->innerJoinWith('paciente', 'paciente.id = solicitud.id_paciente')
       ->innerJoinWith('medico', 'medico.id = solicitud.id_medico')
       ->innerJoinWith('estado', 'estado.id = solicitud.id_estado')
       ->innerJoinWith('estudio', 'estudio.id = solicitud.id_estudio');

       $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
     $query->orderBy(['fechadeingreso'=> SORT_DESC ,'protocolo' => SORT_DESC ,'id' => SORT_DESC ]);
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
          $query->andFilterWhere([  'id_procedencia' => $this->id_procedencia,]);
          $query->andFilterWhere([  'id_estudio' => $this->id_estudio,]);
          $query->andFilterWhere([ "paciente.num_documento" => trim($this->num_documento),]);

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
        $query->andFilterWhere(['paciente.id_tipodoc' => $this->id_tipodoc]);
        $query->andFilterWhere([ "paciente.num_documento" => trim($this->num_documento)]);

        $query->andFilterWhere(['ilike', 'observacion', $this->observacion])
        ->andFilterWhere(['ilike', 'estado.descripcion', $this->estado])
        ->andFilterWhere(['ilike', 'estudio.descripcion', $this->estudio])
        ->andFilterWhere(['ilike', 'procedencia.nombre', $this->procedencia]);
        //Si es true el metodo search es invocado por la funcion actionConsulta del controlador
        if($consulta){
          $dataProvider=  $this->searchConsulta($params, $query,$dataProvider);
        }

        return $dataProvider;
    }

    public function getAttributes($names = null, $except = [])
{
    $attributes = parent::getAttributes($names, $except);
    $attributes['fecha_desde'] = $this->fecha_desde;
    $attributes['fecha_hasta'] = $this->fecha_hasta;
    $attributes['num_documento'] = $this->num_documento;
    $attributes['paciente'] = $this->paciente;

    return $attributes;
}


public function searchAutocomplete()
{
    // Implementa aquí la lógica de búsqueda específica para el autocompletado
    // Puede ser una consulta a la base de datos, búsqueda en un servicio externo, etc.
    // Devuelve los resultados como un arreglo de objetos o modelos

        $results = Solicitud::find()
            ->innerJoinWith('paciente', true)
            ->andFilterWhere(['ilike', new \yii\db\Expression("CONCAT(paciente.nombre, ' ', paciente.apellido)"), trim($this->term)])
            ->orFilterWhere(['ilike', new \yii\db\Expression("CONCAT(paciente.apellido , ' ',paciente.nombre )"), trim($this->term)])
            ->limit(15)
            ->all();
    return $results;
}
}
