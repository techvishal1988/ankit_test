<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css'); ?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
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

  .rt_ftr .form_sec {
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
<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid">
    <div class="row">
      <div class="col-sm-8 plft0">
        <ol class="breadcrumb">
          <li>
            <a href="#"><?php echo 'Report';  ?></a></li>
          <li class="active"><?php echo $title; ?></li>
        </ol>
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div>
</div>



<div id="main-wrapper" class="container-fluid compp_fluid">
  <?php
  echo $this->session->flashdata('message');
  echo $msg;
  // $val = json_decode($tooltip[0]->step);
  ?>

  <div class="rt_ftr">
    <div class="form-horizontal">
      <div class="form_head center_head clearfix">
        <div class="col-sm-12">
          <ul class="">
            <li>
              <div class="form_tittle">
                <h4><span><?php echo 'Employee History Report' ?></span></h4>
              </div>
            </li>
            <li>
              <div class="form_info">
                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="<?php ?>"><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
              </div>
            </li>
          </ul>
        </div>
      </div>






      <div class="row">

      </div>
      <div class="form_sec clearfix">
        <div class="fltr_rule_box clearfix">
          <div class="col-sm-6 paddl0">
            <div class="form-group my-form attireBlock">
              <label class="col-sm-4 col-xs-12 control-label removed_padding">Start Date</label>
              <div class="col-sm-8 col-xs-12 removed_padding">
                <div class="">
                  <input required=true id="txt_start_date_2" name="txt_start_date_2" type="text" class="form-control" maxlength="10" value="<?php echo date('d/m/Y', mktime(0, 0, 0, date("m") , date("d"), date("Y"))); ?>" autocomplete="off" onblur="checkDateFormat(this)">
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 paddr0">
            <div class="form-group my-form attireBlock">
              <label class="col-sm-4 col-xs-12 control-label removed_padding">End Date</label>
              <div class="col-sm-8 col-xs-12 removed_padding">
                <div class="">
                  <input id="txt_end_date_2" name="txt_end_date_2" type="text" class="form-control" maxlength="10" value="" autocomplete="off" onblur="checkDateFormat(this)">
                </div>
              </div>
            </div>
          </div>
        </div>





        <div class="form_head new_fom_head clearfix">
          <div class="col-sm-12">
            <ul>
              <li>
                <div class="form_tittle">
                  <h4>employee detail</h4>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="fltr_rule_box clearfix">
          <div class="col-sm-6 paddl0">
            <div class="form-group my-form attireBlock">
              <label class="col-sm-4 col-xs-12 control-label removed_padding">Name</label>
              <div class="col-sm-8 col-xs-12 removed_padding">
                <div class="">
                  <input id="name_2" name="name_2" type="text" class="form-control" />
                </div>
              </div>
            </div>


          </div>
          <div class="col-sm-6 paddr0">
            <div class="form-group my-form attireBlock">
              <label class="col-sm-4 col-xs-12 control-label removed_padding">Email</label>
              <div class="col-sm-8 col-xs-12 removed_padding">
                <div class="">
                  <input id="email_2" name="email_2" type="text" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 paddl0">
            <div class="form-group my-form attireBlock">
              <label class="col-sm-4 col-xs-12 control-label removed_padding">Employee Code</label>
              <div class="col-sm-8 col-xs-12 removed_padding">
                <div class="">
                  <input id="employee_code_2" name="employee_code_2" type="text" class="form-control" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form_head new_fom_head clearfix">
          <div class="col-sm-12">
            <ul>
              <li>
                <div class="form_tittle">
                  <h4>Organizational Filters </h4>
                </div>
              </li>
              <li>
                <div class="form_info">
                  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="<?php //echo $val[1]?>"><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                </div>
              </li>
              <li>
                <form class="form-horizontal" method="post" action="">
                  <?php echo HLP_get_crsf_field(); ?>
                  <input type="hidden" name="hf_select_all_filters" value="1" />
                  <input style="margin-top:-5px;" type="submit" value="Select All" class="btn btn-primary" />
                </form>
                <?php $select_all = "";
                if ($this->input->post("hf_select_all_filters")) {
                  $select_all = 'selected="selected"';
                }
                ?>
              </li>
            </ul>
          </div>
        </div>
        <form class="form-horizontal" id="employee_historical_search_form" method="post" action="">
          <?php echo HLP_get_crsf_field(); ?>
          <input id="txt_start_date" name="txt_start_date" type="hidden" class="form-control">
          <input id="txt_end_date" name="txt_end_date" type="hidden" class="form-control">
          <input id="name" name="name" type="hidden" class="form-control" />
          <input id="email" name="email" type="hidden" class="form-control" />
          <input id="employee_code" name="employee_code" type="hidden" class="form-control" />
          <div class="row">
            <div class="col-sm-12">
              <div class="fltr_rule_box clearfix">
                <div class="col-sm-6 paddl0">

                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Country</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="country" onchange="hide_list('country');" name="country[]" class="form-control multipleSelect" multiple="multiple">

                          <?php
                          if (!empty($country_list)) { ?>
                            <option value="all">All</option>
                            <?php
                            foreach ($country_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['country']) and in_array($row["id"], $rule_dtls['country'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option value="all">All</option>
                            <?php
                            foreach ($city_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['city']) and in_array($row["id"], $rule_dtls['city'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php }
                          } else { ?>
                            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Bussiness Level 1</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="business_level_1" onchange="hide_list('business_level_1');" name="business_level_1[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($business_level_1_list)) { ?>
                            <option value="all">All</option>
                            <?php
                            foreach ($business_level_1_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['business_level1']) and in_array($row["id"], $rule_dtls['business_level1'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php }
                          } else { ?>
                            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Bussiness Level 2</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="business_level_2" onchange="hide_list('business_level_2');" name="business_level_2[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($business_level_2_list)) { ?>
                            <option value="all">All</option>
                            <?php
                            foreach ($business_level_2_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['business_level2']) and in_array($row["id"], $rule_dtls['business_level2'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php }
                          } else { ?>
                            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Bussiness Level 3</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="business_level_3" onchange="hide_list('business_level_3');" name="business_level_3[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($business_level_3_list)) { ?>
                            <option value="all">All</option>
                            <?php
                            foreach ($business_level_3_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['business_level3']) and in_array($row["id"], $rule_dtls['business_level3'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php }
                          } else { ?>
                            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Function</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="function" onchange="hide_list('function');" name="function[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($function_list)) { ?>
                            <option value="all">All</option>
                            <?php
                            foreach ($function_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['functions']) and in_array($row["id"], $rule_dtls['functions'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                          if (!empty($sub_function_list)) { ?>
                            <option value="all">All</option>
                            <?php foreach ($sub_function_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['sub_functions']) and in_array($row["id"], $rule_dtls['sub_functions'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                              <option value="all">All</option>
                              <?php foreach ($sub_subfunction_list as $row) { ?>
                                <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['sub_subfunctions']) and in_array($row["id"], $rule_dtls['sub_subfunctions'])) {
                                                                            echo 'selected="selected"';
                                                                          } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                <?php } ?>

                </div>

                <div class="col-sm-6 paddr0">

                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Designation</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="designation" onchange="hide_list('designation');" name="designation[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($designation_list)) { ?>
                            <option value="all">All</option>
                            <?php
                            foreach ($designation_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['designations']) and in_array($row["id"], $rule_dtls['designations'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option value="all">All</option>
                            <?php foreach ($grade_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['grades']) and in_array($row["id"], $rule_dtls['grades'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option value="all">All</option>
                            <?php foreach ($level_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['levels']) and in_array($row["id"], $rule_dtls['levels'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
                            <?php }
                          } else { ?>
                            <option value="0" selected="" <?php echo $select_all; ?>><?php echo 'Not available'; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group my-form attireBlock">
                    <label class="col-sm-4 col-xs-12 control-label removed_padding">Education</label>
                    <div class="col-sm-8 col-xs-12 removed_padding">
                      <div class="">
                        <select id="education" onchange="hide_list('education');" name="education[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($education_list)) { ?>
                            <option value="all">All</option>
                            <?php foreach ($education_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['educations']) and in_array($row["id"], $rule_dtls['educations'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option value="all">All</option>
                            <?php foreach ($critical_talent_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['critical_talents']) and in_array($row["id"], $rule_dtls['critical_talents'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                            <option value="all">All</option>
                            <?php foreach ($critical_position_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['critical_positions']) and in_array($row["id"], $rule_dtls['critical_positions'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                        <select id="cspecial_category" onchange="hide_list('cspecial_category');" name="special_category[]" class="form-control multipleSelect" multiple="multiple">
                          <?php
                          if (!empty($special_category_list)) { ?>
                            <option value="all">All</option>
                            <?php foreach ($special_category_list as $row) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (isset($rule_dtls['special_category']) and in_array($row["id"], $rule_dtls['special_category'])) {
                                                                          echo 'selected="selected"';
                                                                        } ?> <?php echo $select_all; ?>><?php echo $row["name"]; ?></option>
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
                <div class="fltr_rule_box" id="dv_search_result" style="display: none; font-size: 13px; padding-bottom: 12px;">
                </div>
              </div>
            </div>

            <div class="">
              <div class="col-sm-12">
                <div class="sub-btnn text-right" id="dv_search">
                  <input type="submit" name="btn_search" value="Search" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order" />
                </div>
              </div>
            </div>

        </form>
      </div>
    </div>
  </div>

  <script>
    $('.multipleSelect').fastselect();
    $(document).ready(function() {
      $("#txt_start_date_2, #txt_end_date_2").datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        // yearRange: "1995:new Date().getFullYear()",
      });
    });

    function hide_list(obj_id) {
      $('#' + obj_id + ' :selected').each(function(i, selected) {
        if ($(selected).val() == 'all') {
          $('#' + obj_id).closest(".fstElement").find('.fstChoiceItem').each(function() {
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
    // this is the id of the form
    $("#employee_historical_search_form").submit(function(e) {
      $("#loading").css('visibility', 'hidden');
    });
    /*
        $("#txt_start_date_2").on('change', function(){  
           
          $("#txt_start_date").val($(this).val());
        });

        $("#txt_end_date_2").on('change', function(){   
          $("#txt_end_date").val($(this).val());
        });

        $("#name_2").on('change', function(){   
          $("#name").val($(this).val());
        });

        $("#employee_code_2").on('change', function(){   
          $("#employee_code").val($(this).val());
        });
      
        $("#email_2").on('change', function(){  
          $("#email").val($(this).val());
        });              
    */
    $("#employee_historical_search_form").submit(function(e) {
      $("#loading").css('display', 'none');
      $("#loading").css('visibility', 'hidden');
      e.preventDefault(); // avoid to execute the actual submit of the form.
      $("#email").val($("#email_2").val());
      $("#employee_code").val($("#employee_code_2").val());
      $("#name").val($("#name_2").val());
      $("#txt_end_date").val($("#txt_end_date_2").val());
      $("#txt_start_date").val($("#txt_start_date_2").val());

      if ($("#txt_start_date_2").val() == '') {
        $("#txt_start_date_2").focus();
        return false;
      }
      var form = $(this);
      var url = '<?php echo site_url("report/employee_historical_search"); ?>';

      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        beforeSend: function() {
          $("#loading").css('display', 'none');
          $("#dv_search_result").css('display', 'block');
          $("#dv_search_result").html("<div>Please wait while we are processing your request... <i class='fa fa-circle-o-notch fa-spin'></i></div>");
        },
        success: function(data) {
          $("#dv_search_result").html(data);
        },
        complete: function() {
          set_csrf_field();
          $("#loading").css('display', 'none');
        }
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