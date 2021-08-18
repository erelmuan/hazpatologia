<?
use kartik\grid\GridView;

$columnsFlora=
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
          'attribute'=>'flora',
      ],
    ];


    $columnsAspecto=
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
              'attribute'=>'aspecto',
          ],
        ];
  $columnsGlandular=
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
        'attribute'=>'glandular',
    ],

  ];

  $columnsPavimentosa=
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
            'attribute'=>'pavimentosa',
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
                    <div class="modal fade bs-flora-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="plantillaflora-index">
                                <div id="ajaxCrudDatatable">
                                    <?=GridView::widget([
                                        'id'=>'crud-flora',
                                        'dataProvider' => $provider['dataProviderFlora'],
                                        'filterModel' => $search['searchModelFlora'],
                                        'pjax'=>true,
                                        'columns' => $columnsFlora,
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
                              <button type="button"  onclick='agregarFormularioFlo();' class="btn btn-primary">Agregar al formulario</button>
                            </div>
                      </div>
                    </div>
                  </div>
              </div>
        </div>

  <div class="x_content">
        <div class="modal fade bs-aspecto-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">


              <div class="modal-body">
                <div class="plantillaaspecto-index">
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crud-aspecto',
                            'dataProvider' => $provider['dataProviderAsp'],
                            'filterModel' => $search['searchModelAsp'],
                            'pjax'=>true,
                            'columns' => $columnsAspecto,
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
                  <button type="button"  onclick='agregarFormularioAsp();' class="btn btn-primary">Agregar al formulario</button>
                </div>
          </div>
        </div>
      </div>
  </div>
</div>


<div class="x_content">
            <div class="modal fade bs-glandular-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="plantillaglandular-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                                'id'=>'crud-glandular',
                                'dataProvider' => $provider['dataProviderGland'],
                                'filterModel' => $search['searchModelGland'],
                                'pjax'=>true,
                                'columns' => $columnsGlandular,
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
                      <button type="button"  onclick='agregarFormularioGland();' class="btn btn-primary">Agregar al formulario</button>
                    </div>
              </div>
            </div>
          </div>
      </div>
</div>

<div class="x_content">
            <div class="modal fade bs-pavimentosa-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="Plantillapavimentosa-index">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                                'id'=>'crud-pavimentosa',
                                'dataProvider' => $provider['dataProviderPav'],
                                'filterModel' => $search['searchModelPav'],
                                'pjax'=>true,
                                'columns' => $columnsPavimentosa,
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
                      <button type="button"  onclick='agregarFormularioPav();' class="btn btn-primary">Agregar al formulario</button>
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
            <div class="modal fade bs-frase-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
