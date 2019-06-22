<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
            <ul class="list-inline">
                <?php if($userId > 0){ ?><li><button class="btn btn-primary submit">Cập nhật</button></li><?php } ?>
                <li><a href="<?php echo base_url('customerlike'); ?>" id="urlBlack" class="btn btn-default">Hủy</a></li>
            </ul>
        </section>
        <section class="content new-box-stl ft-seogeo">
            <?php if($userId > 0): ?>
            <?php echo form_open('api/user/saveUser', array('id' => 'userForm')); ?>
                <div class="row">
                    <div class="col-sm-8 no-padding">
                        <div class="box box-default padding20">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label class="control-label">Họ và tên <span class="required">*</span></label>
                                    <input type="text" name="FullName" class="form-control hmdrequired" value="<?php echo $userEdit['FullName']; ?>" data-field="Họ và tên">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="control-label">Số điện thoại <span class="required">*</span></label>
                                    <input type="text" name="PhoneNumber" id="phoneNumber" class="form-control hmdrequired" value="<?php echo $userEdit['PhoneNumber']; ?>" data-field="Di động">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                     <label class="control-label">Email <span class="required">*</span></label>
                                    <input type="text" name="Email" class="form-control hmdrequired" value="<?php echo $userEdit['Email']; ?>" data-field="Email">
                                </div>
                                
                            </div>
                             <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Mật khẩu</label>
                                        <input type="text" id="newPass" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Nhắc lại mật khẩu</label>
                                        <input type="text" id="rePass" class="form-control" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="javascript:void(0)" class="btn btn-primary" id="generatorPass">Sinh Mật khẩu</a>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="list-inline pull-right margin-right-10">
                                    <li><input class="btn btn-primary submit" type="submit" name="submit" value="Cập nhật"></li>
                                    <li><a href="<?php echo base_url('user/staff'); ?>" class="btn btn-default">Hủy</a></li>
                                    <input type="text" name="UserId" id="userId" hidden="hidden" value="<?php echo $userId; ?>">
                                    <input type="text" name="UserPass" hidden="hidden" value="<?php echo $userEdit['UserPass']; ?>">
                                    <input type="text" name="AnswerId" hidden="hidden" value="<?php echo $userEdit['AnswerId']; ?>">
                                    <input type="text" name="QuestionId" hidden="hidden" value="<?php echo $userEdit['QuestionId']; ?>">
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    <i class="fa fa-desktop" aria-hidden="true"></i> Câu hỏi bảo mật
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="text-center">
                                    <h4 class="mgbt-20 light-blue">Câu hỏi: <?php echo $question ?></h4>
                                    <h4 class="mgbt-20 light-blue">Trả lời: <?php echo $userEdit['AnswerId'] > 0 ? $this->Mconstants->answer[$userEdit['AnswerId']]:''; ?></h4>
                                </div>
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

