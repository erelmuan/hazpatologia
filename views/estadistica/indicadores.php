<?php

$this->title = 'Indicadores';
use yii\helpers\Html;
?>

<style>

.kpi-box{
    background: transparent;
    border:1px solid #ececec;
    border-radius:6px;
    padding:20px;
    margin-bottom:20px;
    min-height:160px;
    transition:0.2s;
}

.kpi-box:hover{
    border-color:#dcdcdc;
    background:#fcfcfc;
}

.kpi-numero{
    font-size:48px;
    font-weight:600;
    color:#2c3e50;
    line-height:1;
}

.kpi-titulo{
    margin-top:10px;
    font-size:13px;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#95a5a6;
    font-weight:bold;
}

.kpi-detalle{
    margin-top:12px;
    color:#7f8c8d;
    font-size:13px;
}

.kpi-icono{
    float:right;
    font-size:42px;
    margin-top:-5px;
}

/* COLORES KPIS */

.kpi-purple{
    color:#8e44ad;
}

.kpi-green{
    color:#27ae60;
}

.kpi-orange{
    color:#f39c12;
}

.kpi-blue{
    color:#3498db;
}

/* FILTROS */

.filtro-box{
    background:transparent;
    border:1px solid #ececec;
    border-radius:6px;
    padding:20px;
    margin-bottom:25px;
}

.filtro-titulo{
    font-size:18px;
    font-weight:600;
    color:#2c3e50;
    margin-bottom:20px;
}

.form-group label{
    color:#5f6a6a;
    font-weight:600;
}

.btn-filtrar{
    background:#3498db;
    border-color:#3498db;
    color:white;
}

.btn-filtrar:hover{
    background:#2e86c1;
    border-color:#2e86c1;
    color:white;
}

.btn-limpiar{
    background:#95a5a6;
    border-color:#95a5a6;
    color:white;
}

.btn-limpiar:hover{
    background:#7f8c8d;
    border-color:#7f8c8d;
    color:white;
}

/* PANELES */

.panel-estadistico{
    background:white;
    border:1px solid #ececec;
    border-radius:6px;
    padding:20px;
    margin-top:10px;
    min-height:260px;
}

.panel-estadistico h4{
    margin-top:0;
    margin-bottom:20px;
    color:#2c3e50;
    font-weight:600;
}

.lista-estadistica{
    padding-left:18px;
}

.lista-estadistica li{
    margin-bottom:12px;
    color:#5f6a6a;
}

</style>

<div class="x_panel">

    <div class="x_title">

        <h2>
            <i class="fa fa-chart-pie"></i>
            INDICADORES
        </h2>

        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/estadistica/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>

    <div class="body-content">

        <!-- FILTROS -->

        <div class="filtro-box">

            <div class="filtro-titulo">

                <i class="fa fa-filter text-primary"></i>
                Filtros de indicadores

            </div>

            <form>

                <div class="row">

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Fecha desde
                            </label>

                            <input type="date"
                                   class="form-control"
                                   value="2026-01-01">

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Fecha hasta
                            </label>

                            <input type="date"
                                   class="form-control"
                                   value="2026-06-30">

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Tipo de estudio
                            </label>

                            <select class="form-control">

                                <option selected>
                                    Todos
                                </option>

                                <option>
                                    Biopsias
                                </option>

                                <option>
                                    Paps
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Procedencia
                            </label>

                            <select class="form-control">

                                <option selected>
                                    Todas
                                </option>

                                <option>
                                    Hospitalaria
                                </option>

                                <option>
                                    Centro Salud
                                </option>

                                <option>
                                    Extra Hospitalaria
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Profesional
                            </label>

                            <select class="form-control">

                                <option selected>
                                    Todos
                                </option>

                                <option>
                                    Dr A
                                </option>

                                <option>
                                    Dr B
                                </option>

                                <option>
                                    Dr C
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-9 text-right"
                         style="margin-top:25px;">

                        <button class="btn btn-filtrar">

                            <i class="fa fa-search"></i>
                            Aplicar filtros

                        </button>

                        <button class="btn btn-limpiar"
                                type="reset">

                            <i class="fa fa-eraser"></i>
                            Limpiar

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <!-- KPIS -->

        <div class="row">

            <div class="col-md-3">

                <div class="kpi-box">

                    <div class="kpi-icono kpi-purple">
                        <i class="fa fa-flask"></i>
                    </div>

                    <div class="kpi-numero">
                        3808
                    </div>

                    <div class="kpi-titulo">
                        Biopsias
                    </div>

                    <div class="kpi-detalle">
                        Estudios anatomopatológicos procesados.
                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="kpi-box">

                    <div class="kpi-icono kpi-green">
                        <i class="fa fa-vials"></i>
                    </div>

                    <div class="kpi-numero">
                        6104
                    </div>

                    <div class="kpi-titulo">
                        Paps
                    </div>

                    <div class="kpi-detalle">
                        Citologías registradas en el sistema.
                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="kpi-box">

                    <div class="kpi-icono kpi-orange">
                        <i class="fa fa-file-alt"></i>
                    </div>

                    <div class="kpi-numero">
                        11073
                    </div>

                    <div class="kpi-titulo">
                        Solicitudes
                    </div>

                    <div class="kpi-detalle">
                        Solicitudes ingresadas al laboratorio.
                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="kpi-box">

                    <div class="kpi-icono kpi-blue">
                        <i class="fa fa-clock"></i>
                    </div>

                    <div class="kpi-numero">
                        4.2
                    </div>

                    <div class="kpi-titulo">
                        Días promedio
                    </div>

                    <div class="kpi-detalle">
                        Tiempo promedio de respuesta.
                    </div>

                </div>

            </div>

        </div>

        <!-- DETALLES -->

        <div class="row">

            <div class="col-md-6">

                <div class="panel-estadistico">

                    <h4>
                        <i class="fa fa-chart-bar text-primary"></i>
                        Indicadores principales
                    </h4>

                    <ul class="lista-estadistica">

                        <li>
                            Total estudios finalizados: <strong>92%</strong>
                        </li>

                        <li>
                            Tiempo promedio de entrega: <strong>4.2 días</strong>
                        </li>

                        <li>
                            Procedencia hospitalaria predominante.
                        </li>

                        <li>
                            Incremento mensual del 12%.
                        </li>

                    </ul>

                </div>

            </div>

            <div class="col-md-6">

                <div class="panel-estadistico">

                    <h4>
                        <i class="fa fa-info-circle text-info"></i>
                        Resumen ejecutivo
                    </h4>

                    <ul class="lista-estadistica">

                        <li>
                            Disminución de pendientes respecto al mes anterior.
                        </li>

                        <li>
                            Mayor volumen de trabajo en ginecología.
                        </li>

                        <li>
                            Incremento sostenido de solicitudes externas.
                        </li>

                        <li>
                            Buen cumplimiento en tiempos de respuesta.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>
