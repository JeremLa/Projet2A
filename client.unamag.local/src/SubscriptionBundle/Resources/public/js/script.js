$(document).ready(function () {
    $('.info-pay').each(function(){
        $(this).on('click', function(){
            $('#pay_id').val($(this).attr('data'));
            $('#amount').val($(this).attr('amount'));
        });
    });

});