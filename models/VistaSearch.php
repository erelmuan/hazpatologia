<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vista;

/**
 * VistaSearch represents the model behind the search form about `app\models\Vista`.
 */
class VistaSearch extends Vista
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario'], 'integer'],
            [['modelo', 'columna'], 'safe'],
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
        $query = Vista::find();

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
            'id_usuario' => $this->id_usuario,
        ]);

        $query->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'columna', $this->columna]);

        return $dataProvider;
    }
}
