<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php $this->load->view('includes/breadcrumb'); ?>
            <section class="content">
                <div class="box box-success">
                    <?php echo form_open('question/update', array('id' => 'questionForm')); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Câu hỏi</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            <?php
                            foreach($listQuestions as $bt){ ?>
                                <tr id="question_<?php echo $bt['QuestionId']; ?>">
                                    <td id="questionName_<?php echo $bt['QuestionId']; ?>"><?php echo $bt['QuestionName']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" data-id="<?php echo $bt['QuestionId']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['QuestionId']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><input type="text" class="form-control hmdrequired" id="questionName" name="QuestionName" value="" data-field="Câu hỏi"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="QuestionId" id="questionId" value="0" hidden="hidden">
                                    <input type="text" id="deleteUrl" value="<?php echo base_url('question/delete'); ?>" hidden="hidden">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>