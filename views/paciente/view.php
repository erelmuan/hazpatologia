

<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */
?>
<div class="paciente-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'apellido',
            'nombre',
            'tipodoc.documento',
            'num_documento',
            'hc',
            'sexo',
            [
            'value'=> $model->nacionalidad->gentilicio,
            'label'=> 'Nacionalidad',
           ],
            'fecha_nacimiento',
            [
            'value'=> ($model->localidad)?$model->localidad->nombre:'No definido',
            'label'=> 'Localidad',
           ],
           [
           'value'=> ($model->localidad)?$model->localidad->provincia->nombre:'No definido',
           'label'=> 'Provincia',
          ],
          'direccion',
          'cp',
          'telefono',
          'email',


          [
            'attribute' => 'Obra social',
                'format'    => 'html',
                'value'     => call_user_func(function($model)
                {
                    $items = "";
                    foreach ($model->carnetOs as $carnet) {
                        $items .= $carnet->obrasocial->denominacion."<br> N° Afiliado: ".$carnet->nroafiliado."<br>";

                    }
                    return $items;
                }, $model)
         ],
        ],
    ]) ?>

</div>
