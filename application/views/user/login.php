<?php $this->load->view('includes/user/header'); ?>
    <div class="login-box-body">
        <p class="login-box-msg">Đăng nhập vào hệ thống</p>
        <?php echo form_open('api/user/checkLogin', array('id' => 'userForm')); ?>
        <div class="form-group has-feedback">
            <input type="text" name="UserName" class="form-control hmdrequired" value="<?php echo $userName; ?>" placeholder="Điện thoại" data-field="Điện thoại">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="UserPass" class="form-control hmdrequired" value="<?php echo $userPass; ?>" placeholder="Mật khẩu" data-field="Mật khẩu">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="IsRemember" class="iCheck" checked="checked"> Ghi nhớ
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                <input type="text" hidden="hidden" name="IsGetConfigs" value="1">
            </div>
        </div>
        <?php echo form_close(); ?>
        <a href="<?php echo base_url('user/forgotpass'); ?>">Quên mật khẩu</a>
        <input type="text" hidden="hidden" id="dashboardUrl" value="<?php echo base_url('user/dashboard'); ?>">
        <input type="text" hidden="hidden" id="siteName" value="Ricky">
    </div>
</div>
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/common.js?20171022"></script>
<script type="text/javascript" src="assets/js/user_login.js"></script>
</body>
</html>
