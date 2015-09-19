<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[ProvinceName]" value="<?php echo set_value('data[ProvinceName]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[ProvinceName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" data-on-color="primary" data-off-text="No" data-on-text="Yes" name="data[Active]" value="1" />
                <span class="help-inline text-danger"><?php echo form_error('data[Active]');?></span>
            </div>
        </div>
        <!----------------------- END ADD FORM INPUT ----------------------->
        <!----------------------- BEGIN EDIT FORM INPUT ----------------------->
        <?php elseif($this->var['action']=='edit'):?>
        <?php $name = isset($this->var['province_list'])? $this->var['province_list'][0]['ProvinceName'] : NULL;
            $province_id = isset($this->var['province_list'])? $this->var['province_list'][0]['ProvinceID'] : NULL;
            $active = isset($this->var['province_list'])? $this->var['province_list'][0]['Active'] : NULL;
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[ProvinceName]" value="<?php echo set_value('data[ProvinceName]',$name);?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[ProvinceName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $province_id;?>" data-db-table="province" data-key-field="ProvinceID" <?php echo $active==1 ? "checked=''" : NULL; ?>/>
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
            <input class="btn green" type="submit" name="btn_province_addedit" value="Submit" />
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
    <!----------------------- END FORM ACTION ----------------------->
</form>
<?php endif; ?>
<!-- END OF FILE: province_addedit.php -->