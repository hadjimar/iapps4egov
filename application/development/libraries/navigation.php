<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * HTML Navigation Generating Class
 *
 * Lets you create navigation links.
 * 
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @category	HTML Navigation
 * @author	RedCrisostomo
 */
class Navigation 
{
    public $navigation_data	= array();
    private $_child_data          = array();
    public $template		= array();
    public $child_template      = array();
    public $position            = NULL;
    private $_template_vars      = array('nav_open','nav_close','ul_open','ul_close','li_open','li_close','a_open','a_close');
    private $_child_template_vars = array('ul_open','ul_close','li_open','li_close','a_open','a_close');
    
    /**
    * Build the table
    *
    * @access	public
    * @return	string
    */
    public function generate($settings = array())
    {
        /*Validate the navigation data*/
        if(!is_array($this->navigation_data) OR count($this->navigation_data) == 0)
        {
            return 'Undefined Navigation Data';  /*If not array or is empty send a message*/
            exit();  /*Stop the execution*/
        }
        /*Compile the template*/
        $this->_compile_template();
        $output = "";
        $nav_open = $this->template['nav_open'];
        $nav_class = isset($settings['nav_class']) ? $settings['nav_class'] : "navbar navbar-default";             
        $ul_open = $this->template['ul_open'];
        $ul_class = "nav";
        
        
        $this->position = isset($settings['position']) ? $settings['position'] : "top";
        $nav_type = isset($settings['type']) ? $settings['type'] : "";
        $nav_alignment = isset($settings['alignment']) ? $settings['alignment'] : "";
        
        if($this->position == 'top')
        {
            $ul_class .= " navbar-nav";
        }
        elseif($this->position=='sidebar')
        {
            $ul_class .= " nav-stacked";
        }
        if($nav_type == 'tab')
        {
            $ul_class .= " nav-tabs";
        }
        elseif($nav_type == 'pill')
        {
            $ul_class .= " nav-pills";
        }
        $nav_open = str_replace("<nav", "<nav class=\"$nav_class\"", $nav_open);
        $ul_open = str_replace("<ul>", "<ul class=\"$ul_class\">", $ul_open);
        
        $output .= $nav_open;
        $output .= $ul_open;
        foreach($this->navigation_data as $navigation)
        {
            $li_open = $this->template['li_open'];
            $a_open = $this->template['a_open'];
            $li_class = "";
            $a_class = "";
            $a_label = isset($navigation['label']) ? $navigation['label'] : "";
            $a_href = "href='";
            $a_href .= isset($navigation['href']) ? $navigation['href'] : "javascript:;";
            $a_href .= "'";
            $a_data_toggle = "";
            $a_data_target = "";
            $a_role = "";
            if(isset($navigation['sub_menu']))
            {
                if($this->position=='top')
                {  
                    $li_class .="class='dropdown'";
                    $a_class .="class='dropdown-toggle'";
                    $a_data_toggle = "data-toggle='dropdown'";
                    $a_role= "role='button'";
                }
                $this->_child_data = $navigation['sub_menu'];
            }
            
            $li_open = str_replace("<li", "<li $li_class", $li_open);
            $a_open = str_replace("<a>","<a $a_href $a_class $a_data_toggle $a_data_target $a_role>",$a_open);
            $output .= $li_open;
            $output .= $a_open;
            $output .= $a_label;
            $output .= $this->template['a_close'];
            $output.= $this->_generateChild();
            $output .= $this->template['li_close'];
        }
        
        $output .= $this->template['ul_close'];
        $output .= $this->template['nav_close'];
        /* Clear navigation properties before generating the navigation */
        $this->clear();
        
        return $output;
    }
    
