<table id="sample_6" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Item</th>
            <th>Name</th>
            <th>Order</th>
            <th>Icon</th>
            <th>Active</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php if(isset($this->var['usermenu_list'])): $a=1;?>
        <?php foreach($this->var['usermenu_list'] as $main):?>
        <tr>
            <td><?php echo $a; ?></td>
            <td><?php echo $main['MenuName']; ?></td>
            <td><?php echo $main['MenuOrder'];?></td>
            <td><span class="<?php echo $main['MenuIcon'];?> font-red fa-2x"></span></td>
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="success" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $main['MenuID'];?>" data-db-table="user_menu" data-key-field="MenuID" <?php echo $main['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $main['MenuID'];?>">Edit</a></td>
        </tr>
        <?php $b = $a+1; ?>
        <?php if(array_key_exists('SubMenu', $main)) :?>
            <?php foreach($main['SubMenu'] as $sub) :?>
        <tr>
            <td> <?php echo $b; ?></td>
            <td><span class="col-md-offset-1"><?php echo $sub['MenuName']; ?></span></td>
            <td><?php echo $sub['MenuOrder'];?></td>
            <td><span class="<?php echo $sub['MenuIcon'];?> font-red fa-2x"></span</i></td>
            <td><input type="checkbox" class="make-switch input-set-active" data-on-color="success" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $sub['MenuID'];?>" data-db-table="user_menu" data-key-field="MenuID" <?php echo $sub['Active']==1 ? "checked=''" : NULL; ?>/></td>
            <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $sub['MenuID'];?>">Edit</a></td>
        </tr>
            <?php $c = $b+1; ?>
            <?php if(array_key_exists('GrandchildMenu', $sub)) :?>
                <?php foreach($sub['GrandchildMenu'] as $grandchild) :?>
            <tr>
                <td> <?php echo $c; ?></td>
                <td><span class="col-md-offset-2"><?php echo $grandchild['MenuName']; ?></span></td>
                <td><?php echo $grandchild['MenuOrder'];?></td>
                <td><span class="<?php echo $grandchild['MenuIcon'];?> font-red fa-2x"></span</td>
                <td><input type="checkbox" class="make-switch input-set-active" data-on-color="success" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $grandchild['MenuID'];?>" data-db-table="user_menu" data-key-field="MenuID" <?php echo $grandchild['Active']==1 ? "checked=''" : NULL; ?>/></td>
                <td><a href="<?php echo $this->var['section_url'];?>action/edit/id/<?php echo $grandchild['MenuID'];?>">Edit</a></td>
            </tr>
                <?php $c++; endforeach; /*($main['SubMenu'] as $sub)*/?>
            <?php endif; /*(array_key_exists('SubMenu', $main))*/ ?>
            <?php $b = $c; endforeach; /*($main['SubMenu'] as $sub)*/?>
        <?php endif; /*(array_key_exists('SubMenu', $main))*/ ?>
        <?php $a = $b; endforeach; /*($this->var['usermenu_list'] as $main)*/ ?>
    <?php endif; /*(isset($this->var['usermenu_list']))*/ ?>
    </tbody>
</table>