<?php

/**
 * Description of Menu_Model
 *
 * @author RedCrisostomo
 */
Class Usermenu_Model extends CI_Model 
{
    public $crud;
    public $id = 0;
    public $user_role_id = 0;
    public $list = array();
    public $parent_id = 0;
    private $parent_menu_list = array();
    private $sub_menu_list = array();
    public function __construct() 
    {
        parent::__construct();
        $this->crud = new Crud();
        $this->crud->audit_trail = $this->config->item('audit_trail');
        $this->crud->audit_trail_settings['table'] = $this->config->item('audit_trail_table');
        $this->crud->audit_trail_settings['user_id'] = $this->session->userdata('ifoure_user_id');
        $this->crud->audit_trail_settings['record_id'] = $this->id>0 ? $this->id : NULL;
    }
    public function getUsermenuByID()
    {
        if($this->id>0)
        {
            $this->crud->where = "`MenuID` = $this->id";
        }
        $this->crud->table = "user_menu";
        $this->crud->read();
        $this->list = $this->crud->result_data;
    }
    /**
     * Get All Menu
     * @return void
     */
    public function getUsermenu($active=NULL)
    {
        /*Ensure that the menu list is empty*/
        $this->_clearMenu();
        /*Set the value of data filter. Get the parent menu first*/
        $where = "";
        if($active)
        {
            $where .= "`Active` = 1";
        }
        
        $where .= strlen($where)>0 ? " AND `MenuParentID` = 0" : "`MenuParentID` = 0";
        $this->crud->where = $where;
        $this->crud->order_by = 'MenuOrder asc';
        /*Set the database table*/
        $this->crud->table = 'user_menu';
        /*Get the data*/
        $this->crud->read();
        /*Put the fetched parent menu data into the main menu list*/
        $this->parent_menu_list = $this->crud->result_data;
        $i=0;
        /*Loop through each parent menu*/
        foreach($this->parent_menu_list as $row)
        {
            if($row['MenuType']=='page')
            {
                $row['Permalink'] = BASE_URL.$row['Permalink'];
            }
            elseif($row['Permalink']=='#')
            {
                $row['Permalink'] = 'javascript:;';
            }
            /*Add each row into the menu list*/
            $this->list[$i] = $row;
            /*Set the value of parent id*/
            $this->parent_id = $row['MenuID'];
            /*Set the filter*/
            $where2 = "";
            if($active)
            {
                $where2 .= "`Active` = 1";
            }
            $where2 .= strlen($where2)>0 ? " AND `MenuParentID` = $this->parent_id" : "`MenuParentID` = $this->parent_id";
            $this->crud->where = $where2;
            /*Set the database table*/
            $this->crud->table = 'user_menu';
            /*Get the sub menu data*/
            $this->crud->read();
            /*Put the fetched sub menu data into sub menu list*/
            $this->sub_menu_list = $this->crud->result_data;
            $a=0;
            if(count($this->sub_menu_list)>0)
            {
                /*Loop through each sub menu */
                foreach($this->sub_menu_list as $row)
                {
                    if($row['MenuType']=='page')
                    {
                        $row['Permalink'] = BASE_URL.$row['Permalink'];
                    }
                    elseif($row['Permalink']=='#')
                    {
                        $row['Permalink'] = 'javascript:;';
                    }
                    /*Add each row into the menu list*/
                    $this->list[$i]['SubMenu'][$a] = $row;
                    /*Set the value of parent id*/
                    $grandchild_parent_id = $row['MenuID'];
                    /*Set the filter*/
                    $where3 = "";
                    if($active)
                    {
                        $where3 .= "`Active` = 1";
                    }
                    $where3 .= strlen($where3)>0 ? " AND `MenuParentID` = $grandchild_parent_id" : "`MenuParentID` = $grandchild_parent_id";
                    $this->crud->where = $where3;
                    /*Set the database table*/
                    $this->crud->table = 'user_menu';
                    /*Get the sub menu data*/
                    $this->crud->read();
                    /*Put the fetched sub menu data into sub menu list*/
                    $grandchild_menu_list = $this->crud->result_data;
                    if(count($grandchild_menu_list)>0)
                    {
                        $b=0;
                        /*Loop through each sub menu */
                        foreach($grandchild_menu_list as $row)
                        {
                            if($row['MenuType']=='page')
                            {
                                $row['Permalink'] = BASE_URL.$row['Permalink'];
                            }
                            elseif($row['Permalink']=='#')
                            {
                                $row['Permalink'] = 'javascript:;';
                            }
                            /*Add each row into the menu list*/
                            $this->list[$i]['SubMenu'][$a]['GrandchildMenu'][$b] = $row;
                            $b++;
                        }
                    }
                    $a++;
                }
            }
            $i++;
        }
        return;
    }
    /**
     * Get Sidebar Menu
     * @param boolean $active
     * @return void
     */
    public function getSidebarMenu()
    {
        /*Ensure that the menu list is set to empty first*/
        $this->_clearMenu();
        /*Get the main menu */
        if($this->user_role_id==1)
        {
            $this->getUsermenu(TRUE);
        }
        else
        {
            /*get dashboard menu*/
            $this->crud->query = "SELECT `MenuID`,`MenuName`,`MenuType`,`Permalink`,`MenuOrder`,`MenuIcon` FROM `user_menu` WHERE `MenuName` = 'dashboard'";
            $this->crud->readByCustomQuery();
            $default_menu = $this->crud->result_data;
            $this->list = $default_menu;
            
            /*get parent menus*/
            $this->crud->query = "SELECT `MenuID`,`MenuName`,`MenuType`,`Permalink`,`MenuOrder`,`MenuIcon` FROM `user_menu` WHERE `MenuID` IN(SELECT DISTINCT a.`MenuParentID` FROM `user_menu` a JOIN `user_role_access` b ON a.`Permalink`=b.`Page` WHERE b.`UserRoleID` = '$this->user_role_id' AND a.`MenuType`='page' AND a.`Active`=1) AND `MenuParentID` = 0 ORDER BY `MenuOrder` ASC";
            $this->crud->readByCustomQuery();
            $parent_menus = $this->crud->result_data;
            
            
            
            /*attach sub menus to parent menus*/
            $a=1;
            foreach($parent_menus as $parent)
            {
                if($parent['MenuType']=='page')
                {
                    $parent['Permalink'] = BASE_URL.$parent['Permalink'];
                }
                elseif($parent['Permalink']=='#')
                {
                    $parent['Permalink'] = 'javascript:;';
                }
                $this->list[$a] = $parent;
                $parent_id = $parent['MenuID'];
                /*get sub menus*/
                $this->crud->query = "SELECT `MenuParentID`,`MenuID`,`MenuName`,`MenuType`,`Permalink`,`MenuOrder`,`MenuIcon` FROM `user_menu` WHERE `MenuID` IN(SELECT DISTINCT a.`MenuID` FROM `user_menu` a JOIN `user_role_access` b ON a.`Permalink`=b.`Page` WHERE b.`UserRoleID` = '$this->user_role_id' AND a.`MenuType`='page' AND a.`Active`=1) AND `MenuParentID` = '$parent_id' ORDER BY `MenuOrder` ASC";
                $this->crud->readByCustomQuery();
                $sub_menus = $this->crud->result_data;
                $b=0;
                foreach($sub_menus as $sub)
                {
                    if($sub['MenuType']=='page')
                    {
                        $sub['Permalink'] = BASE_URL.$sub['Permalink'];
                    }
                    elseif($sub['Permalink']=='#')
                    {
                        $sub['Permalink'] = 'javascript:;';
                    }
                    $this->list[$a]['SubMenu'][$b] = $sub;
                    $parent_submenu_id = $sub['MenuID'];
                    /*get sub menus*/
                    $this->crud->query = "SELECT `MenuParentID`,`MenuID`,`MenuName`,`MenuType`,`Permalink`,`MenuOrder`,`MenuIcon` FROM `user_menu` WHERE `MenuID` IN(SELECT DISTINCT a.`MenuID` FROM `user_menu` a JOIN `user_role_access` b ON a.`Permalink`=b.`Page` WHERE b.`UserRoleID` = '$this->user_role_id' AND a.`MenuType`='page' AND a.`Active`=1) AND `MenuParentID` = '$parent_submenu_id' ORDER BY `MenuOrder` ASC";
                    $this->crud->readByCustomQuery();
                    $grandchild_menus = $this->crud->result_data;
                    if(count($grandchild_menus)>0)
                    {
                        $c=0;
                        foreach($grandchild_menus as $grandchild)
                        {
                            if($grandchild['MenuType']=='page')
                            {
                                $grandchild['Permalink'] = BASE_URL.$grandchild['Permalink'];
                            }
                            elseif($grandchild['Permalink']=='#')
                            {
                                $grandchild['Permalink'] = 'javascript:;';
                            }
                            $this->list[$a]['SubMenu'][$b]['GrandchildMenu'][$c] = $grandchild;
                            $c++;
                        }
                    }
                    $b++;
                }
                $a++;
            }
        }
        return;
    }
    
    public function getParentMenus($active=FALSE)
    {
        $and_where ="";
        if($active==TRUE){$and_where .= " AND `Active` = 1 ";}
        /*Ensure that parent menu list is empty*/
        $this->_clearParentMenu();
        /*Set the query*/
        $this->crud->query = "SELECT * FROM `user_menu` WHERE `MenuID` IN (SELECT DISTINCT(b.`MenuID`) FROM `user_role_access` a JOIN `user_menu` b ON a.`MenuID` = b.`MenuID` WHERE a.`UserRoleID` = '$this->user_role_id' AND b.MenuParentID = 0 GROUP BY b.`MenuID` ORDER BY b.MenuOrder) $and_where ORDER BY `MenuOrder` ASC";
        /*Execute the query and put the data into the main menu list*/
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            $this->parent_menu_list = $this->crud->result_data;
            return;
        }
    }
    public function getSubMenus($active=FALSE)
    {
        /*Ensure that the sub menu list is empty*/
        $this->_clearSubMenu();
        /*Set the query*/
        $and_where ="";
        if($active==TRUE){$and_where .= " AND b.`Active` = 1 ";}
        $this->crud->query = "SELECT * FROM `user_menu` WHERE `MenuParentID` = '$this->parent_id' AND `MenuID` IN (SELECT DISTINCT(b.`MenuID`) FROM `user_role_access` a JOIN `user_menu` b ON a.`MenuID` = b.`MenuID` WHERE a.`UserRoleID` = '$this->user_role_id' $and_where GROUP BY b.`MenuID`) ORDER BY `MenuOrder` ASC";
        /*Execute the query and put the data into sub menu list*/
        $this->crud->readByCustomQuery();
        if(count($this->crud->result_data)>0)
        {
            $this->sub_menu_list = $this->crud->result_data;
            return;
        }
    }
    
    public function addUsermenu()
    {
        $this->crud->table = 'user_menu';
        $this->crud->input_data = $this->input_data;
        if($this->crud->create())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateUsermenu()
    {
        $this->crud->audit_trail_settings['record_id'] = $this->id;
        $this->crud->table = 'user_menu';
        $this->crud->input_data = $this->input_data;
        $this->crud->where = $this->id>0 ? array('MenuID'=>$this->id) : NULL;
        if($this->crud->update())
        {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Clear the main menu list
     */
    private function _clearParentMenu()
    {
        $this->parent_menu_list = array();
    }
    /**
     * Clear the sub menu list
     */
    private function _clearSubMenu()
    {
        $this->sub_menu_list = array();
    }
    /**
     * Clear the menu list
     */
    private function _clearMenu()
    {
        $this->usermenu_list = array();
    }
}
