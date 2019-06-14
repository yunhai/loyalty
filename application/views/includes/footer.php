<?php $siteName = 'Ricky';
$email = 'ricky@gmail.com';
$configs = $this->session->userdata('configs');
if($configs){
    if(isset($configs['SITE_NAME'])) $siteName = $configs['SITE_NAME'];
    if(isset($configs['EMAIL_COMPANY'])) $email = $configs['EMAIL_COMPANY'];
} ?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong></strong>&nbsp;
</footer>
</div>
<input type="text" hidden="hidden" id="rootPath" value="<?php echo ROOT_PATH; ?>">
<input type="text" hidden="hidden" id="siteName" value="<?php echo $siteName; ?>">
<input type="text" hidden="hidden" id="userImagePath" value="<?php echo USER_PATH; ?>">
<?php if(!$user) $user = $this->session->userdata('user');
if($user){ ?>
    <input type="text" hidden="hidden" id="userLoginId" value="<?php echo $user['UserId']; ?>">
    <input type="text" hidden="hidden" id="fullNameLoginId" value="<?php echo $user['FullName'] ?>">
    <input type="text" hidden="hidden" id="avatarLoginId" value="<?php echo empty($user['Avatar']) ? NO_IMAGE : $user['Avatar']; ?>">
<?php } else { ?>
    <input type="text" hidden="hidden" id="userLoginId" value="0">
    <input type="text" hidden="hidden" id="fullNameLoginId" value="">
    <input type="text" hidden="hidden" id="avatarLoginId" value="<?php echo NO_IMAGE; ?>">
<?php } ?>
<input type="text" hidden="hidden" id="getListWardUrl" value="<?php echo base_url('api/config/getListWard'); ?>">
<input type="text" hidden="hidden" id="getRemindUrl" value="<?php echo base_url('remind/getReminds'); ?>">
<input type="text" hidden="hidden" id="detailRemindUrl" value="<?php echo base_url('remind/edit'); ?>">
<input type="text" hidden="hidden" id="detailConsultUrl" value="<?php echo base_url('customerconsult/edit'); ?>">
<input type="text" hidden="hidden" id="chatServerUrl" value="<?php echo CHAT_SERVER; ?>">
<div id="divInputRemindIds" style="display: none"></div>
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/plugins/fastclick/fastclick.js"></script>
<script src="assets/vendor/dist/js/app.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.min.js"></script>
<script src="assets/vendor/plugins/select2/select2.full.min.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/common.js"></script>
<!--<script type="text/javascript" src="assets/vendor/plugins/socket.io/socket.io.js"></script>
<script type="text/javascript" src="assets/vendor/plugins/jquery.playSound.js"></script>
<script type="text/javascript" src="assets/js/chat_staff.js"></script>-->
<?php if(isset($scriptFooter)) outputScript($scriptFooter); ?>
</body>
</html>