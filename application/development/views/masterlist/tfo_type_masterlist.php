<table id="sample_6" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Item</th>
            <th>Name</th>
            <th>Active</th>
            <th>Date Added</th>
            <th>Date Last Updated</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($this->var['tfo_type_list'])): $i=1;?>
        <?php foreach($this->var['tfo_type_list'] as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['TFOTypeName']; ?></td>
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['TFOTypeID'];?>" data-db-table="tfo_type" data-key-field="TFOTypeID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><?php echo $row['DateAdded']; ?></td>
            <td><?php echo $row['DateLastUpdated']; ?></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $row['TFOTypeID'];?>">Edit</a></td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>