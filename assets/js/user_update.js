$(document).ready(function(){
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('.chooseImage').click(function(){
        chooseFile('Users', function(fileUrl) {
            $('input#avatar').val(fileUrl);
            $('img#imgAvatar').attr('src', fileUrl);
        });
    });
    $('#userForm').on('keyup', 'input#maxCost', function () {
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    });
    $('input#cbUnlimit').on('ifToggled', function(e){
        if(e.currentTarget.checked) $('input#maxCost').val('0').prop('disabled', true);
        else $('input#maxCost').val('0').prop('disabled', false);
    });
    $('a#generatorPass').click(function(){
        var pass = randomPassword(10);
        $('input#newPass').val(pass);
        $('input#rePass').val(pass);
        return false;
    });
    var userId = parseInt($('input#userId').val());
    $('.submit').click(function (){
        if(validateEmpty('#userForm') && validateNumber('#userForm', true, ' không được bỏ trống')){
            if ($('input#newPass').val() != $('input#rePass').val()) {
                showNotification('Mật khẩu không trùng', 0);
                return false;
            }
            $('.submit').prop('disabled', true);
            var form = $('#userForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        if(userId == 0) redirect(false, $('input#userEditUrl').val() + '/' + json.data);
                        else $('.submit').prop('disabled', false);
                    }
                    else $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
    });
});

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    //var chars = "ABCDEFGHIJKLMNOPQRSTXYZ1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}