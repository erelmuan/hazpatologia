<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Accion;
/**
 * AccionSearch represents the model behind the search form about `app\models\Accion`.
 */
class AccionSearch extends Accion {
    /**
     * @inheritdoc
     */
    public function rules() {
        return [[['id'], 'integer'],
        [[ 'create', 'delete', 'update',  'view'], 'boolean'], ];
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
        $query = Accion::find();
        $dataProvider = new ActiveDataProvider(['query' => $query, ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id, 'create' => $this->create, 'delete' => $this->delete, 'update' => $this->update, 'view' => $this->view, ]);
        return $dataProvider;
    }
}
