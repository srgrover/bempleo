$(document).ready(function () {
    $('.form-num-identi').blur(function () {
        var respuesta = validate($(this).val());

        if(respuesta.valid){
            $('.form-num-identi').css({
                "border" : "1px solid green",
                "color" : "green"
            }).fadeIn();

            $('.message-container p').text("El "+respuesta.type+" es correcto");
            $('.message-container').css({
                "display" : "block",
                "background-color" : "#4cae4c"
            }).fadeIn();

            $("form[name='appbundle_usuario']").submit(function () {
                return true;
            });
        }else{
            $('.form-num-identi').css({
                "border":"1px solid red",
                "color": "red"
            }).fadeIn();

            $('.message-container p').text("El "+respuesta.type+" es erroneo, puede que no tenga un formato correcto o que la letra final no se corresponda");
            $('.message-container').css({
                "display" : "block",
                "background-color" : "#dd4444"
            }).fadeIn();

            $("form[name='appbundle_usuario']").submit(function () {
                return false;
            });
        }
        seleccionar(respuesta.type);
    });
});

function validate(value) {
    var validChars = 'TRWAGMYFPDXBNJZSQVHLCKET';
    var nifRexp = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i;
    var nieRexp = /^[XYZ]{1}[0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i;
    var str = value.toString().toUpperCase();

    var isNIF = nifRexp.test(str);
    var isNIE = nieRexp.test(str);
    if (!isNIF && !isNIE) return {
        valid: false,
        type: 'Número de identificación'
    };

    var nie = str
        .replace(/^[X]/, '0')
        .replace(/^[Y]/, '1')
        .replace(/^[Z]/, '2');

    var letter = str.substr(-1);
    var charIndex = parseInt(nie.substr(0, 8)) % 23;

    if (validChars.charAt(charIndex) === letter) {
        return {
            valid: true,
            type: (isNIF ? 'NIF' : (isNIE ? 'NIE' : ''))
        }
    }

    return {
        valid: false,
        type: 'Número de identificación'
    };
}

function seleccionar(elemento) {
    var ddl = document.forms[0].appbundle_usuario_tipoDoc;
    var cantidad = ddl.length;
    for (i = 0; i < cantidad; i++) {
        if (ddl[i].value == elemento) {
            ddl[i].selected = true;
        }
    }
}