<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is the main controller. 
 * It extends the CI Controller and all the other sub controllers are linked here.
 * @author RedCrisostomo
 */
class MY_Controller extends CI_Controller
{
    /*DEFINE VARIABLES*/
    public $var;
    public $uri_params;
    public $crud;
    public $RKtable;
    public $log;
    public function __construct() 
    {
        parent::__construct();
       /*LOAD THE DEFAULT JAVASCRIPT AND CSS*/
        loadDefaultCSS();
        loadDefaultJS();
        loadCustomJSCSS();
        loadToastrNotification();
       
        
        /*SET VALUE OF GLOBAL VARIABLES*/
        $this->crud = new Crud();
        $this->uri_params = $this->uri->uri_to_assoc(3);
        
        $this->var['SYSTEM_NAME'] = 'Integrated Application System for eGovernance';
        $this->var['SYSTEM_ABBR'] = 'iApps4eGov';
        $this->var['action'] = isset($this->uri_params['action']) ? $this->uri_params['action'] : 'view';
        $this->var['id'] = isset($this->uri_params['id']) ? $this->uri_params['id'] : 0;
        $this->var['page_url'] = BASE_URL.$this->router->fetch_class().'/';
        $this->var['section_url'] = $this->var['page_url'].($this->router->fetch_method() ? $this->router->fetch_method().'/' : NULL);
        
        /*LOGIN*/
        if($this->input->post('btn_login'))
        {
            $this->form_validation->set_rules('data[User]','Username or Email', 'trim|required');
            $this->form_validation->set_rules('data[Password]','Password', 'trim|required');
            $input_data = $this->input->post('data');
            $this->form_validation->run()==TRUE ? $this->_login($input_data) : NULL;
//            $this->var['user'] = $this->input->post('txt_user') ? $this->input->post('txt_user') : NULL;
//            $this->var['password'] = $this->input->post('txt_password') ? md5($this->input->post('txt_password')) : NULL;
//            $this->_login($input_data);
        }
        /*Set the user_id when session is set*/
        $this->var['user_id'] = $this->session->userdata('ifoure_user_id') ? $this->session->userdata('ifoure_user_id') : NULL;
        /*Set the user_role_id when session is set*/
        $this->var['user_role_id'] = $this->session->userdata('ifoure_user_role_id') ? $this->session->userdata('ifoure_user_role_id') : NULL;
        /*Set Sidebar Menu*/
        $this->_getSidebarMenu();
        
        /*restrict access to pages if not super admin*/
        if($this->router->fetch_class() && $this->router->fetch_class()!='main')
        {
            if(!$this->_defineRouteAccess($this->router->fetch_class().($this->router->fetch_method() && $this->router->fetch_method()!='index' ? '/'.$this->router->fetch_method() : NULL)))
            {
                redirect(BASE_URL);
            }
        }
//        $this->output->enable_profiler(TRUE);
    }
    
    /* END METHODS USE EXCLUSIVELY BY MAIN CONTROLLER */
    
