<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo (isset($this->var['SYSTEM_ABBR']) ? $this->var['SYSTEM_ABBR'] : NULL).' | '.(isset($this->var['CURRENT_MODULE']) ? $this->var['CURRENT_MODULE'] : NULL);?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">-->
<?php loadCSSGlobalMandatoryStyles();?>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<?php loadCSSPageLevelStyles();?>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<?php loadCSSThemeStyles();?>
<!-- END THEME STYLES -->
<!-- BEGIN CUSTOM STYLES -->
<?php loadCSSCustomStyles();?>
<!-- END CUSTOM STYLES -->
<link rel="shortcut icon" href="<?php echo BASE_URL;?>assets/images/favicon.png" type="image/x-icon">

</head>
<!-- END HEAD -->
