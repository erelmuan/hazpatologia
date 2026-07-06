<?php

$this->title = 'Diagnósticos CIE10';
use yii\helpers\Html;
?>

<style>

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
    font-weight:600;
    color:#5f6a6a;
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

.panel-diagnostico{
    background:white;
    border:1px solid #ececec;
    border-radius:6px;
    padding:20px;
}

.table{
    margin-bottom:0;
}

.table thead tr{
    background:#f8f9f9;
}

.badge-cie{
    background:#8e44ad;
    color:white;
    padding:6px 10px;
    border-radius:4px;
    font-size:12px;
}

.badge-pap{
    background:#27ae60;
    color:white;
    padding:5px 10px;
    border-radius:4px;
    font-size:12px;
}

.badge-biopsia{
    background:#e67e22;
    /* color:white; !important */
    padding:5px 10px;
    border-radius:4px;
    font-size:12px;
}

.nav-tabs > li > a{
    color:#2c3e50;
    font-weight:600;
}

.nav-tabs > li.active > a{
    background:#f8f9f9 !important;
}

.btn-editar{
    background:#f39c12;
    border-color:#f39c12;
    color:white;
}

.btn-editar:hover{
    background:#d68910;
    border-color:#d68910;
    color:white;
}

.btn-ver{
    background:#3498db;
    border-color:#3498db;
    color:white;
}

.btn-ver:hover{
    background:#2e86c1;
    border-color:#2e86c1;
    color:white;
}

</style>

<div class="x_panel">

    <div class="x_title">

        <h2>

            <i class="fa fa-notes-medical"></i>
            DIAGNÓSTICOS CIE10

        </h2>

        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/estadistica/index'], ['class'=>'btn btn-danger grid-button']) ?></div>

    </div>

    <div class="body-content">

        <!-- FILTROS -->

        <div class="filtro-box">

            <div class="filtro-titulo">

                <i class="fa fa-filter text-primary"></i>
                Filtros de búsqueda

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
                                Diagnóstico
                            </label>

                            <input type="text"
                                   class="form-control"
                                   placeholder="Buscar diagnóstico">

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Código CIE10
                            </label>

                            <input type="text"
                                   class="form-control"
                                   placeholder="Ej: N87.1">

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 text-right">

                        <button class="btn btn-filtrar">

                            <i class="fa fa-search"></i>
                            Buscar

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <!-- TABS -->

        <div class="panel-diagnostico">

            <ul class="nav nav-tabs">

                <li class="active">

                    <a data-toggle="tab"
                       href="#paps">

                        <i class="fa fa-vials text-success"></i>
                        PAPS

                    </a>

                </li>

                <li>

                    <a data-toggle="tab"
                       href="#biopsias">

                        <i class="fa fa-flask"
                           style="color:#e67e22;"></i>

                        BIOPSIAS

                    </a>

                </li>

            </ul>

            <div class="tab-content"
                 style="margin-top:20px;">

                <!-- PAPS -->

                <div id="paps"
                     class="tab-pane fade in active">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Paciente</th>
                                <th>Diagnóstico</th>
                                <th>CIE10</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th width="160">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>1203</td>

                                <td>
                                    María Gómez
                                </td>

                                <td>
                                    Lesión intraepitelial escamosa de bajo grado
                                </td>

                                <td>
                                    <span class="badge-cie">
                                        N87.0
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-pap">
                                        PAP
                                    </span>
                                </td>

                                <td>
                                    12/06/2026
                                </td>

                                <td>

                                    <button class="btn btn-xs btn-ver">

                                        <i class="fa fa-eye"></i>

                                    </button>

                                    <button class="btn btn-xs btn-editar">

                                        <i class="fa fa-edit"></i>

                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>1204</td>

                                <td>
                                    Laura Pérez
                                </td>

                                <td>
                                    ASC-US
                                </td>

                                <td>
                                    <span class="badge-cie">
                                        R87.6
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-pap">
                                        PAP
                                    </span>
                                </td>

                                <td>
                                    13/06/2026
                                </td>

                                <td>

                                    <button class="btn btn-xs btn-ver">

                                        <i class="fa fa-eye"></i>

                                    </button>

                                    <button class="btn btn-xs btn-editar">

                                        <i class="fa fa-edit"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- BIOPSIAS -->

                <div id="biopsias"
                     class="tab-pane fade">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Paciente</th>
                                <th>Diagnóstico</th>
                                <th>CIE10</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th width="160">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>882</td>

                                <td>
                                    Carlos Medina
                                </td>

                                <td>
                                    Adenocarcinoma de colon
                                </td>

                                <td>
                                    <span class="badge-cie">
                                        C18.9
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-biopsia">
                                        BIOPSIA
                                    </span>
                                </td>

                                <td>
                                    10/06/2026
                                </td>

                                <td>

                                    <button class="btn btn-xs btn-ver">

                                        <i class="fa fa-eye"></i>

                                    </button>

                                    <button class="btn btn-xs btn-editar">

                                        <i class="fa fa-edit"></i>

                                    </button>

                                </td>

                            </tr>

                            <tr>

                                <td>883</td>

                                <td>
                                    Ana Ruiz
                                </td>

                                <td>
                                    Gastritis crónica
                                </td>

                                <td>
                                    <span class="badge-cie">
                                        K29.5
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-biopsia">
                                        BIOPSIA
                                    </span>
                                </td>

                                <td>
                                    11/06/2026
                                </td>

                                <td>

                                    <button class="btn btn-xs btn-ver">

                                        <i class="fa fa-eye"></i>

                                    </button>

                                    <button class="btn btn-xs btn-editar">

                                        <i class="fa fa-edit"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
