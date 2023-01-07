

<div class="page-breadcrumb">
    <div class="col-md-4">
        <ol class="breadcrumb container">
            <li><a href="<?php echo base_url('survey/users');?>">Survey List</a></li>
            <li class="active"><?php echo (isset($surveydtl[0]['survey_name']))?$surveydtl[0]['survey_name']:""; ?></li>
        </ol>
    </div>
</div>

<div id="main-wrapper" class="container">
  <div class="aop">
    <div class="row">
        <div class="col-md-12 ">
          <div class="mb20">
            <div class="panel panel-white">




                <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
                <!-- <div class = "panel panel-default"> -->
                    <div class = "panel-body">

                        <?php if(isset($question) && count($question)>0) { ?>
                        <form action="" id="wizard" class="user_que_wizard" method="post" onsubmit="return confirmsurvey(this);">

                            <?php echo HLP_get_crsf_field();?>
                            <input type="hidden" name="surveyID" value="<?php echo $surveyID ?>" />
                             <h4></h4>
<section class="que_div" style="display:none;">
                                <h2 class="qlbl">
                                  <label>Welcome to Compport Survey</label>
                                </h2>
                                <div class="checkbox anssurvey"></div>
                               
</section>
                            <?php $qn=1; foreach($question as $qkey=>$q) { ?>
                            <!-- SECTION <?php echo $qn; ?> -->
                            <h4></h4>
                            <div id="errorMessage" class="errorMessage"></div>
                            <section class="que_div" id="survey_u_question" style="display:none;">
                                <h2 class="qlbl">
                                   
                                  <label><?php echo ucfirst($q['QuestionName']); ?></label>
                                </h2>
                                <fieldset id="form<?= $qkey ?>">
                                  <?php 
                                      $ans = getSurveyAnswer($q['question_id']);
                                      $sub_ques = getSurveySubQuestion($q['question_id']);
                                      if($q['is_mandatory']){
                                        $required = "required";
                                      }else{
                                        $required = '';
                                      }
                                      //print_r($q);
                                      //die;
                                        $userAnswer1 = HLP_getSurveyUserAnswerMulti($q['question_id'],$surveyID,$this->session->userdata('userid_ses'));
                                        $userAnswer = HLP_getSurveyUserAnswer($q['question_id'],$surveyID,$this->session->userdata('userid_ses'));
                                        if(!empty($userAnswer1)){
                                          $resArr = explode(',',$userAnswer1->ids);
                                        }else{
                                          $resArr = array();
                                        }
                                        
                                  ?>
                                  <div style="margin-left: 20px;">
                                       
                                      <?php if($q['QuestionType']==3) { ?>
                                          
                                          <?php foreach($ans as $an) { ?>
                                          <div class="checkbox anssurvey">
                                            <label><input <?= $required; ?> type="radio" name="question[<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>][]" id="ans_<?php echo $q['question_id'] ?>" value="<?php echo $q['question_id'].'_'.$an['surveyAnsID'] ?>"  <?php if(in_array($an['surveyAnsID'], $resArr)){ echo 'checked'; } ?> /><span><?php  echo $an['Answer']; ?></span></label>
                                          </div>
                                          <?php } ?>
                                          <textarea <?= $required; ?> class="form-control" name="question[<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>][]"><?php echo ($userAnswer[0]['textAnswer'] != "")?$userAnswer[0]['textAnswer']:""; ?></textarea>

                                      <?php } else if($q['QuestionType']==2) { ?>
                                          <textarea <?= $required; ?> class="form-control" placeholder="Enter your Answer" name="question[<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>]"><?php echo ($userAnswer[0]['textAnswer'] != "")?$userAnswer[0]['textAnswer']:""; ?></textarea>

                                      <?php } else if($q['QuestionType']==1) {
                                          foreach($ans as $an) { ?>

                                          <div class="checkbox anssurvey">
                                            <label>
                                              <input type="radio" name="question[<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>]" id="ans_<?php echo $q['question_id'] ?>" value="<?php echo $q['question_id'].'_'.$an['surveyAnsID'] ?>" 
                                              <?php if(in_array($an['surveyAnsID'], $resArr)){ echo 'checked'; } ?> <?= $required; ?> />
                                              <span><?php  echo $an['Answer']; ?></span></label>
                                          </div>

                                      <?php } }else if($q['QuestionType']==4) { ?> 
                                          
                                          <div class="rank_response">
                                            <div id="scale">
                                                <div class="row">
                                                   
                                                      <div class="col-sm-12">
                                                          <div class="table-responsive">
                                                                <div class="table-responsive"> 
                                                                    <table class="table_res table table-bordered">
                                                                        <thead>
                                                                         
                                                                          <tr>
                                                                            <th rowspan="2"></th>
                                                                            <th colspan="<?= $q['sacle_upto']; ?>">Rank 1-<?= $q['sacle_upto']; ?></th>  
                                                                          </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                          <?php $sLength = count($sub_ques); foreach ($sub_ques as $k => $v) { ?>
                                                                            <tr>
                                                                                <td><?= $v['QuestionName']; ?>
                                                                                </td>
                                                                                <td>
                                                                                 <div class="box box-example-1to10">
                                                                                     
                                                                                      <div class="box-body">
                                                                                        <select id="example-1to101" class="rankingStep" name="question[<?php echo $v['QuestionType'].'_'.$v['question_id'] ?>][]" autocomplete="off" <?= $required; ?>>
                                                                                          <?php for($j=1; $j<=$q['sacle_upto'];$j++) { 
                                                                                              if($j == 1){
                                                                                            ?>
                                                                                          <option value="<?= $j; ?>" selected="selected"><?= $j; ?></option>
                                                                                          <?php }else{ ?>
                                                                                          <option value="<?= $j; ?>"><?= $j; ?></option>
                                                                                          <?php } } ?>
                                                                                        </select>
                                                                                      </div>

                                                                                 </div>
                                                                                </td>
                                                                                
                                                                            </tr>
                                                                          <?php } ?>
                                                                           

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                          </div>
                                                      </div>
                                                </div>
                                            </div>
                                          </div>

                                      <?php }else if($q['QuestionType']==5) { ?> 
                                        <div id="twodimentional">
                                          
                                          <div class="rank_response">
                                           <br>
                                          <!-- <h3 style="color:#fff;">Two Dimensional</h3> -->
                                              <!-- <h4 style="color:#fff;">Please tick mark your Response </h4> -->
                                              <div class="row">
                                                  <div class="col-sm-12">
                                                      <div class="table-responsive">
                                                            <div class="table-responsive"> 
                                                                <table class="table_res table table-bordered">
                                                                    <thead>
                                                                      
                                                                      <tr>
                                                                        <th>Response</th>
                                                                        <?php  foreach($ans as $an) { ?>
                                                                           <th style="width:140px;"><?= $an['Answer']; ?></th>
                                                                        <?php } ?> 
                                                                            
                                                                      </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                      <?php foreach ($sub_ques as $k => $v) { ?>
                                                                        <tr>
                                                                            <td><?= $v['QuestionName']; ?></td>
                                                                            <?php  foreach($ans as $an) { ?>
                                                                            <td>
                                                                              <div class="checkbox">
                                                                                <label><input type="radio" name="question[<?php echo $v['QuestionType'].'_'.$v['question_id'] ?>]" value="<?= $an['surveyAnsID']; ?>" <?= $required; ?> checked></label>
                                                                              </div>
                                                                            </td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                      <?php } ?>
                                                                       

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                                                    
                                      <?php }else if($q['QuestionType']==6) { ?> 
                                          <div id="threedimentional">
                                            <div class="rank_response">
                                             <br>
                                                <!-- <h3 style="color:#fff;">Three Dimensional</h3> -->
                                                <!-- <h4 style="color:#fff;">Please enter your Response </h4> -->
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                              <div class="table-responsive"> 
                                                                  <table class="table_res table table-bordered">
                                                                      <thead>
                                                                          <tr>
                                                                          <th></th>
                                                                          <?php  foreach($ans as $k=>$an) { ?>
                                                                          <th style="width:140px;">on a scale of 1-<?= ($k+1); ?></th>
                                                                          <?php } ?>  
                                                                        </tr>
                                                                          <tr>
                                                                            <th></th>
                                                                           <?php  foreach($ans as $an) { ?>
                                                                          <th style="width:140px;"><?= $an['Answer']; ?></th>
                                                                          <?php } ?> 
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                        <?php foreach ($sub_ques as $k => $v) { ?>
                                                                          <tr>
                                                                              <td><?= $v['QuestionName']; ?></td>
                                                                               <?php  foreach($ans as $k=>$an) { ?>
                                                                              <td>
                                                                                <input type="text" max="<?= ($k+1); ?>" name="question[<?php echo $v['QuestionType'].'_'.$v['question_id'] ?>][]" class="numeric" value="" <?= $required; ?>>
                                                                              </td>
                                                                              <?php } ?> 
                                                                          </tr>
                                                                           <?php } ?> 
                                                                       

                                                                      </tbody>
                                                                  </table>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>  
                                      <?php }else if($q['QuestionType']==7) { 
                                          foreach($ans as $an) { ?>

                                          <div class="checkbox anssurvey">
                                            <label>
                                              <input type="checkbox" id="<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>" name="question[<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>][]" value="<?php echo $an['surveyAnsID'] ?>" 
                                              <?php if(in_array($an['surveyAnsID'], $resArr)){ echo 'checked'; } ?> <?= $required; ?> />
                                              <span for="<?php echo $q['QuestionType'].'_'.$q['question_id'] ?>" style="margin-left: 6px;"><?php  echo $an['Answer']; ?></span></label>
                                          </div>
                                      <?php } } ?>

                                  </div>

                                   </fieldset>
                            </section>

                            <?php $qn++; } ?>
                            <div class="form-group" id="sbmt" style="color:#fff; position:absolute; /*bottom: 4%;*/ right:10%; ">
                                <input type="hidden" name="submittype" value="">
                                <input type="button" onclick="formsubmit(1);" value="Save as Draft" name="draft" class="btn" id="btnsvasbraft" />
                                <!-- <input type="submit" onclick="formsubmit(1);" value="Save as Draft" name="draft" class="btn" id="btnsvasbraft" /> -->
                                <input type="submit" onclick="formsubmit(2);" value="Final Submission" name="save" class="hide" id="btnsbmt" />
                            </div>
                        </form>
                        <?php } else { echo '<h4 style="text-align:center;margin-top:10px;">No questions found</h4>'; } ?>
                    </div>
                <!-- </div> -->
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<style type="text/css">
#btnsvasbraft:hover{color: #fff;}
.user_que_wizard section.que_div{ background: #<?php echo $this->session->userdata("company_color_ses");?>;;}
    .qlbl{
        margin-bottom: 10px;
        font-size: 20px;
    }
    .panel-white{padding-bottom : 2px;}
    .user_que_wizard .steps ul:before {
      content: "Question number 1";
      font-size: 25px;
      color: #4E5E6A;
      font-family: "Poppins-Medium"; }
    .user_que_wizard .steps ul:after {
      content: " out of  <?php echo count($question);?>";
      font-size: 25px;
      color: #4E5E6A;
      font-family: "Poppins-Medium";
      position: absolute;
      right: -91%;
      top: 0px;
      width: 170px; }
    <?php $s=2; foreach ($question as $key => $value) {
      echo '.user_que_wizard .steps ul.step-'.$s.':before {
          content: " Question number '.$s.'"; }
        .user_que_wizard .steps ul.step-'.$s.':after {}';
      $s++; }?>
</style>
<script src="<?php echo base_url('assets/js/'); ?>/jquery.validate.js"></script>

<script>

 
 
  function formsubmit(type){
        $('input[name=submittype]').val(type);
        if(type == 1){
          $('#loading').show();
          console.log($('#wizard').serialize());
            $.post('<?php echo base_url('survey/user-survey-questions/'.$surveyID); ?>', 
                $('#wizard').serialize()).done(function( data ) {
                $('#loading').hide(); alert("Your Response has been saved as Draft");
              });
        }
  }

    // function formsubmit(type){
    //     $('input[name=submittype]').val(type);
    //     if(type == 1){
    //       $('#loading').show();
    //       console.log($('#wizard').serialize());
    //         $.post('<?php echo base_url('survey/user-survey-questions/'.$surveyID); ?>', $('#wizard').serialize()).done(function( data ) {$('#loading').hide(); alert("Your Response has been saved as Draft");});
    //     }
    // }
    function confirmsurvey(ths) {

        if($(ths).find("input[name=submittype]").val() == 2){
            if(!confirm('Once submitted you will not be able to check or edit the survey. Would like to submit?')){ 
              console.log($('#loading'));
                $('#loading').remove();
                return false;
            }
        } else{
            if(!confirm('Are you sure?')){ 
                $('#loading').remove();
                return false;
            }
        }
        
    }

    var form = $("#wizard");
    form.validate({
      errorPlacement: function errorPlacement(error, element) { element.before(error); },
      rules: {
        field: {
          required: true
        }
      },
      errorPlacement: function(error, element) {
        //console.log(error);
        $('#errorMessage').html('This is mandatory question');
      }
    // messages: {},
    // errorElement : 'div',
    // errorLabelContainer: '.errorMessage'
    });
    $(function(){
      $("#wizard").steps({
          headerTag: "h4",
          bodyTag: "section",
          transitionEffect: "fade",
          enableAllSteps: true,
          transitionEffectSpeed: 300,
          labels: {
              next: "Next  <i style='margin-left:5px;' class='fa fa-arrow-right' aria-hidden='true'></i>",
              previous: " <i style='margin-right:5px;' class='fa fa-arrow-left' aria-hidden='true'></i> Back"
          },

          onStepChanging: function (event, currentIndex, newIndex) { 
            var flag = false;
            if(currentIndex < newIndex){
              //alert('next');
              $('#errorMessage').html('');
              form.validate().settings.ignore = ":disabled,:hidden";
              flag= form.valid();
            }else{
              //alert('pre');
              flag = true;
            }
             <?php $s=1; foreach ($question as $value) {
                echo "if ( newIndex === ".$s." ) {
                        $('.steps ul').addClass('step-".($s+1)."');
                    } else {
                        
                        $('.steps ul').removeClass('step-".($s+1)."');
                    }";
                $s++; } ?>
              return flag; 
          },
          onFinished: function (event, currentIndex)
          {
              $("#btnsbmt").trigger("click");
          }
      });
      // Custom Button Jquery Steps
      $('.forward').click(function(){
        //alert();
          $("#wizard").steps('next');
      });
    });
