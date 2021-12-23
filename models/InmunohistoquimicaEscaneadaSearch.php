<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InmunohistoquimicaEscaneada;

/**
 * InmunohistoquimicaEscaneadaSearch represents the model behind the search form about `app\models\InmunohistoquimicaEscaneada`.
 */
class InmunohistoquimicaEscaneadaSearch extends InmunohistoquimicaEscaneada
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_biopsia'], 'integer'],
            [['documento', 'observacion'], 'safe'],
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
        $query = InmunohistoquimicaEscaneada::find();

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
            'id_biopsia' => $this->id_biopsia,
        ]);

        $query->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
