<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
<?php  $text= stripslashes($templatedesc[0]->TemplateDesc);?>
<style type="text/css">
 div>img{width:auto !important; height: auto !important;}  
    .panel-group.defaultp
    {
        max-height: 67vh !important;
    }
    .panel#avl_temp
    {
        height: 70vh !important;
    }
#printcontent
{
    background-size: 100% 100%;
    padding-top: 60px;
    padding-left: 6%;
    height: 862px;
    background-repeat: no-repeat;
    padding-right: 6%;
    max-height: 862px;
    overflow-y: auto;
    width: 100%;
    /*overflow-x: hidden;*/
    background-image-resize: 1;
    display: inline-table;
}

#main-wrapper{margin-top: 12px;}
#preview_temp .modal-body{padding: 0px;}
#preview_temp .modal-header{margin-bottom: 0px;}
.textCon2 span{color:black !important;}

.width_a4_match{width:84%;}

@media (min-width:1400px){
 .panel-group.defaultp{ max-height: 65vh !important;}
 .panel#avl_temp{height: 67vh !important;}
 .Editor-editor{height: 57vh !important;}
}


</style>
<script type="text/javascript">
    $(document).ready(function () {
       $("#tempdesc").Editor({"fonts": false,'color':false});
       $('#tempdesc').Editor('setText', $("#descricaoHTML").html());
       $("#promotiontempdesc").Editor({"fonts": false,'color':false});
       $('#promotiontempdesc').Editor('setText', '<?php echo @$templatedesc[0]->PromotionDesc ?>');
<?php
if ($rating_for_current_yr) {
    foreach ($rating_for_current_yr as $rating_val) {
        $ratingdata = HLP_get_template_rating_data(@$templatedesc[0]->TemplateID, $rating_val['id']);
        ?>
                $("#rating<?php echo $rating_val['id'] ?>tempdesc").Editor();
                $('#rating<?php echo $rating_val['id'] ?>tempdesc').Editor('setText', '<?php echo @$ratingdata['raing_desc'] ?>');
        <?php
    }
}
?>
        $('form').submit(function () {
            var data = $('#contentarea').html();
            var data1 = $('.promotion_desc #contentarea').html();
            $('#desc').val(data);
            $('#promotion_desc').val(data1);
<?php
if ($rating_for_current_yr) {

    foreach ($rating_for_current_yr as $rating_val) {
        ?>
                    var data<?php echo $rating_val['id'] ?> = $('.rating<?php echo $rating_val['id'] ?>_desc #contentarea').html();
                    $('#rating<?php echo $rating_val['id'] ?>_desc').val(data<?php echo $rating_val['id'] ?>);
        <?php
    }
}
?>
            return true;
        });



    });
    function selectionpara(cls)
    {
        var selection = window.getSelection();
        var txt = document.getElementsByClassName(cls);
        var range = document.createRange();
        range.selectNodeContents(txt[0]);
        selection.removeAllRanges();
        selection.addRange(range);
    }
</script>
<script>
   

    function gettemplatedetail(templateid)
    {

        if (templateid.length > 0) {
            $.ajax({
                url: "<?php echo base_url('admin/template/getTemplate/') ?>" + templateid,
                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=x-user-defined");
                }
            })
                    .done(function (data) {


                        var jsondata = JSON.parse(data);
                $('#tempdesc').Editor('setText', jsondata[0].TemplateDesc.replace(/[[\]\\]/g, ""));
        $('#promotiontempdesc').Editor('setText', jsondata[0].PromotionDesc);
'<?php
                        if ($rating_for_current_yr) {

                            foreach ($rating_for_current_yr as $rating_for_current_yr_val1) {
                                ?>'
$.ajax({
                url: "<?php echo base_url('admin/template/getTemplateRatingDesc/') ?>" + templateid+'/'+'<?php echo $rating_for_current_yr_val1['id']; ?>',
                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=x-user-defined");
                }
            })
                    .done(function (data1) {


                        var jsondata1 = JSON.parse(data1);
                        $('#rating'+'<?php echo $rating_for_current_yr_val1['id'] ?>'+'tempdesc').Editor('setText', jsondata1[0].raing_desc);
                         

                    });

                            '<?php } }?>'




                        
                        $('#old_latterhead').val(jsondata[0].latter_head_url);
                    });
        } else {
            $('#tempdesc').Editor('setText', jsondata[0].TemplateDesc);
           
            $('#old_latterhead').val(jsondata[0].latter_head_url);
        }

    }
