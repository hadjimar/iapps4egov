<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Debug
 *
 * @author red
 */
Class Debug extends MY_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        parent::__construct();
        $this->load->model('teacher_model');
        $this->setPage(array('view'=>'debug', 'name'=>'debug', 'description'=>'page for testing and debugging source code'));
    }
    
    public function index()
    {
        $this->teacher_model->addTeacher();
        $this->var['testdata'] = $this->teacher_model->teacher_list;
    }
}
