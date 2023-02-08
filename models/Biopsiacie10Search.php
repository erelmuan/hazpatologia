<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Biopsiacie10;

/**
 * Biopsiacie10Search represents the model behind the search form about `app\models\Biopsiacie10`.
 */
class Biopsiacie10Search extends Biopsiacie10
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cie10', 'id_usuario', 'id_biopsia', 'id_estudio'], 'integer'],
            [['verificado'], 'boolean'],
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
        $query = Biopsiacie10::find();

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
            'id_cie10' => $this->id_cie10,
            'verificado' => $this->verificado,
            'id_usuario' => $this->id_usuario,
            'id_biopsia' => $this->id_biopsia,
            'id_estudio' => $this->id_estudio,
        ]);

        return $dataProvider;
    }
}
