      <script>
    function reset_token() {
    $('#loading').show();
    $.ajax({
        url: '<?Php echo site_url('dashboard/get_crsf_field'); ?>',
        type: 'GET',
        success: function (res) {
          console.log('========',res);
            $('input[name=csrf_test_name]').val(res);
            $("#loading").hide();
        }
    });
    }
    $( function() {

var availableTags = [];
$.ajax("<?php echo site_url("survey/getQuestion"); ?>", {
      type: 'POST',  // http method
      data: {'csrf_test_name':$('input[name=csrf_test_name]').val() },  // data to submit
      async:false,
      beforeSend: function(jqXHR, settings){
        
            },
      success: function (data, status, xhr) {
        //console.log(data);
         var obj = JSON.parse(data);
         //console.log(obj);
         for(var i=0;i<obj.length;i++){
          availableTags.push(obj[i].QuestionName);
         }
        
      },
      error: function (jqXhr, textStatus, errorMessage) {
        console.log('error');
        
      },complete:function(){
        reset_token();
      }
    });

    
    $( "#question_name" ).autocomplete({
      source: availableTags,
      autoSelectFirst:true
    });
  } );
  </script>
<script type="text/javascript">
	
 
 $(document).ready(function(){
    $('#qustiontypeoption').on('change', function() {
         $("#ranking").hide();
         $("#matrix").hide();
         $("#scale").hide();
          $('.both').hide(); 
         $('.newRow').remove();
      if ( this.value == '1' || this.value == '2' || this.value == '3')
      {
      	$('.ans_value').each(function(k,v){
      		$(this).val('');
      	});
      }
      if ( this.value == '1'){

      }else if ( this.value == '2'){
        $('.both').show();
        $('.answers').hide(); 
      }else if ( this.value == '3'){
        custom_alert_popup('3');
        $('.both, .answers').show(); 
      }else if ( this.value == '4')
      {
      	$('.ans_value').each(function(k,v){
      		$(this).val("Rank 0"+k);
      	})
        $("#ranking").show();
      }
      else if ( this.value == '5')
      {
        $("#matrix").show();
      }
      else if ( this.value == '6')
      {
                                   
      	var arr = [ "Dissatisfied", "Somewhat Satisfied" ,"Very Satisfied " ,"ExtremelySatisfied"]
      	$('.ans_value').each(function(k,v){
      		$(this).val(arr[k]);
      	});
      	ratingDisable();
		ratingEnable();
        $("#scale").show();
      }

    });
});
	function remove(obj){
		var optionId = $(obj).attr('rid');
		$('#header'+optionId).remove();
		$('#body'+optionId).remove();
		$(obj).parent().parent().parent().remove();
		//alert();
	}
	function addMore(obj){
		var optionId = $(obj).attr('rid');
		var nextOption = (parseInt(optionId)+1);
		var option_value = "";
		//alert($('#qustiontypeoption').val());
		if($('#qustiontypeoption').val() == '4'){
			option_value = "Rank "+nextOption;
			var rankHtml = '<th class="newRow" id="header'+nextOption+'">Rank '+nextOption+'</th>';
			var rankBody = '<td class="newRow" id="body'+nextOption+'"><input type="text" name="rankRespose[]" class="form-control" id="exampleInputEmail1" placeholder="Response no."></td>';
			$('#rankHeader').append(rankHtml);
			$('#rankBody').append(rankBody);
		}

		if($('#qustiontypeoption').val() == '6'){
			option_value = "Option "+nextOption;
			var rankHtml = '<option class="newRow" value="'+option_value+'">'+option_value+'</option>';
			//var rankBody = '<td class="newRow" id="body'+nextOption+'"><input type="text" name="rankRespose[]" class="form-control" id="exampleInputEmail1" placeholder="Response no."></td>';
			$('#example-movie').append(rankHtml);
			//$('#example-movie').barrating('set', 2);
			//$('#example-movie').barrating();
			ratingDisable();
			ratingEnable();
			// $('#example-movie').barrating('show', {
   //          theme: 'bars-movie'
   //      });
			//$('#rankBody').append(rankBody);
		}
		
		var html = '<div class="col-md-6 newRow">'
        html += '<div class="form-group my-form">'
        html += '<label class="col-sm-4 col-xs-12 control-label grey removed_padding white black" for="QuestionName"> Response '+nextOption+'</label>';
        html += '<div class="col-sm-7 col-xs-12 form-input removed_padding">';
        html += '<input required="true" rid="'+nextOption+'" type="text" id="survey_name'+nextOption+'" name="answer[]" value="'+option_value+'" placeholder="Enter question name" class="form-control answare" maxlength="1000">';
        html += '</div>'; 
        html +='<div class="col-sm-1 col-xs-12"><button type="button" rid="'+nextOption+'"  onclick="remove(this)" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div>';
        html += '</div>';
        html += '</div>';
        $(obj).attr('rid',nextOption);
        $('#optionSection').append(html);
	}
</script>