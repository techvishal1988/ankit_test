<style>
    @media screen and (max-width: 767px) {
        .overflowCss {
            overflow-x: scroll !important;
        }
    }
    .downloadcsv {
        text-decoration : none !important;
        color: #000;
    }
    .downloadcsv:hover {
        text-decoration : none !important;
        color: #000;
    }
    
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Salary Rules Upgrade Promotion</li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
    <h3>Upload File</h3>
</div>
</div> -->

<div id="main-wrapper" class="container">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <div class="row mb20">
        <div class="col-md-7 col-md-offset-3 ">
            <div class="panel panel-white">
                <div class="panel-body">
                    <?php
                    echo $this->session->flashdata('message');

                    $tooltip = getToolTip('upload-file');
                    $val = json_decode($tooltip[0]->step);
                    ?>
                    <form class="form-horizontal" method="post" action=" " enctype="multipart/form-data" >
                        <?php echo HLP_get_crsf_field(); ?>
                        <div class="form-group my-form no_bot_mar">
                            <div class="col-sm-11 form-input browse-wrap">
                                <div class="title">Select File to Upload Promotion and hikes</div>
                                <input type="file" name="myfile" id="myfile" class="form-control upload" title="Choose a file csv to upload"  accept="application/msexcel*">
                            </div>
                            <span class="upload-path"></span> </div>
                        <div class="upgrade_pro" style="    text-align: center;">

                       

                                <a href="<?php echo site_url('download-upgrade-promotion-sample-file/').$rule_dtls['id']; ?>" class="downloadcsv">
                                    <input type="button" value="Download Format" class="btn btn-success">
                                </a>


                                <input type="submit" id="btnAdd" name="btnsubmit" value="Submit" class="btn btn-success" />


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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