</script>
<div class="page-breadcrumb">
    <ol class="breadcrumb container-fluid">
        <li><a href="javascript:void(0)">General Settings</a></li>

        <li class="active">Create Letter Template</li>

    </ol>
</div>

<style>
    .myvarcls{
        height: 782px; overflow-y: scroll;
        word-wrap: break-word;
    }
    .surveyquestion p
    {
        text-align:left !important;
        padding: 5px 10px;
    }
    .penal_tittle{background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;color:#fff;}

    .surveyquestion{padding: 0px !important;}
	
    .textCon2 p {
    margin-bottom: 10px !important;
    color: #000 !important;
}
.textCon2 p  span{
    
    color: #000 !important;
}
.textCon2{
    margin: 0px;
    color: #000 !important;
}
    #example th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  color: white;
}

.panel .panel-body#avl_veri{overflow-y:auto; overflow-x: hidden; max-height: 60vh;}
.panel#avl_temp{height: 414px; margin-bottom: 0px;}
.form-group.nobmar{margin-bottom: 0px;}
.defaultp .panel-default>.panel-heading a{color: #<?php echo $this->session->userdata("company_color_ses"); ?>;}
.penal_tittlep{background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?> !important;}
.penal_tittlep label{ font-size: 16px; }

#menuBarDiv a.btn{padding: 3px 6px; font-size:11px !important;}

.textCon2 table{width:100% !important;}

.surveyquestion .form-group .form-control{ font-size: 11px !important; }

#exit_temp_list table tr th{color: #<?php echo $this->session->userdata("company_color_ses"); ?>;}

.padlt0{padding-left: 0px !important;}
</style>
<div id="main-wrapper" class="container-fluid">
    <div class="row mb20">
      <form id="frmtemplate" class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" enctype="multipart/form-data" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                        <?php echo HLP_get_crsf_field(); ?>
        <div class="col-md-12">
            <div class="panel panel-white pad_b_10">
              <div class="panel-body surveyquestion">
              <div class="row">
              <div class="col-sm-3">
               <div class="form-group my-form nobmar">
                            <label style="font-size: 10px !important" class="col-sm-6 control-label removed_padding paddingSam" for ="temptile" data-toggle="tooltip control-label" data-placement="bottom" title="Copy Existing Templates">Copy Existing Templates</label>
                            <div class="col-sm-6 form-input removed_padding">      
                                <select class="form-control mar_b_0" id="oldtemplates" onchange="gettemplatedetail(this.value)">
                                    <option value="">Select Templates</option>
                                    <?php if(!empty($template)){
                                        foreach ($template as $tempvalue) {?>
                                          <option value="<?php echo $tempvalue->TemplateID  ?>"><?php echo $tempvalue->TemplateTitle  ?></option>
                                       <?php  }
                                    } ?>
                                </select>
                            </div>
                </div>
              </div>
              <div class="col-sm-3 padlt0">
                <div class="form-group my-form nobmar">
                    <label style="font-size: 10px !important" class="col-sm-5 control-label removed_padding paddingSam" data-toggle="tooltip control-label" data-placement="bottom" for ="temptile" title="Template Title" > Template Title</label>
                    <div class="col-sm-7 form-input removed_padding"> 
                        <input required="true" type="text" id="title" name="title" value="<?php echo @$templatedesc[0]->TemplateTitle ?>" placeholder="Enter template title"  class="form-control inpt_h mar_b_0" onblur="validatetitle();" maxlength="150"/>
                    </div>
                </div>
              </div>
              <div class="col-sm-3 padlt0">
                <div class="form-group my-form nobmar">
                    <label style="font-size: 10px !important"  class="col-sm-5 control-label removed_padding paddingSam" data-toggle="tooltip control-label" data-placement="bottom" for ="temptile" title="Upload letter head format (Size : A4, File type : PNG, JPEG, JPG)">  Upload Letter Head </label>
                    <div class="col-sm-7 form-input removed_padding"> 
                        <input style="width:101%" type="file" id="latterhead" name="latterhead" class="form-control" accept="image/*" data-filesize="true" /> 
                        <input type="hidden" name="old_latterhead" id="old_latterhead" class="form-control" value="<?php echo @$templatedesc[0]->latter_head_url ?>" /> 
                    </div>
                </div>
              </div> 
              <div class="col-sm-3 padlt0">
                <div class="form-group my-form nobmar">
                    <label style="font-size: 10px !important" class="col-sm-5 control-label removed_padding paddingSam" data-toggle="tooltip control-label" data-placement="bottom" for ="temptile" title="Upload letter head format (Size : A4, File type : PNG, JPEG, JPG)"> Digital Signature </label>
                    <div class="col-sm-7 form-input removed_padding"> 
                        <input style="width:101%" type="file" id="digital_signature" name="digital_signature" class="form-control" accept="image/*" data-filesize="true" /> 
                        
                    </div>
                </div>
              </div> 
              <div class="col-sm-12 padlt0" style="margin-top: 3px;">
                <div style="margin-top:2px;">
                 <button style="margin-left:10px;" type="button" class="btn btn-primary pull-right" id="exist_list">
				 	<i class="glyphicon glyphicon-align-left"></i>
				 </button>
                <?php
                if ($st_save == 2) {
                    // update case
                    ?> 
                    <input type="submit" name="update" value="Update" class="btn btn-primary pull-right btn-w80" />
                <?php } else { ?>
                    <input type="submit" name="save" value="Save" class="btn btn-primary pull-right btn-w80" />
                <?php } ?>
                <input style="margin-right:10px;" type="button" value="Preview" class="btn btn-primary pull-right btn-w80" id="preview" />
 
              </div> 
              </div>
               </div> 
              </div>  
            </div>
        </div>
        <div class="col-md-4">
            <!--<div class="panel panel-white pad_b_10" style="position:fixed; width:22%;">-->
			   <div class="panel panel-white pad_b_10">
                <div class="panel-heading penal_tittlep"><label>Available Variable</label></div>
                <div id="avl_veri" class="panel-body surveyquestion pad0" style="padding-left: 0px !important; padding-right: 0px !important;">
                    <?php 
$business_attributes =$this->db->query("SELECT id, display_name,ba_name,ba_name_cw FROM `business_attribute` where module_name NOT IN ('market_salary','market_salary_ctc') and status=1 order by ba_attributes_order asc")->result_array(); 
if(!empty($business_attributes))
{
    foreach ($business_attributes as $value) {
        if($value['ba_name_cw']=='Books & Periodicals Allowances')
        {
  ?>
<p style="kfbgjdgbjdsgffdgfuydgf"> class="<?php echo $value['ba_name'] ?>" onclick="selectionpara('<?php echo $value['ba_name'] ?>')">{{Books And Periodicals Allowances}}</p>
<?php 
        }else
        {
         ?>
<p class="<?php echo $value['ba_name'] ?>" onclick="selectionpara('<?php echo $value['ba_name'] ?>')">{{<?php echo $value['ba_name_cw'] ?>}}</p>
<?php    
        }
      }}
      ?>
<p class="new_grade" onclick="selectionpara('new_grade')">{{New Grade}}</p>
<p class="new_level" onclick="selectionpara('new_level')">{{New Level}}</p>
<p class="new_designation" onclick="selectionpara('new_designation')">{{New Designation}}</p>
      <?php
      //'Salary Comments','Promotion Comments'
$other_att=array('Current Fixed Salary','Current Variable Salary','Current Total Salary','Current Positioning in pay range','Salary Increment Amount','Salary increase recommended by manager','Salary increase range','Promotion Increase amount','Promotion Increase %age','Final Total Increment Amount','Final Total increment %age','Final New Salary','Final Fixed Salary','Revised Variable Salary','New Positioning in Pay range','Additional Field1','Additional Field2','Additional Field3');
 ?>  
 
 
<p class="digital_signature" onclick="selectionpara('digital_signature')">{{digital_signature}}</p>
<p class="page_break" onclick="selectionpara('page_break')">{{page_break}}</p>
 <div class="panel-heading penal_tittlep"><label>Pre Define Tables</label></div>

  <p  class="promotion_content"  onclick="selectionpara('promotion_content')">{{promotion_content}}</p>
<p class="rating_content"  onclick="selectionpara('rating_content')">{{<?php echo CV_TEMPLATE_TABLE_RATING_CONTENT; ?>}}</p>

                    <p class="<?php echo CV_TEMPLATE_TABLE_COMPENSATION; ?>" onclick="selectionpara('<?php echo CV_TEMPLATE_TABLE_COMPENSATION; ?>')">{{<?php echo CV_TEMPLATE_TABLE_COMPENSATION; ?>}}</p>
                    <p class="<?php echo CV_TEMPLATE_TABLE_INCREMENT_BREAKUP; ?>" onclick="selectionpara('<?php echo CV_TEMPLATE_TABLE_INCREMENT_BREAKUP; ?>')">{{<?php echo CV_TEMPLATE_TABLE_INCREMENT_BREAKUP; ?>}}</p>

                    <p class="<?php echo CV_TEMPLATE_TABLE_BASIC_INFO; ?>" onclick="selectionpara('<?php echo CV_TEMPLATE_TABLE_BASIC_INFO; ?>')">{{<?php echo CV_TEMPLATE_TABLE_BASIC_INFO; ?>}}</p>
                    <p class="<?php echo CV_TEMPLATE_TABLE_FINAL_SALARY_WITH_PREVIOUS_YEAR; ?>" onclick="selectionpara('<?php echo CV_TEMPLATE_TABLE_FINAL_SALARY_WITH_PREVIOUS_YEAR; ?>')">{{<?php echo CV_TEMPLATE_TABLE_FINAL_SALARY_WITH_PREVIOUS_YEAR; ?>}}</p>

                    <p class="<?php echo CV_TEMPLATE_TABLE_FINAL_SALARY_ONLY_CURRENT_YEAR; ?>" onclick="selectionpara('<?php echo CV_TEMPLATE_TABLE_FINAL_SALARY_ONLY_CURRENT_YEAR; ?>')">{{<?php echo CV_TEMPLATE_TABLE_FINAL_SALARY_ONLY_CURRENT_YEAR; ?>}}</p>
<div class="panel-heading penal_tittlep"><label>Field From Salary Rule</label></div>
   <?php foreach ($other_att as $key => $value) {
      ?>
      <p class="<?php echo $value?>" onclick="selectionpara('<?php echo $value ?>')">{{<?php echo $value ?>}}</p>
      <?php
   } ?>


   <?php 
$remove_attname=array('education','critical_talent','critical_position','special_category','start_date_for_role','end_date_for_role','bonus_incentive_applicable','recently_promoted','performance_achievement','rating_for_current_year','rating_for_last_year','rating_for_2nd_last_year','rating_for_3rd_last_year','rating_for_4th_last_year','rating_for_5th_last_year','increment_applied_on','increment_purpose_joining_date','start_date_for_role','total_compensation','end_date_for_role');

 $salary_elememts= $this->db->query("SELECT * FROM `business_attribute` where  ba_grouping='Salary'  and status=1 ORDER BY `business_attribute`.`ba_attributes_order` ASC")->result_array();
 foreach ($salary_elememts as $value)
 {
    if(in_array($value['ba_name'],$remove_attname))
      { 
        continue; 
      }
    $att_list_array[$value['id']]=$value['ba_name_cw'];     
 }
 //print_r($att_list_array);
?>
<div class="panel-heading penal_tittlep"><label>Temp Table Field</label>   </div>
 <?php foreach ($att_list_array as $key => $value) {
    if($value=='Books & Periodicals Allowances')
     {
        ?>
        <p class="<?php echo $value ?>" onclick="selectionpara('<?php echo $value ?>')">{{Temp Books And Periodicals Allowances}}</p>
        <?php
     }else
     {
      ?>
       <p class="<?php echo $value?>" onclick="selectionpara('<?php echo $value ?>')">{{Temp <?php echo $value ?>}}</p>
      <?php
     }
  } ?>
  <p class="temp_total_compensation" onclick="selectionpara('temp_total_compensation')">{{Temp Total compensation}}</p>
<p class="revised_fixed_salary" onclick="selectionpara('revised_fixed_salary')">{{Temp Revised Fixed Salary}}</p>
                </div>

            </div>

        </div>
        <div class="col-md-8">

            <div id="avl_temp" class="panel panel-white pad_b_10">
                <?php
                echo $this->session->flashdata('message');
                if (@$msg) {
                    echo @$msg;
                }
                ?>   
                <?php //echo '<pre />'; print_r($templatedesc);      ?>
                <div class="panel-body surveyquestion">
                    
                    <div class="panel-group defaultp" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default ">
                            <div class="panel-heading" role="tab" id="headingmain">
                                <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsemain" aria-expanded="true" aria-controls="collapsemain">
                                  Main Template
                                </a>
                              </h4>
                              </div>
                            <div id="collapsemain" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                             <div class="form-group nobmar">
                                <div class="col-sm-12">
                                    <!-- <label class="wht_lvl" for ="description">Main Template</label> -->
<textarea class="form-control" id="tempdesc" placeholder="Enter Your Message"></textarea>
<input type="hidden" name="desc" id="desc" value="" />
<div id="descricaoHTML" style='display:none'><?php echo $text; ?></div>
                                </div>
                              </div>
                             </div>
                            </div>


                            <div class="panel-heading" role="tab" id="headingpramotion">
                                <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsepramotion" aria-expanded="false" aria-controls="collapsepramotion">
                                  Promotion Template
                                </a>
                              </h4>
                            </div>
                            <div id="collapsepramotion" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="form-group nobmar">
                                    <div class="col-sm-12 promotion_desc">
                                        <!-- <label class="wht_lvl" for ="description">Promotion Template</label> -->
                                        <textarea class="form-control" id="promotiontempdesc" placeholder="Enter Your Message" maxlength="25000"></textarea>
                                        <input type="hidden" name="promotion_desc" id="promotion_desc"/>
                                    </div>
                                </div>
                             </div>
                            </div>
                                
                        <?php
                        if ($rating_for_current_yr) {

                            foreach ($rating_for_current_yr as $rating_for_current_yr_val) {
                                ?>
                               <div class="panel-heading" role="tab" id="heading<?php echo $rating_for_current_yr_val['id'] ?>">
                                <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $rating_for_current_yr_val['id'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $rating_for_current_yr_val['id'] ?>">
                                  Rating - <?php echo $rating_for_current_yr_val['name'] ?> Template
                                </a>
                              </h4>
                              </div>
                              <div id="collapse<?php echo $rating_for_current_yr_val['id'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                  <div class="form-group nobmar">
                                    <div class="col-sm-12 rating<?php echo $rating_for_current_yr_val['id'] ?>_desc">
                                       <?php /*?><label class="wht_lvl" for ="description">Rating - <?php echo $rating_for_current_yr_val['name'] ?> Template</label><?php */?>
                                        <textarea class="form-control" id="rating<?php echo $rating_for_current_yr_val['id'] ?>tempdesc" placeholder="Enter Your Message" maxlength="25000"></textarea>
                                        <input type="hidden" name="rating_desc<?php echo $rating_for_current_yr_val['id'] ?>" id="rating<?php echo $rating_for_current_yr_val['id'] ?>_desc"/>
                                    </div>
                                </div>
                                </div>
                              </div>
                                <?php
                            }
                        }
                        ?>

                         </div>
                            
                          </div>
                         
                </div>
                
            </div>
            
     
        </div>


       </form> 
    </div>
</div>

<!-- Preview model start -->
<div class="modal fade tempmodel" id="exit_temp_list" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content for_a4">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Existing Template List</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                     <div class="col-md-12">
                        <div class="col-md-12 background-cls">
                       
                            <div class="mailbox-content">
                                <table id="example" class="table  border editorder" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                          
                                            <th>Existing Templates</th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_body">                   
                                     <?php if(!empty($template)){
                                            foreach ($template as $tempvalue) {?>

                                            <tr>
                                               
                                             <td><?php echo $tempvalue->TemplateTitle  ?></td>
                                              <td><a href="<?php echo  site_url("admin/template/template/").$tempvalue->TemplateID ?>"><span class="fa fa-edit"></span></a> | 
                                                <a href="<?php echo  site_url("admin/template/delete-template/").$tempvalue->TemplateID ?>" onclick="return confirm('Do you want to delete this template.')"><span class="fa fa-remove"></span></a></td>
                                            </tr>

                                           
                                           <?php  }
                                        } ?>
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                    </div>                
                </div>
            </div>

            <div  class="tempfooter modal-fo.panel#avl_tempter clearfix">
                <button type="button" class="btn btn-primary pull-right"  data-dismiss="modal">Close</button>
               <!--   <button type="button" class="btn btn-primary pull-right"  onclick='printDiv();'>Print</button> -->
            </div>
        </div>
    </div>
</div>



<!-- Preview model start -->
<div class="modal fade tempmodel" id="preview_temp" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content width_a4_match" style="margin-left:8%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                       <!--  <div class="my_bg2">
                            <img id="preview_img" src="" style="width:100%; height:842px;" />
                        </div> -->
                        <div id="printcontent" class="textCon2">
                           
                        </div>
                    </div>                
                </div>
            </div>

            <div  class="tempfooter modal-fo.panel#avl_tempter clearfix">
                <button type="button" class="btn btn-primary pull-right"  data-dismiss="modal">Close</button>
               <!--   <button type="button" class="btn btn-primary pull-right"  onclick='printDiv();'>Print</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade tempmodel" id="imagePreview" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content for_a4">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Image Preview</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <!-- <div class="">
                            <img class="img-responsive"  src="" style="width:100%; height:auto;" />
                        </div> -->
                        <div class="textCon2"></div>
                    </div>                
                </div>
            </div>
            <div class="tempfooter modal-fo.panel#avl_tempter">
                <button type="button" class="btn btn-primary " data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Preview model end -->

<style>
.panel-group.defaultp{max-height:291px; overflow-y: auto; overflow-x: hidden;}
.Editor-editor{height: 56vh;}

    .for_a4.modal-content{width:635px; margin: auto;}

    .my_bg2{
        position:absolute;
        /*border: #80808047 solid 1px;*/
        width:595px;
        height:700px;
    }

    /* If Image exists */
    .textCon2-img{
        position:relative;
        padding:5px 72px;
        margin-top:148px;
        width:595px;
        height:694px;
    }

    /* Without image */
    .textCon2-noImg{
        color: #000;
        background-color: #fff;
        /*margin-top: 10px;*/
    }

    /*#menuBarDiv .btn{
        background: transparent !important;
    }*/
    .footer{
        margin: auto;
    }
    .Editor-container{
        background: #fff;
    }
    
    .tempmodel{}
    .tempmodel .tempfooter{ padding: 10px; }
    .tempmodel .modal-header{height: 38px;}
    .tempmodel .modal-header .close{opacity: 1;}

</style>
<script src="<?php echo base_url("assets/js/custom.js"); ?>"></script>
<script>
$('#exist_list').on('click', function () {
    $('#exit_temp_list').modal('toggle');
});


function printDiv() 
{

  var divToPrint=document.getElementById('printcontent');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

                                    function validatetitle()
                                    {
                                        if ($('#title').val() == '')
                                        {
                                            return false;
                                        }

                                        $.ajax({
                                            url: "<?php echo base_url('admin/template/checkTitle/') ?>",
                                            type: 'POST',
                                            data: {title: $('#title').val()},
                                            beforeSend: function (xhr) {
                                                xhr.overrideMimeType("text/plain; charset=x-user-defined");
                                            }
                                        })
                                                .done(function (data) {
                                                    if (data >= 1)
                                                    {
                                                        $('#title').val('');
                                                        custom_alert_popup('Template already exist with this title');
                                                        return false;
                                                    } else {
                                                        return true;
                                                    }

                                                });
                                        return false;
                                    }

                                    var img_select = '';
                                    $('#preview').click(function () {

                                var temp_type = 'salary';
                                var temp_title = $('#title').val();

                              var temp_desc = $('#contentarea').html();
                                        var old_image = '';
                                        // && temp_title.length > 0
                                        if (temp_type.length > 0 && temp_desc.length > 0) {
                                           
                                            $('#loading').show();
                                            var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
                                            $('.textCon2').empty();

                                            /* Default parametter define section 

                                            start */
 
                                compensation_table ='<div class="table-responsive"><table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;"><thead><tr><th>Fixed Pay as on 1-Apr-17(Rs.)</th><th>Increase in Fixed Payduring the year (Rs.)</th><th>Annual PMS Increment (Rs.)*</th><th>Total Increase for FY’18 (Rs.)</th><th>Total Increase for FY’18 (%)</th><th>New Fixed Pay w.e.f. 1st April’18(Rs.)</th></tr></thead><tbody><tr><td>380836.80</td><td>6874104.24</td><td>1000</td><td>69741.04</td><td>18.05</td><td>468310.25</td></tr></tbody> </table></div>'; 


increment_breakup_table ='<div class="table-responsive"><table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;"><thead><tr><th>Annual Compensation Increment</th><th>% Increase</th><th>Amount (Rs.)</th></tr></thead><tbody><tr><td>Merit Increment basis performance rating</td><td>1.00</td><td>3,808.37</td></tr><tr><td>Special Increment</td><td>17.05</td><td>64,932.67</td></tr><tr><td>Increase on account of Upgrade</td><td>5.00</td><td>19,041.84</td></tr><tr><th>Total Annual Increment for FY’18 Appraisal</th><th>23.05</th><th>87,782.88</th></tr></tbody> </table></div>'; 

incentive_table ='<div class="table-responsive"><table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;"><thead><tr><th>Incentive Details</th><th>Previous</th><th>Revise</th></tr></thead><tbody><tr><td>Business Incentive</td><td>5000.00</td><td>2000.00</td></tr><tr><td>Cross Sell Incentive</td><td>3000.00</td><td>9000.00</td></tr><tr><td>Contest Incentive</td><td>10000.00</td><td>4000.00</td></tr><tr><th>Total Incentive Earned</th><th>18000</th><th>15000</th></tr></tbody> </table></div>';

basic_info_table ='<div class="table-responsive"><table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;"><thead><tr><th>Employee ID</th><th>Test000001</th></tr><tr><th>Name</th><th>Employee_8806</th></tr></thead><tbody><tr><td>Designation</td><td>L5Role</td></tr><tr><td>Grade</td><td>E01</td></tr><tr><td>Level</td><td>L5</td></tr><tr><td>Department</td><td>Finance & Accounts</td></tr><tr><td>Sub Department</td><td>Consumer Operations</td></tr><tr><td>Location</td><td>New Delhi</td></tr></tbody> </table></div>';  

final_salary_table_with_previous_year ='<div class="table-responsive"><table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;"><thead><tr><th>Components</th><th>Annualized FY’18 (Rs.)</th><th>Annualized FY’19 (Rs.)</th></tr></thead><tbody><tr><td>Basic</td><td>355,099</td><td>530,081</td></tr><tr><td>House Rent Allowance</td><td>177,549</td><td>265,041</td></tr><tr><td>LTA</td><td>50,000</td><td>50,000</td></tr><tr><th>Fixed Pay</th><th>582,648</th><th>845122</th></tr><tr><td>Gratuity</td><td>17,080</td><td>25,497</td></tr><tr><td>Performance Pay (FY’18 on Actuals)</td><td>449,541</td><td>441,734</td></tr><tr><th>Total Cost to Company (CTC)</th><th>1,049,269</th><th>1,312,353</th></tr></tbody> </table></div>';

final_salary_table_only_current_year ='<div class="table-responsive"><table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;"><thead><tr><th>Components</th><th>Annualized FY’19 (Rs.)</th></tr></thead><tbody><tr><td>Basic</td><td>530,081</td></tr><tr><td>House Rent Allowance</td><td>265,041</td></tr><tr><td>LTA</td><td>50,000</td></tr><tr><th>Fixed Pay</th><th>845122</th></tr><tr><td>Gratuity</td><td>25,497</td></tr><tr><td>Performance Pay (FY’18 on Actuals)</td><td>441,734</td></tr><tr><th>Total Cost to Company (CTC)</th><th>1,312,353</th></tr></tbody> </table></div>';

//temp_desc=temp_desc.replace(/{{promotion_content}}/g, $("#promotiontempdesc").Editor("getText"));
var finalrating='';
<?php
 if ($rating_for_current_yr) {
foreach ($rating_for_current_yr as $rating_for_current_yr_val) {
?>
 finalrating+=$("#rating<?php echo $rating_for_current_yr_val['id'] ?>tempdesc").Editor("getText")+'<br>';
<?php }}?>
// alert(finalrating);
// temp_desc = temp_desc.replace(/{{rating_content}}/g, finalrating);
// temp_desc = temp_desc.replace(/{{compensation_table}}/g,compensation_table);
// temp_desc = temp_desc.replace(/{{increment_breakup_table}}/g,increment_breakup_table);
// temp_desc = temp_desc.replace(/{{incentive_table}}/g,incentive_table);
// temp_desc = temp_desc.replace(/{{total_incentive_earned}}/g,'15000');
// temp_desc = temp_desc.replace(/{{basic_info_table}}/g,basic_info_table);
// temp_desc = temp_desc.replace(/{{final_salary_table_with_previous_year}}/g,final_salary_table_with_previous_year);
// temp_desc = temp_desc.replace(/{{final_salary_table_only_current_year}}/g,final_salary_table_only_current_year);

// temp_desc = temp_desc.replace(/{{Employee Full name}}/g, 'Rakesh');
// temp_desc = temp_desc.replace(/{{Employee Code}}/g, 'Test000001');
// temp_desc = temp_desc.replace(/{{Function}}/g, 'Finance & Accounts');
// temp_desc = temp_desc.replace(/{{designation}}/g, 'L5 ');
// temp_desc = temp_desc.replace(/{{Gender}}/g, 'Male ');
// temp_desc = temp_desc.replace(/{{Name of the company}}/g, 'Test Company');
// temp_desc = temp_desc.replace(/{{Employee First Name}}/g, 'Employee_8806');
// temp_desc = temp_desc.replace(/{{Grade}}/g, 'E01');
// temp_desc = temp_desc.replace(/{{Performance Rating for this year}}/g, 'A+');
// temp_desc = temp_desc.replace(/{{City}}/g, 'Bhopal');
// temp_desc = temp_desc.replace(/{{Country}}/g, 'India');
// temp_desc = temp_desc.replace(/{{BU Level-1 (top organisation)}}/g, 'Consumer Business');
// temp_desc = temp_desc.replace(/{{business_level_2}}/g, 'Executive Staff');
// temp_desc = temp_desc.replace(/{{business_level_3}}/g, 'Operations');
// temp_desc = temp_desc.replace(/{{Sub Function}}/g, 'Rural Operations');
// temp_desc = temp_desc.replace(/{{Level}}/g, 'L5');
// temp_desc = temp_desc.replace(/{{Identified talent}}/g, 'Growing Potential');
// temp_desc = temp_desc.replace(/{{Critical Position holder}}/g, 'NA');
// temp_desc = temp_desc.replace(/{{Special Category-1}}/g, 'NA');
// temp_desc = temp_desc.replace(/{{Date of Joining}}/g, '01/10/2009');
// temp_desc = temp_desc.replace(/{{Education}}/g, 'Graduate');                                            

                                            /* LTI parameter section end */

                                            $('.textCon2').html(temp_desc);
                                            $('#preview_temp').modal('toggle');
                                            setbgimage(this);
                                            $('#loading').hide();
                                        } else if (temp_type.length == 0) {
                                            custom_alert_popup('Please select rule type');
                                        } else if (temp_title.length == 0) {
                                            custom_alert_popup('Please enter title');
                                        } else if (temp_desc.length == 0) {
                                            custom_alert_popup('Please enter template content');
                                        }
                                    });

                                    $("#latterhead").change(function () {
                                        imagePreview(this);
                                    });

        function imagePreview(input) {

        if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
        //$('#preview_img').attr('src', e.target.result);
        var data=e.target.result;
        
        $('#old_latterhead').val(data);
        $('.textCon2').css('background-image',"URL("+data+")");

        //$("#imagePreview").modal('show');
        }

        reader.readAsDataURL(input.files[0]);
        }
        }

        function setbgimage (argument) {
            var imgurl=$('#old_latterhead').val();
            //alert(imgurl);

           $('#printcontent').css('background-image',"URL("+imgurl+")");
           $('#printcontent').css('background-image-resize','1');
        }
</script>
