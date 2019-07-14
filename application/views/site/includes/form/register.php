<?php echo form_open('api/user/register', array('id' => 'userRegisterForm')); ?>
<div class="col-md-6">
    <div class="form-group">
        <label>Điện thoại</label>
        <div class="phone-input-group">
            <input id="register--phone" class="form-control hmdrequired" data-field="Số điện thoại" placeholder="Nhập số điện thoại" type="text" />
        </div>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input id="register--email" class="form-control hmdrequired" type="email" data-field="Nhập email" placeholder="Nhập email" />
    </div>
    <div class="form-group">
        <label>Mật khẩu</label>
        <input id="register--password" type="password" class="form-control hmdrequired" data-field="Mật khẩu" placeholder="Nhập mật khẩu" />
    </div>
    <div class="form-group">
        <label>Nhập lại mật khẩu</label>
        <input id="register--password-confirm" type="password" class="form-control hmdrequired" data-field="Mật khẩu xác thực" placeholder="Nhập lại mật khẩu" />
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label>Họ tên</label>
        <input id="register--fullname" class="form-control hmdrequired" data-field="Họ tên" placeholder="Họ tên" type="text" />
    </div>
    <div class="form-group">
        <label>Câu hỏi bảo mật</label>
        <select id="register--security-question" class="form-control hmdrequired" data-field="Câu hỏi bảo mật">
            <option value=''>Câu hỏi bảo mật</option>
            <?php
                foreach($listQuestions as $item) {
                    echo "<option value='{$item['QuestionId']}'>{$item['QuestionName']}</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Đáp án câu hỏi bảo mật</label>
        <input id='register--security-answer' value="" placeholder="Nhập đáp án câu hỏi bảo mật" data-field="Đáp án câu hỏi bảo mật" type="text" class="form-control hmdrequired" />
    </div>
    <div class="clearfix"></div>
    <button type="button" class="btn btn-primary" id="btnRegister">ĐĂNG KÝ</button>
</div>
<div class="clearfix"></div>
<?php echo form_close(); ?>