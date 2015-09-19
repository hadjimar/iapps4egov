<?php

/**
 * Description of business_requirement_model
 *
 * @author RedCrisostomo
 */
Class Business_Requirement_Model extends CI_Model
{
    public $crud;
    public $id = NULL;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public $table = "business_requirement";
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
    }
    
    public function getBusinessRequirement($active=FALSE)
    {
        $where = '';
        if($this->id>0)
        {
            $where .= "WHERE a.`TransactionType` = '$this->id'";
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
        $this->crud->query = "SELECT a.`TransactionType`,a.`Active`,GROUP_CONCAT(a.`RequirementID` SEPARATOR ',') AS `RequirementID`, GROUP_CONCAT(b.`RequirementName` SEPARATOR ', ') AS RequirementName FROM $this->table a JOIN `requirement` b ON a.`RequirementID` = b.`RequirementID` $where GROUP BY a.`TransactionType` ORDER BY a.`TransactionType` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addBusinessRequirement()
    {
        /*delete previous record, if any*/
        $this->id = $this->input_data[0]['TransactionType'];
        $this->db->query("DELETE FROM $this->table WHERE `TransactionType` = '$this->id'");
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        $this->deleteBusinessRequirement();
        /*add new record*/
        $this->crud->table = $this->table;
        $this->crud->input_data = $this->input_data;
        if($this->crud->createBatch())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateBusinessRequirement()
    {
//        echo "<script>alert('".$this->id."')</script>";
        if(strlen($this->id)==0){return FALSE;}
        $this->db->query("DELETE FROM $this->table WHERE `TransactionType` = '$this->id'");
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        /*delete previous record*/
        $this->deleteBusinessRequirement();
        /*add new record*/
        $this->crud->table = $this->table;
        $this->crud->input_data = $this->input_data;
        if($this->crud->createBatch())
        {
            return TRUE;
        }
        return FALSE;
        return TRUE;
    }
    
    public function deleteBusinessRequirement()
    {   
        if($this->id==0){return FALSE;}
        $this->db->query("DELETE FROM $this->table WHERE `TransactionType` = '$this->id'");
        return;
    }
}

