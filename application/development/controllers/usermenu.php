<?php

/**
 * Add, Edit, Delete User Menu.
 * @package Usermenu Controller
 * @author RedCrisostomo
 */
Class Usermenu extends MY_Controller
{
   
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist','name'=>'usermenu'));
    }
    public function index()
    {
        $this->setModel('usermenu_model');
        $input_data = $this->input->post('data') ? $this->input->post('data') : array();
        
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when edit button is clicked */
                loadComponentsDropdowns();
                loadiCheck();
                $this->setMethod('getUsermenu');
                $this->setIndex('usermenu_list');
                $this->executeMethod(array('type'=>'get','active'=>true));
                /*End process when edit button is clicked */
                /*Begin process when submit button is clicked */
                $this->setMethod('addUsermenu');
                $this->form_validation->set_rules('data[MenuName]','This', 'trim|required|is_unique[user_menu.MenuName]');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked */
                break;
            case 'edit':
                /*Begin process when edit button is clicked */
                loadComponentsDropdowns();
                loadiCheck();
                /*get specific user menu*/
                $this->setMethod('getUsermenuByID');
                $this->setIndex('menu_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*get all menus for parent menu dropdown selection*/
                $this->setMethod('getUsermenu');
                $this->setIndex('usermenu_list');
                $this->executeMethod(array('type'=>'get','active'=>true));
                /*End process when edit button is clicked */
                /*Begin process when submit button is clicked*/
                $this->setMethod('updateUsermenu');
                $this->form_validation->set_rules('data[MenuName]','This', 'trim|required');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                /*End Process when submit button is clicked*/
                break;
            default:
                loadAdvancedDataTables();
                $this->setMethod('getUsermenu');
                $this->setIndex('usermenu_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
}