<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css'); ?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
  #main-wrapper{min-height: 64vh;}
  .plft0 {
    padding-left: 0px;
  }

  .prit0 {
    padding-right: 0px;
  }

  .fstMultipleMode {
    display: block;
  }



  .my-form {
    background: #<?php echo $this->session->userdata("company_light_color_ses");
                  ?> !important;
  }

  .fstElement:foucs {
    box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses");
                          ?> !important;
    border: 1px solid #<?php echo $this->session->userdata("company_color_ses");
                        ?> !important;
  }

  .fstChoiceItem {
    background-color: #<?php echo $this->session->userdata("company_color_ses");
                        ?> !important;
    border: 1px solid #<?php echo $this->session->userdata("company_color_ses");
                        ?> !important;
    font-size: 1em;
  }

  .fstResultItem {
    font-size: 1em;
  }

  .fstResultItem.fstFocused,
  .fstResultItem.fstSelected {
    background-color: #<?php echo $this->session->userdata("company_color_ses");
                        ?> !important;
    border-top-color: #<?php echo $this->session->userdata("company_light_color_ses");
                        ?> !important;
  }

  .fstResults {
    position: relative !important;
  }

  .form_head ul {
    padding: 0px;
    margin-bottom: 0px;
  }

  .form_head ul li {
    display: inline-block;
  }

  .control-label {
    line-height: 42px;
    font-size: 12px;
    <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */ ?>background-color: #<?php echo $this->session->userdata("company_light_color_ses");
                                                                                      ?> !important;
    color: #000;
    margin-bottom: 10px;
  }



  .form_head {
    background-color: #f2f2f2;
    <?php /*?>border-top: 8px solid #93c301;<?php */ ?>border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
                                                                              ?>;
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
    /*color: #8b8b8b;*/
    font-size: 24px;
    padding: 7px;
    margin-top: -4px;
  }

  .form_head .form_info .btn-default {
    border: 0px;
    padding: 0px;
    background-color: transparent !important;
  }

  .form_head .form_info .tooltip {
    border-radius: 6px !important;
  }

  .salary_rt_ftr .form_sec {
    background-color: #f2f2f2;
    margin-bottom: 10px;
    display: block;
    width: 100%;
    padding: 20px;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
  }

  .head h4 {
    margin: 0px;
  }

  .padd {
    padding: 10px 20px 0px 20px !important;
  }

  /***added to center align the form head text****/
  .form_head.center_head {
    border-bottom: 0px;
    margin-bottom: 10px;
  }

  .form_head.center_head ul {
    text-align: center;
  }

  .form_head.center_head ul .form_tittle h4 {
    padding: 0px;
  }

  .form_head.center_head ul .form_tittle h4 p {
    margin: 0px;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
  }

  .form-horizontal .control-label {
    font-size: 13px !important;
  }

  /***added to center align the form head text****/
</style>



<div class="panel-group" id="panel-filters" style="display:none;">




  <div class="panel panel-default">
    <div id="main-wrapper1">


      <div class="salary_rt_ftr">
        <div class="">


          <div id ="filter_form" class="form_sec clearfix">
            <div class="form_head new_fom_head clearfix">
              <div class="col-sm-12">
                <ul>
                  <li>
                    <div class="form_tittle">
                      <h4>Filter Target Population</h4>
                    </div>
                  </li>
                  <li>
                    <div class="form_info">
                      <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Select your target population for this Comp rule by selecting or deselecting the demographic filters. You can select all filters together by clicking “select all” and the remove the employee segments which are not intended to be covered under this rule. As all these tools are interlinked, once you select the relevant demographic filters, select confirm selection to check and continue."><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                    </div>
                  </li>
                  <li>                      
                    <div style="margin-top:-5px;"class="btn btn-primary" id="selectAllOptions">Select ALL </div>                    
                  </li>
                </ul>
              </div>
            </div>




            <form id="search_form" class="form-horizontal mob_no_lbl_bg" method="post" action="" onsubmit="return //request_confirm()">
              <?php echo HLP_get_crsf_field(); ?>

              <div class="row">
                <div class="col-sm-12">
                  <div class="fltr_rule_box clearfix">

                  <div class="col-sm-4 paddl0">

