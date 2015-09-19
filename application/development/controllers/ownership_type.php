<?php

/**
 * Description of ownership_type
 *
 * @author red
 */
Class Ownership_Type extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'ownership_type', 'description'=>'view, add, edit, delete ownership type'));
        $this->load->model('ownership_type_model');
        $this->setModel('ownership_type_model');
    }
    
    public function index()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $this->setMethod('addOwnershipType');
                $this->form_validation->set_rules('data[OwnershipTypeName]','Ownership Type Name', 'trim|required|is_unique[ownership_type.OwnershipTypeName]');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getOwnershipType');
                $this->setIndex('ownership_type_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateOwnershipType');
                $this->form_validation->set_rules('data[OwnershipTypeName]','Ownership Type Name', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getOwnershipType');
                $this->setIndex('ownership_type_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
}
