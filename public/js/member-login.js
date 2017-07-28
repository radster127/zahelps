$(function () {
    $('.login_form').parsley();
    $('#recoverform').parsley();

    $("#to-recover").click(function () {
        $("#loginform").slideUp();
        $("#recoverform").slideDown();
    });

    $("#to-login").click(function () {
        $("#recoverform").slideUp();
        $("#loginform").slideDown();
    });

    $('#recoverform').submit(function () {
        $.ajax({
            type: 'post',
            url: $('#recoverform').attr('action'),
            data: $('#recoverform').serialize(),
            success: function (data) {
                if (data.status == 0) {
                    toastMessage('warning', 'Error', data.message);
                } else {
                    toastMessage('success', 'Success', data.message);
                }
            },
            error: function (e) {
                toastMessage('warning', 'Error', 'Getting error while fetching data.');
            }
        });
        return false;
    });
})