<?php $this->load->view('includes/user/header'); ?>
    <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <div class="canhvang">
        <img src="assets/vendor/dist/img/canhvang.png" width="80px" class="mgr-5">
        <img src="assets/vendor/dist/img/rk.png" width="100px">
    </div>
    <div class="login-box-body custom-ip">
        <h3 class="yl-title">RICKY VIỆT NAM</h3>
        <div class="text-center mb-20">
            <div class="ps-rl">
            <img src="assets/vendor/dist/img/getbackpass.png"> <span class="pgbp">Lấy lại mật khẩu</span>
            </div>
        </div>
        <?php $this->load->view('includes/notice'); ?>
        <?php echo form_open('user/sendToken'); ?>
        <div class="input-field">
            <input type="text" class="material" name="Email" placeholder="Nhập email hoặc số điện thoại" /><span class="bottom"></span>
            <label><i class="ion-person"></i></label>
        </div>
        <button type="submit" class="btn btn-or btn-block btn-flat">Khôi phục</button>
        <?php echo form_close(); ?>
        <div class="text-center"><a href="<?php echo base_url('admin'); ?>" class="btn-dk">Trở lại trang đăng nhập</a></div>
    </div>
<?php $this->load->view('includes/user/footer'); ?>