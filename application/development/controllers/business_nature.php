<?php

/**
 * Description of business_nature
 *
 * @author red
 */
Class Business_Nature extends MY_Controller
{
    /*define default model*/
    public $model = 'business_nature_model';
    public function __construct() 
    {
        parent::__construct();
        $this->setPage(array('view'=>'masterlist', 'name'=>'business_nature', 'description'=>'view, add, edit, delete business nature'));
        $this->var['section_array'] = array(
            array('name'=>'business_nature','label'=>'Business Nature'),
            array('name'=>'business_nature_template_schedule','label'=>'', 'hidden'=>TRUE)
        );
        $this->var['section_default'] = 'business_nature';
        $this->setSection();
        $this->load->model($this->model);
        $this->load->model('business_tfo_template_model');
    }
    
    public function index()
    {
        $this->business_nature();
    }
    
    public function business_nature()
    {
        $this->setModel($this->model);
        
        switch($this->var['action'])
        {
            case 'add':
                loadComponentsDropdowns();
                /*Begin process when submit button is clicked*/
                $this->setMethod('addBusinessNature');
                $this->form_validation->set_rules('data[PSIC]','PSIC', 'trim');
                $this->form_validation->set_rules('data[BusinessNatureName]','Business Nature Name', 'trim|required|is_unique[business_nature.BusinessNatureName]');
                $this->form_validation->set_rules('data[BusinessNatureDescription]','Business Nature Description', 'trim');
                $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                /*End process when submit button is clicked*/
                break;
            case 'edit':
                /*Begin process when edit button is clicked*/
                loadComponentsDropdowns();
                /*get specific record by id*/
                $this->setMethod('getBusinessNature');
                $this->setIndex('business_nature_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                /*End process when edit button is clicked*/
                
                /*Begin process when submit button is clicked*/
                if($this->input->post('data'))
                {
                    $input_data = $this->input->post('data') ? $this->input->post('data') : array();
                    if(isset($input_data['TFOTemplateID']))
                    {
                        foreach($input_data['TFOTemplateID'] as $template_id)
                        {
                            $input_data2 = array('BusinessNatureID'=>$this->var['id'],'TFOTemplateID'=>$template_id,'Active'=>1);
                        }
                    }
                    unset($input_data['TFOTemplateID']);
                    $this->setMethod('updateBusinessNature');
                    $this->form_validation->set_rules('data[BusinessNatureName]','Business Nature Name', 'trim|required');
                    $this->form_validation->run()==TRUE ?   $this->executeMethod(array('type'=>'update','id'=>$this->var['id'],'input'=>$input_data)) : NULL;
                }
                /*End process when submit button is clicked*/
                break;
            default:
                /*Load Data Table*/
                loadAdvancedDataTables();
                /*get all records*/
                $this->setMethod('getBusinessNature');
                $this->setIndex('business_nature_list');
                $this->executeMethod(array('type'=>'get'));
                break;
        }
        $this->viewPage();
    }
    
    public function business_nature_template_schedule()
    {
        $this->setModel($this->model);
        /*get business nature detail*/
        $this->setMethod('getBusinessNature');
        $this->setIndex('business_nature_list');
        $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
        /*get available tfo template for dropdown list*/
        $this->setMethod('getAvailableTFOTemplate');
        $this->setIndex('tfo_template_list');
        $this->executeMethod(array('type'=>'get','parent_id'=>$this->var['id']));
        
        switch($this->var['action'])
        {
            case 'add':
                /*get available tfo template for dropdown list*/
                if($this->input->post('data'))
                {
                    $this->form_validation->set_rules('data[TFOTemplateID]','trim');
                    $data = $this->input->post('data');
                    foreach($data['TFOTemplateID'] as $template_id)
                    {
                        $input_data[] = array ('TFOTemplateID'=>$template_id, 'BusinessNatureID'=>$this->var['id'], 'Active'=>1);
                    }
                    $this->setMethod('addBusinessNatureTemplateSchedule');
                    $this->form_validation->run()==TRUE ? $this->executeMethod(array('type'=>'add','input'=>$input_data)) : NULL;
                }
                break;
            case 'edit':
                $this->setMethod('getBusinessNatureTemplateSchedule');
                $this->setIndex('business_nature_template_schedule_list');
                $this->executeMethod(array('type'=>'get','id'=>$this->var['id']));
                break;
            default:
                loadAdvancedDataTables();
                $this->setMethod('getBusinessNatureTemplateSchedule');
                $this->setIndex('business_nature_template_schedule_list');
                $this->executeMethod(array('type'=>'get','parent_id'=>$this->var['id']));
        }
        
        $this->viewPage();
    }
}
