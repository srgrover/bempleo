$(document).ready(function () {

    $('.form-num-identi').blur(function () {
        if($(".form-tipo-doc").val() == "NIF"){
            nif($(this).val());
        }
    });

});

function nif(dni) {
    var numero;
    var letr;
    var letra;
    var expresion_regular_dni;

    expresion_regular_dni = /^\d{8}[a-zA-Z]$/;

    if(expresion_regular_dni.test (dni)){
        numero = dni.substr(0,dni.length-1);
        letr = dni.substr(dni.length-1,1);
        numero = numero % 23;
        letra='TRWAGMYFPDXBNJZSQVHLCKET';
        letra=letra.substring(numero,numero+1);

        if (letra != letr.toUpperCase()) {
            $('.form-num-identi').css({
                "border":"1px solid red",
                "color": "red"
            });

            $('.message-container p').text("El NIF es erroneo, la letra del NIF no se corresponde");

            $('.message-container').css({
                "display" : "block",
                "background-color" : "#dd4444"
            });

            $("form[name='appbundle_usuario']").submit(function () {
                return false;
            });
        }else{
            $('.form-num-identi').css({
                "border" : "1px solid green",
                "color" : "green"
            });

            $('.message-container p').text("El DNI es correcto");

            $('.message-container').css({
                "display" : "block",
                "background-color" : "#4cae4c"
            });

            $("form[name='appbundle_usuario']").submit(function () {
                return true;
            });
        }
    }else{
        $('.form-num-identi').css({
            "border":"1px solid red",
            "color": "red"
        });

        $('.message-container').css({
            "display" : "block",
            "background-color" : "#dd4444"
        });

        $("form[name='appbundle_usuario']").submit(function () {
            return false;
        });
    }
}