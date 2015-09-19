<?php

/**
 * Description of userrole_model
 *
 * @author RedCrisostomo
 */
Class Userrole_Model extends CI_Model
{
    public $crud;
    public $table = 'user_role';
    public $id = 0;
    public $last_id = 0;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
    }
    
    public function getUserrole($active=FALSE)
    {
        $where = '';
        if($this->id>1)
        {
            $where .= "WHERE a.`UserRoleID` = '$this->id'";
        }
        if($this->where)
        {
            $where = "WHERE ".$this->where;
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
        
        $this->crud->query = "SELECT a.*,GROUP_CONCAT(b.`Page` SEPARATOR ', ') AS 'Page' FROM `user_role` a LEFT JOIN `user_role_access` b ON a.`UserRoleID` = b.`UserRoleID` $where GROUP BY `UserRoleID` HAVING `UserRoleID` > 1 ORDER BY a.`UserRoleID` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
        return;
    }
    
    public function getPageAccess()
    {
        if(!$this->id>1){return FALSE;}
        $this->crud->table = 'user_role_access';
        $this->crud->where['UserRoleID'] = $this->id;
        $this->crud->read();
        $this->list = $this->crud->result_data;
        return;
    }
    public function addUserrole()
    {
        $this->crud->table = $this->table;
        $this->setInputData($this->input_data);
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            $this->last_id = $this->crud->last_id;
            return TRUE;
        }
        return FALSE;
    }
    
    public function addAccess()
    {
        $this->crud->input_data = $this->input_data;
        $this->crud->table = 'user_role_access';
        if($this->crud->createBatch())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateUserrole()
    {
        if($this->id==0){return FALSE;}
        $this->crud->where['UserRoleID'] = $this->id;
        $this->setInputData($this->input_data);
        $this->crud->input_data = $this->input_data;
        $this->crud->table = $this->table;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function deleteAccess()
    {
        if($this->id==0){return FALSE;}
        if($this->db->query("DELETE FROM `user_role_access` WHERE `UserRoleID` = '$this->id'"))
        {
            return TRUE;
        }
        return FALSE;
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
        unset($result['UserRoleID']);
        $this->_clearInputData();
        $this->input_data = $result;
        return;
    }
    
    private function _clearInputData() 
    {
        $this->input_data = array();
    }
}
