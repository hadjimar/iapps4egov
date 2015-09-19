<?php

/**
 * Description of tfo
 *
 * @author red
 */
Class TFO extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'tfo', 'description'=>'view, add, edit, delete tfo and tfo type'));
        $this->var['section_array'] = array(
            array('name'=>'tfo','label'=>'TFO'),
            array('name'=>'tfo_type','label'=>'TFO Type')
        );
        $this->var['section_default'] = 'tfo';
        $this->setSection();
        $this->load->model('tfo_model');
        $this->setModel('tfo_model');
    }
    
    public function index()
    {
        $this->tfo();
    }
    
    public function tfo()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when add button is clicked*/
                loadComponentsDropdowns();
                /*get tfo type for dropdown list*/
                $this->setMethod('getTFOType');
                $this->setIndex('tfo_type_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*End process when add button is clicked*/
                /*Begin process when submit button is clicked*/
                $this->setMethod('addTFO');
                $this->form_validation->set_rules('data[TFOTypeID]','TFO Type Name', 'trim|required');
                $this->form_validation->set_rules('data[TFOName]','TFO Name', 'trim|required|is_unique[tfo.TFOName]');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                loadComponentsDropdowns();
                /*get tfo type for dropdown list*/
                $this->setMethod('getTFOType');
                $this->setIndex('tfo_type_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*get specific record by id*/
                $this->setMethod('getTFO');
                $this->setIndex('tfo_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateTFO');
                $this->form_validation->set_rules('data[TFOTypeID]','TFO Type Name', 'trim|required');
                $this->form_validation->set_rules('data[TFOName]','TFO Name', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getTFO');
                $this->setIndex('tfo_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
    
    public function tfo_type()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $this->setMethod('addTFOType');
                $this->form_validation->set_rules('data[TFOTypeName]','TFO Type Name', 'trim|required|is_unique[tfo_type.TFOTypeName]');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getTFOType');
                $this->setIndex('tfo_type_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateTFOType');
                $this->form_validation->set_rules('data[TFOTypeName]','TFO Type Name', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getTFOType');
                $this->setIndex('tfo_type_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
    /* BEGIN TFO TEMPLATE */
    public function tfo_template()
    {
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $this->setMethod('addTFOTemplate');
                $this->form_validation->set_rules('data[TFOTemplateName]','TFO Template Name', 'trim|required|is_unique[tfo_template.TFOTemplateName]');
                $this->form_validation->set_rules('data[TFOTemplateDescription]','TFO Template Description', 'trim|required');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                /*get specific record by id*/
                $this->setMethod('getTFOTemplate');
                $this->setIndex('tfo_template_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateTFOTemplate');
                $this->form_validation->set_rules('data[TFOTemplateName]','TFO Template Name', 'trim|required');
                $this->form_validation->set_rules('data[TFOTemplateDescription]','TFO Template Description', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getTFOTemplate');
                $this->setIndex('tfo_template_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
}
