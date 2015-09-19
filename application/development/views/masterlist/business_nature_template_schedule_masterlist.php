<div class="row">
    <div class="portlet light">
        <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-yellow-casablanca"><?php echo isset($this->var['business_nature_list']) ? $this->var['business_nature_list'][0]['BusinessNatureName'] : NULL; ?></span>
                        <span class="caption-helper"><?php echo isset($this->var['business_nature_list']) ? $this->var['business_nature_list'][0]['BusinessNatureDescription'] : NULL; ?></span>
                    </div>
                </div>
        <div class="portlet-body">
            <table id="sample_6" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Template</th>
                        <th>Description</th>
                        <th>Details</th>
                        <th>Active</th>
                        <th>View Template</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($this->var['business_nature_template_schedule_list'])):?>
                    <?php foreach($this->var['business_nature_template_schedule_list'] as $row) : $i=1;?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['TFOTemplateName']; ?></td>
                        <td><?php echo $row['TFOTemplateDescription']; ?></td>
                        <td><?php echo $row['TFOTemplateDetails']; ?></td>
                        <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['BusinessNatureTemplateScheduleID'];?>" data-db-table="business_nature_template_schedule" data-key-field="BusinessNatureTemplateScheduleID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
                        <td><a href="<?php echo BASE_URL;?>business_tfo_template/business_tfo_schedule/action/view/id/<?php echo $row['TFOTemplateID'];?>" target="_blank" class="btn btn-icon-only btn-circle btn-default"><span class="fa fa-eye fa-2x text-info"></span></a></td>
                    </tr>
                    <?php $i++; endforeach; /*($this->var['business_nature_template_schedule_list'] as $row)*/?>
                <?php endif; /*(isset($this->var['business_nature_template_schedule_list']))*/?>
                </tbody>
            </table>
        </div>
    </div>
</div>