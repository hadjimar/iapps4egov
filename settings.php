<?php
/**
 * 
 */

Class Settings
{
        
    public function initialize()
    {
        /*Define host*/
        $host = $_SERVER['HTTP_HOST'];
        /*Set protocol*/
        $root = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        /*Set host*/
        $root .= $host;
        /*Set server name*/
        /* $_SERVER['SCRIPT_NAME'] is /subdirs/index.php, basename($_SERVER['SCRIPT_NAME'] is index.php -> replace to get subdirs and append to root */
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);
        $hostname = $root;
        
        /*defiine site name*/
        define('BASE_URL', $hostname);

        /*define the environment*/
        if($host=='localhost' OR $host=='127.0.0.1' OR $host=='dev.iapps4egov.com')
        {
            define('ENVIRONMENT','development');
        }
        elseif($host=="test.iapps4egov.com")
        {
            define('ENVIRONMENT','testing');
        }
        else
        {
            define('ENVIRONMENT','production');
        }
        /** 
        * ---------------------------------------------------------------
        * GLOBAL ASSETS
        * File Location: assets/global/
        * @const  folder location of global assets
        * ---------------------------------------------------------------
        */
       define('GLOBAL_ASSETS', BASE_URL.'assets/global/');

       /** 
        * ---------------------------------------------------------------
        * GLOBAL PLUGINS
        * File Location: assets/global/plugins/
        * @const  folder location of global plugins
        * ---------------------------------------------------------------
        */
       define('GLOBAL_PLUGINS',GLOBAL_ASSETS.'plugins/');

       /** 
        * ---------------------------------------------------------------
        * GLOBAL CSS
        * File Location: assets/global/css/
        * @const  folder location of global css
        * ---------------------------------------------------------------
        */
       define('GLOBAL_CSS',GLOBAL_ASSETS.'css/');

       /** 
        * ---------------------------------------------------------------
        * ADMIN ASSETS
        * File Location: assets/admin/
        * @const  folder location of admin assets
        * ---------------------------------------------------------------
        */
       define('ADMIN_ASSETS',BASE_URL.'assets/admin/');

       /** 
         * Admin Theme
        * assets/global/[name of admin theme]
        * @const  folder location of the admin theme
        * @see $config['admin_theme'] in config file
        */
       define('ADMIN_THEME',ADMIN_ASSETS.'layout2/');
       
       /**
        * ---------------------------------------------------------------
        * CUSTOM ASSETS
        * File Location: assets/custom/[ENVIRONMENT]
        * @cons folder location of custom assets
        * ---------------------------------------------------------------
        */
           define('CUSTOM_ASSETS',BASE_URL.'assets/custom/'.ENVIRONMENT.'/');

       /** 
        * ---------------------------------------------------------------
        * CUSTOM CSS
        * File Location: assets/custom/[ENVIRONMENT]/css/
        * @cons folder location of custom css
        * ---------------------------------------------------------------
        */
       define('CUSTOM_CSS',CUSTOM_ASSETS.'css/custom.css');

        return;
    }
}
