<?php

/**
 * Description of business_tfo_template_model
 *
 * @author RedCrisostomo
 */
Class Business_TFO_Template_Model extends CI_Model
{
    public $crud;
    public $id = 0;
    public $parent_id = 0;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public $range_list = array();
    public $table_a = "business_tfo_schedule";
    public $table_b = "business_tfo_template";
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
    }
    /*BEGIN TFO TEMPLATE*/
    public function getTFOTemplate($active=FALSE)
    {
        $this->list = array();
        $where = '';
        $where .= $this->id>0 ? "WHERE `TFOTemplateID` = '$this->id'" : NULL; /*if id is provided*/
        $where .= $this->where ? (strlen($where)>0 ? " AND $this->where " : "WHERE ".$this->where) : NULL; /*if where parameter is provided: if where is not empty, add to where, else set as where */
        $where .= $active==TRUE ? (strlen($where)>0 ? " AND `Active` = '$active'" : "WHERE `Active` = '$active'") : NULL; /*if active parameter is provided: if where is not empty, add to where, else set as where */
        $this->crud->query = "SELECT * FROM $this->table_b $where ORDER BY `TFOTemplateName` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addTFOTemplate()
    {
        $this->crud->table = $this->table_b;
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateTFOTemplate()
    {
        if($this->id==0 OR count($this->input_data)==0){return FALSE;}
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        $this->crud->table = $this->table_b;
        $this->crud->input_data = $this->input_data;
        $this->crud->where = array('TFOTemplateID'=>$this->id);
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    /*END TFO TEMPLATE*/
    
    /*BEGIN TFO SCHEDULE*/
    public function getTFOSchedule($active=FALSE)
    {
        $this->list = array();
        if($this->parent_id==0 && $this->id==0){return FALSE;}
        $where = "";
        $where .= $this->parent_id>0 ? "WHERE a.`TFOTemplateID` = '$this->parent_id'" : NULL;
        $where .= $this->id>0 ? (strlen($where)>0 ? " AND " : "WHERE"). "a.`TFOScheduleID` = '$this->id'" : NULL;
        $this->crud->query = "SELECT a.`TFOScheduleID`,a.`TFOTemplateID`, b.`TFOTemplateName`, b.`TFOTemplateDescription`, c.`TFOName`, d.`TFOTypeName`, a.`TransactionType`, a.`Basis`, a.`ModeOfComputation`, a.`MinimumAmount`,a.`FormulaType`,a.`UnitOfMeasure`, a.`RangeNumber`, a.`LowerLimit`, a.`HigherLimit`, a.`Amount`, a.`Formula`, a.`Active` FROM $this->table_a a JOIN $this->table_b b  ON a.`TFOTemplateID` = b.`TFOTemplateID` JOIN `tfo` c ON a.`TFOID` = c.`TFOID` JOIN `tfo_type` d ON c.`TFOTypeID` = d.`TFOTypeID` $where GROUP BY a.`TFOScheduleID` ORDER BY a.`TFOScheduleID` ASC";
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            $list = $this->crud->result_data;
            $i=0;
            foreach($list as $row)
            {
                $this->list[$i] = $row;
                if($row['ModeOfComputation']=='Range')
                {
                    $id = $row['TFOScheduleID'];
                    $this->getRangeSchedule($id);
                    if(count($this->range_list)>0)
                    {
                        $this->list[$i]['Range'] = $this->range_list;
                    }
                }
                $i++;
            }
        }
    }
    
    public function addTFOSchedule()
    {
        $this->crud->table = $this->table_a;
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function addBatchTFOSchedule()
    {
        $this->crud->audit_trail_settings['record_id'] = $this->input_data[0]['TFOScheduleID'];
        $this->crud->table = $this->table_a;
        $this->crud->input_data = $this->input_data;
        if($this->crud->createBatch())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateTFOSchedule()
    {
        if($this->id==0 OR count($this->input_data)==0){return FALSE;}
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        $this->crud->table = $this->table_a;
        $this->crud->input_data = $this->input_data;
        $this->crud->where = array('TFOScheduleID'=>$this->id);
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function getRangeSchedule($id)
    {
//        if(!$id){return FALSE;}
        $this->crud->query = "SELECT `RangeNumber`,`LowerLimit`,`HigherLimit`,`Amount`,`Formula` FROM $this->table_a WHERE `TFOScheduleID` = '$id' ORDER BY `RangeNumber`;";
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            $this->range_list = $this->crud->result_data;
            return TRUE;
        }
        return FALSE;
    }
    
    public function getComplexFormula()
    {
        if($this->id==0 OR strlen($this->where)==0){return FALSE;}
        $query = "SELECT (CASE WHERE a.`TFOScheduleID` = '$this->id' AND $this->where;";
        if($this->crud->readByCustomQuery($query))
        {
            $this->list = $this->crud->result_data;
            return TRUE;
        }
        return FALSE;
    }
    
    public function getVariables()
    {
        if($this->id==0 OR strlen($this->where)==0){return FALSE;}
        $query = "SELECT b.`TFOID`, b.`TFOName` FROM $this->table_a a JOIN `tfo` b ON a.`TFOID` = b.`TFOID` WHERE a.`TFOScheduleID` = '$this->id' AND a.`Active` = 1";
        $this->crud->query = $query;
        if($this->crud->readByCustomQuery())
        {
            $this->list = $this->crud->result_data;
            return TRUE;
        }
        return FALSE;
    }
    /*END TFO TEMPLATE*/
}


