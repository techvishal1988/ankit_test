<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery.barrating.js"); ?>"></script>

<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
<script type="text/javascript">
var $currentform = "1basicsurvey";
$(document).ready( function() {
$("#description").Editor();    
$('#description').Editor('setText','<?php echo str_replace("'","\'",$survey[0]["description"]); ?>');

$("#close_description").Editor(); 
$('#close_description').Editor('setText','<?php echo str_replace("'","\'",$survey[0]["closing_description"]); ?>');

$('form.survey').submit(function() {
var data1 = $('#contentarea').text().trim();
var shortdata1 = $('.close_desc #contentarea').text().trim();
if(data1.length == 0) {
$('#contentarea').html('');
custom_alert_popup('Please enter Create message to be sent to employees at the time of survey launch');
$('#loading').css('z-index','0').css('opacity','0.0 !important');
return false;
} else if(shortdata1.length == 0) {
$('.close_desc #contentarea').html('');
custom_alert_popup('Please enter Create thank you message when a participant finishes the survey');
$('#loading').css('z-index','0').css('opacity','0.0 !important');
return false;
} else {
var data=$('#contentarea').html();
$('#desc').val(data);
var shortdata = $('.close_desc #contentarea').html();
$('#close_desc').val(shortdata);
// if(request_confirm()){
$('#loading').css('z-index','99999999').css('opacity','0.8 !important');
return true;    
// }else{
//     return false;
// }
}
});

$('#survey_name').blur(function(){
let sname = this.value.trim();
if(sname.length == 0){
$(this).val('');
}
});


//Initialize tooltips
$('.nav-tabs > li a[title]').tooltip();

$('.wizard .nav-tabs li').click( function(e) {
setTimeout(function(){ 
$( '.wizard .nav-tabs li.active' ).next().removeClass('disabled');
}, 300);
});

$( '.wizard .nav-tabs li.active' ).next().removeClass('disabled');

$(".create_more_que").click( function(e){
$('.r_response').attr('required',true);
var formdiv = $('#QuestionForm');
var btnObj = $(this);
if(formdiv.hasClass('hide')){
formdiv.removeClass("hide");
//$('#que_next').html('<input style="margin-left:10px; margin-bottom:10px;" type="submit" name="btn_save_exit" value="Next" class=" btn btn-primary pull-right" />');
$('#que_next1').html('<input style="margin-left:10px; margin-top:10px;" type="submit" name="btn_save_exit" value="Next" class=" btn btn-primary pull-right" />');
// var scroll=$('#QuestionForm');

// scroll.animate({scrollTop: scroll.prop("scrollHeight")});

//btnObj.attr("type","submit");
}
});


$(".expand1").click( function() {
$expand = $(this).find(">:first-child");
if($(this).closest('.panel-default').find('div.collapse').hasClass('in')){
$expand.text("+");
} else{$expand.text("-");}
});

$(".expand2").click( function() {
$expand = $(this).find(">:first-child");
if($(this).closest('.panel-default').find('div.collapse').hasClass('in')){
$expand.text("+");
} else{$expand.text("-");}
});

$(".expand3").click( function() {
$expand = $(this).find(">:first-child");
if($(this).closest('.panel-default').find('div.collapse').hasClass('in')){
$expand.text("+");
} else{$expand.text("-");}
});

$("#scaleUpto").keypress(function(event){
//console.log('out');
if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
//console.log('aaaaaaaa');
event.preventDefault(); //stop character from entering input
}
});

}); 
//Wizard
function stopTab(ths){
if (!$(ths).parent().hasClass('disabled')) {
return true;
}
return false;
}  
function stopTab1(ths){
if (!$(ths).parent().hasClass('disabled')) {
if(request_confirm()){
return true;
}
}
return false;
}  

function hasWhiteSpace(obj ,s)
{
reWhiteSpace = new RegExp(/^\s+$/);
if (reWhiteSpace.test(s)) {
$(obj).val('');
return false;
}
return true;
}


</script>
<?php 
$checkdays = 0;
if(isset($survey[0]['start_date']) && $survey[0]['start_date'] != '0000-00-00'){ 
$date1=date_create($survey[0]['start_date']);
$date2=date_create(date("Y-m-d"));
$diff=date_diff($date1,$date2);
$checkdays = $diff->format("%a"); 
}
?>
<div class="page-breadcrumb">
<ol class="breadcrumb container">
<li><a href="<?= base_url('survey');?>">Survey</a></li>
<?php if(!empty($survey)) { ?>
<li><a href="<?= base_url('survey/dashboard-analytics');?>">Dashboard</a></li>
<?php } ?>
<li class="active"> <?php echo (!empty($survey)) ? 'Update Survey':'Create Survey'; ?></li>
</ol>
</div>

<div id="main-wrapper" class="container">
<div class="row">
<div class="col-md-12">
<div class="panel panel-white pad_b_10" >
<?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
<section>
<div class="wizard">
<div class="wizard-inner">
<div class="connecting-line"></div>
<ul class="nav nav-tabs" role="tablist">
<?php $setp1class = "active";$setp2class ="disabled";$setp3class ="disabled";$setp4class ="disabled";$setp5class ="disabled";
if(isset($survey[0]['survey_name']) && $survey[0]['survey_name']!=''){
$setp1class = "pre-active";
} 
if($pageName == 'survey'){
$setp1class = "active";
}
if(count($questions)!=0){
$setp2class = "pre-active";
}
if($pageName == 'question'){
$setp2class = "active";
}
if(isset($survey[0]['country']) && $survey[0]['country']!=''){
$setp3class = "pre-active";
}
if($pageName == 'filtersurvey'){
$setp3class = "active";
}
if(isset($survey[0]['start_date']) && $survey[0]['start_date'] != '0000-00-00'){
$setp4class = "pre-active";
}
if($pageName == 'setupsurvey'){
$setp4class = "active";
}

if(isset($survey[0]['is_published']) && $survey[0]['start_date'] != '0000-00-00'){
$setp5class = "";
}
if(isset($survey[0]['is_published']) && $survey[0]['is_published'] > 0){
$setp5class = "pre-active";
}
if($pageName == 'launchSurvey'){
$setp5class = "active";
}
?>

<li role="presentation" class="<?php echo $setp1class;?>" id="1basicsurvey">
<a href="<?php echo base_url('survey/create/'.$survey_id);?>" onclick="return stopTab(this);" class="next-step" role="tab" title="Step 1">
<span class="round-tab">
    <i class="glyphicon glyphicon-folder-open"></i>
</span>
</a>
<p>1. Initiate Survey</p>
</li>

<li role="presentation" class="<?php echo $setp2class;?>" id="2question">
<a href="<?php echo base_url('survey/questions_create/'.$survey_id);?>"  role="tab" onclick="return stopTab(this);" title="Step 2">
<span class="round-tab">
    <i class="glyphicon glyphicon-pencil"></i>
</span>
</a>
<p>2. Questions</p>
</li>
<li role="presentation" class="<?php echo $setp3class;?>" id="3filter">
<a href="<?php echo base_url('survey/survey_filters/'.$survey_id);?>" role="tab" onclick="return stopTab(this);" title="Step 3">
<span class="round-tab">
    <i class="glyphicon glyphicon-filter"></i>
</span>
</a>
<p>3. Select Participants</p>
</li>

<li role="presentation" class="<?php echo $setp4class;?>" id="4setup">
<a href="<?php echo base_url('survey/publish/'.$survey_id);?>" role="tab" title="step 4">
<span class="round-tab">
    <i class="glyphicon glyphicon-ok"></i>
</span>
</a>
<p>4. Setup Survey</p>
</li>
<li role="presentation" class="<?php echo $setp5class;?>" id="5launch">
<a href="<?php echo base_url('survey/launch/'.$survey_id);?>" role="tab" onclick="return stopTab(this);" title="Complete">
<span class="round-tab">
    <i class="glyphicon glyphicon-send"></i>
</span>
</a>
<p>Launch</p>
</li>
</ul>
</div>

<div class="tab-content">
<div class="tab-pane <?php echo ($pageName == 'survey')?'active':'';?>" role="tabpanel" id="step1">
<form class="form-horizontal survey" method="post" action="<?php echo base_url('survey/create/'.$survey_id);?>" enctype="multipart/form-data" id="form-1basicsurvey">
<?php echo HLP_get_crsf_field();?>
<input type="hidden" name="survey_id" value="<?php echo $survey_id ?>" />
<div class="row">
<div class="col-sm-12">
    <input style="margin-bottom:10px;" type="submit" class="btn btn-primary pull-right" value="Next"/>
