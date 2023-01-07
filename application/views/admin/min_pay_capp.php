<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active"><?php echo (isset($title)) ? $title : 'Manage'; ?></lti>
    </ol>
</div>

<div id="main-wrapper" class="container aop">
    <div class="row">
        <div class="col-sm-12">
            <div class="mailbox-content">
                <div class="upload_div managecity">
                    <form class="frm_cstm_popup_cls_upload_pay_capp"  method="post"  enctype="multipart/form-data" action="<?php echo site_url("upload-min-pay-capp-data/".$tenure["id"]); ?>" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_upload_pay_capp')">
                        <?php echo HLP_get_crsf_field(); ?>

                        <div class="upload_file">
                            <input type="file" name="myfile" id="myfile" class="form-control" title="Choose a file csv to upload" required accept="application/msexcel*">
                            <span class="upload-path" style=" display: none" ></span>
                        </div>
                        <div class="upload_btn">
                            <input type="submit" name="uploadfile" value="Upload File" class="btn btn-success">
                        </div>
                        <div class="download_btn">
                            <a href="<?php echo base_url('download-min-pay-capp-sample-file/'); ?>" class="downloadcsv"><input type="button" value="Download File Format" class="btn btn-success"></a>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb20">

                <div class="panel panel-white">   
                    <?php echo $this->session->flashdata('message'); ?> 

                    <div class="panel-body">
                        <div class="rule-form">

                            <form class="form-horizontal frm_cstm_popup_cls_mintable_pay_capp" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_mintable_pay_capp')">
                                <?php echo HLP_get_crsf_field(); ?>
                                <div class="form-group">
                                    <div class="">
                                        <div class="col-sm-12">
                                            <div class="form_head clearfix">
                                                <div class="col-sm-12">
                                                    <ul>
                                                        <li>
                                                            <div class="form_tittle">
                                                                <h4>Band Wise Minimum Pay  for tenure <?php
                                                                    if ($tenure['end_month'] == CV_Max_Tenure_Value) {
                                                                        echo $str = ">" . $tenure['start_month'];
                                                                    } else {
                                                                        echo $str = "" . $tenure['start_month'] . "-" . $tenure['end_month'];
                                                                    }
                                                                    ?></h4>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div> 
                                            <!--
                                            -->                                            <div class="form_sec clearfix" id="dv_frm_head">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table style="margin-bottom:10px;" class="table table-bordered th-top-aln">
                                                            <thead>
                                                                <tr>
                                                                    <th>Band</th>
                                                                    <?php for ($i = 0; $i < count($tierlist); $i++) { ?>
                                                                        <th><?php echo $tierlist[$i]['name']; ?></th>
                                                                    <?php } ?>

                                                                </tr>


                                                            </thead>
                                                            <tbody>
                                                                <?php
//                                                           


                                                                for ($l = 0; $l < count($gradelist); $l++) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $gradelist[$l]['name'] ?></td>

                                                                        <?php
                                                                        for ($j = 0; $j < count($tierlist); $j++) {
                                                                            $tierarr = HLP_get_min_pay_capping_master_row($gradelist[$l]['id'], $tenure['id'], $tierlist[$j]['id']);
                                                                            ?>
                                                                            <td><input type="text" name="txt_tier_val_<?php echo $tierlist[$j]['id'] . "_" . $gradelist[$l]['id'] ?>" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"  maxlength="8" class="form-control mar_bot txt_tier_<?php echo $gradelist[$l]['id'] ?>" onchange="fill_below_value(this.value, '<?php echo $j; ?>', '<?php echo $gradelist[$l]['id'] ?>');" value="<?php
                                                                                if ($tierarr['tier_val'] != 0) {
                                                                                    echo round($tierarr['tier_val'], 0);
                                                                                }
                                                                                ?>"></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                            </tbody>
                                                        </table>   

                                                    </div>                                     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mob-center text-right">  
                                        <input type="submit" id="btnAdd" name="btnAdd" value="Submit" class="btn mar_l_5 btn-success" />

                                    </div>
                                </div>   
                            </form>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
</div>


<style>

    .form_head ul {
        padding:0px;
        margin-bottom:0px;
    }
    .form_head ul li {
        display:inline-block;
    }
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
        padding: 6px 3px !important;
    }
    .rule-form .control-label {
        font-size: 12px;
        <?php /* ?>background-color: rgba(147, 195, 1, 0.2);<?php */ ?> background-color: #<?php echo $this->session->userdata("company_light_color_ses");
        ?>;
        margin-bottom:10px;
    }
    .rule-form .form-control:focus {
        box-shadow: none!important;
    }
    .rule-form .form_head {
        background-color: #f2f2f2;
        <?php /* ?>border-top: 8px solid #93c301;<?php */ ?> border-top: 8px solid #<?php echo $this->session->userdata("company_color_ses");
        ?>;
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
        padding: 7px;
        margin-top: -4px;
    }
    .rule-form .form_sec {
        background-color: #f2f2f2;
        display: block;
        width: 100%;
        padding: 5px 0px 9px 0px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
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
    .form-group {
        margin-bottom: 10px;
    }
    .mailbox-content, .panel-white {
        padding-bottom: 2px;
    }
    .paddg {
        0px 20px;
    }

    .msgtxtalignment .msg-left{
        width: 29%;
        display: inline-block;
    }

    .msgtxtalignment .msg-left .alert-success{background:transparent; padding-right: 0px;}

    .msgtxtalignment .msg-left .close{display:none;}

    .msgtxtalignment .msg-right{
        width: 55% !important;
        display: inline-block !important;
    }

    .alert 
    {
        margin-bottom: -10px !important;
        margin-top: -5px !important;
    }

    .rule-form .form-control.mar_bot{margin-bottom: 0px !important; }

</style>
<script>
    function fill_below_value(fillval, indx, id)
    {
        var i = 0;
        $(".txt_tier_" + id).each(function () {
            //  alert(i);
            if (i > indx)
            {
//            if ($(this).val() == "0.00" || $(this).val() == "0" || $(this).val() == "") {
                $(this).val(fillval);
            }
            i++;
//            }
        })
    }
</script>

<script type="text/javascript">
    var span = document.getElementsByClassName('upload-path');
    // Button
    var uploader = document.getElementsByName('myfile');
    // On change
    for (item in uploader) {
        // Detect changes
        uploader[item].onchange = function () {
            // Echo filename in span
            span[0].innerHTML = this.files[0].name;
            var filename = this.files[0].name;
            var file_ext = filename.split('.').pop();
            // if((this.files[0].type != "text/comma-separated-values") && (this.files[0].type != "application/vnd.ms-excel") && (this.files[0].type != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
            if (file_ext != 'csv')
            {
                span[0].innerHTML = "";
                $("#myfile").val("");
                custom_alert_popup("Selected file type should csv only.")
            } else if (this.files[0].size > (2 * 1024 * 1000))
            {
                $("#myfile").val("");
                span[0].innerHTML = "";
                custom_alert_popup("Selected file size should be less than 20MB.")
            }
        }
    }
</script>