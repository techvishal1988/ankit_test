<?php // echo "<pre/>";print_r($attributes);   ?>
<style>
    .form_head ul{ padding:0px; margin-bottom:0px;}
    .form_head ul li{ display:inline-block;}

    .rule-form .control-label {
        font-size: 12px;
        line-height: 30px;
    }
    .rule-form .form-control {
        height: 30px;
        margin-top: 0px;
        font-size: 12px;
        background-color: #FFF;
        margin-bottom:10px;
    }
    .rule-form .control-label {
        font-size: 11.25px;
        background-color: #<?php echo $this->session->userdata("company_light_color_ses"); ?>;
        color: #000;
    }
    .rule-form .form-control:focus {
        box-shadow: none!important;
    }
    .rule-form .form_head {
        background-color: #f2f2f2;
        border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses"); ?>;
    }
    .rule-form .form_head .form_tittle {
        display: block;
        width: 100%;
    }
    .rule-form .form_head .form_tittle h4 {
        font-weight: bold;
        color: #000;
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
        color: #8b8b8b;
        font-size: 24px;
        padding: 7px;
    }
    .rule-form .form_sec {
        background-color: #f2f2f2;
        margin-bottom: 10px;
        display: block;
        width: 100%;
        padding: 5px 0px 9px 0px;

    }
    .rule-form .form_info .btn-default {
        border: 0px;
        padding: 0px;
        background-color: transparent!important;
    }
    .rule-form .form_info .tooltip {
        border-radius: 6px !important;
    }
    .mar10 {
        margin-bottom: 10px !important;
    }


    @media screen and (max-width: 767px)
    {
        .beg_color input[type="checkbox"]+span:before {
            margin-top: 10px;
        }
    }
</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <!--<li><a href="<?php //echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <?php
            if($show_breadcrumb) {
        ?>
            <li><a href="<?php echo site_url("staff"); ?>">Employee List</a></li>
        <?php
            }
        ?>
        <?php if (isset($staffDetail) and ! empty($staffDetail)) { ?>
            <li class="active">Employee Detail</li>
        <?php } else { ?>
            <li class="active">Add Employee</li>
        <?php } ?>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <div class="row mb20">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-white">

                <div class="panel-body">
                    <div class="rule-form">
                        <div class="form-group">
                            <!-- <form method="post" id="dis" > -->
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <?php
                                    echo $this->session->flashdata('message');
                                    if ($msg) {
                                        echo $msg;
                                    }
                                    ?>
                                </div>

<?php

