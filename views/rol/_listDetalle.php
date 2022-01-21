<?php

use yii\helpers\Html;
use kartik\grid\GridView;

?>

<style>
    .expanded-row > td {
        background-color: #a4cea9;
    }
    .expanded-row > tr {
        background-color: #beedc0;
    }
    .detalle-expand .table-striped > tbody > tr:nth-of-type(2n+1) > td {
        background-color: #f9f9f9; !important;
        padding: 6px;!important;
    }
    .detalle-expand .table-striped > tbody > tr:nth-of-type(2n) > td {
        background-color: #ffffff; !important;
        padding: 6px;!important;
    }
    .detalle-expand .table-striped > thead > tr > th {
        padding-top: 2px; !important;
        padding-left: 6px; !important;
        padding-right: 6px; !important;
        padding-bottom: 2px; !important;
    }
    .detalle-expand .glyphicon {
        /*color: #6cb475;*/
    }
</style>

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
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Index/Ver',
                'attribute'=>'accion.index',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Alta',
                'attribute'=>'accion.create',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Borrar',
                'attribute'=> 'accion.delete',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Modificar',
                'attribute'=> 'accion.update',
            ],
            [
                'class' => 'kartik\grid\BooleanColumn',
                'label'=>'Exportar',
                'attribute'=> 'accion.export',
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'vAlign'=>'middle',
                'contentOptions' =>['width'=>'75px', 'style'=>'text-align:center;'],
                'header' => Html::a('Agregar', 'index.php?r=rol/createdetalle&id_maestro='.$id_maestro, [
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
                        $url ='index.php?r=rol/addaccion&id_permiso='.$searchModel->id;
                        return $url;
                    }
                    if ($action === 'deleteDetalle') {
                        $url ='index.php?r=rol/deletedetalle&id_detalle='.$searchModel->id.'&id_maestro='.$searchModel->id;
                        return $url;
                    }
                }
            ],
        ],
        'striped' => true,
        'condensed' => true,
        //Adaptacion para moviles
        'responsiveWrap' => false,
    ]);

    ?>
</div>
