<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Biopsia;

/**
 * BiopsiaSearch represents the model behind the search form about `app\models\Biopsia`.
 */
class BiopsiaSearch extends Biopsia
{
//son necesarias las variables y tambien la modificacion en el archivo _columns.php
// en los atributos
  public $protocolo;
  public $paciente;
  public $medico;
  public $fecharealizacion;
  public $fechadeingreso;
  public $sexo;
  public $procedencia;
  public $fecha_desde;
  public $fecha_hasta;
  public $estado;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_solicitudbiopsia', 'protocolo', 'id_estado'], 'integer'],
            [['fecha_desde','fecha_hasta','sexo','material','macroscopia', 'microscopia', 'diagnostico',  'observacion','fechalisto'], 'safe'],
            ['fecharealizacion', 'date', 'format' => 'dd/MM/yyyy'],
            ['fechadeingreso', 'date', 'format' => 'dd/MM/yyyy'],
            [['firmado', 'ihq'], 'boolean'],
            //Se agrego para permitir la habilitacion del filtro en la grilla
            [['paciente','medico','procedencia','estado'], 'safe'],
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
    public function search($params)
    {
      $id_estudio = Solicitudbiopsia::find()
          ->select(['id_estudio'])
          ->scalar();
      $selectedYearsQuery = (new \yii\db\Query())
        ->select('id_anio_protocolo')
        ->from('configuracion_anios_usuario')
        ->andWhere(['id_usuario' => Yii::$app->user->id])
        ->andWhere(['id_estudio' =>  $id_estudio])
        ->column();

      $query = Biopsia::find()->innerJoinWith('solicitudbiopsia', true)
      ->innerJoin('paciente', 'paciente.id = solicitudbiopsia.id_paciente')
      ->innerJoin('procedencia', 'procedencia.id = solicitudbiopsia.id_procedencia')
      ->innerJoin('medico', 'medico.id = solicitudbiopsia.id_medico')
      ->innerJoinWith('estado', 'estado.id = biopsia.id_estado')
      ->andWhere(['solicitudbiopsia.id_anio_protocolo' => $selectedYearsQuery])
      ->andWhere(['and','biopsia.id_estado <> 6 ' ]); //ANULADO


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $dataProvider->setSort([
            'attributes' => [
              'protocolo','estado','id','fechadeingreso','fecharealizacion','sexo'
         ]]);
         $dataProvider->sort->attributes['medico'] = [
                'asc' => ['medico.apellido' => SORT_ASC],
                'desc' => ['medico.apellido' => SORT_DESC],
            ];
        $dataProvider->sort->attributes['paciente'] = [
               'asc' => ['paciente.apellido' => SORT_ASC],
               'desc' => ['paciente.apellido' => SORT_DESC],
           ];
       $dataProvider->sort->attributes['procedencia'] = [
                'asc' => ['procedencia.nombre' => SORT_ASC],
                'desc' => ['procedencia.nombre' => SORT_DESC],
            ];
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //filtro de busqueda
        $query->andFilterWhere([
            'biopsia.id' => $this->id,
            'id_solicitudbiopsia' => $this->id_solicitudbiopsia,
            //Esto es solo posble porque se agrego una variable a la clase
            'solicitudbiopsia.protocolo' => $this->protocolo,
            'fechalisto' => $this->fechalisto,
        ]);
        $paciente= trim($this->paciente);
        if (is_numeric($paciente)){
            $query->andFilterWhere(["paciente.num_documento"=>$paciente]);
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
            $query->andFilterWhere(["medico.matricula"=>$medico]);
             }
        else {
            $apellidonombreM = explode(",", $medico);
            $query->andFilterWhere(['ilike', '("medico"."apellido")',strtolower(trim($apellidonombreM[0]))]);
            if (isset($apellidonombreM[1])){
              $query->andFilterWhere(['ilike', '("medico"."nombre")',strtolower(trim($apellidonombreM[1]))]);
            }
        }

        $query->andFilterWhere(['ilike', 'material', $this->material])
            ->andFilterWhere(['ilike', 'macroscopia', $this->macroscopia])
            ->andFilterWhere(['ilike', 'microscopia', $this->microscopia])

            ->andFilterWhere(['=', 'ihq', $this->ihq])
            ->andFilterWhere(['ilike', 'sexo', $this->sexo])
            ->andFilterWhere(['ilike', 'estado.descripcion', $this->estado])
            ->andFilterWhere(['ilike', 'procedencia.nombre', $this->procedencia])
            ->andFilterWhere(['ilike', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['ilike', 'observacion', $this->observacion]);
            $query->andFilterWhere(['=', 'fecharealizacion', $this->fecharealizacion]);
            $query->andFilterWhere(['=', 'fechadeingreso', $this->fechadeingreso]);
            $query->andFilterWhere(['>=', 'fechadeingreso', $this->fecha_desde]);
            $query->andFilterWhere(['<', 'fechadeingreso', $this->fecha_hasta]);
        return $dataProvider;
    }
}
