<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active"><?php echo (isset($title)) ? $title : 'Manage'; ?></lti>
    </ol>
</div>

<div id="main-wrapper" class="container aop">
    <div class="row">
        <div class="col-md-12">
            <div class="mb20">
                
                <div class="panel panel-white">   
                    <?php echo $this->session->flashdata('message'); ?>  
                    <div class="panel-body">
                        <div class="rule-form">
                            <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                                <?php echo HLP_get_crsf_field(); ?>
                                <div class="form-group">
                                    <div class="">
                                        <div class="col-sm-12">
                                            <div class="form_head clearfix">
                                                <div class="col-sm-12">
                                                    <ul>
                                                        <li>
                                                            <div class="form_tittle">
                                                                <h4>Create Key Cross Cell Bonus (%age of Fixed Salary)</h4>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> 

                                            <div class="form_sec clearfix" id="dv_frm_head">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table style="margin-bottom:10px;" class="table table-bordered th-top-aln">
                                                            <thead>
                                                                <tr>
                                                                    <th>Business Group</th>
                                                                    <?php for ($i = 0; $i < count($functionlist); $i++) { ?>

                                                                        <th colspan="<?php echo $subcount[$i][0]['totalsub']; ?>"><?php echo $functionlist[$i]['name'] ?></th>

                                                                    <?php }
                                                                    ?>


                                                                </tr>
                                                                <tr>
                                                                    <th>AOP code</th>
                                                                    <?php
                                                                    for ($j = 0; $j < count($functionlist); $j++) {
                                                                        for ($k = 0; $k < count($subfunctionlist[$j]); $k++) {
                                                                            ?>
                                                                            <th colspan="1"><?php echo $subfunctionlist[$j][$k]['name']; ?></th>

                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?> 
                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <?php for ($l = 0; $l < count($gradelist); $l++) { ?>
                                                                    <tr>
                                                                        <td><?php echo $gradelist[$l]['name'] ?></td>
                                                                        <?php
                                                                        for ($j = 0; $j < count($functionlist); $j++) {
                                                                            for ($k = 0; $k < count($subfunctionlist[$j]); $k++) {
                                                                                ?>
                                                                                <?php $perval = get_key_cross_cell_per_old_val($gradelist[$l]['id'], $functionlist[$j]['id'], $subfunctionlist[$j][$k]['id']);
                                                                                ?>
                                                                                <td><input type="text" name="txt_per_val_<?php echo $subfunctionlist[$j][$k]['id'] . "_" . $functionlist[$j]['id'] . "_" . $gradelist[$l]['id'] ?>" value="<?php
                                                                                    if (isset($perval)) {
                                                                                        echo $perval;
                                                                                    } else {
                                                                                        echo 0;
                                                                                    }
                                                                                    ?>" class="form-control mar_bot" required="" onKeyUp="validate_percentage_onkeyup_common(this);" onBlur="validate_percentage_onblure_common(this);"  maxlength="5"></td>

                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?> 
                                                                    </tr>
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
                                        <input type="submit" id="btnAdd" value="Submit" class="btn mar_l_5 btn-success" />

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
