<?php

/**
 * Add, Edit, Delete User.
 * @package User Controller
 * @author RedCrisostomo
 */
Class User extends MY_Controller
{
   
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist','name'=>'user'));
        $this->load->model('user_model');
        $this->load->model('userrole_model');
        
        
    }
    public function index()
    {
        switch($this->var['action'])
        {
            case 'add':
                loadCustomDropdowns();
                $this->setModel('userrole_model');
                $this->setMethod('getUserrole');
                $this->setIndex('userrole_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                if($this->input->post('data'))
                {
                    $this->form_validation->set_rules('data[FirstName]', 'FirstName', 'trim|required');
                    $this->form_validation->set_rules('data[Username]', 'Username', 'trim|required|min_length[4]|xss_clean');
                    $this->form_validation->set_rules('data[UserRoleID]', 'User Role', 'trim|required');
                    $this->form_validation->set_rules('data[Password]', 'Password', 'trim|required|matches[ConfirmPassword]');
                    $this->form_validation->set_rules('ConfirmPassword', 'Password Confirmation', 'trim|required');
                    $this->form_validation->set_rules('data[UserEmail]', 'Email', 'trim|valid_email');
                    $input_data = $this->input->post('data');
                    $encryption = crypt($this->config->item('encryption_key'));
                    $input_data['EncryptionKey'] = $encryption;
                    $input_data['Salt'] = crypt($input_data['Password'],$encryption);
                    $input_data['Password'] = isset($input_data['Password']) ?  md5($input_data['Password']) : NULL;
                    $this->setMethod('addUser');
                    $this->form_validation->run()==TRUE ? $this->var['data'] = json_encode($input_data)/*$this->executeMethod(array('type'=>'add','input'=>$input_data))*/ : NULL;
                }
                break;
            case 'edit':
                loadCustomDropdowns();
                $this->setModel('user_model');
                $this->setMethod('getUser');
                $this->setIndex('user_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                if($this->input->post('data'))
                {
                    $this->form_validation->set_rules('data[PersonID]', 'Name', 'trim|required');
                    $this->form_validation->set_rules('data[Username]', 'Username', 'trim|required|min_length[4]|xss_clean');
                    $this->form_validation->set_rules('data[UserRoleID]', 'User Role', 'trim|required');
                    $this->form_validation->set_rules('data[Password]', 'Password', 'trim|matches[ConfirmPassword]');
                    $this->form_validation->set_rules('ConfirmPassword', 'Password Confirmation', 'trim|required');
                    $this->form_validation->set_rules('data[UserEmail]', 'Email', 'trim|valid_email');
                    $input_data = $this->input->post('data');
                    $input_data['Password'] = isset($input_data['Password']) ?  md5($input_data['Password']) : NULL;
                    $this->setMethod('updateUser');
                    $this->form_validation->run()==TRUE ? /*$this->executeMethod(array('type'=>'update','input'=>$input_data))*/ : NULL;
                }
                break;
            default:
                loadAdvancedDataTables();
                $this->setModel('user_model');
                $this->setMethod('getUser');
                $this->setIndex('user_list');
                $this->executeMethod(array('type'=>'get'));
        }
        $this->viewPage();
    }
    
    
}
