<?php echo form_open('api/user/login', array('id' => 'userLoginForm')); ?>
    <div class="form-group">
        <label>Số điện thoại / Email</label>
        <input id="login--phone" class="form-control hmdrequired" value="" placeholder="Nhập số điện thoại hoặc email" data-field="Số điện thoại hoặc email" type="text" />
    </div>
    <div class="form-group">
        <label>Mật khẩu</label>
        <input id="login--password" type="password" class="form-control hmdrequired" value="" placeholder="Nhập mật khẩu" data-field="Mật khẩu" />
    </div>
    <div class="col-md-6 col-xs-6 text-left">
        <!-- <label class="container">Nhớ tôi
            <input type="checkbox" checked="checked" class="checked-custom" name="IsRemember" id="isRemember" value="on">
            <span class="checkmark"></span>
        </label> -->
    </div>
    <div class="col-md-6 col-xs-6 text-right">
        <a href="javascript:;" data-toggle="modal" data-target="#modal--forget-password">
            Quên mật khẩu
        </a>
    </div>
    <div class="clearfix"></div>
    <button type="button" class="btn btn-primary" id='btnLogin'>ĐĂNG NHẬP</button>
    <div class="clearfix"></div>
    <div class="form-group text-center">
        <span>Bạn chưa có tài khoản? <a href="#dang-ky-thanh-vien" id="signup-register-link">Đăng ký!</a> tại đây</span>
    </div>
<?php echo form_close(); ?>