<?php

/**
 * Description of location_model
 * @package Location Model
 * @author RedCrisostomo
 */
Class Location_Model extends CI_Model
{
    public $crud;
    public $id = 0;
    public $parent_id = 0;
    public $input_data = array();
    public $where = null;
    public $list = array();
    public $list_view = array();
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
    }
    
    /*BEGIN GETTING RECORDS*/
    /**
     * Get Province
     * @param array $params
     * @param string $params['id'] ProvinceID of record to get
     * @return void
     */
    public function getProvince($active=NULL)
    {
        $this->crud->table = "province";
        if($this->id>0)
        {
            $this->crud->where = "ProvinceID = $this->id";
        }
        if($active)
        {
            $this->crud->where = "Active = $active";
        }
        if($this->where)
        {
            $this->crud->where = $this->where;
        }
        $this->crud->order_by = "Active desc, ProvinceName asc";
        $this->crud->read();
        $this->list = $this->crud->result_data;
        return;
    }
    /**
     * Get City / Municipality
     * @param int $active
     * @return void
     */
    public function getCityMunicipality($active=NULL)
    {
        $where = '';
        /*if id is set*/
        if($this->id>0) { $where .= "WHERE a.`CityMunicipalityID` = '$this->id'"; }
        /*if parent id is set*/
        elseif($this->parent_id>0) { $where .= "WHERE a.`ProvinceID` = '$this->parent_id'"; }
        /*if where parameter is set*/
        if($this->where) { $where = "WHERE ".$this->where; }
        /*if active parameter is set*/
        if($active) { $where .= strlen($where)>0 ? " AND a.`Active` = '$active'" : "WHERE a.`Active` = '$active'"; }
        /*get only the record where province is active*/
        $where .= strlen($where)>0 ? " AND b.`Active` = 1" : "WHERE b.`Active` = 1";
        
        $this->crud->query = "SELECT a.`CityMunicipalityID`,a.`CityMunicipalityName`,a.`CityMunicipalityType`,a.`Active`,a.`ProvinceID`,b.`ProvinceName` FROM `city_municipality` a JOIN `province` b ON a.`ProvinceID` = b.`ProvinceID` $where ORDER BY a.`Active` DESC, b.`ProvinceName` ASC, a.`CityMunicipalityName` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
        return;
    }
    
    public function getBarangay($active=NULL)
    {
        $where = '';
        /*if id is set*/
        if($this->id>0) { $where .= "WHERE a.`BarangayID` = '$this->id'"; }
        /*if parent id is set*/
        elseif($this->parent_id>0) { $where .= "WHERE a.`CityMunicipalityID` = '$this->parent_id'"; }
        /*if where parameter is set*/
        if($this->where) { $where = "WHERE ".$this->where; }
        /*if active parameter is set*/
        if($active) { $where .= strlen($where)>0 ? " AND a.`Active` = '$active'" : "WHERE a.`Active` = '$active'"; }
        /*get only the record where province and city municipality are both active */
        $where .= strlen($where)>0 ? " AND b.`Active` = 1 AND c.`Active` = 1" : "WHERE b.`Active` = 1 AND c.`Active` = 1";
        
        $this->crud->query = "SELECT a.`BarangayID`,a.`BarangayName`,a.`Active`,a.`CityMunicipalityID`,b.`CityMunicipalityName`,b.`ProvinceID`,c.`ProvinceName` FROM `barangay` a JOIN `city_municipality` b ON a.`CityMunicipalityID` = b.`CityMunicipalityID` JOIN `province` c ON b.`ProvinceID` = c.`ProvinceID` $where ORDER BY a.`Active` DESC, b.`CityMunicipalityName` ASC, a.`BarangayName` ASC";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
        return;
    }
    /*END GETTING RECORDS*/
    
    /**BEGIN ADDING RECORDS*/
    public function addProvince()
    {
        $this->crud->table = "province";
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    
    public function addCityMunicipality()
    {
        $this->crud->table = "city_municipality";
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    public function addBarangay()
    {
        $this->crud->table = "barangay";
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    /*END ADDING RECORDS*/
    
    /*BEGIN UPDATING RECORDS*/
    public function updateProvince()
    {
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
        $this->crud->table = "province";
        $this->crud->input_data = $this->input_data;
        $this->crud->where = $this->id>0 ? array('ProvinceID'=>$this->id) : NULL;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    public function updateCityMunicipality()
    {
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
        $this->crud->table = "city_municipality";
        $this->crud->input_data = $this->input_data;
        $this->crud->where = $this->id>0 ? array('CityMunicipalityID'=>$this->id) : NULL;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    public function updateBarangay()
    {
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
        $this->crud->table = "barangay";
        $this->crud->input_data = $this->input_data;
        $this->crud->where = $this->id>0 ? array('BarangayID'=>$this->id) : NULL;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    /*END UPDATING RECORDS*/
}
