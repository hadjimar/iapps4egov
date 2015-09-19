<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <div class="form-group">
            <label class="col-md-3 control-label">Transaction</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" id="transaction-get-tfo" data-tfo-template-id="<?php echo $this->var['id'];?>" data-target=".input-tfo" name="data[TransactionType]" >
                    <option></option>
                    <option value="New" <?php echo set_select('data[TransactionType]','New');?>>New</option>
                    <option value="Renew" <?php echo set_select('data[TransactionType]','Renew');?>>Renew</option>
                    <option value="Retire" <?php echo set_select('data[TransactionType]','Retire');?>>Retire</option>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[TransactionType]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">TFO</label>
            <div class="col-md-3">
                <input type="hidden" class="form-control input-inline input-medium input-tfo select2" name="data[TFOID]" value="<?php echo set_value('data[TFOID]');?>"/>
<!--                <select type="text" class="form-control input-inline input-medium input-tfo" name="data[TFOID]" >
                </select>-->
                <span class="help-inline text-danger"><?php echo form_error('data[TFOID]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Basis</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me input-basis" name="data[Basis]" >
                    <option></option>
                    <option value="CapitalInvestment" <?php echo set_select('data[Basis]','CapitalInvestment');?>>Capital Investment</option>
                    <option value="GrossSales" <?php echo set_select('data[Basis]','GrossSales');?>>Gross Sales</option>
                    <option value="InputtedValue" <?php echo set_select('data[Basis]','InputtedValue');?>>Inputted Value</option>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[Basis]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Mode of Computation</label>
            <div class="radio-list col-md-9">
                <label class="radio-inline">
                    <input type="radio" name="data[ModeOfComputation]" value="constant" class="input-mode-of-computation" <?php echo set_radio('data[ModeOfComputation]','constant');?>> Constant 
                </label>
                <label class="radio-inline">
                    <input type="radio" name="data[ModeOfComputation]" value="formula" class="input-mode-of-computation" <?php echo set_radio('data[ModeOfComputation]','formula');?>> Formula 
                </label>
                <label class="radio-inline">
                    <input type="radio" name="data[ModeOfComputation]" value="range" class="input-mode-of-computation" <?php echo set_radio('data[ModeOfComputation]','range');?>> Range 
                </label>
                <span class="help-inline text-danger"><?php echo form_error('data[ModeOfComputation]');?></span>
            </div>
        </div>
        <!-- Begin Unit of Measure: if basis is Inputted Value -->
        <div class="form-group div-unit-of-measure">
            <label class="col-md-3 control-label">Unit of Measure</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-small" name="data[UnitOfMeasure]" value="<?php echo set_value('data[UnitOfMeasure]');?>">
                <span class="help-inline text-danger"><?php echo form_error('data[UnitOfMeasure]');?></span>
            </div>
        </div>
        <!-- End Unit of Measure: if basis is Inputted Value -->
        <!-- Begin Amount: if mode of computation is constant -->
        <div class="form-group div-tfo-amount">
            <label class="col-md-3 control-label">Amount</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-small" name="data[Amount]" >
                <span class="help-inline text-danger"><?php echo form_error('data[Amount]');?></span>
            </div>
        </div>
        <!-- End Amount: if mode of computation is constant -->
        <!-- Begin Formula Type: if mode of computation is formula -->
        <div class="form-group div-formula-type">
            <label class="col-md-3 control-label">Formula Type</label>
            <div class="radio-list col-md-9">
                <label class="radio-inline">
                    <input type="radio" name="data[FormulaType]" value="simple" class="input-formula-type" data-tfo-template-id="<?php echo $this->var['id'];?>"> Simple 
                </label>
                <label class="radio-inline">
                    <input type="radio" name="data[FormulaType]" value="complex" class="input-formula-type" data-tfo-template-id="<?php echo $this->var['id'];?>"> Complex 
                </label>
            </div>
            <span class="help-inline text-danger"><?php echo form_error('data[ModeofComputation]');?></span>
        </div>
        <!-- End Formula Type: if mode of computation is formula -->
        <!-- Begin minimum amount: if mode of computation is formula or range -->
        <div class="form-group div-minimum-amount">
            <label class="col-md-3 control-label">Minimum Amount</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-small input-number-of-range" name="data[MinimumAmount]">
            </div>
        </div>
        <!-- End minimum amount: if mode of computation is formula or range -->
        <!-- Begin Formula: if mode of computation is formula -->
        <div class="form-group div-tfo-formula">
            <label class="col-md-3 control-label">Formula</label>
            <div class="col-md-9">
                <textarea class="form-control input-inline input-large" name="data[Formula]" ></textarea>
                <span class="help-inline text-danger"><?php echo form_error('data[Formula]');?></span>
            </div>
        </div>
        <!-- End Formula: if mode of computation is formula -->
        <!-- Begin variables: if mode of computation is formula and/or basis is selected -->
        <div class="form-group div-available-variables">
            <div class='col-md-3'><span class='pull-right'>Available Variables</span></div>
            <div class="col-md-8 available-variable-list"></div>
        </div>
        <!-- End No of variables: if mode of computation is formula and/or basis is selected   -->
        <!-- Begin Number of Range: if mode of computation is range -->
        <div class="form-group div-number-of-range">
            <label class="col-md-3 control-label">Number of Range</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-xsmall input-number-of-range">
            </div>
        </div>
        <!-- End Number of Range: if mode of computation is range  -->
        <!-- Begin Range: if mode of computation is range -->
        <table class="table table-responsive table-striped table-range">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Lower Limit</th>
                    <th>Higher Limit</th>
                    <th>Amount</th>
                    <th>Formula</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <!-- End Range: if mode of computation is range  -->
        <!----------------------- END ADD FORM INPUT ----------------------->
        <!----------------------- BEGIN EDIT FORM INPUT ----------------------->
        <?php elseif($this->var['action']=='edit'):?>
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