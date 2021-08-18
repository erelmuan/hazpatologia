<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Localidad;

/**
 * LocalidadSearch represents the model behind the search form about `app\models\Localidad`.
 */
class LocalidadSearch extends Localidad
{

  public $provincia;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'codigopostal'], 'integer'],
            [['nombre','provincia'], 'safe'],
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
        // $query = Localidad::find();
        $query = Localidad::find()->innerJoinWith('provincia', true);

            // ->joinWith(['accessToken.usuario']);

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
            // 'provincia.nombre' => $this->provincia,
            'codigopostal' => $this->codigopostal,
        ]);

        $query->andFilterWhere(['ilike', 'localidad.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'provincia.nombre', $this->provincia]);

        return $dataProvider;
    }
}
