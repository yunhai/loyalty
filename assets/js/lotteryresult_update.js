var app = app || {};

app.init = function () {
    app.initLibrary();
    app.submit();
};

app.initLibrary = function(){
    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function () {
        var value = $(this).val();
        $(this).val(value);
    });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
};


app.submit = function(){
    $('.submit').click(function(){
        if(validateEmpty('#lotteryresultForm')){
            var btn = $(this);
            var lotteryStationId = $('select#lotteryStationId').val().trim();
            if(parseInt(lotteryStationId) == 0){
                showNotification('Vui lòng chọn đài số xổ', 0);
                return false;
            }

            btn.prop('disabled', true);
            var form = $('#lotteryresultForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        redirect(false, $('a#urlBlack').attr('href'));
                        btn.prop('disabled', false);
                    }
                    else btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        }
    });
}

$(document).ready(function(){
	app.init();
});

function getLotteryResultDetails(){
    var retVal = [];
    var raffle = 0;
    var flag = false;
    $('#tbodyDetails tr').each(function(){
        raffle = $(this).find('input.raffle').val().trim();

        if(raffle == ''){
            flag = true;
            showNotification('Vui lòng nhập số xổ', 0);
            $(this).find('input.raffle').focus();
            return false;
        }else{
            retVal.push({
                Raffle: raffle
            });
        }
    });
    if(flag) retVal = [];
    else if(retVal.length == 0) showNotification('Bạn chưa nhập số xổ', 0);
    return retVal;
}
