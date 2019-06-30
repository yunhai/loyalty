$(document).ready(function(){
    $('#btnRegister').click(function(){
    	if(validateEmpty('#userForm')){
    		if ($('input#userPass').val() != $('input#rePass').val()) {
                showNotification('Mật khẩu không trùng', 0);
                return false;
            }
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
            // var userName = $('input#userName').val().trim();
            // if(userName.indexOf(' ') >= 0){
            //     showNotification('Tên đăng nhập không được có khoảng trằng', 0);
            //     $('input#userName').focus();
            //     return false;
            // }
    		var v = grecaptcha.getResponse();
	        if(v.length == 0){
	            showNotification('Chưa veryfy captcha', 0);
	            return false;
	        }
            var form = $('#userForm');
            var btn = $(this);
	        btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: {
                	UserId: 	0,
                    UserName: $('input#fullName').val().trim(),
                	UserPass: 	$('input#userPass').val(),
                	FullName: 	$('input#fullName').val().trim(),
                	Email: 		$('input#email').val(),
                	GenderId: 	1,
                	StatusId: 	2,
                	PhoneNumber: $('input#phoneNumber').val(),
                    AnswerId: answerId,
                    QuestionId: questionId
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
});
