<?php $this->load->view('includes/header'); ?>
<div class="content-wrapper">
	<div class="container-fluid">
        <section class="content-header">
            <h1><?php echo $title; ?></h1>
        </section>
        <section class="content new-box-stl ft-seogeo">
        	<?php if($cardId > 0): ?>
            <?php echo form_open('card/update', array('id' => 'cardForm')); ?>
            	<div class="row">
            		<div class="col-sm-2">
                    </div>
                    <div class="col-sm-4 no-padding">
                        <div class="box box-default padding20">
                        	<div class="row">
                        		<div class="col-sm-12 form-group">
                        			<label class="control-label">Tên nhà mạng (*)</label>
                        			<?php $this->Mconstants->selectConstants('homeNetwork', 'CardNameId', $card['CardNameId'], true, '-- Chọn nhà mạng --'); ?>
                        		</div>
                        		<div class="col-sm-12 form-group">
                        			<label class="control-label">Số seri (*)</label>
                        			<input type="text" class="form-control cost hmdrequired" name="CardSeri" id="cardSeri" placeholder="Số seri" data-field="Số seri" value="<?= $card['CardSeri'] ?>">
                        		</div>
                        		<div class="col-sm-12 form-group">
                        			<label class="control-label">Số thẻ cào (*)</label>
                        			<input type="text" class="form-control cost hmdrequired" name="CardNumber" id="cardNumber" placeholder="Số thẻ cào" data-field="Số thẻ cào" value="<?= $card['CardNumber'] ?>">
                        		</div>
                        	</div>
                        	<div class="row">
                        		<ul class="list-inline pull-right margin-right-10">
		                        	<li><button class="btn btn-primary submit" type="button">Thêm</button></li>
		                    		<li><a href="<?php echo base_url('card'); ?>" id="urlBlack" class="btn btn-default">Hủy</a></li>
                                    <input type="hidden" id="cardId"  name="CardId" value="<?= $card['CardId'] ?>">
		                        </ul>
                        	</div>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
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