<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paciente;

/**
 * PacienteSearch represents the model behind the search form about `app\models\Paciente`.
 */
class PacienteSearch extends Paciente
{

  public $nacionalidad;
  public $tipodoc;

    /**
     * @inheritdoc
     */
    public function rules()
    {
      //Esta mal se supene que si sabes la localidad sabes la prvincia
        return [
          [['id', 'id_provincia','num_documento', 'id_localidad'], 'integer','except'=>'search'],
          // SCESNARIO //
          [['num_documento',],'integer','on'=>'search'],
          [['num_documento',],'required','on'=>'search'],
          // SCESNARIO //
        [['nacionalidad','tipodoc','nombre', 'apellido',  'hc', 'sexo', 'fecha_nacimiento', 'direccion', 'cp', 'telefono', 'email', 'afiliado'], 'safe','except'=>'search'],
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
        $query = Paciente::find()->innerJoinWith('tipodoc', true);

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'id_provincia' => $this->id_provincia,
            'id_localidad' => $this->id_localidad,
            'num_documento' => $this->num_documento,
            'tipodoc.id' => $this->tipodoc,

        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'apellido', $this->apellido])
            ->andFilterWhere(['ilike', 'hc', $this->hc])
            ->andFilterWhere(['ilike', 'sexo', $this->sexo])
            ->andFilterWhere(['ilike', 'direccion', $this->direccion])
            ->andFilterWhere(['ilike', 'cp', $this->cp])
            ->andFilterWhere(['ilike', 'telefono', $this->telefono])
          // ->andFilterWhere(['ilike', 'tipodoc.documento', $this->tipodoc])
            ->andFilterWhere(['ilike', 'telefono', $this->telefono])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'afiliado', $this->afiliado]);


        return $dataProvider;
    }
}
