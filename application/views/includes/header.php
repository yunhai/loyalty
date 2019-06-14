<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $title; ?></title>
    <base href="<?php echo base_url(); ?>" id="baseUrl"/>
    <?php $this->load->view('includes/favicon'); ?>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.min.css"/>
    <link rel="stylesheet" href="assets/vendor/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="assets/vendor/plugins/iCheck/all.css">
    <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
    <link rel="stylesheet" href="assets/vendor/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/style.css?20180207">
    <link rel="stylesheet" href="assets/vendor/dist/css/common.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php $textLogoHeader = 'CRM MKT';
    $textLogoMenu = 'CRM MKT';
    $logoImage = NO_IMAGE;
    $configs = $this->session->userdata('configs');
    if($configs){
        if(isset($configs['TEXT_LOGO_HEADER'])) $textLogoHeader = $configs['TEXT_LOGO_HEADER'];
        if(isset($configs['TEXT_LOGO_MENU'])) $textLogoMenu = $configs['TEXT_LOGO_MENU'];
        if(isset($configs['LOGO_IMAGE'])) $logoImage = $configs['LOGO_IMAGE'];
    } ?>
    <header class="main-header">
        <a href="<?php echo base_url(); ?>" class="logo">
            <img src="assets/vendor/dist/img/logowt.png" width="40px" class="mgr-5">
        </a>
        <nav class="navbar navbar-static-top">
            <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php $avatar = empty($user['Avatar']) ? $logoImage : $user['Avatar']; ?>
                          <img src="<?php echo USER_PATH.$avatar; ?>" class="user-image" alt="User Image">
                          <span class="hidden-xs"><?php echo $user['FullName']; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                            <img src="<?php echo USER_PATH.$avatar; ?>" class="img-circle" alt="User Image">
                            <p> <?php echo $user['FullName']; ?></p>
                          </li>
                          <!-- Menu Footer-->
                          <li class="user-footer">
                            <div class="pull-left">
                              <a href="<?php echo base_url('user/profile'); ?>" class="btn btn-default btn-flat">Tài khoản của bạn</a>
                            </div>
                            <div class="pull-right">
                              <a href="<?php echo base_url('user/logout'); ?>" class="btn btn-default btn-flat">Đăng xuất</a>
                            </div>
                          </li>
                        </ul>
                      </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="<?php echo base_url('user/staff'); ?>">
                        <i class="fa fa-circle-o"></i> <span>Danh sách khách hàng</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="javascript:void(0)">
                        <i class="fa fa-circle-o"></i> <span>Cài đặt</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('card'); ?>"><i class="fa fa-circle-o"></i>Card điện thoại</a></li>
                        <li><a href="<?php echo base_url('lotteryresult'); ?>"><i class="fa fa-circle-o"></i>Kết quả sổ xố</a></li>
                        <li><a href="<?php echo base_url('question'); ?>"><i class="fa fa-circle-o"></i>Câu hỏi đăng ký TK</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>