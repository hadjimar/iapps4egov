<?php

/**
 * Library for loading the Admin Theme Javascript and CSS files.  This file requires the settings.php (which needs to be initialized in the index.php) and the JSCSS_Loader_helper.php  
 * @package JSCSS Loader
 * @author redcrisostomo
 * @see JSCSS_Loader_helper.php (helper/JSCSSLoader_helper.php)
 * @see settings.php
 * @see index.php
 */
Class JSCSS_Loader
{
    public $css_global_mandatory_styles = array();
    public $css_page_level_styles = array();
    public $css_theme_styles = array();
    public $css_custom_styles = array();
    public $js_core_level_plugins = array();
    public $js_page_level_plugins = array();
    public $js_page_level_scripts = array();
    public $initscripts = array();
    
    public function __construct()
    {
        $host = $_SERVER['HTTP_HOST'];
         /*Set protocol*/
        $root = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        /*Set host*/
        $root .= $host;
        /*Set server name*/
        /* $_SERVER['SCRIPT_NAME'] is /subdirs/index.php, basename($_SERVER['SCRIPT_NAME'] is index.php -> replace to get subdirs and append to root */
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);
        $hostname = $root;
    }
    
    /*------------ BEGIN CSS LOADERS ------------*/
    /**
     * CSS Global Mandatory Styles
     */
    public function loadCSSGlobalMandatoryStyles()
    {
        if(count($this->css_global_mandatory_styles)==0){return FALSE;}
        foreach($this->css_global_mandatory_styles as $style){echo $style;}
        return;
    }
    
    /**
     * CSS Page Level Styles
     */
    public function loadCSSPageLevelStyles()
    {
        if(count($this->css_page_level_styles)==0){return FALSE;}
        foreach($this->css_page_level_styles as $style){echo $style;}
        return;
    }
    /**
     * CSS Theme Styles
     */
    public function loadCSSThemeStyles()
    {
        if(count($this->css_theme_styles)==0){return FALSE;}
        foreach($this->css_theme_styles as $style){echo $style;}
        return;
    }
    
    /**
     * CSS Custom Styles
     */
    public function loadCSSCustomStyles()
    {
        if(count($this->css_custom_styles)==0){return FALSE;}
        foreach($this->css_custom_styles as $style) {echo $style;}
        return;
    }
    /*------------ END CSS LOADERS ------------*/
    
    /*------------ BEGIN JAVASRIPT LOADERS ------------*/
    
    /**
     * JS Core Level Plugins
     */
    public function loadJSCoreLevelPlugins()
    {
        if(count($this->js_core_level_plugins)==0){return FALSE;}
        foreach($this->js_core_level_plugins as $js){echo $js;}
        return;
    }
    /**
     * JS Page Level Plugins
     */
    public function loadJSPageLevelPlugins()
    {
        if(count($this->js_page_level_plugins)==0){return FALSE;}
        foreach($this->js_page_level_plugins as $js){echo $js;}
        return;
    }
    /**
     * JS Page Level Scripts
     */
    public function loadJSPageLevelScripts()
    {
        if(count($this->js_page_level_scripts)==0){return FALSE;}
        foreach($this->js_page_level_scripts as $js){echo $js;}
        return;
    }
    /*------------ END JAVASCRIPT LOADERS ------------*/
    
    /**
     * JS Init Scripts
     */
    public function initializeScripts()
    {
        if(count($this->initscripts)==0){return FALSE;}
        foreach($this->initscripts as $init){echo $init;}
        return;
    }
    
    /*BEGIN DEFAULT JSCSS*/    
    /**
     * Default Javascripts and Stylesheets
     */
    public function loadDefaultCSS()
    {
        /*global mandatory styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_PLUGINS."font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".GLOBAL_PLUGINS."simple-line-icons/simple-line-icons.min.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".GLOBAL_PLUGINS."bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".GLOBAL_PLUGINS."uniform/css/uniform.default.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".GLOBAL_PLUGINS."font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".GLOBAL_PLUGINS."bootstrap-switch/css/bootstrap-switch.min.css' rel='stylesheet' type='text/css'>")
        );
        foreach($styles1 as $style) { !in_array($style, $this->css_global_mandatory_styles) ? array_push($this->css_global_mandatory_styles,$style) : NULL; }
        
        /*theme styles*/
        $styles2 = array(
            trim("<link href='".GLOBAL_ASSETS."css/components.css' id='style_components' rel='stylesheet' type='text/css'>"),
            trim("<link href='".GLOBAL_ASSETS."css/plugins.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".ADMIN_THEME."css/layout.css' rel='stylesheet' type='text/css'>"),
            trim("<link id='style_color' href='".ADMIN_THEME."css/themes/default.css' rel='stylesheet' type='text/css'>"),
            trim("<link href='".ADMIN_THEME."css/custom.css' rel='stylesheet' type='text/css'>")
        );
        foreach($styles2 as $style) { !in_array($style, $this->css_theme_styles) ? array_push($this->css_theme_styles,$style) : NULL; }
        
    }
    public function loadDefaultJS()
    {
        $js1 = array(
          trim("<script src='".GLOBAL_ASSETS."plugins/jquery.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/jquery-migrate.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/jquery-ui/jquery-ui.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/bootstrap/js/bootstrap.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/jquery-slimscroll/jquery.slimscroll.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/jquery.blockui.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/jquery.cokie.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/uniform/jquery.uniform.min.js' type='text/javascript'></script>"),  
          trim("<script src='".GLOBAL_ASSETS."plugins/bootstrap-switch/js/bootstrap-switch.min.js' type='text/javascript'></script>")  
        );
        foreach($js1 as $js) { !array_search($js, $this->js_core_level_plugins) ? array_push($this->js_core_level_plugins, $js) : NULL; }
        /*page level scripts */
        $js2 = array(
          trim("<script type='text/javascript' src='".GLOBAL_ASSETS."scripts/metronic.js'></script>"),  
          trim("<script type='text/javascript' src='".ADMIN_THEME."scripts/layout.js'></script>"),  
          trim("<script type='text/javascript' src='".ADMIN_THEME."scripts/demo.js'></script>"),  
        );
        foreach($js2 as $js) { !array_search($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts, $js) : NULL; }
        
        /*init scripts*/
        $init1 = array(
            trim("Metronic.init();"),
            trim("Layout.init();"),
            trim("Demo.init();")
        );
        foreach($init1 as $init) { !array_search($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END DEFAULT JSCSS*/
    public function loadCustomJSCSS()
    {
        $styles1 = array(trim("<link href='".CUSTOM_ASSETS."css/custom.css' rel='stylesheet' type='text/css'>"));
        foreach($styles1 as $style) { !in_array($style, $this->css_custom_styles) ? array_push($this->css_custom_styles,$style) : NULL; }
    }
    /*BEGIN LOGIN*/
    /**
     * Login
     */
    public function loadLogin()
    {
        /*page level style*/
        $styles1 = array(
            trim("<link href='".ADMIN_ASSETS."pages/css/login.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        
        /*page level script*/
        $js1 = array(
            trim("<script type='text/javascript' src='".ADMIN_ASSETS."pages/scripts/login.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        
        /*init script*/
        $init1 = array("Login.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END LOGIN*/
    
    /*BEGIN DATA TABLES*/
    /**
     * Managed Data Tables
     */
    public function loadManagedDataTables()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/select2/select2.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/select2/select2.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/media/js/jquery.dataTables.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js'></script>"),
        );
        foreach($js1 as $js) { !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins, $js) : NULL; }
        
        /*page level scripts*/
        $js2 = array(
          trim("<script type='text/javascript' src='".ADMIN_ASSETS."pages/scripts/table-managed.js'></script>")  
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        
        /*init script*/
        $init1 = array("TableManaged.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /**
     * Advanced Data Tables
     */
    public function loadAdvancedDataTables()
    {
        /*page level styles*/
        $styles1 = array(
          trim("<link href='".GLOBAL_ASSETS."plugins/select2/select2.css' rel='stylesheet' type='text/css' />"),  
          trim("<link href='".GLOBAL_ASSETS."plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css' rel='stylesheet' type='text/css' />"),  
          trim("<link href='".GLOBAL_ASSETS."plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css' rel='stylesheet' type='text/css' />"),  
          trim("<link href='".GLOBAL_ASSETS."plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />")  
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/select2/select2.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/media/js/jquery.dataTables.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js'></script>")
        );
        foreach($js1 as $js) { !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins, $js) : NULL; }
        
        $js2 = array(
            trim("<script type='text/javascript' src='".ADMIN_ASSETS."pages/scripts/table-advanced.js'></script>")
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        
        /*init script*/
        $init1 = array("TableAdvanced.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END DATA TABLES*/
    /*BEGIN COMPONENT DROPDOWNS*/
    public function loadComponentsDropdowns()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-select/bootstrap-select.min.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/select2/select2.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/jquery-multi-select/css/multi-select.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-select/bootstrap-select.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/select2/select2.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/jquery-multi-select/js/jquery.multi-select.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins,$js) : NULL;}
        /*page level scripts*/
        $js2 = array(
            trim("<script type='text/javascript' src='".ADMIN_ASSETS."pages/scripts/components-dropdowns.js'></script>")
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        /*init script*/
        $init1 = array("ComponentsDropdowns.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END COMPONENT DROPDOWNS*/
    
    /*BEGIN CUSTOM DROPDOWNS*/
    public function loadCustomDropdowns()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-select/bootstrap-select.min.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/select2/select2.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/jquery-multi-select/css/multi-select.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-select/bootstrap-select.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/select2/select2.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/jquery-multi-select/js/jquery.multi-select.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins,$js) : NULL;}
        /*page level scripts*/
        $js2 = array(
            trim("<script type='text/javascript' src='".CUSTOM_ASSETS."scripts/custom-dropdowns.js'></script>")
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        /*init script*/
        $init1 = array("CustomDropdowns.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END CUSTOM DROPDOWNS*/
    /*BEGIN LOCATION DROPDOWNS*/
    public function loadLocationDropdowns()
    {
        /*page level scripts*/
        $js1 = array(
            trim("<script type='text/javascript' src='".CUSTOM_ASSETS."scripts/location-dropdowns.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        /*init script*/
        $init1 = array("LocationDropdowns.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END LOCATION DROPDOWNS*/
    /*BEGIN COMPONENT PICKERS*/
    public function loadComponentPickers()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/clockface/css/clockface.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-datepicker/css/datepicker3.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-colorpicker/css/colorpicker.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-daterangepicker/daterangepicker-bs3.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/clockface/js/clockface.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-daterangepicker/moment.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-daterangepicker/daterangepicker.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins,$js) : NULL;}
        /*page level scripts*/
        $js2 = array(
            trim("<script type='text/javascript' src='".ADMIN_ASSETS."pages/scripts/components-pickers.js'></script>")
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        /*init scripts*/
        $init1 = array(
            trim("ComponentsPickers.init();")
        );
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END COMPONENT PICKERS*/
    
    /*BEGIN TOASTR NOTIFICATION*/
    public function loadToastrNotification()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-toastr/toastr.min.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-toastr/toastr.min.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins,$js) : NULL;}
        /*page level scripts*/
        $js2 = array(
            trim("<script type='text/javascript' src='".ADMIN_ASSETS."pages/scripts/ui-toastr.js'></script>")
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        /*init script*/
        $init1 = array("UIToastr.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END LOCATION DROPDOWNS*/
    
    public function loadiCheck()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/icheck/skins/all.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/icheck/icheck.min.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins,$js) : NULL;}
    }
    
    /*BEGIN BUSINESS FUNCTIONS*/
    public function loadBusinessFunctions()
    {
        /*page level styles*/
        $styles1 = array(
            trim("<link href='".GLOBAL_ASSETS."plugins/bootstrap-select/bootstrap-select.min.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/select2/select2.css' rel='stylesheet' type='text/css' />"),
            trim("<link href='".GLOBAL_ASSETS."plugins/jquery-multi-select/css/multi-select.css' rel='stylesheet' type='text/css' />")
        );
        foreach($styles1 as $style){ !in_array($style, $this->css_page_level_styles) ?  array_push($this->css_page_level_styles, $style) : NULL; }
        /*page level plugins*/
        $js1 = array(
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/bootstrap-select/bootstrap-select.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/select2/select2.min.js'></script>"),
            trim("<script type='text/javascript' src='".GLOBAL_ASSETS."plugins/jquery-multi-select/js/jquery.multi-select.js'></script>")
        );
        foreach($js1 as $js){ !in_array($js, $this->js_page_level_plugins) ? array_push($this->js_page_level_plugins,$js) : NULL;}
        /*page level scripts*/
        $js2 = array(
            trim("<script type='text/javascript' src='".CUSTOM_ASSETS."scripts/business-functions.js'></script>")
        );
        foreach($js2 as $js){ !in_array($js, $this->js_page_level_scripts) ? array_push($this->js_page_level_scripts,$js) : NULL;}
        /*init script*/
        $init1 = array("BusinessFunctions.init();");
        foreach($init1 as $init){ !in_array($init, $this->initscripts) ? array_push($this->initscripts, $init) : NULL; }
    }
    /*END CUSTOM DROPDOWNS*/
}
