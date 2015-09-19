<?php
/**
 * Add, Edit, Delete Location
 * @package Location Controller
 * @author red
 */
Class Location extends MY_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        
        $this->setPage(array('view'=>'masterlist', 'name'=>'location', 'description'=>'view, add, edit, delete location'));
        $this->var['section_array'] = array(
            array('name'=>'province','label'=>'Province'),
            array('name'=>'citymunicipality','label'=>'City/Municipality'),
            array('name'=>'barangay','label'=>'Barangay')
        );
        $this->var['section_default'] = 'province';
        $this->setSection();
        $this->setModel('location_model');
    }
    public function index()
    {
        $this->province();
    }
    public function province()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->location_model->input_data = $input_data;
                $this->setMethod('addProvince');
                $this->form_validation->set_rules('data[ProvinceName]','Province Name', 'trim|required|is_unique[province.ProvinceName]');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getProvince');
                $this->setIndex('province_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateProvince');
                $this->form_validation->set_rules('data[ProvinceName]','Province Name', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getProvince');
                $this->setIndex('province_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
    public function citymunicipality()
    {
        /*Begin getting data needed for input forms in add and edit*/
        /*Get the Province - this is needed for dropdown list*/
        $this->setMethod('getProvince');
        $this->setIndex('province_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        /*End getting data needed for input forms in add and edit*/
        
        /*Begin initial process when submit button is clicked on add and edit*/
        /*Set the input data */
        $input_data = $this->input->post('data') ? $this->input->post('data') : array();
        $input_data['Active'] = isset($input_data['Active']) ? $input_data['Active'] : 0;
        /*Set the form validation when submit button is click on add and edit*/
        $this->form_validation->set_rules('data[ProvinceID]','Province', 'trim|required');
        $this->form_validation->set_rules('data[CityMunicipalityName]','Name', 'trim|required');
        $this->form_validation->set_rules('data[CityMunicipalityType]','Type', 'trim|required');
        /*End inital process when submit button is clicked on add and edit */
        
        /*Set the method based on action*/
        switch($this->var['action'])
        {
            case 'add':
                loadComponentsDropdowns();
                /*Begin additional process when submit button is clicked*/
                $this->setMethod('addCityMunicipality');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*Begin additional process when submit button is clicked*/
                break;
            case 'edit':
                loadComponentsDropdowns();
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getCityMunicipality');
                $this->setIndex('citymunicipality_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                $this->setMethod('updateCityMunicipality');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getCityMunicipality');
                $this->setIndex('citymunicipality_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
    
    public function barangay()
    {
        /*Begin getting data needed for input forms in add and edit*/
        /*Get the Province - this is needed for dropdown list*/
        $this->setMethod('getProvince');
        $this->setIndex('province_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        /*End getting data needed for input forms in add and edit*/
        
        /*Begin initial process when submit button is clicked on add and edit*/
        /*Set the input data */
        $input_data = $this->input->post('data') ? $this->input->post('data') : array();
        /*End inital process when submit button is clicked on add and edit */
        
        switch($this->var['action'])
        {
            case 'add':
                loadComponentsDropdowns();
                /*Begin additional process when submit button is clicked*/
                $this->setMethod('addBarangay');
                $this->form_validation->set_rules('data[CityMunicipalityID]','City/Municipality','trim|required');
                $this->form_validation->set_rules('data[BarangayName]','Barangay','trim|required');
                $this->form_validation->run() ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End additional process when submit button is clicked*/
                break;
            case 'edit':
                loadComponentsDropdowns();
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getBarangay');
                $this->setIndex('barangay_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*get the municipality list based on province id - this is needed for dropdown list on edit*/
                $province_id = $this->var['barangay_list'][0]['ProvinceID'];
                $this->setMethod('getCityMunicipality');
                $this->setIndex('citymunicipality_list');
                $this->executeMethod(array('type'=>'get','parent_id'=>$province_id,'active'=>1));
                /*End process when edit button is clicked*/
                
                /*Begin additional process when submit button is clicked*/
                $this->setMethod('updateBarangay');
                $this->form_validation->set_rules('data[CityMunicipalityID]','City/Municipality','trim|required');
                $this->form_validation->set_rules('data[BarangayName]','Barangay','trim|required');
                $this->form_validation->run() ? $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                /*End additional process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getBarangay');
                $this->setIndex('barangay_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
    
    public function getProvince()
    {
        $this->setModel('location_model');
        $this->setMethod('getProvince');
        $this->setIndex('province_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        $provinces = array();
        foreach($this->var['province_list'] as $row)
        {
            $id = $row['ProvinceID'];
            $text = $row['ProvinceName'];
            $provinces[] = array('id'=>$id,'text'=> $text);
        }
        echo json_encode($provinces);
    }
    public function getCityMunicipality()
    {
        $p = $_POST['p'];
        $this->setModel('location_model');
        $model = $this->var['model'];
        $this->$model->parent_id = $p;
        $this->setMethod('getCityMunicipality');
        $this->setIndex('citymunicipality_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        $citymunicipalities = array();
        foreach($this->var['citymunicipality_list'] as $row)
        {
            $id = $row['CityMunicipalityID'];
            $text = $row['CityMunicipalityName'];
            $citymunicipalities[] = array('id'=>$id,'text'=> $text);
        }
        echo json_encode($citymunicipalities);
    }
    public function getBarangay()
    {
        $p = $_POST['p'];
        $this->setModel('location_model');
        $model = $this->var['model'];
        $this->$model->parent_id = $p;
        $this->setMethod('getBarangay');
        $this->setIndex('barangay_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        $barangays = array();
        foreach($this->var['barangay_list'] as $row)
        {
            $id = $row['BarangayID'];
            $text = $row['BarangayName'];
            $barangays[] = array('id'=>$id,'text'=> $text);
        }
        echo json_encode($barangays);
    }
    
}
