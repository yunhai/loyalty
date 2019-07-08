<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
        </section>
        <section class="content new-box-stl ft-seogeo">
            <?php if($userId > 0): ?>
            <?php echo form_open('user/update', array('id' => 'userForm')); ?>
                <div class="row">
                    <div class="col-sm-8 no-padding">
                        <div class="box box-default padding20">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label">Họ tên <span class="required">*</span></label>
                                    <input type="text" name="FullName" class="form-control hmdrequired" value="<?php echo $userEdit['FullName']; ?>" data-field="Họ và tên">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class="control-label">Số điện thoại <span class="required">*</span></label>
                                    <input type="text" name="PhoneNumber" id="phoneNumber" class="form-control hmdrequired" value="<?php echo $userEdit['PhoneNumber']; ?>" data-field="Di động">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                     <label class="control-label">Email <span class="required">*</span></label>
                                    <input type="text" name="Email" class="form-control hmdrequired" value="<?php echo $userEdit['Email']; ?>" data-field="Email">
                                </div>
                                
                            </div>
                             <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Mật khẩu</label>
                                        <input type="text" id="newPass" class="form-control" value="" name="Password" />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Nhắc lại mật khẩu</label>
                                        <input type="text" id="rePass" class="form-control" value="" name="PasswordConfirm" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:void(0)" class="btn btn-primary" id="generatorPass">Sinh Mật khẩu</a>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="list-inline pull-right margin-right-10">
                                    <li><input class="btn btn-primary submit" type="submit" name="submit" value="Cập nhật"></li>
                                    <li><a href="<?php echo base_url('user/list'); ?>" class="btn btn-default">Hủy</a></li>
                                    <input type="text" name="UserId" id="userId" hidden="hidden" value="<?php echo $userId; ?>">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
            <?php else: ?>
                <h1 class="text-center"><?php echo $txtError ?></h1>
            <?php endif; ?>
        </section>    
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>

