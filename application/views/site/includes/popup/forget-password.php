<div class="modal fade popup" id="modal--forget-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Quên mật khẩu</h4>
      </div>
      <div class="modal-body">
          <?php echo form_open('api/user/resetPassword', array('id' => 'userResetPasswordForm')); ?>
          <div class="form-group">
              <label>Số điện thoại</label>
              <input id='resetPassword--phone' placeholder="Nhập số điện thoại" data-field="Số điện thoại" type="text" class="form-control hmdrequired" />
          </div>
          <div class="form-group">
              <label>Câu hỏi bảo mật</label>
              <select id="resetPassword--security-question" class="form-control hmdrequired" data-field="Câu hỏi bảo mật">
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
              <input id='resetPassword--security-answer' placeholder="Nhập đáp án câu hỏi bảo mật" data-field="Đáp án câu hỏi bảo mật" type="text" class="form-control hmdrequired" />
          </div>
          <div class="form-group">
              <label>Mật khẩu mới</label>
              <input id="resetPassword--password" class="form-control hmdrequired" placeholder="Nhập mật khẩu" data-field="Mật khẩu" type="password" />
          </div>
          <div class="form-group">
              <label>Nhập lại mật khẩu mới</label>
              <input id="resetPassword--password-confirm" class="form-control hmdrequired" placeholder="Nhập mật khẩu xác thực" data-field="Mật khẩu xác thực" type="password" />
          </div>
      </div>
      <?php echo form_close(); ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id='resetPassword--cancel' data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id='resetPassword--submit'>Cập nhật</button>
      </div>
    </div>
  </div>
</div>
