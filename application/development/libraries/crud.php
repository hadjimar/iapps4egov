<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package: Crud
 * This library serves as the main data model.  
 * This contains methods to create, read, update and delete record to and from the database
 * @author RedCrisostomo
 */

Class Crud 
{
    public $table = null;
    public $input_data = array();
    public $result_data = array();
    public $fields = null;
    public $where = null;
    public $group = null;
    public $order_by = null;
    public $offset = null;
    public $having = null;
    public $query = null;
    public $last_id = 0;
    public $audit_trail = false;
    public $audit_trail_settings = array();
    public $audit_trail_result = array();
    public $CI;
 
    public function __construct() 
    {
        $this->CI = &get_instance();
    }
    
    /**
     * Get a specific record / set of records
     * @access public
     * @return void
     */
    public function read()
    {
        $this->_clearResultData();
        $this->_verifyTable();
        $this->_setWhere();
        $this->_setGroup();
        $this->_setOrderBy();
        $this->_setOffset();
        $this->_setHaving();
        $this->_setFields();
        if($query = $this->CI->db->get($this->table))
        {
            /*throw fetch data into global variable: if more than 1 record is found the result will be multidimentional array else a simple array*/
            $this->result_data = $query->result_array();
            $query->free_result();
            return;
        }
        return FALSE;
    }
    /**
     * Read by Custom Query
     * @return boolean/void
     */
    public function readByCustomQuery()
    {
        if(!$this->query OR strlen($this->query)==0)
        {
            return FALSE;
        }
        if($query = $this->CI->db->query($this->query))
        {
            $this->_clearQuery();
            $this->result_data = $query->result_array();
            $query->free_result();
            return;
        }
        return FALSE;
    }
    
    /**
     * Add a record
     * @access public
     * @return boolean
     */
    
    public function create()
    {
        if(!$this->_verifyTable() OR !$this->_verifyInputData()){return FALSE;}
        $this->_setAuditTrail();
        
        if($this->CI->db->insert($this->table, $this->input_data))
        {
            
            $this->last_id = $this->CI->db->insert_id();
            if($this->audit_trail==true)
            {
                $this->audit_trail_result['UserID'] = $this->audit_trail_settings['user_id'];
                $this->audit_trail_result['Action'] = "create";
                $this->audit_trail_result['AffectedTable'] = $this->table;
                $this->audit_trail_result['RecordID'] = $this->CI->db->insert_id();
                $this->audit_trail_result['AffectedFields'] = implode(' | ',  array_keys($this->input_data));
                $this->audit_trail_result['InputData'] = implode(' | ',  $this->input_data);
                count($this->audit_trail_result)>0 ? $this->CI->db->insert($this->audit_trail_settings['table'],  $this->audit_trail_result) : NULL;
            }
            return TRUE;
        }
        return FALSE;
    }
    
    public function createBatch()
    {
        if(!$this->_verifyTable() OR !$this->_verifyInputData()){return FALSE;}
        $this->_setAuditTrail();
        $i=0;
        foreach($this->input_data as $row)
        {
            if($this->CI->db->insert($this->table, $row))
            {
                $this->last_id = $this->CI->db->insert_id();
                if($this->audit_trail==true)
                {
                    $this->audit_trail_result['UserID'] = $this->audit_trail_settings['user_id'];
                    $this->audit_trail_result['Action'] = "create";
                    $this->audit_trail_result['AffectedTable'] = $this->table;
                    $this->audit_trail_result['RecordID'] = $this->CI->db->insert_id() ? $this->CI->db->insert_id() : $this->audit_trail_settings['record_id'];
                    $this->audit_trail_result['AffectedFields'] = implode(' | ',  array_keys($row));
                    $this->audit_trail_result['InputData'] = implode(' | ',  $row);
                    count($this->audit_trail_result)>0 ? $this->CI->db->insert($this->audit_trail_settings['table'],  $this->audit_trail_result) : NULL;
                }
                
                $i++;
            }
        }
        if($i==count($this->input_data))
        {
            return TRUE;
        }
        return FALSE;
    }
    
    
    /**
     * Update the record
     * @access public
     * @return boolean
     */
    public function update()
    {
        if(!$this->_verifyTable() OR !$this->_verifyInputData()){return FALSE;}
        $this->_setAuditTrail();
        if($this->audit_trail==true)
        {
           $affectedfields = array();
           $old_data = array();
           $new_data = array();
            /*get the old data*/
            $this->_setWhere();
            $this->CI->db->select(implode(',',array_keys($this->input_data)));
            if($query = $this->CI->db->get($this->table))
            {
                foreach($query->row_array() as $key => $value)
                {
                    if($this->input_data[$key]!=$value)
                    {
                        array_push($affectedfields,$key);
                        array_push($old_data, $value);
                        array_push($new_data, $this->input_data[$key]);
                    }
                }
                if(count($affectedfields)>0)
                {
                    $this->audit_trail_result['UserID'] = $this->audit_trail_settings['user_id'];
                    $this->audit_trail_result['Action'] = 'update';
                    $this->audit_trail_result['AffectedTable'] = $this->table;
                    $this->audit_trail_result['AffectedFields'] = implode(' | ', $affectedfields);
                    $this->audit_trail_result['RecordID'] = $this->audit_trail_settings['record_id'];
                    $this->audit_trail_result['OldData'] = implode(' | ', $old_data);
                    $this->audit_trail_result['NewData'] = implode(' | ', $new_data);
                }
                $query->free_result();
            }
            
            /*execute the update query*/
            $this->_setWhere();
            if($query = $this->CI->db->update($this->table,  $this->input_data))
            {
                count($this->audit_trail_result)>0 ? $this->CI->db->insert($this->audit_trail_settings['table'],  $this->audit_trail_result) : NULL;
                return TRUE;
            }
            return FALSE;
        }
        else
        {
            $this->_setWhere();
            if($query = $this->CI->db->update($this->table,  $this->input_data))
            {
                return TRUE;
            }
            return FALSE;
        }
        
    }
    
    public function setActive()
    {
        if(!$this->_verifyTable() OR !$this->_verifyInputData()){return FALSE;}
        $this->_setAuditTrail();
        
        if($this->audit_trail==true)
        {
            $this->_setWhere();
            $this->CI->db->select('Active');
            if($query = $this->CI->db->get($this->table))
            {
                $row = $query->row_array();
                /*compare the old record to the new input: if changes found set the values of log result*/
                if($row['Active'] != $this->input_data['Active'])
                {
                    $this->audit_trail_result['UserID'] = $this->audit_trail_settings['user_id'];
                    $this->audit_trail_result['Action'] = "update";
                    $this->audit_trail_result['AffectedTable'] = $this->table;
                    $this->audit_trail_result['RecordID'] = $this->audit_trail_settings['record_id'];
                    $this->audit_trail_result['AffectedFields'] = 'Active';
                    $this->audit_trail_result['OldData'] = $row['Active'];
                    $this->audit_trail_result['NewData'] = $this->input_data['Active'];
                }
                $query->free_result();
            }
            $this->_setWhere();
            if($this->CI->db->update($this->table, $this->input_data))
            {
                count($this->audit_trail_result)>0 ? $this->CI->db->insert($this->audit_trail_settings['table'],  $this->audit_trail_result) : NULL;
                return TRUE;
            }
            return FALSE;
        }
        else
        {
            $this->_setWhere();
            if($this->CI->db->update($this->table, $this->input_data))
            {
                return TRUE;
            }
            return FALSE;
        }
    }
    
    /**
     * Set the record to deleted status
     * @access public
     * @return boolean
     */    
    public function delete()
    {
        if(!$this->_verifyTable()){return FALSE;}
        $this->_setWhere();
        if($query = $this->CI->db->delete($this->table))
        {
            return TRUE;
        }
        return FALSE;
    }
    
    
    /**
     * Get Max Record
     * @param string $field  The database field
     * @param string $table  The database table
     */
    public function getMax($field,$table)
    {
        $this->CI->db->select_max($field);
        if($query = $this->CI->db->get($table))
        {
            $row = $query->row_array();
            $this->max = $row[$field];
        }
    }
    /**
     * Set the MySQL clauses
     * @access private
     * @return method
     */
    private function _setWhere()
    {
        if(!isset($this->where) OR (is_array($this->where) ? count($this->where)==0 : strlen($this->where)==0)){ return FALSE;}
        return $this->CI->db->where($this->where);
    }
    private function _setGroup()
    {
        if(!isset($this->group) OR strlen($this->group)==0){ return FALSE; }
        return $this->CI->db->group($this->group);
    }
    private function _setOrderBy()
    {
        if(!isset($this->order_by) OR strlen($this->order_by)==0){ return FALSE; }
        return $this->CI->db->order_by($this->order_by);
    }
    private function _setOffset()
    {
        if(!isset($this->offset) OR strlen($this->offset)==0) { return FALSE; }
            return $this->CI->db->offset($this->offset);
    }
    private function _setHaving()
    {
        if(!isset($this->having) OR strlen($this->having)==0){ return FALSE; }
        return $this->CI->db->having($this->having);
    }
    
    /**
     * Set the database fields for getting record
     * @access private
     * @return method
     */
    private function _setFields()
    {
        if(isset($this->fields) OR strlen($this->fields)>0)
        {
            return $this->CI->db->select($this->fields);
        }
    }
    
    /**
     * Verify if the table is specified or if it exists in the database
     * @access private
     * @return boolean
     */
    private function _verifyTable()
    {
        if(!isset($this->table) OR strlen($this->table)==0 OR !$this->CI->db->table_exists($this->table))
        {
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Verify if input data is specified or if not empty
     * @access private
     * @return boolean
     */
    private function _verifyInputData()
    {
        if(!isset($this->input_data) OR count($this->input_data)==0)
        {
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Reset the table
     * @access private
     */
    private function _clearTable()
    {
        $this->table = NULL;
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
     * Reset the result data
     * @access private
     */
    private function _clearResultData()
    {
        $this->result_data = array();
    }
    
    /**
     * Reset the fields
     * @access private
     */
    private function _clearFields()
    {
        $this->fields = NULL;
    }
    
    /**
     * Reset the MySQL clauses
     * @access private
     */
    private function _clearClause()
    {
        $this->where = NULL;
        $this->group = NULL;
        $this->order = NULL;
        $this->offset = NULL;
        $this->having = NULL;
    }
    private function _clearQuery()
    {
        $this->query = NULL;
    }
    
    /**
     * Set the audit trail
     * @return void
     */
    private function _setAuditTrail()
    {
        /*empty the result*/
        $this->audit_trail_result = array();
        
        /*set the array keys for settings*/
        $settings = array('table','user_id');
        /*loop through each key*/
        foreach($settings as $setting)
        {
            /*if any of the key is not defined set the audit trail to false*/
            if(!isset($this->audit_trail_settings[$setting]) OR strlen($this->audit_trail_settings[$setting])==0)
            {
                $this->audit_trail = false;
            }
        }
        return;
    }
    /**
     * Clear the audit trail settings
     * @return void
     */
    private function _clearAuditTrailSettings()
    {
        $this->audit_trail_settings = array();
        return;
    }
}