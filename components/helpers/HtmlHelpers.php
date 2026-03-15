<?php
namespace app\components\helpers;

use yii\helpers\Json;
use yii\db\Query;


class HtmlHelpers {

    public static function sugestionList($field, $table, $model, $q, $id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, '.$field.' as text')
                ->from($table)
                ->where('' . $field . ' LIKE "%' . $q .'%"')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $model::find($id)->fullDescriptor];
        }
        return $out;
    }
    public static function dropDownList($model, $parent_model_id, $id, $value, $string)
    {
        $rows = $model::find()->where([$parent_model_id => $id])->orderBy(['nombre'=>SORT_DESC])->all();

        $droptions = "<option>Por favor elige uno</option>";

        if(count($rows)>0){
            foreach($rows as $row){
                $droptions .= '<option value='.$row->$value.'>'.$row->$string.'</option>';
            }
        }
        else{
            $droptions = "<option value=''>No se han encontrado resultados</option>";

        }

        return $droptions;
    }

}
