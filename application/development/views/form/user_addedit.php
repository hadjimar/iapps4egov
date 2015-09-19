<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <h3 class="form-section">Person Info</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-md-2 control-label" >Name</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control input-inline input-medium" name="data[FirstName]" placeholder="Firstname" value="<?php echo set_value('data[FirstName]',''); ?>"/>
                        <input type="text" class="form-control input-inline input-medium" name="data[MiddleName]" placeholder="Middlename" value="<?php echo set_value('data[MiddleName]',''); ?>"/>
                        <input type="text" class="form-control input-inline input-medium" name="data[LastName]" placeholder="Lastname" value="<?php echo set_value('data[LastName]',''); ?>"/>
                        <input type="text" class="form-control input-inline input-xsmall" name="data[ExtensionName]" placeholder="Ext." value="<?php echo set_value('data[ExtensionName]','');?>"/>
                    </div>
                    <div class="col-md-10 col-md-offset-2">
                        <span class="help-block input-inline input-medium text-danger"><?php echo form_error('data[FirstName]');?> </span>
                        <span class="help-inline input-inline input-medium text-danger"><?php echo form_error('data[MiddleName]');?> </span>
                        <span class="help-inline input-inline input-medium text-danger"><?php echo form_error('data[LastName]');?> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Date of Birth</label>
                    <div class="col-md-8">
                        <input class="form-control input-medium input-inline date-picker" data-date-format="yyyy-mm-dd" type="text" placeholder="yyyy-mm-dd" name="data[Birthday]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Marital Status</label>
                    <div class="col-md-8">
                        <select class="form-control input-medium input-inline" name="data[MaritalStatus]">
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widow</option>
                            <option value="divorced">Divorced</option>
                            <option value="annulled">Annulled</option>
                            <option value="separated">Separated</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-3">Gender</label>
                    <div class="col-md-9">
                        <select class="form-control input-medium input-inline" name="data[Gender]">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Citizenship</label>
                    <div class="col-md-9">
                        <select class="form-control input-medium input-inline" name="data[CitizenshipID]">
                            <option value="1">Filipino</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="form-section">User Info</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >Username</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-inline input-medium" name="data[Username]" value="<?php echo set_value('data[Username]'); ?>"/>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[Username]');?> </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" >Email</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-inline input-medium" name="data[UserEmail]" value="<?php echo set_value('data[UserEmail]',''); ?>"/>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[UserEmail]');?> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control input-inline input-medium" name="data[Password]" />
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[Password]');?> </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" >Confirm Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control input-inline input-medium" name="ConfirmPassword"/>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[ConfirmPassword]');?> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label" >User Role</label>
                    <div class="col-md-8">
                        <select class="form-control input-inline input-medium select2me" name="data[UserRoleID]" />
                        <option value=""></option>
                        <?php if(isset($this->var['userrole_list'])) : ?>
                            <?php foreach($this->var['userrole_list'] as $row) : ?>
                            <option value="<?php echo $row['UserRoleID'];?>" <?php echo set_select('data[UserRoleID]', $row['UserRoleID']);?>><?php echo $row['UserRoleName'];?></option>
                            <?php endforeach; ?>
                        <?php endif; /*(isset($this->var['userrole_list']))*/?>
                        </select>
                        <span class="help-inline input-inline text-danger"><?php echo form_error('data[UserRoleID]');?> </span>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------- END ADD FORM INPUT ----------------------->
        <!----------------------- BEGIN EDIT FORM INPUT ----------------------->
        <?php elseif($this->var['action']=='edit'):?>
        <?php $firstname = isset($this->var['user_list'])? $this->var['user_list'][0]['UserRoleName'] : NULL;
           
        ?>
        
        <!----------------------- END EDIT FORM INPUT ----------------------->
        <?php endif; /*($this->var['action']==???)*/?>
    </div>
    <!----------------------- END FORM BODY ----------------------->
    <!----------------------- BEGIN FORM ACTION ----------------------->
    <div class="form-actions">
        <div class="col-md-offset-4">
            <button class="btn green-jungle" type="submit" name="btn_user_addedit">Submit</button>
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
    <!----------------------- END FORM ACTION ----------------------->
</form>
<?php endif; ?>
<!-- END OF FILE: userrole_addedit.php -->
