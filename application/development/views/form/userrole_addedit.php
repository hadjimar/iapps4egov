
<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-inline input-medium" name="data[UserRoleName]" value="<?php echo set_value('data[UserRoleName]',''); ?>"/>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[UserRoleName]');?> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >Description</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-inline input-medium" name="data[UserRoleDescription]" value="<?php echo set_value('data[UserRoleDescription]',''); ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="col-md-2 control-label" >Page Access</label>
                <div class="col-md-10">
                        <select multiple="multiple" class="multi-select form-control input-large" id="my_multi_select2" name="data[Page][]">
                            
                            <?php foreach($this->config->item('iskul_methods') as $controller =>$methods) :?>
                            <optgroup label="<?php echo strtoupper($controller);?>">
                                <?php foreach($methods as $method) :?>
                                <option value="<?php echo $method=='index' ? $controller : $controller.'/'.$method;?>"><?php echo str_replace('_',' ',($method=='index' ? $controller : $method));?></option>
                                <?php endforeach;?>
                            </optgroup>
                            <?php endforeach;?>
                            
                        </select>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[UserRoleName]');?> </span>
                </div>
            </div>
        </div>
        <!----------------------- END ADD FORM INPUT ----------------------->
        <!----------------------- BEGIN EDIT FORM INPUT ----------------------->
        <?php elseif($this->var['action']=='edit'):?>
        <?php $name = isset($this->var['userrole_list'])? $this->var['userrole_list'][0]['UserRoleName'] : NULL;
            $description = isset($this->var['userrole_list'])? $this->var['userrole_list'][0]['UserRoleDescription'] : NULL;
            $page_access = isset($this->var['pageaccess_list']) ? $this->var['pageaccess_list'] : array() ;
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-inline input-medium" name="data[UserRoleName]" value="<?php echo set_value('data[UserRoleName]',$name); ?>"/>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[UserRoleName]');?> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >Description</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-inline input-medium" name="data[UserRoleDescription]" value="<?php echo set_value('data[UserRoleDescription]',$description); ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <label class="col-md-2 control-label" >Page Access</label>
                <div class="col-md-10">
                        <select multiple="multiple" class="multi-select form-control input-large" id="my_multi_select2" name="data[Page][]">
                            
                            <?php foreach($this->config->item('iskul_methods') as $controller =>$methods) :?>
                            <optgroup label="<?php echo strtoupper($controller);?>">
                                <?php foreach($methods as $method) :?>
                                <option value="<?php echo $method=='index' ? $controller : $controller.'/'.$method;?>" <?php echo in_array(($method=='index' ? $controller : $controller.'/'.$method),$page_access) ? "selected=''" : NULL;?> ><?php echo str_replace('_',' ',($method=='index' ? $controller : $method));?></option>
                                <?php endforeach;?>
                            </optgroup>
                            <?php endforeach;?>
                            
                        </select>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[UserRoleName]');?> </span>
                </div>
            </div>
        </div>
        <!----------------------- END EDIT FORM INPUT ----------------------->
        <?php endif; /*($this->var['action']==???)*/?>
    </div>
    <!----------------------- END FORM BODY ----------------------->
    <!----------------------- BEGIN FORM ACTION ----------------------->
    <div class="form-actions">
        <div class="col-md-offset-4">
            <button class="btn green-jungle" type="submit" name="btn_userrole_addedit">Submit</button>
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
    <!----------------------- END FORM ACTION ----------------------->
</form>
<?php endif; ?>
<!-- END OF FILE: userrole_addedit.php -->