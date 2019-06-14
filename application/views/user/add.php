<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Lưu</button></li>
                    <li><a href="<?php echo base_url('user/staff'); ?>" class="btn btn-default">Đóng</a></li>
                </ul>
            </section>
            <section class="content">
                <?php echo form_open('api/user/saveUser', array('id' => 'userForm')); ?>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Họ và tên <span class="required">*</span></label>
                            <input type="text" name="FullName" class="form-control " value="" data-field="Họ và tên">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Mã nhân viên <span class="required">*</span></label>
                            <input type="text" name="UserName" id="userName" class="form-control" value="" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" name="Email" class="form-control " value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Di động</label>
                            <input type="text" name="PhoneNumber" id="phoneNumber" class="form-control " value="">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Trạng thái</label>
                            <?php $this->Mconstants->selectConstants('status', 'StatusId'); ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Nhóm quyền <span class="required">*</span></label>
                            <?php $this->Mconstants->selectObject($listGroups, 'GroupId', 'GroupName', 'GroupIds1[]', 0, true, '', ' select2', ' multiple'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php $avatar = (set_value('Avatar')) ? set_value('Avatar') : NO_IMAGE; ?>
                            <img src="<?php echo USER_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 100%;display: block;">
                            <input type="text" hidden="hidden" name="Avatar" id="avatar" value="<?php echo $avatar; ?>">
                        </div>
                        <p><a href="javascript:void(0)" class="chooseImage">Upload ảnh avatar</a></p>
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Số tiền giới hạn định mức (VNĐ)</label>
                                    <div class="input-group">
                                        <input type="text" id="maxCost" name="MaxCost" class="form-control" value="0" style="width: 90%;">
                                        <span class="input-group-addon" style="float: left;border: none;background: none;">
                                            <span class="item"><input type="checkbox" id="cbUnlimit" class="iCheck"> Không giới hạn</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Mật khẩu <span class="required">*</span></label>
                                    <input type="text" id="newPass" name="UserPass" class="form-control hmdrequired" value="" data-field="Mật khẩu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Gõ lại Mật khẩu <span class="required">*</span></label>
                                    <input type="text" id="rePass" class="form-control hmdrequired" value="" data-field="Mật khẩu">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="javascript:void(0)" class="btn btn-default" id="generatorPass">Sinh Mật khẩu</a>
                            </div>
                        </div>
                        <ul class="list-inline pull-right margin-right-10">
                            <li><input class="btn btn-primary submit" type="submit" name="submit" value="Lưu"></li>
                            <li><a href="<?php echo base_url('user/staff'); ?>" class="btn btn-default">Đóng</a></li>
                            <input type="text" name="UserId" id="userId" hidden="hidden" value="0">
                            <input type="text" name="GroupIds" id="groupIds" hidden="hidden" value="">
                            <input type="text" id="userEditUrl" hidden="hidden" value="<?php echo base_url('user/edit'); ?>">
                        </ul>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>