</script>
<script src="<?php echo base_url("assets/js/survey_qus_steps.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery.barrating.js"); ?>"></script>
<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
<script>
  $(document).ready(function(){$('#survey_u_question').css('display','block')});
</script>

<style type="text/css">
  table.cust_p_p tr td{background-color: unset !important;}

  /***bar scale css**/
  /* Boxes */
  .box {
    width: 100%;
    float: left;
    padding: 5px;
  }

  .box .box-body {
    position: relative;
  }


  .box .br-wrapper {}

   @media print {   
  .box-blue .box-body {
      background-color: transparent;
      border: none;
    }
  }

  .br-theme-bars-1to10 .br-widget {
    white-space: nowrap;
    text-align: center;
  }

  .br-theme-bars-1to10 .br-widget a {
    display: inline-block;
    width: 12px;
    padding: 5px 0;
    height: 24px;
    background-color:#ddd;
    margin: 1px;

  }
  .br-theme-bars-1to10 .br-widget a.br-active,
  .br-theme-bars-1to10 .br-widget a.br-selected {
    background-color:red !important;
  }

  .br-theme-bars-1to10 .br-widget .br-current-rating {
    font-size: 20px;
    padding-left:15px;
    display: inline-block;
   color: red !important;
    font-weight: 400;
    font-size: 18px;
    vertical-align: super;
  }

  .br-theme-bars-1to10 .br-readonly a {
    cursor: default;
  }

  .br-theme-bars-1to10 .br-readonly a.br-active,
  .br-theme-bars-1to10 .br-readonly a.br-selected {
    background-color: #f2cd95;
  }

  .br-theme-bars-1to10 .br-readonly .br-current-rating {
    color: #f2cd95;
  }


  @media print {
    .br-theme-bars-1to10 .br-widget a {
      border: 1px solid #b3b3b3;
      background: white;
      height: 28px;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }
    .br-theme-bars-1to10 .br-widget a.br-active,
    .br-theme-bars-1to10 .br-widget a.br-selected {
      border: 1px solid black;
      background: white;
    }
    .br-theme-bars-1to10 .br-widget .br-current-rating {
      color: black;
    }
  }
</style>
<script type="text/javascript">
 /***bar scale script**/   
    function ratingEnable() {

        $('.rankingStep').barrating('show', {
            theme: 'bars-1to10'
        });
    }



    function ratingDisable() {
        $('select').barrating('destroy');
    }

    $('.rating-enable').click(function(event) {
        event.preventDefault();
        //alert();
        ratingEnable();

        $(this).addClass('deactivated');
        $('.rating-disable').removeClass('deactivated');
    });

    $('.rating-disable').click(function(event) {
        event.preventDefault();

        ratingDisable();

        $(this).addClass('deactivated');
        $('.rating-enable').removeClass('deactivated');
    });
$(document).ready(function(){
   ratingEnable();

   $(document).on("input", ".numeric", function() {
    var val = $(this).val();
    if($.isNumeric(val)){
      if($(this).attr('max') < val){
        alert('invalid input');
        val='';
      }else{
          val=$(this).val();
      }
    }else{
        val='';
    }
    this.value = val;
    return false;
   
       // this.value = this.value.replace(/\D/g,val);
    });
});
   
</script>


<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 