<table id="sample_6" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Item</th>
            <th>Name</th>
            <th>Active</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($this->var['ownership_type_list'])): $i=1;?>
        <?php foreach($this->var['ownership_type_list'] as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['OwnershipTypeName']; ?></td>
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['OwnershipTypeID'];?>" data-db-table="ownership_type" data-key-field="OwnershipTypeID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $row['OwnershipTypeID'];?>">Edit</a></td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>