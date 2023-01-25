function quitarSeleccion() {
    $('span.kv-clear-radio').click();

}

function cambioFirma() {
    if (document.getElementById("biopsia-firmado").value == 1) {
        document.getElementById("biopsia-firmado").value = 0;

    } else {
        document.getElementById("biopsia-firmado").value = 1;
    }
}


function agregarFormularioMat() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        // $("span#select2-w2-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
        var textArea = document.getElementById('biopsia-material');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-material.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-material.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }
        // $("textarea#biopsia-material.form-control").val($("tr.success").find("td:eq(2)").text());
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

function quitarMaterial() {
    // $("span#select2-w2-container.select2-selection__rendered")[0].innerText ="";
    $("textarea#biopsia-material.form-control").val('');
}



function agregarFormularioMac() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        // $("span#select2-w3-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
        var textArea = document.getElementById('biopsia-macroscopia');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-macroscopia.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-macroscopia.form-control").val(textArea.value + "\r\n" + $("tr.success").find(
                "td:eq(2)").text());
        }
        // $("textarea#biopsia-macroscopia.form-control").val($("tr.success").find("td:eq(2)").text());
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

function quitarMacroscopia() {
    $("textarea#biopsia-macroscopia.form-control").val('');
}

function agregarFormularioMic() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('biopsia-microscopia');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-microscopia.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-microscopia.form-control").val(textArea.value + "\r\n" + $("tr.success").find(
                "td:eq(2)").text());
        }
        // $("textarea#biopsia-microscopia.form-control").val($("tr.success").find("td:eq(2)").text());
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

function quitarMicroscopia() {
    $("textarea#biopsia-microscopia.form-control").val('');
}

function agregarFormularioDiag() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('biopsia-diagnostico');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-diagnostico.form-control").val(textArea.value + "\r\n" + $("tr.success").find(
                "td:eq(2)").text());
        }

        // $("textarea#biopsia-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
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
    $("textarea#biopsia-diagnostico.form-control").val('');
    $("#biopsia-cie10.form-control").val('');
    $("#biopsia-id_cie10.form-control").val('');

}


function agregarFormularioFra() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('biopsia-frase');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-frase.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-frase.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
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
    $("textarea#biopsia-frase.form-control").val('');

}
function agregarFormularioCie10() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        $("#biopsia-cie10").val($("tr.success").find("td:eq(2)").text());
        $("#biopsia-id_cie10").val($("tr.success").find("td:eq(1)").text());
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
    $("#biopsia-cie10.form-control").val('');
    $("#biopsia-id_cie10.form-control").val('');
}
