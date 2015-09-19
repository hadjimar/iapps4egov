<?php if(isset($this->var['action'])) :?>
<form class="form-horizontal" method="post">
    <!----------------------- BEGIN FORM BODY ----------------------->
    <div class="form-body">
        <!----------------------- BEGIN ADD FORM INPUT ----------------------->
        <?php if($this->var['action']=='add'):?>
        <table id="sample_6" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>Add</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($this->var['tfo_template_list'])) :?>
                <?php foreach($this->var['tfo_template_list'] as $row) : $id=$row['TFOTemplateID'];?>
                <tr>
                    <td><input type="checkbox" class="make-switch" data-on-color="primary" data-off-text="No" data-on-text="Yes" name="data[TFOTemplateID][]" value="<?php echo $row['TFOTemplateID'];?>" <?php echo $this->input->post('data')['TFOTemplateID'] && in_array($row['TFOTemplateID'], $this->input->post('data')['TFOTemplateID'])? "checked=''" : NULL; ?>/></td>
                    <td><?php echo $row['TFOTemplateName'];?></td>
                    <td><?php echo $row['TFOTemplateDescription'];?></td>
                    <td><?php echo $row['TFOTemplateDetails'];?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <!----------------------- END ADD FORM INPUT ----------------------->
        <?php endif; /*($this->var['action']==???)*/?>
    </div>
    <!----------------------- END FORM BODY ----------------------->
    <!----------------------- BEGIN FORM ACTION ----------------------->
    <div class="form-actions">
        <div class="col-md-offset-4">
            <input class="btn green-jungle" type="submit" value="Submit" />
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
    <!----------------------- END FORM ACTION ----------------------->
</form>
<?php endif; ?>
<!-- END OF FILE: citizenship_addedit.php -->