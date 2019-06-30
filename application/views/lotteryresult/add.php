<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
	<div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
            <ul class="list-inline pull-right margin-right-10">
            	<li><button class="btn btn-primary submit" type="button">Thêm</button></li>
        		<li><a href="<?php echo base_url('lotteryresult'); ?>" id="urlBlack" class="btn btn-default">Hủy</a></li>
                
            </ul>
        </section>
        <section class="content new-box-stl ft-seogeo">
            <?php echo form_open('lotteryresult/update', array('id' => 'lotteryresultForm')); ?>
            	<div class="row">
            		<div class="col-sm-2">
                    </div>
                    <div class="col-sm-6 no-padding">
                        <div class="box box-default padding20">
                        	<div class="row">
                        		<div class="col-sm-6 form-group">
                        			<label class="control-label">Đài sổ (*)</label>
                        			<?php $this->Mconstants->selectObject($lotteryStationList, 'LotteryStationId', 'LotteryStationName', 'LotteryStationId', 17, true, '--Đài sổ--', ' select2'); ?>
                        		</div>
                        		<div class="col-sm-6 form-group">
                        			<label class="control-label">Ngày sổ (*)</label>
                        			<div class="input-group">
	                                    <span class="input-group-addon">
	                                        <i class="fa fa-calendar"></i>
	                                    </span>
	                                    <input type="text" class="form-control datepicker hmdrequired" id="cDateTime" name="CrDateTime" value="" autocomplete="off" data-field="Ngày sổ">
	                                </div>
                        		</div>
                        	</div>
                        	
                        </div>
                        <div class="box box-default padding20">
                        	<div class="row">
                        		<div class="col-sm-12 form-group">
                        			<div class="box-body table-responsive no-padding divTable">
			                            <table class="table table-hover table-bordered">
			                                <thead class="theadNormal">
			                                <tr>
			                                    <th style="width: 150px;">Kết quả (*)</th>
			                                </tr>
			                                </thead>
			                                <tbody id="tbodyDetails">
			                                <tr>
			                                    <td><input type="text" class="form-control raffle cost hmdrequired" name="Raffle" id="raffle_1" data-field="Kết quả"></td>
			                                </tr>
			                                </tbody>
			                            </table>
			                        </div>
                        		</div>
                        	</div>
                        </div>
                        <input type="hidden" id="lotteryResultId"  name="LotteryResultId" value="0">
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
            <?php echo form_close(); ?>
        </section>    
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>