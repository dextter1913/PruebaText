$(document).ready(function () {
    console.log('Hola desde Jquery usando rol Asistente');
    EnviarMensajesChat();
    setInterval('MostrarMensajesChat()', 3000);
    ValidacionCantidadMaximaCaracteres();

    PruebaToastDesdeJquery();//Toast
});






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
    }
}

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
////////////////////////////////////


//TOAST O NOTIFICACIONES DE MESAJES PRUEBA
//Probando Toast Desde Jquery
var PruebaToastDesdeJquery = function () {
    var MiToast = document.getElementById('liveToast');
    //$('#PruebaToast').click(function (e) {
        //e.preventDefault();
        var toast = new bootstrap.Toast(MiToast);

        toast.show();
    //});
}
//////////////////////////////////