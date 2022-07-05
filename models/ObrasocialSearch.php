<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Obrasocial;

/**
 * ObrasocialSearch represents the model behind the search form about `app\models\Obrasocial`.
 */
class ObrasocialSearch extends Obrasocial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'telefono'], 'integer'],
            [['sigla', 'denominacion', 'direccion', 'paginaweb', 'observaciones', 'correoelectronico', 'codigo'], 'safe'],
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
        $query = Obrasocial::find();

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
            'telefono' => $this->telefono,
        ]);

        $query->andFilterWhere(['ilike', 'sigla', $this->sigla])
            ->andFilterWhere(['ilike', 'denominacion', $this->denominacion])
            ->andFilterWhere(['ilike', 'direccion', $this->direccion])
            ->andFilterWhere(['ilike', 'paginaweb', $this->paginaweb])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones])
            ->andFilterWhere(['ilike', 'correoelectronico', $this->correoelectronico])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
