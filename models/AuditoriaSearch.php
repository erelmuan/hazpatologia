<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Auditoria;

/**
 * AuditoriaSearch represents the model behind the search form about `app\models\Auditoria`.
 */
class AuditoriaSearch extends Auditoria
{
  public $usuario;
  public $registro;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_usuario'], 'integer'],
            [['usuario' ,'tabla','accion','registro', 'fecha', 'hora', 'ip', 'informacion_usuario', 'cambios'], 'safe'],
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
        $query = Auditoria::find()->innerJoinWith('usuario', true)
        ->orderBy(['id'=>SORT_DESC]);


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
            'auditoria.id' => $this->id,
            'fecha' => $this->fecha,
            'registro' => $this->registro,
            'hora' => $this->hora,
        ]);

        $query->andFilterWhere(['ilike', 'accion', $this->accion])
            ->andFilterWhere(['ilike', 'tabla', $this->tabla])
            ->andFilterWhere(['ilike', 'ip', $this->ip])
            ->andFilterWhere(['ilike', 'usuario', $this->usuario])
            ->andFilterWhere(['ilike', 'informacion_usuario', $this->informacion_usuario])
            ->andFilterWhere(['ilike', 'cambios', $this->cambios]);

        return $dataProvider;
    }
}
