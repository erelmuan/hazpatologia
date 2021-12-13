<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inmunohistoquimica;

/**
 * InmunohistoquimicaSearch represents the model behind the search form about `app\models\Inmunohistoquimica`.
 */
class InmunohistoquimicaSearch extends Inmunohistoquimica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_biopsia'], 'integer'],
            [['microscopia', 'diagnostico', 'observacion'], 'safe'],
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
        $query = Inmunohistoquimica::find();

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

        $query->andFilterWhere(['like', 'microscopia', $this->microscopia])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
