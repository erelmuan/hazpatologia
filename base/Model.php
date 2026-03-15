<?php
namespace app\base;
use Yii;
use yii\base\Model as BaseModel;

class Model extends BaseModel
{
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (! empty($multipleModels)) {
            $keys = array_keys($multipleModels);
            $models = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($models[$item['id']])) {
                    $models[] = $models[$item['id']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        return $models;
    }
    // En app\base\Model — agregar este método estático público
    public static function cargarModelos(string $clase, string $formName, array $postData): array
    {
        $modelos = [];
        $items = $postData[$formName] ?? [];

        foreach ($items as $data) {
            $id = !empty($data['id']) ? (int)$data['id'] : null;
            if ($id) {
                $m = $clase::findOne($id);
                if (!$m) continue;
            } else {
                $m = new $clase();
            }
            $m->load([$formName => $data], $formName);
            $modelos[] = $m;
        }
        return $modelos;
    }

}
