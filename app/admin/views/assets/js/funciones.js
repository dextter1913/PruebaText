$(document).ready(function () {
    console.log('Hola desde jquery seccion admin');
    EnviarMensajesChat();
    setInterval('MostrarMensajesChat()', 3000);
    setInterval('MostrarCantidadSalasChatAbiertas()', 3000);
    setInterval('MostrarCantidadSalasChatCerradas()', 3000);
    setInterval('MostrarCantidadSalasChatAsignadas()', 3000);
    TablaChatAsignadoAgente();
    InsertarMensajeDespedida();
    MostrarMensajesDespedida();
    DeleteMensajeDespedida();
    CreateTransferirChat();
    ReadTransferenciaChat();
    ReadSalasChatTransferencia();
    ReadDialogsAsignadosAgente();
    ReadAgentes();
    IngresarAgente();
    IngresoAccessWebToken();
    ReadAccesWebToken();
    ValidacionCantidadMaximaCaracteres();
    MostrarCantidadSalasChatAbiertas();
});


//Funcion para mostrar Datatable por Ajax
var ReadAgentes = function () {
    var table = $('#TablaAgentes').DataTable({
        "ajax": {
            "method": "POST",
            "url": "Datatable"
        },
        "columns": [
            { "data": "usuario" },
            { "data": "nombre" },
            { "data": "apellido" },
            { "data": "password" }
        ]
    });
}

