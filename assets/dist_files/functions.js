$(document).ready(function(){
	/* When click on change profile pic */	
	$('#change-profile-pic').on('click', function(e){
        topFunction();
        $('#profile_pic_modal').modal({show:true,backdrop: 'static', keyboard: false});  
        $('body').addClass('bodycss');
       
    });	
	$('#profile-pic').on('change', function(){ 
		$("#preview-profile-pic").html('');
		$("#preview-profile-pic").html('Uploading....');
		$("#cropimage").ajaxForm(
		{
		target: '#preview-profile-pic',
		success:    function() { 
				$('img#photo').imgAreaSelect({
				aspectRatio: '1:1',
				onSelectEnd: getSizes,
			});
			$('#image_name').val($('#photo').attr('file-name'));
                        
			}
		}).submit();
        $('#loading').hide();
	});
	/* handle functionality when click crop button  */
	$('#save_crop').on('click', function(e){
           
    e.preventDefault();
    params = {
            id:$('#hdn-profile-id').val(),
            targetUrl: base_url+'/admin/admin_dashboard/edit_company_logo',
            action: 'save',
            x_axis: $('#hdn-x1-axis').val(),
            y_axis : $('#hdn-y1-axis').val(),
            x2_axis: $('#hdn-x2-axis').val(),
            y2_axis : $('#hdn-y2-axis').val(),
            thumb_width : $('#hdn-thumb-width').val(),
            thumb_height:$('#hdn-thumb-height').val(),
            image_name:$('#image_name').val(),
            pic_modal:'profile_pic_modal',
            pic_src:'profile_picture'
        };
        saveCropImage(params);
    });
    /* Function to get images size */
    //start
    
    $('#bg_image').on('click', function(e){
        topFunction();
        $('#bg_pic_modal').modal({show:true,backdrop: 'static', keyboard: false});        
        $('body').addClass('bodycss');
        
    });	
	$('#bg-pic').on('change', function(){ 
		$("#preview-profile-pic").html('');
		$("#preview-profile-pic").html('Uploading....');
		$("#cropimagebg").ajaxForm(
		{
		target: '#preview-profile-pic-bg',
		success:    function() { 
				$('img#photo').imgAreaSelect({
				aspectRatio: '1:1',
				onSelectEnd: getSizesBg,
			});
			$('#image_name_bg').val($('#photo').attr('file-name'));
                       
			}
		}).submit();
 $('#loading').hide();
	});
	/* handle functionality when click crop button  */
	$('#save_crop_bg').on('click', function(e){
           
    e.preventDefault();
    params = {
            id:$('#hdn-profile-id-bg').val(),
            targetUrl: base_url+'/admin/admin_dashboard/edit_company_bg',
            action: 'save',
            x_axis: $('#hdn-x1-axis-bg').val(),
            y_axis : $('#hdn-y1-axis-bg').val(),
            x2_axis: $('#hdn-x2-axis-bg').val(),
            y2_axis : $('#hdn-y2-axis-bg').val(),
            thumb_width : $('#hdn-thumb-width-bg').val(),
            thumb_height:$('#hdn-thumb-height-bg').val(),
            image_name:$('#image_name_bg').val(),
            pic_modal:'bg_pic_modal',
            pic_src:'profile_picture_bg'
        };
        saveCropImage(params);
    });
    //end
    
    
    
    function getSizesBg(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
			$('#hdn-x1-axis-bg').val(x_axis);
			$('#hdn-y1-axis-bg').val(y_axis);
			$('#hdn-x2-axis-bg').val(x2_axis);
			$('#hdn-y2-axis-bg').val(y2_axis);
			$('#hdn-thumb-width-bg').val(thumb_width);
			$('#hdn-thumb-height-bg').val(thumb_height);
        } else {
            custom_alert_popup("Please select portion..!");
		}
    }
    function getSizes(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
			$('#hdn-x1-axis').val(x_axis);
			$('#hdn-y1-axis').val(y_axis);
			$('#hdn-x2-axis').val(x2_axis);
			$('#hdn-y2-axis').val(y2_axis);
			$('#hdn-thumb-width').val(thumb_width);
			$('#hdn-thumb-height').val(thumb_height);
        } else {
            custom_alert_popup("Please select portion..!");
		}
    }
    /* Function to save crop images */
    function saveCropImage(params) {
		$.ajax({
			url: params['targetUrl'],
			cache: false,
			dataType: "html",
			data: {
				action: params['action'],
				id: params['id'],
				 t: 'ajax',
                                w1:params['thumb_width'],
                                x1:params['x_axis'],
                                h1:params['thumb_height'],
                                y1:params['y_axis'],
                                x2:params['x2_axis'],
                                y2:params['y2_axis'],
                                image_name :params['image_name']
			},
			type: 'Post',
		   	success: function (response) {
                            console.log(JSON.parse(response));
                            var jval=JSON.parse(response);
                            $('body').removeClass('bodycss');
                            custom_alert_popup(jval['status']);
                            $('#loading').hide();
                            $('#'+params['pic_modal']).modal('hide');
                            $(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');

                            $("#"+params['pic_src']).attr('src', jval['image']);
                            $("#preview-profile-pic").html('');
                            $("#profile-pic").val();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				custom_alert_popup('status Code:' + xhr.status + 'Error Message :' + thrownError);
			}
		});
    }
});
function removeoverlay()
{
     $('body').removeClass('bodycss');
     $(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
}
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}