<?php

/**
 * Description of citizenship
 *
 * @author red
 */
Class Citizenship extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'citizenship', 'description'=>'view, add, edit, delete ownership type'));
        $this->load->model('citizenship_model');
        $this->setModel('citizenship_model');
    }
    
    public function index()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $this->setMethod('addCitizenship');
                $this->form_validation->set_rules('data[CitizenshipName]','Ownership Type Name', 'trim|required|is_unique[citizenship.CitizenshipName]');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getCitizenship');
                $this->setIndex('citizenship_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateCitizenship');
                $this->form_validation->set_rules('data[CitizenshipName]','Ownership Type Name', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getCitizenship');
                $this->setIndex('citizenship_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
}
