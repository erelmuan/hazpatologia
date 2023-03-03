<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile('../../components/jquery-ui.js', ['position' => \yii\web\View::POS_BEGIN]);
?>
<style>
#sortable{
    height: 300px;
    width: 500px;
    margin-left: 40px;
    padding-right: 180px;
    overflow: auto;
}
#sortable label {
    list-style-type: none;
    padding: 3px 0px 0px 9px;
    width: 300px;
}
.ui-sortable-handle {
    border: 1px solid;
    height: 32px;
    margin-bottom: 2px;
    background-color: #ccc;
    border-radius: 4px;
}
</style>

<div class="select-form">

<?php
$form = ActiveForm::begin();
echo "<b>Seleccione la ubicación y las columnas que desea visualizar</b><br><br>";
echo Html::checkboxList('seleccion', $seleccion, $etiquetas,
        [   'class'=>'ui-sortable',
            'id'=>'sortable',
            'item'=>function ($index, $label, $name, $checked, $value){
                return Html::checkbox($name, $checked, [
               'value' => $value,
               'label' => '&nbsp;'.$label,
               'labelOptions'=>['class'=>'ui-sortable-handle']
                ]);
            }
        ]);

    ?>
<?php ActiveForm::end(); ?>
</div>
<script>
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
</script>
