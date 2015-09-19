<?php

/**
 * Description of tfo_model
 *
 * @author RedCrisostomo
 */
Class TFO_Model extends CI_Model
{
    public $crud;
    public $id = 0;
    public $parent_id = 0;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public $table_a = "tfo";
    public $table_b = "tfo_type";
    public $table_c = "tfo_template";
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
    }
    /*BEGIN TFO*/
    public function getTFO($active=FALSE)
    {
        $where = '';
        if($this->id>0)
        {
            $where .= "WHERE a.`TFOID` = '$this->id'";
        }
        elseif($this->parent_id>0)
        {
            $where .= "WHERE a.`TFOTypeID` = '$this->parent_id'";
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
        $this->crud->query = "SELECT a.*, b.`TFOTypeName` FROM $this->table_a a JOIN $this->table_b b ON a.`TFOTypeID` = b.`TFOTypeID` $where ORDER BY a.`TFOID` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addTFO()
    {
        $this->crud->table = $this->table_a;
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateTFO()
    {
        if($this->id==0 OR count($this->input_data)==0){return FALSE;}
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        $this->crud->table = $this->table_a;
        $this->crud->input_data = $this->input_data;
        $this->crud->where = array('TFOTypeID'=>$this->id);
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    /*END TFO */
    
    /*BEGIN TFO TYPE*/
    public function getTFOType($active=FALSE)
    {
        $where = '';
        if($this->id>0)
        {
            $where .= "WHERE `TFOTypeID` = '$this->id'";
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
        $this->crud->query = "SELECT * FROM $this->table_b $where ORDER BY `TFOTypeID` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addTFOType()
    {
        $this->crud->table = $this->table_b;
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateTFOType()
    {
        if($this->id==0 OR count($this->input_data)==0){return FALSE;}
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        $this->crud->table = $this->table_b;
        $this->crud->input_data = $this->input_data;
        $this->crud->where = array('TFOTypeID'=>$this->id);
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    /*END TFO TYPE*/
}
