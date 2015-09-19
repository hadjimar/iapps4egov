<table id="sample_6" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Item</th>
            <th>Profile Picture</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Email</th>
            <th>Date Last Login</th>
            <th>Active</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($this->var['user_list'])): $i=1;?>
        <?php foreach($this->var['user_list'] as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><img alt="" class="img-circle" src="<?php echo file_exists(APPPATH.'assets/files/pictures/'.$row['ProfilePicture']) ? BASE_URL.'assets/files/pictures/'.$row['ProfilePicture'] : ADMIN_THEME.'img/avatar.png';?>"/></td>
            <td><?php echo $row['FirstName'].' '.$row['MiddleName'].' '.$row['LastName'].' '.$row['ExtensionName']; ?></td>
            <td><?php echo $row['Username']; ?></td>
            <td><?php echo $row['UserRoleName']; ?></td>
            <td><?php echo $row['UserEmail']; ?></td>
            <td><?php echo $row['DateLastLogin']; ?></td>
            <td><input type="checkbox" class="make-switch" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['UserID'];?>" data-db-table="user" data-key-field="UserID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $row['UserID'];?>">Edit</a></td>
        </tr>
        <?php $i++; endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>