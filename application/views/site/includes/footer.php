        <div class="footer">
            <div class="container">
                <div class="text-center">
                    <a href="javascript:void(0)"><img src="assets/web/img/logo-footer.jpg"></a>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        <input type="hidden" id="urlShare" value="<?php echo base_url('ban-da-chia-se-ket-qua-du-doan-la/') ?>">
        <div id="overpay" class=""></div>
        <div id="fb-root" style="display: none"></div>
        <script>
            var global_user = <?php echo json_encode($user ?? []); ?>;
        </script>
        <script src="assets/web/js/jquery-1.11.1.min.js"></script>
        <script src="assets/web/js/bootstrap.js"></script>
        <script src="assets/vendor/plugins/pnotify/pnotify.custom.min.js"></script>
        <script src="assets/js/web/index.js"></script>
        <script src="assets/js/web/site.js"></script>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3&appId=1310386095769247&autoLogAppEvents=1"></script>
    </body>
</html>