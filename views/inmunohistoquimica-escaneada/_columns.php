<?php
use yii\helpers\Url;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'documento',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_biopsia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'nombre_archivo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'baja_logica',
    ],


];
