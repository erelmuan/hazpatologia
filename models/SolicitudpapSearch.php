<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Solicitudpap;

/**
 * SolicitudpapSearch represents the model behind the search form about `app\models\Solicitudpap`.
 */
class SolicitudpapSearch extends Solicitudpap
{

     /**
     * {@inheritdoc}
     */
    public static function modelName()
    {
        return 'SolicitudpapSearch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_procedencia', 'id_medico', 'id_materialsolicitud', 'protocolo', 'id_tipo_muestra', 'id_metodo_anticonceptivo', 'id_cirugia_previa','id_estudio','id_estado'], 'integer'],
            [['fecharealizacion', 'fechadeingreso',  'observacion', 'resultado_pap_previo', 'resultado_biopsia_previo', 'fum', 'fecha_ult_parto', 'datos_clinicos_de_interes', 'conclusion'], 'safe'],
            [['pap_previo', 'biopsia_previa', 'embarazo_actual', 'menopausia', 'tratamiento_radiante', 'quimioterapia', 'colposcopia'], 'boolean'],
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
        $query = Solicitudpap::find()
            //     //No debe tener estudio de biopsia asociado
            ->leftJoin('pap', 'pap.id_solicitudpap = solicitudpap.id')
            // //Tiene que se distinto a el estado RECHAZADO id=3
            ->where(['and','pap.id IS NULL' ])
            ->andWhere(['and','solicitudpap.id_estado <> 3 ' ]);


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
            'solicitudpap.id' => $this->id,
            'id_paciente' => $this->id_paciente,
            'id_procedencia' => $this->id_procedencia,
            'id_medico' => $this->id_medico,
            'id_materialsolicitud' => $this->id_materialsolicitud,
            'fecharealizacion' => $this->fecharealizacion,
            'fechadeingreso' => $this->fechadeingreso,
            'protocolo' => $this->protocolo,
            'id_tipo_muestra' => $this->id_tipo_muestra,
            'pap_previo' => $this->pap_previo,
            'biopsia_previa' => $this->biopsia_previa,
            'embarazo_actual' => $this->embarazo_actual,
            'menopausia' => $this->menopausia,
            'fecha_ult_parto' => $this->fecha_ult_parto,
            'id_metodo_anticonceptivo' => $this->id_metodo_anticonceptivo,
            'id_cirugia_previa' => $this->id_cirugia_previa,
            'tratamiento_radiante' => $this->tratamiento_radiante,
            'quimioterapia' => $this->quimioterapia,
            'colposcopia' => $this->colposcopia,
            'id_estudio' => $this->id_estudio,
            'id_estado' => $this->id_estado,
        ]);

        $query->andFilterWhere(['ilike', 'observacion', $this->observacion])
            ->andFilterWhere(['ilike', 'resultado_pap_previo', $this->resultado_pap_previo])
            ->andFilterWhere(['ilike', 'resultado_biopsia_previo', $this->resultado_biopsia_previo])
            ->andFilterWhere(['ilike', 'fum', $this->fum])
            ->andFilterWhere(['ilike', 'datos_clinicos_de_interes', $this->datos_clinicos_de_interes])
            ->andFilterWhere(['ilike', 'conclusion', $this->conclusion]);

        return $dataProvider;
    }
}
