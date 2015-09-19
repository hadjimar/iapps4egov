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
    <?php if(isset($this->var['province_list'])): $i=1;?>
        <?php foreach($this->var['province_list'] as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['ProvinceName']; ?></td>
<!--            <td><input type="checkbox" class="make-switch" data-on-color="primary" data-off-text="No" data-on-text="Yes" name="data[Active]" value="1" onchange="javascript:setActive('location','<?php echo $row['ProvinceName'];?>',<?php echo $row['ProvinceID'];?>,'province','ProvinceID' );" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>-->
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['ProvinceID'];?>" data-db-table="province" data-key-field="ProvinceID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <!--<td><?php echo $row['Active']==1 ? "<i class='fa fa-check font-green'></i>" : "<i class='fa fa-remove font-red'></i>";?></td>-->
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $row['ProvinceID'];?>">Edit</a></td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>