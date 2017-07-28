
function toastMessage(status, title, message) {
    $.toast({
        heading: title,
        text: message,
        position: 'top-right',
        loaderBg: '#ff6849',
        icon: status,
        hideAfter: 4500,
        stack: 6
    });
}

$(function () {
    if ($('.module_form').length > 0) {
        $('.module_form').parsley();
    }
})