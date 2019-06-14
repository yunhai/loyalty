<?php $this->load->view('includes/user/header'); ?>
<link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<div  class="canhvang">
    <img src="assets/vendor/dist/img/canhvang.png" width="80px" class="mgr-5">
    <img src="assets/vendor/dist/img/rk.png" width="100px">
</div>
<div class="login-box-body custom-ip">
    <h3 class="yl-title">RICKY VIỆT NAM</h3>
    <?php echo form_open('api/user/checkLogin', array('id' => 'userForm')); ?>
    <div class="input-field">
        <input type="text" class="material hmdrequired" name="UserName" value="<?php echo $userName; ?>" placeholder="Nhập email hoặc số điện thoại" data-field="Nhập email hoặc số điện thoại"><span class="bottom"></span>
        <label><i class="ion-person"></i></label>
    </div>
    <div class="input-field">
        <input type="password" class="material hmdrequired" name="UserPass" autocomplete="new-password" value="<?php echo $userPass; ?>" placeholder="Nhập password" data-field="Password"><span class="bottom"></span>
        <label><i class="ion-locked"></i></label>
    </div>
    <button type="submit" class="btn btn-gr btn-block btn-flat">Đăng nhập</button>
    <input type="text" hidden="hidden" name="IsGetConfigs" value="1">
    <input type="text" hidden="hidden" name="IsRemember" value="on">
    <?php echo form_close(); ?>
    <div class="text-center"><a href="<?php echo base_url('user/register'); ?>" class="btn-dk">Đăng ký</a></div>
    <div class="text-center" id="divForgot" style="display: none;"><a href="<?php echo base_url('user/forgotPass'); ?>" class="btn-dk">Quên mật khẩu</a></div>
    <input type="hidden" id="dashboardUrl" value="<?php echo base_url('user/dashboard'); ?>">
    <input type="hidden" id="siteName" value="Ricky">
</div>
</div>
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/particles.js"></script>
<script type="text/javascript" src="assets/js/common.js"></script>
<script type="text/javascript" src="assets/js/user_login.js"></script>
</body>
</html>