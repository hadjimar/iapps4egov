<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Transaction</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-large select2me" name="data[TransactionType]" >
                    <option value=""></option>
                    <option value="New" <?php echo set_select('data[TransactionType]', 'New');?>>New</option>
                    <option value="Renew" <?php echo set_select('data[TransactionType]', 'Renew');?>>Renew</option>
                    <option value="Retire" <?php echo set_select('data[TransactionType]', 'Retire');?>>Retire</option>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[TransactionType]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Requirement</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select form-control input-large" id="my_multi_select1" name="data[RequirementID][]">
                    <option value=""></option>
                    <?php if(isset($this->var['requirement_list'])) :?>
                    <?php foreach($this->var['requirement_list'] as $row): ?>
                    <option value="<?php echo $row['RequirementID'];?>" <?php echo set_select('data[RequirementID][]', $row['RequirementID']);?>><?php echo $row['RequirementName'];?></option>
                    <?php endforeach; /*($this->var['requirement_list'] as $row)*/?>
                    <?php endif; /*(isset($this->var['requirement_list']))*/?>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[RequirementID]');?></span>
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
        <?php $requirement = isset($this->var['business_requirement_list'])? $this->var['business_requirement_list'][0]['RequirementID'] : NULL;
            $transaction = isset($this->var['business_requirement_list'])? $this->var['business_requirement_list'][0]['TransactionType'] : NULL;
            $active = isset($this->var['business_requirement_list'])? $this->var['business_requirement_list'][0]['Active'] : NULL;
        ?>
        <div class="form-group">
            <label class="col-md-3 control-label" >Transaction</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-large select2me" name="data[TransactionType]" >
                    <option value=""></option>
                    <option value="New" <?php echo set_select('data[TransactionType]', 'New', $transaction=='New' ? TRUE:NULL);?>>New</option>
                    <option value="Renew" <?php echo set_select('data[TransactionType]', 'Renew', $transaction=='Renew' ? TRUE:NULL);?>>Renew</option>
                    <option value="Retire" <?php echo set_select('data[TransactionType]', 'Retire', $transaction=='Retire' ? TRUE:NULL);?>>Retire</option>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[TransactionType]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Requirement</label>
            <div class="col-md-9">
                <select multiple="multiple" class="multi-select form-control input-large" id="my_multi_select1" name="data[RequirementID][]">
                    <option value=""></option>
                    <?php if(isset($this->var['requirement_list'])) :?>
                    <?php foreach($this->var['requirement_list'] as $row): ?>
                    <option value="<?php echo $row['RequirementID'];?>" <?php echo in_array($row['RequirementID'],explode(',',$requirement)) ? "selected" : NULL;?>><?php echo $row['RequirementName'];?></option>
                    <?php endforeach; /*($this->var['requirement_list'] as $row)*/?>
                    <?php endif; /*(isset($this->var['requirement_list']))*/?>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[RequirementID]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $transaction;?>" data-db-table="business_requirement" data-key-field="TransactionType"/>
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
<!-- END OF FILE: business_requirement_addedit.php -->