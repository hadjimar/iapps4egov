<?php 

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author red
 */
Class Main extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        
    }
    public function index()
    {
        $this->setPage(array('view'=>'dashboard','name'=>'dashboard'));
        $this->viewPage();
        
    }
    public function about()
    {
        $this->setPage(array('view'=>'about'));
        $this->viewPage();
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(BASE_URL);
    }
}
