<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
    <div class="col-md-8">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('survey');?>">Survey</a></li>
            <li class="active">Ready to launch survey</li>
        </ol>
    </div>
      <div class="col-md-4 text-right">
      </div>
     </div>
    </div>
</div>

<div id="main-wrapper" class="container">
  <div class="survey_toggle_panel">
    <div class="row">
      <div class="col-sm-12">
      <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} 
        if(isset($adminCategory)&& !empty($adminCategory)){ ?>
        <div class="survey_penal">
          <ul>
          <?php  foreach ($adminCategory as $key => $catg) { $islist = true; ?>
            <li>
              <div class="survey_nam_img">
              <div class="sur_icon">
               <img width="50" height="54" src="<?php echo base_url($catg["img_path"]); ?>" alt="">
              </div>  
              <h4><?php echo $catg['name']; ?></h4>
              </div>
              <div class="sur_nam_drop clearfix" onclick="surveyslide('<?php echo $key; ?>')">
                <h5>Select Survey</h5>
                <i class="read_more fa fa-angle-down"></i>
              </div>
              <div class="sur_nam_info sur_info<?php echo $key; ?>" style="display:none;">
                <div class="info">
                  <div class="sur_nam">
                  <?php if(isset($survey)&& !empty($survey)) { 
                            foreach ($survey as $k => $srvy) {
                              if($srvy['category_id'] == $catg['id']){
                                $islist = false;
                          ?>
                   <a onclick="copy_admin_survey('<?php echo ucfirst($srvy['survey_id']);?>')"><h5><?php echo ucfirst($srvy['survey_name']);?><span> <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-original-title="<?= $srvy['tooltip_desc_msg'] ?>"></span></span></h5></a>
                   <?php  } } } 
                        if($islist) { echo '<div class=" col-md-12"><div style="margin-bottom: 0;margin-top: 5px;" class="alert alert-danger"><strong></strong> '. $this->lang->line('msg_no_record_found').'</div></div>'; } ?>
                  </div>
                </div>
                
              </div>
            </li>
          <?php } ?>

          </ul>
        </div>
        <?php } else {
                echo '<div class="alert alert-info">
                          <strong>Info! </strong> '. $this->lang->line('msg_no_record_found').'
                        </div>';
          } ?>
      </div>
    </div>
  </div>  
