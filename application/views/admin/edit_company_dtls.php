<script src="<?php echo base_url("assets/js/jscolor.js"); ?>"></script>
<script>
var base_url='<?php echo base_url() ?>';
</script>
<script src="<?php echo base_url() ?>assets/dist_files/jquery.imgareaselect.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/dist_files/jquery.form.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/dist_files/imgareaselect.css">
<script src="<?php echo base_url() ?>assets/dist_files/functions.js"></script>

<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>

<style>
.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstControls{line-height:13px;}
/*.rule-form .form-control{height:38px !important;} */
.rule-form .control-label{line-height:38px !important;}
.fstControls{width: 39em !important;}
.my-form{    background: #fff !important;}
.fstResults{position:inherit !important; z-index:999;}
.form-input{padding-left: 0px;}
/*.frm_inpt{height: 30px;}*/
.form-horizontal .control-label{line-height: 29px;}
.form-horizontal .fstMultipleMode {
    padding-top: 3px !important;}
</style>

  <div class="page-breadcrumb">
      <ol class="breadcrumb container">
      <li>General Settings</li>
      <li class="active">Edit Company Profile</li>
  </ol>
  </div>

<div id="main-wrapper">
  <div class="row mb20">
  	<div class="col-md-8 col-md-offset-2">
          <div class="panel panel-white">
              <div class="panel-body">
                  <!--<p id="msg">-->
                  <?php $tooltip=getToolTip('edit-company');$val=json_decode($tooltip[0]->step);?><!--</p>-->
                  
                    <?php if(($msg) or $this->session->flashdata('message')){?>
                        <div class="">
                            <?php echo $this->session->flashdata('message');
                        if($msg){echo $msg;} ?>
                        </div>  
                    <?php } ?> 

                  <form class="form-horizontal frm_cstm_popup_cls_default" action="" method="post" enctype="multipart/form-data" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                  		<?php echo HLP_get_crsf_field();?>
                      <?php /*?><div class="form-group my-form">
                          <label for="inputEmail3" class="col-sm-4 control-label">Company Name</label>
                          <div class="col-sm-8 form-input">
                              <input id="txtCompany" type="text" class="form-control" name="txt_company" required="required" maxlength="200" value="<?php echo $company_dtl["company_name"]; ?>">
                          </div>
                      </div><?php */?>
                      
                      <fieldset class="company-theme-sett">
  						  <legend >Company Settings:</legend>
                          <div class="my-form nobg" style="margin-bottom: 15px !important; display: flow-root;">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Company Theme Color <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[0] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>

                              <div class="col-sm-8 col-xs-12 form-input">
                                  <input id="txt_color" type="text" class="form-cust-control jscolor" name="txt_color" required="required" maxlength="50" value="<?php echo $company_dtl["company_color"]; ?>">
                              </div>

                          </div>
                          <div class="my-form nobg" style="margin-bottom: 15px !important; display: flow-root;">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Company Theme Light Color <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[1] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input">
                                  <input id="txt_light_color" type="text" class="form-cust-control jscolor" name="txt_light_color" required="required" maxlength="50" value="<?php echo $company_dtl["company_light_color"]; ?>">
                              </div>
                          </div>
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Company Logo <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-4 col-xs-12 form-input">
                                 <input id="comp_logo" type="file" class="form-control" name="comp_logo" title="Choose a image for the company logo." accept="image/*">
                                  <!--<a type="button" class="btn btn-primary" id="change-profile-pic">Upload Company logo</a>-->
                              </div>
                              <div class="col-sm-4 col-xs-12 form-input">
                                  <img class="com_logo"  data-holder-rendered="true" id="profile_picture" src="<?php echo $company_dtl["company_logo"]; ?>">
                              </div>
                          </div>                      
                          <div class="form-group my-form nobg">
                                          <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Company BG Image <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[3] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                                          <div class="col-sm-4 col-xs-12 form-input">
                                               <input id="comp_bg_img" type="file" class="form-control" name="comp_bg_img" title="Choose a image for the company background." accept="image/*" data-filetype="jpg,jpeg,png" data-filesize="true">
                                              <!--<a type="button" class="btn btn-primary" id="bg_image">Upload Background Image</a>-->
                                          </div>
                                          <div class="col-sm-4 col-xs-12 form-input">
                                              <img class="com_bg" data-holder-rendered="true" id="profile_picture_bg" src="<?php echo $company_dtl["company_bg_img"]; ?>">
                                          </div>
                                      </div>
                      </fieldset>
                    
                      <fieldset>
  						  <legend>Configurations:</legend>
						  <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Managers Hierarchy Setup</label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding ">
                                  <select id="ddl_peer_graph_for" name="ddl_managers_hierarchy_based_on" class="js-states form-control" tabindex="-1" style=" width: 100%" required="required">
                                    <option value="<?php echo CV_MANAGERS_HIERARCHY_BY_MANUAL;?>" <?php if($company_dtl["managers_hierarchy_based_on"]==CV_MANAGERS_HIERARCHY_BY_MANUAL){?> selected="selected" <?php } ?>> Manual Hierarchy Setup</option>
                                    <option value="<?php echo CV_MANAGERS_HIERARCHY_BY_1ST_MANAGER;?>" <?php if($company_dtl["managers_hierarchy_based_on"]==CV_MANAGERS_HIERARCHY_BY_1ST_MANAGER){?> selected="selected" <?php } ?>>Automatic Hierarchy Setup From First Approver</option>
                                     <option value="<?php echo CV_MANAGERS_HIERARCHY_BY_INTEGRATION;?>" <?php if($company_dtl["managers_hierarchy_based_on"]==CV_MANAGERS_HIERARCHY_BY_INTEGRATION){?> selected="selected" <?php } ?>>Automatic Hierarchy Setup Through Integration</option>
                                </select>
                              </div>
                          </div>
						  
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Peers <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[4] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding ">
                                  <select id="ddl_peer_graph_for" name="ddl_peer_graph_for" class="js-states form-control" tabindex="-1" style=" width: 100%" required="required">
                                    <option value="<?php echo CV_DESIGNATION;?>" <?php if($company_dtl["peer_graph_for"]==CV_DESIGNATION){?> selected="selected" <?php } ?>> Designation</option>
                                    <option value="<?php echo CV_LEVEL;?>" <?php if($company_dtl["peer_graph_for"]==CV_LEVEL){?> selected="selected" <?php } ?>> Level</option>
                                     <option value="<?php echo CV_GRADE;?>" <?php if($company_dtl["peer_graph_for"]==CV_GRADE){?> selected="selected" <?php } ?>> Grade</option>
                                </select>
                              </div>
                          </div>

                          <div class="form-group my-form nobg">
                              <label for="ddl_peer_group_base" class="col-sm-4 col-xs-12 control-label">Peers Group Base <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[5] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding ">
                                  <select id="ddl_peer_group_base" name="ddl_peer_group_base" class="js-states form-control" tabindex="-1" style=" width: 100%" required="required">
                                    <option value="1" <?php if($company_dtl["peer_group_base"]=='1'){?> selected="selected" <?php } ?>> Company</option>
                                    <option value="2" <?php if($company_dtl["peer_group_base"]=='2'){?> selected="selected" <?php } ?>> Function</option>
                                </select>
                              </div>
                          </div>
                                                    
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Benchmark Type <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[5] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                  <select id="ddl_market_data_by" name="ddl_market_data_by" class="js-states form-control" tabindex="-1" style=" width: 100%" required="required">
                                    <option  value="<?php echo CV_MARKET_SALARY_ELEMENT; ?>" <?php if($company_dtl["market_data_by"]==CV_MARKET_SALARY_ELEMENT){?> selected="selected" <?php } ?> >Single</option>
                                    <option value="<?php echo CV_MARKET_SALARY_CTC_ELEMENT; ?>" <?php if($company_dtl["market_data_by"]==CV_MARKET_SALARY_CTC_ELEMENT){?> selected="selected" <?php } ?>>Multiple</option>
                                </select>
                              </div>
                          </div>
                          
                          
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Adhoc Salary Review <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                  <select id="ddl_adhoc_salary_review_for" name="ddl_adhoc_salary_review_for" class="js-states form-control" tabindex="-1" style=" width: 100%" required="required" onchange="show_preserved_days_dv();">
                                    <option  value="<?php echo CV_ADHOC_FULL_TIME; ?>" <?php if($company_dtl["adhoc_salary_review_for"]==CV_ADHOC_FULL_TIME){?> selected="selected" <?php } ?> >Any Time</option>
                                    <option value="<?php echo CV_ADHOC_ANNIVERSARY_TIME; ?>" <?php if($company_dtl["adhoc_salary_review_for"]==CV_ADHOC_ANNIVERSARY_TIME){?> selected="selected" <?php } ?>>Anniversary Based</option>
                                </select>
                              </div>
                          </div>
                          
                          
                          <div class="form-group my-form nobg" style="display:none;" id="dv_preserved_days">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Preserved Days For Anniversary Based Rule <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                  <input type="text" class="form-control" id="txt_preserved_days" name="txt_preserved_days" maxlength="3" value="<?php echo $company_dtl["preserved_days"]; ?>" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);">
                              </div>
                          </div>
                          
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 label_h control-label frm_inpt">Target Salary Elements <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[6] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding frm_inpt">
                                  <select id="ddl_target_sal_elem" onchange="hide_list('ddl_target_sal_elem');" name="ddl_target_sal_elem[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($salary_elem_list){
                                        $target_salary_applied_on_elem = "";
                                        if($company_dtl['target_sal_elem'])
                                        {
                                            $target_salary_applied_on_elem = explode(",", $company_dtl['target_sal_elem']);
                                        }
                                        foreach($salary_elem_list as $row){ ?>
                                    <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($target_salary_applied_on_elem) and in_array($row["business_attribute_id"], $target_salary_applied_on_elem)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                    <?php }} ?>
                                </select>
                              </div>
                          </div>
                          
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 label_h control-label">Total Salary Elements <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[7] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                  <select id="ddl_total_sal_elem" onchange="hide_list('ddl_total_sal_elem');" name="ddl_total_sal_elem[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($salary_elem_list){
                                        $total_salary_applied_on_elem = "";
                                        if($company_dtl['total_sal_elem'])
                                        {
                                            $total_salary_applied_on_elem = explode(",", $company_dtl['total_sal_elem']);
                                        }
                                        foreach($salary_elem_list as $row){ ?>
                                    <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($total_salary_applied_on_elem) and in_array($row["business_attribute_id"], $total_salary_applied_on_elem)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                    <?php }} ?>
                                </select>
                              </div>
                          </div>
                          
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 label_h control-label">Adhoc Salary Elements <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[8];?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                  <select id="ddl_adhoc_sal_elem" onchange="hide_list('ddl_adhoc_sal_elem');" name="ddl_adhoc_sal_elem[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($salary_elem_list){
                                        $adhoc_salary_applied_on_elem = "";
                                        if($company_dtl['adhoc_sal_elem'])
                                        {
                                            $adhoc_salary_applied_on_elem = explode(",", $company_dtl['adhoc_sal_elem']);
                                        }
                                        foreach($salary_elem_list as $row){ ?>
                                    <option  value="<?php echo $row["business_attribute_id"]; ?>" <?php if(($adhoc_salary_applied_on_elem) and in_array($row["business_attribute_id"], $adhoc_salary_applied_on_elem)){echo 'selected="selected"';}?>><?php echo $row["display_name"]; ?></option>
                                    <?php }} ?>
                                </select>
                              </div>
                          </div>
                          
                      </fieldset>


                      <fieldset class="company-theme-sett">
                <legend >Smtp Details:</legend>
                <?php 
                $smtpdeatils=unserialize($company_dtl["smtp_detail"]);
                 ?>
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Smtp User<span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" ><i class="fa fa-info" aria-hidden="true"></i></span></label>

                            <div class="col-sm-8 col-xs-12 form-input">
                                  <input id="user" type="text" class="form-control" name="smtp[user]"  maxlength="50" value="<?php echo $smtpdeatils['user'] ?>" >
                              </div>

                          </div>
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Smtp Password <span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input">
                                 <input id="password1" type="text" class="form-control " name="smtp[password]" maxlength="70" value="<?php echo $smtpdeatils['password'] ?>">
                               
                                  
                              </div>
                          </div>
                          <div class="form-group my-form nobg">
                              <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Smtp Host<span type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                              <div class="col-sm-8 col-xs-12 form-input">
                                 <input id="host" type="text" class="form-control" name="smtp[host]" value="<?php echo $smtpdeatils['host'] ?>" >
                                 
                              </div>
                             
                          </div>                      
                          <div class="form-group my-form nobg">
                                          <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Smtp Port <span type="button" class="tooltipcls" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                                          <div class="col-sm-8 col-xs-12 form-input">
                                               <input id="port" type="text" class="form-control" name="smtp[port]" value="<?php echo $smtpdeatils['port'] ?>" >
                                             
                                          </div>
                                         
                                      </div>
                               <div class="form-group my-form nobg">
                                          <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Connections Type <span type="button" class="tooltipcls" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                                          <div class="col-sm-8 col-xs-12 form-input">
                                            <select name="smtp[connections]" class="form-control">
                            <option value="">Select Connection Type</option>
                            <option value="TLS" <?php if($smtpdeatils['connections']=='TLS'){echo 'selected';} ?>>TLS </option>
                            <option value="SSL" <?php if($smtpdeatils['connections']=='SSL'){echo 'selected';} ?>>SSL</option>
                                            </select>
                                               
                                             
                                          </div>
                                         
                                      </div>

                                      <div class="form-group my-form nobg">
                                          <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Email<span type="button" class="tooltipcls" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                                          <div class="col-sm-8 col-xs-12 form-input">
                                               <input id="port" type="text" class="form-control" name="smtp[email]" value="<?php echo $smtpdeatils['email'] ?>" >
                                             
                                          </div>
                                         
                                      </div>

                                      <div class="form-group my-form nobg">
                                          <label for="inputEmail3" class="col-sm-4 col-xs-12 control-label">Name<span type="button" class="tooltipcls" ><i class="fa fa-info" aria-hidden="true"></i></span></label>
                                          <div class="col-sm-8 col-xs-12 form-input">
                                               <input id="port" type="text" class="form-control" name="smtp[name]" value="<?php echo $smtpdeatils['name'] ?>"  >
                                             
                                          </div>
                                         
                                      </div>
                      </fieldset>


                      
                      <div class="">
                          <div class="col-sm-offset-10 mob-center">
                              <input type="submit" id="btnAdd" value="Update" class="btn btn-success pull-right" />
                          </div>
                      </div>
                  </form>

              </div>
          </div>
      </div>
  </div>
 

	<div id="profile_pic_modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
                                    <button type="button" onclick="removeoverlay()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				   <h3>Upload Compnay Logo</h3>
				</div>
				<div class="modal-body">
					<form id="cropimage" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/admin_dashboard/changeProfilePic') ?>">
						<strong>Upload Logo Image:</strong><br>
						<input type="file" name="profile-pic" id="profile-pic" />
						<input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="1" />
						<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
						<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
						<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
						<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
						<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
						<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
						<input type="hidden" name="action" value="" id="action" />
						<input type="hidden" name="image_name" value="" id="image_name" />
						
						<div id='preview-profile-pic'></div>
					<div id="thumbs" style="padding:5px; width:600p"></div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="removeoverlay()" class="btn btn-primary" data-dismiss="modal">Close</button>
					<button type="button" id="save_crop" class="btn btn-primary">Crop & Update</button>
				</div>
			</div>
		</div>
	</div>
    <div id="bg_pic_modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" onclick="removeoverlay()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				   <h3>Upload Background Image</h3>
				</div>
				<div class="modal-body">
					<form id="cropimagebg" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/admin_dashboard/changeProfilePicbg') ?>">
						<strong>Upload Background Image:</strong> <br>
						<input type="file" name="bg-pic" id="bg-pic" />
						<input type="hidden" name="hdn-profile-id-bg" id="hdn-profile-id-bg" value="1" />
						<input type="hidden" name="hdn-x1-axis-bg" id="hdn-x1-axis-bg" value="" />
						<input type="hidden" name="hdn-y1-axis-bg" id="hdn-y1-axis-bg" value="" />
						<input type="hidden" name="hdn-x2-axis-bg" value="" id="hdn-x2-axis-bg" />
						<input type="hidden" name="hdn-y2-axis-bg" value="" id="hdn-y2-axis-bg" />
						<input type="hidden" name="hdn-thumb-width-bg" id="hdn-thumb-width-bg" value="" />
						<input type="hidden" name="hdn-thumb-height-bg" id="hdn-thumb-height-bg" value="" />
						<input type="hidden" name="action-bg" value="" id="action-bg" />
						<input type="hidden" name="image_name_bg" value="" id="image_name_bg" />
						
						<div id='preview-profile-pic-bg'></div>
					<div id="thumbs" style="padding:5px; width:600p"></div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" onclick="removeoverlay()" class="btn btn-primary" data-dismiss="modal">Close</button>
					<button type="button" id="save_crop_bg" class="btn btn-primary">Crop & Update</button>
				</div>
			</div>
		</div>
	</div>
    
<style>
  .bodycss{
      overflow: hidden;
      position:fixed;
  }
  .modal-header{padding: 0px 20px !important;}
  .modal-header .close{    margin-top: 20px !important;}
  .modal-header{
      background:#<?php echo $this->session->userdata('company_color_ses') ?> !important;
      color: #fff;
  }
.form-horizontal #txt_color.form-control{color: unset !important;}
    </style>
   <?php //echo '<pre />'; print_r($this->session->userdata('company_color_ses')) ?>
   <script src="<?php echo base_url("assets/js/custom.js"); ?>"></script>
   <script>

/**/



        
$('.multipleSelect').fastselect();

function hide_list(obj_id)
{
    
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
            	$(this).find(".fstChoiceRemove").trigger("click");
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

show_preserved_days_dv();
function show_preserved_days_dv()
{
	var adhoc_salary_review_for = $("#ddl_adhoc_salary_review_for").val();
	$("#dv_preserved_days").hide();
	$("#txt_preserved_days").prop('required',false);
	if(adhoc_salary_review_for == '<?php echo CV_ADHOC_ANNIVERSARY_TIME; ?>')
	{
		$("#dv_preserved_days").show();
		$("#txt_preserved_days").prop('required',true);
	}
	else
	{
		$("#txt_preserved_days").val('');
	}
}
</script>