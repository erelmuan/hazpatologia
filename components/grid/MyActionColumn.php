<?php
namespace app\components\grid;

use kartik\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class MyActionColumn extends ActionColumn
{
    public $viewOptions = [
        'role' => 'modal-remote',
        'class' => 'btn btn-success btn-circle btn-sm',
    ];

    public $updateOptions = [
        'role' => 'modal-remote',
        'class' => 'btn btn-primary btn-circle btn-sm',
    ];

    public $deleteOptions = [
        // 🚫 IMPORTANTE: sin modal-remote
        'class' => 'btn btn-danger btn-circle btn-sm',
    ];

    public function init()
    {
        if ($this->template === null) {
            $this->template = '{view} {update} {delete}';
        }
        parent::init();
    }

    protected function initDefaultButtons()
    {
        // VER
        $this->buttons['view'] = function ($url, $model, $key) {
            $options = $this->viewOptions;
            $options['title'] = ArrayHelper::getValue($options, 'title', 'Ver');
            $options['data-pjax'] = '0';

            return Html::a('<i class="fas fa-eye"></i>', $url ?: '#', $options);
        };

        //  EDITAR
        $this->buttons['update'] = function ($url, $model, $key) {
            $options = $this->updateOptions;
            $options['title'] = ArrayHelper::getValue($options, 'title', 'Editar');
            $options['data-pjax'] = '0';

            return Html::a('<i class="fas fa-pen"></i>', $url ?: '#', $options);
        };

        // ELIMINAR (FIX)
        $this->buttons['delete'] = function ($url, $model, $key) {
            return Html::a('<i class="fas fa-trash"></i>', $url, [
                'class' => 'btn btn-danger btn-circle btn-sm',
                'role' => 'modal-remote', // 🔥 vuelve AJAX
                'data-request-method' => 'post',
                'data-confirm-title' => 'Confirmar',
                'data-confirm-message' => '¿Está seguro de eliminar este elemento?',
                'data-pjax' => '0',
            ]);
        };
    }
}
