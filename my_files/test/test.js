$(document).ready(function () {
    $(".collapse-toggle").mouseover(function () {
        if ($(this).hasClass("collapsed") === true) {
            $(this).click();
        }
    });
}); 