// paciente.js
function agregarInput(id, text, nroafiliado) {
    if (nroafiliado == "") {
        nroafiliado = "";
    }
    var div = document.createElement('div');
    div.setAttribute('class', 'form-inline');
    div.setAttribute("id", "afiliado" + id);
    div.innerHTML = '<div style="clear:both" class="col-md-14"><b>N° Afiliado</b>' + ' (' + text + ') ' +
        '<input class="form-control" value="' + nroafiliado + '" name="nroafiliado[]" type="text" required/></div>';
    document.getElementById('afiliado').appendChild(div);
}

function pucoAjax() {
    var dni_paciente = document.getElementById('paciente-num_documento').value;
    var resultadoPuco = document.getElementById("resultadoPuco");
    resultadoPuco.value = "";
    resultadoPuco.placeholder = "Espere, buscando en el puco";

    $.ajax({
        url: PACIENTE_URLS.puco,
        type: 'POST',
        data: { dni: dni_paciente },
        dataType: 'json',
        success: function(data) {
            resultadoPuco.value = "";
            if (data.error) {
                resultadoPuco.placeholder = data.error;
            } else if (Array.isArray(data)) {
                resultadoPuco.value = data[0];
            } else if (data.resultado) {
                resultadoPuco.value = data.resultado;
            }
        },
        error: function() {
            resultadoPuco.placeholder = "Error en la consulta";
        }
    });
}

function consultarRenaper() {
    let dni_paciente = document.getElementById("paciente-num_documento").value;
    let sexo_paciente = document.getElementById("paciente-sexo").value;
    const btn = document.getElementById("btnRenaper");

    if (!dni_paciente || !sexo_paciente) {
        alert('Por favor, complete el DNI y el sexo del paciente');
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="mini-spinner"></span>';

    $.ajax({
        url: PACIENTE_URLS.renaper,
        type: 'post',
        data: {
            dni: dni_paciente,
            sexo: sexo_paciente
        },
        success: function(response) {
            btn.disabled = false;
            btn.innerHTML = 'R';

            if (response && response.success) {
                if (response.data.success && response.data.response && typeof response.data.response === 'object') {
                    const datos = response.data.response;

                    if (datos.nombre) {
                        document.getElementById('paciente-nombre').value = datos.nombre;
                    }
                    if (datos.apellido) {
                        document.getElementById('paciente-apellido').value = datos.apellido;
                    }
                    if (datos.fecha_nacimiento) {
                        const fechaParts = datos.fecha_nacimiento.split('-');
                        if (fechaParts.length === 3) {
                            const fechaFormateada = `${fechaParts[2]}/${fechaParts[1]}/${fechaParts[0]}`;
                            document.getElementById('paciente-fecha_nacimiento').value = datos.fecha_nacimiento;
                            document.getElementById('paciente-fecha_nacimiento-disp').value = fechaFormateada;
                        }
                    }
                    if (datos.sexo) {
                        document.getElementById('paciente-sexo').value = datos.sexo;
                    }
                } else if (!response.data.success && response.data.response === "Datos no encontrados") {
                    alert('No se encontraron datos para el DNI y sexo ingresados');
                } else {
                    alert('Error inesperado en la respuesta del servicio Renaper');
                }
            } else {
                alert(response.error || 'Error en la consulta al Renaper');
            }
        },
        error: function(xhr, status, error) {
            btn.disabled = false;
            btn.innerHTML = 'R';
            alert('Error al consultar el servicio. Por favor, intente nuevamente.');
            console.error('Error en la consulta:', error, xhr.responseText);
        }
    });
}

function quitarInput(id) {
    let element = document.getElementById("afiliado" + id);
    while (element.firstChild) {
        element.removeChild(element.firstChild);
    }
    element.remove();
}
