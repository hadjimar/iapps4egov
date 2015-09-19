<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Type</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" name="data[TFOTypeID]">
                    <option></option>
                    <?php if(isset($this->var['tfo_type_list'])) :?>
                    <?php foreach($this->var['tfo_type_list'] as $row) :?>
                    <option value="<?php echo $row['TFOTypeID'];?>" <?php echo set_select('data[TFOTypeID]',$row['TFOTypeID']);?>><?php echo $row['TFOTypeName'];?></option>
                    <?php endforeach; /*($this->var['tfo_type_list'] as $row)*/?>
                    <?php endif; /*(isset($this->var['tfo_type_list']))*/?>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOTypeID]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[TFOName]" value="<?php echo set_value('data[TFOName]',''); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOName]');?></span>
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
        <?php $name = isset($this->var['tfo_list'])? $this->var['tfo_list'][0]['TFOName'] : NULL;
            $id = isset($this->var['tfo_list'])? $this->var['tfo_list'][0]['TFOID'] : NULL;
            $parent_id = isset($this->var['tfo_list'])? $this->var['tfo_list'][0]['TFOTypeID'] : NULL;
            $active = isset($this->var['tfo_list'])? $this->var['tfo_list'][0]['Active'] : NULL;
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Type</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" name="data[TFOTypeID]">
                    <option></option>
                    <?php if(isset($this->var['tfo_type_list'])) :?>
                    <?php foreach($this->var['tfo_type_list'] as $row) :?>
                    <option value="<?php echo $row['TFOTypeID'];?>" <?php echo set_select('data[TFOTypeID]',$row['TFOTypeID'],$row['TFOTypeID']==$parent_id ? TRUE : NULL );?>><?php echo $row['TFOTypeName'];?></option>
                    <?php endforeach; /*($this->var['tfo_type_list'] as $row)*/?>
                    <?php endif; /*(isset($this->var['tfo_type_list']))*/?>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOTypeID]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[TFOName]" value="<?php echo set_value('data[TFOName]',$name); ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[TFOName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $id;?>" data-db-table="tfo" data-key-field="TFOID" <?php echo $active==1 ? "checked=''" : NULL; ?>/>
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
<!-- END OF FILE: tfo_addedit.php -->