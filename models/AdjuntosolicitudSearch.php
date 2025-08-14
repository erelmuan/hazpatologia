<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adjuntosolicitud;

/**
 * AdjuntosolicitudSearch represents the model behind the search form about `app\models\Adjuntosolicitud`.
 */
class AdjuntosolicitudSearch extends Adjuntosolicitud
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_solicitud'], 'integer'],
            [['nombre_archivo', 'nombre_asignado', 'observacion'], 'safe'],
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
        $query = Adjuntosolicitud::find();

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
            'baja_logica' => $this->baja_logica,
            'id_solicitud' => $this->id_solicitud,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
            ->andFilterWhere(['like', 'nombre_asignado', $this->nombre_asignado])
            ->andFilterWhere(['like', 'observacion', $this->observacion]);

        return $dataProvider;
    }
}
