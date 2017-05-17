$(document).ready(function () {
    $(".btn-eliminar").unbind("click").click(function () {
        $.ajax({
            url: URL+'/formacion/eliminar/'+$(this).attr("data-id"),
            type: 'GET',
            success: function (response) {
                location.reload();
            }
        });
    });
});