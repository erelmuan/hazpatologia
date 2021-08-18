<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Plantillafrase;

/**
 * PlantillafraseSearch represents the model behind the search form about `app\models\Plantillafrase`.
 */
class PlantillafraseSearch extends Plantillafrase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_estudio'], 'integer'],
            [['codigo', 'frase'], 'safe'],
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
        $query = Plantillafrase::find();

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
            'id_estudio' => $this->id_estudio,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'frase', $this->frase]);

        return $dataProvider;
    }
}
