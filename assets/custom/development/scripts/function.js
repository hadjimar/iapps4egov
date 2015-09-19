var $ifoure_protocol = window.location.protocol;
var $ifoure_hostname = window.location.hostname;
if($ifoure_hostname=='localhost')
{
    $ifoure_hostname += '/iapps4egov';
}
var $ifoure_site = $ifoure_protocol + '//' + $ifoure_hostname + '/';

$(document).on("keypress", ":input:not(textarea)", function(event) {
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});

/*BEGIN TOASTER NOTIFICATION*/
$(document).ready(function() {
    var $type = $('#toastr-notification').attr('data-notification-type');
    var $heading = $('#toastr-notification').attr('data-notification-heading');
    var $content = $('#toastr-notification').attr('data-notification-content');
    if($type && $heading && $content) 
    {   
        Command: toastr[$type]($content, $heading)
        
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
    }
});
/*END TOASTER NOTIFICATION*/

/*BEGIN GETTING CHILD DATA */
/*Loop trhough html tags with class='form-parent-child'*/
$.each($('.form-parent-child'),function(){
    var $this = $(this);
    /*Look for its html content with class='form-parent'*/
    var $form_parent = $(this).find('.form-parent');
    /*When the class='form-parent' is in focus add 'form-parent-focused' class to 'form-parent-child'*/
    $form_parent.focus(function(){
       $($this).addClass('form-parent-focused'); 
    });
    /*When the class='form-parent' is out of focus remove 'form-parent-focused' class from 'form-parent-child'*/
    $form_parent.blur(function(){
       $($this).removeClass('form-parent-focused'); 
    });
    /*Look for its html content with class='form-child'*/
    var $form_child = $(this).find('.form-child');
    /*When the class='form-child' is in focus add 'form-child-focused' class to 'form-parent-child'*/
    $form_child.focus(function(){
       $($this).addClass('form-child-focused'); 
    });
    /*When the class='form-child' is out of focus remove 'form-child-focused' class from 'form-parent-child'*/
    $form_child.blur(function(){
       $($this).removeClass('form-child-focused'); 
    });
});


/**
 * Get the Children Data
 * @param {string} $parent_dbfield  The name of database field of parent(ex:ParentID,ProvinceID,etc)
 * @param {int} $parent_id   The parent id of child data
 * @param {string} $dbtable  The database table where the children data will come from(ex:city_municipality,barangay)
 * @param {string} $dbfieldval  The name of database field that will be set as value of form when submitted(ex: CityMunicipalityID)
 * @param {string} $dbfielddesc  The name of database field that will be seen on form(ex: CityMunicipalityName)
 * @returns {html content}
 */
function getChildrenData($parent_dbfield,$parent_id,$dbtable,$dbfieldval,$dbfielddesc)
{
    /*When class='form-parent' in on focus get the child data*/
    $.each($('.form-parent-focused'),function(){
        var $form_child = $(this).find('.form-child');
        var $form_grandchild = $(this).find('.form-grandchild');
        var $option;
        if($parent_id.length>0)
        {
            $.ajax({
                    url:$ifoure_site+'main/getChildrenData',
                    method: 'POST',
                    data:{parent_dbfield:$parent_dbfield,parent_id:$parent_id, dbtable:$dbtable,dbfieldval:$dbfieldval,dbfielddesc:$dbfielddesc},
                    dataType:'json',
                    success:function($result){
                        $option += "<option value=''>Select...</option>";
                        $.each($result,function($key,$data){
                        $option += "<option value='"+$data[$dbfieldval]+"'>";
                        $option += $data[$dbfielddesc] + "</option>";
                        });
                        $form_child.removeAttr('readonly');
                        $form_child.html($option);
                    },
                    error:function(){
                        console.log('Error getting data from '+$dbtable);
                        $form_child.attr('readonly','');
                        $form_child.html('');
                    }
            });
        }
        else
        {
            $form_child.html('');
            $form_child.attr('readonly','');
            $form_grandchild.html('');
            $form_grandchild.attr('readonly','');
        }
    });
    /*When class='form-child' is on focus get the grand child data*/
    $.each($('.form-child-focused'),function(){
        var $form_grandchild = $(this).find('.form-grandchild');
        var $option;
        if($parent_id.length>0)
        {
            $.ajax({
                    url:$ifoure_site+'main/getChildrenData',
                    method: 'POST',
                    data:{parent_dbfield:$parent_dbfield,parent_id:$parent_id, dbtable:$dbtable,dbfieldval:$dbfieldval,dbfielddesc:$dbfielddesc},
                    dataType:'json',
                    success:function($result){
                        $option += "<option value=''>Select...</option>";
                        $.each($result,function($key,$data){
                        $option += "<option value='"+$data[$dbfieldval]+"'>";
                        $option += $data[$dbfielddesc] + "</option>";
                        });
                        $form_grandchild.removeAttr('readonly');
                        $form_grandchild.html($option);
                    },
                    error:function(){
                        console.log('Error getting data from '+$dbtable);
                        $form_grandchild.attr('readonly','');
                        $form_grandchild.html('');
                    }
            });
        }
        else
        {
            $form_grandchild.html('');
            $form_grandchild.attr('readonly','');
        }
    });
}
/*END GETTING CHILD DATA*/

/* BEGIN SHOW & HIDE PERMALINK : Adding and Editing Menu*/
/*Define variable*/
var $permalink;
/*Hide permalink by default when it has no value*/
$('document').ready(function(){
   $permalink += $('#menu-permalink').find('input').val();
    if($permalink.length==0)
    {
        $('#menu-permalink').hide();
    }
});
/**
 * Show the permalink if the selected menu type is either page, internal link, or external link
 * @param {string} $type  The selected menu type
 * @returns {event}  Hide or show event
 */
function showPermalink($type)
{
    var $types = ["page","internal link","external link"];
    if($types.indexOf($type)>=0)
    {
        $('#menu-permalink').show();
    }
    else
    {
        $('#menu-permalink').hide();
    }
}

/*Setting switch ACTIVE or NOT ACTIVE */
$('.input-set-active').on('switchChange.bootstrapSwitch', function(event, state) {
    var $id = $(this).attr('data-record-id');
    var $dbtable = $(this).attr('data-db-table');
    var $keyfield = $(this).attr('data-key-field');
    var $value;
    if(state===true){$value =1 }else {$value = 0}
    
    $.ajax({
                url:$ifoure_site+'main/setActive',
                method: 'POST',
                data:{id:$id, dbtable:$dbtable,keyfield:$keyfield,value:$value},
                success:function($result){
                }
        });
//  console.log($object); // true | false
//  console.log($data); // true | false
//  console.log($id); // true | false
//  console.log($dbtable); // true | false
//  console.log($dbfield); // true | false
//  console.log($value); // true | false
//  console.log(this); // DOM element
//  console.log(event); // jQuery event
//  console.log(state); // true | false
});

$('.input-icon').on('change',function(){
   $(this).parent({
//    checkboxClass: 'icheckbox_minimal-red',
    radioClass: 'iradio_line-grey',
    increaseArea: '20%' // optional
    });
});