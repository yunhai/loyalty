<div class="footer">
            <div class="container">
                <div class="text-center">
                    <a href="javascript:void(0)"><img src="assets/web/img/logo-footer.jpg"></a>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //footer --> 
        <script type="text/javascript">
            $(document).ready(function() {
            // Requires jQuery
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
                $(document).on('click', '#signup', function() {
                    $('a[href="#register"]').click();
                });
                $('.scrollTo').click(function () {
                    if ($(this).hasClass('register')) {
                        $('a[href="#register"]').click();
                    } else if ($(this).hasClass('login')) {
                        $('a[href="#login"]').click();
                    } else {
                        $('html, body').animate({ 
                            scrollTop: $($(this).attr('href')).offset().top
                        }, 1000)
                    }
                });
            });
        </script>
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="assets/web/js/bootstrap.js"></script>
        <div id="overpay" class=""></div>
        <script src="assets/vendor/plugins/pnotify/pnotify.custom.min.js"></script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e3ba7c637c424ce"></script>
        <script src="assets/js/site.js"></script>
    </body>
</html>