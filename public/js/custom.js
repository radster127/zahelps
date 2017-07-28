/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    if ($('.module_form').length > 0) {
        $('.module_form').parsley();
    }

    $('#start_date, #end_date').datepicker({
        autoclose: true,
        todayHighlight: true
    });


    $('.delete_btn').click(function () {
        if (confirm('Are you sure to delete this row?')) {
            $url = $(this).attr('href');
            $('#global_delete_form').attr('action', $url);
            $('#global_delete_form #row_id').val($(this).data('id'));
            $('#global_delete_form').submit();
        }
        return false;
    });

    $('.pagination').find('span, a').addClass('page-link');
    $('.pagination').find('li').addClass('page-item');

})