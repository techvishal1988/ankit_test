<style type="text/css">
.white {color: unset !important;}
.black {color: unset !important;}
.checkbox input[type=checkbox] {
     margin-left: -20px; 
}
.table>thead>tr>th {
     text-align: left !important; 
}
.box{
  border: 1px solid gray;
    padding: 5px 10px;
}
</style>

<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
    <div class="col-md-8">
        <ol class="breadcrumb wn_btn">
            <li><a href="<?php echo base_url('survey');?>">Survey</a></li>
            <li><a href="<?php echo base_url('survey/dashboard-analytics');?>">Dashboard</a></li>
            <li class="active">View Survey</li>
        </ol>
    </div>
      <div class="col-md-4 text-right">
        
      </div>
     </div>
    </div>
</div>
<div id="main-wrapper" class="container">
  <div class="row mb20">
    <div class="col-md-12">
      <div class="panel panel-white pad_b_10">
        <div class="panel-group" id="accordion" style="margin-bottom:0px;">
          <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>  
  
          <!-- // - Survey Panel -->
          <div class="panel panel-default">
            <div class="panel-heading">
                <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand black" style="color:#4E5E6A !important;cursor: pointer;" >
                  <div class="right-arrow pull-right">-</div>
                  <a>Survey Overview</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                  <div class="survey_details_view">
                    <div class="sur_info">
                      <div class="overview">
                              <?php if(isset($survey) && !empty($survey)) {?>
                                    <div class="view_img">
                                      <img id="popimg" alt="No Image" height="298" src="<?php echo HLP_Check_IMG(base_url('/').$survey[0]['survey_img']);?>">
                                    </div>
                                    <div class="view_info">
                                        <div class="stat"> 
                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>Survey name :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span class="sur_name"> 
                                               <?php echo $survey[0]['survey_name']?>
                                              </span>
                                             </div> 
                                         </div>

                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>Category Name :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span class="cata_name"> 
                                               <?php echo HLP_get_filter_names("category", "name" , "id IN (".$survey[0]['category_id'].")"); ?><?php echo $survey[0]['category_name']?>
                                              </span>
                                             </div> 
                                         </div>

                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>No. of Questions :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span id="questionnumber"> 
                                               <?php echo count($result); ?>
                                              </span>
                                             </div> 
                                         </div>

                                         <div class="info_detail">
                                             <div class="head_name">
                                               <h5>Publishing Status :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span id="questionnumber"> 
                                               <?php if($survey[0]['is_published'] == 3){
                                                    echo CV_SURVEY_PUBLISHED_TERMS_3;
                                                  }else if($survey[0]['is_published'] == 2){
                                                    echo CV_SURVEY_PUBLISHED_TERMS_2;
                                                  }else if($survey[0]['is_published'] == 1){
                                                    echo CV_SURVEY_PUBLISHED_TERMS_1;
                                                  }else{
                                                    echo CV_SURVEY_PUBLISHED_TERMS_0;
                                                  }
                                                ?>
                                              </span>
                                             </div> 
                                         </div>

                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>Start Date :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span id="questionnumber"> 
                                               <?php echo HLP_DateConversion($survey[0]['start_date']);?>
                                              </span>
                                             </div> 
                                         </div>

                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>End Date :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span> 
                                               <?php echo HLP_DateConversion($survey[0]['start_date'], ' + '.$survey[0]['surevy_open_periods'].' days');?>
                                              </span>
                                             </div> 
                                         </div>

                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>Type :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span> 
                                               <?php if($survey[0]['survey_type'] == 2){
                                                    echo "Periodic";
                                                  }else{
                                                    echo "One Time";
                                                  }
                                                  ?>
                                              </span>
                                             </div> 
                                         </div>  

                                         <div class="info_detail">
                                             <div class="head_name">
                                              <h5>Frequency Days :</h5>
                                              </div>
                                             <div class="name_info">
                                              <span> 
                                               <?php
                                                  $vfreqdepton = json_decode(CV_FRQ_SURVEY_ARRAY); 
                                                    print_r($vfreqdepton->{$survey[0]['frequency_dependent_on']});
                                                ?>
                                              </span>
                                             </div>
                                         </div>

                                         <?php if($survey[0]['frequency_days']>0){ ?>
                                         <div class="info_detail">
                                             <div class="head_name"> 
                                              <h5> Frequency Dependent On :</h5>
                                              </div>
                                             <div class="name_info">
                                               <span><?php echo $survey[0]['frequency_days']." days"; ?></span>
                                             </div>
                                         </div>
                                         <?php } ?>
                                          
                                        </div>
                                    </div>
                                    <div class="des"> 
                                      <h4>Description :</h4>
                                      <p id="popupdesc"> <?php echo html_entity_decode($survey[0]['description']);?></p>

                                      <?php if(!empty($survey[0]['closing_description'])){ ?>
                                        <h4>Close Description : </h4>
                                        <p id="popupdesc"> <?php echo html_entity_decode($survey[0]['closing_description']);?></p>
                                      <?php }?>
                                    </div>      
                              <?php }else{ echo "No Record Found."; }?>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
