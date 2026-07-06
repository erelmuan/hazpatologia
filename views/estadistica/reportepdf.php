<?php

$this->title = 'Reportes PDF';
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

/* LISTADO PDF */

.pdf-box{
    background:transparent;
    border:1px solid #ececec;
    border-radius:6px;
    padding:18px;
    margin-bottom:15px;
    transition:0.2s;
}

.pdf-box:hover{
    border-color:#d8d8d8;
    background:#fcfcfc;
}

.pdf-icono{
    font-size:42px;
    color:#e74c3c;
    float:left;
    width:60px;
}

.pdf-contenido{
    margin-left:70px;
}

.pdf-titulo{
    font-size:17px;
    font-weight:600;
    color:#2c3e50;
    margin-bottom:5px;
}

.pdf-detalle{
    color:#7f8c8d;
    margin-bottom:10px;
    font-size:13px;
}

.pdf-meta{
    font-size:12px;
    color:#95a5a6;
}

.btn-descargar{
    background:#27ae60;
    border-color:#27ae60;
    color:white;
}

.btn-descargar:hover{
    background:#229954;
    border-color:#229954;
    color:white;
}

.btn-vista{
    background:#3498db;
    border-color:#3498db;
    color:white;
}

.btn-vista:hover{
    background:#2e86c1;
    border-color:#2e86c1;
    color:white;
}

.seccion-titulo{
    font-size:18px;
    font-weight:600;
    margin-bottom:20px;
    color:#2c3e50;
}

</style>

<div class="x_panel">

    <div class="x_title">

        <h2>

            <i class="fa fa-file-pdf"></i>
            REPORTES PDF

        </h2>

        <div class="clearfix"></div>

    </div>

    <div class="body-content">

        <!-- FILTROS -->

        <div class="filtro-box">

            <div class="filtro-titulo">

                <i class="fa fa-filter text-primary"></i>
                Filtros de reportes

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
                    <div class="col-md-3">

                <div class="form-group">

                    <label>
                        Estado del estudio
                    </label>

                    <select class="form-control">

                        <option selected>
                            Todos
                        </option>

                        <option>
                            Pendiente
                        </option>

                        <option>
                            En proceso
                        </option>

                        <option>
                            Informado
                        </option>

                        <option>
                            Entregado
                        </option>

                        <option>
                            Anulado
                        </option>

                    </select>

                </div>

            </div>

                    <div class="col-md-3">

                        <div class="form-group">

                            <label>
                                Tipo de reporte
                            </label>

                            <select class="form-control">

                                <option selected>
                                    Todos
                                </option>

                                <option>
                                    Productividad
                                </option>

                                <option>
                                    Diagnósticos
                                </option>

                                <option>
                                    Estadístico
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-6 text-right"
                         style="margin-top:25px;">

                        <button class="btn btn-filtrar">

                            <i class="fa fa-search"></i>
                            Buscar reportes

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

        <!-- RESULTADOS -->

        <div class="seccion-titulo">

            <i class="fa fa-folder-open text-danger"></i>
            Reportes encontrados

        </div>

        <!-- PDF 1 -->

        <div class="pdf-box">

            <div class="pdf-icono">

                <i class="fa fa-file-pdf"></i>

            </div>

            <div class="pdf-contenido">

                <div class="pdf-titulo">

                    Estadística mensual de biopsias

                </div>

                <div class="pdf-detalle">

                    Reporte institucional con cantidad de biopsias,
                    tiempos de respuesta y productividad por profesional.

                </div>

                <div class="pdf-meta">

                    Generado: 12/06/2026 —
                    Período: Enero 2026 / Junio 2026

                </div>

                <br>

                <button class="btn btn-xs btn-vista">

                    <i class="fa fa-eye"></i>
                    Vista previa

                </button>

                <button class="btn btn-xs btn-descargar">

                    <i class="fa fa-download"></i>
                    Descargar PDF

                </button>

            </div>

        </div>

        <!-- PDF 2 -->

        <div class="pdf-box">

            <div class="pdf-icono">

                <i class="fa fa-file-pdf"></i>

            </div>

            <div class="pdf-contenido">

                <div class="pdf-titulo">

                    Diagnósticos CIE10 más frecuentes

                </div>

                <div class="pdf-detalle">

                    Informe estadístico con distribución de diagnósticos
                    anatomopatológicos y citológicos.

                </div>

                <div class="pdf-meta">

                    Generado: 10/06/2026 —
                    Área: Estadística

                </div>

                <br>

                <button class="btn btn-xs btn-vista">

                    <i class="fa fa-eye"></i>
                    Vista previa

                </button>

                <button class="btn btn-xs btn-descargar">

                    <i class="fa fa-download"></i>
                    Descargar PDF

                </button>

            </div>

        </div>

        <!-- PDF 3 -->

        <div class="pdf-box">

            <div class="pdf-icono">

                <i class="fa fa-file-pdf"></i>

            </div>

            <div class="pdf-contenido">

                <div class="pdf-titulo">

                    Solicitudes externas por localidad

                </div>

                <div class="pdf-detalle">

                    Distribución geográfica de derivaciones y solicitudes
                    extra hospitalarias.

                </div>

                <div class="pdf-meta">

                    Generado: 08/06/2026 —
                    Procedencia: Extra hospitalaria

                </div>

                <br>

                <button class="btn btn-xs btn-vista">

                    <i class="fa fa-eye"></i>
                    Vista previa

                </button>

                <button class="btn btn-xs btn-descargar">

                    <i class="fa fa-download"></i>
                    Descargar PDF

                </button>

            </div>

        </div>

        <!-- PDF 4 -->

        <div class="pdf-box">

            <div class="pdf-icono">

                <i class="fa fa-file-pdf"></i>

            </div>

            <div class="pdf-contenido">

                <div class="pdf-titulo">

                    Rendimiento y tiempos de entrega

                </div>

                <div class="pdf-detalle">

                    Comparativa mensual de informes emitidos,
                    pendientes y tiempos promedio de resolución.

                </div>

                <div class="pdf-meta">

                    Generado: 07/06/2026 —
                    Indicadores institucionales

                </div>

                <br>

                <button class="btn btn-xs btn-vista">

                    <i class="fa fa-eye"></i>
                    Vista previa

                </button>

                <button class="btn btn-xs btn-descargar">

                    <i class="fa fa-download"></i>
                    Descargar PDF

                </button>

            </div>

        </div>

    </div>

</div>
