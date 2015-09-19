<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- BEGIN HEADER -->
<?php include('header.php'); ?>
<!-- END HEADER -->
<body class="page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo" ng-app="App">
<!-- BEGIN TOP NAVIGATION -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?php echo BASE_URL;?>">
                <img src="<?php echo CUSTOM_ASSETS;?>images/iapps4egov_logo.png" alt="logo" class="logo-default" height="20"/> 
            </a>
            <div class="menu-toggler sidebar-toggler">
             <!--DOC: Remove the above "hide" to enable the sidebar toggler button on header--> 
            </div>
        </div>
        <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <div class="page-top">
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
            <!-- BEGIN NOTIFICATION DROPDOWN -->
            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-bell"></i>
                    <span class="badge badge-default">
                    0 </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                    <p>
                    You have 0 new notifications
                    </p>
                    </li>
                </ul>
            </li>
            <!-- END NOTIFICATION DROPDOWN -->

            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown dropdown-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img alt="" class="img-circle" src="<?php echo file_exists(APPPATH.'assets/files/pictures/'.$this->session->userdata('ifoure_profile_pic')) ? BASE_URL.'assets/files/pictures/'.$this->session->userdata('ifoure_profile_pic') : ADMIN_THEME.'img/avatar.png';?>"/>
                <span class="username">
                <?php echo $this->session->userdata('ifoure_fullname');?> </span>
                <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                <li>
                <a href="javascript:;">
                <i class="icon-user"></i> My Profile </a>
                </li>
                <li>
                <a href="javascript:;">
                <i class="icon-calendar"></i> My Calendar </a>
                </li>
    <!--            <li>
                <a href="inbox.html">
                <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
                3 </span>
                </a>
                </li>
                <li>
                <a href="#">
                <i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
                7 </span>
                </a>
                </li>-->
                <li class="divider">
                </li>
                <li>
                <a href="extra_lock.html">
                <i class="icon-lock"></i> Lock Screen </a>
                </li>
                <li>
                <a href="<?php echo BASE_URL;?>main/logout">
                <i class="icon-key"></i> Log Out </a>
                </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
            <li class="dropdown dropdown-quick-sidebar-toggler">
            <a href="<?php echo BASE_URL;?>main/logout" class="dropdown-toggle">
            <i class="icon-logout"></i>
            </a>
            </li>
            <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END TOP NAVIGATION -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php include('sidebar.php'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content" style="min-height:800px;">
                <!-- BEGIN PAGE HEADER-->
                <h3 class="page-title">
                    <span class="uppercase"><?php echo isset($this->var['page_name']) ? str_replace('_', ' ',$this->var['page_name']) : NULL;?></span> <small><?php echo isset($this->var['page_description']) ? $this->var['page_description'] : NULL;?></small>
                </h3>
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo BASE_URL; ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="<?php echo $this->var['page_url'];?>"><?php echo str_replace('_',' ',ucfirst($this->router->fetch_class()));?></a>
                            <i class="<?php echo $this->router->fetch_method() && $this->router->fetch_method()!= 'index' ? 'fa fa-angle-right' : NULL ;?>"></i>
                        </li>
                        <?php if($this->router->fetch_method() && $this->router->fetch_method()!= 'index') :?>
                        <li>
                            <a href="<?php echo $this->var['section_url'];?>"><?php echo str_replace('_',' ',ucfirst($this->router->fetch_method())); ?></a>
                        </li>
                        <?php endif; /*($this->router->fetch_method())*/?>
                    </ul>
                </div>
                <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
                <?php 
                    $page = '';
//                    $page .= $this->module ? $this->module.'/' : NULL;
                    $page .= isset($this->var['page_view']) ? $this->var['page_view'] : NULL;
                    $this->load->view($page); 
                ?>
            <!-- END PAGE CONTENT-->
            
            </div>
        </div>
        <!-- END CONTENT -->
        <!----------------------- BEGIN ERROR MESSAGE ----------------------->
        <?php if(isset($this->var['err_message'])) :?>
        <div id="toastr-notification" data-notification-type="<?php echo $this->var['err_message']['type'];?>" data-notification-heading="<?php echo $this->var['err_message']['heading'];?>" data-notification-content="<?php echo $this->var['err_message']['content'];?>">
        </div>
        <?php endif; /*(isset($this->var['err_message']))*/?>
        <!----------------------- END ERROR MESSAGE ----------------------->
<!-- BEGIN FOOTER --> 
<?php include('footer.php'); ?>
<!-- END FOOTER -->
