<!-- BEGIN PAGE CONTENT-->
<?php if(isset($this->var['data'])) : ;?>
<pre><?php print_r($this->var['data']);?></pre>
<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
                <?php if(isset($this->var['section_array'])):?>
                <span class="uppercase bold font-grey-gallery font-md">Section</span> &nbsp;&nbsp;
                        <?php foreach($this->var['section_array'] as $section) :?>
                        <?php 
                            $section['name'] = isset($section['name']) ? $section['name'] : $section; /*if each row is an array and 'name' key is found then set the value to that item else the row is considered string then set the value to that string */
                            $section_label = isset($section['label']) ? $section['label'] : $section['name']; /*if 'label' key is found that set the value to that item else set the value to 'name' item */
                        ?>
                        <?php if(!isset($section['hidden']) OR (isset($section['hidden']) && $section['hidden']==FALSE)) : ?>
                            <a href="<?php echo $this->var['page_url'].$section['name'].(isset($this->var['action']) && ($this->var['action']=='view' OR $this->var['action']=='add') ? '/action/'.$this->var['action'] : NULL);?>" class="btn btn-circle btn-medium <?php echo $section['name']==$this->var['section'] ? 'green-jungle' : 'btn-default';?>"><?php echo $section['label'];?></a>
                        <?php endif; ?>
                        <?php endforeach; ?>
                <?php endif; ?>
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green-jungle uppercase"><?php echo ($this->var['action']=='add' || $this->var['action']=='edit') ? $this->var['action'] : 'Masterlist'; ?></span>
                    <span class="caption-helper uppercase"><?php echo isset($this->var['section']) ? $this->var['section'] : $this->var['page_name']; ?></span>
                    <?php if($this->var['action']=='add' || $this->var['action']=='edit'):?>
                    <a href="<?php echo $this->var['section_url'];?>action/view<?php echo isset($this->var['id']) && $this->var['id']>0? '/id/'.$this->var['id'] : NULL;?>" class="btn btn-circle btn-default btn-sm"><i class="fa fa-list"></i> Masterlist</a>
                    <?php else :?>
                    <a href="<?php echo $this->var['section_url'];?>action/add<?php echo isset($this->var['id']) && $this->var['id']>0? '/id/'.$this->var['id'] : NULL;?>" class="btn btn-circle btn-default btn-sm"><i class="fa fa-plus"></i> Add</a>
                    <?php endif; ?>
                </div>
                <div class="actions">
                    <?php if($this->var['action']!="add" || $this->var['action']!="edit") :?>
                    <a class="btn btn-icon-only btn-circle btn-default" href="<?php echo $this->var['section_url'];?>action/export_to_pdf<?php echo isset($this->var['id'])? '/id/'.$this->var['id'] : NULL;?>" title="Export to PDF"><i class="fa fa-file-pdf-o"></i></a>
    </a>
                    <a href="<?php echo $this->var['section_url'];?>action/export_to_csv<?php echo isset($this->var['id']) && $this->var['id']>0? '/id/'.$this->var['id'] : NULL;?>" class="btn btn-circle btn-icon-only btn-default" title="Export to CSV"><i class="fa fa-file-text-o"></i></a>
                    <a href="javascript:;" class="btn btn-circle btn-icon-only btn-default DTTT_Print"><i class="fa  fa-print"></i></a>
                    <?php endif; ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-circle btn-sm btn-icon-only btn-default  fullscreen" href="#" data-original-title="" title=""></a>
                </div>
            </div>
            <div class="portlet-body <?php echo ($this->var['action']=='add'||$this->var['action']=='edit')? 'form' : NULL;?>">
                <?php $filepref = isset($this->var['section']) ? $this->var['section'] : $this->var['page_name'];?>
                <?php if($this->var['action']=='add' || $this->var['action']=='edit') : ?>
                    <?php file_exists(APPPATH.'views/form/'.$filepref.'_addedit.php') ? include 'form/'.$filepref.'_addedit.php' : include 'page_not_exists.php' ; ?>
                <?php else :?>
                    <?php file_exists(APPPATH.'views/masterlist/'.$filepref.'_masterlist.php') ? include 'masterlist/'.$filepref.'_masterlist.php' : include 'page_not_exists.php' ; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->