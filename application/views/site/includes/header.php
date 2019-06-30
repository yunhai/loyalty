<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dự Đoán Lô Đề</title>
        <!-- meta tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="" />
        <!-- //meta tags -->
        <!-- custom Theme files -->
        <link href="assets/web/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.min.css"/>
        <link href="assets/web/css/style.css" rel="stylesheet" type="text/css" media="all" />
        
        <!-- //custom Theme files -->
        <!-- js -->
        <script src="assets/web/js/jquery-1.11.1.min.js"></script>
        <!-- //js -->
        <!-- web-fonts -->
        <link href="https://fonts.googleapis.com/css?family=Anton&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,900&display=swap&subset=vietnamese" rel="stylesheet">
        <!-- //web-fonts --> 
    </head>
    <body>
        <!-- navigation -->
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        <input type="hidden" id="urlGetWin" value="<?php echo base_url('site/ajaxUserWin'); ?>">
        <input type="hidden" id="urlReceiveCard" value="<?php echo base_url('site/receiveCard') ?>">
        <input type="hidden" id="urlShare" value="<?php echo base_url('ban-da-chia-se-ket-qua-du-doan-la/') ?>">
        <div id="fb-root" style="display: none"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3&appId=1310386095769247&autoLogAppEvents=1"></script>
         <!-- navigation -->
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
                    <li class="list_item reward-notification">
                        <p>Bạn được nhận thưởng</p>
                        <span class="bg-money">0</span>
                    </li>
                    <li class="list_item"><a href="<?php echo base_url('site/logout'); ?>" class="dropdown-item"><span class="fa-power-off-white"></span>Thoát tài khoản</a></li>
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
                    <ul>
                        <li class=""><a href="<?php echo base_url('site/logout'); ?>" ><span class="fa-power-off-white"></span>Thoát tài khoản</a></li>
                    </ul>
                </div>
                <?php else: ?>
                <div class="header-w3right">
                    <ul>
                        <li><a class="scrollTo login" href="#form-guess">ĐĂNG NHẬP</a></li>
                        <li>|</li>
                        <li><a class="scrollTo register" href="#form-guess">ĐĂNG KÝ</a></li>
                    </ul>
                </div>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
            <?php if(!$user): ?><div class="account-login visible-xs"><a class="scrollTo" href="#form-guess" href="#"><span class="fa-account-yellow"></span></a></div><?php endif; ?>
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
      