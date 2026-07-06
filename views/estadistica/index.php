<?php

use kartik\icons\Icon;

Icon::map($this, Icon::WHHG);

$this->title = 'Estadísticas';
?>

<div class="x_panel">

    <div class="x_title">
        <h2>
            <i class="fa fa-chart-line"></i>
            ESTADÍSTICAS
        </h2>

        <div class="clearfix"></div>
    </div>

    <div class="body-content">

        <div class="row top_tiles">

            <!-- GRAFICOS -->
            <a href="<?= Yii::$app->homeUrl . 'estadistica/graficos'; ?>">

                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <div class="tile-stats">

                        <div class="icon">
                            <i class="fa fa-chart-bar" style="color:#5dade2;"></i>
                        </div>

                        <div class="count">8</div>

                        <h3>GRÁFICOS</h3>

                        <p>
                            Dashboards y gráficos interactivos.
                        </p>

                    </div>

                </div>

            </a>


            <!-- REPORTES -->
            <a href="<?= Yii::$app->homeUrl . 'estadistica/reportes'; ?>">

                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <div class="tile-stats">

                        <div class="icon">
                            <i class="fa fa-file-text" style="color:#58d68d;"></i>
                        </div>

                        <div class="count">12</div>

                        <h3>REPORTES</h3>

                        <p>
                            Reportes estadísticos del laboratorio.
                        </p>

                    </div>

                </div>

            </a>


            <!-- EXPORTAR -->
            <a href="<?= Yii::$app->homeUrl . 'estadistica/exportar'; ?>">

                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <div class="tile-stats">

                        <div class="icon">
                            <i class="fa fa-notes-medical" style="color:#f5b041;"></i>
                        </div>

                        <div class="count">4</div>

                        <h3>CODIFICACIÓN</h3>

                        <p>
                            Exportación PDF y Excel.
                        </p>

                    </div>

                </div>

            </a>


            <!-- INDICADORES -->
            <a href="<?= Yii::$app->homeUrl . 'estadistica/indicadores'; ?>">

                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <div class="tile-stats">

                        <div class="icon">
                            <i class="fa fa-chart-pie" style="color:#af7ac5;"></i>
                        </div>

                        <div class="count">15</div>

                        <h3>INDICADORES</h3>

                        <p>
                            Indicadores institucionales.
                        </p>

                    </div>

                </div>

            </a>


        </div>

    </div>

</div>
