<?php $this->load->view('site/includes/header'); ?>
    <!-- services -->
    <div id="services" class="services">
        <div class="container">
            <?php echo form_open('site/update', array('id' => 'inputNumberForm')); ?>
                <div class="services-left">
                    <div class="serw3agile-grid">
                        <span class="hi-icon hi-icon-archive glyphicon"><input type="text" name="" maxlength="1" placeholder="$" value="" class="cost hmdrequired" data-field="Nhập số"> </span>
                    </div>
                </div>
                <div class="services-right">
                    <div class="serw3agile-grid">
                        <span class="hi-icon hi-icon-archive glyphicon"> <input type="text" name="" maxlength="1" placeholder="$" class="cost hmdrequired" data-field="Nhập số"></span>
                    </div>
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
                <tbody>
                    <tr>
                        <td class="text-indent">Huỳnh Ngọc Hùng</td>
                        <td class="text-center">Thẻ Cào Điện Thoại 200.000VNĐ</td>
                    </tr>
                    <tr>
                        <td class="text-indent">Nguyễn Thị Minh Tâm</td>
                        <td class="text-center">Thẻ Cào Điện Thoại 200.000VNĐ</td>
                    </tr>
                    <tr>
                        <td class="text-indent">Lê Thị Minh</td>
                        <td class="text-center">Thẻ Cào Điện Thoại 200.000VNĐ</td>
                    </tr>
                    <tr>
                        <td class="text-indent">Võ Minh Phát</td>
                        <td class="text-center">Thẻ Cào Điện Thoại 200.000VNĐ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- //rewarded -->
    <!-- guess -->
    <div id="form-guess" class="form-guess">
        <div class="container">
            <h1 class="title">THAM GIA DỰ ĐOÁN LÔ ĐỀ!</h1>
            <ul class="nav nav-tabs" id="myForm">
                <li class="active"><a href="#login">ĐĂNG NHẬP</a></li>
                <li><a href="#register">ĐĂNG KÝ</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="login">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu">
                        </div>
                        <div class="col-md-6 text-left">
                            <label class="container">Nhớ tôi
                                <input type="checkbox" checked="checked" class="checked-custom">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="#">Quên mật khẩu</a>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-primary">ĐĂNG NHẬP</button>
                        <div class="clearfix"></div>
                        <div class="form-group text-center">
                            <span>Bạn chưa có tài khoản? <a href="#register" id="signup">Đăng ký!</a> tại đây</span>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="register">
                    <form action="" method="post">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"  class="form-control" id="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" name="password" id="password"  class="form-control" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" name="password" id="password"  class="form-control" placeholder="Nhập mật khẩu">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="email" name="email"  class="form-control" id="email" placeholder="Nhập email">
                            </div>
                            <div class="form-group">
                                <label>Điện thoại</label>
                                <input type="text" name="" class="form-control phone-input" placeholder="Nhập điện thoại">
                            </div>
                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-primary">ĐĂNG KÝ</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- //guess -->
<?php $this->load->view('site/includes/footer'); ?>