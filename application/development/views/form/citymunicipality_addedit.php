<?php 
if($this->var['action']=='edit' && isset($this->var['citymunicipality_list']))
{
    $name = $this->var['citymunicipality_list'][0]['CityMunicipalityName'];
    $id = $this->var['citymunicipality_list'][0]['CityMunicipalityID'];
    $parent_id = $this->var['citymunicipality_list'][0]['ProvinceID'];
    $type = $this->var['citymunicipality_list'][0]['CityMunicipalityType'];
    $active = $this->var['citymunicipality_list'][0]['Active'];
}
else
{
    $name = NULL;
    $id = NULL;
    $parent_id = NULL;
    $type = NULL;
    $active = 1;
}
?>
<form class="form-horizontal" method="post">
    <div class="form-body" >
        <div class="form-group">
            <label class="col-md-3 control-label" >Province</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" name="data[ProvinceID]">
                    <option value="">Select...</option>
                    <?php if(isset($this->var['province_list'])) : ?>
                    <?php foreach($this->var['province_list'] as $row) :?>
                    <option value="<?php echo $row['ProvinceID'];?>" <?php echo $row['ProvinceID']==$parent_id ? "Selected='selected'" : NULL; ?>><?php echo $row['ProvinceName'];?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[ProvinceID]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[CityMunicipalityName]" value="<?php echo $name; ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[CityMunicipalityName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Type</label>
            <div class="col-md-9">
                <select class="form-control input-inline input-medium select2me" name="data[CityMunicipalityType]">
                    <option value="">Select...</option>
                    <?php $type_array = array('mun'=>'Municipality','cc'=>'Component City','icc'=>'Independent Component City','huc'=>'Highly Urbanized City'); ?>
                    <?php foreach($type_array as $key=>$val) :?>
                    <option value=<?php echo $key;?> <?php echo $key==$type ? "Selected='selected'" : NULL; ?>><?php echo $val; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="help-inline text-danger"><?php echo form_error('data[CityMunicipalityType]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $id; ?>" data-db-table="city_municipality" data-key-field="CityMunicipalityID" <?php echo $active==1 ? "checked=''" : NULL; ?>/>
                <span class="help-inline text-danger"><?php echo form_error('data[Active]');?></span>
            </div>
        </div>
        <?php if(isset($this->var['err_message'])) :?>
        <div class="note note-<?php echo $this->var['err_message']['type'];?>">
            <span><?php echo $this->var['err_message']['content'];?></span>
        </div>
        <?php endif; /*(isset($this->var['err_message']))*/?>
    </div>
    <div class="form-actions">
        <div class="col-md-offset-4">
            <input class="btn green" type="submit" name="btn_citymunicipality_addedit" value="Submit" />
            <a href="<?php echo $this->var['section_url'];?>" class="btn default">Cancel</a> 
        </div>
    </div>
</form>
