<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid">
   <div class="row">
    <div class="col-md-8 padlt0">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('survey');?>">Survey</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div>
      <div class="col-md-4 text-right">

        
      </div>
     </div>
    </div>
</div>
<div id="main-wrapper" class="container-fluid compp_fluid">
<div class="row mb20">
    <div class="col-md-12">
       <div class="mailbox-content pad_b_10">
         <div class="survey_dash">
            <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
               <div class="row">
                  <div class="col-sm-12">
                    <div class="surver_table_typ">
                    <div class="alert alert-danger hide q_count" role="alert"> <button type="button" class="close" onclick="hidealert();" aria-label="Close"><span aria-hidden="true">×</span></button><b>Please add question(s) before <?php echo CV_SURVEY_PUBLISHED_TERMS_1; ?> survey.</b></div>
                      <!-- Nav tabs -->
                      <!-- <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php echo ($currenttab=='draft')?'active':'';?>"><a href="#survey_draft" aria-controls="draft" role="tab" data-toggle="tab">Draft Survey [<?php echo count($count_progress_company); ?>]</a></li>
                        <li role="presentation" class="<?php echo ($currenttab=='launch')?'active':'';?>"><a href="#survey_lunched" aria-controls="lunched" role="tab" data-toggle="tab"> Launched Surveys [<?php echo count($count_lunch_company); ?>]</a></li>
                        <li role="presentation" class="<?php echo ($currenttab=='completed')?'active':'';?>"><a href="#survey_completed" aria-controls="completed" role="tab" data-toggle="tab"> Completed Survey [<?php echo count($count_completed_company); ?>]</a></li>
                      </ul> -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php echo ($currenttab=='draft')?'active':'';?>"><a href="<?php echo base_url('survey/dashboard-analytics/draft'); ?>" >Draft Survey [<?php echo count($count_progress_company); ?>]</a></li>
                        <li role="presentation" class="<?php echo ($currenttab=='launch')?'active':'';?>"><a href="<?php echo base_url('survey/dashboard-analytics/launch'); ?>" > Launched Survey [<?php echo count($count_lunch_company); ?>]</a></li>
                        <li role="presentation" class="<?php echo ($currenttab=='completed')?'active':'';?>"><a href="<?php echo base_url('survey/dashboard-analytics/completed'); ?>" > Completed Survey [<?php echo count($count_completed_company); ?>]</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content" style="min-height:350px; max-height:350px; overflow-y: auto;">
                          <div role="tabpanel" class="tab-pane <?php echo ($currenttab=='draft')?'active':'';?>" id="survey_draft">
                             <div class="master_sur">
                                <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th class="text-center" scope="col">Sr. No.</th>
                                          <th class="text-left" style="text-align:left !important;" scope="col">Survey Name</th>
                                          <th scope="col">No of Participants Invited</th>
                                          <th scope="col">No of Questions</th>
                                          <th scope="col">Category</th>
                                          <th scope="col">Survey Created On</th>
                                          <th style="width:9%;" scope="col">Start Date</th>
                                          <th style="width:9%;" scope="col">End Date</th>
                                          <th scope="col" style="width:22%;">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php 
                                      if(!empty($progress_company_survey)){ 
                                          $i = 1;
                                        if($currenttab=='draft')
                                          $i = $currentindex;
                                        foreach($progress_company_survey as $lcs){
                                      ?>
                                      <tr>
                                        <td class="text-center" scope="row"><?php echo $i;?></td>
                                        <td class="text-left"><?php echo ucwords($lcs['survey_name']);?></td>
                                        <td class="text-center"><?= getParticipantsCount($lcs['survey_id']); ?></td>
                                        <td class="text-center"><?php echo $lcs['question_count'];?></td>
                                        <td class="text-left"><?php echo $lcs['category_name'];?></td>
                                        <td class="text-center"><?php echo HLP_DateConversion($lcs['createdon']);?></td>
                                       <!--  <td class="text-center"><?php //echo HLP_DateConversion($lcs['createdon'],'','d-m-Y H:i:s');?></td> -->
                                        <td class="text-center"><?php echo HLP_DateConversion($lcs['start_date']);?></td>
                                        <td class="text-center"><?php echo HLP_DateConversion($lcs['start_date'], ' + '.$lcs['surevy_open_periods'].' days');?></td>
                                        <td class="text-center">
                                        <?php 
                                        // if($lcs['is_published']==1)
                                        // {
                                        //     $status = 0;
                                        //     $caption_title="Disable";
                                        //     $caption='<i class="fa fa-eye-slash"></i>';
                                        //     $pub_url = base_url('survey/updatesurvey/'.$g['survey_id'].'/'.$status);
                                        // }
                                        // if($lcs['is_published']==0)
                                        // {
                                        //     $status=1;
                                        //     $caption_title="Publish";
                                        //     $caption='<i class="fa fa-cloud-upload"></i>';
                                        //     $pub_url = base_url('survey/survey_filters/'.$lcs['survey_id']);
                                        // }
                                        ?>

                                            <a title="View Survey" href="<?php echo base_url('survey/viewsurvey/'.$lcs['survey_id']) ?>"><i class="fa fa-files-o" aria-hidden="true" title="View"></i></a>

                                            <a title="Setup/Edit" href="<?php echo base_url('survey/create/'.$lcs['survey_id']); ?>"><i class="fa fa-eye"></i></a> <span <?php echo @$clsshide ?>> | </span>

                                            <a class="anchor_cstm_popup_cls_sury_launch_<?php echo $lcs['survey_id']; ?>" title="<?php echo CV_SURVEY_PUBLISHED_TERMS_1; ?>" <?php if($lcs['question_count'] == 0){ echo 'onclick="showLink();"'; }else{ ?>onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sury_launch_<?php echo $lcs['survey_id']; ?>','Are you sure ?');" href="<?php echo base_url('survey/updatesurvey/'.$lcs['survey_id'].'/1/launch'); ?>"<?php }?>><i class="fa fa-rocket"></i></a> <span <?php echo @$clsshide ?>> | </span>
                                            
                                            <!-- <a title="Edit" <?php echo @$clsshide ?> href="<?php echo base_url('survey/create/'.$lcs['survey_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <span <?php echo @$clsshide ?>>|</span>  -->

                                            <a title="Questions" href="<?php echo base_url('survey/questions_create/'.$lcs['survey_id']) ?>"><i class="fa fa-question-circle"></i></a><span <?php echo @$clsshide ?>> | </span>

                                            <a class="anchor_cstm_popup_cls_sury_delete_<?php echo $lcs['survey_id']; ?>" title="View Survey" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_sury_delete_<?php echo $lcs['survey_id']; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo base_url('survey/deleteSurvey/'.$lcs['survey_id']) ?>"><i class="fa fa-trash text-danger" aria-hidden="true" title="Delete"></i></a>
                                        
                                        </td>
                                      </tr>    
                                    <?php $i++;
                                        } 
                                      } else {
                                        echo '<tr><td colspan=9>No Record Found</td></tr>';
                                      }  
                                    ?>
                                      </tbody>
                                    </table>

                                    <?php if (isset($links_progress)) { ?>
                                        <?php echo $links_progress ?>
                                    <?php } ?>
                                </div>
                             </div>
                          </div>

                          <div role="tabpanel" class="tab-pane <?php echo ($currenttab=='launch')?'active':'';?>" id="survey_lunched">
                             <div class="master_sur">
                                <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th class="text-center" scope="col">Sr. No.</th>
                                          <th class="text-left" style="text-align:left !important;" scope="col">Survey Name</th>
                                          <th scope="col">No of Participants Invited</th>
                                          <th scope="col">Participation status</th>
                                          <th scope="col">No of Questions</th>
                                          <th scope="col">Category</th>
                                          <th style="width:9%;" scope="col">Survey Created On</th>
                                          <th style="width:9%;" scope="col">Start Date</th>
                                          <th style="width:9%;" scope="col">End Date</th>
                                          <th scope="col">Status</th>
                                          <th scope="col" style="width:25%;">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php 
                                      if(!empty($lunch_company_survey)){ 
                                          $i = 1;
                                        if($currenttab=='launch')
                                          $i = $currentindex;
                                        foreach($lunch_company_survey as $lcs){
                                    ?>
                                      <tr>
                                        <td class="text-center" scope="row"><?php echo $i;?></td>
                                        <td class="text-left"><?php echo ucwords($lcs['survey_name']);?></td>
                                        <td class="text-center"><?= getParticipantsCount($lcs['survey_id']); ?></td>
                                        <td class="text-center">Active</td>
                                        <td class="text-center"><?php echo $lcs['question_count'];?></td>
                                        <td class="text-left"><?php echo $lcs['category_name'];?></td>
                                        <td class="text-center"><?php echo HLP_DateConversion($lcs['createdon']);?></td>
                                        <!-- <td class="text-center"><?php //echo HLP_DateConversion($lcs['createdon'],'','d-m-Y H:i:s');?></td> -->
                                        <td class="text-center"><?php echo HLP_DateConversion($lcs['start_date']);?></td>
                                        <td class="text-center"><?php echo HLP_DateConversion($lcs['start_date'], ' + '.$lcs['surevy_open_periods'].' days');?></td>
                                        <td class="text-center">
                                            <?php 
                                              if(isset($lcs['is_published']) && $lcs['is_published']==2){ 
                                                echo CV_SURVEY_PUBLISHED_TERMS_2;
                                              }else{
                                                echo CV_SURVEY_PUBLISHED_TERMS_1;
                                              }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a title="View Survey" href="<?php //echo base_url('survey/viewsurvey/'.$lcs['survey_id']) ?>"></a>
                                             <a title="View Survey" href="<?php echo base_url('survey/viewsurvey/'.$lcs['survey_id']) ?>"><i class="fa fa-eye" aria-hidden="true" title="View"></i></a> <span <?php echo @$clsshide ?>> | </span> 
                                             <!-- <a title="Setup/Edit" href="<?php echo base_url('survey/create/'.$lcs['survey_id']); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a> <span <?php echo @$clsshide ?>>|</span> -->


                                          <?php if($lcs['is_published'] == 1){ ?>
                                            <a class="anchor_cstm_popup_cls_sury_freeze_<?php echo $lcs['survey_id']; ?>" title="<?php echo CV_SURVEY_PUBLISHED_TERMS_2; ?>" <?php if($lcs['question_count'] == 0){ echo 'onclick="showLink();"'; }else{ ?>onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_sury_freeze_<?php echo $lcs['survey_id']; ?>','You are about to freeze your survey and participants will not be able to participate in survey, unless you open it again.\n Are you sure you want to proceed')" href="<?php echo base_url('survey/updatesurvey/'.$lcs['survey_id'].'/2'); ?>"<?php }?>><i class="fa fa-key"></i></a> <span <?php echo @$clsshide ?>> | </span>

                                          <?php } elseif($lcs['is_published'] == 2) { ?>
                                            <a class="anchor_cstm_popup_cls_sury_launch_<?php echo $lcs['survey_id']; ?>" title="<?php echo CV_SURVEY_PUBLISHED_TERMS_1; ?>" <?php if($lcs['question_count'] == 0){ echo 'onclick="showLink();"'; }else{ ?>onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sury_launch_<?php echo $lcs['survey_id']; ?>','Are you sure ?');" href="<?php echo base_url('survey/updatesurvey/'.$lcs['survey_id'].'/1'); ?>"<?php }?>><i class="fa fa-rocket"></i></a> <span <?php echo @$clsshide ?>>|</span>
                                          <?php }?>

                                            <a class="anchor_cstm_popup_cls_sury_quest_<?php echo $lcs['survey_id']; ?>" title="Complete" <?php if($lcs['question_count'] == 0){ echo 'onclick="showLink();"'; }else{ ?>onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_sury_quest_<?php echo $lcs['survey_id']; ?>','Are you sure ?');" href="<?php echo base_url('survey/updatesurvey/'.$lcs['survey_id'].'/3/completed'); ?>"<?php }?>><i class="fa fa-check"></i></a> <span <?php echo @$clsshide ?>> | </span>

                                           

                                            <a title="Copy Survey" style="cursor: pointer;" onclick="copy_company_survey(<?php echo $lcs['survey_id'];?>)"><i class="fa fa-files-o" aria-hidden="true"></i></a> 
                                            <span <?php echo @$clsshide ?>> | </span>
                                            
                                            <a title="Results" href="<?php echo base_url('survey/results/'.$lcs['survey_id']) ?>"><i class="fa fa-clipboard"></i></a>
                                            <span <?php echo @$clsshide ?>> | </span>
                                            
                                            <a class="anchor_cstm_popup_cls_lti_delete<?php echo $lcs['survey_id']; ?>" title="View Survey" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_lti_delete<?php echo $lcs['survey_id']; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo base_url('survey/deleteSurvey/'.$lcs['survey_id'].'/launch') ?>"><i class="fa fa-trash text-danger" aria-hidden="true" title="Delete"></i></a>
                                        </td>
                                      </tr>    
                                    <?php $i++;
                                        } 
                                      } else {
                                        echo '<tr><td colspan="11">No Record Found</td></tr>';
                                      }  
                                    ?>
                                      </tbody>
                                    </table>

                                    <?php if (isset($links_lunch)) { ?>
                                        <?php echo $links_lunch ?>
                                    <?php } ?>
                                </div>
                             </div>
                          </div>

                          <div role="tabpanel" class="tab-pane <?php echo ($currenttab=='completed')?'active':'';?>" id="survey_completed">
                              <div class="master_sur">
                                 <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <tr>
                                        <th class="text-center" scope="col">Sr. No.</th>
                                          <th class="text-left" style="text-align:left !important;" scope="col">Survey Name</th>
                                          <th scope="col">No of Participants Invited</th>
                                          <th scope="col">% of Completion</th>
                                          <th scope="col">No of Questions</th>
                                          <th scope="col">Category</th>
                                          <th scope="col">Survey Created On</th>
                                          <th style="width:9%;" scope="col">Start Date</th>
                                          <th style="width:9%;" scope="col">End Date</th>
                                          <th scope="col" style="width:22%;">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                        if(!empty($completed_company_survey)){ 
                                            $i = 1;
                                          if($currenttab=='completed')
                                            $i = $currentindex;
                                          foreach($completed_company_survey as $lms){
                                      ?>
                                        <tr>
                                          <td class="text-center" scope="row"><?php echo $i;?></td>
                                          <td class="text-left"><?php echo ucwords($lms['survey_name']);?></td>
                                          <td class="text-center">415</td>
                                          <td class="text-center">95 %</td>
                                          <td class="text-center"><?php echo $lms['question_count'];?></td>
                                          <td class="text-left"><?php echo $lms['category_name'];?></td>
                                          <td class="text-center"><?php echo HLP_DateConversion($lms['createdon']);?></td>
                                          <!-- <td class="text-center"><?php //echo HLP_DateConversion($lms['createdon'],'','d-m-Y H:i:s');?></td> -->
                                          <td class="text-center"><?php echo HLP_DateConversion($lms['start_date']);?></td>
                                          <td class="text-center"><?php echo HLP_DateConversion($lms['start_date'], ' + '.$lms['surevy_open_periods'].' days');?></td>
                                          <td class="text-center">
                                            <a title="View Survey" href="<?php echo base_url('survey/viewsurvey/'.$lms['survey_id']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a><span <?php echo @$clsshide ?>> | </span>

                                            <a title="Copy Survey" style="cursor: pointer;" onclick="copy_company_survey(<?php echo $lms['survey_id'];?>)"><i class="fa fa-files-o" aria-hidden="true"></i></a> 
                                            <span <?php echo @$clsshide ?>> | </span>

                                            <a title="Results" href="<?php echo base_url('survey/results/'.$lms['survey_id']) ?>"><i class="fa fa-clipboard"></i></a>
                                            <span <?php echo @$clsshide ?>> | </span>

                                            <a class="anchor_cstm_popup_cls_lti_delete<?php echo $lcs['survey_id']; ?>" title="View Survey" onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_lti_delete<?php echo $lcs['survey_id']; ?>','<?php echo $this->lang->line('msg_critical_delete_record'); ?>')" href="<?php echo base_url('survey/deleteSurvey/'.$lcs['survey_id']) ?>"><i class="fa fa-trash text-danger" aria-hidden="true" title="Delete"></i></a>

                                          </td>
                                        </tr>    
                                      <?php $i++;
                                          } 
                                        } else {
                                          echo '<tr><td colspan=10>No Record Found</td></tr>';
                                        }  
                                      ?>
                                    </tbody>
                                  </table>

                                  <?php if (isset($links_completed)) { ?>
                                        <?php echo $links_completed ?>
                                    <?php } ?>
                                 </div>
                              </div>
                          </div>
                      </div>

                    </div>

                     
                 </div> 
               </div>
           </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var csrf_token_val = '<?php echo $this->security->get_csrf_hash()?>';
    function showLink(){
      $('.q_count').removeClass('hide');
    }
    function hidealert(){
      $('.q_count').addClass('hide');
    }

function copy_company_survey(surveyId)
{
 custom_confirm_popup_callback('Are you sure',function(result)
  {
 
  if(result)
  {
        $('#loading').show();
        $.ajax({
            url: '<?Php echo site_url('survey/copy-company-exists-survey');?>',
            type: 'POST',
            data: { surveyid: surveyId, csrf_test_name: csrf_token_val}
        }).done(function(res){
            var obj = JSON.parse(res);
            console.log(res);
            if(obj.status){
              window.location.replace('<?php echo site_url('survey/create/');?>'+obj.id);
            } else {
              $('#loading').hide();
              custom_alert_popup(obj.message);
            }
            reset_token();
        });
      }
  }
);
  
}

    /*function copy_company_survey(surveyId) {
      $check = request_confirm();
      if($check) {
        $('#loading').show();
        $.ajax({
            url: '<?Php //echo site_url('survey/copy-company-exists-survey');?>',
            type: 'POST',
            data: { surveyid: surveyId, csrf_test_name: csrf_token_val}
        }).done(function(res){
            var obj = JSON.parse(res);
            console.log(res);
            if(obj.status){
              window.location.replace('<?php //echo site_url('survey/create/');?>'+obj.id);
            } else {
              $('#loading').hide();
              custom_alert_popup(obj.message);
            }
            reset_token();
        });
      }
    }
*/

    function reset_token() {
        $('#loading').show();
        $.ajax({
          url: '<?Php echo site_url('survey/reset_token');?>',
          type: 'GET',
          success: function(res){
            csrf_token_val = res;
            $('#loading').hide();
          }
        });
    }
</script>     

