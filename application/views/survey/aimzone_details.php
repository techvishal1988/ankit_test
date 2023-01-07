<div class="page-breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <ol class="breadcrumb wn_btn">
            <li><a href="<?= base_url('survey');?>">Survey</a></li>
            <li><a href="<?= base_url('survey/aim-zone');?>">Action Planning Zone List</a></li>
            <li class="active">Action Planning Zone</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div id="main-wrapper" class="container">
  <div class="row mb20">
    <div class="col-md-12">
      <div class="mailbox-content pad_b_10">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
        <div class="survey_edit clearfix">
          <form method="post" action="" enctype="multipart/form-data" id="form-aimzone">
            <?php echo HLP_get_crsf_field();?>
            <div class="survey_table">
              <div class="row">
                <div class="col-md-3">
                  <?php if(isset($survey)){ ?>

                    <select name="survey_id" id="selectSurvey" class="form-control ht30" autofocus required="required" style="display: inline-block" <?php echo (count($aimItemList)>0 && !$editsurvey)?' disabled="disabled"':'';?> onchange="showresult();">
                      <option value="">Select Survey</option>
                        <?php  foreach ($survey as $k => $val) { echo '<option value="'.$val['survey_id'].'" '.((isset($aimItemList)&&($aimItemList[0]['survey_id']==$val['survey_id']))?' selected="selected"':'').'>'.ucfirst($val['survey_name']).' </option>';  } ?>
                    </select>
                  <?php  } ?> 
                </div>
                
                <div class="col-md-1 resultlink hide">
                  <a title="Result" href=""><i class="custom fa fa-clipboard" aria-hidden="true"></i></a>    
                </div>
                
                <div class="col-md-3">
                  <input placeholder="Select Owner" style="display: inline-block" name="aim_owner_search"  class="form-control ht30" autofocus required="required" maxlength="50" <?php echo (count($aimItemList)>0)?' value="'.$aimItemList[0]['email'].'" type="text"':' type="email"'; echo (count($aimItemList)>0 && !$editowner)?' disabled="disabled"':'id="aim_owner_search"';?>> 


                  <input id="aim_owner" name="aim_owner" type="hidden" class="form-control" value="<?php echo (count($aimItemList)>0)?$aimItemList[0]['aim_owner_id']:'';?>"> 
                </div> 

                <div class="col-md-5">
                  <div class="action_4_table clearfix">
                    <?php if($editsurvey || !count($aimItemList)>0){ ?>
                      <input type="button" id="dv_btn_dlt" value="Add Row" onclick="addNewOption();" class="btn btn success pull-right"/>
                    <?php } ?>
                    <input type="hidden" id="row_count" name="row_count" value="<?php echo (count($aimItemList)>0)?count($aimItemList):1;?>" />
                  </div>
                </div> 
              </div> 

              <div class="table-responsive">
                <table id="testingTable1" class="table">
                  <thead>
                    <tr>
                      <th class="text-left" style="text-align:left !important; vertical-align: middle; width:50px;" scope="col">S. N.</th>
                      <th scope="col">Focus</th>
                      <th class="bold_txt" scope="col">A<span>im</span></th>
                      <th class="bold_txt" scope="col">I<span>mpact</span></th>
                      <th class="bold_txt" scope="col">M<span>easure</span></th>
                      <th scope="col">Comments</th>
                      <th scope="col">Action Item Owner</th>
                      <th scope="col" style="width:150px;" colspan="2">Status</th>
                      <?php if( $pagetype == "edit" ){ ?>
                      <th scope="col" style="width:150px;">Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody id="tbl_bd_exz">
                      <?php if(isset($aimItemList)&&!empty($aimItemList)) { $i=0;
                              foreach ($aimItemList as $key => $val) { $i++;
                      ?>
                        <tr id="dv_new_ratio_range_row_<?php echo $i; ?>" class="rv1">
                           <td class="text-left" scope="row" ><?php echo $i; ?></td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="focus[]" placeholder="" rows="4" maxlength="500" required="required"> <?php echo $val['focus']; ?></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="action[]" placeholder="" rows="4" maxlength="500" required="required"><?php echo $val['action']; ?></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="impact[]" placeholder="" rows="4" maxlength="500" required="required"><?php echo $val['impact']; ?></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="metric[]" placeholder="" rows="4" maxlength="500" required="required"><?php echo $val['metric']; ?></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="comment[]" placeholder="" rows="4" maxlength="500" required="required"><?php echo $val['comment']; ?></textarea>
                             </div>
                           </td>
                            <td class="text-center">
                             <div class="form-group">
                                <input style="display: inline-block" id="aim_item_owner_search_<?php echo $i; ?>" name="aim_item_owner_search[]" type="text" autofocus class="form-control ht30 aim_item_owner_search" value="<?php echo $val['item_owner_email'];?>" required="required" maxlength="50">
                                <span class=" hide aim_item_owner_email_<?php echo $i; ?>"><?php echo $val['item_owner_email'];?></span> 
                                <input name="aim_item_owner_id[]" id="aim_item_owner_id_<?php echo $i; ?>" class="aim_item_owner_id" type="hidden" value="<?php echo $val['item_owner_id'];?>"> 
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <select name="status[]" class="form-control ht30 minpdw" required="required" onchange="ChangeActionStatus(this);">
                                <option value="1" <?php echo ($val['status']==1)?'selected="selected"':""; ?>>Open</option>
                                <option value="2" <?php echo ($val['status']==2)?'selected="selected"':""; ?>>Close</option>
                              </select>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <select name="aim_action_status[]" class="form-control aim_action_status" <?php echo ($val['status']!=2)?'style="display: none;"':""; ?>>
                                <option value="" <?php echo ($val['aim_action_status']==0)?'selected="selected"':""; ?>>Select</option>
                                <option value="1" <?php echo ($val['aim_action_status']==1)?'selected="selected"':""; ?>><?php echo CV_AIM_ACTION_STATUS_TERMS_1; ?></option>
                                <option value="2" <?php echo ($val['aim_action_status']==2)?'selected="selected"':""; ?>><?php echo CV_AIM_ACTION_STATUS_TERMS_2; ?></option>
                                <option value="3" <?php echo ($val['aim_action_status']==3)?'selected="selected"':""; ?>><?php echo CV_AIM_ACTION_STATUS_TERMS_3; ?></option>
                                <option value="4" <?php echo ($val['aim_action_status']==4)?'selected="selected"':""; ?>><?php echo CV_AIM_ACTION_STATUS_TERMS_4; ?></option>
                              </select>
                             </div>
                           </td>
                           <?php if( $pagetype == "edit" ){ ?>
                           <td class="text-center td_action">
                              <input type="hidden" name="aimItem_id[]" value="<?php echo $val['id']?>">
                              
                              <a title="Edit" href="javascript:void(0)" onclick="return editOption(this);"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                              <?php 
                              if($i!=1 && (count($aimItemList)>0 && $editsurvey) && $pagetype == "edit"){ echo "<span>|</span>";} ?>

                              <?php if($i!=1 && (count($aimItemList)>0 && $editsurvey)) { ?>
                              <a title="Delete" href="javascript:void(0)" onclick="return deleteOption(this, '<?php echo $val['id']?>');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                              <?php } ?>
                           </td>
                           <?php } ?>
                        </tr>

                      <?php } } else { ?>

                        <tr id="dv_new_ratio_range_row_1" class="rv1">
                           <td class="text-left" scope="row" >1</td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="focus[]" placeholder="" rows="4" maxlength="500" required="required"></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="action[]" placeholder="" rows="4" maxlength="500" required="required"></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="impact[]" placeholder="" rows="4" maxlength="500" required="required"></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="metric[]" placeholder="" rows="4" maxlength="500" required="required"></textarea>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <textarea class="form-control" name="comment[]" placeholder="" rows="4" maxlength="500" required="required"></textarea>
                             </div>
                           </td>
                            <td class="text-center">
                             <div class="form-group">
                                <input style="display: inline-block" id="aim_item_owner_search_1" name="aim_item_owner_search[]" type="email" autofocus class="form-control ht30 aim_item_owner_search" required="required" maxlength="50"> 
                                <input name="aim_item_owner_id[]" id="aim_item_owner_id_1" class="aim_item_owner_id" type="hidden"> 
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <select name="status[]" class="form-control ht30 minpdw" required="required" onchange="ChangeActionStatus(this);">
                                <option value="1">Open</option>
                                <option value="2">Close</option>
                              </select>
                             </div>
                           </td>
                           <td class="text-center">
                             <div class="form-group">
                              <select name="aim_action_status[]" class="ht30 form-control aim_action_status" style="display: none;">
                                <option value="">Select</option>
                                <option value="1"><?php echo CV_AIM_ACTION_STATUS_TERMS_1; ?></option>
                                <option value="2"><?php echo CV_AIM_ACTION_STATUS_TERMS_2; ?></option>
                                <option value="3"><?php echo CV_AIM_ACTION_STATUS_TERMS_3; ?></option>
                                <option value="4"><?php echo CV_AIM_ACTION_STATUS_TERMS_4; ?></option>
                              </select>
                             </div>
                           </td>
                           <td class="text-center td_action">
                              <!-- <a title="Edit" href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>  -->
                              
                           </td>
                        </tr>
                      <?php } ?>
                  </tbody>
                </table>
                <?php if(count($aimItemList) < 1 || $pagetype == "edit" ){ ?>
                  <input type="submit" style="margin-top:10px; <?php echo ( isset($pagetype) && $pagetype == "view" && !empty($aimItemList) )?'display: none;':'';?>" <?php echo ( isset($pagetype) && ($pagetype!="create") && !empty($aimItemList) )?'value="Update"':'value="Save"';?> class="btn btn-success pull-right"/> 
                <?php } ?>
              </div>
            </div>
          </form>
        </div> 
      </div> 
    </div>
  </div>
</div>
<script type="text/javascript">
    var resulturl = '<?php echo base_url('survey/results/');?>';
    var csrf_token_val = '<?php echo $this->security->get_csrf_hash()?>';
    var showSubmitBtn = '<?php echo ((isset($pagetype) && $pagetype == "view"))?false:true;?>';
    function addNewOption()
    {
        var row_count = parseInt($("#row_count").val())+1;
        var clonetd = $('#tbl_bd_exz').children('tr:first').clone(); 
        clonetd.children('td:first').text(row_count);
        clonetd.find("input:text, input[type=email], input[type=hidden], select, textarea").val("");
        clonetd.find("input:text, input[type=email], input[type=hidden], select, textarea").removeAttr("disabled");
        clonetd.find(".aim_action_status").hide();
        clonetd.find(".aim_action_status").removeAttr("required");
        clonetd.find(".aim_item_owner_search").attr("id","aim_item_owner_search_"+row_count);
        clonetd.find(".aim_item_owner_id").attr("id","aim_item_owner_id_"+row_count);
        clonetd.find(".td_action").html('<a title="Delete" href="javascript:void(0)" onclick="return deleteOption(this,\'\');"><i class="fa fa-trash" aria-hidden="true"></i></a>');
        clonetd.attr("id","dv_new_ratio_range_row_"+row_count);

        $("#tbl_bd_exz").append(clonetd);
        $("#row_count").val(row_count);
        $("#form-aimzone").find("input[type=submit]").show();
        showSubmitBtn = true;
    }

    function editOption(ths)
    {
        var rowtr = $(ths).closest("tr");
        rowtr.find("input:text, input[type=email], input[type=hidden], select, textarea").removeAttr("disabled");
        $("#form-aimzone").find("input[type=submit]").show();
        $(ths).hide()
        $(ths).closest("td").find('span').hide();
        showSubmitBtn = true;
    }



function deleteOption(ths,id)
{
 custom_confirm_popup_callback('Are you sure',function(result)
  {
 
  if(result)
  {
        console.log(id);
        var rowtr = $(ths).closest("tr");
        if(id!=""){
          $('#loading').show();
          $.ajax({
            url: "<?php echo site_url('survey/aim-zone-delete'); ?>",
            type: 'POST',
            data: { aimid: id, csrf_test_name: csrf_token_val}
          }).done(function() {
            $('#loading').hide();
            rowtr.remove();
          });
        }else{
          rowtr.remove();
        }
        showSubmitBtn = true;
      }
  }
);
  
}

/*
    function deleteOption(ths,id)
    {
      $check = request_confirm();
      if($check) {
        console.log(id);
        var rowtr = $(ths).closest("tr");
        if(id!=""){
          $('#loading').show();
          $.ajax({
            url: "<?php //echo site_url('survey/aim-zone-delete'); ?>",
            type: 'POST',
            data: { aimid: id, csrf_test_name: csrf_token_val}
          }).done(function() {
            $('#loading').hide();
            rowtr.remove();
          });
        }else{
          rowtr.remove();
        }
        showSubmitBtn = true;
      }
    }*/




    function ChangeActionStatus(ths)
    {
        var rowtr = $(ths).closest("tr");
        if(parseInt($(ths).val()) == 2){
          rowtr.find(".aim_action_status").show();
          rowtr.find(".aim_action_status").attr("required","required");
        }else{
          rowtr.find(".aim_action_status").hide();
          rowtr.find(".aim_action_status").removeAttr("required");
        }
    }

    function showresult()
    {
        var surveyid = $('#selectSurvey').val();
        var rlink = $(".resultlink");
        console.log(surveyid);
        console.log(resulturl);
        if(typeof surveyid != "" && surveyid!=''){
            rlink.find('a').attr("href",resulturl+surveyid);
            rlink.removeClass('hide');
        }else{
            rlink.addClass('hide');
            rlink.find('a').attr("href","");
        }
    }

    $(function() { 

      <?php if(isset($pagetype) && $pagetype != "create" && !empty($aimItemList)){ ?>
      $("#tbl_bd_exz").find("input:text, input[type=email], input[type=hidden], select, textarea").attr("disabled","disabled"); 
      <?php } ?>
      showresult();

      $( "#aim_owner_search" ).autocomplete({
        minLength: 2,        
        search: function(event, ui) {$('#loading').show();},
        response: function(event, ui) {$('#loading').hide();},
        source: '<?php echo site_url("survey/get-users-for-aim"); ?>',
        select: function(event, ui) {
          console.log(ui);
          $("#aim_owner").val(ui.item.id);
        }
      });

      $(document).on("keydown", "#aim_owner_search", function(){
        $("#aim_owner").val("");
      });

      $('form#form-aimzone').submit(function() {
        var aim_owner = $("#aim_owner").val();
        if(aim_owner==''){
            custom_alert_popup("Please select the owner from Autocomplete dropdown.");
            $('#loading').hide();
            return false;
        }
      });

      $(document).on('keydown', '.aim_item_owner_search', function() {
          var id = this.id;
          var item_owner_id = $(this).closest("tr").find(".aim_item_owner_id");
              item_owner_id.val("");

          // Initialize jQuery UI autocomplete
          $( '#'+id ).autocomplete({
            minLength: 2,        
            search: function(event, ui) {$('#loading').show();},
            response: function(event, ui) {$('#loading').hide();},
            source: '<?php echo site_url("survey/get-users-for-aim"); ?>',
            select: function (event, ui) {
              $(this).val(ui.item.label); // display the selected text
              item_owner_id.val(ui.item.id);
            }
          });
      }); 

    });
</script>

<style>
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{background: #fff;}
    .survey_edit{display: block; width: 100%;}
    .survey_edit .form-group{margin-bottom: 0px;}
    .survey_edit .form-control.ht30{height: 30px;}
    .minpdw{padding: 6px 3px !important; width: 65px !important;}
    .survey_edit .action_4_table{display: block; width: 100%; margin-bottom: 10px;}
    .survey_edit .action_4_table .btn{color: #fff;}
    .survey_edit a i.custom{font-size:20px; margin:10px; vertical-align: middle;}
    #aim_owner_search.ui-autocomplete-input{ border:1px solid #ccc;z-index: 99999999 !important;}
</style>
              


