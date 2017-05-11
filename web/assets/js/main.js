$(document).ready(function () {
    $('.avatar img').mouseenter(function() {
        $('.avatar a').css({
            "display": "inline"
        });
    });
    $('.avatar img').mouseleave(function() {
        $('.avatar a').css({
            "display": "none"
        });
    })
});