<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>DeskFlow login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/metronic/assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="/metronic/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/metronic/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>
</head>
<body class="login">
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="/user/login">
        <img src="/images/whitelogo.png" alt="Deskflow"/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="" method="post">
        <h3 class="form-title">Login</h3>
                <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Gebruikersnaam</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Gebruikersnaam" name="u_email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Wachtwoord</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Wachtwoord" name="u_paswoord"/>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success uppercase">Login</button>
            <a href="javascript:;" id="forget-password" class="forget-password">Wachtwoord vergeten?</a>
        </div>
        <div class="login-options">
            <span class="pull-right">
                    <a class="social-icon facebook" data-original-title="facebook" href="https://www.facebook.com/Deskflow"></a>
                    <a class="social-icon twitter" data-original-title="Twitter" href="https://twitter.com/desk_flow"></a>
                    <a class="social-icon linkedin" data-original-title="LinkedIn" href="https://www.linkedin.com/company/deskflow"></a>
            </span>
        </div>
        <div class="create-account">
            <p>
                <a href="https://app.deskflow.eu/public/stap1" id="registreer-btn" class="uppercase">Registreren</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="/public/wachtwoordvergeten" method="post">
        <h3>Wachtwoord vergeten?</h3>

        <p>Vul uw e-mailadres in om uw wachtwoord te resetten.</p>

        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="e-mail" name="u_email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-success btn-warning">Terug</button>
            <button type="submit" class="btn btn-success uppercase pull-right">Verzenden</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div><!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/metronic/assets/global/plugins/respond.min.js"></script>
<script src="/metronic/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/metronic/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/metronic/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/metronic/assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        Metronic.setAssetsPath('/metronic/assets/');

        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
    });

    $(function () {
        $('#registreer-btn').click(function () {
            Metronic.blockUI({
                target: '.content',
                boxed: true
            });

            window.setTimeout(function () {
                Metronic.unblockUI('.content');
            }, 2000);
        });
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>




