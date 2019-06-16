 <!-- footer -->
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
             $('#myForm a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $(document).on('click', '#signup', function() {
                $('a[href="#register"]').click();
            })
        </script>
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="assets/web/js/bootstrap.js"></script>
        <script src="assets/vendor/plugins/pnotify/pnotify.custom.min.js"></script>
        <script src="assets/js/site.js"></script>
    </body>
</html>