</div>
</div>
<div class="row">
<!-- <div class="col-sm-4 left_div ">
    <div class="form-group my-form">
     <label class="col-sm-5 col-xs-12 control-label removed_padding" for ="temptile"> Survey Category</label>
        <div class="col-sm-7 col-xs-12 form-input removed_padding"> 
         <select required="true" id="survey_category" name="survey_category" class="form-control" <?php echo (isset($survey[0]['category_id']) && $survey[0]['category_id']!='')?'disabled="disabled"':"";?>>
            <option value="">Select Category</option>
            <?php 
                if(!empty($category)) {
                    foreach($category as $cat) {
                        $sel = '';
                        if(!empty($survey) && ($cat['id'] == $survey[0]['category_id'])){
                            $sel = 'selected="selected"';
                        }
            ?>            
                        <option <?=$sel;?> value="<?=$cat['id'];?>"><?=ucwords($cat['name']);?></option>
            <?php        }
                }
            ?>
         </select>
       </div> 
    </div>
</div> -->

<div class="col-sm-4 ">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Survey Name</label>
        
      <div class="col-sm-8 col-xs-12 form-input removed_padding">  
        <input required="true" type="text" id="survey_name" name="survey_name" value="<?php echo @$survey[0]['survey_name'] ?>" placeholder="Enter survey name"  class="form-control" maxlength="500"/>
      </div>  
    </div>
</div>

<div class="col-sm-4" style="padding-left:0px;">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Survey Category</label>
      <div class="col-sm-8 col-xs-12 form-input removed_padding">
      <select name="survey_category" class="form-control" required="">
        <!-- <option value="2">Employee Insights</option> -->
        <?php
            foreach ($categories as $key => $category) { ?>
             <option value="<?= $category['id'] ?>" <?php if($category['id'] == @$survey[0]['category_id']){ echo 'selected'; } ?>><?= $category['name'] ?></option>   
           <?php }
        ?>
        
      </select>
    </div>   
    </div>
</div>

<div class="col-sm-4 left_div" style="padding-left:0px;">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Survey Image</label>
       <div class="col-sm-8 col-xs-12 form-input removed_padding">  
        <input style="width:103%" type="file" id="survey_image" name="survey_image" class="form-control sur_img_area" accept="image/*"/>
        <?php 
            $src = '';
            if(!empty($survey) && !empty($survey[0]['survey_img'])){
                $src = base_url($survey[0]['survey_img']);
            }
        ?>        
        <img src="<?=$src;?>" id="preview_img" />
    </div>
   </div> 
</div>

<div class="col-sm-6 mt-10">
   <span style="width:100%; font-weight: bold; font-size: 13px !important; letter-spacing: .5px; margin-bottom: 10px;" class="control-label" for ="description"> Create message to be sent to employees at the time of survey launch</span>
    <textarea style="height:100px !important;" rows="3"  class="form-control wht_lvl " id="description" placeholder="Enter Description"></textarea>
    <input  type="hidden" name="desc" id="desc"/>
</div>

<div class="col-sm-6 mt-10 close_desc">
   <span style="width:100%; font-weight: bold; font-size: 13px !important; letter-spacing: .5px; margin-bottom: 10px;" class="control-label" for ="description"> Create thank you message when a participant finishes the survey</span>
     <textarea style="height:100px !important;"  class="form-control wht_lvl " id="close_description" placeholder="Close Description"></textarea>
     <input  type="hidden" name="close_desc" id="close_desc"/>
</div>

</div>
<div class="row">
<div class="col-sm-12">
    <input style="margin-top:10px;" type="submit" class="btn btn-primary pull-right" value="Next"/>
</div>
</div>
</form>  
</div>

