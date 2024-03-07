<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Modulo;

/**
 * ModuloSearch represents the model behind the search form about `app\models\Modulo`.
 */
class ModuloSearch extends Modulo
{
  public $tipo_acceso;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['id', 'id_tipo_acceso'], 'integer'],
           [['nombre'], 'safe'],
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
        $query = Modulo::find()
        ->innerJoinWith('tipoAcceso', true)
        ;

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
            'id_tipo_acceso' => $this->id_tipo_acceso, 
        ]);

        $query->andFilterWhere(['ilike', 'modulo.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'tipo_acceso.nombre', $this->tipo_acceso]);

        ;

        return $dataProvider;
    }
}
