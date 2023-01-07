<?php // echo "<pre/>";print_r($attributes); ?>
<style>
.form_head ul{ padding:0px; margin-bottom:0px;}
.form_head ul li{ display:inline-block;}

.rule-form .control-label {
	font-size: 12px;
	line-height: 30px;
}
.rule-form .form-control {
	height: 30px;
	margin-top: 0px;
	font-size: 12px;
	background-color: #FFF;
	margin-bottom:10px;
}
.rule-form .control-label {
	font-size: 11.25px;
	background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
	
}
.rule-form .form-control:focus {
	box-shadow: none!important;
}
.rule-form .form_head {
	background-color: #f2f2f2;
	border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
}
.rule-form .form_head .form_tittle {
	display: block;
	width: 100%;
}
.rule-form .form_head .form_tittle h4 {
	font-weight: bold;
	color: #000;
	text-transform: uppercase;
	margin: 0;
	padding: 12px 0px;
	margin-left: 5px;
}
.rule-form .form_head .form_info {
	display: block;
	width: 100%;
	text-align: center;
}
.rule-form .form_head .form_info i {
	color: #8b8b8b;
	font-size: 24px;
	padding: 7px;
}
.rule-form .form_sec {
	background-color: #f2f2f2;
	margin-bottom: 10px;
	display: block;
	width: 100%;
	padding: 5px 0px 9px 0px;
	border-bottom-left-radius: 6px;
	border-bottom-right-radius: 6px;
}
.rule-form .form_info .btn-default {
	border: 0px;
	padding: 0px;
	background-color: transparent!important;
}
.rule-form .form_info .tooltip {
	border-radius: 6px !important;
}
.mar10 {
	margin-bottom: 10px !important;
}
</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <!--<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
                <li><a href="<?php echo site_url("staff"); ?>">Employee List</a></li>
		<?php if(isset($staffDetail) and !empty($staffDetail)){ ?>
		<li class="active">Edit Employee</li>
		<?php }else{ ?>
                <li class="active">Add Employee</li>
		<?php } ?>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-white">
              
            <div class="panel-body">
                <div class="rule-form">
                    <div class="form-group">
                        <form class="frm_cstm_popup_cls_default" method="post" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default');">
                        <?php echo HLP_get_crsf_field();?>
                        <div class="row">
							<div class="col-sm-12">
								<?php echo $this->session->flashdata('message'); 
								if($msg){echo $msg;} ?>
							</div>
                            
                            <?php 
                            	$roles_str = "";
                            	foreach ($roles as $row) {
                                        if($row['id']!=6){
                            		$roles_str .= "<option value='".$row["id"]."'>".$row["name"]."</option>";
                                        }
								}
								$tooltip=getToolTip('add-employee');
								$val = json_decode($tooltip[0]->step);
								$tool_id = 0;
                              foreach($attributes as $key=>$value){ ?>
                            
                            <div class="col-sm-12 ">
                                <div class="form_head clearfix">
                                   <div class="col-sm-12">
                                      <ul>
                                       <li>
                                          <div class="form_tittle">
                                            <h4><?php echo $key;?></h4>
                                          </div>
                                          </li>
                                        <li>
                                      <div class="form_info">
                                        <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php echo $val[$tool_id];?>"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                        </div>
                                       </li>
                                      </ul>
                                   </div>
                                </div>
                                <div class="form_sec clearfix">
                                  <div class="col-sm-12">
									  <?php 
									  $tool_id++;
									  $i=1;
									  foreach($value as $atti){
                                           if($atti['is_required']==1){
                                               $req="required";
                                               $reqmark='*';
                                           }else{
                                               $req="";
                                               $reqmark='';
                                           }
                                          if($atti['status']==1){
                                          ?>
                                    <div class="col-sm-6">
                                      <label for="input<?php echo $i;?>" class="control-label"><?php echo $atti['display_name'].$reqmark; ?></label>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-input">
                                        <input type="text" id="txt_<?php echo $atti['id'];?>" name="txt_<?php echo $atti['id'];?>" <?php echo $req; ?> <?php if($atti['id'] == CV_CURRENCY_ID){?> maxlength="5" <?php } ?> class="form-control" value="<?php echo $staffDetail[$atti['ba_name']] ?>"/>
                                      </div>
                                    </div>
                                    <?php $i++; } }
										if($key=="Personal"){?>
										<div class="col-sm-6">
                                      <label for="input" class="control-label">Role*</label>
                                    </div>
										<div class="col-sm-6">
										  <div class="form-input">
											<select id="ddl_role" name="ddl_role" class="js-states form-control" tabindex="-1" style="width: 100%" required="required" onchange="show_hide_manage_hr_only_dv()">
												<option value="">Select</option>
											 <?php foreach ($roles as $row) { ?>
<option value='<?php echo $row["id"]; ?>' <?php if($staffDetail['role']==$row["id"]){ echo "selected";} ?>><?php echo $row["name"] ?></option>
        <?php } ?>
                                                            
											</select>
										  </div>
										</div>
										
										<div class="col-sm-6 dv_manage_hr_only">
										  	<label for="input" class="control-label">Managing HR Only</label>
										</div>
										<div class="col-sm-6 dv_manage_hr_only">
										  <div class="form-input">
												<div class="beg_color" style="margin-top:5px;">
													<label>&nbsp; 
														<input type="checkbox" name="chk_manage_hr_only"  value="1" id="chk_manage_hr_only" style="opacity:1; margin-top:1px;"><span></span>
													</label>
												</div>
										  </div>
										</div>
									<?php } ?>
                                  </div>
                                </div>
                              </div>
                            <?php } ?>
                                
                                <!--<input type="button" id="btnAdd" value="Add" class="btn btn-success" />-->
                           
                        </div>
                            <div class="form-input" style="text-align:center;">
							<?php if(isset($staffDetail) and !empty($staffDetail)){ ?>
							<input type="submit" id="btnAdd" value="Update" class="btn btn-success pull-right" />
							<?php }else{ ?>
							<input type="submit" id="btnAdd" value="Add" class="btn btn-success pull-right" />
							<?php } ?>
                                
                                </div>
                             </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<script>
  $( function() {    
    $( "#txt_64,#txt_65,#txt_66,#txt_67" ).autocomplete({
        minLength: 2,        
        source: "<?php echo base_url("admin/admin_dashboard/autocomplete_email_for_approver"); ?>",
        select: function(event, ui) {

     }
    });
  } );
  
  </script>
  <script type="text/javascript">
    $(function () {
		$('#txt_'+'<?php echo CV_BA_ID_COMPANY_JOINING_DATE; ?>'+',#txt_'+'<?php echo CV_DATE_OF_JOINING_FOR_INCREMENT_PURPOSES_ID; ?>'+
		',#txt_'+'<?php echo CV_BA_ID_START_DATE_FOR_ROLE; ?>'+',#txt_'+'<?php echo CV_BA_ID_END_DATE_FOR_ROLE; ?>' +
		',#txt_'+'<?php echo CV_EFFECTIVE_DATE_OF_LAST_SALARY_INCREASE_ID; ?>'+
		',#txt_'+'<?php echo CV_BA_ID_EFFECTIVE_DATE_OF_2ND_LAST_SALARY_INCREASE; ?>'+
		',#txt_'+'<?php echo CV_BA_ID_EFFECTIVE_DATE_OF_3RD_LAST_SALARY_INCREASE; ?>'+
		',#txt_'+'<?php echo CV_BA_ID_EFFECTIVE_DATE_OF_4TH_LAST_SALARY_INCREASE; ?>'+
		',#txt_'+'<?php echo CV_EFFECTIVE_DATE_OF_5TH_LAST_SALARY_INCREASE_ID; ?>'+
		',#txt_'+'<?php echo CV_BA_ID_EMPLOYEE_MOVEMENT_INTO_BONUS_PLAN; ?>'
		).datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: false,
           
            dateFormat: 'yy-mm-dd',
            onClose: function (dateText, inst) {
            
            }
        });
        
    });
</script>
<script>
   //$('.multipleSelect').fastselect();
   
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
					   $('.email_exist').show();				  
				   }
				   else if(response.status == 3)
				   {
					   $('.email_exist').show();
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
                if($(this).attr("data-value")!= 0)
                {
                    $(this).find(".fstChoiceRemove").trigger("click");
                }
            });
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}
<?php if (isset($staffDetail) and ! empty($staffDetail)) { ?>
      
        $("input[name=txt_<?php echo CV_EMAIL_ID; ?>]").attr('readonly','readonly');
        $("input[name=txt_<?php echo CV_EMAIL_ID; ?>]").css('background-color','#eee');
        $("input[name=txt_<?php echo CV_EMAIL_ID; ?>]").css('cursor','not-allowed');
        
        
<?php } ?>

show_hide_manage_hr_only_dv();
function show_hide_manage_hr_only_dv()
{
	$(".dv_manage_hr_only").hide();
	var role = $("#ddl_role").val();
	if(role == '3' || role == '4' || role == '5')
	{
		$(".dv_manage_hr_only").show();
	}
	else
	{
		$("#chk_manage_hr_only").prop("checked", false);
	}
}
</script>