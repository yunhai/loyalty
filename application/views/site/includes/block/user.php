<?php if(!$user): ?>
<div id="form-guess" class="form-guess">
    <div class="container">
        <h1 class="title">THAM GIA DỰ ĐOÁN LÔ ĐỀ!</h1>
        <ul class="nav nav-tabs account--navigator" id="myForm">
            <li class="active"><a href="#dang-nhap">ĐĂNG NHẬP</a></li>
            <li><a href="#dang-ky-thanh-vien">ĐĂNG KÝ</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane login-form active" id="dang-nhap">
                <?php $this->load->view('site/includes/form/login'); ?>
            </div>
            <div class="tab-pane register-form" id="dang-ky-thanh-vien">
                <?php $this->load->view('site/includes/form/register'); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('site/includes/popup/forget-password'); ?>
<?php else: ?>
<?php $this->load->view('site/includes/popup/profile'); ?>
<?php $this->load->view('site/includes/popup/change-password'); ?>
<?php endif; ?>
