    <!-- BEGIN FOOTER -->
        <div class="page-footer container-fluid">
            <div class="page-footer-inner" style="width:100%;text-align: center;">
            2015 &copy; <?php echo isset($this->var['SYSTEM_ABBR']) ? $this->var['SYSTEM_ABBR'] : NULL; ?>
            </div>
<!--            <div class="page-footer-tools">
            <span class="go-top">
            <i class="fa fa-angle-up"></i>
            </span>
            </div>-->
        </div>
    </div>
<!-- END CONTAINER -->
    <!-- END FOOTER -->
<!--        <footer id="footer" class="collapse navbar-collapse navbar navbar-inverse navbar-fixed-bottom text-smaller">
            <span>Powered by: eGov4MD Inc.</span>
            <span class="pull-right">
                Framework: <a href="http://ellislab.com/codeigniter">CodeIgniter</a> | 
                Front End: <a href="http://getbootstrap.com/">Bootstrap3</a>, <a href="javascript:;">HTML5</a>, <a href="javascript:;">CSS3</a> | 
                Icons by: <a href="http://glyphicons.com/">Glyphicons</a> &nbsp;&nbsp;
            </span>
        </footer>-->
<!------------------------------------------------------------------------------------------------ -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo GLOBAL_ASSETS;?>plugins/respond.min.js"></script>
<script src="<?php echo GLOBAL_ASSETS;?>plugins/excanvas.min.js"></script> 
<![endif]-->
<?php loadJSCoreLevelPlugins(); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script src="<?php echo CUSTOM_ASSETS?>scripts/CustomDropdowns.js"></script>-->
<?php loadJSPageLevelPlugins();?>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php loadJSPageLevelScripts();?>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="<?php echo CUSTOM_ASSETS;?>scripts/function.js"></script>

<script>
jQuery(document).ready(function() {    
//    Metronic.init(); // init metronic core components
//    Layout.init(); // init current layout
//    Demo.init();
//    CustomDropdowns.init();
    <?php initializeScripts(); ?>
});
</script>
<!-- END JAVASCRIPTS -->
</body>
</html>