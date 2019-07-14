// var data = {
            //     FullName: $('#register--fullname').val().trim() || 'fullname',
            //     PhoneNumber: $('#register--phone').val().trim() || '07070025',
            //     Email: $('#register--email').val() || 'email@email.com',
            //     Password: password || 'password',
            //     ConfirmPassword: passwordConfirm || 'password',
            //     SecurityQuestion: $('#register--security-question').val() || 2 ,
            //     SecurityAnswer: $('#register--security-answer').val() || 'reply',
            // };

var app = app || {};

app.init = function () {
    app.initLibrary();
    app.submit();
    app.login();
    app.register();
    app.profile();
    app.changePassword();
    app.resetPassword();
    app.history();
    app.receiveCard();
};

app.initLibrary = function(){
    $('body').on('keydown', 'input.cost', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.cost', function () {
        var value = $(this).val();
        if(value.length == 1) {
            $(this).val(value);
        } else {
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

app.login = function() {
    $(document).on('click', '#btnLogin', function () {
        if(validateEmpty('#userLoginForm')) {
            var form = $('#userLoginForm');
            var data = form.serialize();

            var btn = $(this);
            btn.prop('disabled', true);

            var data = {
                PhoneNumber: $('#login--phone').val(),
                Password: $('#login--password').val(),
            };
            console.log(data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = response;
                    console.log(json);
                    if (json.code > 0) {
                        location.reload();
                        form.trigger('reset');
                        return;
                    } 
                    btn.prop('disabled', false);
                    showNotification(json.message, json.code);
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

app.register = function(){
    $(document).on('click','#btnRegister',function (){
        if(validateEmpty('#userRegisterForm')){
            var password = $('#register--password').val();
            var passwordConfirm = $('#register--password-confirm').val();

            if (password != passwordConfirm) {
                showNotification('Mật khẩu & mật khẩu xác thực không khớp', 0);
                return false;
            }
 
            var data = {
                FullName: $('#register--fullname').val().trim(),
                PhoneNumber: $('#register--phone').val().trim(),
                Email: $('#register--email').val(),
                Password: password,
                ConfirmPassword: passwordConfirm,
                SecurityQuestion: $('#register--security-question').val() ,
                SecurityAnswer: $('#register--security-answer').val(),
            };

            var form = $('#userRegisterForm');
            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code > 0) {
                        form.trigger('reset');
                    }
                    showNotification(json.message, json.code);
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

app.resetPassword = function(){
    $(document).on('click','#resetPassword--submit', function (){
        if(validateEmpty('#userResetPasswordForm')) {
            var password = $('#resetPassword--password').val();
            var passwordConfirm = $('#resetPassword--password-confirm').val();
            if (password != passwordConfirm) {
                showNotification('Mật khẩu & mật khẩu xác thực không khớp', 0);
                return false;
            }
            var form = $('#userResetPasswordForm');
            var data = {
                PhoneNumber: $('#resetPassword--phone').val(),
                Password: password,
                ConfirmPassword: passwordConfirm,
                SecurityQuestion: $('#resetPassword--security-question').val(),
                SecurityAnswer: $('#resetPassword--security-answer').val(),
            };
            var btn = $(this);
            btn.prop('disabled', false);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code > 0) {
                        btn.prop('disabled', false);
                        $('#resetPassword--cancel').click();
                        form.trigger('reset');
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification(json.message, json.code);
                }
            });
        }
        return false;
    });
}

app.profile = function(){
    $(document).on('click','#profile--submit', function (){
        if(validateEmpty('#userProfileForm')) {
            var form = $('#userProfileForm');
            var data = {
                FullName: $('#profile--fullname').val(),
                PhoneNumber: $('#profile--phone').val(),
                Email: $('#profile--email').val(),
                SecurityQuestion: $('#profile--security-question').val() ,
                SecurityAnswer: $('#profile--security-answer').val(),
            };

            var btn = $(this);
            btn.prop('disabled', false);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code > 0) {
                        btn.prop('disabled', false);
                        $('#profile--cancel').click();
                        form.trigger('reset');
                        global_user = json.data;
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification(json.message, json.code);
                }
            });
        }
        return false;
    });
}

app.changePassword = function(){
    $(document).on('click','#changePassword--submit', function (){
        if(validateEmpty('#userChangePasswordForm')) {
            var form = $('#userChangePasswordForm');
           
            var password = $('#changePassword--password').val();
            var passwordConfirm = $('#changePassword--password-confirm').val();
            if (password != passwordConfirm) {
                showNotification('Mật khẩu & mật khẩu xác thực không khớp', 0);
                return false;
            }
            
            var data = {
                Password: password,
                ConfirmPassword: passwordConfirm,
                CurrentPassword: $('#changePassword--password-current').val()
            };

            var btn = $(this);
            btn.prop('disabled', false);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.code > 0) {
                        btn.prop('disabled', false);
                        $('#changePassword--cancel').click();
                        form.trigger('reset');
                    }
                    showNotification(json.message, json.code);
                },
                error: function (response) {
                    showNotification(json.message, json.code);
                }
            });
        }
        return false;
    });
}

app.submit = function(){
    $("body").on('click', '.submit', function(){
        if (validateEmpty('#inputNumberForm')) {
            var form = $('#inputNumberForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    $("#inputNumberForm input").val('');
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
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

app.history = function(){
    $.ajax({
        type: "GET",
        url: 'site/ajaxUserWin',
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1 && json.data.length > 0) {
                var data = json.data;
                var html = '';
                var total = 0;

                var cardStatus = cardStatuses();
                var cardType = cardTypes();
                var cardName = cardNames();

                for (var item = 0; item < data.length; item++) {
                    var tmp = data[item];
                    var total = total + parseInt(cardType[tmp.CardTypeId]);

                    var cardText =  cardName[tmp.CardNameId] + ' ' + cardType[tmp.CardTypeId] + 'K';
                    var statusText = cardStatus[tmp.CardActiveId];
                    if (tmp.CardActiveId == 3) {
                        statusText = '<a href="#" class="btn btn-success receive-card" role="button" data-id="' + tmp.CustomersAnticipateId + '">' + statusText + '</a>';
                    } else {
                        statusText = '<button type="button" class="btn btn-default" disabled="disabled">' + statusText + '</button>';
                    }
                    
                    html += '<tr>';
                    html += '<td class="text-center">' + tmp.PlayDate+ '<br />' + statusText + '</td>';
                    html += '<td class="text-center">' + cardText  + '</td>'
                    html += '</tr>';
                }
                $(".bg-money").html(formatNumber(total) + 'K');
                $("#tbody-bac").html(html);
                $("#container-bac").show();
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

app.receiveCard = function(){
    $("body").on("click", 'a.receive-card', function(){
        var customersAnticipateId = parseInt($(this).attr("data-id"));
        if (customersAnticipateId >= 0) {
            $.ajax({
                type: "POST",
                url: 'site/receiveCard',
                data: {
                    CustomersAnticipateId:  customersAnticipateId,
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if(json.code == 1){
                        var data = json.data;

                        var cardType = cardTypes();
                        var cardName = cardNames();
                        
                        $('#modal--jackpot__cardname').text(cardName[data.CardNameId]);
                        $('#modal--jackpot__cardtype').text(cardType[data.CardTypeId] + 'K');
                        $('#modal--jackpot__cardseri').text(data.CardSeri);
                        $('#modal--jackpot__cardnumber').text(data.CardNumber);
                        $('#modal--jackpot').modal('show');

                        app.history()
                    }
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
            return;
        } 
        showNotification("Có lổi xảy ra, vui lòng thử lại sau.", 0);
        return false;
    });
}

function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

$(document).ready(function(){
    app.init();
});

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

function cardNames() {
    return  {
        1: 'Viettel',
        2: 'Mobifone',
        3: 'Vinaphone',
        4: 'Vietnamobile',
        5: 'Gmobile',
    };
}

function cardTypes() {
    return {
        1: '20',
        2: '50',
        3: '100',
        4: '200',
        5: '500',
    };
}

function cardStatuses() {
    return {
        3: 'Nhận thưởng',
        4: 'Đã nhận thưởng',
    };
}