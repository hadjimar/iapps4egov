<table id="sample_6" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Item</th>
            <th>Name</th>
            <th>Description</th>
            <th>Active</th>
            <th>Edit</th>
            <th>View Schedule</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($this->var['tfo_template_list'])): $i=1;?>
        <?php foreach($this->var['tfo_template_list'] as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['TFOTemplateName']; ?></td>
            <td><?php echo $row['TFOTemplateDescription']; ?></td>
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['TFOTemplateID'];?>" data-db-table="business_tfo_template" data-key-field="TFOTemplateID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $row['TFOTemplateID'];?>">Edit</a></td>
            <td><a href="<?php echo $this->var['page_url'];?>business_tfo_schedule/action/view/id/<?php echo $row['TFOTemplateID'];?>" class="btn btn-icon-only btn-circle btn-default"><span class="fa fa-eye fa-2x text-info"></span></a></td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>