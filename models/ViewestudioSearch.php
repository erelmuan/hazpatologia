<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viewestudio;

/**
 * ViewestudioSearch represents the model behind the search form about `app\models\Viewestudio`.
 */
class ViewestudioSearch extends Viewestudio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_solicitud', 'id_estudio_modelo', 'protocolo'], 'integer'],
            [['modelo', 'fechadeingreso', 'pacientenomb', 'pacienteapel', 'tipo_documento', 'num_documento', 'procedencia', 'estudio', 'estado', 'mediconomb', 'medicoeapel'], 'safe'],
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
        $query = Viewestudio::find();

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
            'id_solicitud' => $this->id_solicitud,
            'id_estudio_modelo' => $this->id_estudio_modelo,
            'protocolo' => $this->protocolo,
            'fechadeingreso' => $this->fechadeingreso,
        ]);

        $query->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'pacientenomb', $this->pacientenomb])
            ->andFilterWhere(['like', 'pacienteapel', $this->pacienteapel])
            ->andFilterWhere(['like', 'tipo_documento', $this->tipo_documento])
            ->andFilterWhere(['like', 'num_documento', $this->num_documento])
            ->andFilterWhere(['like', 'procedencia', $this->procedencia])
            ->andFilterWhere(['like', 'estudio', $this->estudio])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'mediconomb', $this->mediconomb])
            ->andFilterWhere(['like', 'medicoeapel', $this->medicoeapel]);

        return $dataProvider;
    }
}
