<?php

/**
 * Description of citizenship_model
 *
 * @author RedCrisostomo
 */
Class Citizenship_Model extends CI_Model
{
    public $crud;
    public $id = 0;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public $table = "citizenship";
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->table = $this->table;
    }
    
    public function getCitizenship($active=FALSE)
    {
        $where = '';
        if($this->id>0)
        {
            $where .= "WHERE `CitizenshipID` = '$this->id'";
        }
        if($this->where)
        {
            $where = "WHERE ".$this->where;
        }
        if($active==TRUE)
        {
            if(strlen($where)>0)
            {
                $where .= " AND `Active` = '$active'";
            }
            else
            {
                $where .= "WHERE `Active` = '$active'";
            }
        }
        $this->crud->query = "SELECT * FROM $this->table $where ORDER BY `CitizenshipID` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addCitizenship()
    {
        $this->crud->table = "citizenship";
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateCitizenship()
    {
        $this->crud->table = $this->table;
        $this->crud->input_data = $this->input_data;
        $this->crud->where = $this->id>0 ? array('CitizenshipID'=>$this->id) : NULL;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
}
