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
};

app.submit = function(){
	$("body").on('click', '.submit', function(){
        if (validateEmpty('#cardForm')) { 
            if($("select#cardNameId").val() == 0){
                showNotification("Vui lòng chọn nhà mạng.", 0);
                return false;
            }
            if($("select#cardTypeId").val() == 0){
                showNotification("Vui lòng chọn mệnh giá.", 0);
                return false;
            }
    		var form = $('#cardForm');
    		$.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                	// redirect(false, $('a#urlBlack').attr('href'));
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
	});
}

$(document).ready(function(){
	app.init();
});