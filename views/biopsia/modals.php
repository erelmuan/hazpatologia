<?
use kartik\grid\GridView;

?>

<?

    $columnsMaterial=
        [
          [
              'class' => '\kartik\grid\RadioColumn',
              'width' => '20px',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'codigo',
          ],
          [
              'class'=>'\kartik\grid\DataColumn',
              'attribute'=>'material',
          ],

        ];
  $columnsMacroscopia=
  [
    [
        'class' => '\kartik\grid\RadioColumn',
        'width' => '20px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'codigo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'macroscopia',
    ],

  ];

  $columnsMicroscopia=
      [
        [
            'class' => '\kartik\grid\RadioColumn',
            'width' => '20px',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'codigo',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'microscopia',
        ],
      ];
      $columnsDiagnostico=[
        [
            'class' => '\kartik\grid\RadioColumn',
            'width' => '20px',
        ],
        [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'codigo',
        ],
        [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'diagnostico',
        ],

      ];
      $columnsFrase=[
        [
            'class' => '\kartik\grid\RadioColumn',
            'width' => '20px',
        ],
      [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'codigo',
      ],
      [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>'frase',
      ],
      ];

?>

  <div class="x_content">
        <div class="modal fade bs-material-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body">
                <div class="plantillamaterialb-index">
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crud-material',
                            'dataProvider' => $provider['dataProviderMat'],
                            'filterModel' => $search['searchModelMat'],
                            'pjax'=>true,
                            'columns' => $columnsMaterial,
                            'toolbar'=> [
                                // ['content'=>
                                //     Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                                //     ['role'=>'modal-remote','title'=> 'Agrega dato al formulario','class'=>'btn btn-default']),
                                // ],
                            ],

                            'panel' => [
                                'type' => 'primary',
                                'heading'=> false,

                            ]
                        ])
                        ?>
                      </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button"  onclick='agregarFormularioMat();' class="btn btn-primary">Agregar al formulario</button>
                </div>
          </div>
        </div>
      </div>
  </div>
</div>


<div class="x_content">
            <div class="modal fade bs-microscopia-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="plantillamicroscopia-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                                'id'=>'crud-microscopia',
                                'dataProvider' => $provider['dataProviderMic'],
                                'filterModel' => $search['searchModelMic'],
                                'pjax'=>true,
                                'columns' => $columnsMicroscopia,
                                'toolbar'=> [

                                ],
                                'panel' => [
                                    'type' => 'primary',
                                    'heading'=> false,
                                ]
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="button"  onclick='agregarFormularioMic();' class="btn btn-primary">Agregar al formulario</button>
                    </div>
              </div>
            </div>
          </div>
      </div>
</div>

<div class="x_content">
            <div class="modal fade bs-macroscopia-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="plantillamacroscopia-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                                'id'=>'crud-macroscopia',
                                'dataProvider' => $provider['dataProviderMac'],
                                'filterModel' => $search['searchModelMac'],
                                'pjax'=>true,
                                'columns' => $columnsMacroscopia,
                                'toolbar'=> [

                                ],
                                'panel' => [
                                    'type' => 'primary',
                                    'heading'=> false,
                                ]
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="button"  onclick='agregarFormularioMac();' class="btn btn-primary">Agregar al formulario</button>
                    </div>
              </div>
            </div>
          </div>
      </div>
</div>

<div class="x_content">
            <div class="modal fade bs-diagnostico-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="plantilladiagnostico-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                                'id'=>'crud-diagnostico',
                                'dataProvider' => $provider['dataProviderDiag'],
                                'filterModel' => $search['searchModelDiag'],
                                'pjax'=>true,
                                'columns' => $columnsDiagnostico,
                                'toolbar'=> [

                                ],
                                'panel' => [
                                    'type' => 'primary',
                                    'heading'=> false,
                                ]
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="button"  onclick='agregarFormularioDiag();' class="btn btn-primary">Agregar al formulario</button>
                    </div>
              </div>
            </div>
          </div>
      </div>
</div>

<div class="x_content">
            <div class="modal fade bs-frases-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="plantillafrases-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                                'id'=>'crud-frases',
                                'dataProvider' => $provider['dataProviderFra'],
                                'filterModel' => $search['searchModelFra'],
                                'pjax'=>true,
                                'columns' => $columnsFrase,
                                'toolbar'=> [

                                ],
                                'panel' => [
                                    'type' => 'primary',
                                    'heading'=> false,
                                ]
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="button"  onclick='agregarFormularioFra();' class="btn btn-primary">Agregar al formulario</button>
                    </div>
              </div>
            </div>
          </div>
      </div>
</div>
