<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Plantillamaterial;

/**
 * PlantillamaterialSearch represents the model behind the search form about `app\models\Plantillamaterial`.
 */
class PlantillamaterialSearch extends Plantillamaterial
{
  /**
   * @inheritdoc
   */
  public function rules()
  {
      return [
          [['id'], 'integer'],
          [['codigo', 'material'], 'safe'],
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
      $query = Plantillamaterial::find();

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
      ]);

      $query->andFilterWhere(['ilike', 'codigo', $this->codigo])
          ->andFilterWhere(['ilike', 'material', $this->material]);

      return $dataProvider;
  }
}
