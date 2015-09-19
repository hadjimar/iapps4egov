<?php

/**
 * Description of occupancy_type
 *
 * @author red
 */
Class Occupancy_Type extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'occupancy_type', 'description'=>'view, add, edit, delete occupancy type'));
        $this->load->model('occupancy_type_model');
        $this->setModel('occupancy_type_model');
    }
    
    public function index()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $this->setMethod('addOccupancyType');
                $this->form_validation->set_rules('data[OccupancyTypeName]','Occupancy Type Name', 'trim|required|is_unique[occupancy_type.OccupancyTypeName]');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getOccupancyType');
                $this->setIndex('occupancy_type_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateOccupancyType');
                $this->form_validation->set_rules('data[OccupancyTypeName]','Occupancy Type Name', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getOccupancyType');
                $this->setIndex('occupancy_type_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
}
