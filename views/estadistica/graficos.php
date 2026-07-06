<?php

$this->title = 'Gráficos';
use yii\helpers\Html;
?>

<style>

.grafico-box{
    background:transparent;
    border:1px solid #ececec;
    border-radius:6px;
    padding:20px;
    margin-bottom:20px;
}

.grafico-box:hover{
    border-color:#d8d8d8;
}

.grafico-titulo{
    font-size:18px;
    font-weight:600;
    color:#2c3e50;
    margin-bottom:20px;
}

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

</style>

<div class="x_panel">

    <div class="x_title">

        <h2>
            <i class="fa fa-chart-bar"></i>
            GRÁFICOS
        </h2>
        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/estadistica/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
        <div class="clearfix"></div>

    </div>

    <div class="body-content">

        <!-- FILTROS -->

        <div class="filtro-box">

            <div class="filtro-titulo">
                <i class="fa fa-filter text-primary"></i>
                Filtros estadísticos
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

                                <option>
                                    Todos
                                </option>

                                <option selected>
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
                                Agrupar por
                            </label>

                            <select class="form-control">

                                <option>
                                    Día
                                </option>

                                <option selected>
                                    Mes
                                </option>

                                <option>
                                    Año
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="col-md-6 text-right"
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

        <!-- GRAFICOS -->

        <div class="row">

            <div class="col-md-8">

                <div class="grafico-box">

                    <div class="grafico-titulo">
                        Estudios por mes
                    </div>

                    <canvas id="chartMes"></canvas>

                </div>

            </div>

            <div class="col-md-4">

                <div class="grafico-box">

                    <div class="grafico-titulo">
                        Procedencias
                    </div>

                    <canvas id="chartProcedencia"></canvas>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="grafico-box">

                    <div class="grafico-titulo">
                        Productividad mensual
                    </div>

                    <canvas id="chartProductividad"></canvas>

                </div>

            </div>

            <div class="col-md-6">

                <div class="grafico-box">

                    <div class="grafico-titulo">
                        Informes emitidos
                    </div>

                    <canvas id="chartInformes"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('chartMes'), {

    type: 'line',

    data: {

        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],

        datasets: [{

            label: 'Estudios',

            data: [500, 800, 1200, 950, 1400, 1300],

            borderWidth: 2,
            tension: 0.3

        }]

    }

});

new Chart(document.getElementById('chartProcedencia'), {

    type: 'doughnut',

    data: {

        labels: [
            'Hospitalaria',
            'Centro Salud',
            'Extra Hospitalaria'
        ],

        datasets: [{

            data: [55, 25, 20]

        }]

    }

});

new Chart(document.getElementById('chartProductividad'), {

    type: 'bar',

    data: {

        labels: ['Dr A', 'Dr B', 'Dr C', 'Dr D'],

        datasets: [{

            label: 'Estudios',

            data: [120, 190, 95, 160]

        }]

    }

});

new Chart(document.getElementById('chartInformes'), {

    type: 'pie',

    data: {

        labels: ['Emitidos', 'Pendientes'],

        datasets: [{

            data: [92, 8]

        }]

    }

});

</script>
