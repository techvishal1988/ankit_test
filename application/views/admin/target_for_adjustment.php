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
                                                                <h4>Band Wise Target for Adjustment</h4>
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
                                                                    <th>Calculation Type</th>
                                                                   <th>TFP-ORG</th>
                                                                   <th>TCC-ORG</th>
                                                                   <th>TFP-Business</th>
                                                                   <th>TCC-Business</th>
                                                                </tr>
                                                               

                                                            </thead>
                                                            <tbody>
                                                             
                                                                <?php for ($i = 0; $i < count($gradelist); $i++) { ?>
                                                                    <tr>
                                                                        <td><?php echo $gradelist[$i]['name'] ?></td>
                                                                         <?php $targetarr = get_target_for_adjustment_val($gradelist[$i]['id']);
 
                                                                             ?>
                                                                        <td>
                                                                            
                                                                            <select name="ddl_calculation_type_<?php echo $gradelist[$i]['id'] ?>" class="form-control mar_bot">
                                                                                <option value="1" <?php if($targetarr['calculation_type']==1){ echo "selected";} ?>>Average</option>
                                                                                <option value="2" <?php if($targetarr['calculation_type']==2){ echo "selected";} ?>>Higher</option>
                                                                                <option value="3" <?php if($targetarr['calculation_type']==3){ echo "selected";} ?>>Lower</option>
                                                                                
                                                                               </select>
                                                                        </td>
                                                                        
                                                                        <td>
                                                                            
                                                                            <select name="ddl_tfp_org_<?php echo $gradelist[$i]['id'] ?>" class="form-control mar_bot">
                                                                                <option value="">Select</option>
                                                                                <?php foreach ($market_salary as $msrow) { ?>
<option value='<?php echo $msrow["business_attribute_id"]; ?>' <?php if($targetarr['tfp_org']==$msrow["business_attribute_id"]){ echo "selected";} ?>><?php echo $msrow["display_name"] ?></option>
        <?php } ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="ddl_tcc_org_<?php echo $gradelist[$i]['id'] ?>" class="form-control mar_bot">
                                                                                <option value="">Select</option>
                                                                                <?php foreach ($market_salary as $msrow) { ?>
<option value='<?php echo $msrow["business_attribute_id"]; ?>' <?php if($targetarr['tcc_org']==$msrow["business_attribute_id"]){ echo "selected";} ?>><?php echo $msrow["display_name"] ?></option>
        <?php } ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="ddl_tfp_business_<?php echo $gradelist[$i]['id'] ?>" class="form-control mar_bot">
                                                                                <option value="">Select</option>
                                                                                <?php foreach ($market_salary as $msrow) { ?>
<option value='<?php echo $msrow["business_attribute_id"]; ?>' <?php if($targetarr['tfp_business']==$msrow["business_attribute_id"]){ echo "selected";} ?>><?php echo $msrow["display_name"] ?></option>
        <?php } ?>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="ddl_tcc_business_<?php echo $gradelist[$i]['id'] ?>" class="form-control mar_bot">
                                                                                <option value="">Select</option>
                                                                                <?php foreach ($market_salary as $msrow) { ?>
<option value='<?php echo $msrow["business_attribute_id"]; ?>' <?php if($targetarr['tcc_business']==$msrow["business_attribute_id"]){ echo "selected";} ?> ><?php echo $msrow["display_name"] ?></option>
        <?php } ?>
                                                                            </select>
                                                                        </td>
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
