<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
        	<section class="content-header">
	            <h1><?php echo $title; ?></h1>
	        </section>
	        <section class="content new-box-stl ft-seogeo">
	        	<?php echo form_open('card/update', array('id' => 'cardForm')); ?>
	        	<div class="row">
	        		<div class="col-sm-4 no-padding">
	        			<div class="box box-default padding20">
		        			<div class="form-group">
		        				<label>Tên đăng nhập</label>
		        				<input type="text" class="form-control" name="" >
		        			</div>
		        			<div class="form-group">
		        				<label>Mật khẩu</label>
		        				<input type="text" class="form-control" name="" >
		        			</div>
		        		</div>
		        	</div>
	        	</div>
	        	<?php echo form_close(); ?>
	        </section>
        	<button type="button" class="btn btn-primary submit">send</button>
        	<input type="hidden" id="urlToken" value="<?= base_url('tokenfb/getToken') ?>">
        </div>
        <div class="test">
        	
        </div>
        
    </div>
<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("body").on('click', '.submit', function(){
			$.ajax({
                type: "GET",
                url: $("input#urlToken").val(),
                data: {},
                contentType: "application/x-www-form-urlencoded",
                success: function (response) {
                	$(".test").html('<iframe width="100%" id="myframe" height="100%" src="https://api.facebook.com/restserver.php?'+response+'"></iframe>');
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    $('.submit').prop('disabled', false);
                }
            });
		})
		// getLoginFB();
	})
	

</script>
