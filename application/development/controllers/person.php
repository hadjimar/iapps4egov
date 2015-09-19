<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of person
 *
 * @author red
 */
Class Person extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('person_model');
        $this->load->model('location_model');
        $this->setPage(array('view'=>'masterlist', 'name'=>'person', 'description'=>'view, add, edit, delete person'));
    }
    public function index()
    {
        switch($this->var['action'])
        {
            case 'add':
                loadComponentPickers();
                /*Begin process when add button is clicked*/
                $this->setModel('location_model');
                $this->setMethod('getProvince');
                $this->setIndex('province_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*End process when add button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $this->setModel('person_model');
                $model = $this->var['model'];
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->$model->input_data = $input_data;
                $this->setMethod('addPerson');
                $this->form_validation->set_rules('data[FirstName]','Firstname', 'trim|required');
                $this->form_validation->set_rules('data[LastName]','Lastname', 'trim|required');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                loadComponentPickers();
                /*Begin process when edit button is clicked*/
                /*get the specific person record*/
                $this->setModel('person_model');
                $this->setMethod('getPerson');
                $this->setIndex('person_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*get list of province*/
                $this->setModel('location_model');
                $this->setMethod('getProvince');
                $this->setIndex('province_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*get list of municipalities based on province id*/
                $province_id = $this->var['person_list'][0]['ProvinceID'];
                $this->setMethod('getCityMunicipality');
                $this->setIndex('citymunicipality_list');
                $this->executeMethod(array('type'=>'get','parent_id'=>$province,'active'=>TRUE));
                /*get list of barangay based on citymunicipality id*/
                $citymunicipality_id = $this->var['person_list'][0]['CityMunicipalityID'];
                $this->setMethod('getBarangay');
                $this->setIndex('barangay_list');
                $this->executeMethod(array('type'=>'get','parent_id'=>$citymunicipality_id,'active'=>TRUE));
                /*End process when edit button is clicked*/
                
                /*Begin process when update button is clicked*/
                $this->setModel('person_model');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updatePerson');
                $this->form_validation->set_rules('data[FirstName]','Firstname', 'trim|required');
                $this->form_validation->set_rules('data[LastName]','Lastname', 'trim|required');
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                /*End process when update button is clicked*/
                break;
            default:
                loadAdvancedDataTables();
                /*get person list*/
                $this->setModel('person_model');
                $model = $this->var['model'];
                $this->setMethod('getPerson');
                $this->setIndex('person_list');
                $this->executeMethod(array('type'=>'get'));
        }
        $this->viewPage();
    }
  
    public function searchPerson()
    {
        $pattern = array(',','.',';',':');
        $q = TRIM(str_replace($pattern, ' ', $_GET['q']));
        $arr_q = explode(' ', $q);
        $where = "";
        $i=0;
        foreach($arr_q as $q)
        {
            if($i==0)
            {
                $where .= "(a.`FirstName` LIKE '%$q%' OR a.`MiddleName` LIKE '%$q%' OR a.`LastName` LIKE '%$q%')";
            }
            else
            {
                $where .= " AND (a.`FirstName` LIKE '%$q%' OR a.`MiddleName` LIKE '%$q%' OR a.`LastName` LIKE '%$q%')";
            }
            $i++;
        }
//        $this->load->model('student_model');
        $this->setModel('person_model');
        $this->setMethod('getPerson');
        $this->setIndex('person_list');
        $this->executeMethod(array('type'=>'get','where'=>$where));
        $persons = array();
        foreach($this->var['person_list'] as $row)
        {
            $id = $row['PersonID'];
            $persons[] = array('id'=>$id,'text'=> TRIM($row['LastName'].', '.$row['FirstName'].' '.$row['MiddleName'].' '.$row['ExtensionName']));
        }
        echo json_encode($persons);
    }
    
}
