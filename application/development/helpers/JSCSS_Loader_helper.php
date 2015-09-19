<?php

/**
 * Helper to execute the methods for loading javascripts and stylesheets
 * @package JSCSS_Loader_helper
 * @author red
 * @see library/JSCSS_Loader.php
 */

if(!function_exists('loadCSSGlobalMandatoryStyles'))
{ 
    /**
     * Global Mandatory Styles
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadCSSGlobalMandatoryStyles()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadCSSGlobalMandatoryStyles();
    }
}

if(!function_exists('loadCSSPageLevelStyles'))
{ 
    /**
     * Page Level Styles
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadCSSPageLevelStyles()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadCSSPageLevelStyles();
    }
}

if(!function_exists('loadCSSThemeStyles'))
{ 
    /**
     * Theme Styles
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadCSSThemeStyles()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadCSSThemeStyles();
    }
}

if(!function_exists('loadCSSCustomStyles'))
{ 
    /**
     * Custom Styles
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadCSSCustomStyles()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadCSSCustomStyles();
    }
}

if(!function_exists('loadJSCoreLevelPlugins'))
{ 
    /**
     * Core Level Plugins
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadJSCoreLevelPlugins()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadJSCoreLevelPlugins();
    }
}

if(!function_exists('loadJSPageLevelPlugins'))
{ 
    /**
     * Page Level Plugins
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadJSPageLevelPlugins()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadJSPageLevelPlugins();
    }
}

if(!function_exists('loadJSPageLevelScripts'))
{ 
    /**
     * Page Level Scripts
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadJSPageLevelScripts()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadJSPageLevelScripts();
    }
}

if(!function_exists('initializeScripts'))
{ 
    /**
     * Init Script
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function initializeScripts()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->initializeScripts();
    }
}

/* Default CSS */
if(!function_exists('loadDefaultCSS'))
{ 
    /**
     * Default CSS
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadDefaultCSS()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadDefaultCSS();
    }
}
/* Default JS */
if(!function_exists('loadDefaultJS'))
{ 
    /**
     * Default JS
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadDefaultJS()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadDefaultJS();
    }
}
/* Custom JSCSS */
if(!function_exists('loadCustomJSCSS()'))
{ 
    /**
     * Custom JSCSS
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadCustomJSCSS()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadCustomJSCSS();
    }
}

if(!function_exists('loadLogin'))
{
    /**
     * Login
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadLogin()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadLogin();
    }
}

if(!function_exists('loadManagedDataTables'))
{ 
    /**
     * Managed Datatables
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadManagedDataTables()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadManagedDataTables();
    }
}

if(!function_exists('loadAdvancedDataTables'))
{ 
    /**
     * Advanced Data Tables
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadAdvancedDataTables()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadAdvancedDataTables();
    }
}

if(!function_exists('loadComponentsDropdowns'))
{
    /**
     * Components Dropdowns
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadComponentsDropdowns()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadComponentsDropdowns();
    }
}

if(!function_exists('loadCustomDropdowns'))
{
    /**
     * Custom Dropdowns
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadCustomDropdowns()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadCustomDropdowns();
    }
}
if(!function_exists('loadLocationDropdowns'))
{
    /**
     * Location Dropdowns
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadLocationDropdowns()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadLocationDropdowns();
    }
}

if(!function_exists('loadComponentPickers'))
{
    /**
     * Component Pickers
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadComponentPickers()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadComponentPickers();
    }
}
if(!function_exists('loadToastrNotification'))
{
    /**
     * Toastr Notification
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadToastrNotification()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadToastrNotification();
    }
}
if(!function_exists('loadiCheck'))
{
    /**
     * iCheck
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadiCheck()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadiCheck();
    }
}
if(!function_exists('loadBusinessFunctions'))
{
    /**
     * iCheck
     * @return method
     * @see library/JSCSS_Loader.php
     */
    function loadBusinessFunctions()
    {
        $ci = &get_instance();
        return $ci->jscss_loader->loadBusinessFunctions();
    }
}
