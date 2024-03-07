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
    ['class' => '\kartik\grid\CheckboxColumn',
     'header' => Html::img("./images/check.png"),
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
                    'onclick' => 'submitDetalle('.$id_maestro.')'
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
                'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em> </br><span id="error-no-seleccion" style="color:red;"> </span>',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Modulos',
            ]
        ])?>
    </div>
</div>
<script>
    $('#ajaxCrudModal').on('hidden.bs.modal', function () {
        $("#ajaxCrudModal .modal-dialog").css({"width":"600px"});
    })
</script>