<div class="tab-pane <?php echo ($pageName == 'question')?'active':'';?>" role="tabpanel" id="step2">
<?php if($question[0]['QuestionName'] !='') { ?>
<form class="form-horizontal quen_cret" method="post" action="<?php echo base_url('survey/questions_edit/'.$survey_id.'/'.$questionID);?>" enctype="multipart/form-data" id="form-2question">
<?php } else { ?>
<form class="form-horizontal quen_cret" method="post" action="<?php echo base_url('survey/questions_create/'.$survey_id);?>" enctype="multipart/form-data" id="form-2question">
<?php } ?>
<?php echo HLP_get_crsf_field();?>
<div class="row">
<div class="col-sm-12">
<?php if(count($questions) > 0) { 
  if($question[0]['QuestionName'] !='') { ?>
    <a href="<?php echo base_url('survey/questions_create/'.$survey_id); ?>" value="Next" style="margin-left:10px; margin-bottom:10px;" class="mar_b_10 btn btn-primary pull-right" >Skip</a>

    <!-- <input type="submit" name="update" value="Update" class=" btn btn-primary pull-right" /> -->

  <?php } else { ?>
    <span id="que_next"><a href="<?php echo base_url('survey/survey_filters/'.$survey_id); ?>" value="Next" style="margin-left:10px; margin-bottom:10px;" class="mar_b_10 btn btn-primary pull-right" >Next</a></span>

    <a href="#QuestionForm" name="btn_save_create_more" class=" btn btn-primary pull-right create_more_que"> Add More Question</a>
  <?php } 
} else { ?>
    <input style="margin-left:10px; margin-bottom:10px;" type="submit" name="btn_save_exit" value="Next" class=" btn btn-primary pull-right" />
    
    <input type="button" name="btn_save_create_more" value="Add more question" class=" btn btn-primary pull-right" />

<?php } ?>
</div>
</div>
<?php if(count($questions)!=0) { ?>

<div class="row">
<div class="col-md-12">    
<table class="table border cust_p_p" id="glossary">
    <thead>
        <th class="nobor" style="text-align:left !important;">Question</th>
        <th class="nobor" style="width:100px; text-align:center !important;">Mandatory</th>
        <th style="width:120px; text-align:center !important;" <?php echo @$clsshide ?>>Action</th>
    </thead>
    <tbody>
        <?php foreach ($questions as $g){ ?> 
        <tr>
            
            <td class="nobor"><?php echo $g['QuestionName']; ?></td>
            <td class="nobor"><div style="margin-top:-9px;text-align:center!important;" class="checkbox">
                 
                    <?php
                        if($g['is_mandatory'] == 1){ $check = "checked"; ?>
                            <span style="color:#4E5E6A;font-size:12px" >Yes</span>
                        <?php }else{ $check = ""; ?>
                             <span style="color:#4E5E6A;font-size:12px">No</span>
                        <?php }
                    ?>
                    
                </div>
            </td>
            <td style="text-align:center !important;" <?php echo @$clsshide ?>>
                
                <a href="<?php echo base_url('survey/questions_edit/'.$g['survey_id'].'/'.$g['question_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | <a href="<?php echo base_url('survey/deleteQuestion/'.$g['survey_id'].'/'.$g['question_id']) ?>" onclick="return confirm('<?php echo CV_CONFIRMATION_MESSAGE;?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
                
            </td>
            
            
        </tr>
		
		<tr class="edit_bg" id="tr_q_row_<?php echo $g['question_id']; ?>" style="display:none;"><td style="border-top:0px;" colspan="3" id="td_q_row_<?php echo $g['question_id']; ?>">new</td>                                            
        </tr>
            
            <?php } ?>
    </tbody>
</table>
</div>    
</div>

<?php } ?>



<div id="QuestionForm" class="hide animated fadeInUp">

<div class="row"> 
<div class="col-md-12">
    <div class="form-group my-form">
        <label style="width: 16.2%;"  class="col-sm-2 col-xs-12 control-label removed_padding" for ="QuestionName"> Question</label>

        <div class="col-sm-10 col-xs-12 form-input removed_padding">
         <input style="width: 100.7%;border:none;" required="true" type="text" id="question_name" name="QuestionName" value="<?php echo @$question[0]['QuestionName'] ?>" placeholder="Enter question name"  class="form-control" onkeypress="return hasWhiteSpace(this,this.value)" maxlength="1000"/>
        </div> 
    </div>
</div>   
<div class="col-md-6">
    <div class="form-group my-form">
    <label class="col-sm-4 col-xs-12 control-label removed_padding"  for ="QuestionType"> Question Type</label>
        <div class="col-sm-8 col-xs-12 form-input removed_padding">
           
           
         <?php if($this->uri->segment(2) == 'questions_edit'){  
            $disabled= "disabled"; ?>
         <?php }else{ 
            $disabled= "";
          } ?>  
          <select id="qustiontypeoption" name="QuestionType" onchange="chkType(this.value)" class="form-control" required="" readonly>

            <?php
                foreach ($question_types as $key => $question_type) { ?>
                    <option value="<?= $question_type['id']; ?>" <?php if($question_type['id'] == $question[0]['QuestionType'] ){ echo 'selected'; }else{ echo $disabled; } ?> ><?= $question_type['name']; ?></option>
                <?php }
            ?>
          </select>
        </div>  
    </div>
</div>
<div class="col-md-6">
    <div class="form-group my-form">
       
        <div class="col-sm-12 col-xs-12 form-input removed_padding" style="text-align: right;">
        <?php 
        if(empty($question)){
            $check = "checked";
        }else{
        if($question[0]['is_mandatory'] == 1){
            $check = "checked";
        }else{
            $check = ""; 
        }

        } 
        ?>
        <input style="float: left; margin-left: 10px; margin-top: 8px;"  type="checkbox" id="mandetory" name="mandetory" value="1" <?= $check; ?>>
        <label class="control-label removed_padding" for ="mandetory"> Mandatory </label>
        </div> 
        
    </div>
</div>
<div class="col-md-12 both" <?php if(@$question[0]['QuestionType'] != '2') {echo 'style="display:none"';} ?>>
    <div class="form-group my-form">
        <label class="col-sm-2 col-xs-12 control-label removed_padding" for ="QuestionName"> Title </label>
        <div class="col-sm-10 col-xs-12 form-input removed_padding">
         <input  type="text" id="QuestionTitle" name="QuestionTitle" value="<?php echo $question[0]['QuestionTitle'] ?>" placeholder="Enter question title" onkeypress="return hasWhiteSpace(this,this.value)"  class="form-control r_title" maxlength="1000"/>
        </div> 
    </div>
</div>


</div>


<div class="animated fadeInDown" id="subQuestionOuterSection" <?php if(empty($sub_ques)){ echo 'style="display:none"'; } ?> >
<div class="panel panel-default panelp">
    <div class="panel-heading">Sub Question</div>
    <div class="panel-body" style="margin-top: 10px;">
        <div id="subQuestionSection">
            <?php $count= 1; 
            if(!empty($sub_ques)){ $count=count($sub_ques); }
                $k=1;
            for($i=0;$i<$count;$i++) {  ?>
                <div class="col-md-12 oldRow pad0" style="padding:0px;">
                    <div class="form-group my-form">
                        <label class="labelSubQues col-sm-2 col-xs-12 control-label grey removed_padding"  for ="temptile" > Sub Question <?= ($i+1); ?></label>
                        <div class="col-sm-10 col-xs-12 form-input removed_padding">
                        <input onkeypress="return hasWhiteSpace(this,this.value)" type="text" id="subQuestion" name="subQuestion[]" placeholder="Enter Sub Question"  value="<?= $sub_ques[$i]['QuestionName']; ?> " class="form-control ans_value r_subquestion"/>
                       
                        </div>
                         <?php 
                        if(!empty($sub_ques)){
                        echo '<input type="hidden" name="subQuesId[]" value="'.$sub_ques[$i]['question_id'].'" />';
                        }
                        ?>
                        <?php if($i!=0){ ?>
                        <button type="button" rid="<?= $i; ?>" onclick="remove(this)" class="btn det_dyn_btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        <?php } ?>
                    </div>
                </div>
            <?php $k++;
            } 
            ?>
            

        </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <button type="button" rid="<?= $i; ?>" class="btn btn-danger" id="addMoreQuestionBtn" onclick="addMoreQuestion(this)" title="add more sub question"><i class="fa fa-plus text text-white" aria-hidden="true"></i>&nbsp;Sub Question</button>
            </div>
        </div>    
    </div>
</div>
</div>

<div id="rankingSection" <?php if($question[0]['QuestionType'] !='4' && $question[0]['QuestionType'] !='6') {echo 'style="display:none"';} ?> >
<!--  <div  class="col-md-12"> -->
    <div class="form-group my-form">
        <label style="width: 16.2%;" class="col-sm-2 col-xs-12 control-label grey removed_padding"  for ="temptile" > Scale Upto</label>
        <div style="width: 83.8%;" class="col-sm-10 col-xs-12 form-input removed_padding">
            <input  type="number" id="scaleUpto"  name="scaleUpto" value="<?php echo $question[0]['sacle_upto'] ?>" placeholder="Enter Scale Upto"  class="form-control r_upto" maxlength="10"/>
        </div>
    </div>
<!-- </div> -->
</div>

<div id="optionSection" class="row answers" <?php if($question[0]['QuestionType'] =='2' || $question[0]['QuestionType'] =='4' || $question[0]['QuestionType'] =='6') {echo 'style="display:none"';} ?>>
<?php $a_count=$count= 4; 
if(!empty($answer)){ $a_count=$answer_count;$count=count($answer); }
    $k=1;
for($i=0;$i<$count;$i++) { 
        if(!empty($answer)){
            echo '<input type="hidden" name="awsid[]" value="'.$answer[$i]['surveyAnsID'].'" />';
        }
        if($a_count > $i){
    ?>
    <div  class="col-md-6">
        <div class="form-group my-form">
            <label class="labelResponse col-sm-4 col-xs-12 control-label grey removed_padding"  for ="temptile" > Response <?php echo ($i+1);  ?></label>
            <div class="col-sm-8 col-xs-12 form-input removed_padding">
             <input onkeypress="return hasWhiteSpace(this,this.value)" type="text" value="<?php echo $answer[$i]['Answer'] ?>" id="ans<?php echo $k ?>" name="answer[]" placeholder="Enter options" class="form-control ans_value inp_ans response <?php if($k < 3){echo 'r_response';} ?>" />
           
            </div>
            
        </div>
    </div>
<?php $k++;
 } }
?>
</div>

<div class="row">


<div class="col-sm-12 text-right">
    <?php if($this->uri->segment(2) == 'questions_edit'){ ?>
          <input type="submit" name="update" value="Update" class=" btn btn-primary">
    <?php }else{ ?>
         <input value="Save" type="submit" name="btn_save_create_more" class="btn btn-warning" / >
    <?php } ?>
  

   
    <button <?php if($question[0]['QuestionType'] =='2' || $question[0]['QuestionType'] =='4') {echo 'style="display:none"';} ?> id="addMoreBtn" type="button" rid="<?= $i; ?>" class="btn btn-warning " onclick="addMore(this)" title="add more response"><i class="fa fa-plus plus" aria-hidden="true"></i>&nbsp;Response</button>
</div>

</div>

</div>


<?php if(count($questions) > 10) { ?>
<div class="row">
<div class="col-sm-12">
<?php if($question[0]['QuestionName'] !='') { ?>
    <a href="<?php echo base_url('survey/questions_create/'.$survey_id); ?>" value="Next" style="margin-left:10px; margin-top:10px;" class="mar_b_10 btn btn-primary pull-right" >Skip</a>

    <!-- <input type="submit" name="update" value="Update" class=" btn btn-primary pull-right" style="margin-left:10px; margin-top:10px;"/> -->

  <?php } else { ?>
    <span id="que_next1"><a href="<?php echo base_url('survey/survey_filters/'.$survey_id); ?>" value="Next" style="margin-left:10px; margin-top:10px;" class="mar_b_10 btn btn-primary pull-right" >Next</a></span>

    <input type="button" name="" value="Add More Question" class=" btn btn-primary pull-right create_more_que" style="margin-left:10px; margin-top:10px;"/>
  <?php } ?>
</div>
</div>
<?php } ?>
</form>
</div>

<div class="tab-pane <?php echo ($pageName == 'filtersurvey')?'active':'';?>" role="tabpanel" id="step3">
<div class="panel-body">
<?php 
//echo $this->session->flashdata('message'); echo $msg;  
$tooltip=getToolTip('survey-filters');
$val = json_decode($tooltip[0]->step);
?>
<div class="salary_rt_ftr" style="position: relative;margin-top: 4%;">
<div class="form_head clearfix">
  <div class="col-sm-12">
    <ul>
      <li>
        <div class="form_tittle">
          <h4>Step One</h4>
        </div>
      </li>
      <li>
        <div class="form_info">
          <button type="button" class="btn btn-default" data-toggle="tooltip" title="<?php echo $val[0] ?>"  data-placement="bottom" title="Step One">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
          </button>
        </div>
      </li>
      <li>
          <form class="form-horizontal" method="post" action="<?php echo base_url('survey/survey_filters/'.$survey_id);?>">
              <?php echo HLP_get_crsf_field();?>
              <input type="hidden" name="hf_select_all_filters" value="1" />
              <input type="submit" value="Select All" class="btn btn-primary"/>
          </form>
          <?php $select_all = "";
                if($this->input->post("hf_select_all_filters"))
                {
                  $select_all = 'selected="selected"';  
                }
          ?>
      </li>
    </ul>
  </div>        
</div>
<div class="form_sec clearfix">
<form class="form-horizontal mob_no_lbl_bg" method="post" action="<?php echo base_url('survey/survey_filters/'.$survey_id);?>" id="form-3filter">
    <?php echo HLP_get_crsf_field();?>
  <div class="row">
    <div class="col-sm-6">
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Survey For</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
               
            <div class="">
             <select id="survey_for"  name="survey_for"  class="form-control multipleSelect" required="required" multiple="multiple">
                 <?php
                        if($survey[0]['survey_for']=='manager')
                        {
                            $manager='selected';
                        }
                        if($survey[0]['survey_for']=='employee')
                        {
                            $employee='selected';
                        }
                        if($survey[0]['survey_for']=='both')
                        {
                            $both='selected';
                        }else{
                           $both='selected';
                        }
                 ?>  
                 <option  value="manager" <?php echo $manager ?>  <?php echo $select_all; ?> >People Managers</option>
                   <option  value="employee" <?php echo $employee ?>  <?php echo $select_all; ?> >Individual Contributor</option>
                   <option  value="both" <?php echo $both ?> <?php echo $select_all; ?> >Both</option>
                   
                </select>
              </div>
           </div>  
        </div>

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Country</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
               <input type="hidden" name="survey_id" value="<?php echo  $survey[0]['survey_id'] ?>" />
            <div class="">
             <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($country_list)){?>
  <option  value="all">All</option>
  <?php  foreach($country_list as $row){
                        
                        if(in_array($row["id"],explode(',',$survey[0]['country'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                    <?php } }else{ ?>
<option  value="0" selected=""  <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">City</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">                              
             <select id="ddl_city" onchange="hide_list('ddl_city');" name="ddl_city[]" class="form-control multipleSelect" required="required" multiple="multiple">
                     <?php 
if(!empty($city_list)){?>
  <option  value="all">All</option>
  <?php foreach($city_list as $row){
                         if(in_array($row["id"],explode(',',$survey[0]['city'])))
                            {
                                $selected='selected';
                            }
                            else {
                                $selected='';
                            }
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                     <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>
        </div>
        
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Business Level 1</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
             <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($bussiness_level_1_list)){?>
  <option  value="all">All</option>
  <?php foreach($bussiness_level_1_list as $row){
                        if(in_array($row["id"],explode(',',$survey[0]['business_level1'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>  

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Business Level 2</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
             <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" required="required" multiple="multiple">
                   <?php 
if(!empty($bussiness_level_2_list)){?>
  <option  value="all">All</option>
  <?php foreach($bussiness_level_2_list as $row){ 
                        if(in_array($row["id"],explode(',',$survey[0]['business_level2'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div> 

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Business Level 3</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
             <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($bussiness_level_3_list)){?>
  <option  value="all">All</option>
  <?php foreach($bussiness_level_3_list as $row){
                        if(in_array($row["id"],explode(',',$survey[0]['business_level3'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?>  <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div> 

        <div class="form-group my-form attireBlock">
         <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Function</label>
         <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
          <div class="">
           <select id="ddl_function" onchange="hide_list('ddl_function');" name="ddl_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                  <?php 
if(!empty($function_list)){?>
  <option  value="all">All</option>
  <?php foreach($function_list as $row){
                      if(in_array($row["id"],explode(',',$survey[0]['functions'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }
                        ?>
                  <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
                 <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
              </select>
            </div>
         </div>  
        </div>  
                    
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Sub Function</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
               <select id="ddl_sub_function" onchange="hide_list('ddl_sub_function');" name="ddl_sub_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($sub_function_list)){?>
  <option  value="all">All</option>
  <?php foreach($sub_function_list as $row){
                        if(in_array($row["id"],explode(',',$survey[0]['sub_functions'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
                    <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>
                                
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Designation</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
               <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($designation_list)){?>
  <option  value="all">All</option>
  <?php foreach($designation_list as $row){ 
                        if(in_array($row["id"],explode(',',$survey[0]['designations'])))
                        {
                            $selected='selected';
                        }
                        else {
                            $selected='';
                        }   
                        ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
                    <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>                  
    </div>

    <div class="col-sm-6">
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Grade</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
             <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($grade_list)){?>
  <option  value="all">All</option>
  <?php foreach($grade_list as $row){
                        if(in_array($row["id"],explode(',',$survey[0]['grades'])))
                          {
                              $selected='selected';
                          }
                          else {
                              $selected='';
                          } 
                          ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div> 
        
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Level</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
             <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" required="required" multiple="multiple">
                   <?php 
if(!empty($level_list)){?>
  <option  value="all">All</option>
  <?php foreach($level_list as $row){
                         if(in_array($row["id"],explode(',',$survey[0]['levels'])))
                          {
                              $selected='selected';
                          }
                          else {
                              $selected='';
                          } 
                          ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>
         
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Education</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
               <select id="ddl_education" onchange="hide_list('ddl_education');" name="ddl_education[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($education_list)){?>
  <option  value="all">All</option>
  <?php foreach($education_list as $row){
                         if(in_array($row["id"],explode(',',$survey[0]['educations'])))
                          {
                              $selected='selected';
                          }
                          else {
                              $selected='';
                          } 
                          ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                     <?php } }else{ ?>
<option  value="0" selected=""  <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Critical Talent</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
              <select id="ddl_critical_talent" onchange="hide_list('ddl_critical_talent');" name="ddl_critical_talent[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <?php 
if(!empty($critical_talent_list)){?>
  <option  value="all">All</option>
  <?php foreach($critical_talent_list as $row){
                         if(in_array($row["id"],explode(',',$survey[0]['critical_talents'])))
                          {
                              $selected='selected';
                          }
                          else {
                              $selected='';
                          } 
                          ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?> ><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Critical Position</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
              <select id="ddl_critical_position" onchange="hide_list('ddl_critical_position');" name="ddl_critical_position[]" class="form-control multipleSelect" required="required" multiple="multiple">
                   <?php 
if(!empty($critical_position_list)){?>
  <option  value="all">All</option>
  <?php foreach($critical_position_list as $row){
                        if(in_array($row["id"],explode(',',$survey[0]['critical_positions'])))
                          {
                              $selected='selected';
                          }
                          else {
                              $selected='';
                          } 
                          ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                   <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>                    
                    
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Special Category</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
              <select id="ddl_cspecial_category" onchange="hide_list('ddl_cspecial_category');" name="ddl_special_category[]" class="form-control multipleSelect" required="required" multiple="multiple">
                   <?php 
if(!empty($special_category_list)){?>
  <option  value="all">All</option>
  <?php foreach($special_category_list as $row){
                        if(in_array($row["id"],explode(',',$survey[0]['special_category'])))
                          {
                              $selected='selected';
                          }
                          else {
                              $selected='';
                          } 
                          ?>
                    <option  value="<?php echo $row["id"]; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                    <?php } }else{ ?>
<option  value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                </select>
              </div>
           </div>  
        </div>      
                      
        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Tenure in the company</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
              <select id="ddl_tenure_company" onchange="hide_list('ddl_tenure_company');" name="ddl_tenure_company[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <option  value="all">All</option>
                    <?php for($i=0; $i<=35; $i++){
                        $selected='';
                        if(!empty($survey[0]['tenure_company'])) {
                          if(in_array($i,explode(',',$survey[0]['tenure_company'])))
                          {
                              $selected='selected';
                          }
                        } 
                          ?>
                    <option  value="<?php echo $i; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                    <?php } ?>
                </select>
              </div>
           </div>  
        </div> 

        <div class="form-group my-form attireBlock">
           <label class="col-sm-12 col-md-4 col-lg-4 col-xs-12 control-label removed_padding">Tenure in the Role</label>
           <div class="col-sm-12 col-md-8 col-lg-8 col-xs-12 removed_padding">
            <div class="">
             <select id="ddl_tenure_role" onchange="hide_list('ddl_tenure_role');" name="ddl_tenure_role[]" class="form-control multipleSelect" required="required" multiple="multiple">
                    <option  value="all">All</option>
                    <?php for($i=0; $i<=35; $i++){
                        $selected='';
                        if(!empty($survey[0]['tenure_roles'])) {
                         if(in_array($i,explode(',',$survey[0]['tenure_roles'])))
                          {
                              $selected='selected';
                          }
                        }
                          ?>
                    <option  value="<?php echo $i; ?>" <?php echo $selected;?> <?php echo $select_all; ?>><?php echo $i; ?></option>
                    <?php } ?>
                </select>
              </div>
           </div>  
        </div> 

        <div class="form-group my-form attireBlock">
          <label class="col-sm-4 col-xs-12 control-label removed_padding">Cutoff Date</label>
          <div class="col-sm-8 col-xs-12 removed_padding">
            <div class="">
              <!-- <input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($survey[0]["cutoff_date"]) and $survey[0]["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($survey[0]["cutoff_date"]));} ?>" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"> -->
              <input id="txt_cutoff_dt" name="txt_cutoff_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if(isset($survey[0]["cutoff_date"]) and $survey[0]["cutoff_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($survey[0]["cutoff_date"]));} ?>" autocomplete="off" onblur="checkDateFormat(this)">
            </div>
          </div>
        </div> 
    </div>
  </div>
  <div class="sub-btnn text-right">  
      <div class="sub-btnn text-right dv_next" <?php if($select_all != ""){}elseif(!isset($survey[0])){echo 'style="display:none;"';} ?>>
        <input style="    position: absolute;top: -44px;right: 0%;" type="submit" id="btnAdd" name="btn_next" value="Next" class="btn btn-primary" />
      </div>
      <div class="sub-btnn text-right dv_confirm_selection" <?php if(isset($survey[0]) or $select_all != ""){echo 'style="display:none;"';} ?>>
        <input style="position: absolute;top: -44px;right: 0%;"  type="submit" name="btn_confirm_selection" value="Confirm Selection" class="btn btn-primary" />
      </div>
    </div>

    <div class="sub-btnn text-right">  
      <div class="sub-btnn text-right dv_next" <?php if($select_all != ""){}elseif(!isset($survey[0])){echo 'style="display:none;"';} ?>>
        <input type="submit" id="btnAdd1" name="btn_next" value="Next" class="btn btn-primary" />
      </div>
      <div class="sub-btnn text-right dv_confirm_selection" <?php if(isset($survey[0]) or $select_all != ""){echo 'style="display:none;"';} ?>>
        <input type="submit" name="btn_confirm_selection" value="Confirm Selection" class="btn btn-primary" />
      </div>
    </div>
</form> 
</div>
</div>
</div>
</div>

<div class="tab-pane <?php echo ($pageName == 'setupsurvey')?'active':'';?>" role="tabpanel" id="step4">
<form class="form-horizontal mob_no_lbl_bg" method="post" action="<?php echo base_url('survey/publish/'.$survey_id.'/create');?>" id="form-4setup">
<div class="row">
<div class="col-sm-12">
<input style="margin-bottom:10px;" type="submit" name="update" value="Next" class="btn btn-primary pull-right" />
</div>
</div>
<?php echo HLP_get_crsf_field();?>
<div class="row">
<div class="col-sm-6">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Type</label>
       <div class="col-sm-8 col-xs-12 form-input removed_padding"> 
        <select class="form-control" id="survey_type" name="survey_type" require="true" <?php if($survey[0]['is_published'] != 0) { echo 'disabled'; } ?>>
            <option value="1" <?php if(@$survey[0]['survey_type'] == 1) {echo 'selected = "selected" ';} ?>>One Time</option>
            <option value="2" <?php if(@$survey[0]['survey_type'] == 2) {echo 'selected = "selected" ';} ?>>Periodic</option>
         </select>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Active Status</label>
        <div class="col-sm-8 col-xs-12 form-input removed_padding"> 
        <select class="form-control" name="is_active"  require="true" <?php if($survey[0]['is_published'] != 0) { echo 'disabled'; } ?>>
            <option value="1" <?php if(@$survey[0]['status'] == 1) {echo 'selected = "selected" ';} ?>>Active</option>
            <option value="2" <?php if(@$survey[0]['status'] == 2) {echo 'selected = "selected" ';} ?>>Inactive</option>
        </select>
        </div>
    </div>            
</div>
</div>

<div class="form-group extra_edit type_periodic"></div>
<div class="row type_periodic">
<div class="col-sm-6">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Frequency Dependent On</label>
       <div class="col-sm-8 col-xs-12 form-input removed_padding">  
        <select class="form-control opt_periodic" id="frequency_dependent_on" name="frequency_dependent_on" <?php if($survey[0]['is_published'] != 0) { echo 'disabled'; } ?>>
            <?php 
                if(@CV_FRQ_SURVEY_ARRAY) {
                    foreach(json_decode(CV_FRQ_SURVEY_ARRAY) as $key => $val) {
                        $sel = '';
                        if($key == $survey[0]['frequency_dependent_on']){
                            $sel = 'selected="selected"';
                        }
                        echo '<option '.$sel.' value="'.$key.'">'.$val.'</option>';
                    }
                }
            ?>
        </select>
      </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Frequency Days</label>
       <div class="col-sm-8 col-xs-12 form-input removed_padding">  
        <input type="number" class="form-control opt_periodic" id="frequency_days" name="frequency_days" onkeypress="return isNumber(event)" min="0" maxlength="2" <?php if($survey[0]['is_published'] != 0) { echo 'disabled'; } ?> value="<?php if($survey[0]['frequency_days'] > 0) { echo $survey[0]['frequency_days']; }?>" />
        </div>
    </div>            
</div>
</div>

<div class="form-group extra_edit"></div>
<div class="row">
<div class="col-sm-6">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Start Date</label>
       <div class="col-sm-8 col-xs-12 form-input removed_padding">  
        <input <?php if($survey[0]['is_published'] == 0) { echo 'id="start_dt"';} else{ echo 'disabled readonly="true"'; } ?> name="start_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if($survey[0]['start_date'] != '0000-00-00') echo date('d/m/Y',strtotime($survey[0]['start_date']));?>" autocomplete="off"  require="true"> 

        <!-- <input <?php if($survey[0]['is_published'] == 0) { echo 'id="start_dt"';} else{ echo 'disabled readonly="true"'; } ?> name="start_dt" type="text" class="form-control" required="required" maxlength="10" value="<?php if($survey[0]['start_date'] != '0000-00-00') echo date('d/m/Y',strtotime($survey[0]['start_date']));?>" autocomplete="off" onkeypress="return false;"  require="true"> -->
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group my-form">
        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile"> Open upto (number of days)</label>
       <div class="col-sm-8 col-xs-12 form-input removed_padding">  
        <input type="text" class="form-control" id="surevy_open_periods"  name="surevy_open_periods" onkeypress="return isNumber(event)" min="1" maxlength="3"  value="<?php if($survey[0]['surevy_open_periods'] > 0) { echo $survey[0]['surevy_open_periods']; } ?>" required />
        </div>
    </div>            
</div>
</div>

<div class="form-group extra_edit"></div>
<input type="hidden" name="is_published"  value="<?php echo ($survey[0]['is_published'] > 0)? $survey[0]['is_published']:0;?>">
<!-- <div class="row">
<div class="col-sm-6 left_div">
    <div class="form-group mar_bot">
        <label class="wht_lvl w_hit_col" for ="temptile"> Publishing Status</label>
        <select class="form-control" name="is_published" require="true">
            <?php if($survey[0]['is_published'] == 0) { ?><option value="0" <?php if(@$survey[0]['is_published'] == 0) {echo 'selected = "selected" ';} ?>><?= CV_SURVEY_PUBLISHED_TERMS_0 ?></option>
            <?php } ?>
            <option value="1" <?php if(@$survey[0]['is_published'] == CV_SURVEY_PUBLISHED_TRUE) {echo 'selected = "selected" ';} ?>><?= CV_SURVEY_PUBLISHED_TERMS_1 ?></option>
            <option value="2" <?php if(@$survey[0]['is_published'] == 2) {echo 'selected = "selected" ';} ?>><?= CV_SURVEY_PUBLISHED_TERMS_2 ?></option>
            <option value="3" <?php if(@$survey[0]['is_published'] == 3) {echo 'selected = "selected" ';} ?>><?= CV_SURVEY_PUBLISHED_TERMS_3 ?></option>
        </select>
    </div>
</div>
</div> 
<div class="form-group extra_edit"></div> -->
</form>
</div>

<div class="tab-pane <?php echo ($pageName == 'launchSurvey')?'active':'';?>" role="tabpanel" id="step5">
<div class="row">
<div class="col-sm-12">
<?php if(isset($survey[0]['is_published']) && $survey[0]['is_published'] != 3){ ?>
    <a style="margin-left:10px;margin-bottom:10px;" href="<?php echo base_url('survey/updatesurvey/'.$survey_id.'/1/launchComplete');?>" onclick="return stopTab1(this);" class="btn btn-primary pull-right">Launch</a>

    <a style="margin-bottom:10px;" href="<?php echo base_url('survey/dashboard-analytics');?>" onclick="return stopTab1(this);" class="btn btn-primary pull-right">Save</a>
<?php }?>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="panel pad_b_10">
    <div class="panel-group" id="accordion">                              
      <!-- // - Survey Panel -->
      <div class="panel panel-default" style="border: 1px solid #ddd !important;">
        <div class="panel-heading">
            <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand1 black" style="color:#4E5E6A !important;cursor: pointer;" >
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
                                <?php 
                                    $src = '';
                                    if(!empty($survey) && !empty($survey[0]['survey_img'])){
                                        $src = base_url($survey[0]['survey_img']);
                                    }else{
                                        $src = base_url('assets/dummy.png'); 
                                    }
                                ?>
                                  <img id="popimg" alt="No Image" height="298" src="<?php echo $src;?>">
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
                                           <?php echo count($questions); ?>
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
    </div>

    <div class="panel-group" id="accordion2">
      <!-- // - Question Panel -->
      <div class="panel panel-default" style="border: 1px solid #ddd !important;">
        <div class="panel-heading">
            <h4 data-toggle="collapse" data-parent="#accordion2" href="#collapse2" class="panel-title expand2 black" style="color:#4E5E6A !important;cursor: pointer;">
              <div class="right-arrow pull-right">-</div>
              <a href="#"> Questions</a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse in">  
          <div class="panel-body area">
            <div class="survey_details_view">
              <div class="questn">
                <?php if(isset($result) && !empty($result)){ 
                      foreach ($result as $key => $val) {
                        
                  ?>
                <div class="que_block">
                     <h4><?php echo ($key+1).' : '.$val['name'];?></h4>
                     <!-- <img alt="No Image" src="<?php echo HLP_Check_IMG(base_url('/').$val['img']);?>"> -->
                     <?php if(isset($val['aws']) && !empty($val['aws'])){ 
                          foreach ($val['aws'] as $k => $ansval) { ?>
                         <div class="checkbox">
                            <label style="cursor: default;">
                              <input type="radio" disabled="disabled" style="cursor: default;"> 
                              <span><?php echo $ansval['answer'];?></span>
                            <!-- <img alt="No Image" src="<?php echo HLP_Check_IMG(base_url('/').$ansval['ans_img']);?>"> -->
                            </label>
                          </div>
                      <?php } } ?>
                      <?php if(!empty($val['title'])) echo "<h4>".$val['title']."</h4>"; ?>
                </div>
                <?php } } else { echo "No Record Found.";}?>
              </div>
            </div>
          </div>   
        </div>
      </div>
    </div>

    <div class="panel-group" id="accordion3">
      <!-- // - filter Survey Panel -->
      <div class="panel panel-default" style="border: 1px solid #ddd !important;">
        <div class="panel-heading">
            <h4 data-toggle="collapse" data-parent="#accordion3" href="#collapse4" class="panel-title expand3 black" style="color:#4E5E6A !important;cursor: pointer;">
              <div class="right-arrow pull-right">-</div>
              <a href="#">Selected Participants </a>
            </h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse in">
          <div class="panel-body">
            <div class="survey_details_view">
              <div class="filter">
                <?php if($showfilter){ ?>
                <table class="table">
                  <tr>
                    <td class="col-md-3"><h5>Survey For :</h5></td>
                    <td><?php echo ucfirst($survey[0]['survey_for']);?></td>
                  </tr>
                  <tr>
                    <td><h5>Country :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_country", "name" , "id IN (".$survey[0]['country'].")");; ?> </td>
                  </tr>
                  <tr>
                    <td><h5>City :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_city", "name" , "id IN (".$survey[0]["city"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Business Level 1 :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_business_level_1", "name" , "id IN (".$survey[0]["business_level1"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Business Level 2 :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_business_level_2", "name" , "id IN (".$survey[0]["business_level2"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Business Level 3 :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_business_level_3", "name" , "id IN (".$survey[0]["business_level3"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Function :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_function", "name" , "id IN (".$survey[0]["functions"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Sub Function :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_subfunction", "name" , "id IN (".$survey[0]["sub_functions"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Designation :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_designation", "name" , "id IN (".$survey[0]["designations"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Grade :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_grade", "name" , "id IN (".$survey[0]["grades"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Level :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_level", "name" , "id IN (".$survey[0]["levels"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Education :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_education", "name" , "id IN (".$survey[0]["educations"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Critical Talent :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_critical_talent", "name" , "id IN (".$survey[0]["critical_talents"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Critical Position :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_critical_position", "name" , "id IN (".$survey[0]["critical_positions"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Special Category :</h5></td>
                    <td> <?php echo HLP_get_filter_names("manage_special_category", "name" , "id IN (".$survey[0]["special_category"].")"); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Tenure in the company :</h5></td>
                    <td> <?php echo str_replace(",",", ",$survey[0]['tenure_company']); ?> </td>
                  </tr>
                  <tr>
                    <td><h5>Tenure in the Role :</h5></td>
                    <td><?php echo str_replace(",",", ",$survey[0]['tenure_roles']); ?></td>
                  </tr>
                  <tr>
                      <td><h5>Cutoff Date :</h5></td>
                      <td><?php echo date('d/m/Y',strtotime($survey[0]['cutoff_date'])); ?></td>
                  </tr>
                </table>
                <?php }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<?php if(isset($survey[0]['is_published']) && $survey[0]['is_published'] != 3){ ?>
    <a style="margin-left:10px;margin-bottom:10px;" href="<?php echo base_url('survey/updatesurvey/'.$survey_id.'/1/launchComplete');?>" onclick="return stopTab1(this);" class="btn btn-primary pull-right">Launch</a>

    <a style="margin-bottom:10px;" href="<?php echo base_url('survey/dashboard-analytics');?>" onclick="return stopTab1(this);" class="btn btn-primary pull-right">Save</a>
<?php }?>
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
</div>
</section>
</div>
</div>
</div>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="mylaunchorsave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Please Select Your Action</h4>
</div>
<div class="modal-body">
<div class="action_view_btn text-center">
<button type="button" class="btn btn-primary">Save</button>
<button type="button" class="btn btn-primary">Save & launch</button>
</div>
</div>
</div>
</div>
</div> -->

<div style="height:250px;"></div>
<!-- Image popup -->
<div id="img_preview" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Preview</h4>
</div>
<div class="modal-body">
<img id="pop_image_preview" style="width: 100%;" />
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<style type="text/css">
/******new css start here********/
.newRow{position: relative; }
.newRow.pad0{padding: 0px;}
.newRow .det_dyn_btn{text-align:center; padding:3px 6px; position: absolute; right: 2px; top: 2px; background-color: #e8e8e8 !important; }
.newRow .det_dyn_btn.res{right: 17px;}
.newRow .det_dyn_btn:hover{background-color: red !important; }
.newRow .det_dyn_btn:hover i{color: #fff !important;}
.newRow .det_dyn_btn i{ color: #000; margin-left:0px;}

.oldRow{position: relative; }
.oldRow.pad0{padding: 0px;}
.oldRow .det_dyn_btn{text-align:center; padding:3px 6px; position: absolute; right: 2px; top: 2px; background-color: #e8e8e8 !important; }
.oldRow .det_dyn_btn.res{right: 17px;}
.oldRow .det_dyn_btn:hover{background-color: red !important; }
.oldRow .det_dyn_btn:hover i{color: #fff !important;}
.oldRow .det_dyn_btn i{ color: #000; margin-left:0px;}

.table tr td .fa-plus {
color: #ffffff !important;
}
.control-label.grey{background-color: #e8e8e8 !important;}

#statusbar .label{display: none !important;}
#mylaunchorsave.modal{
background-color: rgb(0, 0, 0, .8);}


.action_view_btn{display: block; width: 100%;}
.action_view_btn .btn{width: 150px;
padding: 9px 10px;
margin-left: 10px;}
.wizard {
margin: 0px auto;
/*background: #fff;*/
}

.wizard .nav-tabs {
position: relative;
margin: 0px auto;
margin-bottom: 0;
border-bottom-color: #e0e0e0;
}

.wizard > div.wizard-inner {
position: relative;
}

.connecting-line {
height: 2px;
background: #e0e0e0;
position: absolute;
width: 80%;
margin: 0 auto;
left: 0;
right: 0;
top: 36%;
z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
color: #555555;
cursor: default;
border: 0;
border-bottom-color: transparent;
}

span.round-tab {
width: 40px;
height: 40px;
line-height: 36px;
display: inline-block;
border-radius: 100px;
background: #fff;
border: 2px solid #afafaf;
background-color: #afafaf;
z-index: 2;
position: absolute;
left: 14px;
text-align: center;
font-size: 20px;
}
span.round-tab i{
font-size: 14px;  
color:#fff;
}

/*  .wizard li.active span.round-tab {
background: #31b0d5;
border: 3px solid #31b0d5;

}*/

/*  .wizard li.active span.round-tab i{
color: #576a7a;
} */

.wizard li.active span.round-tab i{
color: #fff;
}

/*span.round-tab:hover {
color: #576a7a;
border: 2px solid #576a7a;
}
*/
.wizard li span.round-tab:focus{background:transparent; }

.wizard .nav-tabs > li {
width: 20%;
}

.wizard .nav-tabs > li{text-align: center;}

.wizard .nav-tabs > li p{
margin-bottom: 20px;
font-size: 15px;
/*font-weight: bold;*/
background:transparent;
padding: 0px; 
color: #fff;
}


.wizard li:after {
content: " ";
position: absolute;
left: 46%;
opacity: 0;
margin: 0 auto;
bottom: 0px;
border: 5px solid transparent;
border-bottom-color: #fff;
transition: 0.1s ease-in-out;
}

.wizard li.active:after {
content: " ";
position: absolute;
left: 43%;
opacity: 1;
margin: 0 auto;
bottom: 1px;
border: 15px solid transparent;
border-bottom-color: #31b0d5;
}

.wizard .nav-tabs > li a {
width: 70px;
height: 27px;
margin: 16px auto;
border-radius: 100%;
padding: 0;
background-color:transparent !important;
border:0px; 
}

.wizard .nav-tabs > li a:hover {
background: transparent;
}

.wizard .tab-pane {
position: relative;
/*padding-top: 20px;*/
}

.wizard h3 {
margin-top: 0;
}

.tab-content{    background-color: #fff;

}


.wizard .form-horizontal .Editor-editor{color: #555; /*height: 200px !important;*/}

@media( max-width : 585px ) {

.wizard {
width: 90%;
height: auto !important;
}

span.round-tab {
font-size: 16px;
width: 50px;
height: 50px;
line-height: 50px;
}

.wizard .nav-tabs > li a {
width: 50px;
height: 50px;
line-height: 50px;
}

.wizard li.active:after {
content: " ";
position: absolute;
left: 35%;
}
}

/* Harshit*/
.wizard li.pre-active span.round-tab {
border: 3px solid #31b0d5;
background: #31b0d5;

}
.wizard li.pre-active span.round-tab i{
color: #fff;
}
.mt-10{
margin-top: 10px;
}
/******new css ends here********/

#txt_cutoff_dt{
margin-bottom: 0px;
}
.red{
color: red;
}

.footer {
margin: auto !important;
}

.form-horizontal .Editor-editor{color: #fff;}
/*.panel-body.area{padding:0px 20px 20px 20px; }*/
.form-control.sur_img_area{position: relative;}
#preview_img{width:30px; min-height: 31px; max-height: 31px; position: absolute; top:1%; right: -3%;}
.left_div{padding-right:2%;}
.right_div{padding-left:2%;}
/*.black{color: unset !important;}*/
.form-horizontal .form-control{margin-bottom: 0px;}

.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls {width:25.7em; }

.my-form{background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
<!--.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;--> <!--shumsul-->
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}

.fstResults{ position:relative !important;}

.form_head ul{ padding:0px; margin-bottom:0px;}

.form_head ul li{ display:inline-block;}

.form-group {
margin-bottom: 10px;
}
.control-label {
line-height:42px;
font-size: 11.25px;
<?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */?>
background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?> !important;
color: #000;
margin-bottom:10px;
}

.form_head {
background-color: #f2f2f2;
<?php /*?>border-top: 8px solid #93c301;<?php */?>
border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
}
.form_head .form_tittle {
display: block;
width: 100%;
}
.form_head .form_tittle h4 {
font-weight: bold;
color: #000;
text-transform: uppercase;
margin: 0;
padding: 12px 0px;
margin-left: 5px;
}
.form_head .form_info {
display: block;
width: 100%;
text-align: center;
}
.form_head .form_info i {
color: #8b8b8b;
font-size: 24px;
padding: 7px;
margin-top:-4px;
}   
.form_head .form_info .btn-default {
border: 0px;
padding: 0px;
background-color: transparent!important;
}
.form_head .form_info .tooltip {
border-radius: 6px !important;
}
.salary_rt_ftr .form_sec {
background-color: #f2f2f2;
margin-bottom: 0px;
display: block;
width: 100%;
padding:20px;
border-bottom-left-radius: 6px;
border-bottom-right-radius: 6px;
}
.head h4{ margin:0px;}
.padd{ padding:10px 20px 0px 20px !important; }

.panel-group{margin-bottom: 10px;}

.panel-body.area {
padding: 10px 30px 0px 30px;
}

.white, .black{color: unset !important;}

table.cust_p_p{}
table.cust_p_p thead th.nobor, table.cust_p_p tbody td.nobor{border-right:0px !important;}

.wizard li.active span.round-tab{background-color:#FF6600; border: 2px solid #FF6600; }
.wizard li.active:after{border-bottom-color: #FF6600 !important;}
.wizard li.pre-active span.round-tab{border: 3px solid #48BD00; background: #48BD00;}



</style>



<script>

var category_id = ("<?php echo $survey[0]['category_id']; ?>");
//alert( category_id);
reset_token();
function reset_token() {
$('#loading').show();
$.ajax({
url: '<?Php echo site_url('dashboard/get_crsf_field'); ?>',
type: 'GET',
success: function (res) {
console.log('========',res);
$('input[name=csrf_test_name]').val(res);
$("#loading").hide();
}
});
}

$( function() {
//console.log('test ',$('input[name=csrf_test_name]').val());
var availableTags = [];

$.ajax("<?php echo site_url("survey/getQuestion"); ?>", {
type: 'POST',  // http method
data: {'csrf_test_name':$('input[name=csrf_test_name]').val() },  // data to submit
async:false,
beforeSend: function(jqXHR, settings){

},
success: function (data, status, xhr) {
//console.log(data);
var obj = JSON.parse(data);
//console.log(obj);
for(var i=0;i<obj.length;i++){
availableTags.push(obj[i].QuestionName);
}

},
error: function (jqXhr, textStatus, errorMessage) {
console.log('error');

},complete:function(){

}
});

//return false;
reset_token();
if(category_id==1){
$( "#question_name" ).autocomplete({
source: availableTags,
autoSelectFirst:true
});
}

});


$(document).ready(function(){
$('#qustiontypeoption').on('change', function() {
$("#addMoreBtn,#addMoreQuestionBtn,#ranking,#matrix,#subQuestionOuterSection,#rankingSection,#scale,#rankingSection").hide();
$('#QuestionTitle').val('');
$('.both').hide(); 
$('.newRow').remove();
$('.ans_value').each(function(k,v){
$(this).val('');
});

// if ( this.value == '1' || this.value == '2' || this.value == '3' || this.value == '7')
// {
//     $('.subQuestion').each(function(k,v){
//         $(this).attr('required',false);
//     });
// }else{
//     $('.subQuestion').each(function(k,v){
//         $(this).attr('required',true);
//     });
// }
$('.r_response').attr('required',false);
$('.r_title').attr('required',false);
$('.r_subquestion').attr('required',false);
$('.r_upto').attr('required',false);
if ( this.value == '1'){
$('.r_response').attr('required',true);
$('.answers').show();
$("#addMoreBtn").show();
}else if ( this.value == '2'){
$('.r_title').attr('required',true);
$('.both').show();
$('.answers').hide(); 
}else if ( this.value == '3'){
$('.r_response').attr('required',true);
$('.r_title').attr('required',true);
$('.both, .answers').show(); 
$("#addMoreBtn").show();
}else if ( this.value == '4')
{

$('.r_subquestion').attr('required',true);
$('.r_upto').attr('required',true);
$("#addMoreQuestionBtn,#rankingSection").show();
$("#subQuestionOuterSection").show();
$('.answers').hide();
$('#addMoreBtn').hide();
}
else if ( this.value == '5')
{
$('.r_response').attr('required',true);
$('.r_subquestion').attr('required',true);
$("#addMoreBtn,#addMoreQuestionBtn,#subQuestionOuterSection").show();
$('.answers').show(); 
}
else if ( this.value == '6')
{
//$('.r_response').attr('required',true);
$('.r_upto').attr('required',true);
$('.r_subquestion').attr('required',true);
// var arr = [ "Dissatisfied", "Somewhat Satisfied" ,"Very Satisfied " ,"ExtremelySatisfied"]
// ratingDisable();
// ratingEnable();
$("#rankingSection,#addMoreQuestionBtn,#subQuestionOuterSection").show();

$('.answers').hide(); 
$('#addMoreBtn').hide();
}else if ( this.value == '7'){
$('.r_response').attr('required',true);
$("#addMoreQuestionBtn,#subQuestionOuterSection").hide();
$("#addMoreBtn").show();
$('.answers').show(); 
}

// $("#addMoreBtn,#addMoreQuestionBtn,#ranking,#matrix,#subQuestionOuterSection,#rankingSection,#scale,#rankingSection").show();
// $('.answers').show();

});
});

function remove(obj){
var optionId = $(obj).attr('rid');

$('#header'+optionId).remove();
$('#body'+optionId).remove();
$(obj).parent().parent().remove();
var id = 4;
$('.labelResponse').each(function(i,v){
id = (1+parseInt(i));
$(this).html('Response '+id);
});
var sub_id = 1;
$('.labelSubQues').each(function(i,v){
sub_id = (1+parseInt(i));
$(this).html('Sub Question '+sub_id);
});
$('#addMoreQuestionBtn').attr('rid',sub_id);
$('#addMoreBtn').attr('rid',id);
}
function addMore(obj){

var optionId = $(obj).attr('rid');

var nextOption = (parseInt(optionId)+1);
var option_value = "";
//alert(nextOption);

var html = '<div class="col-md-6 newRow animated fadeInDown">'
html += '<div class="form-group my-form">'
html += '<label class="labelResponse col-sm-4 col-xs-12 control-label grey removed_padding white black" for="QuestionName" rid="'+nextOption+'"> Response '+nextOption+'</label>';
html += '<div class="col-sm-8 col-xs-12 form-input removed_padding">';
html += '<input required="true" rid="'+nextOption+'" type="text" id="survey_name'+nextOption+'" name="answer[]" value="'+option_value+'" placeholder="Enter options" class="form-control answare" maxlength="1000">';
html += '</div>'; 
html +='<button type="button" rid="'+nextOption+'" onclick="remove(this)" class="btn res det_dyn_btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
html += '</div>';
html += '</div>';
$(obj).attr('rid',nextOption);
$('#optionSection').append(html);
}

function addMoreQuestion(obj){
//alert();
var optionId = $(obj).attr('rid');
var nextOption = (parseInt(optionId)+1);
var option_value = "";

var html ='<div class="col-md-12 newRow pad0 animated fadeInDown">';
html +='<div class="form-group my-form">';
html +='<label class="labelSubQues col-sm-2 col-xs-12 control-label grey removed_padding"  for ="temptile" > Sub Question '+nextOption+'</label>';
html +='<div class="col-sm-10 col-xs-12 form-input removed_padding">';
html +='<input type="text" id="subQuestion" name="subQuestion[]" placeholder="Enter Sub Question" class="form-control"/>';
html +='</div>';
html +='<button type="button" rid="'+nextOption+'" onclick="remove(this)" class="btn det_dyn_btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
html +='</div>';
html +='</div>';
$(obj).attr('rid',nextOption);
$('#subQuestionSection').append(html);
}

//frequency_dependent_on
$(document).ready(function(){
$( "#txt_cutoff_dt" ).datepicker({ 
dateFormat: 'dd/mm/yy',
changeMonth : true,
changeYear : true,
});

var sry_type = '<?php echo $survey[0]['survey_type']; ?>';
if(sry_type == '<?php echo CV_SURVEY_TYPE_PERIODIC;?>'){
$('.type_periodic').css('display','block');
$('.opt_periodic').attr('required',true);
} else{
$('.type_periodic').css('display','none');
$('.opt_periodic').removeAttr('required');
}

$( "#start_dt" ).datepicker({ 
dateFormat: 'dd/mm/yy',
changeMonth : true,
changeYear : true,
minDate: 0
// yearRange: "1995:new Date().getFullYear()",
}); 

$('#survey_type').change(function(){
var type = this.value;
if(type == '<?php echo CV_SURVEY_TYPE_PERIODIC;?>') {
$('.type_periodic').css('display','block');
$('.opt_periodic').attr('required',true);
} else {
$('.type_periodic').css('display','none');
$('.opt_periodic').removeAttr('required');
}
});

$('#surevy_open_periods').change(function(){
var sop = $(this).val();
if(sop == 0) {
$(this).val('');
} else {
var survey_status = '<?php echo $survey[0]['is_published'];?>';
if(survey_status) {
var start_date = '<?php echo $survey[0]['start_date'];?>'.split("-");
var f = new Date(start_date[1] + '/' + start_date[2]+'/'+start_date[0]);
var days = '<?php echo $survey[0]['surevy_open_periods'];?>';
var curdate = new Date();
var set_new_days = addDays(f,sop);
if (curdate >= set_new_days) {
$(this).val('');
}
}
}
});

$('#frequency_days').change(function(){
var sop = $(this).val();
if(sop == 0) {
$(this).val('');
}
});

});

function addDays(startDate, numberOfDays) {
return new Date(startDate.getTime() + (numberOfDays * 24 *60 * 60 * 1000));
}

function isNumber(evt,val) {
var days_gt = "<?php echo $checkdays; ?>";
evt = (evt) ? evt : window.event;
var charCode = (evt.which) ? evt.which : evt.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57)) {
return false;
}
if(parseInt(days_gt) > parseInt(val)){
return false;
}
return true;
}


$(function(){
$("#survey_image").change(function() {
readURL(this);
});

$('#preview_img').click(function(){
$('#pop_image_preview').attr('src',$(this).attr('src'));
$('#img_preview').modal('show');
});
});

function readURL(input) {
var fileTypes = ['jpg', 'jpeg', 'png', 'gif']; 
if (input.files && input.files[0]) {

var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
isSuccess = fileTypes.indexOf(extension) > -1;

if (isSuccess) { //yes
var reader = new FileReader();
reader.onload = function (e) {
$('#preview_img').attr('src', e.target.result);
}

reader.readAsDataURL(input.files[0]);
}
else { 
$("#survey_image").val('');
$('#preview_img').attr('src', '');
custom_alert_popup('Please select valid file type.');
}    
}
}

$('.multipleSelect').fastselect();
$(document).ready(function(){
var classcheck = $('.fstControls .fstQueryInput').hasClass('fstQueryInputExpanded');
if(classcheck) {
$('.fstControls .fstQueryInput').attr('required',true);
}

$('.fstControls .fstQueryInput').change(function(){
var check_class = $(this).hasClass('fstQueryInputExpanded');
if(!check_class) {
$(this).removeAttr('required',true);
}
}); 
});


function hide_list(obj_id)
{
$(".dv_next").hide();
$(".dv_confirm_selection").show();

$('#'+ obj_id +' :selected').each(function(i, selected)
{
if($(selected).val()=='all')
{
$('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
{
//if($(this).attr("data-value")!= 'all')
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

function chkType(val)
{
// console.log(val);
// if(val == 3) {
//     $('.both, .answers').show(); 
//     $('.req_two, .req_both').attr('required',true);
// } else if(val==5) {
//     //$('.answers, .both').hide();
// }else if(val==1) {
//     $('.req_two').attr('required',true);
//     $('.answers').show();
//     $('.req_both').removeAttr('required');
//     $('.both').hide(); 
// } else {
//     $('.req_two, .req_both').removeAttr('required');

// }
//alert();
}
$(document).ready(function(){
$('.inp_ans').blur(function(){
let slen = this.value.trim();
if(slen.length == 0){
$(this).val('');
}
});
$('#survey_name').blur(function(){
let slen = this.value.trim();
if(slen.length == 0){
$(this).val('');
}
});
$('#preview_img').click(function(){
$('#pop_image_preview').attr('src',$(this).attr('src'));
$('#img_preview').modal('show');
});

$('.aws_img_pre').click(function(){
$('#pop_image_preview').attr('src',$(this).attr('src'));
$('#img_preview').modal('show'); 
});
});

$(function(){
$("#question_image").change(function() {
readURL(this);
});

$('.img_aws').change(function(){
readAwsURL(this);
});
});

function readAwsURL(input) {
var str = input.id;
var imgid = str.split("_");
var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];

if (input.files && input.files[0]) {
var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
isSuccess = fileTypes.indexOf(extension) > -1;

if (isSuccess) { //yes
var reader = new FileReader();
reader.onload = function (e) {
var ans_preview = '#ansimg_pre' + imgid[1];
if($(ans_preview).length){
$(ans_preview).attr('src', e.target.result);
}else{
$(input).after('<img width="30" height="31" src="'+e.target.result+'" id="ansimg_pre'+ imgid[1] +'" class="aws_img_pre"  />');
}
}

reader.readAsDataURL(input.files[0]);
}
else { 
$("#"+str).val('');
$(ans_preview).attr('src', '');
custom_alert_popup('Please select valid file type.');
}
}

};

function readURL(input) {
var fileTypes = ['jpg', 'jpeg', 'png', 'gif']; 
if (input.files && input.files[0]) {

var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
isSuccess = fileTypes.indexOf(extension) > -1;

if (isSuccess) { //yes
var reader = new FileReader();
reader.onload = function (e) {
if($('#preview_img').length){
$('#preview_img').attr('src', e.target.result);
}else{
$(input).after('<img width="30" height="31" src="'+e.target.result+'" id="preview_img" />');
}
}

reader.readAsDataURL(input.files[0]);
}
else { 
$("#question_image").val('');
$('#preview_img').attr('src', '');
custom_alert_popup('Please select valid file type.');
}

}
}

function changeURL(url){
window.location.replace(url);
}


<?php if(count($questions) > 0 and $question[0]['QuestionName'] !=''){ ?>
setTimeout(show_q_edit_frm, 100);
function show_q_edit_frm()
{
//alert();
var q_id = '<?php echo $questionID; ?>'
$("#td_q_row_"+ q_id).html($("#QuestionForm").html());
$("#tr_q_row_"+ q_id).show();
$("#QuestionForm").html('');
$("#QuestionForm").hide();
}
<?php }if(count($questions) <= 0){ ?>
setTimeout(show_q_create_frm, 100);
function show_q_create_frm()
{
$("#QuestionForm").removeClass("hide");
}    
<?php } ?>
</script>

<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script type="text/javascript">
if("<?= $this->uri->segment(2); ?>" != 'questions_edit'){
$('tbody').sortable();
}
</script>
<style type="text/css">
.ui-sortable-handle.ui-sortable-helper{ width: 100%; background-color: #c9c6c6;}
.ui-sortable-handle.ui-sortable-helper td{background-color: #c9c6c6 !important; display: table-cell !important; border: 0px;}   
.ui-sortable-handle.ui-sortable-helper td:nth-child(1){min-width: 900px !important;}
/*.ui-sortable-handle.ui-sortable-helper td:nth-child(2){min-width: 100px !important;}*/
.ui-sortable-handle.ui-sortable-helper td:nth-child(3){text-align:center !important; min-width: 100px !important;}
</style>





