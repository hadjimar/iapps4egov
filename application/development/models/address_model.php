<?php

/**
 * This is the data model for address.
 *
 * @author RedCrisostomo
 */
Class Address_Model extends CI_Model
{
    public $crud;
    public $person;
    public $last_address_id = 0;
    public $table = "address";
    public $id = 0;
    public $input_data = array();
    public $list = array();
    public $list_view = array();
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
        $this->crud->table = $this->table;
    }
    
   
    /**
     * Get Address
     * @access public
     * @return void|boolean
     */
    public function getAddress()
    {
        /*Make sure that the list is empty*/
        $this->_clearList();
        /*If id is specified*/
        if($this->id>0)
        {
            $this->crud->where = "AddressID = $this->id"; /*Set the filter to get only the record based on specified id*/
        }
        $this->crud->table = $this->table;
        /*If getting record is successfull*/
        $this->crud->read();
        if(isset($this->crud->result_data) && count($this->crud->result_data)>0)
        {
            $this->list = $this->crud->result_data;  /*Transfer the data to the list*/
            $this->_clearID();  /*Reset the address id*/
            return;
        }
        /*If getting record failed*/
        return FALSE;
    }
    
     /**
     * Add address
     * @access public
     * @return boolean
     */
    public function addAddress()
    {
        /*Set the values of input data as where parameters*/
        $this->crud->where = $this->input_data;
        /*Run query to check if the same record exists*/
        $this->getAddress();
        /*If the record exists*/
        if(count($this->list)>0)
        {
            $this->last_address_id = $this->list[0]['AddressID'];
            return;
        }
        else
        {
            $this->crud->input_data = $this->input_data;
            $this->crud->table = $this->table;
            if($this->crud->create())
            {
                $this->last_address_id = $this->crud->last_id;
                return TRUE;
            }
            return FALSE;
        }
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
        unset($result['AddressID']);
        $this->_clearInputData();
        $this->input_data = $result;
        return;
    }
    
    private function _verifyInputData()
    {
        if(!isset($this->input_data) OR count($this->input_data)==0)
        {
            return FALSE;
        }
    }
    
    /**
    * Reset the address id to 0
    * @access private
    */
    private function _clearID()
    {
        $this->id = 0;
    }
    
    /**
     * Reset the input data
     * @access private
     */
    private function _clearInputData()
    {
        $this->input_data = array();
    }
    
    /**
     * Reset the address list
     * @access private
     */
    private function _clearList()
    {
        $this->list = array();
    }
}
