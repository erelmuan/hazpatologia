<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form about `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
  public $pantalla;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activo'], 'integer'],
            [['id', 'id_pantalla'], 'integer'],
            [['usuario', 'contrasenia', 'nombre', 'email', 'descripcion', 'pantalla'], 'safe'],
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
        $query = Usuario::find();

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
            'activo' => $this->activo,
            'id_pantalla' => $this->id_pantalla,
              'id_pantalla' => $this->pantalla,
        ]);

        $query->andFilterWhere(['ilike', 'usuario', $this->usuario])
            ->andFilterWhere(['ilike', 'contrasenia', $this->contrasenia])
            ->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
