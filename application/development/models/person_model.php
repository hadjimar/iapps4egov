<?php

/**
 * Description of person_model
 *
 * @author unexpec
 */
Class Person_Model extends CI_Model
{
    public $crud;
    public $table = "person";
    public $address;
    public $last_person_id = 0;
    public $id = 0;
    public $input_data = array();
    public $list = array();
    public $list_view = array();
    
    public function __construct() 
    {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->model('address_model');
        $this->crud = new Crud();
        $this->address = new Address_Model();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
    }
    
    /**
     * Get Person
     * @access public
     * @return void|boolean
     */
     public function getPerson($active=FALSE)
    {
        $where = '';
        if($this->id>0)
        {
            $where = "WHERE a.`PersonID` = '$this->id'";
        }
        if($this->where)
        {
            $where = "WHERE ".$this->where;
        }
        $this->crud->query = "SELECT a.`PersonID`, a.`LastName`, a.`FirstName`, a.`MiddleName`, a.`ExtensionName`, a.`Birthday`, a.`Gender`,a.MaritalStatus, b.`CitizenshipID`, b.`CitizenshipName`, c.`AddressID`, c.`HouseUnitNumber`, c.`BuildingNumber`, c.`BuildingName`, c.`LotNumber`, c.`BlockNumber`, c.`SubdivisionName`, c.`StreetName`, c.`Zone`, d.`BarangayID`,d.`BarangayName`, e.`CityMunicipalityID`, e.`CityMunicipalityName`, f.`ProvinceID`, f.`ProvinceName` FROM `person` a LEFT JOIN `citizenship` b ON a.`CitizenshipID` = b.`CitizenshipID` LEFT JOIN `address` c ON a.`AddressID` = c.`AddressID` LEFT JOIN `barangay` d ON c.`BarangayID` = d.`BarangayID` LEFT JOIN `city_municipality` e ON d.`CityMunicipalityID` = e.`CityMunicipalityID` LEFT JOIN `province` f ON e.`ProvinceID` = f.`ProvinceID` $where ORDER BY a.`LastName` ASC, a.`FirstName` ASC, a.`MiddleName` ASC;";
        $this->crud->readByCustomQuery();
        $this->list = $this->crud->result_data;
    }
    
    /**
     * Add person
     * @access public
     * @return boolean
     */
    public function addPerson()
    {
        $this->address->setInputData($this->input_data);
        $this->address->addAddress();
        if($this->address->last_address_id==0){return FALSE;}
        /*Transfer set of values to insert to the crud input data */
        $this->setInputData($this->input_data);
        $this->input_data['AddressID'] = $this->address->last_address_id;
        $this->crud->input_data = $this->input_data;
        $this->crud->table = $this->table;
        /*If data insertion is successful*/
        if($this->crud->create())
        {
            $this->last_person_id = $this->crud->last_id;
            $this->_clearInputData();
            return TRUE;
        }
        return FALSE;  
    }
    
    public function updatePerson()
    {
        /*Add new address record if found that the given data is different*/
        $this->address->setInputData($this->input_data);
        $this->address->addAddress();
        if($this->id==0 && $this->address->last_address_id==0){return FALSE;}
        $this->crud->where['PersonID'] = $this->id;
        $this->setInputData($this->input_data);
        $this->input_data['AddressID'] = $this->address->last_address_id;
        $this->crud->input_data = $this->input_data;
        $this->crud->table = $this->table;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    /**
     * Get the person address
     * @access public
     * @return void|boolean
     */
    public function getPersonAddress()
    {
        /*If the list is empty return false*/
        if(!isset($this->list) OR count($this->list)==0)
        {
            return FALSE;
        }
        /*else get the record*/
        $a=0; /*identifier for each record*/
        $new_list = array();
        foreach($this->list as $row) /*loop through each record*/
        {
            /*If each row is an object*/
            if(is_object($row))
            {
                $row = get_object_vars($row); /* convert into array */
            }
            $this->address->id = $row['AddressID']; /*Specify the address id*/
            $this->address->getAddress(); /* Get the address */
            $address_list = $this->address->list; /* Put the fetched address into new container */
            
            /*if the fetched record is an object, convert into array*/
            if(is_object($address_list))
            {
                $address_list = get_object_vars($address_list); /*  */
            }
            
            /* loop through each value and then add into the person record */
            foreach($address_list as $key => $val)
            {
                $row[$key] = $val; 
            }
            $new_list[$a] = $row;
            
            $a++; /*increment the record identifier*/
        }
        $this->list = $new_list;
        return;
    }
    
    /**
     * Update address
     * @access public
     * @return boolean
     */
    public function updateAddress()
    {
        $this->_verifyInputData();
        /*Make sure that the id is specified*/
        $this->_verifyID();
        /*Set the filtering on which record should be updated*/
        $this->crud->where = "PersonID = $this->id";
        /*Transfer the data update to the crud input data*/
        $this->crud->input_data = $this->input_data;
        /*If update is successful*/
        if($this->crud->update())
        {
            $this->_clearID(); /*Reset the id*/
            $this->_clearInputData(); /*Reset the input data*/
            return TRUE;
        }
       /*If update failed*/
        return FALSE;
    }
    
    public function setInputData($input_data)
    {
        $fields = $this->db->list_fields('person');
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
        unset($result['PersonID']);
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
    private function _verifyAddressID()
    {
        if($this->address->last_address_id==0)
        {
            return FALSE;
        }
    }
    /**
     * Check if id is specifiec.  This is use when updating record
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
    
    /**
     * Reset the address list
     * @access private
     */
    private function _clearList()
    {
        $this->list = array();
    }
    
}
