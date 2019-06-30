<?php $this->load->view('site/includes/header'); ?>
    <!-- services -->
    <div id="services" class="services">
            <div class="container">
                <h2>NHẬP SỐ DỰ ĐOÁN</h2>
                <h3>CHỌN 2 SỐ VÀ NHẤN "<span>NHẬP SỐ</span>"</h3>
                <?php echo form_open('site/update', array('id' => 'inputNumberForm')); ?>
                    <div class="input-group-t">
                        <div class="services-left">
                            <div class="serw3agile-grid">
                                <span class="hi-icon hi-icon-archive glyphicon"><input type="text" name="NumberOne" maxlength="1" placeholder="$" value="" class="cost hmdrequired" data-field="Nhập số"> </span>
                            </div>
                        </div>
                        <div class="services-right">
                            <div class="serw3agile-grid">
                                <span class="hi-icon hi-icon-archive glyphicon"> <input type="text" name="NumberTwo" maxlength="1" placeholder="$" class="cost hmdrequired" data-field="Nhập số"></span>
                            </div>
                        </div>
                        <?php if($user): ?>
                        <div class="fb-share-button" data-href="http://loyalty.client.webstarterz.com/ban-da-chia-se-ket-qua-du-doan-la/<?php echo $num; ?>" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary submit">NHẬP SỐ</button>
                <?php echo form_close(); ?>
            </div>
        </div>

    <!-- //services -->
    <!-- rewarded -->
    <div id="rewarded" class="rewarded">
        <div class="container">
            <h1 class="title">Nhận Thưởng</h1>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>HỌ TÊN</th>
                        <th class="text-center">GIẢI THƯỞNG</th>
                    </tr>
                </thead>
                <tbody id="tbody-bac">
                </tbody>
            </table>
        </div>
    </div>
    <!-- //rewarded -->
    <!-- guess -->
    <?php if(!$user): ?>
    <div id="form-guess" class="form-guess">
        <div class="container">
            <h1 class="title">THAM GIA DỰ ĐOÁN LÔ ĐỀ!</h1>
            <ul class="nav nav-tabs" id="myForm">
                <li class="active"><a href="#login">ĐĂNG NHẬP</a></li>
                <li><a href="#register">ĐĂNG KÝ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="login">
                    <?php echo form_open('api/user/checkLogin', array('id' => 'userForm')); ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control hmdrequired" name="UserName" value="" placeholder="Nhập email hoặc số điện thoại" data-field="Nhập email hoặc số điện thoại">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="UserPass" id="password" class="form-control hmdrequired" value="" placeholder="Nhập password" data-field="Password">
                        </div>
                        <div class="col-md-6 text-left">
                            <label class="container">Nhớ tôi
                                <input type="checkbox" checked="checked" class="checked-custom" name="IsRemember" id="isRemember" value="on">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="javascript:void(0)" id="forgotpass">Quên mật khẩu</a>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary">ĐĂNG NHẬP</button>
                        <div class="clearfix"></div>
                        <div class="form-group text-center">
                            <span>Bạn chưa có tài khoản? <a href="#register" id="signup">Đăng ký!</a> tại đây</span>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                <div class="tab-pane" id="register">
                    <?php echo form_open('api/user/saveUser', array('id' => 'userRegisterForm')); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control hmdrequired" data-field="Nhập email" placeholder="Nhập email" id="email">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" id="userPass" class="form-control hmdrequired" data-field="Nhập mật khẩu" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group">
                                <label>Câu hỏi bảo mật</label>
                                <select class="form-control hmdrequired" data-field="Câu hỏi bảo mật" placeholder="Câu hỏi bảo mật" id="security-question">
                                  <option value=''>chọn câu hỏi</option>
                                  <option value='1'>câu hỏi 1</option>
                                  <option value='2'>câu hỏi 2</option>
                                  <option value='3'>câu hỏi 3</option>
                                  <option value='4'>câu hỏi 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control hmdrequired" data-field="Họ và tên" placeholder="Họ và tên" id="fullName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>Điện thoại</label>
                              <input type="text" class="form-control hmdrequired" data-field="Số điện thoại di động" placeholder="Số điện thoại di động" id="phoneNumber">
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" id="rePass"  class="form-control hmdrequired" data-field="Nhập lại mật khẩu" placeholder="Nhập lại mật khẩu">
                            </div>
                            <div class="form-group">
                                <label>Đáp án câu hỏi bảo mật</label>
                                <input type="text" id="security-anwser" class="form-control hmdrequired" data-field="Đáp án câu hỏi bảo mật" placeholder="Đáp án câu hỏi bảo mật">
                            </div>
                            <div class="clearfix"></div>
                            <button type="button" class="btn btn-primary" id="btnRegister">ĐĂNG KÝ</button>
                        </div>
                        <div class="clearfix"></div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- //guess -->
<?php $this->load->view('site/includes/footer'); ?>
