<?php
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<style>
    .detalle-seleccionado > td {
        background-color: #bee0bf;!important;
    }
</style>

<?php
// agrego acciones a $columns
$columns[]=

    [ 'class' => '\kartik\grid\RadioColumn',
     'header' => Html::img("./img/check.png"),
     'rowSelectedClass' => 'detalle-seleccionado',
    ];
?>

<div class="modulo-index">
    <div id="ajaxCrudDatatableDetalle">
        <?=GridView::widget([
            'options'=>['id'=>'cruddetalle-datatable'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'layout'=>"{sorter}\n{items}",
            'toolbar' => [
                ['content'=>
                    Html::a('Aceptar', '#', [
                    'title' => 'Agregar registros seleccionados',
                    'class' => 'btn btn-primary',
                    'style' => ['width'=>'75px', 'height'=>'30px','padding-top'=>'4px'],
                    'onclick' => 'submitAddaccion('.$id_permiso.')'
                    ]),
                ],
            ],

            'columns' => $columns,
            'striped' => true,
            'condensed' => true,
            //Adaptacion para moviles
            'responsiveWrap' => false,
            'panel' => [
                'type' => 'primary',
                'before'=>'<em>* Para buscar algún registro tipear un id o elegir una opción en el filtro. </em> </br><span id="error-no-seleccion" style="color:red;"> </span>',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Acciones',
            ]
        ])?>
    </div>
</div>
<script>
    $('#ajaxCrudModal').on('hidden.bs.modal', function () {
        $("#ajaxCrudModal .modal-dialog").css({"width":"600px"});
    })
</script>
