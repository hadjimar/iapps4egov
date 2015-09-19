
<?php if(file_exists(APPPATH.'views/form/menu_icons.php')) {include 'menu_icons.php';} ?> 
<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!------------------ BEGIN FORM INPUT: ADD ------------------>
        <?php if($this->var['action']=='add') : ?>
        <!-- Begin Menu Name -->
        <div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[MenuName]" value="<?php echo set_value('data[MenuName]', ''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuName]');?></span>
            </div>
        </div>
        <!-- End Menu Name -->
        <!-- Begin Menu Description -->
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[MenuDescription]" value="<?php echo set_value('data[MenuDescription]', ''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuDescription]');?></span>
            </div>
        </div>
        <!-- End Menu Description -->
        <!-- Begin Menu Type -->
        <div class="form-group">
            <label class="col-md-3 control-label">Menu Type</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" name="data[MenuType]" onchange="javascript:showPermalink(this.value)">
                    <option value="static">Static</option>
                    <option value="page">Page</option>
                    <option value="internal link">Internal Link</option>
                    <option value="external link">External Link</option>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuType]');?></span>
            </div>
        </div>
        <!-- End Menu Type -->
        <!-- Begin Permalink -->
        <div class="form-group" id="menu-permalink">
            <label class="col-md-3 control-label">Permalink</label>
            <div class="col-md-9">
                <input class="form-control input-inline input-medium" type="text" name="data[Permalink]" value="<?php echo set_value('data[Permalink]', '');?>" >
                <span class="help-inline text-danger"><?php echo form_error('data[Permalink]');?></span>
            </div>
        </div>
        <!-- End Permalink -->
        
        <!-- Begin Parent Menu -->
        <div class="form-group">
            <label class="col-md-3 control-label">Parent Menu</label>
            <div class="col-md-9 portlet box border" style="border:1px solid #E9E9E9;max-height: 200px;overflow-y: scroll;">
                <div class="portlet-body">
                    <?php if(isset($this->var['usermenu_list']) && count($this->var['usermenu_list'])>0) : ?>
                    <div class="radio-list">
                    <!-- BEGIN PARENT MENU -->
                        <?php foreach($this->var['usermenu_list'] as $main) : ?>
                        <label>
                            <div>
                                <span>
                                    <input type="radio" class="form-control" name="data[MenuParentID]" value="<?php echo $main['MenuID'];?>"/> <?php echo $main['MenuName'];?>
                                </span>
                            </div>
                        </label>
                        <!-- BEGIN SUB MENU LEVEL 1 -->
                        <?php if(array_key_exists('SubMenu', $main)) : /*If there is sub menu*/?>
                            <?php foreach($main['SubMenu'] as $sub): /*loop and display as radio selection */?>
                            <label class="col-md-offset-1">
                                <div>
                                    <span>
                                        <input type="radio" name="data[MenuParentID]" value="<?php echo $sub['MenuID'];?>"/> <?php echo $sub['MenuName'];?>
                                    </span>
                                </div>
                            </label>
                            <!-- BEGIN SUB MENU LEVEL 2 -->
                            <?php if(array_key_exists('GrandchildMenu', $sub)) : /*If there is sub menu*/?>
                                <?php foreach($sub['GrandchildMenu'] as $grandchild): /*loop and display as radio selection */?>
                                <label class="col-md-offset-2">
                                    <div>
                                        <span>
                                            <input type="radio" name="data[MenuParentID]" value="<?php echo $grandchild['MenuID'];?>"/> <?php echo $grandchild['MenuName'];?>
                                        </span>
                                    </div>
                                </label>
                                <?php endforeach; /*($sub['GrandchildMenu'] as $grandchild)*/?>
                            <?php endif; /*(array_key_exists('GrandchildMenu', $sub))*/?>
                            <!-- END SUB MENU LEVEL 2 -->
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- END SUB MENU LEVEL 1 -->
                        <?php endforeach; /*($this->var['usermenu_list'] as $main)*/ ?>
                    <!-- END MAIN MENU -->
                    </div>
                    <?php endif; /*(isset($this->var['usermenu_list']) && count($this->var['usermenu_list'])>0)*/?>
                </div>
            </div>
        </div>
        <!-- End Parent Menu -->
        <div class="form-group">
            <label class="col-md-3 control-label">Menu Order</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-xsmall" name="data[MenuOrder]" value="<?php echo set_value('data[MenuOrder]', ''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuOrder]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Menu Icon</label>
            <div class="col-md-9 portlet box border" style="border:1px solid #E9E9E9;max-height: 400px;overflow-y: scroll;">
                <div class="portlet-body">
                    <label class="fa-item col-md-4 col-sm-6">
                        <div>
                            <span >
                                <input type="radio" name="data[MenuIcon]" value="" />
                                <span aria-hidden="true" class="font-red fa-2x">x</span>no-icon
                            </span>
                        </div>
                    </label>
                    <?php if(isset($icon_array)) :?>
                    <?php foreach($icon_array as $icon) :?>
                    <label class="fa-item col-md-4 col-sm-6">
                        <div>
                            <span >
                                <input type="radio" name="data[MenuIcon]" value="<?php echo $icon;?>" />
                                <span aria-hidden="true" class="<?php echo $icon;?> font-red fa-2x"></span> <?php echo $icon;?>
                            </span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" data-on-color="primary" data-off-text="No" data-on-text="Yes" name="data[Active]" value="1" checked=""/>
                <span class="help-inline text-danger"><?php echo form_error('data[Active]');?></span>
            </div>
        </div>
    <!------------------ END FORM INPUT: ADD ------------------>
    <!------------------ BEGIN FORM INPUT: EDIT ------------------>
    <?php elseif($this->var['action']=='edit') :?>
    <?php $name = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuName'] : NULL;
            $id = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuID'] : NULL;
            $description = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuDescription'] : NULL;
            $type = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuType'] : NULL;
            $permalink = isset($this->var['menu_list'])? $this->var['menu_list'][0]['Permalink'] : NULL;
            $parent_id = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuParentID'] : NULL;
            $menu_icon = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuIcon'] : NULL;
            $order = isset($this->var['menu_list'])? $this->var['menu_list'][0]['MenuOrder'] : NULL;
            $active = isset($this->var['menu_list'])? $this->var['menu_list'][0]['Active'] : NULL;
        ?>
        <!-- Begin Menu Name -->
        <div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[MenuName]" value="<?php echo set_value('data[MenuName]', $name); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuName]');?></span>
            </div>
        </div>
        <!-- End Menu Name -->
        <!-- Begin Menu Description -->
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[MenuDescription]" value="<?php echo set_value('data[MenuDescription]', $description); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuDescription]');?></span>
            </div>
        </div>
        <!-- End Menu Description -->
        <!-- Begin Menu Type -->
        <div class="form-group">
            <label class="col-md-3 control-label">Menu Type</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" name="data[MenuType]" onchange="showPermalink(this.value);">
                    <option value="static" <?php echo $type=="static" ? "Selected='selected'" : NULL; ?>>Static</option>
                    <option value="page" <?php echo $type=="page" ? "Selected='selected'" : NULL; ?>>Page</option>
                    <option value="internal link" <?php echo $type=="internal link" ? "Selected='selected'" : NULL; ?>>Internal Link</option>
                    <option value="external link" <?php echo $type=="external link" ? "Selected='selected'" : NULL; ?>>External Link</option>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuType]');?></span>
            </div>
        </div>
        <!-- End Menu Type -->
        <!-- Begin Permalink -->
        <div class="form-group" id="menu-permalink">
            <label class="col-md-3 control-label">Permalink</label>
            <div class="col-md-9">
                <input class="form-control input-inline input-medium" type="text" name="data[Permalink]" value="<?php echo set_value('data[Permalink]', $permalink);?>" >
                <span class="help-inline text-danger"><?php echo form_error('data[Permalink]');?></span>
            </div>
        </div>
        <!-- End Permalink -->
        <!-- Begin Parent Menu -->
        <div class="form-group">
            <label class="col-md-3 control-label">Parent Menu</label>
            <div class="col-md-9 portlet box border" style="border:1px solid #E9E9E9;max-height: 200px;overflow-y: scroll;">
                <div class="portlet-body">
                    <?php if(isset($this->var['usermenu_list']) && count($this->var['usermenu_list'])>0) : ?>
                    <div class="radio-list">
                        <!-- BEGIN MAIN MENU -->
                        <?php foreach($this->var['usermenu_list'] as $main) : ?>
                        <label>
                            <div>
                                <span <?php echo $main['MenuID']==$parent_id ? "class='checked'" : NULL; ?>>
                                    <input type="radio" class="form-control" name="data[MenuParentID]" value="<?php echo $main['MenuID'];?>" <?php echo $main['MenuID']==$parent_id ? "checked=''" : NULL; ?> /><?php echo $main['MenuName']; ?>
                                </span>
                            </div>
                        </label>
                        <!-- BEGIN SUB MENU LEVEL 1 -->
                        <?php if(array_key_exists('SubMenu', $main)) : /*If there is sub menu*/?>
                            <?php foreach($main['SubMenu'] as $sub): /*loop and display as radio selection */?>
                            <label class="col-md-offset-1">
                                <div>
                                    <span <?php echo $sub['MenuID']==$parent_id ? "class='checked'" : NULL; ?>>
                                        <input type="radio" name="data[MenuParentID]" value="<?php echo $sub['MenuID'];?>" <?php echo $sub['MenuID']==$parent_id ? "checked=''" : NULL; ?>/> <?php echo $sub['MenuName'];?>
                                    </span>
                                </div>
                            </label>
                            <!-- BEGIN SUB MENU LEVEL 2 -->
                            <?php if(array_key_exists('GrandchildMenu', $sub)) : /*If there is sub menu*/?>
                                <?php foreach($sub['GrandchildMenu'] as $grandchild): /*loop and display as radio selection */?>
                                <label class="col-md-offset-2">
                                    <div>
                                        <span <?php echo $grandchild['MenuID']==$parent_id ? "class='checked'" : NULL; ?>>
                                            <input type="radio" name="data[MenuParentID]" value="<?php echo $grandchild['MenuID'];?>" <?php echo $grandchild['MenuID']==$parent_id ? "checked=''" : NULL; ?>/> <?php echo $grandchild['MenuName'];?>
                                        </span>
                                    </div>
                                </label>
                                <?php endforeach; ?>
                            <?php endif; /*(array_key_exists('GrandchildMenu', $sub))*/?>
                            <!-- END SUB MENU LEVEL 2 -->
                            <?php endforeach; /*($main['SubMenu'] as $sub)*/?>
                        <?php endif; /*(array_key_exists('SubMenu', $main))*/?>
                        <!-- END SUB MENU LEVEL 1 -->
                        <?php endforeach; /*($this->var['usermenu_list'] as $main)*/ ?>
                    <!-- END MAIN MENU -->
                    </div>
                    <?php endif; /*(isset($this->var['usermenu_list']) && count($this->var['usermenu_list'])>0)*/?>
                </div>
            </div>
        </div>
        <!-- End Parent Menu -->
        <div class="form-group">
            <label class="col-md-3 control-label">Menu Order</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-xsmall" name="data[MenuOrder]" value="<?php echo set_value('data[MenuOrder]', $order); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[MenuOrder]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Menu Icon</label>
            <div class="col-md-9 portlet box border" style="border:1px solid #E9E9E9;max-height: 400px;overflow-y: scroll;">
                <div class="portlet-body">
                    <label class="fa-item col-md-4 col-sm-6">
                        <div>
                            <span >
                                <input type="radio" name="data[MenuIcon]" value="" />
                                <span aria-hidden="true" class="font-red fa-2x">x</span>no-icon
                            </span>
                        </div>
                    </label>
                    <?php if(isset($icon_array)) :?>
                    <?php foreach($icon_array as $icon) :?>
                    <label class="fa-item col-md-4 col-sm-6">
                        <div>
                            <span <?php echo $icon==$menu_icon ? "class='checked'" : NULL; ?> >
                                <input type="radio" name="data[MenuIcon]" value="<?php echo $icon;?>" <?php echo $icon==$menu_icon ? "checked=''" : NULL; ?> />
                                <span aria-hidden="true" class="<?php echo $icon;?> font-red fa-2x"></span> <?php echo $icon;?>
                            </span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" data-on-color="primary" data-record-id="<?php echo $id;?>" data-db-table="user_menu" data-key-field="MenuID" <?php echo $active ? "checked=''" : NULL; ?>/>
                <span class="help-inline text-danger"><?php echo form_error('data[Active]');?></span>
            </div>
        </div>
        <!------------------ END FORM INPUT: EDIT ------------------>
    <?php endif; /*($this->var['action']==???)*/?>
    </div>
    <!----------------------- END FORM BODY ----------------------->
    <!----------------------- BEGIN FORM ACTION ----------------------->
    <div class="form-actions">
        <div class="col-md-offset-4">
            <input class="btn green" type="submit" name="btn_usermenu_addedit" value="Submit" />
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
    <!----------------------- END FORM ACTION ----------------------->
</form>
<?php endif; /*(isset($this->var['action']))*/?>
<!-- END OF FILE: province_addedit.php -->