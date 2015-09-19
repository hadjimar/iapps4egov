<?php

/**
 * Description of business_requirement
 *
 * @author red
 */
Class Business_Requirement extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'business_requirement', 'description'=>'view, add, edit, delete ownership type'));
        $this->load->model('business_requirement_model');
        $this->load->model('requirement_model');
        
    }
    
    public function index()
    {
        switch($this->var['action'])
        {
            case 'add':
                loadComponentsDropdowns();
                $this->setModel('requirement_model');
                $this->setMethod('getRequirement');
                $this->setIndex('requirement_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*Begin process when submit button is clicked*/
                $this->setModel('business_requirement_model');
                $this->setMethod('addBusinessRequirement');
                $this->form_validation->set_rules('data[TransactionType]','Transaction', 'trim|required');
                $this->form_validation->set_rules('data[RequirementID]','Requirement Name', 'trim|required');
                if($this->input->post('data'))
                {
                    /*set input data*/
                    $data = $this->input->post('data');
                    foreach($data['RequirementID'] as $requirement)
                    {
                        $input_data[]= array(
                            'TransactionType' => $data['TransactionType'],
                            'RequirementID' => $requirement,
                            'Active' => 1
                        );
                    }
                    $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                }
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                loadComponentsDropdowns();
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setModel('business_requirement_model');
                $this->setMethod('getBusinessRequirement');
                $this->setIndex('business_requirement_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                
                $this->setModel('requirement_model');
                $this->setMethod('getRequirement');
                $this->setIndex('requirement_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $this->form_validation->set_rules('data[TransactionType]','Transaction', 'trim|required');
                $this->form_validation->set_rules('data[RequirementID]','Requirement Name', 'trim|required');
                if($this->input->post('data'))
                {
                    /*set input data*/
                    $data = $this->input->post('data');
                    foreach($data['RequirementID'] as $requirement)
                    {
                        $input_data[]= array(
                            'TransactionType' => $data['TransactionType'],
                            'RequirementID' => $requirement,
                            'Active' => isset($data['Active']) ? $data['Active'] : 0
                        );
                    }
                    $this->setModel('business_requirement_model');
                    $this->setMethod('updateBusinessRequirement');
                    $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                }
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setModel('business_requirement_model');
                $this->setMethod('getBusinessRequirement');
                $this->setIndex('business_requirement_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
}
