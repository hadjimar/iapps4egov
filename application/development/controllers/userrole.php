<?php

/**
 * Add, Edit, Delete User Menu.
 * @package Userrole Controller
 * @author RedCrisostomo
 */
Class Userrole extends MY_Controller
{
   
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist','name'=>'userrole'));
        $this->load->model('userrole_model');
    }
    public function index()
    {
        $this->setModel('userrole_model');
        $input_data = $this->input->post('data') ? $this->input->post('data') : array();
        
        
        switch($this->var['action'])
        {
            case 'add':
                loadComponentsDropdowns();
                $input_data['Active'] = 1;
                $this->form_validation->set_rules('data[UserRoleName]','Name', 'trim|required|is_unique[user_role.UserRoleName]');
                if($this->form_validation->run()==TRUE)
                {
                    /*set the method to add user role*/
                    $this->setMethod('addUserrole');
                    /*if adding user role is successfull*/
                    if($this->executeMethod(array('type'=>'add','input'=>$input_data)))
                    {
                        /*set new container for user access input data*/
                        $data = array();
                        /*loop through each selected pages*/
                        foreach($input_data['Page'] as $page)
                        {
                            /*set the input data*/
                            $data[]= array(
                                'UserRoleID' => $this->$model->last_id, /*set the id as the last inserted id*/
                                'Page' => $page
                            );
                        }
                        /*set the method to add user role access*/
                        $this->setMethod('addAccess');
                        /*execute the method to add user role access */
                        $this->executeMethod(array('type'=>'add','input'=>$data));
                    }
                }
                 
                break;
            case 'edit':
                loadComponentsDropdowns();
                /*get specific user role data*/
                $this->setMethod('getUserRole');
                $this->setIndex('userrole_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*get page access*/
                $this->setMethod('getPageAccess');
                $this->setIndex('pages');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                foreach($this->var['pages'] as $row)
                {
                    $this->var['pageaccess_list'][] = $row['Page'];
                }
                $this->setMethod('updateUserrole');
                $this->form_validation->set_rules('data[UserRoleName]','Name', 'trim|required');
                if($this->form_validation->run()==TRUE)
                {
//                    $this->var['data'] = $input_data;
                    /*set the method to add user role*/
                    $this->setMethod('updateUserrole');
                    if($this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)))
                    {
                        /*remove the access*/
                        $this->setMethod('deleteAccess');
                        $this->executeMethod(array('type'=>'update'));
                        
                        /*set new container for user access input data*/
                        $data = array();
                        /*loop through each selected pages*/
                        foreach($input_data['Page'] as $page)
                        {
                            /*set the input data*/
                            $data[]= array(
                                'UserRoleID' => $this->var['id'], /*set the id as the last inserted id*/
                                'Page' => $page
                            );
                        }
                        /*set the method to add user role access*/
                        $this->setMethod('addAccess');
//                        $this->var['data'] = $this->$model->input_data;
                        /*execute the method to add user role access */
                        $this->executeMethod(array('type'=>'add','input'=>$data));
                    }
                }
                break;
            default:
                loadAdvancedDataTables();
                $this->setMethod('getUserrole');
                $this->setIndex('userrole_list');
                $this->executeMethod(array('type'=>'get'));
        }
        $this->viewPage();
    }
    
}