    private function _generateChild()
    {
        if(!isset($this->_child_data) OR count($this->_child_data)==0)
        {
            return "";
        }
        /*Compile the child template*/
        $this->_compile_child_template();
        $output = "";
        $ul_open = $this->child_template['ul_open'];
        $ul_class = $this->position=='top' ? "dropdown-menu" : "nav nav-stacked";
        $ul_open = str_replace("<ul", "<ul class=\"$ul_class\"", $ul_open);
        $output .= $ul_open;
        foreach($this->_child_data as $child)
        {
            $li_open = $this->child_template['li_open'];
            $a_open = $this->child_template['a_open'];
            $li_class = "";
            $a_class = "";
            if($this->position=='top')
            {
                $a_label = isset($child['label']) ? $child['label'] : "";
            }
            elseif($this->position=='sidebar')
            {
                $a_label = "<i class='glyphicon glyphicon-chevron-right'></i> ";
                $a_label .= isset($child['label']) ? $child['label'] : "";
            }
            $a_href = "href='";
            $a_href .= isset($child['href']) ? $child['href'] : "javascript:;";
            $a_href .= "'";
            $a_data_toggle = "";
            $a_data_target = "";
            $a_role = "";
            $child_data="";
            if(isset($child['sub_menu']))
            {
                if($this->position=='top')
                {
                    $li_class .="class='dropdown'";
                    $a_class .="class='dropdown-toggle'";
                    $a_data_toggle = "data-toggle='dropdown'";
                    $a_role= "role='button'";
                    
                }
               
                $this->_child_data = $child['sub_menu'];
                $child_data = $this->_generateChild();
            }
            
            $li_open = str_replace("<li", "<li $li_class", $li_open);
            $a_open = str_replace("<a>","<a $a_href $a_class $a_data_toggle $a_data_target $a_role>",$a_open);
            $output .= $li_open;
            $output .= $a_open;
            $output .= $a_label;
            $output .= $this->child_template['a_close'];
            $output .= $child_data;
            $output .= $this->child_template['li_close'];
        }
        $output .= $this->child_template['ul_close'];
        $this->_clearChild();
        return $output;
    }
    
    /**
     * Clear the table properties
     * @access public
     * @return void
     */
    public function clear()
    {
        $this->navigation_data = array();
    }
    private function _clearChild()
    {
        $this->_child_data = array();
    }
    /**
     * Compile the template
     * @access private
     * @return voide
     */
    private function _compile_template()
    {
        if(!is_array($this->template) OR count($this->template) == 0)
        {
            $this->template = $this->_default_template();
            return;
        }
        $temp = $this->_default_template();
        foreach($this->_template_vars as $value)
        {
            if(!isset($this->template[$value])) /*if some table properties are not specified*/
            {
                $this->template[$value] = $temp[$value]; /*set the unspecified properties to the default template*/
            }
        }
    }
    /**
     * Compile the child template
     * @access private
     * @return void
     */
    private function _compile_child_template()
    {
        if(!is_array($this->child_template) OR count($this->child_template) == 0)
        {
            $this->child_template = $this->_default_child_template();
            return;
        }
        $child_temp = $this->_default_child_template();
        foreach($this->_child_template_vars as $value)
        {
            if(!isset($this->child_template[$value])) /*if some table properties are not specified*/
            {
                $this->child_template[$value] = $child_temp[$value]; /*set the unspecified properties to the default template*/
            }
        }
    }
    /**
     * Set the default template
     * @access private
     * @return array
     */
    private function _default_template()
    {
        
        return  array (
                        'nav_open'  =>  '<nav role="navigation">',
                        'nav_close' =>  '</nav>',
                        'ul_open'   =>  '<ul>',
                        'ul_close'  =>  '</ul>',
                        'li_open'   =>  '<li role="presentation">',
                        'li_close'  =>  '</li>',
                        'a_open'    =>  '<a>',
                        'a_close'   =>  '</a>'
                    );
    }
    
    private function _default_child_template()
    {
        return array(
                        'ul_open' => '<ul role="menu">',
                        'ul_close' => '</ul>',
                        'li_open' => '<li role="presentation">',
                        'li_close' => '</li>',
                        'a_open' => '<a>',
                        'a_close' => '</a>'
        );
    }
    
}