//Ingresar Agente por ajax en el boton de dicho formulario
let IngresarAgente = function () {
    $('#btnRegistrarAgente').click(function (e) {
        e.preventDefault();


        let Formulario = $('#frmIngresarAgente').serialize();
        $.ajax({
            type: "POST",
            url: "AgregarAgente",
            data: Formulario,
            success: function (Respuesta) {
                $('#RespuestaIngresoAgentes').css('color', 'Green').html(Respuesta);
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });

        //Limpiando vasillas y desmarcando checkbox
        $('#user').val('');
        $('#nombre').val('');
        $('#apellido').val('');
        $('#documento').val('');
        $('#telefono').val('');
        $('#direccion').val('');
        $('#correo').val('');
        $('#password').val('');
        $('#ConfirmacionPassword').val('');
    });


}

//Ingreso de AccesWebToken
var IngresoAccessWebToken = function () {
    $('#btnIngresoAccesWebToken').click(function (e) {
        e.preventDefault();
        var form = $('#frmAccesWebToken').serialize();

        $.ajax({
            type: "POST",
            url: "InsertAccesWebToken",
            data: form,
            success: function (Respuesta) {
                $('#RespuestaIngresoToken').html(Respuesta)
                console.log(Respuesta);
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
        $('#instancia').val('');
        $('#token').val('');
        ReadAccesWebToken();
    });
}

//Read AccesWebToken
var ReadAccesWebToken = function () {
    $.ajax({
        type: "GET",
        url: "ReadAccesWebToken",
        success: function (Respuesta) {
            let json = JSON.parse(Respuesta);
            let tbody = '';
            json.forEach(
                Consulta => {
                    tbody += `
                        <tr>
                            <td>${Consulta.idToken}</td>
                            <td>${Consulta.Instance}</td>
                            <td>${Consulta.Token}</td>
                        </tr>
                        `
                });
            $('#TablaTokenChatApi').html(tbody);
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}





//TODO LO RELACIONADO CON EL CHAT
//Enviar mensajes de chat
var EnviarMensajesChat = function () {
    $('#btnEnviarMensajeWhatsapp').click(function (e) {
        e.preventDefault();

        var form = $('#frmMostrarChat').serialize();
        $.ajax({
            type: "POST",
            url: "EnviarMensajesChat",
            data: form,
            success: function (Respuesta) {
                console.log(Respuesta);
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
        //MostrarMensajesChat();
        $('#txtCuerpoMensage').val('');
    });
}

//Validacion de maxima cantidad de caracteres
var ValidacionCantidadMaximaCaracteres = function () {
    $('#CantidadCaracteresMaximos').text('60 carácteres restantes');
    $('#txtCuerpoMensage').keydown(function () {
        var max = 60;
        var len = $(this).val().length;
        if (len >= max) {
            $('#CantidadCaracteresMaximos').text('Has llegado al límite');// Aquí enviamos el mensaje a mostrar          
            $('#CantidadCaracteresMaximos').addClass('text-danger');
            $('#txtCuerpoMensage').addClass('is-invalid');
            $('#btnEnviarMensajeWhatsapp').addClass('disabled');
            document.getElementById('btnEnviarMensajeWhatsapp').disabled = true;
        }
        else {
            var ch = max - len;
            $('#CantidadCaracteresMaximos').text(ch + ' carácteres restantes');
            $('#CantidadCaracteresMaximos').removeClass('text-danger');
            $('#txtCuerpoMensage').removeClass('is-invalid');
            $('#btnEnviarMensajeWhatsapp').removeClass('disabled');
            document.getElementById('btnEnviarMensajeWhatsapp').disabled = false;
        }
    });
}

//Mostrar Mensajes de chat individual
var MostrarMensajesChat = function () {

    let form = $('#frmMostrarChat').serialize();

    if (form != '') {
        $.ajax({
            type: "POST",
            url: "MostrarMensajesChat",
            data: form,
            success: function (Respuesta) {
                //console.log(Respuesta);
                let json = JSON.parse(Respuesta);
                //console.log(json);
                let conversacion = '';
                json.forEach(
                    Datos => {
                        if (Datos.sender == 'master' || Datos.sender == 'admin' || Datos.sender == 'regular') {
                            conversacion += `                            
                                <div class="m-2">
                                    <span class="text text-success">${Datos.sender}</span>
                                    <span>${Datos.body}</span>
                                    <span style="float: right; font-size: 11px;">${Datos.FechaHora}</span><hr>
                                </div>
                                `
                        } else {
                            conversacion += `
                            <div class="m-2">
                                <span class="text text-danger">${Datos.sender}</span>
                                <span>${Datos.body}</span>
                                <span style="float: right; font-size: 11px;">${Datos.FechaHora}</span><hr>
                            </div>
                            `
                        }
                    });
                $('#datos_chat').html(conversacion);
                //
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });


        $.ajax({
            type: "POST",
            url: "MostrarEstadoConectado",
            data: form,
            success: function (Respuesta) {
                //var json = JSON.parse(Respuesta);
                if (Respuesta === 'available') {
                    $('#statusCliente').css('color','green').html('•');
                }else if(Respuesta === 'unavailable'){
                    $('#statusCliente').css('color','red').html('•');
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);

            }
        });
    }
};

//Enviar mensajes de chat con Enter
var EnviarMensajesDesdeEnter = function () {

    var wage = document.getElementById("txtCuerpoMensage");
    wage.addEventListener("keydown", function (e) {
        if (e.KeyboardEvent.keyCode === 13) {
            validate(e);
        }
    });


    function validate(e) {
        var form = $('#frmMostrarChat').serialize();
        $.ajax({
            type: "POST",
            url: "EnviarMensajesChat",
            data: form,
            success: function (Respuesta) {
                console.log(Respuesta);
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
        //MostrarMensajesChat();
        $('#txtCuerpoMensage').val('');
    }

}

//Ingreso Mensaje de Despedida
var InsertarMensajeDespedida = function () {
    $('#btnIngresarMensajeDespedida').click(function (e) {
        e.preventDefault();

        var form = $('#formMensajeDespedida').serialize();

        $.ajax({
            type: "POST",
            url: "CreateMensajeDespedida",
            data: form,
            success: function (Respuesta) {
                console.log(Respuesta);
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
        $('#txtMensajeDespedida').val('');
        MostrarMensajesDespedida();

    });
}

//Mostrando Tabla Mensaje Despedida
var MostrarMensajesDespedida = function () {
    $.ajax({
        type: "GET",
        url: "MostrandoMensajeDespedida",
        success: function (Respuesta) {
            var json = JSON.parse(Respuesta);
            if (json != null) {
                var tabla = '';
                json.forEach(
                    Datos => {
                        tabla += `
                            <tr>
                                <td>${Datos.cuerpo}</td>
                                <td>${Datos.fecha}</td>
                                <td>${Datos.usuario}</td>
                                <td><button class="btn btn-outline-danger" id="btnEliminarMensajeDespedida" type="button" name="btnEliminarMensajeDespedida" title="Eliminar Despedida" value="${Datos.id}"><i class="far fa-trash-alt"></i></button></td>
                            </tr>
                            `
                    }
                );
                $('#tablaMostrarMensajeDespedida').html(tabla);
            }
        }
    });
}

//Eliminando Mensaje de Despedida
var DeleteMensajeDespedida = function () {
    $('#btnEliminarMensajeDespedida').click(function (e) {
        e.preventDefault();
        console.log('probando desde funciones de js');

        //var form = $('#form_MensajeDespedida').serialize();
        //$.ajax({
        //    type: "POST",
        //    url: "DeleteMensajeDespedida",
        //    data: form,
        //    success: function (Respuesta) {
        //        console.log(Respuesta);
        //    },
        //    error: function (xhr, status, error){
        //        console.log(xhr);
        //        console.log(status);
        //        console.log(error);
        //    }
        //});
    });
}
////////////////////////////////////




//TODO LO RELACIONADO CON LA TRANSFERENCIA DE CHAT
//Consultar tabla para transferir chat
var ReadTransferenciaChat = function () {
    var table = $('#TablaTransferirChat').DataTable({
        "ajax": {
            "method": "POST",
            "url": "ConsultandoUsuarioATransferir"
        },
        "columns": [
            { "data": "id" },
            { "data": "nombre" },
            { "data": "apellido" },
            { "data": "usuario" }
            //{ "data": "admin" }
        ]
    });
    /*$.ajax({
        type: "GET",
        url: "ConsultandoUsuarioATransferir",
        success: function (Respuesta) {
            var json = JSON.parse(Respuesta);
            var tbody = '';
            json.forEach(
                consulta => {
                    tbody += `
                    <tr>
                        <td><input type="checkbox" name="idAgenteTransferir[]" value="${consulta.id}" class="form-check-input"></td>
                        <td>${consulta.nombre}</td>
                        <td>${consulta.apellido}</td>
                        <td>${consulta.usuario}</td>
                    </tr>
                    `;
                }
            );
            $('#TablaTransferirChat').html(tbody);
        }
    });*/
};


//Consultar salas de chat para transferir
var ReadSalasChatTransferencia = function () {
    $.ajax({
        type: "GET",
        url: "ConsultandoSalasChatSelector",
        success: function (Respuesta) {
            var json = JSON.parse(Respuesta);
            if (json != null) {
                var select = '';
                json.forEach(
                    consulta => {
                        select += `
                        <option value="${consulta.name}">${consulta.name}</option>
                        `
                    }
                );
                $('#SeleccionSalaChat').html(select);
            }
        }
    });
}


//Transferir Sala a Agente
var CreateTransferirChat = function () {
    $('#btnTransferirChat').click(function (e) {
        e.preventDefault();
        $('#RespuestaTransferencia').html('');

        var form = $('#frmTransferirChat').serialize();

        $.ajax({
            type: "POST",
            url: "UpdateDialogs",
            data: form,
            dataType: "text",
            success: function (Respuesta) {
                //console.log(Respuesta);
                $('#RespuestaTransferencia').html(Respuesta).css('color', 'Green').val();

            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }

        });
        $('#IdAgenteTransferir').val('');
    });
}
//////////////////////////////////////////////








//TODO LO RELACIONADO CON LOS CONTEOS
//Mostrando Cantidad de salas de chat Abiertas
var MostrarCantidadSalasChatAbiertas = function () {
    $.ajax({
        type: "POST",
        url: "MostrandoChatAbiertos",
        success: function (Respuesta) {
            $('#CardSalasAbiertas').html(Respuesta);
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}

//Mostrando cantidad de Salaas de chat Cerradas
var MostrarCantidadSalasChatCerradas = function () {
    $.ajax({
        type: "POST",
        url: "MostrandoChatCerrados",
        dataType: "text",
        success: function (Respuesta) {
            //console.log(Respuesta);
            $('#CardSalasCerradas').html(Respuesta);
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}

//Mostrando cantidad de salas de chat asignadas a agentes
var MostrarCantidadSalasChatAsignadas = function () {
    $.ajax({
        type: "POST",
        url: "MostrandoChatAsignados",
        success: function (Respuesta) {
            //console.log(Respuesta);
            $('#CardSalasAsignadas').html(Respuesta);
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}

//Mostrando tabla del dashboard
var TablaChatAsignadoAgente = function () {
    $.ajax({
        type: "POST",
        url: "TablaChatAsignadoAgente",
        success: function (Respuesta) {
            let json = JSON.parse(Respuesta);
            //console.log();
            let tabla = '';
            json.forEach(
                Datos => {
                    if (Datos.ChatPendiente != '0' && Datos.ChatAbiertos == '0') {
                        tabla += `
                        <tr>
                            <td><input class="form-check-input" name="idAgente[]" type="checkbox" value="${Datos.id}"></td>
                            <td>${Datos.nombre}</td>
                            <td>${Datos.apellido}</td>
                            <td>${Datos.usuario}</td>
                            <td><span class="badge bg-danger rounded-pill">${Datos.ChatPendiente}</span></td>
                            <td><span>${Datos.ChatAbiertos}</span></td>
                        </tr>
                    `
                    } else if (Datos.ChatAbiertos != '0' && Datos.ChatPendiente == '0') {
                        tabla += `
                        <tr>
                            <td><input class="form-check-input" name="idAgente[]" type="checkbox" value="${Datos.id}"></td>
                            <td>${Datos.nombre}</td>
                            <td>${Datos.apellido}</td>
                            <td>${Datos.usuario}</td>
                            <td><span>${Datos.ChatPendiente}</span></td>
                            <td><span class="badge bg-warning rounded-pill">${Datos.ChatAbiertos}</span></td>
                        </tr>
                    `
                    } else if (Datos.ChatAbiertos != '0' && Datos.ChatPendiente != '0') {
                        tabla += `
                        <tr>
                            <td><input class="form-check-input" name="idAgente[]" type="checkbox" value="${Datos.id}"></td>
                            <td>${Datos.nombre}</td>
                            <td>${Datos.apellido}</td>
                            <td>${Datos.usuario}</td>
                            <td><span class="badge bg-danger rounded-pill">${Datos.ChatPendiente}</span></td>
                            <td><span class="badge bg-warning rounded-pill">${Datos.ChatAbiertos}</span></td>
                        </tr>
                    `
                    } else if (Datos.ChatAbiertos == '0' && Datos.ChatPendiente == '0') {
                        tabla += `
                    <tr>
                        <td><input class="form-check-input" name="idAgente[]" type="checkbox" value="${Datos.id}"></td>
                        <td>${Datos.nombre}</td>
                        <td>${Datos.apellido}</td>
                        <td>${Datos.usuario}</td>
                        <td><span>${Datos.ChatPendiente}</span></td>
                        <td><span>${Datos.ChatAbiertos}</span></td>
                    </tr>
                `
                    }
                }
            );
            $('#ChatAsignadosAgentes').html(tabla);
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
}
///////////////////////////////////////


//Mostrando Salas de chat Asignadas
var ReadDialogsAsignadosAgente = function () {

    var form = $('#frmidparaconsultarDatatableConversacion').serialize();
    if (form != '') {
        $.ajax({
            type: "POST",
            url: "ReadDialogsAsignadosAgente",
            data: form,
            success: function (Respuesta) {
                var json = JSON.parse(Respuesta);
                var tabla = '';
                json.forEach(
                    Datos => {
                        tabla += `
                            <tr>
                                <td>${Datos.id}</td>
                                <td>${Datos.name}</td>
                                <td><img src="${Datos.image}" class="img-thumbnail rounded" width="40px"></td>
                                <td>${Datos.abierto}</td>
                            </tr>
                        `
                    }
                );
                $('#tabladialogs').html(tabla);




                console.log(json);



            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }
}




//Agregando Tabla para mostrar las conversaciones
var MostrarConversacionDataTable = function () {
    var form = $('#frmidparaconsultarDatatableConversacion').serialize();

    if (form != '') {
        $.ajax({
            type: "POST",
            url: "MostrarConversacionesConsulta",
            data: form,
            success: function (Respuesta) {
                console.log(Respuesta);
                var json = JSON.parse(Respuesta);
                console.log(json);
                var table = '';
                json.forEach(
                    Datos => {
                        table += `
                        <tr>
                            <td>${Datos.chatId}</td>
                            <td>${Datos.sender}</td>
                            <td>${Datos.messageNumber}</td>
                            <td>${Datos.body}</td>
                        </tr>
                    `
                    }
                );
                $('#tablaconversacion').html(table);

            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });
    }


    /*     var table = $('#tablaconversacion').DataTable({
            "ajax": {
                "method": "POST",
                "url": "MostrarConversacionesConsulta"
            },
            "columns": [
                { "data": "chatId" },
                { "data": "sender" },
                { "data": "messageNumber" },
                { "data": "body" }
                //{ "data": "admin" }
            ]
        }); */
}
