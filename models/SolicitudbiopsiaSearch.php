<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Solicitudbiopsia;

/**
 * SolicitudbiopsiaSearch represents the model behind the search form about `app\models\Solicitudbiopsia`.
 */
class SolicitudbiopsiaSearch extends Solicitudbiopsia
{

       /**
     * {@inheritdoc}
     */
    public static function modelName()
    {
        return 'SolicitudbiopsiaSearch';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'protocolo', 'id_materialginecologico', 'id_estudio', 'id_estado'], 'integer'],
            [['fecharealizacion', 'fechadeingreso', 'observacion', 'sitio_prec_toma', 'datos_clin_interes', 'diagnostico_presuntivo', 'biopsia_anterior_resultado'], 'safe'],
            ['fechadeingreso', 'date', 'format' => 'dd/MM/yyyy'],
            ['fecharealizacion', 'date', 'format' => 'dd/MM/yyyy'],

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
        //$query = Solicitudbiopsia::find();
        $query = Solicitudbiopsia::find()
        //No debe tener estudio de biopsia asociado
        ->leftJoin('biopsia', 'biopsia.id_solicitudbiopsia = solicitudbiopsia.id')
        ->where(['and','biopsia.id IS NULL ' ])
        ->andWhere(['and','solicitudbiopsia.id_estado <> 3 ' ]);


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
            'solicitudbiopsia.id' => $this->id,
            'id_paciente' => $this->id_paciente,
            'id_procedencia' => $this->id_procedencia,
            'id_medico' => $this->id_medico,
            'id_materialsolicitud' => $this->id_materialsolicitud,
            'fecharealizacion' => $this->fecharealizacion,
            'fechadeingreso' => $this->fechadeingreso,
            'protocolo' => $this->protocolo,
            'id_materialginecologico' => $this->id_materialginecologico,
            'id_estudio' => $this->id_estudio,
            'id_estado' => $this->id_estado,
        ]);

        $query->andFilterWhere(['ilike', 'observacion', $this->observacion])
            ->andFilterWhere(['ilike', 'sitio_prec_toma', $this->sitio_prec_toma])
            ->andFilterWhere(['ilike', 'datos_clin_interes', $this->datos_clin_interes])
            ->andFilterWhere(['ilike', 'diagnostico_presuntivo', $this->diagnostico_presuntivo])
            ->andFilterWhere(['ilike', 'biopsia_anterior_resultado', $this->biopsia_anterior_resultado]);

        return $dataProvider;
    }
}
