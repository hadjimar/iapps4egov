<?php

/**
 * Description of teacher_model
 *
 * @author red
 */
Class Business_Owner_Model extends CI_Model
{
    public $crud;
    public $person;
    public $table = "teacher";
    public $id = 0;
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
    
    public function getTeacher($active=FALSE)
    {
        $where = '';
        if($this->id>0)
        {
            $where .= "WHERE a.`TeacherRecordID` = '$this->id'";
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
        $this->crud->query = "SELECT a.`TeacherRecordID`, a.`TeacherID`, a.`Picture`, a.`Active`, a.`PersonID`, b.`LastName`, b.`FirstName`, b.`MiddleName`, b.`ExtensionName`, b.`Birthday`, b.`Gender`, b.`MaritalStatus`, c.`CitizenshipID`, c.`CitizenshipName`, d.`AddressID`, d.`HouseUnitNumber`, d.`BuildingNumber`, d.`BuildingName`, d.`LotNumber`, d.`BlockNumber`, d.`SubdivisionName`, d.`StreetName`, d.`Zone`, e.`BarangayID`,e.`BarangayName`,f.`CityMunicipalityID`,f.`CityMunicipalityName`,g.`ProvinceID`,g.`ProvinceName` FROM `teacher` a INNER JOIN `person` b ON a.`PersonID`=b.`PersonID` LEFT JOIN `citizenship` c ON b.`CitizenshipID` = c.`CitizenshipID` LEFT JOIN `address` d ON b.`AddressID` = d.`AddressID` LEFT JOIN `barangay` e ON d.`BarangayID` = e.`BarangayID` LEFT JOIN `city_municipality` f ON e.`CityMunicipalityID` = f.`CityMunicipalityID` LEFT JOIN `province` g ON f.`ProvinceID` = g.`ProvinceID` $where ORDER BY b.`LastName` ASC, b.`FirstName` ASC, b.`MiddleName` ASC;";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    public function addTeacher()
    {
        $this->person->input_data = $this->input_data;
        $this->person->addPerson();
        if($this->person->last_person_id>0)
        {
            $this->setInputData($this->input_data);
            $this->_verifyInputData();
            $this->input_data['PersonID'] = $this->person->last_person_id;
            $this->crud->input_data = $this->input_data;
            $this->crud->table = $this->table;
            if($this->crud->create())
            {
               return TRUE;
            }
            return FALSE;
        }
    }
    
    public function updateTeacher()
    {
        /*Update Person Data*/
        $this->person->id = $this->input_data['PersonID'];
        $this->person->input_data = $this->input_data;
        $this->person->updatePerson();
        /*Update Teacher data*/
        if($this->id==0){return FALSE;}
        $this->setInputData($this->input_data);
        $this->crud->input_data = $this->input_data;
        $this->crud->where['TeacherRecordID'] = $this->id;
        $this->crud->table = $this->table;
        if($this->crud->update())
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
        unset($result['TeacherRecordID']);
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
     * Check if id is specified.  This is use when updating record
     * @access private
     * @return boolean
     */
    private function _verifyID()
    {
        if($this->id==0)
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
}
