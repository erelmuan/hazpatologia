<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pap;

/**
 * PapSearch represents the model behind the search form about `app\models\Pap`.
 */
class PapSearch extends Pap
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
            [['id', 'id_solicitudpap','protocolo', 'sexo',  'indicepicnotico', 'id_plantilladiagnostico', 'cantidad', 'id_estado'], 'integer'],
            [['descripcion', 'calificacion', 'indicedemaduracion', 'plegamiento', 'agrupamiento', 'leucocitos', 'hematies', 'histiocitos', 'detritus', 'citolisis', 'flora', 'aspecto', 'pavimentosas', 'glandulares', 'diagnostico',  'fechalisto', 'observacion','fecha_desde','fecha_hasta','fecharealizacion'], 'safe'],
            //Se agrego para permitir la habilitacion del filtro en la grilla
            [['paciente','medico','procedencia','estado'], 'safe'],
            ['fecharealizacion', 'date', 'format' => 'dd/MM/yyyy'],
            ['fechadeingreso', 'date', 'format' => 'dd/MM/yyyy'],

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
        $query = Pap::find()->innerJoinWith('solicitudpap', true)
       ->leftJoin('paciente', 'paciente.id = solicitudpap.id_paciente')
       ->leftJoin('medico', 'medico.id = solicitudpap.id_medico')
      ->leftJoin('procedencia', 'procedencia.id = solicitudpap.id_procedencia')
      ->innerJoinWith('estado', 'estado.id = pap.id_estado');

       $dataProvider = new ActiveDataProvider([
           'query' => $query,
       ]);
       $dataProvider->sort->attributes['protocolo'] = [
              'asc' => ['solicitudpap.protocolo' => SORT_ASC],
              'desc' => ['solicitudpap.protocolo' => SORT_DESC],
          ];
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'pap.id' => $this->id,
            'id_solicitudpap' => $this->id_solicitudpap,
            'indicepicnotico' => $this->indicepicnotico,
            'protocolo' => $this->protocolo,
            'id_plantilladiagnostico' => $this->id_plantilladiagnostico,
            'fechalisto' => $this->fechalisto,
            'cantidad' => $this->cantidad,
            'pap.id_estado' => $this->id_estado,
        ]);
        if (is_numeric($this->paciente)){
            $query->orFilterWhere(["paciente.num_documento"=>$this->paciente]);
             }
        else {
            $query->andFilterWhere(['ilike', '("paciente"."apellido")',strtolower($this->paciente)]);

        }
        if (is_numeric($this->medico)){
            $query->orFilterWhere(["medico.matricula"=>$this->medico]);
             }
        else {
            $query->andFilterWhere(['ilike', '("medico"."apellido")',strtolower($this->medico)]);

        }

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'calificacion', $this->calificacion])
            ->andFilterWhere(['ilike', 'indicedemaduracion', $this->indicedemaduracion])
            ->andFilterWhere(['ilike', 'plegamiento', $this->plegamiento])
            ->andFilterWhere(['ilike', 'agrupamiento', $this->agrupamiento])
            ->andFilterWhere(['ilike', 'leucocitos', $this->leucocitos])
            ->andFilterWhere(['ilike', 'hematies', $this->hematies])
            ->andFilterWhere(['ilike', 'histiocitos', $this->histiocitos])
            ->andFilterWhere(['ilike', 'detritus', $this->detritus])
            ->andFilterWhere(['ilike', 'citolisis', $this->citolisis])
            ->andFilterWhere(['ilike', 'flora', $this->flora])
            ->andFilterWhere(['ilike', 'aspecto', $this->aspecto])
            ->andFilterWhere(['ilike', 'pavimentosas', $this->pavimentosas])
            ->andFilterWhere(['ilike', 'glandulares', $this->glandulares])
            ->andFilterWhere(['ilike', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['ilike', 'procedencia.nombre', $this->procedencia])
            ->andFilterWhere(['ilike', 'estado.descripcion', $this->estado])

            ->andFilterWhere(['ilike', 'observacion', $this->observacion]);
            $query->andFilterWhere(['=', 'fecharealizacion', $this->fecharealizacion]);
            $query->andFilterWhere(['=', 'fechadeingreso', $this->fechadeingreso]);
            $query->andFilterWhere(['>=', 'fechadeingreso', $this->fecha_desde]);
            $query->andFilterWhere(['<', 'fechadeingreso', $this->fecha_hasta]);
        return $dataProvider;
    }
}
