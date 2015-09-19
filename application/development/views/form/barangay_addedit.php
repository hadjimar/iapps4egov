<?php 
if($this->var['action']=='edit' && isset($this->var['barangay_list']))
{
    $name = $this->var['barangay_list'][0]['BarangayName'];
    $id = $this->var['barangay_list'][0]['BarangayID'];
    $province_id = $this->var['barangay_list'][0]['ProvinceID'];
    $citymunicipality_id = $this->var['barangay_list'][0]['CityMunicipalityID'];
    $active = $this->var['barangay_list'][0]['Active'];
}
else
{
    $name = NULL;
    $id = NULL;
    $province_id = NULL;
    $citymunicipality_id = NULL;
    $type = NULL;
    $active = 1;
}
?>
<form class="form-horizontal" method="post">
    <div class="form-body" >
        <div class="form-parent-child">
            <div class="form-group ">
                <label class="col-md-3 control-label" >Province</label>
                <div class="col-md-9">
                    <select class="form-control input-inline input-medium form-parent " onchange="javascript:getChildrenData('ProvinceID',this.value,'city_municipality','CityMunicipalityID','CityMunicipalityName');">
                        <option value="">Select</option>
                        <?php if(isset($this->var['province_list'])) : ?>
                    <?php foreach($this->var['province_list'] as $row) :?>
                    <option value="<?php echo $row['ProvinceID'];?>" <?php echo $row['ProvinceID']==$province_id ? "Selected='selected'" : NULL ;?>><?php echo $row['ProvinceName'];?></option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </select>
                    <span class="help-inline text-danger"><?php echo form_error('data[ProvinceID]');?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" >CityMunicipality</label>
                <div class="col-md-9">
                    <select class="form-control input-inline input-medium form-child" name="data[CityMunicipalityID]" id="sel-citymunicipality" <?php echo $this->var['action']=='edit' && isset($this->var['citymunicipality_list']) ? NULL : "readonly='readonly'";?>>
                        <?php if($this->var['action']=='edit' && isset($this->var['citymunicipality_list'])) :?>
                        <?php foreach($this->var['citymunicipality_list'] as $row) :?>
                        <option value="<?php echo $row['CityMunicipalityID'];?>" <?php echo $row['CityMunicipalityID']==$citymunicipality_id ? "Selected='selected'" : NULL; ?>><?php echo $row['CityMunicipalityName'];?></option>
                            <?php endforeach; /*($this->var['citymunicipality_list'] as $row)*/?>
                        <?php endif; /*($this->var['action']=='edit' && isset($this->var['citymunicipality_list']))*/?>
                    </select>
                    <span class="help-inline text-danger"><?php echo form_error('data[CityMunicipalityID]');?></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control input-inline input-medium" name="data[BarangayName]" value="<?php echo $name; ?>"/>
                <span class="help-inline text-danger"><?php echo form_error('data[BarangayName]');?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label" >Active</label>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch input-set-active" data-on-color="primary" data-off-text="No" data-on-text="Yes" data-record-id="<?php echo $id;?>" data-db-table="barangay" data-key-field="BarangayID" <?php echo $active==1 ? "checked=''" : NULL; ?>/>
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
