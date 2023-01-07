<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
<script type="text/javascript">
$(document).ready( function() {
$("#left").Editor();    
$('#left').Editor('setText','<?php echo @$esg[0]["left_half"] ?>');

$("#left_center").Editor();    
$("#left_bottom").Editor();

$("#right").Editor();    
$('#right').Editor('setText','<?php echo @$esg[0]["right_half"] ?>');

$("#right_center").Editor();    
$("#right_bottom").Editor();


$('#employee_graph_create').submit(function() {
    var data_left = $('.left #contentarea').html();
    $('#desc_left').val(data_left);

    var data_left_center = $('.left_center #contentarea').html();
    $('#desc_left_center').val(data_left_center);

    var data_left_bottom = $('.left_bottom #contentarea').html();
    $('#desc_left_bottom').val(data_left_bottom);
    
    var data_right = $('.right #contentarea').html();
    $('#desc_right').val(data_right);

    var data_right_center = $('.right_center #contentarea').html();
    $('#desc_right_center').val(data_right_center);

    var data_right_bottom = $('.right_bottom #contentarea').html();
    $('#desc_right_bottom').val(data_right_bottom);

    var err = 0;
    if(data_left.length == 0) {
        custom_alert_popup('Please enter top left content');
        err++;
    } else if(data_left_center.length == 0) {
        custom_alert_popup('Please enter center left content');
        err++;
    } else if(data_left_bottom.length == 0) {
        custom_alert_popup('Please enter bottom left content');
        err++;
    } else if(data_right.length == 0) {
        custom_alert_popup('Please enter top right content');
        err++;
    } else if(data_right_center.length == 0) {
        custom_alert_popup('Please enter center right content');
        err++;
    } else if(data_right_bottom.length == 0) {
        custom_alert_popup('Please enter bottom right content');
        err++;
    }
    
    if(err == 0) {
        if(request_custom_confirm('frm_cstm_popup_cls_default')){
            return true;
        } else {
            return false;
        }
        
    } else {
        $('#loading').css('display','none');
        return false;
    }
         
});



});
</script>
<style type="text/css">
    .Editor-editor{color: #fff;}
    .footer{margin-bottom: 0px;}
    h3{color: #fff;}
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li class="active">Employee Graph Create</li>
    </ol>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    
    <div class="col-md-12">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            <?php // echo '<pre />'; print_r($esg); ?>
            <div class="panel-body">
                <form id="employee_graph_create"  class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" >
                    <?php echo HLP_get_crsf_field();?>
                    <input type="hidden" name="Esg_id" value="<?php echo $Esg_id ?>" />
                    <input type="hidden" name="userids" value="<?php echo $this->session->userdata('userIDGraph') ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Left panel section start -->
                            <h3>Left Section</h3>
                            <div class="form-group no_mar left extra_edit">
                                <label for ="description" class="wht_lvl" > Top Left Content</label>
                                <textarea  class="form-control" id="left" placeholder="Enter Description"></textarea>
                                <input type="hidden" name="left" id="desc_left"/>
                            </div>
                            <div class="form-group no_mar left_center extra_edit">
                                <label for ="description" class="wht_lvl" > Center Left Content</label>
                                <textarea  class="form-control" id="left_center" placeholder="Enter Description"></textarea>
                                <input type="hidden" name="left_center" id="desc_left_center"/>
                            </div>
                            <div class="form-group no_mar left_bottom extra_edit">
                                <label for ="description" class="wht_lvl" > Bottom Left Content</label>
                                <textarea  class="form-control" id="left_bottom" placeholder="Enter Description"></textarea>
                                <input type="hidden" name="left_bottom" id="desc_left_bottom"/>
                            </div>
                            <!-- Left panel section end -->
                        </div>
                        <div class="col-md-6">
                            <!-- Right panel section start -->
                            <h3>Right Section</h3>
                            <div class="form-group no_mar right extra_edit">
                                <label for ="description" class="wht_lvl"> Top Right Content</label>
                                <textarea  class="form-control" id="right" placeholder="Enter Description"></textarea>
                                <input type="hidden" name="right" id="desc_right"/>
                            </div>

                            <div class="form-group no_mar right_center extra_edit">
                                <label for ="description" class="wht_lvl"> Center Right Content</label>
                                <textarea  class="form-control" id="right_center" placeholder="Enter Description"></textarea>
                                <input type="hidden" name="right_center" id="desc_right_center"/>
                            </div>

                            <div class="form-group no_mar right_bottom extra_edit">
                                <label for ="description" class="wht_lvl"> Bottom Right Content</label>
                                <textarea  class="form-control" id="right_bottom" placeholder="Enter Description"></textarea>
                                <input type="hidden" name="right_bottom" id="desc_right_bottom"/>
                            </div>
                            <!-- Right panel section end -->
                        </div>
                    </div>

                    <?php
                            if(@$esg[0]->Esg_id!='')
                            {
                                $btnName='update';
                                $btnCaption='Update';
                            }
                            else
                            {
                                $btnName='save';
                                $btnCaption='Save';
                            }
                    ?>
                    <input type="submit" name="<?php echo $btnName ?>" value="<?php echo $btnCaption ?>" class="btn btn-primary pull-right" />
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>
