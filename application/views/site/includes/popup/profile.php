<div class="modal fade popup" id="modal--profile" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="profileModalLabel">Tài khoản của Tôi</h4>
      </div>
      <div class="modal-body">
          <?php echo form_open('api/user/profile', array('id' => 'userProfileForm')); ?>
          <div class="form-group">
              <label>Số điện thoại</label>
              <input id='profile--phone' placeholder="Nhập số điện thoại" data-field="Số điện thoại" type="text" class="form-control hmdrequired" />
          </div>
          <div class="form-group">
              <label>Email</label>
              <input id='profile--email' placeholder="Nhập email" data-field="Email" type="email" class="form-control hmdrequired" />
          </div>
          <div class="form-group">
              <label>Họ tên</label>
              <input id='profile--fullname' placeholder="Nhập họ tên" data-field="Họ tên" type="email" class="form-control hmdrequired" />
          </div>
          <div class="form-group">
              <label>Câu hỏi bảo mật</label>
              <select id="profile--security-question" class="form-control hmdrequired" data-field="Câu hỏi bảo mật">
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
              <input id='profile--security-answer' placeholder="Nhập đáp án câu hỏi bảo mật" data-field="Đáp án câu hỏi bảo mật" type="text" class="form-control hmdrequired" />
          </div>
      </div>
      <?php echo form_close(); ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id='profile--cancel' data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id='profile--submit'>Cập nhật</button>
      </div>
    </div>
  </div>
</div>