</div>
<!-- <div style="height:136px;"></div> -->



 <script type="text/javascript">


     //***add by pramod****//
   function surveyslide(a)
   {
      $(".sur_info"+a).slideToggle("slow");
   }

    var csrf_token_val = '<?php echo $this->security->get_csrf_hash()?>';
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

    function copy_admin_survey(surveyId) {
        $check = true;
        if($check) {
         $('#loading').show();
          $.ajax({
              url: '<?Php echo site_url('survey/copy-admin-exists-survey');?>',
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



<?php /*
<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-12">
       <div class="mailbox-content pad_b_10">
         <div class="exist_survey">
            <div class="row">
              <div class="col-sm-12">
                <div class="fecting_sur_tab">
                  <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><span class="cusm-lable">Master Surveys</span>
                          <select class="form-control cusm-contl" id="admin_existing_survey" onchange="find_survey(this.value)">
                          <option value="">Select Category</option>
                          <?php 
                              if(!empty($adminCategory)) {
                                  foreach($adminCategory as $cat) {
                                      echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                  }
                              }
                          ?>
                          </select>
                        </a></li>
                      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><span class="cusm-lable">Existing Surveys</span>
                          <select class="form-control cusm-contl" id="company_existing_survey" onchange="find_comp_survey(this.value)">
                            <option value="">Select Category</option>
                            <?php 
                                if(!empty($comp_category)) {
                                    foreach($comp_category as $cat) {
                                        echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                    }
                                }
                            ?>                            
                          </select>
                      </a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="survey_cards">
                          <div class="row" id="content_admin_category">
                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Info!</strong> Please select the option to view records.
                              </div>
                          </div>
                        </div> 
                      </div>
                      <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="survey_cards">
                          <div class="row" id="content_company_category">
                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Info!</strong> Please select the option to view records.
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
    <div class="col-md-12">
      <div class="panel panel-white pad_b_10" >
        <div class="panel-group" id="accordion" style="margin-bottom:0px;">
          <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
          <?php if(isset($adminCategory)&& !empty($adminCategory)){
              foreach ($adminCategory as $key => $catg) { $islist = true;
          ?>
              <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>" class="panel-title expand black" style="color:#4E5E6A !important;cursor: pointer;" >
                      <div class="right-arrow pull-right">+</div>
                      <a><?php echo $catg['name']; ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo $key;?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="survey_cards">
                          <div class="row">
                           <!-- <div class="col-sm-4">
                              <div class="cardss">
                                <div class="sur_crd"">
                                 <h4>Employee life cycle test </h4>
                                 <h5>No of question's : <span>50</span></h5>
                                 <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                 <div class="hide_wall"></div>
                                  <div class="perfom_action">
                                  <button class="btn btn-primary">Select</button>
                                  </div>
                                 </div>
                                </div>
                            </div> -->
                          <?php if(isset($survey)&& !empty($survey)) { 
                            foreach ($survey as $k => $srvy) {
                              if($srvy['category_id'] == $catg['id']){
                                $islist = false;
                          ?>
                              <div class="col-sm-4">
                                <div class="cardss">
                                  <div class="sur_crd"">
                                    <!-- <a href="<?php //echo base_url('survey/create/').$srvy['survey_id'].'/1';?>"> -->
                                    <!-- <a onclick="copy_admin_survey('<?php echo ucfirst($srvy['survey_id']);?>')"> -->
                                      <h4><?php echo ucfirst($srvy['survey_name']);?></h4>
                                      <h5>No of question's : <span><?php echo ucfirst($srvy['que_count']);?></span></h5>
                                      <p> <?php echo $srvy['description'];?></p>
                                      <div class="hide_wall"></div>
                                      <div class="perfom_action">
                                        <button onclick="copy_admin_survey('<?php echo ucfirst($srvy['survey_id']);?>')" class="btn btn-primary">Select</button>
                                      </div>
                                    <!-- </a> -->
                                  </div>
                                </div>
                              </div>
                          <?php
                              }
                            } } 
                            if($islist) { echo '<div class=" col-md-12"><div class="alert alert-danger"><strong></strong> '. $this->lang->line('msg_no_record_found').'</div></div>'; } ?>
                            
                          </div>
                        </div>
                    </div>
                </div>
              </div>  

          <?php
              } 
          } else {
                echo '<div class="alert alert-info">
                          <strong>Info! </strong> '. $this->lang->line('msg_no_record_found').'
                        </div>';
          } ?>

        </div> 
      </div>
    </div>
  </div>
        </div>
    </div>
</div>
</div>
 



<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="sur_card_details" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <form class="form-horizontal" method="post" action=""> 
            
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Survey Details</h4>
          <input type="hidden" id="mdpid" name="product_id">
        </div>
        <div class="modal-body">
          <div class="survey_details">
            <div class="row">
              <div class="col-sm-12">
               <div class="sur_info">
                <div id="sur_model">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#overview" aria-controls="home" role="tab" data-toggle="tab"> Overview</a></li>
                    <li role="presentation"><a href="#questions" aria-controls="profile" role="tab" data-toggle="tab">Questions</a></li>
                    <!-- <li role="presentation"><a href="#results" aria-controls="messages" role="tab" data-toggle="tab">Results</a></li> -->
                   
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="overview">
                      <div class="overview">
                          <div class="view_img">
                            <img id="popimg" alt="No Image">
                          </div>
                          <div class="view_info">
                              <p id="popupdesc"> </p>
                              <div class="stat">
                                <h5>No. of Questions</h5>
                                <h4 id="questionnumber"></h4>
                              </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="questions">
                      <div class="questn" id="show_question">
                          
                      </div>
                    </div>
                  </div>
                </div>
               </div>
              </div> 
            </div>
          </div>
        </div>
        <div class="modal-footer" id="create_new_copy">
          <!-- <button type="submit" class="btn btn-primary">Use This Survey</button> -->
          <a href="javascript:void(0)" class="btn btn-primary">Use This Survey</a>
        </div>
        </form>
      </div>
      
    </div>
</div>

<script>
  var basepath = '<?Php echo base_url();?>';
  var adminbasepath = '<?php echo CV_PLATFORM_COMPANY_BASE_URL;?>';
  var survey_data = '';
  var csrf_token_val = '<?php echo $this->security->get_csrf_hash()?>';
  function find_survey(catid) {
    $('#company_existing_survey option[value=""]').attr("selected",true);
    if(catid.length > 0) {
        $('#loading').show();
        $('#content_admin_category').empty();
        $.ajax({
            url: '<?Php echo site_url('survey/get-category-survey');?>',
            type: 'POST',
            data: { category_id: catid, csrf_test_name: csrf_token_val}
        }).done(function(res){
            var response = JSON.parse(res);
            var bcontent = '';
            if(response.length > 0) {
              survey_data = res;
              $.each(response,function(index,key){
                bcontent += `<div class="col-sm-3">
                                <div class="sur_crd" onclick="set_copy_admin_link(`+key.survey_id+`)">
                                  <h5>`+capitalizeFirstLetter(key.survey_name)+` [ `+key.que_count+` ]</h5>
                                  <p> `+key.description+`</p>
                                  <div class="hide_wall"></div>
                                </div>
                              
                              </div>`;
                // <p> `+truncate(key.description, 100)+`</p>              
              });
              $('#content_admin_category').html(bcontent);
            } else {
              $('#content_admin_category').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong></strong> No survey found.</div>');
            }
            $('#loading').hide();
            reset_token();
        });
    } else {
      $('#content_admin_category').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Info!</strong> Please select the option to view records.</div>');
    }
  }
    
    function copy_admin_survey(surveyId) {
      $check = request_confirm();
      if($check) {
        $('#loading').show();
        $.ajax({
            url: '<?Php echo site_url('survey/copy-admin-exists-survey');?>',
            type: 'POST',
            data: { surveyid: surveyId, csrf_test_name: csrf_token_val}
        }).done(function(res){
            alert(res);
            $('#loading').hide();
            $('#sur_card_details').modal('hide');
            reset_token();
        });
      }
    }

    function set_copy_admin_link(surveyid) {
      $.each(JSON.parse(survey_data), function(index, key){
        if(surveyid == key.survey_id){
          $('#popupdesc').text('');
          $('#popupdesc').text(key.description);
          var image = new Image();
          image.src = adminbasepath+key.survey_img;
          image.onload = function() {
              $('#popimg').attr('src',adminbasepath+key.survey_img);
          }
          image.onerror = function() {
              $('#popimg').attr('src',basepath+'assets/img/no_photo.jpg');
          }
        }
      });
      $('#create_new_copy').empty();
      $('#create_new_copy').html(`<a href="javascript:void(0)" class="btn btn-primary" onclick="copy_admin_survey(`+surveyid+`)">Use This Survey</a>`);
      show_admin_survey_question(surveyid);
    }

    function show_admin_survey_question(surveyId) {
      $('#loading').show();
      $.ajax({
          url: '<?Php echo site_url('survey/show-admin-survey');?>',
          type: 'POST',
          data: { surveyid: surveyId, csrf_test_name: csrf_token_val}
      }).done(function(res){
        if(res.length > 0) {
          var question = 0;
          var response = JSON.parse(res);
          console.log(response);
          var question_list = ``;
          $.each(response,function(index,key){
            question++;
            question_list += `<div class="que_block">`;  
            question_list += `<h4>`+question+`: `+capitalizeFirstLetter(key.name)+`</h4>`;
            var question_obj = key.aws;
            $.each(question_obj,function(index,awskey){
              question_list += `<div class="checkbox">
                                  <label style="cursor: default;">
                                    <input type="radio" disabled="disabled" style="cursor: default;"> <span>`+awskey.answer+`</span>
                                  </label>
                                </div>`;
            });
            if(key.title!=null)
            question_list += `<h5>`+capitalizeFirstLetter(key.title)+`</h5>`;
            question_list += `</div>`;
          });
          $('#show_question').empty();
          $('#show_question').html(question_list);
          $('#questionnumber').text(question);
          $('#sur_card_details').modal('show');
        }
        $('#loading').hide();
        reset_token();
      });
    }

    //---------------------------------------------------------------------
    var comp_survey_data = '';
    
    function find_comp_survey(catid) {
      $('#admin_existing_survey option[value=""]').attr("selected",true);  
        if(catid.length > 0) {
            $('#loading').show();
            $('#content_company_category').empty();
            $.ajax({
                url: '<?Php echo site_url('survey/get-exists-category-survey');?>',
                type: 'POST',
                data: { category_id: catid, csrf_test_name: csrf_token_val}
            }).done(function(res){
                var response = JSON.parse(res);
                var bcontent = '';
                if(response.length > 0) {
                    comp_survey_data = res;
                    $.each(response,function(index,key){
                      if(key.que_count > 0) {
                        bcontent += `<div class="col-sm-3" onclick="set_copy_company_link(`+key.survey_id+`)">
                                      <div class="sur_crd">
                                        <h5>`+capitalizeFirstLetter(key.survey_name)+` [ `+key.que_count+` ]</h5>
                                        <p> `+key.description+`</p>
                                        <div class="hide_wall"></div>
                                      </div>
                                      
                                    </div>`;
                      }
                    });
                    $('#content_company_category').html(bcontent);
                } else {
                    $('#content_company_category').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong></strong> No survey found.</div>');
                }
                $('#loading').hide();
                reset_token();
            });
            
        } else {
          $('#content_company_category').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Info!</strong> Please select the option to view records.</div>');
        }
    }

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

    function copy_company_survey(surveyId) {
      $check = request_confirm();
      if($check) {
        $('#loading').show();
        $.ajax({
            url: '<?Php echo site_url('survey/copy-company-exists-survey');?>',
            type: 'POST',
            data: { surveyid: surveyId, csrf_test_name: csrf_token_val}
        }).done(function(res){
            alert(res);
            $('#loading').hide();
            $('#sur_card_details').modal('hide');
            reset_token();
        });
      }
    }

    function set_copy_company_link(surveyid) {
      $.each(JSON.parse(comp_survey_data), function(index, key){
        if(surveyid == key.survey_id){
          $('#popupdesc').empty();
          $('#popupdesc').html(key.description);
          // $('#popimg').attr('src',basepath+key.survey_img);
          var image = new Image();
          image.src = basepath+key.survey_img;
          image.onload = function() {
              $('#popimg').attr('src',basepath+key.survey_img);
          }
          image.onerror = function() {
              $('#popimg').attr('src',basepath+'assets/img/no_photo.jpg');
          }
        }
      });
      $('#create_new_copy').empty();
      $('#create_new_copy').html(`<a href="javascript:void(0)" class="btn btn-primary" onclick="copy_company_survey(`+surveyid+`)">Use This Survey</a>`);
      show_comp_survey_question(surveyid);
      $('#sur_card_details').modal('toggle');
    }

    function show_comp_survey_question(surveyId) {
        $('#loading').show();
        $.ajax({
            url: '<?Php echo site_url('survey/show-company-survey');?>',
            type: 'POST',
            data: { surveyid: surveyId, csrf_test_name: csrf_token_val}
        }).done(function(res){
          if(res.length > 0) {
          var question = 0;
          var response = JSON.parse(res);
          var question_list = ``;
          $.each(response,function(index,key){
            question++;
            question_list += `<div class="que_block">`;  
            question_list += `<h4>`+question+`: `+capitalizeFirstLetter(key.name)+`</h4>`;
            var question_obj = key.aws;
            $.each(question_obj,function(index,awskey){
              var aws = awskey.answer;
              if(aws.length > 0)
              question_list += `<div class="checkbox">
                                  <label style="cursor: default;">
                                    <input type="radio" disabled="disabled" style="cursor: default;"> <span>`+awskey.answer+`</span>
                                  </label>
                                </div>`;
            });
            if(key.title!=null)
            question_list += `<h5>`+capitalizeFirstLetter(key.title)+`</h5>`;
            question_list += `</div>`;
          });
          $('#show_question').empty();
          $('#show_question').html(question_list);
          $('#questionnumber').text(question);
          $('#sur_card_details').modal('show');
        }
        $('#loading').hide();
        reset_token();
        });
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function truncate(source, size) {
      return source.length > size ? source.slice(0, size - 1) + "…" : source;
    }

    $(function(){

    });
</script>
*/ ?>