<div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">Employee Name</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
        <input type="text" name="name[]" multiple class="multipleSelect" data-url="<?php echo site_url("increments/view_increments_search_field_data_ajax/{$rule_dtls['id']}/name"); ?>"   />
      </div>
    </div>
  </div> 
  

  <div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">Manager Name</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
       <input id="manager_name" type="text" name="manager_name[]" multiple class="multipleSelect" data-url="<?php echo site_url("increments/view_increments_search_field_data_ajax/{$rule_dtls['id']}/manager_name"); ?>"   />
      </div>
    </div>
  </div>                       

<div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">Country</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
        <select id="country" onchange="hide_list('country');" name="country[]" class="form-control multipleSelect" multiple="multiple">
          <?php
          if (!empty($country_list)) { ?>
            <option class="optAll" value="all">All</option>
            <?php
            foreach ($country_list as $row) { ?>
              <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
            <?php }
          } else { ?>
            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>

  <div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">City</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
        <select id="city" onchange="hide_list('city');" name="city[]" class="form-control multipleSelect" multiple="multiple">
          <?php
          if (!empty($city_list)) { ?>
            <option class="optAll" value="all">All</option>
            <?php
            foreach ($city_list as $row) { ?>
              <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
            <?php }
          } else { ?>
            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>

<div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">Business Level 1</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
        <select id="business_level_1" onchange="hide_list('business_level_1');" name="business_level_1[]" class="form-control multipleSelect" multiple="multiple">
          <?php
          if (!empty($business_level_1_list)) { ?>
            <option class="optAll" value="all">All</option>
            <?php
            foreach ($business_level_1_list as $row) { ?>
              <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
            <?php }
          } else { ?>
            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>

  <div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">Business Level 2</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
        <select id="business_level_2" onchange="hide_list('business_level_2');" name="business_level_2[]" class="form-control multipleSelect" multiple="multiple">
          <?php
          if (!empty($business_level_2_list)) { ?>
            <option class="optAll" value="all">All</option>
            <?php
            foreach ($business_level_2_list as $row) { ?>
              <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
            <?php }
          } else { ?>
            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>


   <div class="form-group my-form attireBlock">
    <label class="col-sm-4 col-xs-12 control-label removed_padding">Business Level 3</label>
    <div class="col-sm-8 col-xs-12 removed_padding">
      <div class="">
        <select id="business_level_3" onchange="hide_list('business_level_3');" name="business_level_3[]" class="form-control multipleSelect" multiple="multiple">
          <?php
          if (!empty($business_level_3_list)) { ?>
            <option class="optAll" value="all">All</option>
            <?php
            foreach ($business_level_3_list as $row) { ?>
              <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
            <?php }
          } else { ?>
            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>




</div>


                    <div class="col-sm-4 paddl0">

                  

                  


                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Function</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="function" onchange="hide_list('function');" name="function[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($function_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php
                                foreach ($function_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Sub Function</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="sub_function" onchange="hide_list('sub_function');" name="sub_function[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($subfunction_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($subfunction_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <?php /* if($performance_cycle_dtls["type"]==CV_PERFORMANCE_CYCLE_SALES_ID){ */
                      if (isset($sub_subfunction_list)) { ?>
                        <div class="form-group my-form attireBlock">
                          <label class="col-sm-4 col-xs-12 control-label removed_padding">Sub Sub Function</label>
                          <div class="col-sm-8 col-xs-12 removed_padding">
                            <div class="">
                              <select id="sub_subfunction" name="sub_subfunction[]" onchange="hide_list('sub_subfunction');" class="multipleSelect" multiple="multiple">
                                <!--<option  value="all">All</option>-->
                                <?php
                                if (!empty($sub_subfunction_list)) { ?>
                                  <option class="optAll" value="all">All</option>
                                  <?php foreach ($sub_subfunction_list as $row) { ?>
                                    <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                  <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      <?php }
                              } else { ?>
                      <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                    <?php } ?>

                    <div class="form-group my-form attireBlock">
                      <label class="col-sm-4 col-xs-12 control-label removed_padding">Designation</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <div class="">
                          <select id="designation" onchange="hide_list('designation');" name="designation[]" class="form-control multipleSelect" multiple="multiple">
                            <?php
                            if (!empty($designation_list)) { ?>
                              <option class="optAll" value="all">All</option>
                              <?php
                              foreach ($designation_list as $row) { ?>
                                <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                              <?php }
                            } else { ?>
                              <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Grade</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="grade" onchange="hide_list('grade');" name="grade[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($grade_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($grade_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>

                            </select>


                          </div>
                        </div>
                      </div>
                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Level</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="level" onchange="hide_list('level');" name="level[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($level_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($level_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>

                    </div>                  

                    <div class="col-sm-4 col-sm-4 paddr0 paddl0">                    

                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Education</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="education" onchange="hide_list('education');" name="education[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($education_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($education_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Talent</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="critical_talent" onchange="hide_list('critical_talent');" name="critical_talent[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($critical_talent_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($critical_talent_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Critical Position</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="critical_position" onchange="hide_list('critical_position');" name="critical_position[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($critical_position_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($critical_position_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Special Category</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="special_category" onchange="hide_list('special_category');" name="special_category[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($special_category_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($special_category_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>



                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Employee type</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="employee_type" onchange="hide_list('employee_type');" name="employee_type[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($employee_type_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($employee_type_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>


                      <div class="form-group my-form attireBlock">
                        <label class="col-sm-4 col-xs-12 control-label removed_padding">Employee role</label>
                        <div class="col-sm-8 col-xs-12 removed_padding">
                          <div class="">
                            <select id="employee_role" onchange="hide_list('employee_role');" name="employee_role[]" class="form-control multipleSelect" multiple="multiple">
                              <?php
                              if (!empty($employee_role_list)) { ?>
                                <option class="optAll" value="all">All</option>
                                <?php foreach ($employee_role_list as $row) { ?>
                                  <option value="<?php echo $row; ?>" <?php echo $select_all; ?>><?php echo $row; ?></option>
                                <?php }
                              } else { ?>
                                <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>


                     


                    </div>
                  </div>
                </div>






                <div class="">
                  <div class="col-sm-12">
                    <div class="sub-btnn text-right">
                      <input id="searchfilter" type="submit" name="btn_confirm_selection" value="Search" class="btn btn-primary" />
                    </div>
                  </div>
                </div>
                <input type="hidden" value="1" name="ajax">
            </form>
          </div>
          </div>
          <div class="">
            <div id="ajax_content">
            </div>
            <div class="fltr_rule_box" id="dv_search_result" style="display: none; font-size: 13px; padding-bottom: 12px;">
            </div>
          </div>
     

      </div>
    </div>
  </div>
</div>
</div>
<script>


  function hide_list(obj_id) {
    $("#dv_next").hide();
    $("#dv_confirm_selection").show();
    $('#' + obj_id + ' :selected').each(function(i, selected) {
      if ($(selected).val() == 'all') {
        $('#' + obj_id).closest(".fstElement").find('.fstChoiceItem').each(function() {
          $(this).find(".fstChoiceRemove").trigger("click");
        });
        show_list(obj_id);
        $("div").removeClass("fstResultsOpened fstActive");
      }
    });
  }

  function show_list(obj) {
    $('#' + obj).siblings('.fstResults').children('.fstResultItem').each(function(i, selected) {
      if ($(this).html() != 'All') {
        $(this).trigger("click");
      }
    });
  }
</script>
<script>
  //Piy12Jan

 $('.multipleSelect').fastselect();
  $("#selectAllOptions").click(function() {
    $("#search_form select").each(function(){
      var that=$(this);
      var par=that.parent().parent();
      that.children('option').prop('selected', true);
      that.children('option.optAll').prop('selected', false);    
      par.html("").append(that);
      that.fastselect().siblings(".fstControls").trigger("click");
    });    
  });

  $("#showfilter").click(function() {
    $('#filter_form').show();
    if ($(this).attr('processed') == 'processed') {
      $(this).html("Show Filters");
      $(this).attr('processed', '');
      $("#accordion").show();
      $('#panel-filters').hide();
    } else {
      $(this).html("Hide Filters");
      $(this).attr('processed', 'processed');
      $("#accordion").hide();
      $('#panel-filters').show();
    }
  });

  $("#search_form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var url = '<?php echo site_url("increments/view_increments_search_ajax/{$rule_dtls['id']}/0"); ?>';
    get_records_ajax(url);
  });

  function get_records_ajax(url) {
    var target = $("#dv_search_result");

    $("#loading").css('display', 'none');
    $("#loading").css('visibility', 'hidden');
    $.ajax({
      type: "POST",
      url: url,
      data: $("#search_form").serialize(), // serializes the form's elements.
      beforeSend: function() {

        $("#loading").css('display', 'none');
        $("#dv_search_result").css('display', 'block');
        $("#dv_search_result").html("<div>Please wait while we are processing your request... <i class='fa fa-circle-o-notch fa-spin'></i></div>");
        if (target.length) {
        $('html,body').animate({
            scrollTop: target.offset().top
        }, 1000);
        }        
      },
      success: function(data) {
        $("#dv_search_result").html(data);

        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top
            }, 1000);
        }
        var table = $('#ajax_content table').DataTable({
				orderCellsTop: true,       
				searching: true,
				 paging: false, 
				 info: false         
			   // fixedHeader: true
			});

      //  $('#filter_form').hide();   
      /*   
        $('#table_').excelTableFilter({
          columnSelector: '.showfilter'   // (optional) if present, will only select <th> with specified class
        });*/

      },
      complete: function() {
        set_csrf_field();
        $("#loading").css('display', 'none');
      }
    });
  };

  $(function() {

    <?php
    if ($this->input->post("hf_select_all_filters")) {
    ?>
    $("#showfilter").trigger("click");
    <?php
    }
    ?>

    $(document).on("click", '#ajax_links li a', function(event) {
      var page_id = $(this).attr('page_id');
      var url = '<?php echo site_url("increments/view_increments_search_ajax/{$rule_dtls['id']}"); ?>/' + page_id;
      get_records_ajax(url);
    });
  });
</script>
<style type="text/css">
  .rule-form .form-control {
    height: 30px;
    margin-top: 0px;
    font-size: 12px;
    background-color: #FFF;
    margin-bottom: 10px;
  }

  .rule-form .control-label {
    font-size: 13px;
    line-height: 30px;
    <?php /*?>background-color: rgba(147, 195, 1, 0.2);<?php */ ?>background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
    color: #000;
    margin-bottom: 10px;
  }

  .rule-form .form-control:focus {
    box-shadow: none !important;
  }

  .rule-form .form_head {
    background-color: #f2f2f2;
    <?php /*?>border-top: 8px solid #93c301;<?php */ ?>border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
  }

  .rule-form .form_head .form_tittle {
    display: block;
    width: 100%;
  }

  .rule-form .form_head .form_tittle h4 {
    font-weight: bold;
    color: #000 !important;
    text-transform: uppercase;
    margin: 0;
    padding: 12px 0px;
    margin-left: 5px;
  }

  .rule-form .form_head .form_info {
    display: block;
    width: 100%;
    text-align: center;
  }

  .rule-form .form_head .form_info i {
    /*color: #8b8b8b;*/
    font-size: 24px;
    margin-top: -4px;
    padding: 7px;
  }

  .rule-form .form_sec {
    background-color: #f2f2f2;

    display: block;
    width: 100%;
    padding: 5px 0px 9px 0px;
    border-bottom-left-radius: 0px;
    /*6px;*/
    border-bottom-right-radius: 0px;
    /*6px;*/
  }

  .form-group {
    margin-bottom: 10px;
  }

  .rule-form .form_info .btn-default {
    border: 0px;
    padding: 0px;
    background-color: transparent !important;
  }

  .rule-form .form_info .tooltip {
    border-radius: 6px !important;
  }
</style>