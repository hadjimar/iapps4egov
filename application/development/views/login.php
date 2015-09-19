<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php loadLogin();?>
<!-- BEGIN HEADER -->
<?php include('header.php'); ?>
<!-- END HEADER -->
<body class="login">
    <div class="page-container">
    <div class="logo">
        <a href="<?php echo base_url();?>">
<!--            <img src="<?php echo base_url();?>assets/admin/layout/img/lbmis_logo.png" alt="logo" class="logo-default" height="20"/>
            <img src="<?php echo base_url();?>assets/admin/layout/img/hr_module.png" alt="module logo" class="logo-default" height="20"/>-->
        </a>
    </div>
    <div class="content">
        <form class="login-form" method="post" role="form">
            <h3 class="form-title">Login to your account</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter any username and password. </span>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Username / Email</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix" type="text" name="data[User]" placeholder="Username or Email" autocomplete="off">
                </div>
                <span class="text-danger"><?php echo form_error('data[User]');?></span>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" name="data[Password]" placeholder="Password" autocomplete="off">
                </div>
                <span class="text-danger"><?php echo form_error('data[Password]');?></span>
            </div>
            <div class="form-actions">
                <input class="btn btn-success uppercase" type="submit" name="btn_login" value="Login" />
            </div>
            
        </form>
    </div>
<!-- BEGIN FOOTER --> 
<?php include('footer.php'); ?>
<!-- END FOOTER -->