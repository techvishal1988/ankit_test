<!-- Bootstrap core CSS -->
<link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
<style>
    .bg {
        background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
        background-size: cover;
    }
    .card-1 {
        background: url(<?php echo base_url() ?>assets/salary/img/card-1.png);
        background-size: cover;
        padding: 5px;
        padding-top: 5px;
        /*margin-top: 6px;*/
        /*padding-bottom: 29px;*/
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }
    .card-1-c {
        background: url(<?php echo base_url() ?>assets/salary/img/c1-cricle.png);
        //width: 65%; /*Shumsul*/
        width: 70px;
        display: block;
        height: 70px;
        background-size: cover;
        text-align: center;
        padding-top: 28px;
        color: #fff;
        margin-top: -20px;

    }
    .black-card-1 {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        background: url(<?php echo base_url() ?>assets/salary/img/black-card.png);
        background-size: cover;
        color: #fff;
        padding: 5px 30px;
        background-repeat: no-repeat;
        padding-bottom: 23px;
        margin-bottom: 10px;
        /*Shumsul*/
        border-radius: 17px;
        background-attachment: scroll;
    }
    .card-1-c2 {
        background: url(<?php echo base_url() ?>assets/salary/img/c2-cricle.png);
        //width: 65%; /*Shumsul*/
        width: 70px;
        display: block;
        height: 70px;
        background-size: cover;
        text-align: center;
        padding-top: 25px;
        color: #fff;
        padding-left: 2px;
        margin-top: -15px;
    }
    #salary_movement_chart, #comparison_with_peers, #current_market_positioning, #comparison_with_team {
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .pcc, .pc {
        padding-left: 0px;
        width: 110px;
        position: absolute;
        background: transparent;
        border: none;
        border-bottom: solid gray 1px;
        margin-left: 5px;
        text-align: right;
    }
    #per {

        float: left;  /*Shumsul*/
    }
    .pcc {
        width: 60px;
        text-align:right;
    }
    .perEdit {
        margin-left: 65px !important;
    }
    #spercentage {
        float: left;
        font-size: 20px;
        margin-left: 5px;
    }
    .pc:focus, .pcc:focus {
        outline: none;
    }
    #txt_citation, .customcls {
        background: transparent;
        width: 100%;
        border: none;
        border-bottom: solid gray 1px;
        display: none;
        color: orange;
    }
    .promoprice, .promoper {
        padding-left: 0px;
        width: 110px;
        position: absolute;
        background: transparent;
        border: none;
        border-bottom: solid gray 1px;
        margin-left: 5px;
        text-align: right;
    }
    #prompers {
        float: right;
    }
    .promoper {
        width: 65px;
        text-align: right;
        font-size: 20px;
    }
    #promper {
        float: left;
        margin-left: 10px;
    }
    .promoper:focus, .promoprice:focus, .customcls:focus, #txt_citation:focus {
        outline: none;
    }
    .mycls {
        display: none;
    }
    .customcls {
        width: 78%;
    }
    .comp {
        background: #fff;
        text-align: center;
        margin-top: -11px;
    }
    .popoverlay {
        width:100%;
        height:100%;
        display:none;
        position:fixed;
        top:0px;
        left:0px;
        background:rgba(0, 0, 0, 0.75);
        z-index: 9;
    }
    .black-card-1 h2 {
        margin-top: 20px !important;
    }
    .card-2 {
        padding-top: 10px !important;
    }
    /*Start shumsul*/
    .page-inner {
        padding:0 0 40px;
        background: url(<?php echo $this->session->userdata('company_bg_img_url_ses');
?>) 0 0 no-repeat !important;
        background-size: cover !important;
    }
    /*End shumsul*/
    .map-2, .map-1 {
        text-align:center;
    }
    .bg {
        margin: 15px 0 45px 0;
    }
    .box-cls{
        padding: 5px 15px !important;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/style3.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.min.css">


<div id="popoverlay" class=" popoverlay"></div>
<div class="bg">

    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn" style="position: absolute;    z-index: 1;"> <i class="glyphicon glyphicon-align-left"></i> <span>List</span> </button>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div id="sidebar">
                    <div id="dismiss"> <i class="glyphicon glyphicon-arrow-left"></i> </div>
                    <div>
                        <h2 style="margin-left: 5px;">Employee list</h2>
                        <?php if ($staff_list) {
                            ?>
                            <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th><?php echo "Name/Email"; ?></th>
                                      
                                    </tr>
                                </thead>
                                <tbody id="tbl_body">
                                    <?php
                                    for ($i = 0; $i < count($staff_list); $i++) {
                                        $emparr = get_emp_val($staff_list[$i]['user_id']);
                                        if($emparr['name']!=""){ $empval =  $emparr['name']; }else{ $empval= $emparr['email'];}
                                        
                   echo "<td><a href='" . site_url("admin/admin_dashboard/employee_graph_update/" . $emparr['id']) . "'>" . $empval. " </a></td>";
                                        
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-white">
                    <?php
                    $empnewarr = get_emp_val($user_id);
                   
                    ?>
                    <h3><?php if($empnewarr['name']!=""){ echo $empnewarr['name']; }else{ echo $empnewarr['email'];} ?></h3>
                    <?php
                    echo $this->session->flashdata('message');
                    if (@$msg) {
                        echo @$msg;
                    }
                    ?>   
                            <?php // echo '<pre />'; print_r($esg);  ?>
                    <div class="panel-body">
                        <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="">
<?php echo HLP_get_crsf_field(); ?>
                            <input type="hidden" name="Esg_id" value="<?php echo $Esg_id ?>" />
                            <input type="hidden" name="userids" value="<?php echo $this->session->userdata('userIDGraph') ?>" />
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Left panel section start -->
                                    <h3>Left Section</h3>
                                    <?php
                                     $left = json_decode($employee_graph_details['left_half']);
                                   
                                    ?>
                                    <div class="form-group no_mar left extra_edit">
                                        <label for ="description" class="wht_lvl" > Top Left Content</label>
                                        <textarea  class="form-control" id="left" placeholder="Enter Description"> </textarea>
                                        <input type="hidden" name="left" id="desc_left" value=""/>
                                    </div>
                                    <div class="form-group no_mar left_center extra_edit">
                                        <label for ="description" class="wht_lvl" > Center Left Content</label>
                                        <textarea  class="form-control" id="left_center" placeholder="Enter Description"> </textarea>
                                        <input type="hidden" name="left_center" id="desc_left_center"/>
                                    </div>
                                    <div class="form-group no_mar left_bottom extra_edit">
                                        <label for ="description" class="wht_lvl" > Bottom Left Content</label>
                                        <textarea  class="form-control" id="left_bottom" placeholder="Enter Description"> </textarea>
                                        <input type="hidden" name="left_bottom" id="desc_left_bottom"/>
                                    </div>
                                    <!-- Left panel section end -->
                                </div>
                                <div class="col-md-6">
                                    <!-- Right panel section start -->
                                    <h3>Right Section</h3>
                                    <?php  $right = json_decode($employee_graph_details['right_half']); ?>
                                    <div class="form-group no_mar right extra_edit">
                                        <label for ="description" class="wht_lvl"> Top Right Content</label>
                                        <textarea  class="form-control" id="right" placeholder="Enter Description"> </textarea>
                                        <input type="hidden" name="right" id="desc_right"/>
                                    </div>

                                    <div class="form-group no_mar right_center extra_edit">
                                        <label for ="description" class="wht_lvl"> Center Right Content</label>
                                        <textarea  class="form-control" id="right_center" placeholder="Enter Description"> </textarea>
                                        <input type="hidden" name="right_center" id="desc_right_center"/>
                                    </div>

                                    <div class="form-group no_mar right_bottom extra_edit">
                                        <label for ="description" class="wht_lvl"> Bottom Right Content</label>
                                        <textarea  class="form-control" id="right_bottom" placeholder="Enter Description"> </textarea>
                                        <input type="hidden" name="right_bottom" id="desc_right_bottom"/>
                                    </div>
                                    <!-- Right panel section end -->
                                </div>
                            </div>

                            <input type="submit" name="update" value="Update" class="btn btn-primary pull-right" />
                        </form>
                    </div>



                </div>
            </div>
        </div>

    </div>
</div>
<link href="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.css" rel="stylesheet">
<script src="https://www.jqueryscript.net/demo/Responsive-WYSIWYG-Text-Editor-with-jQuery-Bootstrap-LineControl-Editor/editor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#left").Editor();
        $('#left').Editor('setText', '<?php echo $left->top_left; ?>');

        $("#left_center").Editor();
        $('#left_center').Editor('setText', '<?php echo $left->center_left; ?>');
        $("#left_bottom").Editor();
$('#left_bottom').Editor('setText', '<?php echo $left->bottom_left; ?>');
        $("#right").Editor();
        $('#right').Editor('setText', '<?php echo $right->top_right; ?>');

        $("#right_center").Editor();
        $('#right_center').Editor('setText', '<?php echo $right->center_right; ?>');
        $("#right_bottom").Editor();
         $('#right_bottom').Editor('setText', '<?php echo $right->bottom_right; ?>');


        $('form').submit(function () {
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
            if (data_left.length == 0) {
                custom_alert_popup('Please enter top left content');
                err++;
            } else if (data_left_center.length == 0) {
                custom_alert_popup('Please enter center left content');
                err++;
            } else if (data_left_bottom.length == 0) {
                custom_alert_popup('Please enter bottom left content');
                err++;
            } else if (data_right.length == 0) {
                custom_alert_popup('Please enter top right content');
                err++;
            } else if (data_right_center.length == 0) {
                custom_alert_popup('Please enter center right content');
                err++;
            } else if (data_right_bottom.length == 0) {
                custom_alert_popup('Please enter bottom right content');
                err++;
            }

            if (err == 0) {
                if (request_custom_confirm('frm_cstm_popup_cls_default')) {
                    return true;
                } else {
                    return false;
                }

            } else {
                $('#loading').css('display', 'none');
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

<script src="<?php echo base_url() ?>assets/flotter/jquery.mCustomScrollbar.concat.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').fadeOut();
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').fadeIn();
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
    $(document).ready(function () {
        $('#example').DataTable({
            "paging": false,
            "info": false,
            "searching": false
        });
    });

</script>