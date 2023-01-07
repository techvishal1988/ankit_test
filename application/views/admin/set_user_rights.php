<link rel="stylesheet" href="<?php echo base_url("assets/css/fastselect.min.css"); ?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>

.fstMultipleMode { display: block; }
.fstMultipleMode .fstControls {width:36em; }

.my-form{background:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important;}

.control-label
{ 
    line-height:42px;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="javascript:void(0)">General Setting</a></li>
        <li class="active">Set User Rights</li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
    <h3>Set User Rights</h3>
</div>
</div> -->

<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-9 col-md-offset-2">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if($msg){echo $msg;} ?>      
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="">
                    
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Country</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_country" onchange="hide_list('ddl_country');" name="ddl_country[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['countrys']) and in_array(0, $users_old_right_dtls['countrys'])){echo 'selected="selected"';}?>>All</option>
                                <?php foreach($country_list as $row){?>
                                <option value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['countrys']) and in_array($row["id"], $users_old_right_dtls['countrys'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>                       
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">City</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_city" onchange="hide_list('ddl_city');" name="ddl_city[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option value="0" <?php if(isset($users_old_right_dtls['citys']) and in_array(0, $users_old_right_dtls['citys'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($city_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['citys']) and in_array($row["id"], $users_old_right_dtls['citys'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Bussiness Level 1</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_bussiness_level_1" onchange="hide_list('ddl_bussiness_level_1');" name="ddl_bussiness_level_1[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['bl_1']) and in_array(0, $users_old_right_dtls['bl_1'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($bussiness_level_1_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['bl_1']) and in_array($row["id"], $users_old_right_dtls['bl_1'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Bussiness Level 2</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_bussiness_level_2" onchange="hide_list('ddl_bussiness_level_2');" name="ddl_bussiness_level_2[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['bl_2']) and in_array(0, $users_old_right_dtls['bl_2'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($bussiness_level_2_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['bl_2']) and in_array($row["id"], $users_old_right_dtls['bl_2'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Bussiness Level 3</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_bussiness_level_3" onchange="hide_list('ddl_bussiness_level_3');" name="ddl_bussiness_level_3[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['bl_3']) and in_array(0, $users_old_right_dtls['bl_3'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($bussiness_level_3_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['bl_3']) and in_array($row["id"], $users_old_right_dtls['bl_3'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Function</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_function" onchange="hide_list('ddl_function');" name="ddl_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['functions']) and in_array(0, $users_old_right_dtls['functions'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($function_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['functions']) and in_array($row["id"], $users_old_right_dtls['functions'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Sub Function</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_sub_function" onchange="hide_list('ddl_sub_function');" name="ddl_sub_function[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['sub_functions']) and in_array(0, $users_old_right_dtls['sub_functions'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($sub_function_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['sub_functions']) and in_array($row["id"], $users_old_right_dtls['sub_functions'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Sub Sub Function</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_sub_subfunction" onchange="hide_list('ddl_sub_subfunction');" name="ddl_sub_subfunction[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['sub_subfunctions']) and in_array(0, $users_old_right_dtls['sub_subfunctions'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($sub_subfunction_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['sub_subfunctions']) and in_array($row["id"], $users_old_right_dtls['sub_subfunctions'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Designation</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_designation" onchange="hide_list('ddl_designation');" name="ddl_designation[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['designations']) and in_array(0, $users_old_right_dtls['designations'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($designation_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['designations']) and in_array($row["id"], $users_old_right_dtls['designations'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Grade</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_grade" onchange="hide_list('ddl_grade');" name="ddl_grade[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['grades']) and in_array(0, $users_old_right_dtls['grades'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($grade_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['grades']) and in_array($row["id"], $users_old_right_dtls['grades'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group my-form attireBlock">
                        <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Level</label>
                        <div class="col-sm-9 form-input inner removed_padding">
                             <select id="ddl_level" onchange="hide_list('ddl_level');" name="ddl_level[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                <option  value="0" <?php if(isset($users_old_right_dtls['levels']) and in_array(0, $users_old_right_dtls['levels'])){echo 'selected="selected"';}?> >All</option>
                                <?php foreach($level_list as $row){?>
                                <option  value="<?php echo $row["id"]; ?>" <?php if(isset($users_old_right_dtls['levels']) and in_array($row["id"], $users_old_right_dtls['levels'])){echo 'selected="selected"';}?> ><?php echo $row["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="">
                        <div class="col-sm-offset-9 col-sm-9 mob-center">
                            <input type="submit" id="btnAdd" value="Add" class="btn btn-success" />
                        </div>
                    </div>
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>

<script>
   $('.multipleSelect').fastselect();
</script>

<script>
function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()==0)
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
                if($(this).attr("data-value")!= 0)
                {
                    $(this).find(".fstChoiceRemove").trigger("click");
                }
            });
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}
</script>
