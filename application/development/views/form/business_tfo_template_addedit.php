<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[TFOTemplateName]" value="<?php echo set_value('data[TFOTemplateName]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOTemplateName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Description</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[TFOTemplateDescription]" value="<?php echo set_value('data[TFOTemplateName]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOTemplateDescription]');?></span>
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
        <?php $name = isset($this->var['tfo_template_list'])? $this->var['tfo_template_list'][0]['TFOTemplateName'] : NULL;
            $id = isset($this->var['tfo_template_list'])? $this->var['tfo_template_list'][0]['TFOTemplateID'] : NULL;
            $description = isset($this->var['tfo_template_list'])? $this->var['tfo_template_list'][0]['TFOTemplateDescription'] : NULL;
            $active = isset($this->var['tfo_template_list'])? $this->var['tfo_template_list'][0]['Active'] : NULL;
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[TFOTemplateName]" value="<?php echo set_value('data[TFOTemplateName]',$name); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOTemplateName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Description</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[TFOTemplateDescription]" value="<?php echo set_value('data[TFOTemplateDescription]',$description); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOTemplateDescription]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $id;?>" data-db-table="tfo_template" data-key-field="TFOTemplateID" <?php echo $active==1 ? "checked=''" : NULL; ?>/>
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
<!-- END OF FILE: tfo_template_addedit.php -->