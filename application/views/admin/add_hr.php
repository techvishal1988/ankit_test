<link rel="stylesheet" href="<?php echo base_url("assets/css/fastselect.min.css"); ?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls {width:38em !important; }

.my-form{border-radius:0px; background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
<!--.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;--> 
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important;}

.control-label
{ 
    line-height:40px;
}
.form-control
{
  height:42px;
} 

/* css for autocomplete */
 .ui-autocomplete {         
          max-height: 200px; 
          overflow-y: auto;         
          overflow-x: hidden;         
          padding: 0px;
          margin: 0px;
        }

 .panel-body form fieldset legend, .mailbox-content h3{background-color: rgba(255,255,255,0.8) !important;}
 .fstChoiceRemove{top:57%;}       

</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li><a href="<?php echo base_url("view-user-right-details/".$role_select); ?>">User Rights</a></li>
        <li class="active">Add HR</li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
    <h3>Add Staff</h3>
</div>
</div> -->

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if($msg){echo $msg;} ?>      
            <div class="panel-body">
            	<form  id="frm_select_all" class="form-horizontal" method="post" action="" style="display:none;">
                	<?php echo HLP_get_crsf_field();?>
                  	<input type="hidden" name="hf_select_all_filters" value="1" />
                    <input type="hidden" name="show_email" id="show_email"  />
                    <input type="hidden" name="show_name" id="show_name"  />
                    <input type="submit" id="btn_select_all" value="Select All" class="btn btn-primary"/>
                </form>
                <?php $select_all = "";
                      if($this->input->post("hf_select_all_filters"))
                      {
                        $select_all = 'selected="selected"';  
                      }
                      ?>
            	
                <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                	<?php echo HLP_get_crsf_field();?>
                  <fieldset>
                    <legend>User Details:</legend>
                    <div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">
                        Email</label>
                        <div class="col-sm-9 form-input removed_padding">
                            <input id="txt_email" name="txt_email" type="email" class="form-control" required="required" value="<?php if(isset($_POST['show_email'])){ echo $_POST['show_email'];} ?>"  maxlength="50">
                            <span class="rights_exist" style="color:red;" ></span>
                        </div>
                         <!-- <label title="Email already exist." class="col-sm-1 control-label email_exist" style="display:none;">
                       <i class="fa fa-check-circle col-sm-1 " aria-hidden="true" style="font-size:25px; color:green;"></i>
                       </label> -->
                    </div>                
                    
                    <div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Name</label>
                        <div class="col-sm-9 form-input removed_padding">
                            <input id="txt_name" name="txt_name" type="text" class="form-control" value="<?php if(isset($_POST['show_name'])){ echo $_POST['show_name'];} ?>" required="required" maxlength="50">
                        </div>
                    </div>
                    <!--<div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9 form-input">
                            <input id="txt_pwd" name="txt_pwd" type="password" class="form-control" required="required" maxlength="30">
                        </div>
                    </div> -->
                    
                    <?php /*?><div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 control-label">Designation</label>
                        <div class="col-sm-9 form-input">
                             <select id="ddl_user_designation" name="ddl_user_designation" class="js-states form-control" tabindex="-1" style="width: 100%" required="required">
                                <option  value="">Select</option>
                                <?php foreach($designation_list as $row){?>
                                <option  value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
                                <?php } ?>
                               
                            </select>
                        </div>
                    </div><?php */?>    
					
                    <div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Role</label>
                        <div class="col-sm-9 form-input removed_padding">
                             <select id="ddl_role" name="ddl_role" class="js-states form-control" tabindex="-1" style="width: 100%" required="required">
                                <option value="">Select</option>                                
                                <?php /*?><option value="3">HR Partner Level 1</option>
                                <option value="4">HR Partner Level 2</option>
                               <option value="5">HR Head</option><?php */?>
                               <?php 
                            	
                            	foreach ($roles as $row) {
                                    if($row['id']!=6){
                                        $sel = '';
                                        if( (!empty($role_select)) && ($row["id"] == $role_select))
                                            $sel = 'selected = "selected" ';
                                        echo "<option ".$sel." value='".$row["id"]."'>".$row["name"]."</option>";
                                    }
                            	}
								?>                                
                            </select>
                        </div>
                    </div>
                   <!-- <div class="form-group my-form">
                        <label for="inputPassword3" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9 form-input">
                            <select id="ddl_status" name="ddl_status" class="js-states form-control" tabindex="-1" style=" width: 100%">
                                <option  value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>    -->  
                    </fieldset>
                    
                    <fieldset><legend>Access Details:
                    		<input style="margin-top:2px;" type="button" id="btn_all" value="Select All" class="pull-right btn btn-success"  onclick="submit_select_all_frm();"/>
                    </legend>
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Country</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($country_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>                       
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">City</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_city" onchange="hide_list('ddl_city');" name="ddl_city[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($city_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Business Level 1</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($bussiness_level_1_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Business Level 2</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($bussiness_level_2_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Business Level 3</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($bussiness_level_3_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Function</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_function" onchange="hide_list('ddl_function');" name="ddl_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($function_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Sub Function</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_sub_function" onchange="hide_list('ddl_sub_function');" name="ddl_sub_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($sub_function_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Sub Sub Function</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_sub_subfunction" onchange="hide_list('ddl_sub_subfunction');" name="ddl_sub_subfunction[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($sub_subfunction_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Designation</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($designation_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Grade</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($grade_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Level</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0">All</option>
                                <?php foreach($level_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    </fieldset>                    
                    
                    <div class="">
                        <div class="mob-center">
                            <input type="submit" id="btnAdd" value="Add" class="btn btn-success pull-right" />
                           <!--  <a href="<?php //echo site_url("upload-employee"); ?>"><button class="btn btn-success" type="button">Import Bulk Employee</button></a> -->
                        </div>
                    </div>
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>
<script>
  $( function() {    
    $( "#txt_email" ).autocomplete({
        minLength: 2,        
        source: '<?php echo site_url("admin/admin_dashboard/autocomplete_email"); ?>',
        select: function(event, ui) {
          var name=ui.item.value.split('@');
          $('#txt_name').val(name[0]);
          $('#show_name').val(name[0]);
          $('#show_email').val(ui.item.value);
     }
    });
  } );
  </script>

<script>
   $('.multipleSelect').fastselect();
   
	$('#txt_email').blur(function(){	
		if($("#txt_email").val())
		{
			$('.email_exist').hide();	
			$('.rights_exist').html("");
			$.post("<?php echo site_url("admin/admin_dashboard/check_email_exist"); ?>",{"email_id":$("#txt_email").val()},function(data){
			   if(data)
			   {
                
				   var response = JSON.parse(data);
				   $("#txt_name").val(response.emp_name);
				   if(response.status == 2)
				   {
					   //$('.email_exist').show();				  
				   }
				   else if(response.status == 3)
				   {
					   //$('.email_exist').show();
					   $('.rights_exist').html("Rights already created for this user.");
				   }
			   }
			 });
		}	 
	 });
	 

</script>

<script>
function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()==0)
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
                //if($(this).attr("data-value")!= 0)
                //{
                    $(this).find(".fstChoiceRemove").trigger("click");
                //}
            });
			show_list(obj_id);
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}

function show_list(obj)
{
    $('#'+ obj ).siblings('.fstResults').children('.fstResultItem') .each(function(i, selected)
	{
        if($(this).html()!='All')
        {
            $(this).trigger("click");
        }
    });
}


function submit_select_all_frm()
{
	$("#btn_select_all" ).trigger( "click" );
}


  $(function() {
  $(".fstMultipleMode").addClass('dexpand');
});
</script>