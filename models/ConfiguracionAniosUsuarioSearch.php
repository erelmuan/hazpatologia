<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ConfiguracionAniosUsuario;

/**
 * ConfiguracionAniosUsuarioSearch represents the model behind the search form of `app\models\ConfiguracionAniosUsuario`.
 */
class ConfiguracionAniosUsuarioSearch extends ConfiguracionAniosUsuario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario', 'id_anio_protocolo', 'id_estudio'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ConfiguracionAniosUsuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_usuario' => $this->id_usuario,
            'id_anio_protocolo' => $this->id_anio_protocolo,
            'id_estudio' => $this->id_estudio,
        ]);

        return $dataProvider;
    }
}
