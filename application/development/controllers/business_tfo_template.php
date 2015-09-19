<?php

/**
 * Description of tfo
 *
 * @author red
 */
Class Business_TFO_Template extends MY_Controller
{
    public $model;
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'business_tfo_template', 'description'=>'view, add, edit, delete business tfo template and tfo schedule'));
        $this->var['section_array'] = array(
            array('name'=>'business_tfo_template','label'=>'TFO Template'),
            array('name'=>'business_tfo_schedule','label'=>'', 'hidden'=>TRUE),
            array('name'=>'tfo_template_test','label'=>'', 'hidden'=>TRUE)
        );
        $this->var['section_default'] = 'business_tfo_template';
        $this->setSection();
        $this->model = 'business_tfo_template_model';
        $this->load->model($this->model);
        $this->load->model('tfo_model');
        
    }
    /* BEGIN TFO TEMPLATE */
    public function index()
    {
        $this->business_tfo_template();
    }
    
    public function business_tfo_template()
    {
        $this->setModel($this->model);
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when submit button is clicked*/
                $this->setMethod('addTFOTemplate');
                $this->form_validation->set_rules('data[TFOTemplateName]','TFO Template Name', 'trim|required|is_unique[business_tfo_template.TFOTemplateName]');
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
    
    /*BEGIN TFO SCHEDULE*/
    public function business_tfo_schedule()
    {
        
        /*GET TFO*/
        $this->setModel('tfo_model');
        $this->setMethod('getTFO');
        $this->setIndex('tfo_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        /*End process when add button is clicked*/
                
        /*Get Available Variables */
        $this->setModel($this->model);
        $this->setMethod('getVariables');
        $this->setIndex('tfo_variable_list');
        $this->executeMethod(array('type'=>'get'));
        /*End process when add button is clicked*/
        
        switch($this->var['action'])
        {
            case 'add':
                /*Begin process when add button is clicked*/
                loadBusinessFunctions();
                /*Begin process when submit button is clicked*/
                $this->setModel($this->model);
                if($this->input->post('data'))
                {
                    $this->form_validation->set_rules('data[TransactionType]','Transaction', 'trim|required');
                    $this->form_validation->set_rules('data[TFOID]','TFO', 'trim|required');
                    $this->form_validation->set_rules('data[Basis]','Basis', 'trim|required');
                    $this->form_validation->set_rules('data[ModeOfComputation]','Mode of Computation', 'trim|required');
                    $data = $this->input->post('data');
                    $input_data = array();
                    if(isset($data['Range']))
                    {
                        foreach($data['Range'] as $range)
                        {
                            $input_data[] = array(
                                'TFOScheduleID'=> str_pad($this->var['id'], 5, '0', STR_PAD_LEFT).'-'.str_pad($data['TFOID'], 5, '0', STR_PAD_LEFT).'-'.$data['TransactionType'],
                                'TFOTemplateID'=>$this->var['id'],
                                'TFOID'=>$data['TFOID'],
                                'TransactionType'=>$data['TransactionType'],
                                'Basis'=>$data['Basis'],
                                'ModeOfComputation'=>$data['ModeOfComputation'],
                                'MinimumAmount'=>$data['MinimumAmount'],
                                'UnitOfMeasure'=>isset($data['UnitOfMeasure']) ? $data['UnitOfMeasure'] : NULL,
                                'RangeNumber'=>$range['RangeNumber'],
                                'LowerLimit'=>$range['LowerLimit'],
                                'HigherLimit'=>$range['HigherLimit'],
                                'Amount'=>$range['Amount'],
                                'Formula'=>$range['Formula'],
                                'Active'=>1
                                );
                        }
                        $this->setMethod('addBatchTFOSchedule');
                        $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                        
                    }
                    else
                    {
                        $input_data = $data;
                        $input_data['TFOScheduleID'] = str_pad($this->var['id'], 5, '0', STR_PAD_LEFT).'-'.str_pad($input_data['TFOID'], 5, '0', STR_PAD_LEFT).'-'.$input_data['TransactionType'];
                        $input_data['TFOTemplateID'] = $this->var['id'];
                        $input_data['Active'] = 1;
                        $this->setMethod('addTFOSchedule');
                        $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                    }
                }
                
                
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                loadBusinessFunctions();
                /*GET TFO*/
                $this->setModel('tfo_model');
                $this->setMethod('getTFO');
                $this->setIndex('tfo_list');
                $this->executeMethod(array('type'=>'get','active'=>TRUE));
                /*End process when add button is clicked*/
                /*get specific record by id*/
                $this->setModel($this->model);
                $this->setMethod('getTFOSchedule');
                $this->setIndex('business_tfo_schedule_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->setMethod('updateTFOSchedule');
                $this->form_validation->set_rules('data[TFOScheduleName]','TFO Schedule Name', 'trim|required');
                $this->form_validation->set_rules('data[TFOScheduleDescription]','TFO Schedule Description', 'trim|required');
                $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                                
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get template detail */
                $this->setModel($this->model);
                $this->setMethod('getTFOTemplate');
                $this->setIndex('tfo_template_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*get tfo schedule */
                $this->setModel($this->model);
                $this->setMethod('getTFOSchedule');
                $this->setIndex('business_tfo_schedule_list');
                $this->executeMethod(array('type'=>'get','parent_id'=>$this->var['id']));
                break;
        }
        $this->viewPage();
    }
    /*END TFO SCHEDULE*/
    
    /*BEGIN TEMPLATE TEST*/
    public function tfo_template_test()
    {
        loadComponentsDropdowns();
        $this->viewPage();
    }
    /*END TEMPLATE TEST*/
    /*Begin utility methods use with Javascript functions*/
    public function getAvailableTFO()
    {
        $transaction = $this->input->post('transaction');
        $template_id = $this->input->post('template_id');
        $query = "SELECT * FROM `TFO` WHERE `TFOID` NOT IN (SELECT `TFOID` FROM `business_tfo_schedule` WHERE `TFOTemplateID` = '$template_id' AND `TransactionType` = '$transaction') AND `Active` = 1";
        $this->crud->query = $query;
        $this->crud->readByCustomQuery();
//        echo json_encode($this->crud->result_data);
        $tfo_list = array();
        foreach($this->crud->result_data as $row)
        {
            $id = $row['TFOID'];
            $tfo_list[] = array('id'=>$id,'text'=> $row['TFOName']);
        }
        echo json_encode($tfo_list);
        
    }
    public function getAvailableVariables()
    {
        $transaction = $this->input->post('transaction');
        $template_id = $this->input->post('template_id');
        $query = "SELECT * FROM `TFO` WHERE `TFOID` IN (SELECT `TFOID` FROM `business_tfo_schedule` WHERE `TFOTemplateID` = '$template_id' AND `TransactionType` = '$transaction') AND `Active` = 1";
        $this->crud->query = $query;
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            echo json_encode($this->crud->result_data);
        }
        else
        {
            return FALSE;
        }
    }
    /*End utility methods use with Javascript functions*/
}
