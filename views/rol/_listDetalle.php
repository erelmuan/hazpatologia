<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
?>


<div class="detalle-expand" style="padding-left: 20px;padding-right: 20px;">

    <div style="font-size: 16px;padding-top: 4px;padding-bottom: 4px;"><b>Modulos</b></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'crud-detail',
        'layout' => '{items}',
        'columns' => [
            'id',
            'modulo.nombre',
            [
              'label'=>'Tipo de acceso',
              'attribute'=>'modulo.tipoAcceso.nombre',
              ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Ver',
                'attribute'=> 'accion.view',
                'trueLabel' => 'Sí',
                'falseLabel' => 'No',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Alta',
                'attribute'=>'accion.create',
                'trueLabel' => 'Sí',
                'falseLabel' => 'No',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Borrar',
                'attribute'=> 'accion.delete',
                'trueLabel' => 'Sí',
                'falseLabel' => 'No',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Modificar',
                'attribute'=> 'accion.update',
                'trueLabel' => 'Sí',
                'falseLabel' => 'No',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'vAlign'=>'middle',
                'contentOptions' =>['width'=>'75px', 'style'=>'text-align:center;'],
                'header' => Html::a('Agregar',Yii::$app->urlManager->baseUrl.'/rol/createdetalle?id_maestro='.$id_maestro, [
                    'title' => 'Agregar registro',
                    'class' => 'btn btn-success',
                    'style' => ['width'=>'75px', 'height'=>'30px','padding-top'=>'4px'],
                    'role' => 'modal-remote' ,
                    'onclick' => '$("#ajaxCrudModal .modal-dialog").css({"width":"1000px"})']),

                'template' => '{addAccion}{deleteDetalle}',
                'buttons' => [
                    'addAccion' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-plus">&nbsp;</span>', $url,
                                ['role'=>'modal-remote','title'=> 'Agregar acciones al modulo',]);
                        },
                    'deleteDetalle' => function ($url) {
                            return Html::a('<span class="glyphicon glyphicon-trash">&nbsp;</span>', $url,
                                ['role'=>'modal-remote','title'=>'Quitar registro',
                                 'data-url'=> $url,
                                 'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                 'data-request-method'=>'post',
                                 'data-toggle'=>'tooltip',
                                 'data-confirm-title'=>'Quitar Registro',
                                 'data-confirm-message'=>'¿ Desea quitar el registro de este modulo ?']);

                        },
                    ],
                    'urlCreator' => function ($action, $searchModel) {

                    if ($action === 'addAccion') {
                        $url =Yii::$app->urlManager->baseUrl.'/rol/addaccion?id_permiso='.$searchModel->id;
                        return $url;
                    }
                    if ($action === 'deleteDetalle') {
                        $url =Yii::$app->urlManager->baseUrl.'/rol/deletedetalle?id_detalle='.$searchModel->id.'&id_maestro='.$searchModel->id_rol;
                        return $url;
                    }
                },
                 'visibleButtons' => [
                        'addAccion' => function ($model, $key, $index) {
                           // Aquí se verifica si el ID del modelo es 1
                         return ($model->modulo->tipoAcceso->nombre == "index" );
                   },],
            ],
        ],
        'striped' => true,
        'condensed' => true,
        //Adaptacion para moviles
        'responsiveWrap' => false,
    ]);

    ?>
</div>
