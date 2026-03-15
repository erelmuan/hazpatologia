

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
        [
          'attribute'=> 'fecha_nacimiento',
          "value"=>Yii::$app->formatter->asDate($model->fecha_nacimiento,'php:d/m/Y'),
        ],
        [
            'label' => 'Domicilio',
            'format' => 'html',
            'value' => function($model){

                $html = '';
                $num = 1;

                foreach ($model->domicilios as $d) {

                    $html .= "<div'>
                                <b  class='text-primary mb-2'>DOMICILIO {$num}</b>

                                <div style='display:flex;flex-wrap:wrap;gap:10px;margin-top:5px'>
                                    <div><b>Calle:</b> ".($d->calle ?? 'No definido')."</div>
                                    <div><b>N°:</b> ".($d->numero ?? 'S/N')."</div>
                                    <div><b>Tipo:</b> ".($d->tipodom->descripcion ?? 'No definido')."</div>
                                    <div><b>Provincia:</b> ".($d->provincia->nombre ?? 'No definido')."</div>
                                    <div><b>Localidad:</b> ".($d->localidad->nombre ?? 'No definido')."</div>
                                    <div><b>Barrio:</b> ".($d->barrio->nombre ?? 'No definido')."</div>
                                    <div><b>Principal:</b> ".($d->principal ? 'SI' : 'NO')."</div>
                                </div>
                              </div>";

                    $num++;
                }

                return $html ?: 'Sin domicilios';
            }
        ],
        [
            'label' => 'Contacto',
            'format' => 'raw',
            'value' => function ($model) {
                if (empty($model->contactos)) {
                    return '<span class="text-muted">Sin medio de contacto</span>';
                }
                // wrapper que recibe padding pero no margenes
                $html = '<div class="contactos-cell">';
                foreach ($model->contactos as $contacto) {
                    $tipo  = Html::encode($contacto->tipocontacto->descripcion ?? '');
                    $valor = Html::encode($contacto->valor ?? '');
                    $uso   = Html::encode($contacto->tipouso->descripcion ?? '');

                    // tarjeta COMPACTA: sin margin vertical, solo padding interior
                    $html .= '<div class="contacto-item">';
                    $html .= "  <div class='text-primary mb-2'>{$tipo}</div>";
                    $html .= "  <div><strong>Valor:</strong> {$valor}</div>";
                    $html .= "  <div><strong>Uso:</strong> {$uso}</div>";
                    $html .= '</div>';
                }
                $html .= '</div>';
                return $html;
            },
        ],
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

            'value' => function($model) {
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
                if ($model->ultimoChequeo) {
                  $dateTime = new DateTime($model->ultimoChequeo->fechahora);
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
