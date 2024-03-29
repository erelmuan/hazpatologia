<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VphEscaneado;

/**
 * VphEscaneadoSearch represents the model behind the search form about `app\models\VphEscaneado`.
 */
class VphEscaneadoSearch extends VphEscaneado
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_pap'], 'integer'],
            [['documento', 'observacion', 'nombre_archivo'], 'safe'],
            [['baja_logica'], 'boolean'],
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
        $query = VphEscaneado::find();

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
            'id_pap' => $this->id_pap,
            'baja_logica' => $this->baja_logica,
        ]);

        $query->andFilterWhere(['ilike', 'documento', $this->documento])
              ->andFilterWhere(['ilike', 'observacion', $this->observacion])
              ->andFilterWhere(['ilike', 'nombre_archivo', $this->nombre_archivo]);
        return $dataProvider;
    }
}
