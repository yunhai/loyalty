<div class="modal fade popup" id="modal--changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="changePasswordModalLabel">Đổi mật khẩu</h4>
      </div>
      <div class="modal-body">
          <?php echo form_open('api/user/password', array('id' => 'userChangePasswordForm')); ?>
          
          <div class="form-group">
              <label>Mật khẩu hiện tại</label>
              <input type="password" id="changePassword--password-current" class="form-control hmdrequired" placeholder="Nhập mật khẩu hiện tại" data-field="Mật khẩu hiện tại">
          </div>
          <div class="form-group">
              <label>Mật khẩu mới</label>
              <input type="password" id="changePassword--password" class="form-control hmdrequired" placeholder="Nhập mật khẩu mới" data-field="Mật khẩu mới">
          </div>
          <div class="form-group">
              <label>Nhập lại mật khẩu mới</label>
              <input type="password" id="changePassword--password-confirm" class="form-control hmdrequired" placeholder="Nhập mật khẩu xác thực" data-field="Mật khẩu xác thực">
          </div>
      </div>
      <?php echo form_close(); ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id='changePassword--cancel' data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id='changePassword--submit'>Cập nhật</button>
      </div>
    </div>
  </div>
</div>
