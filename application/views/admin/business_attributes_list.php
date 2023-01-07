<style>

@media screen and (max-width: 767px)
{
	.lll{
	width:320px !important;
	
}
.marginTopbtn{
	margin-top:5px;
}
}

</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
<li>General Settings</li>
        
        <li class="active">Business Attributes</li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
     <div class="row">
        <div class="col-sm-5 mob-center">
            <h3>Business Attributes</h3>
        </div>

        <div class="col-sm-7 mob-center">
            <div class="pull-right">
                <a href="<?php //echo site_url("add-business-attributes"); ?>"><button class="btn btn-success" type="button">Add Business Attributes</button></a>
            </div>
        </div>
    </div>
</div>
</div> -->

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row">
			<div class="col-md-12 background-cls">
               <div class="mailbox-content">
                <?php echo $msg; echo $this->session->flashdata('message'); ?> 
               <?php 
                    if(!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_INSERT_RIGHT_NAME))
                    {
                        $dis='disabled';
                        $style='style="display:none;"';
                         echo '<style>.beg_color input[type="checkbox"]:hover + span:before{border:2px #999 solid !important}</style>';
                    }
               ?>

               <style type="text/css">
               .busi_attr_form{display: block; width: 100%; padding: 0px 15px;}
               .busi_attr_form .form-group select.form-control{height: 25px; padding:3px 8px!important}    
               .busi_attr_form .form-group{margin-right: 15px;}
               .busi_attr_form .form-group label{margin-top: 4px; margin-right: 5px;}
               .busi_attr_form .btn{margin-right:15px;}
               </style>
                    <div class="row">
                        <div class="busi_attr_form">
                        <form class="form-inline frm_cstm_popup_cls_default" action="<?php echo site_url("business-attributes"); ?>" method="post" >
                        	<?php echo HLP_get_crsf_field();?>
                            <div class="form-group">
                                <label class="w_hit_col wht_lvl"for="email" >Status:</label>
                                <select id="ddl_attribute_status" name="ddl_attribute_status" class="js-states form-control mob_b_m" tabindex="-1">  
                                    <option value="">All</option>                             
                                    <option value="Yes" <?php if(($this->session->userdata('ba_attribute_status_ddl_ses')) and $this->session->userdata('ba_attribute_status_ddl_ses') == "Yes"){ echo 'selected="selected"';} ?>>Yes</option>
                                    <option value="No" <?php if(($this->session->userdata('ba_attribute_status_ddl_ses')) and $this->session->userdata('ba_attribute_status_ddl_ses') == "No"){ echo 'selected="selected"';} ?>>No</option>
                                </select>
                            </div>
                            
                           
                           <div class="form-group">
                                <label class="w_hit_col wht_lvl" for="email" >Is Required:</label>
                                <select id="ddl_is_required" name="ddl_is_required" class="js-states form-control mob_b_m" tabindex="-1">  
                                <option value="">All</option>                             
                                <option value="Yes" <?php if(($this->session->userdata('ba_is_required_ddl_ses')) and $this->session->userdata('ba_is_required_ddl_ses') == "Yes"){ echo 'selected="selected"';} ?>>Yes</option>
                                <option value="No" <?php if(($this->session->userdata('ba_is_required_ddl_ses')) and $this->session->userdata('ba_is_required_ddl_ses') == "No"){ echo 'selected="selected"';} ?>>No</option>
                                </select>
                            </div>
                            <input type="submit" id="btn_search" value="Search" class="btn btn-success" />
                            <a href="<?php echo site_url("export-business-attributes");?>"><input type="button" id="btn_export" value="Export" class="btn btn-success" /></a>
                          </form>                       
                        </div>                    
                    </div>                             
                </div>
            </div>
