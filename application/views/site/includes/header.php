<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dự Đoán Lô Đề</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="Dự đoán lô đề và nhận giải thưởng thẻ cào.">
        <meta name="keywords" content="lo de, danh de, lô đề, đánh đề">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="assets/web/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.min.css"/>
        <link href="assets/web/css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="https://fonts.googleapis.com/css?family=Anton&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,900&display=swap&subset=vietnamese" rel="stylesheet">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="60x60" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="76x76" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" />
        <link rel="icon" type="image/png" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" sizes="196x196" />
        <link rel="icon" type="image/png" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" sizes="96x96" />
        <link rel="icon" type="image/png" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" sizes="16x16" />
        <link rel="icon" type="image/png" href="assets/vendor/dist/favicon/apple-touch-icon-57x57.png" sizes="128x128" />

        <?php $title = 'Tham gia dự đoán lô đề, trúng thẻ cào điện thoại'; ?>
        <?php $content = 'Mình đã tham gia dự đoán rồi, còn bạn thì sao? Cùng chơi và cùng trúng nhé.' ?>

        <meta property="og:url" content="<?php echo current_url() ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo $title ?>" />
        <meta property="og:description" content="<?php echo $content ?>" />
        <meta property="og:image:width" content="400" />
        <meta property="og:image:height" content="300" />
        <meta property="og:image" content="<?php echo base_url().'assets/images/bg_share.png' ?>" />
        <base href="<?php echo base_url(); ?>" />
    </head>
    <body>
        <div class="side_menu">
            <div class="burger_box visible-xs">
                <div class="menu-icon-container">
                    <a href="#" class="menu-icon js-menu_toggle closed">
                    <span class="menu-icon_box">
                    <span class="menu-icon_line menu-icon_line--1"></span>
                    <span class="menu-icon_line menu-icon_line--2"></span>
                    <span class="menu-icon_line menu-icon_line--3"></span>
                    </span>
                    </a>
                </div>
            </div>
            <div>
                <h2 class="menu_title">Tài khoản</h2>
                <ul class="list_load">
                    <?php if($user): ?>
                    <li class="list_item reward-notification">
                        <p>Bạn được nhận thưởng</p>
                        <span class="bg-money">0</span>
                    </li>
                    <li class="list_item">
                        <a href="javascript:;" data-toggle="modal" data-target="#modal--profile">
                            Profile
                        </a>
                    </li>
                    <li class="list_item">
                        <a href="javascript:;" data-toggle="modal" data-target="#modal--changePassword">
                            Đổi mật khẩu
                        </a>
                    </li>
                    <li class="list_item">
                        <a href="<?php echo base_url('site/logout'); ?>" class="dropdown-item">
                            <span class="fa-power-off-white"></span>Đăng xuất
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="list_item">
                        <a class="scrollTo sp-login" href='javascript:;'>
                            Đăng nhập
                        </a>
                    </li>
                    <li class="list_item">
                        <a class="scrollTo sp-register" href='javascript:;'>
                            Đăng ký
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="header">
            <div class="container collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
                <?php if($user): ?>
                <div class="header-w3left">
                    <span class="pull-left">Bạn được<br>nhận thưởng</span>
                    <span class="bg-money">0</span>
                </div>
                <div class="header-w3right">
		            <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Chào, <?php echo $user['UserName']; ?></a>
                        <div class="dropdown-menu">
                            <a href="javascript:;" data-toggle="modal" data-target="#modal--profile">
                                <span class=""></span>Profile
                            </a>
                            <a href="javascript:;" data-toggle="modal" data-target="#modal--changePassword">
                                <span class=""></span>Đổi mật khẩu
                            </a>
                            <a href="<?php echo base_url('site/logout'); ?>" class="dropdown-item"><span class="fa-power-off"></span>Đăng xuất</a>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="header-w3right">
                    <ul>
                        <li><a class="scrollTo login" href='javascript:;'>ĐĂNG NHẬP</a></li>
                        <li>|</li>
                        <li><a class="scrollTo register" href='javascript:;'>ĐĂNG KÝ</a></li>
                    </ul>
                </div>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
            <?php if(!$user): ?>
            <div class="account-login visible-xs">
                <a class="scrollTo" href='javascript:;'>
                    <span class="fa-account-yellow"></span>
                </a>
            </div
            ><?php endif; ?>
        </div>
        <!-- //navigation -->
        <!-- banner -->
        <div class="banner">
            <div class="container">
                <div  id="top" class="callbacks_container">
                    <ul class="rslides" id="slider3">
                        <li>
                            <div class="banner-agileinfo">
                                <h4>DỰ ĐOÁN<br><span style="color: #e8b54a;">LÔ ĐỀ</span>NHẬN THƯỞNG<br>MỖI NGÀY</h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //banner -->