<?php  //print_r($result); ?>
          <!-- // - Question Panel -->
          <div class="panel panel-default">
            <div class="panel-heading">
                <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="panel-title expand black" style="color:#4E5E6A !important;cursor: pointer;">
                  <div class="right-arrow pull-right">+</div>
                  <a href="#"> Questions</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">  
              <div class="panel-body area">
                <div class="survey_details_view">
                  <div class="questn">
                    <?php if(isset($result) && !empty($result)){ 
                          foreach ($result as $key => $val) {
                            
                      ?>
                    <div class="que_block" style="border-bottom: 1px double gray;padding: 15px;">
                         <h4><?php echo ($key+1).' : '.$val['name'];?></h4>
                         <!-- <img alt="No Image" src="<?php echo HLP_Check_IMG(base_url('/').$val['img']);?>"> -->
                         <?php 
                         if(in_array($val['type'], array(1,3,7) ) ) {
                          if($val['type'] == 7){$sel = "checkbox";}else{$sel = "radio";}
                            if(isset($val['aws']) && !empty($val['aws'])){ 
                              foreach ($val['aws'] as $k => $ansval) { ?>
                             <div class="checkbox">
                                <label class="ques" style="cursor: default;">
                                  <input type="<?= $sel; ?>" disabled="disabled" style="cursor: default;"> 
                                  <span><?php echo $ansval['answer'];?></span>
                                <!-- <img alt="No Image" src="<?php echo HLP_Check_IMG(base_url('/').$ansval['ans_img']);?>"> -->
                                </label>
                              </div>
                          <?php } } } ?>

                          <?php if(isset($val['sub']) && !empty($val['sub'])){ 
                            //echo "<h5>Sub Question</h5>";
                            if($val['type'] == '4'){ ?>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <?php //for($j=1;$j<=$val['sacle_upto'];$j++){ ?>
                                    <th>Rank- 1 to <?= $val['sacle_upto']; ?></th>
                                    <?php //} ?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($val['sub'] as $k => $ansval) { ?>
                                    <tr>
                                      <td><?php echo $ansval['QuestionName'];?></td>
                                      <td>
                                        <?php for($j=1;$j<=$val['sacle_upto'];$j++){ ?>
                                        <span class="box"><?= $j; ?></span>
                                        <?php } ?>
                                      </td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                            <?php }

                            if($val['type'] == '5'){ ?>
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <?php if(isset($val['aws']) && !empty($val['aws'])){ 
                                      foreach ($val['aws'] as $k => $ansval) { ?>
                                      <th><?= $ansval['answer'];?></th>
                                  <?php } } ?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($val['sub'] as $k => $ansval) { ?>
                                    <tr>
                                      <td><?php echo $ansval['QuestionName'];?></td>
                                      <?php if(isset($val['aws']) && !empty($val['aws'])){ 
                                      foreach ($val['aws'] as $k => $ansval) { ?>
                                      <th><input type="text" disabled="disabled" name=""></th>
                                  <?php } } ?>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                           <?php }

                            if($val['type'] == '6'){ ?>
                               <table class="table">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>on a scale of 1-<?= $val['sacle_upto']; ?></th>
                                    <th>on a scale of 1-<?= $val['sacle_upto']; ?></th>
                                  </tr>
                                  <tr>
                                    <th></th>
                                    <th>IMPORTANCE</th>
                                    <th>SATISFACTION</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($val['sub'] as $k => $ansval) { ?>
                                    <tr>
                                      <td><?php echo $ansval['QuestionName'];?></td>
                                     
                                      <th><input type="text" disabled="disabled" name=""></th>
                                      <th><input type="text" disabled="disabled" name=""></th>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                           <?php } 

                          } ?>

                          <?php if(!empty($val['title'])){  ?>
                            <h4><?php echo $val['title']; ?></h4>
                            <textarea class="form-control" disabled="disabled"></textarea> 
                          <?php } ?>
                          
                          <?php if(!empty($val['sacle_upto'])) echo "<h4>Sacle Upto : ".$val['sacle_upto']."</h4>"; ?>
                    </div>
                    <?php } } else { echo "No Record Found.";}?>
                  </div>
                </div>
              </div>   
            </div>
          </div>
        
          <!-- // - filter Survey Panel -->
          <?php if(!empty($survey[0]['country'])){ echo "string"; } ?>
          <div class="panel panel-default">
            <div class="panel-heading">
                <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse4" class="panel-title expand black" style="color:#4E5E6A !important;cursor: pointer;">
                  <div class="right-arrow pull-right">+</div>
                  <a href="#">Filter Survey Details</a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
              <div class="panel-body">
                <div class="survey_details_view">
                  <div class="filter">
                    <table class="table">
                      <tr>
                        <td class="col-md-3"><h5>Survey For :</h5></td>
                        <td>ddd</td>
                      </tr>
                      <?php if(isset($survey[0]['survey_for'])){ ?>
                      <tr>
                        <td class="col-md-3"><h5>Survey For :</h5></td>
                        <td><?php echo ucfirst($survey[0]['survey_for']);?></td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['country'])){ ?>
                      <tr>
                        <td><h5>Country :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_country", "name" , "id IN (".$survey[0]['country'].")");; ?> </td>
                      </tr>
                       <?php } ?>
                      <?php if(!empty($survey[0]['city'])){ ?>
                      <tr>
                        <td><h5>City :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_city", "name" , "id IN (".$survey[0]["city"].")"); ?> </td>
                      </tr>
                       <?php } ?>
                       <?php if(!empty($survey[0]['business_level1'])){ ?>
                      <tr>
                        <td><h5>Business Level 1 :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_business_level_1", "name" , "id IN (".$survey[0]["business_level1"].")"); ?> </td>
                      </tr>
                       <?php } ?>
                       <?php if(!empty($survey[0]['business_level2'])){ ?>
                      <tr>
                        <td><h5>Business Level 2 :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_business_level_2", "name" , "id IN (".$survey[0]["business_level2"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['business_level3'])){ ?>
                      <tr>
                        <td><h5>Business Level 3 :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_business_level_3", "name" , "id IN (".$survey[0]["business_level3"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['functions'])){ ?>
                      <tr>
                        <td><h5>Function :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_function", "name" , "id IN (".$survey[0]["functions"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['sub_functions'])){ ?>
                      <tr>
                        <td><h5>Sub Function :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_subfunction", "name" , "id IN (".$survey[0]["sub_functions"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['designations'])){ ?>
                      <tr>
                        <td><h5>Designation :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_designation", "name" , "id IN (".$survey[0]["designations"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['grades'])){ ?>
                      <tr>
                        <td><h5>Grade :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_grade", "name" , "id IN (".$survey[0]["grades"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['levels'])){ ?>
                      <tr>
                        <td><h5>Level :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_level", "name" , "id IN (".$survey[0]["levels"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['educations'])){ ?>
                      <tr>
                        <td><h5>Education :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_education", "name" , "id IN (".$survey[0]["educations"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['critical_talents'])){ ?>
                      <tr>
                        <td><h5>Critical Talent :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_critical_talent", "name" , "id IN (".$survey[0]["critical_talents"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['critical_positions'])){ ?>
                      <tr>
                        <td><h5>Critical Position :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_critical_position", "name" , "id IN (".$survey[0]["critical_positions"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['special_category'])){ ?>
                      <tr>
                        <td><h5>Special Category :</h5></td>
                        <td> <?php echo HLP_get_filter_names("manage_special_category", "name" , "id IN (".$survey[0]["special_category"].")"); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['tenure_company'])){ ?>
                      <tr>
                        <td><h5>Tenure in the company :</h5></td>
                        <td> <?php echo str_replace(",",", ",$survey[0]['tenure_company']); ?> </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($survey[0]['tenure_roles'])){ ?>
                      <tr>
                        <td><h5>Tenure in the Role :</h5></td>
                        <td><?php echo str_replace(",",", ",$survey[0]['tenure_roles']); ?></td>
                      </tr>
                      <?php } ?>
                      <?php if($survey[0]['cutoff_date']){ ?>
                      <tr>
                          <td><h5>Cutoff Date :</h5></td>
                          <td><?php echo date('d/m/Y',strtotime($survey[0]['cutoff_date'])); ?></td>
                      </tr>
                      <?php } ?>
                    </table>
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
<div style="height:250px;"></div>
<script type="text/javascript">
  $(function() {
    $(".expand").on( "click", function() {
      // $(this).next().slideToggle(200);
      $expand = $(this).find(">:first-child");
      var expand = $expand.text();
      $(".expand").find(">:first-child").text("+");
      if(expand != "-")
        $expand.text("-");
    });
  });
</script>
