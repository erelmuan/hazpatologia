function quitarSeleccion() {
    $('span.kv-clear-radio').click();

}

function agregarFormularioFlo() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('pap-flora');
        if (textArea.value.trim() == "") {
            $("textarea#pap-flora.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#pap-flora.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)").text());
        }

        // $("textarea#pap-flora.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();
    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarFlora() {
    $("textarea#pap-flora.form-control").val('');
}

function agregarFormularioAsp() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('pap-aspecto');
        if (textArea.value.trim() == "") {
            $("textarea#pap-aspecto.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#pap-aspecto.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
            .text());
        }

        // $("textarea#pap-aspecto.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarAspecto() {
    $("textarea#pap-aspecto.form-control").val('');
}

function agregarFormularioPav() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('pap-pavimentosas');
        if (textArea.value.trim() == "") {
            $("textarea#pap-pavimentosas.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#pap-pavimentosas.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }
        // $("textarea#pap-pavimentosas.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarPavimentosas() {
    $("textarea#pap-pavimentosas.form-control").val('');
}

function agregarFormularioGland() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('pap-glandulares');
        if (textArea.value.trim() == "") {
            $("textarea#pap-glandulares.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#pap-glandulares.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }

        // $("textarea#pap-glandulares.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarGlandular() {
    $("textarea#pap-glandulares.form-control").val('');
}

function agregarFormularioDiag() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('pap-diagnostico');
        if (textArea.value.trim() == "") {
            $("textarea#pap-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#pap-diagnostico.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }
        // $("textarea#pap-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarDiagnostico() {
    $("textarea#pap-diagnostico.form-control").val('');
    $("#pap-cie10.form-control").val('');
    $("#pap-id_cie10.form-control").val('');
}

function agregarFormularioFra() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('pap-frase');
        if (textArea.value.trim() == "") {
            $("textarea#pap-frase.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#pap-frase.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)").text());
        }
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }

}

function quitarFrase() {
    $("textarea#pap-frase.form-control").val('');

}
function agregarFormularioCie10() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        $("#pap-cie10").val($("tr.success").find("td:eq(2)").text());
        $("#pap-id_cie10").val($("tr.success").find("td:eq(1)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }

}

function quitarCie10() {
    $("#pap-cie10.form-control").val('');
    $("#pap-id_cie10.form-control").val('');
}
