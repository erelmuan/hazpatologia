<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AnioProtocolo;
/**
 * AnioProtocoloSearch represents the model behind the search form about `app\models\AnioProtocolo`.
 */
class AnioProtocoloSearch extends AnioProtocolo {
    /**
     * @inheritdoc
     */
    public function rules() {
        return [[['anio', 'id'], 'integer'], [['activo'], 'boolean'], ];
    }
    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = AnioProtocolo::find();
        $dataProvider = new ActiveDataProvider(['query' => $query, ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['anio' => $this->anio, 'activo' => $this->activo, 'id' => $this->id, ]);
        return $dataProvider;
    }
}