    /**
     * Login
     * @access private
     * @return boolean
     */
    private function _login($params=array())
    {
//        echo "<script>alert('".json_encode($params)."')</script>";
        if(!isset($params['User']) OR !isset($params['Password'])){return FALSE;}
        $this->setModel('user_model');
        $model = $this->var['model'];
        /*get user info if valid user*/
        $this->$model->user = $params['User'];
        $this->$model->password = md5($params['Password']);
        
        $this->setMethod('getUser');
        $this->setIndex('user_list');
        $this->executeMethod(array('type'=>'get','active'=>TRUE));
        /*if found valid*/
        if(isset($this->var['user_list']) && count($this->var['user_list'])>0)
        {
            if(crypt($params['Password'],$this->var['user_list'][0]['EncryptionKey'])==$this->var['user_list'][0]['Salt'])
            {
                /*update last login*/
                $this->$model->id = $this->var['user_list'][0]['UserID'];
                $this->setMethod('setLastLogin');
                $this->executeMethod(array('type'=>'update'));

                /*set session data*/
                $newsession = array(
                    'ifoure_user_id'  => $this->var['user_list'][0]['UserID'],
                    'ifoure_user_role_id' => $this->var['user_list'][0]['UserRoleID'],
                    'ifoure_person_id' => $this->var['user_list'][0]['PersonID'],
                    'ifoure_fullname' => $this->var['user_list'][0]['FirstName'].' '.$this->var['user_list'][0]['LastName'],
                    'ifoure_profile_pic' => $this->var['user_list'][0]['ProfilePicture'],
                    'ifoure_email'     => $this->var['user_list'][0]['UserEmail'],
                    'ifoure_is_logged' => TRUE
                );
                $this->session->set_userdata($newsession);
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }
    
    /**
     * Logout
     * @access public
     */
    public function logout()
    {
        $this->session->unset_userdata();
        redirect(BASE_URL);
    }
    
    /**
     * Get Sidebar Menu
     * @access private
     */
    private function _getSidebarMenu()
    {
        $this->setModel('usermenu_model');
        $model = $this->var['model'];
        $this->$model->user_role_id = isset($this->var['user_role_id']) ? $this->var['user_role_id'] : 0;
        $this->setMethod('getSidebarMenu');
        $this->setIndex('sidebar_menu_list');
        $this->executeMethod(array('type'=>'get'));
        return;
//        echo json_encode($this->var['sidebar_menu_list']);
    }
    
    /**
     * Method to restrict access to pages
     * @access private
     * @param type $route
     * @return boolean
     */
    private function _defineRouteAccess($route)
    {
        if(!isset($this->var['user_role_id'])){return FALSE;}
        $user_role_id = isset($this->var['user_role_id']);
        if($user_role_id==1)
        {
            return TRUE;
        }
        else
        {
            $this->crud->query = "SELECT `Page` FROM `user_role_access` WHERE `UserRoleID` = $user_role_id";
            $this->crud->readByCustomQuery();
            $page_access = $this->crud->result_data;
            $access = array();
            foreach($page_access as $row)
            {
                $access[] = $row['Page'];
            }
            if(!in_array($route, $access)) {return FALSE; }
            return TRUE;
        }
    }
    /* END METHODS USE EXCLUSIVELY BY MAIN CONTROLLER */
    
    /* END METHODS USE BY SUB CONTROLLERS TO VIEW PAGE, SET MODULE, PAGE AND SECTION */
    
    /**
     * View the page
     * @access public
     */
    public function viewPage()
    {
        self::setModule();
        $this->load->vars($this->var);
        if($this->session->userdata('ifoure_is_logged')==TRUE)
        {
            if(!isset($this->module) && $this->var['user_role_id']>1)
            {
//                $this->load->view('index');
                $this->load->view('main');
            }
            else
            {
                $this->load->view('main');
            }
        }
        else
        {
            $this->load->view('login');
        }
//        if($this->module && $this->module != 'main')
//        {
//            $this->load->view('main/dashboard');
//        }
//        else
//        {
//            $this->load->view('main/index');
//        }
    }
    
    /**
     * Set the Page
     * @access public
     * @param string $params['view']  The page to view
     * @param string $params['name']  The name of page that will appear to page header
     * @param string $params['description']  The description of page that will appear to page header
     * @return void
     */
    public function setPage($params=array('view'=>NULL, 'name'=>NULL, 'description'=>NULL))
    {
        $this->var['page_view'] = isset($params['view']) && strlen($params['view'])>0 ? $params['view'] : $this->router->fetch_method();
        $this->var['page_name'] = isset($params['name']) && strlen($params['name'])>0 ? $params['name'] : $this->router->fetch_method();
        $this->var['page_description'] = isset($params['description']) && strlen($params['description'])>0 ? $params['description'] : NULL;
        return;
    }
    /**
     * Set the Module
     * @access public
     * @param type $module
     * @return type
     */
    public function setModule($module=NULL)
    {
        $this->var['module'] = $this->router->fetch_class() ? $this->router->fetch_class() : $module;
        return;
    }
    /**
     * Set the section Use this if you have different sections on your controller
     * @access public
     * @see views/masterlist.php
     * @return boolean
     */
    public function setSection()
    {
        if(!isset($this->var['section_array'])) {return FALSE;}
        $this->var['section'] = $this->router->fetch_method() && $this->router->fetch_method()!= 'index' ? $this->router->fetch_method() : $this->var['section_default'];
        return;
    }
    /* END METHODS USE BY SUB CONTROLLERS TO VIEW PAGE, SET MODULE, PAGE AND SECTION */
    
    /*BEGIN METHODS USE IN SUB-CONTROLLERS TO EXECUTE ADDING, EDITING, VIEWING OF RECORDS */
    /**
     * Set the Error Message
     * @access private
     * @param string $data  The record to be added or updated that will appear on error message
     * @param boolean $success The type of error message to appear.  TRUE if success and FALSE if failed.
     * @return void
     */
    private function _setErrorMessage($success=NULL)
    {
        if($success==TRUE)
        {
            if(isset($this->var['action']) && $this->var['action']=='add')
            {
                $this->var['err_message'] = array('type'=>'success', 'heading'=>'SUCCESS!', 'content'=>'Record has been successfully added');
            }
            elseif(isset($this->var['action']) && $this->var['action']=='edit')
            {
                $err_action = 'updated';
                $this->var['err_message'] = array('type'=>'success', 'heading'=>'SUCCESS!', 'content'=>'Record has been successfully updated');
            }
        }
        elseif($success==FALSE)
        {
            if(isset($this->var['action']) && $this->var['action']=='add')
            {
                $err_action = 'adding';
                $this->var['err_message'] = array('type'=>'error', 'heading'=>'ERROR!', 'content'=>'Error in adding record');
            }
            elseif(isset($this->var['action']) && $this->var['action']=='edit')
            {
                $err_action = 'updating';
                $this->var['err_message'] = array('type'=>'error', 'heading'=>'ERROR!', 'content'=>'Error in updating record');
            }
        }
        return;
    }
    
    /**
     * Execute Method
     * @access public
     * @see setModel(), setMethod(), setIndex(), _setErrorMessage()
     * @param string $params[type]  The type of method.  Either add, edit, or get.
     * @param string $params[input] The value/s of record to be added or updated
     * @param string $params[active] The status of record to fetch if active or not(soft deleted)
     * @param string $params[where]  The where clause for filtering data
     * @return void
     */
    public function executeMethod($params = array())
    {
        $type = isset($params['type']) ? $params['type'] : NULL;
        $index = $this->var['index'];
        $model_name = $this->var['model'];
        $method = $this->var['method'];
        $this->$model_name->id = isset($params['id']) ? $params['id'] : 0 ;
        if(isset($this->$model_name->parent_id))
        {
            $this->$model_name->parent_id = isset($params['parent_id']) ? $params['parent_id'] : 0 ;
        }
        if($type=='add')
        {
            if(!isset($params['input']))
            {
                $this->_setErrorMessage(FALSE);
                return FALSE;
            }
            else
            {
                $this->$model_name->input_data = $params['input'];
                if($this->$model_name->$method())
                {
                    $this->_setErrorMessage(TRUE);
                    return TRUE;
                }
                $this->_setErrorMessage(FALSE);
                return FALSE;
            }
        }
        elseif($type=='update')
        {
            if(!isset($params['input']) OR !isset($params['id']))
            {
                $this->_setErrorMessage(FALSE);
                return FALSE;
            }
            else
            {
                $this->$model_name->input_data = $params['input'];
                if($this->$model_name->$method())
                {
                    $this->_setErrorMessage(TRUE);
                    return TRUE;
                }
                $this->_setErrorMessage(FALSE);
                return FALSE;
            }
        }
        elseif($type=='get')
        {
            $this->$model_name->where = isset($params['where']) ? $params['where'] : NULL;
            $this->$model_name->$method(isset($params['active']) ? $params['active'] : NULL);
            $this->var[$index] = $this->$model_name->list;
        }
        return;
    }
    /**
     * Set the model name
     * @access public
     * @param string $model  The name of model
     * @return boolean/void  Set the return value to index ('model') of global variable $var
     */
    public function setModel($model=NULL)
    {
        if(strlen($model)==0){return FALSE;}
        $this->var['model'] = $model;
        return;
    }
    
    /**
     * Set the method
     * @access public
     * @param string $method The name of method
     * @return boolean Set the return value to index ('method') of global variable $var
     */
    public function setMethod($method=NULL)
    {
        if(strlen($method)==0){return FALSE;}
        $this->var['method'] = $method;
        return;
    }
    
    /**
     * Set the index key.  This is used to setup index key of data when the executeMethod is used
     * @access public
     * @param type $index  The name of index
     * @return void
     */
    public function setIndex($index=NULL)
    {
        if(strlen($index)==0){return FALSE;}
        $this->var['index'] = $index;
        return;
    }
    
    /*END METHODS USE IN SUB-CONTROLLERS TO EXECUTE ADDING, EDITING, VIEWING OF RECORDS*/
    
    /* BEGIN METHODS USE WITH JAVASCRIPT */
    /**
     * Set the record status to active and not active
     * @access public
     * @see assets/custom/[ENVIRONMENT]/scripts/function.js
     */
    public function setActive()
    {
        $this->crud->audit_trail = true;
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->input->post('id');
        $this->crud->table = $this->input->post('dbtable');
        $this->crud->where = array($this->input->post('keyfield')=>$this->input->post('id'));
        $this->crud->input_data = array('Active' =>  $this->input->post('value'));
        if($this->crud->setActive())
        {
            echo $this->input->post('keyfield')." #".$this->input->post('id')." has been set to ".($this->input->post('value')==0 ? "NOT ACTIVE" : "ACTIVE");
//            echo json_encode($this->crud->audit_trail_result);
        }
        else
        {
            echo "Error in updating ".$this->input->post('object')." ".$this->input->post('details');
        }
    }
    
    
    /**
     * Get the Children Data
     * @access public
     * @see assets/custom/[ENVIRONMENT]/scripts/function.js
     */
    public function getChildrenData()
    {
        $this->crud->table = $this->input->post('dbtable');
        $this->crud->where = array($this->input->post('parent_dbfield')=>$this->input->post('parent_id'),'Active'=>'1');
        $this->crud->read();
        if(count($this->crud->result_data)>0)
        {
            echo json_encode($this->crud->result_data);
        }
        else
        {
            echo "No record found!";
        }
    }
    /* END METHODS USE WITH JAVASCRIPT */
    
}
