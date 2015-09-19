<table id="sample_6" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Item</th>
            <th>PSIC</th>
            <th>Name</th>
            <th>Description</th>
            <th>TFO Template</th>
            <th>Active</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($this->var['business_nature_list'])): $i=1;?>
        <?php foreach($this->var['business_nature_list'] as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['PSIC']; ?></td>
            <td><?php echo $row['BusinessNatureName']; ?></td>
            <td><?php echo $row['BusinessNatureDescription']; ?></td>
            <td><?php echo strlen($row['TFOTemplateName'])>0 ? $row['TFOTemplateName']."<br/> <a href='".$this->var['page_url']."business_nature_template_schedule/action/view/id/".$row['BusinessNatureID']."'class='btn btn-xs btn-info'><i class='fa fa-eye'></i>View</a>" : "<a href='".$this->var['page_url']."business_nature_template_schedule/action/add/id/".$row['BusinessNatureID']."'class='btn btn-xs btn-info'><i class='fa fa-plus'></i>Add</a>";?>
            </td>
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['BusinessNatureID'];?>" data-db-table="business_nature" data-key-field="BusinessNatureID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $row['BusinessNatureID'];?>">Edit</a></td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>