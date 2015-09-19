<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="form-group">
            <label class="col-md-3 control-label" >PSIC</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-small" name="data[PSIC]" value="<?php echo set_value('data[PSIC]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[PSIC]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[BusinessNatureName]" value="<?php echo set_value('data[BusinessNatureName]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[BusinessNatureName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Description</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[BusinessNatureDescription]" value="<?php echo set_value('data[BusinessNatureDescription]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[BusinessNatureDescription]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" data-on-color="primary" data-off-text="No" data-on-text="Yes" name="data[Active]" checked=""value="1" />
                <span class="help-inline text-danger"><?php echo form_error('data[Active]');?></span>
            </div>
        </div>
        <!----------------------- END ADD FORM INPUT ----------------------->
        <!----------------------- BEGIN EDIT FORM INPUT ----------------------->
        <?php elseif($this->var['action']=='edit'):?>
        <?php $name = isset($this->var['business_nature_list'])? $this->var['business_nature_list'][0]['BusinessNatureName'] : NULL;
            $id = isset($this->var['business_nature_list'])? $this->var['business_nature_list'][0]['BusinessNatureID'] : NULL;
            $psic = isset($this->var['business_nature_list'])? $this->var['business_nature_list'][0]['PSIC'] : NULL;
            $description = isset($this->var['business_nature_list'])? $this->var['business_nature_list'][0]['BusinessNatureDescription'] : NULL;
            $active = isset($this->var['business_nature_list'])? $this->var['business_nature_list'][0]['Active'] : NULL;
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label" >PSIC</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[PSIC]" value="<?php echo set_value('data[PSIC]',$psic); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[PSIC]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[BusinessNatureName]" value="<?php echo set_value('data[BusinessNatureName]',$name); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[BusinessNatureName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Description</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[BusinessNatureDescription]" value="<?php echo set_value('data[BusinessNatureDescription]',$description); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[BusinessNatureDescription]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $id;?>" data-db-table="business_nature" data-key-field="BusinessNatureID" <?php echo $active==1 ? "checked=''" : NULL; ?>/>
                <span class="help-inline text-danger"><?php echo form_error('data[Active]');?></span>
            </div>
        </div>
        <!----------------------- END EDIT FORM INPUT ----------------------->
        <?php endif; /*($this->var['action']==???)*/?>
    </div>
    <!----------------------- END FORM BODY ----------------------->
    <!----------------------- BEGIN FORM ACTION ----------------------->
    <div class="form-actions">
        <div class="col-md-offset-4">
            <input class="btn green-jungle" type="submit" value="Submit" />
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
    <!----------------------- END FORM ACTION ----------------------->
</form>
<?php endif; ?>
<!-- END OF FILE: business_nature_addedit.php -->