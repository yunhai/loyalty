<?php $this->load->view('includes/user/header'); ?>
    <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <div  class="canhvang">
        <img src="assets/vendor/dist/img/canhvang.png" width="80px" class="mgr-5">
        <img src="assets/vendor/dist/img/rk.png" width="100px">
    </div>
    <div class="login-box-body custom-ip">
        <h3 class="yl-title">RICKY VIỆT NAM</h3>
        <?php echo form_open('api/user/saveUser', array('id' => 'userForm')); ?>
        <div class="input-field">
            <input type="text" class="material hmdrequired" data-field="Họ và tên" placeholder="Họ và tên" id="fullName"/><span class="bottom"></span>
            <label><i class="ion-person"></i></label>
        </div>
        <div class="input-field">
            <input type="text" class="material hmdrequired" data-field="Số điện thoại di động" placeholder="Số điện thoại di động" id="phoneNumber"/><span class="bottom"></span>
            <label class="mobile-icon"><i class="ion-iphone"></i></label>
        </div>
        <div class="input-field">
            <input type="text" class="material hmdrequired" data-field="Nhập địa chỉ email" placeholder="Nhập địa chỉ email" id="email"/><span class="bottom"></span>
            <label><i class="ion-ios-email"></i></label>
        </div>
        <div class="input-field">
            <input type="password" class="material hmdrequired" data-field="Nhập password" placeholder="Nhập password" id="userPass"/><span class="bottom"></span>
            <label><i class="ion-locked"></i></label>
        </div>
        <div class="input-field">
            <input type="password" class="material hmdrequired" data-field="Nhập lại password" placeholder="Nhập lại password" id="rePass"/><span class="bottom"></span>
            <label><i class="ion-locked"></i></label>
        </div>
        <div class="input-field">
            <?php $this->Mconstants->selectObject($listQuestions, 'QuestionId', 'QuestionName', 'QuestionId', 0, true, '--Câu hỏi bảo mật--', ''); ?>
        </div>
        <div class="input-field">
            <?php $this->Mconstants->selectConstants('answer', 'AnswerId', 0, true, '--Chọn câu trả lời--'); ?>
        </div>
        <div class="g-recaptcha" data-sitekey="6Ldm7FcUAAAAAMc9e7oCu_vhkVPqv6Hkvg6DyCj0"></div>
        <button type="button" class="btn btn-gr btn-block btn-flat" id="btnRegister">Hoàn thành</button>
        <input type="text" id="registerUrl" hidden="hidden" value="<?php echo base_url('user/register'); ?>">
        <?php echo form_close(); ?>
        <div class="text-center"><a href="<?php echo base_url('admin'); ?>" class="btn-dk">Đăng nhập</a></div>
        <input type="hidden" id="siteName" value="Ricky">
    </div>
</div>
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<!-- <script type="text/javascript" src="assets/js/particles.js"></script> -->
<script type="text/javascript" src="assets/js/common.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript" src="assets/js/user_register.js"></script>
</body>
</html>