</div>

    <div class="row mb40">
        <?php if(count($business_attributes_list)==0){
            echo '<div class="alert alert-danger alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong></strong> No result found.
                  </div>';
        } ?>
		


                <form class="frm_cstm_popup_cls_businessattit" action="<?php echo site_url("update-business-attributes"); ?>" method="post" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_businessattit')">
                	<?php echo HLP_get_crsf_field();?>
			<div class="table-responsive">
                <table id="example" class="table border" style="width:100%;" cellspacing: 0;">
                    <thead>
                        <tr>
                            <?php /*?><!--<th class="hidden-xs" width="4%"><input type="checkbox" class="check-mail-all"></th>--><?php */?>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Attribute Name</th>  
                            <th>New Display Name</th>
                            <th>Is Required</th>
                            <th> Active/Inactive </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0;
                     foreach($business_attributes_list as $row)
                     {
                        echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                        echo "<td>".$row["ba_name_cw"]."</td>";                       
						echo '<td><input '.@$dis.' type="text" name="txt_ba_display_name[]" value="'.$row["display_name"].'" class="form-control lll" maxlength="45"/>
						<input type="hidden" name="hf_ba_id[]" value="'.$row["id"].'" class="form-control" /></td>';
                       /* if($row["data_type_code"] == 'INT')
                        {
                            echo "<td>NUMBER</td>";
                        }
                        elseif($row["data_type_code"] == 'VARCHAR')
                        {
                            echo "<td>STRING</td>";
                        }
                        else
                        {
                            echo "<td style='text-transform: lowercase; text-transform:capitalize;'>".$row["data_type_code"]."</td>";
                        }*/

                         if($row["is_required"] == 1)
                        {?>
                             <td align="center">
                            <?php /*?> <a href="<?php echo site_url("change-business-attributes-required")."/".$row["id"]."/0";?>" onclick="return confirm('Are you sure, You want to remove this attribute from required list?');"><b>Yes</b></a><?php */?>
                            <div class="beg_color">
                            <label><!--Yes--> &nbsp; <input <?php echo @$dis ?> type="checkbox" id="ck_required_<?php echo $row["id"]; ?>" class="ck_required"  name="chk_ba_required[]" checked="checked" value="<?php echo $row["id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                             
                             </td>  
                        <?php }
                        else
                        {?>
                            <td align="center">
                             <?php /*?><a href="<?php echo site_url("change-business-attributes-required")."/".$row["id"]."/1";?>" onclick="return confirm('Are you sure, You want to add this attribute in required list?');"><b>No</b></a><?php */?>
                            <div class="beg_color">
                            <label><!--No--> &nbsp; <input <?php echo @$dis ?> id="ck_required_<?php echo $row["id"]; ?>" class="ck_required" type="checkbox" name="chk_ba_required[]" value="<?php echo $row["id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                             
                             </td> 
                        <?php }

                        if($row["status"])
                        {?>
                            <td align="center">
                            <?php /*?> <a href="<?php echo site_url("change-business-attributes-status")."/".$row["id"]."/0";?>" onclick="return confirm('Are you sure, You want to Inactive this attribute?');"><b>Active</b></a><?php */?>
                            <?php  if(helper_have_rights(CV_BUSINESS_ATTRIBUTES, CV_VIEW_RIGHT_NAME))
                                    { ?>
                            <div class="beg_color">
                            <label><!--Active--> &nbsp; <input <?php echo @$dis ?> id="ck_active_<?php echo $row["id"]; ?>" class="ck_active" type="checkbox" name="chk_ba_active[]" checked="checked" value="<?php echo $row["id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                                    <?php } ?>
                             </td>   
                        <?php }
                        else
                        {?>
                             <td align="center">
                                 
                             <?php /*?><a href="<?php echo site_url("change-business-attributes-status")."/".$row["id"]."/1";?>" onclick="return confirm('Are you sure, You want to Active this attribute?');"><b>Inactive</b></a><?php */?>
                            <?php
                                if(helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME))
                                    {
                            ?>     
                           <div class="beg_color">
                            <label><!--Inactive--> &nbsp; <input <?php echo @$dis ?> type="checkbox" id="ck_active_<?php echo $row["id"]; ?>" class="ck_active" name="chk_ba_active[]" value="<?php echo $row["id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                                    <?php } ?>
                             </td> 
                        <?php }                       
                        echo "</tr>";
                $i++;
                     }
                     ?>  
                     
                    </tbody>
                   </table> 
				   </div><!--End responsive div-->
                   
                    <div class="row">
                            <div class="col-sm-12">
                            <div class="overrt_btn">                    
                            	<input <?php echo @$style ?>  type="submit" class="btn btn-primary pull-right" value="Save" />
                            </div>
                        </div>
                    </div>
					 
                 </form>
				 
				  
              				 
                   </div> 
</div>

<script>
    $(document).ready(function(){
        var validids = '<?php echo CV_BUSINESS_REQUIRED_ACTIVE_INACTIVE_ARRAY;?>';
        $('.ck_required').click(function(){
            var reqval = $(this).val();
            var conv = JSON.parse(validids);

            if( $(this).prop('checked') == false ) {
                for(var i = 0; i < conv.length; i++) {
                    if(reqval == conv[i]) {
                        setTimeout(function(){ 
                            $('#ck_required_'+reqval).trigger('click');
                        }, 50);
                    }
                }
                
            }
        });

        $('.ck_active').click(function(){
            var reqval = $(this).val();
            var conv = JSON.parse(validids);

            if( $(this).prop('checked') == false ) {
                for(var i = 0; i < conv.length; i++) {
                    if(reqval == conv[i]) {
                        setTimeout(function(){ 
                            $('#ck_active_'+reqval).trigger('click');
                        }, 50);
                    }
                }
                
            }
        });

    });
</script>

