var BusinessFunctions = function(){
    
    var $ifoure_protocol = window.location.protocol;
    var $ifoure_hostname = window.location.hostname;
    if($ifoure_hostname=='localhost')
    {
        $ifoure_hostname += '/iapps4egov';
    }
    var $ifoureSite = $ifoure_protocol + '//' + $ifoure_hostname + '/';
    var autoLoadSelect2 = function(){
        
        /*Person*/
        $("#transaction-get-tfo").change(function(){
            var $target_form = $(this).attr('data-target');
            var $transaction = $(this).val();
            var $tfo_template_id = $(this).attr('data-tfo-template-id');
            var $option
            $.ajax({
                    url:$ifoureSite+'business_tfo_template/getAvailableTFO',
                    method: 'POST',
                    data:{transaction:$transaction,template_id:$tfo_template_id},
                    dataType:'json',
                    success:function($result){
                        $($target_form).select2({
                            data:$result,
                            placeholder: "Select",
                            allowClear: true
                        });
                        console.log($result);
                    }
            });
            
            var $formula_type = $('.input-formula-type:checked').val();
            var $tfo_template_id = $('.input-formula-type:checked').attr('data-tfo-template-id');
            if($formula_type=='complex' && $tfo_template_id){
                $('.div-available-variables').fadeIn('slow');
                $.ajax({
                    url:$ifoureSite+'business_tfo_template/getAvailableVariables',
                    method: 'POST',
                    data:{transaction:$transaction,template_id:$tfo_template_id},
                    dataType:'json',
                    success:function($result){
                        if($result)
                        {
                            var $html_content = "";
                            $.each($result,function($key,$data){
                                $html_content += "<span class='label label-info variable-tfo'>{"+$data['TFOName']+"}</span>";
                                });
                            $('.available-variable-list').append($html_content);
                        }
                    },
                    error:function(){
                        $('.div-available-variables').empty();
                    }
                });
            }
            if($transaction.length==0)
            {
                $('.variable-tfo').remove();
            }
            
        });
        var $basis_val;
        var $mode_val;
        $('.input-basis').change(function(){
            $basis_val = $(this).val();
           if($(this).val().length>0){
                var $mode_val = $('.input-mode-of-computation:checked').val();
                if($mode_val && $mode_val!='constant')
                {
                    $('.div-available-variables').show('slower');
                }
                var $html_content = "<span class='label label-info variable-basis'>["+$(this).val()+"]</span>";
                $('.variable-basis').remove();
                $('.available-variable-list').prepend($html_content);
                
                if($(this).val()=='InputtedValue' && $mode_val && $mode_val!='constant')
                {
                    $('.div-unit-of-measure').show('slower');
                }
                else
                {
                    $('.div-unit-of-measure').hide('fast');
                }
           }
           else
           {
               $('.variable-basis').remove();
               $('.div-unit-of-measure').hide('fast');
           }
        });
        
        $('document').ready(function(){
            $mode_val = $('.input-mode-of-computation:checked').val();
            console.log($basis_val);
            if(!$mode_val)
            {
                $('.div-unit-of-measure').hide('fast');
                $('.div-tfo-amount').hide('fast');
                $('.div-formula-type').hide('fast');
                $('.div-minimum-amount').hide('fast');
                $('.div-tfo-formula').hide('fast');
                $('.div-available-variables').hide('fast');
                $('.div-number-of-range').hide('fast');
                $('.table-range').hide('fast');
                $('.div-available-variables').hide('fast');
            }
            if($mode_val && $mode_val=='constant')
            {
                $('.div-unit-of-measure').hide('fast');
                $('.div-formula-type').hide('fast');
                $('.div-minimum-amount').hide('fast');
                $('.div-tfo-formula').hide('fast');
                $('.div-available-variables').hide('fast');
                $('.div-number-of-range').hide('fast');
                $('.table-range').hide('fast');
            }
            if($mode_val && $mode_val=='formula')
            {
                $('.div-tfo-amount').hide('fast');
                $('.div-number-of-range').hide('fast');
                $('.table-range').hide('fast');
                if($('.input-basis').val().length==0)
                {
                    $('.div-available-variables').hide('fast');
                }
            }
            if($mode_val && $mode_val=='range')
            {
                $('.div-tfo-amount').hide('fast');
                $('.div-formula-type').hide('fast');
                $('.div-tfo-formula').hide('fast');
                if($('.input-basis').val().length==0)
                {
                    $('.div-available-variables').hide('fast');
                }
            }
            if($('.input-basis').val().length==0 || $('.input-basis:selected').val()!='InputtedValue')
            {
                $('.div-unit-of-measure').hide('fast');
            }
        });
        
        $('.input-mode-of-computation').change(function(){
            $mode_val = $(this).val();
            switch($(this).val())
            {
                case 'constant':
                    $('.div-unit-of-measure').hide('fast');
                    $('.div-minimum-amount').hide('fast');
                    $('.div-formula-type').hide('fast');
                    $('.div-tfo-formula').hide('fast');
                    $('.div-available-variables').hide('fast');
                    $('.div-number-of-range').hide('fast');
                    $('.table-range').hide('fast');
                    $('.div-tfo-amount').show('slower');
                    break;
                case 'formula':
                    $('.div-tfo-amount').hide('fast');
                    $('.div-available-variables').hide('fast');
                    $('.div-number-of-range').hide('fast');
                    $('.table-range').hide('fast');
                    if($basis_val=='InputtedValue')
                    {
                        $('.div-unit-of-measure').show('slower');
                    }
                    $('.div-formula-type').show('slower');
                    $('.div-minimum-amount').show('slower');
                    $('.div-tfo-formula').show('slower');
                    $('.div-available-variables').show('slower');
                    break;
                case 'range':
                    $('.div-tfo-amount').hide('fast');
                    $('.div-tfo-formula').hide('fast');
                    $('.div-formula-type').hide('fast');
                    $('.table-range').show('fast');
                    $('.div-minimum-amount').show('slower');
                    $('.div-number-of-range').show('slower');
                    break;
            }
        });
        
        $('.input-formula-type').change(function(){
            switch($(this).val())
            {
                case 'simple':
                    $('.variable-tfo').remove();
                    break;
                case 'complex':
                    $('.div-available-variables').fadeIn('slow');
                    var $transaction =  $("#transaction-get-tfo").val();
                    var $tfo_template_id = $(this).attr('data-tfo-template-id');
                    $.ajax({
                        url:$ifoureSite+'business_tfo_template/getAvailableVariables',
                        method: 'POST',
                        data:{transaction:$transaction,template_id:$tfo_template_id},
                        dataType:'json',
                        success:function($result){
                            if($result)
                            {
                                var $html_content = "";
                                $.each($result,function($key,$data){
                                    $html_content += "<span class='label label-info variable-tfo'>{"+$data['TFOName']+"}</span>";
                                    });
                                $('.available-variable-list').append($html_content);
                            }
                        },
                        error:function(){
                            $('.div-available-variables').empty();
                        }
                    });
                    break;
            }
        });
        
        $('.input-number-of-range').blur(function(){
            $('.table-range').fadeIn('slow');
            var $tbody = $('.table-range tbody');
            var $num = $(this).val();
            var $range = $('.tr-range').length;
            
            if($range<$num)
            {
                $('.input-range-formula:last').val('').attr('readonly','');
                $('.input-range-higher-limit:last').removeAttr('readonly');
                for($i=$range;$i<$num;$i++)
                {
                    var $a=$i+1;
                    
                    var $html_content = "<tr class='tr-range'>";
                        $html_content += "<td><input type='hidden' class='form-control input-range-lower-limit' name='data[Range]["+$i+"][RangeNumber]' value='"+$a+"'/>"+$a+"</td>";
                        $html_content += "<td><input type='text' class='form-control input-range-lower-limit' name='data[Range]["+$i+"][LowerLimit]'/></td>";
                        $html_content += "<td><input type='text' class='form-control input-range-higher-limit' name='data[Range]["+$i+"][HigherLimit]'/></td>";
                        $html_content += "<td><input type='text' class='form-control input-range-amount' name='data[Range]["+$i+"][Amount]'/></td>";
                        $html_content += "<td><input type='text' class='form-control input-range-formula' name='data[Range]["+$i+"][Formula]' readonly/></td>";
                        $html_content += "</tr>";

                    $tbody.append($html_content);
                }
                $('.input-range-formula:last').removeAttr('readonly');
                $('.input-range-higher-limit:last').attr('readonly','');
            }
            
            if($range>$num)
            {
                var $rem = $range-$num;
                for($x=1;$x<=$rem;$x++)
                {
                    $('.tr-range:last').remove();
                }
                $('.input-range-formula:last').removeAttr('readonly');
                $('.input-range-higher-limit:last').val('').attr('readonly','');
            }
        });
        $('.input-range-amount:last').keyup(function(){
           if($(this).val().length>0)
           {
               $('.input-range-formula:last').html('').attr('readonly','');
           }
           else
           {
               $('.input-range-formula:last').removeAttr('readonly');
           }
           console.log('xxx');
        });
        $('.input-range-formula:last').blur(function(){
           if($(this).val().length>0)
           {
               $('.input-range-amount:last').val('0').attr('readonly','');
           }
           else
           {
               $('.input-range-amount:last').removeAttr('readonly');
           }
        });
        /*Person*/
        $(".input-person").select2({
            placeholder: "Select",
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: $ifoureSite+"person/searchPerson",
                dataType:"json",
                data: function (term) {
                    return {
                        q: term, // search term
                    };
                },
                results: function(data){
                    return {results:data};
                }
            }
        });
        
    }
    return{
        init: function(){
            autoLoadSelect2();
        }
    };
}();