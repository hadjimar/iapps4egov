<?php

/**
 * Description of books_model
 *
 * @author RedCrisostomo
 */
Class Business_Nature_Model extends CI_Model
{
    public $crud;
    public $id = 0;
    public $parent_id = 0;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public $table = "business_nature";
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = true;
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
        $this->crud->table = $this->table;
    }
    
    public function getBusinessNature($active=FALSE)
    {
        $this->list = array();
        $where = '';
        if($this->id>0)
        {
            $where .= "WHERE a.`BusinessNatureID` = '$this->id'";
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
        $this->crud->query = "SELECT a.*, GROUP_CONCAT(c.`TFOTemplateName` SEPARATOR ', ')AS TFOTemplateName FROM $this->table a LEFT JOIN `business_nature_template_schedule` b ON a.`BusinessNatureID` = b.`BusinessNatureID` LEFT JOIN `business_tfo_template` c ON b.`TFOTemplateID` = c.`TFOTemplateID` $where GROUP BY a.`BusinessNatureID` ORDER BY a.`BusinessNatureName` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addBusinessNature()
    {
        $this->crud->table = $this->table;
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateBusinessNature()
    {
        $this->crud->table = $this->table;
        $this->crud->input_data = $this->input_data;
        $this->crud->where = $this->id>0 ? array('BusinessNatureID'=>$this->id) : NULL;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    /*BEGIN TEMPLATE SCHEDULE*/
    public function getBusinessNatureTemplateSchedule()
    {
        $this->list = array();
        if($this->parent_id==0 && $this->id==0){return FALSE;}
        $where = "";
        $where .= $this->parent_id>0 ? "WHERE a.`BusinessNatureID` = '$this->parent_id'" : NULL;
        $where .= $this->id>0 ? (strlen($where)>0 ? "WHERE" : " AND" )." a.`BusinessNatureTemplateScheduleID` = '$this->id'" : NULL;
        $this->crud->query = "SELECT a.`BusinessNatureTemplateScheduleID`,b.`TFOTemplateID`,b.`TFOTemplateName`,b.`TFOTemplateDescription`,a.`Active`, GROUP_CONCAT(CONCAT(d.`TFOName`,' [',c.`TransactionType`,']') SEPARATOR ', ') AS TFOTemplateDetails FROM `business_nature_template_schedule` a JOIN `business_tfo_template` b ON a.`TFOTemplateID`=b.`TFOTemplateID` LEFT JOIN `business_tfo_schedule` c ON a.`TFOTemplateID`=c.`TFOTemplateID` LEFT JOIN `tfo` d ON c.`TFOID` = d.`TFOID` $where GROUP BY a.`BusinessNatureID`, a.`TFOTemplateID` ORDER BY a.`BusinessNatureTemplateScheduleID`";
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            $this->list = $this->crud->result_data;
            return TRUE;
        }
        return FALSE;
    }
    public function getAvailableTFOTemplate()
    {
        $this->list = array();
        if($this->parent_id==0){return FALSE;}
        $where = "WHERE `BusinessNatureID` = '$this->parent_id'";
        $this->crud->query = "SELECT a.`TFOTemplateID`,a.`TFOTemplateName`, a.`TFOTemplateDescription`, GROUP_CONCAT(CONCAT(c.`TFOName`,' [',b.`TransactionType`,']') SEPARATOR ', ') AS `TFOTemplateDetails` FROM `business_tfo_template` a LEFT JOIN `business_tfo_schedule` b ON a.`TFOTemplateID` = b.`TFOTemplateID` LEFT JOIN `tfo` c ON b.`TFOID` = c.`TFOID` WHERE a.`TFOTemplateID` NOT IN (SELECT `TFOTemplateID` FROM `business_nature_template_schedule` $where) AND a.`Active` = 1 GROUP BY a.`TFOTemplateID` ORDER BY a.`TFOTemplateID`";
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            $this->list = $this->crud->result_data;
            return TRUE;
        }
        return FALSE;
    }
    public function addBusinessNatureTemplateSchedule()
    {
        if(count($this->input_data)==0){return FALSE;}
        $this->crud->table = 'business_nature_template_schedule';
        $this->crud->input_data = $this->input_data;
        if($this->crud->createBatch())
        {
            return TRUE;
        }
        return FALSE;
    }
    /*END TEMPLATE SCHEDULE*/
}
