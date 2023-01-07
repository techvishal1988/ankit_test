<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
<style type="text/css">
  .table tr td span {
    color: #4E5E6A !important;
     font-size: 12px !important;
}

.penal_tittlep {
  background-color: #D8D9FC !important;
}
.variableList
{
  list-style: none;
  font-size: 14px;
  padding-left: 10px; padding-top: 15px;
  padding-bottom: 10px;
}
.variableList li
{
  padding-top: 2px;
}


.my-form{background: none; margin-bottom: 0px !important;}
.Editor-editor{height: 200px; background-color: #fff !important;}
</style>
<script type="text/javascript">
    var $currentform = "1basicsurvey";
    $(document).ready( function() {
         $("#description").Editor();    
        $('#description').Editor('setText','<?php echo str_replace("'","\'",$templates->email_body); ?>');

       
        $('form.survey').submit(function() {
            var data1 = $('#contentarea').text().trim();
            if(data1.length == 0) {
                $('#contentarea').html('');
                custom_alert_popup('Please enter template body to be sent to email');
                $('#loading').css('z-index','0').css('opacity','0.0 !important');
                return false;
            } else {
                var data=$('#contentarea').html();
                $('#body').val(data);
                return true;    
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

      
        
        $( '.wizard .nav-tabs li.active' ).next().removeClass('disabled');

       
        
     
    }); 
    //Wizard
   /* function stopTab(ths){
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
    }  */

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
        <li><a href="<?= base_url('dashboard');?>">Dashboard</a></li>
        <li class="active"> Template</li>
    </ol>
</div>

<div id="main-wrapper" class="container" style="padding: 0px;">
  <div class="row">
    
    <div class="col-md-3">
  <div class="panel panel-white" style="padding-bottom: 1px;">
    <div><label style="width:100%;" class="control-label">Available Variable</label></div>
    <div class="panel-white" style="background: #fff;">
      <ul class="variableList" style="">
        <li>
          {{employee_first_name}}
        </li>
        <li>
          {{approvers_first_name}}
        </li>
        <li>{{reciver_name}}</li>
        <li>{{manager_name}}</li>
        <li>{{plan_name}}</li>
        <li>{{bonus_rule_name}}</li>
        <li>{{rule_name}}</li>
        <li>{{lti_rule_name}}</li>
        <li>{{rnr_rule_name}}</li>
        <li>{{rnr_rule_name}}</li>
        <li>{{email_id_reciver}}</li>
        <li>{{password}}</li>
        <li>{{url}}</li>
      </ul>
    </div>
   </div>             
    </div>
    <div class="col-md-9">
      <div class="panel panel-white pad_b_10">
      <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
       
         <form class="form-horizontal survey frm_cstm_popup_cls_default" method="post" action="<?php echo base_url('survey/create');?>" enctype="multipart/form-data" id="form-1basicsurvey" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                            <?php echo HLP_get_crsf_field();?>
                            <input type="hidden" name="template_id" value="<?php echo $template_id ?>" />
                             <div class="row">
                                <div class="col-sm-12">
                                    <?php if($template_id !=''){ ?>
                                     <a style="margin-bottom: 10px;" class="btn btn-primary pull-right" href="<?= site_url('dashboard/emailTemplate');?>">New Template</a>
                                   <?php } ?>
                                   
                                </div>
                            </div>
                            <div class="row">
                              
                                 <div class="col-sm-12 ">
                                    <div class="form-group my-form">
                                        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile">Trigger Point</label>
                                        
                                      <div class="col-sm-8 col-xs-12 form-input removed_padding">
                                      <select name="trigger_point" id="trigger_point" class="form-control" required="true">
                                        <option value="">Select</option>
                                        <?php foreach ($triggerPoints as $row) { ?>
                                         <option value="<?=$row->target_point_id?>" <?=($row->target_point_id==$templates->target_point_id) ?'selected' : ''?>><?=$row->target_display_name?></option>
                                        <?php } ?>
                                      </select>  
                                        
                                      </div>  
                                    </div>
                                </div>

                                <div class="col-sm-12 ">
                                    <div class="form-group my-form">
                                        <label class="col-sm-4 col-xs-12 control-label removed_padding" for ="temptile">Subject</label>
                                        
                                      <div class="col-sm-8 col-xs-12 form-input removed_padding">  
                                        <input required="true" onkeypress="return hasWhiteSpace(this,this.value);" type="text" id="subject" name="subject" value="<?php echo @$templates->email_subject ?>" placeholder="Enter Subject"  class="form-control" maxlength="500"/>
                                      </div>  
                                    </div>
                                </div>

                          
                             

                                <div class="col-sm-12 mt-10">
                                   <span style="width:100%; font-weight: bold; font-size: 13px !important; letter-spacing: .5px; margin-bottom: 10px;" class="control-label" for ="description"> Body</span>
                                    <textarea style="height:100px !important;" rows="3"  class="form-control wht_lvl " id="description" placeholder="Email Content"></textarea>
                                    <input  type="hidden" name="body" id="body"/>
                                </div>

                               
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php if($template_id!=''){ $txt = 'Update';}else{ $txt = 'Save'; } ?>
                                    <input style="margin-top:10px;" type="submit" class="btn btn-primary pull-right" name="template" value="<?=  $txt; ?>"/>
                                </div>
                            </div>
                        </form>
      </div>
    </div>

    <div class="col-md-12">
    <div class="panel panel-white pad_b_10">
      <table class="table border" id="" style="width: 100%">
        <thead>
          <tr>
            <th>Trigger Point</th>
            <th>Subject</th>
            <th>Body</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="ui-sortable">
          <?php foreach ($template_list as $key => $template) { ?>
            <tr class="ui-sortable-handle">
              <td class="nobor"><?= $template->target_display_name; ?></td>
              <td class="nobor">
               <?= $template->email_subject; ?>
              </td>
              <td class="nobor"><?=$template->email_body?></td>

              <td style="width:80px; text-align: center;">
                <a href="<?php echo base_url('dashboard/emailTemplate/'.$template->id); ?>" title="Edit"><i class="fa fa-eye"></i></a>
                <a href="<?php echo base_url('dashboard/templateDelete/'.$template->id); ?>"><i class="fa fa-trash" title="Delete" onclick="return confirm('Are You Sure?')"></i></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div>

<br/>
<br/>
<br/>
<br/>



<script>
// $(".variableList li").click( function (){
//   console.log(this.innerText);
//   var txt=this.innerText;
  

// });
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
</script>


