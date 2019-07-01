
var app = app || {};

app.init = function () {
    app.initLibrary();
    app.submit();
    app.login();
    app.register();
    app.userWin();
    app.receiveCard();
};


app.initLibrary = function(){
    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function () {
        var value = $(this).val();
        if(value.length == 1) $(this).val(value);
        else{
        	showNotification('Mỗi ô chỉ được nhập 1 số duy nhất', 0);
         	$(this).val('')
        } 
    }).on("change", "#isRemember", function(){
        if ($(this).is(':checked')){
            $(this).val("on")
        }else{
            $(this).val("off")
        }
    });

    function checkKeyCodeNumber(e){
	    return !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 ||  e.keyCode == 35 || e.keyCode == 36 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46);
	}

	
};

app.submit = function(){
	$("body").on('click', '.submit', function(){

		if (validateEmpty('#inputNumberForm')) {
    		var form = $('#inputNumberForm');
    		$.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    $("#inputNumberForm input").val('');
                    if(json.code == 1){
                        setInterval(function(){ location.reload(); }, 3000);
                    }
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

app.login = function(){
    $(document).on('submit','#userForm',function (){
        if(validateEmpty('#userForm')) {

            var form = $('#userForm');
            var data = form.serialize();
            form.find('input, button').prop("disabled", true);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = response;

                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        setInterval(function(){ location.reload(); }, 3000);
                        form.find('input, button').prop("disabled", true);
                    }else{
                        form.find('input, button').prop("disabled", fase);
                    }
                    
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    form.find('input, button').prop("disabled", false);
                }
            });
        }
        return false;
    });
}

app.receiveCard = function(){
    $("body").on("click", 'a.receive-card', function(){
        var customersAnticipateId = parseInt($(this).attr("data-id"));
        if(customersAnticipateId >= 0){
            $.ajax({
                type: "POST",
                url: $("input#urlReceiveCard").val().trim(),
                data: {
                    CustomersAnticipateId:  customersAnticipateId,
                },
                success: function (response) {
                    console.log(response)
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        // $(".fb-share-button").attr("data-value", "Haminh man");
                        var data = json.data;

                        $(".fb-share-button").trigger('click');
                        if(confirm('Vui lòng nhận card: mã:'+data.CardNumber)){

                        }
                        app.userWin()

                    }
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }else showNotification("Có lổi xảy ra, vui lòng thử lại sau.", 0);
        return false;
    });
}

app.register = function(){
    $(document).on('click','#btnRegister',function (){
        if(validateEmpty('#userRegisterForm')){
            var questionId = $('select#questionId').val();
            if(parseInt(questionId) == 0){
                showNotification('Vui lòng chọn câu hỏi.', 0);
                 return false;
            }
            var answerId = $('select#answerId').val();
            if(parseInt(answerId) == 0){
                showNotification('Vui lòng chọn câu trả lời.', 0);
                return false;
            }
            if(parseInt(answerId) > 0 && parseInt(questionId) == 0){
                showNotification('Vui lòng chọn câu hỏi trước.', 0);
                return false;
            }
            if ($('input#userPass').val() != $('input#rePass').val()) {
                showNotification('Mật khẩu không trùng', 0);
                return false;
            }
            var form = $('#userRegisterForm');
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: {
                    UserId:     0,
                    UserName: $('input#fullName').val().trim(),
                    UserPass:   $('input#userPass').val(),
                    FullName:   $('input#fullName').val().trim(),
                    Email:      $('input#email').val(),
                    GenderId:   1,
                    StatusId:   2,
                    PhoneNumber: $('input#phoneNumber').val(),
                    QuestionId : questionId,
                    AnswerId: answerId
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        form.trigger('reset');
                        showNotification('Chúc mừng bạn đăng ký thành công', 1);
                    }
                    else showNotification(json.message, json.code);
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        }
        return false;
    });
}

app.userWin = function(){
    $.ajax({
        type: "POST",
        url: $("input#urlGetWin").val().trim(),
        success: function (response) {
          
            var json = $.parseJSON(response);
            if(json.code == 1){
                var data = json.data;
                var html = '';
                var num = 0;
                if(data.length > 0){
                    for (var item = 0; item < data.length; item++) {
                        html += '<tr>';
                        html += '<td class="text-indent">'+data[item].FullName+'</td>';
                        html += '<td class="text-center">'+data[item].CardType+'</td>'
                        html += '</tr>';
                        num += data[item].TotalPrice;
                        
                    }
                    $(".bg-money").html(formatNumber(num));
                    $("#tbody-bac").html(html);
                    $("#container-bac").show();
                }
                
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}
function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

$(document).ready(function(){
	app.init();
});

//validate
function validateEmpty(container) {
    var flag = true;
    $(container + ' .hmdrequired').each(function () {
        if ($(this).val().trim() == '') {
            showNotification($(this).attr('data-field') + ' không được bỏ trống', 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}
function showNotification(msg, type) {
    var typeText = 'error';
    if (type == 1) typeText = 'success';
    var notice = new PNotify({
        title: 'Thông báo',
        text: msg,
        type: typeText,
        delay: 2000,
        addclass: 'stack-bottomright',
        stack: {"dir1": "up", "dir2": "left", "firstpos1": 15, "firstpos2": 15}
    });
}