foreach ($attributes as $key => $value) { ?>

                                    <div class="col-sm-12">
                                        <div class="form_head clearfix">
                                            <div class="col-sm-12">
                                                <ul>
                                                    <li>
                                                        <div class="form_tittle">
                                                            <h4><?php echo $key; ?></h4>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form_info">
                                                            <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="Employee detail"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form_sec clearfix">
                                            <div class="col-sm-12">
                                                <?php
                                                $i = 1;

                                                foreach ($value as $atti) {
                                                    if ($atti['is_required'] == 1) {
                                                        $req = "required";
                                                        $reqmark = '*';
                                                    } else {
                                                        $req = "";
                                                        $reqmark = '';
                                                    }
                                                    if ($atti['status'] == 1) {
                                                        ?>
                                                        <div class="col-sm-6">
                                                            <label for="input<?php echo $i; ?>" class="control-label"><?php echo $atti['display_name'] . $reqmark; ?></label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-input">
                                                                <input type="text" name="txt_<?php echo $atti['id']; ?>" <?php echo $req; ?> <?php if(isset($uri_key) and $uri_key = "view-employee"){ echo "readonly"; }?> class="form-control" value="<?php echo $staffDetail[$atti['ba_name']] ?>"/>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                                if ($key == "Personal") {
                                                    ?>
                                                    <div class="col-sm-6">
                                                        <label for="input" class="control-label">Role*</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-input">
                                                            <select id="ddl_role" <?php if(isset($uri_key) and $uri_key = "view-employee"){ echo "disabled"; }?> name="ddl_role" class="js-states form-control" tabindex="-1" style="width: 100%" required="required" onchange="show_hide_manage_hr_only_dv()">
                                                                <option value="">Select</option>
                                                                <?php foreach ($roles as $row) { ?>
<option value='<?php echo $row["id"]; ?>' <?php if($staffDetail['role']==$row["id"]){ echo "selected";} ?>><?php echo $row["name"] ?></option>
        <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 dv_manage_hr_only">
                                                        <label for="input" class="control-label">Managing HR Only</label>
                                                    </div>
                                                    <div class="col-sm-6 dv_manage_hr_only">
                                                        <div class="form-input">
                                                            <div class="beg_color" style="margin-top:5px;">
                                                                <label>&nbsp; 
                                                                    <input type="checkbox" name="chk_manage_hr_only"  value="1" id="chk_manage_hr_only" style="opacity:1; margin-top:1px;"><span class="margTop"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
<?php if(isset($uri_key) and $uri_key != "view-employee"){ ?>
                                                    <div class="col-sm-6">
                                                        <label for="input" class="control-label">Image</label>
                                                    </div>
                                                    <form action="<?php echo base_url('view-employee/') . $userid; ?>" method="post" enctype="multipart/form-data">
                                                        <div class="col-sm-4">
                                                            <div class="form-input">
        <?php echo HLP_get_crsf_field(); ?>
                                                                <input type="file" required="required" name="emp_img" accept="image/*" id="emp_img" class="form-control" value=""/>

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <input type="submit" class="btn btn-primary" value="Upload" name="submit">
                                                        </div>
                                                    </form>

<?php }} ?>
                                            </div>
                                        </div>
                                    </div>
<?php } ?>

<!--<input type="button" id="btnAdd" value="Add" class="btn btn-success" />-->

                            </div>

                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('#dis input[type=text],#dis select').attr("disabled", true);
    //$('.multipleSelect').fastselect();

    $('#txt_email').blur(function () {
        if ($("#txt_email").val())
        {
            $('.email_exist').hide();
            $('.rights_exist').html("");
            $.post("<?php echo site_url("admin/admin_dashboard/check_email_exist"); ?>", {"email_id": $("#txt_email").val()}, function (data) {
                if (data)
                {
                    var response = JSON.parse(data);
                    $("#txt_name").val(response.emp_name);
                    if (response.status == 2)
                    {
                        $('.email_exist').show();
                    } else if (response.status == 3)
                    {
                        $('.email_exist').show();
                        $('.rights_exist').html("Rights already created for this user.");
                    }
                }
            });
        }
    });


</script>

<script>
    function hide_list(obj_id)
    {
        $('#' + obj_id + ' :selected').each(function (i, selected)
        {
            if ($(selected).val() == 0)
            {
                $('#' + obj_id).closest(".fstElement").find('.fstChoiceItem').each(function ()
                {
                    if ($(this).attr("data-value") != 0)
                    {
                        $(this).find(".fstChoiceRemove").trigger("click");
                    }
                });
                $("div").removeClass("fstResultsOpened fstActive");
            }
        });
    }



<?php if (isset($staffDetail) and ! empty($staffDetail)) { ?>
        $("#ddl_role").val(<?php echo $staff_basic_dtls["role"]; ?>);
        //$("input[name=txt_<?php echo CV_EMAIL_ID; ?>]").attr('readonly','readonly');
        //$("input[name=txt_<?php echo CV_EMAIL_ID; ?>]").css('background-color','#eee');
        //$("input[name=txt_<?php echo CV_EMAIL_ID; ?>]").css('cursor','not-allowed');
        $("#chk_manage_hr_only").prop("checked", <?php echo $staff_basic_dtls["manage_hr_only"]; ?>);
<?php } ?>
    show_hide_manage_hr_only_dv();
    function show_hide_manage_hr_only_dv()
    {
        $(".dv_manage_hr_only").hide();
        var role = $("#ddl_role").val();
        if (role == '3' || role == '4' || role == '5')
        {
            $(".dv_manage_hr_only").show();
        } else
        {
            $("#chk_manage_hr_only").prop("checked", false);
        }
    }
</script>