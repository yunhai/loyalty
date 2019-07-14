$(document).ready(function() {
    $(document).on('click','.js-menu_toggle.closed',function(e){
        e.preventDefault(); $('.list_load, .list_item').stop();
        $(this).removeClass('closed').addClass('opened');
    
        $('.side_menu').css({ 'left':'0px' });
        $('#overpay').addClass('overpay');
        var count = $('.list_item').length;
        $('.list_load').slideDown( (count*.6)*100 );
        $('.list_item').each(function(i){
            var thisLI = $(this);
            timeOut = 100*i;
            setTimeout(function(){
                thisLI.css({
                    'opacity':'1',
                    'margin-left':'0'
                });
            },100*i);
        });
    });
    
    $(document).on('click','.js-menu_toggle.opened',function(e){
        e.preventDefault(); $('.list_load, .list_item').stop();
        $(this).removeClass('opened').addClass('closed');
    
        $('.side_menu').css({ 'left':'-80%' });
        $('#overpay').removeClass('overpay');
        var count = $('.list_item').length;
        $('.list_item').css({
            'opacity':'0',
            'margin-left':'-20px'
        });
        $('.list_load').slideUp(300);
    });    
    
    $('#myForm a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('.scrollTo').click(function () {
        if ($(this).hasClass('login')) {
            $('.account--navigator a:first').tab('show');
        } else if ($(this).hasClass('register')) {
            $('.account--navigator a:last').tab('show');
        } else {
            if ($(this).hasClass('sp-login')) {
                $('.js-menu_toggle').click();
                $('.account--navigator a:first').tab('show');
            } else if ($(this).hasClass('sp-register')) {
                $('.js-menu_toggle').click();
                $('.account--navigator a:last').tab('show');
            }
        }
        
        $('html, body').animate({ 
            scrollTop: $('.account--navigator').offset().top
        }, 1000);
    });

    $('#modal--profile').on('show.bs.modal', function (e) {
        $('#profile--phone').val(global_user.PhoneNumber || '');
        $('#profile--email').val(global_user.Email || '');
        $('#profile--fullname').val(global_user.FullName || '');
        $('#profile--security-question').val(global_user.QuestionId || '');
        $('#profile--security-answer').val(global_user.AnswerId || '');
    })
});