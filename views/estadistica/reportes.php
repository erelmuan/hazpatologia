<?php

$this->title = 'Reportes';
use yii\helpers\Html;
?>

<style>

.reporte-box{
    background:transparent;
    border:1px solid #ececec;
    border-radius:6px;
    padding:22px;
    margin-bottom:20px;
    transition:0.2s;
    min-height:240px;
}

.reporte-box:hover{
    border-color:#dcdcdc;
    background:#fcfcfc;
}

.reporte-icono{
    font-size:42px;
    margin-bottom:20px;
}

/* COLORES ICONOS */

.icon-pdf{
    color:#e74c3c;
}

.icon-excel{
    color:#27ae60;
}

.icon-estadistica{
    color:#3498db;
}

.reporte-titulo{
    font-size:20px;
    font-weight:600;
    color:#2c3e50;
    margin-bottom:12px;
}

.reporte-detalle{
    color:#7f8c8d;
    margin-bottom:20px;
}

.lista-reportes{
    padding-left:18px;
    margin-bottom:20px;
}

.lista-reportes li{
    margin-bottom:8px;
    color:#5f6a6a;
}

/* BOTONES */

.btn-reporte-pdf{
    background:#e74c3c;
    border-color:#e74c3c;
    color:white;
}

.btn-reporte-pdf:hover{
    background:#cb4335;
    border-color:#cb4335;
    color:white;
}

.btn-reporte-excel{
    background:#27ae60;
    border-color:#27ae60;
    color:white;
}

.btn-reporte-excel:hover{
    background:#229954;
    border-color:#229954;
    color:white;
}

.btn-reporte-estadistica{
    background:#3498db;
    border-color:#3498db;
    color:white;
}

.btn-reporte-estadistica:hover{
    background:#2e86c1;
    border-color:#2e86c1;
    color:white;
}

</style>

<div class="x_panel">

    <div class="x_title">

        <h2>
            <i class="fa fa-file-alt"></i>
            REPORTES
        </h2>

        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/estadistica/index'], ['class'=>'btn btn-danger grid-button']) ?></div>

    </div>

    <div class="body-content">

        <div class="row">

            <div class="col-md-4">

                <div class="reporte-box">

                    <div class="reporte-icono icon-pdf">
                        <i class="fa fa-file-pdf"></i>
                    </div>

                    <div class="reporte-titulo">
                        Reportes PDF
                    </div>

                    <div class="reporte-detalle">
                        Informes listos para impresión institucional.
                    </div>

                    <ul class="lista-reportes">

                        <li>Estudios por período</li>
                        <li>Productividad</li>
                        <li>Resumen mensual</li>
                        <li>Informe consolidado</li>

                    </ul>

                    <a href="<?= Yii::$app->homeUrl . 'estadistica/reportepdf'; ?>"
                       class="btn btn-reporte-pdf">

                        <i class="fa fa-file-pdf"></i>
                        Ver reporte

                    </a>

                </div>

            </div>

            <div class="col-md-4">

                <div class="reporte-box">

                    <div class="reporte-icono icon-excel">
                        <i class="fa fa-file-excel"></i>
                    </div>

                    <div class="reporte-titulo">
                        Exportación Excel
                    </div>

                    <div class="reporte-detalle">
                        Exportación de datos para auditorías y análisis.
                    </div>

                    <ul class="lista-reportes">

                        <li>Exportación filtrada</li>
                        <li>Listado completo</li>
                        <li>Estudios pendientes</li>
                        <li>Datos estadísticos</li>

                    </ul>

                    <button class="btn btn-reporte-excel">
                        <i class="fa fa-file-excel"></i>
                        Exportar Excel
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
