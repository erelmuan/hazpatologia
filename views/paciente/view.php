

<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model app\models\Medico */
?>
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
            'value'     => call_user_func(function($model) {
                $items = "";
                foreach ($model->carnetOs as $carnet) {
                    $items .= $carnet->obrasocial->denominacion
                        . "<br> N° Afiliado: " . $carnet->nroafiliado . "<br>";
                }
                return $items ?: '<span class="text-muted">Sin obra social</span>';
            }, $model),
        ],

        // NUEVO ATRIBUTO: último chequeo
        [
            'label' => 'Último chequeo OS',
            'format'=>'raw',

            'value' => function($model) use ($lastCheck) {
              // Botón que abre el modal para editar paciente
              $url = \yii\helpers\Url::to(['paciente/update', 'id' => $model->id]);
                    $btn = \yii\helpers\Html::a(
                        '<i class="fa fa-edit"></i>',
                        $url,
                        [
                            'class' => 'btn btn-sm btn-primary ml-2',
                            'title' => 'Editar paciente',
                            'target' => '_blank' // 🔑 abre en nueva pestaña
                        ]
                    );
                if ($lastCheck) {
                  $dateTime = new DateTime($lastCheck['fechahora']);
                  // Configurar el formatter con locale español
                  $formatter = new \yii\i18n\Formatter([
                      'locale' => 'es-AR', // o 'es-ES'
                      'timeZone' => 'America/Argentina/Buenos_Aires'
                  ]);
                    $fecha = Html::encode($formatter->asDatetime($dateTime->getTimestamp())) ;

                    return "<b>{$fecha}</b> {$btn}";
                }

                return "<span class='text-muted'>Aún no se registró ningún chequeo</span> {$btn}";
            }
        ],

    ],
]) ?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
