<script>
$(document).ready(function() {
    // Manejar el evento de cambio del checkbox "Seleccionar Todos"
    $("#seleccionarTodos").change(function() {
        // Si está seleccionado, selecciona todos los checkboxes
        if ($(this).is(":checked")) {
            $("input[name='seleccion[]']").prop("checked", true);
        } else {
            // De lo contrario, deselecciona todos los checkboxes
            $("input[name='seleccion[]']").prop("checked", false);
        }
    });
});
</script>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin();
echo "<b>Seleccione los años de los estudios que desea visualizar
&nbsp;<input type='checkbox' id='seleccionarTodos'> Seleccionar Todos </input><br><br>";

echo Html::checkboxList('seleccion', $aniosSeleccionados, $aniosDisponibles,
        [
            'class' => 'ui-sortable',
            'id' => 'sortable',
            'item' => function ($index, $label, $name, $checked, $value) use ($aniosSeleccionados) {
                $isChecked = in_array($value, $aniosSeleccionados);
                return Html::checkbox($name, $isChecked, [
                    'value' => $value,
                    'label' => '&nbsp;' . $label . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;' . '&nbsp;',
                    'labelOptions' => ['class' => 'ui-sortable-handle']
                ]);
            }
        ]);
    ?>
<?php ActiveForm::end(); ?>
