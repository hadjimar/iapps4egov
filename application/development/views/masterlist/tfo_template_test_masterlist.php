<div class="row">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-yellow-casablanca">TFO Template Test</span>
                <span class="caption-helper">This will be the facility to test the template</span>
            </div>
        </div>
        <div class="portlet-body">
            <form class="form-horizontal" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Transaction</label>
                        <div class="col-md-9">
                            <select class="form-control input-inline input-medium select2me" id="transaction-get-tfo" data-tfo-template-id="<?php echo $this->var['id'];?>" data-target=".input-tfo" name="data[TransactionType]" >
                                <option></option>
                                <option value="New">New</option>
                                <option value="Renew">Renew</option>
                                <option value="Retire">Retire</option>
                            </select>
                            <span class="help-inline text-danger"><?php echo form_error('data[TransactionType]');?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Basis Amount</label>
                        <div class="col-md-9">
                            <input class="form-control input-inline input-medium" name="data[BasisAmount]" >
                            <span class="help-inline text-danger"><?php echo form_error('data[BasisAmount]');?></span>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="col-md-offset-4">
                        <input class="btn green-jungle" type="submit" value="Initiate Test" />
                        <a href="<?php echo $this->var['page_url'];?>business_tfo_schedule/action/view/id/<?php echo $this->var['id'];?>" class="btn default">Cancel</a> 
                    </div>
                </div>
            </form>
        </div>
        <div class="form-body">
            
        </div>
    </div>
</div>