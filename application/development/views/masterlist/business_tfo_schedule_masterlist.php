                
<div class="row">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-yellow-casablanca"><?php echo isset($this->var['tfo_template_list']) ? $this->var['tfo_template_list'][0]['TFOTemplateName'] : NULL; ?></span>
                <span class="caption-helper"><?php echo isset($this->var['tfo_template_list']) ? $this->var['tfo_template_list'][0]['TFOTemplateDescription'] : NULL; ?></span>
            </div>
            <div class="actions">
                <a href="<?php echo $this->var['page_url'];?>tfo_template_test<?php echo isset($this->var['id']) && $this->var['id']>0? '/id/'.$this->var['id'] : NULL;?>" class="btn btn-circle btn-default btn-sm"><i class="fa fa-plus"></i> Test Computation</a>
            </div>
        </div>
        <div class="portlet-body">
            <table id="sample_6" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>TFO</th>
                        <th>Transaction</th>
                        <th>Basis</th>
                        <th>Mode</th>
                        <th>Min.Amt</th>
                        <th>UnitOfMeasure</th>
                        <th>Range #</th>
                        <th>LowerLimit</th>
                        <th>HigherLimit</th>
                        <th>Amount</th>
                        <th>Formula</th>
                        <th>Active</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($this->var['business_tfo_schedule_list'])): $i=1;?>
                    <?php foreach($this->var['business_tfo_schedule_list'] as $row):?>
                    <?php if($row['ModeOfComputation']!='Range' && !isset($row['Range'])):?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['TFOName']; ?></td>
                        <td><?php echo $row['TransactionType']; ?></td>
                        <td><?php echo $row['Basis']; ?></td>
                        <td><?php echo $row['ModeOfComputation']; ?></td>
                        <td><?php echo $row['MinimumAmount']; ?></td>
                        <td><?php echo $row['UnitOfMeasure']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $row['Amount']; ?></td>
                        <td><?php echo $row['Formula']; ?></td>
                        <td><input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['TFOScheduleID'];?>" data-db-table="business_tfo_schedule" data-key-field="TFOScheduleID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/></td>
                        <td><a href="<?php echo $this->var['page_url'];?>/business_tfo_schedule/action/edit/id/<?php echo $row['TFOScheduleID'];?>">Edit</a></td>
                    </tr>
                    <?php else : $a=1;?>
                    <?php foreach($row['Range'] as $range) :?>
                    <tr>
                        <?php $class = $a==1 ? NULL : "text-muted" ; ?>
                        <td><span class="<?php echo $class;?>"><?php echo $i;?></span></td>
                        <td><span class="<?php echo $class;?>"><?php echo $row['TFOName'];?></span></td>
                        <td><span class="<?php echo $class;?>"><?php echo $row['TransactionType'];?></span></td>
                        <td><span class="<?php echo $class;?>"><?php echo $row['Basis'];?></span></td>
                        <td><span class="<?php echo $class;?>"><?php echo $row['ModeOfComputation'];?></span></td>
                        <td><span class="<?php echo $class;?>"><?php echo $row['MinimumAmount'];?></span></td>
                        <td><span class="<?php echo $class;?>"><?php $row['UnitOfMeasure'];?></span></td>
                        <td><span><?php echo $range['RangeNumber'];?></span></td>
                        <td><span><?php echo $range['LowerLimit'];?></span></td>
                        <td><span><?php echo $range['HigherLimit'];?></span></td>
                        <td><span><?php echo $range['Amount'];?></span></td>
                        <td><span><?php echo $range['Formula'];?></span></td>
                        <td><?php if($a==1) :?> <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $row['TFOScheduleID'];?>" data-db-table="business_tfo_schedule" data-key-field="TFOScheduleID" <?php echo $row['Active']==1 ? "checked=''" : NULL; ?>/><?php endif; ?></td>
                        <td><?php if($a==1) :?><a href="<?php echo $this->var['page_url'];?>/business_tfo_schedule/action/edit/id/<?php echo $row['TFOScheduleID'];?>">Edit</a><?php endif; ?></td>
                    </tr>
                    
                    <?php $a++; endforeach;/*($row['Range'] as $range)*/ ?>
                    <?php endif; ?>
                    <?php $i++; endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>