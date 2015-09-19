<?php

/**
 * Description of user_model
 *
 * @author RedCrisostomo
 */
Class User_Model extends CI_Model
{
    public $crud;
    public $person;
    public $table = "user";
    public $id = 0;
    public $user = null;
    public $code = null;
    public $password = null;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public function __construct() 
    {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->model('person_model');
        $this->crud = new Crud();
        $this->person = new Person_Model();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
    }
    
    public function getUser($active=FALSE)
    {
        $where = '';
        if(strlen($this->user && $this->password))
        {
            $where .= "WHERE (a.`Username` = '$this->user' AND a.`Password` = '$this->password') OR (a.`UserEmail` = '$this->user' AND a.`Password` = '$this->password')";
        }
        if($this->id>0)
        {
            $where .= "WHERE a.`UserID` = '$this->id'";
        }
        if($active==TRUE)
        {
            if(strlen($where)>0)
            {
                $where .= " AND a.`Active` = '$active'";
            }
            else
            {
                $where .= "WHERE a.`Active` = '$active'";
            }
        }
        $this->crud->query = "SELECT a.`UserID`, a.`Username`, a.`UserEmail`, a.`ProfilePicture`, a.`Salt`, a.`EncryptionKey`, a.`Active`, a.`DateLastLogin`, b.`PersonID`,b.`FirstName`,b.`MiddleName`,b.`LastName`, b.`ExtensionName`, c.`UserRoleID`, c.`UserRoleName`  FROM `user` a INNER JOIN `person` b ON a.`PersonID`=b.`PersonID` INNER JOIN `user_role` c ON a.`UserRoleID` = c.`UserRoleID` $where ORDER BY c.`UserRoleID` ASC, b.`LastName` ASC, b.`FirstName` ASC, b.`MiddleName` ASC;";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addUser()
    {
        $this->setInputData($this->input_data);
        $this->crud->input_data = $this->input_data;
        $this->crud->table = $this->table;
        if($this->crud->create())
        {
           return TRUE;
        }
        return FALSE;
    }
    
    public function updateUser()
    {
        /*Update User data*/
        if($this->id==0){return FALSE;}
        $this->setInputData($this->input_data);
        $this->crud->input_data = $this->input_data;
        $this->crud->where['UserID'] = $this->id;
        $this->crud->table = $this->table;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function setLastLogin()
    {
        if($this->id==0){return FALSE;}
        $now = date('Y-m-d H:i:s');
        $this->crud->where['UserID'] = $this->id;
        $this->crud->input_data = array('DateLastLogin'=>$now);
        $this->crud->table = $this->table;
        $this->crud->update();
        return;
    }
    public function setInputData($input_data)
    {
       $fields = $this->db->list_fields($this->table);
        foreach($fields as $field)
        {
            if(array_key_exists($field, $input_data))
            {
                if(strlen($input_data[$field])==0)
                {
                    $result[$field] = NULL;
                }
                else
                {
                    $result[$field] = $input_data[$field];
                }
            }
        }
        unset($result['UserID']);
        $this->_clearInputData();
        $this->input_data = $result;
        return;
    }
}
