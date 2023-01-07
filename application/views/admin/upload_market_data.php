<link rel="stylesheet" href="<?php echo base_url('assets/js/dist/fastselect.min.css');?>">
<script src="<?php echo base_url("assets/js/fastselect.standalone.js"); ?>"></script>
<style>
	.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
	border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
	.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
	border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
	.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
	.fstResultItem{ font-size:1em;}
	.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
	.fstControls{line-height:13px;}
	.fstControls{width: 39em !important;}
	.fstResults{position:inherit !important; z-index:999;}
	.form-horizontal .fstMultipleMode {padding-top: 3px !important;}
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active"><?php echo (isset($title)) ? $title : 'Manage'; ?></lti>
    </ol>
</div>

<div id="main-wrapper" class="container aop">
    <div class="row mb20">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-white">
                <?php echo $this->session->flashdata('message'); ?>  
                <div class="panel-body">
                    <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')" enctype="multipart/form-data" >
                        <?php echo HLP_get_crsf_field(); ?>
                        <div class="form-group my-form">
							<div class="col-sm-12 form-input removed_padding">
                                <select id="ddl_ba_names_to_upd_mkt_data" onchange="hide_list('ddl_ba_names_to_upd_mkt_data');" name="ddl_ba_names_to_upd_mkt_data[]" class="form-control multipleSelect" required="required" multiple="multiple">
                                    <option  value="all">All</option>
                                    <?php if($ba_names_to_upd_mkt_data_list){                                        
                                        foreach($ba_names_to_upd_mkt_data_list as $row){ ?>
                                    <option  value="<?php echo $row["ba_name"]; ?>" ><?php echo $row["display_name"]; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
						</div>
						<div class="form-group my-form">	
                            <div class="col-sm-12 form-input removed_padding">
                                <input type="file" name="myfile" id="myfile" class="form-control" title="Choose a file csv to upload" required accept="application/msexcel*">
                                <span class="upload-path" style=" display: none" ></span>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <input type="submit" name="btn_upload"  value="Upload" class="btn btn-success">
                                <a href="<?php echo base_url('download-market-data-sample-format-file'); ?>" class="downloadcsv"><input type="button" value="Download File Format" class="btn btn-success"></a>
                            </div>
                        </div> 

                    </form>
                </div>             

            </div>
        </div>

    </div>
    <?php if ($mkt_data_list) { ?>
        <div class="row mb20">
            <div class="col-md-12 background-cls" style="padding:10px !important;">
                <div class="table-responsive" style="  overflow-y: scroll;  height: 300px;">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th class="hidden-xs" width="5%">S.No</th>
                                <?php
                                foreach ($header_name_list as $ba_name) {
                                    echo "<th>" . $ba_name . "</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody id="tbl_body" >                   
                            <?php
                            $i = 0;
                            foreach ($mkt_data_list as $row) {
                                $k = 0;
                                echo "<td class='hidden-xs'>" . ($i + 1) . "</td>";
                                foreach ($ba_name_list as $ba_name) {
                                    if ($k > 13) {
                                        echo "<td>" . HLP_get_formated_amount_common($row[$ba_name]) . "</td>";
                                    } else {
                                        echo "<td>" . $row[$ba_name] . "</td>";
                                    }

                                    $k++;
                                }
                                echo "</tr>";
                                $i++;
                            }
                            ?>  

                        </tbody>
                    </table>                    
                </div>
            </div>
           
                <div class="col-sm-12 text-right background-cls">
                   
                    <a style="padding-right: 10px !important;" href="<?php echo base_url('market-data-export'); ?>" class="downloadcsv"><input type="button" value="Download" class="btn btn-success"></a>
                </div>
        
        </div>
    <?php } ?>
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

<script>        
$('.multipleSelect').fastselect();
function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
            	$(this).find(".fstChoiceRemove").trigger("click");
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
</script>