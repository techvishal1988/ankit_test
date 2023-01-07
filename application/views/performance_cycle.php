<style type="text/css">
.blackk{color: #fff !important; background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}
.disabled {
    pointer-events:none; //This makes it not clickable
    opacity:0.6;         //This grays it out to look disabled
}
.form-horizontal .control-label{font-size: 13px !important;}
.mailbox-content h4{font-size: 16px;}
.mailbox-content table tr th, .mailbox-content tbody tr td{font-size: 13px !important;}
</style>
<script type="text/javascript">
function set_plan_type(obj)
{
  <?php if(isset($edit_dtls_disable) and $edit_dtls_disable){?> return; <?php } ?>
  $('label li').removeClass('blackk');
  $("#"+obj).addClass('blackk')
}
</script>


<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid"> 
    <div class="row">
      <div class="col-sm-8" style="padding-left: 0px;">
        <ol class="breadcrumb">
            <!--<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
            <li class="active">Design Compensation Plans</li>
        </ol>
      </div>
      <div class="col-sm-4"></div>
     </div>
    </div>    
</div>

<div id="main-wrapper" class="container-fluid compp_fluid">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">

    <div class="col-sm-12">
	 <?php $tooltip=getToolTip('design-reward-plans');$val=json_decode($tooltip[0]->step);
		   if(helper_have_rights(CV_PERFORMANCE_CYCLE_ID, CV_INSERT_RIGHT_NAME)) { ?>
        <div class="panel panel-white">
            <div class="panel-body">
                <span id="spn_error_msg"> <?php echo $msg; ?> </span>
                <div id="inactive-msg"></div>
                <form class="form-horizontal" method="post" action="">
                    <?php echo HLP_get_crsf_field();

                        $cur_pointer = "cursor:pointer;";
                        if(isset($edit_dtls_disable) && $edit_dtls_disable){ $cur_pointer = "";}
                    ?>

                    <div class="plans clearfix">
                        <ul class="clearfix" >
                            <?php if(get_module_status('salary_module')) { ?>
                                <a href="#">
                                    <label style=" <?php echo $cur_pointer; ?>" onclick="set_plan_type('lbl_salary');" class="solid">
                                        <li class="wow animated flipInX" data-wow-delay=".5s" id="lbl_salary" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID){ echo 'class="blackk"';} ?> ><input name="ddl_type" type="radio" value="<?php echo CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID; ?>" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID){ echo 'checked="checked"';} ?> /> Annual Salary Review <br>Plan</li>
                                    </label>
                                </a>
                            <?php } else { ?>
                                <a>
                                    <label style=" <?php echo $cur_pointer; ?>" class="solid">
                                        <li class="wow animated flipInX inactive_plans" data-wow-delay=".5s" id="lbl_salary" > Annual Salary Review <br>Plan</li>
                                    </label>
                                </a>
                            <?php } ?>
                            <?php if(get_module_status('bonus_module')) { ?>
                                <a href="#">
                                    <label style=" <?php echo $cur_pointer; ?>" onclick="set_plan_type('lbl_bonus');" class="solid">
                                        <li class="wow animated flipInX" data-wow-delay=".5s"  id="lbl_bonus" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID){ echo 'class="blackk"';} ?>><input name="ddl_type" type="radio" value="<?php echo CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID; ?>" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID){ echo 'checked="checked"';} ?> required />Annual Bonus/Incentive<br> Review Plan</li>
                                    </label>
                                </a>
                            <?php } else { ?>
                                <a>
                                    <label style=" <?php echo $cur_pointer; ?>" class="solid">
                                        <li class="wow animated flipInX inactive_plans" data-wow-delay=".5s" id="lbl_salary" > Annual Bonus/Incentive<br> Review Plan</li>
                                    </label>
                                </a>
                            <?php } ?>
                            <?php if(get_module_status('sip_module')) { ?>
                                <a href="#">
                                    <label style=" <?php echo $cur_pointer; ?>" onclick="set_plan_type('lbl_sip');" class="solid">
                                        <li class="wow animated flipInX" data-wow-delay=".5s"  id="lbl_sip" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_SALES_ID){ echo 'class="blackk"';} ?> ><input name="ddl_type" type="radio" value="<?php echo CV_PERFORMANCE_CYCLE_SALES_ID; ?>" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_SALES_ID){ echo 'checked="checked"';} ?> />Sales Incentive<br> Plan</li>
                                    </label>
                                </a>
                            <?php } else { ?>
                                <a>
                                    <label style=" <?php echo $cur_pointer; ?>" class="solid">
                                        <li class="wow animated flipInX inactive_plans" data-wow-delay=".5s" id="lbl_salary" > Sales Incentive<br> Plan</li>
                                    </label>
                                </a>
                            <?php } ?>
                            <?php if(get_module_status('lti_module')) { ?>
                                <a href="#">
                                    <label style=" <?php echo $cur_pointer; ?>" onclick="set_plan_type('lbl_lti');" class="solid">
                                        <li class="wow animated flipInX" data-wow-delay=".5s"  id="lbl_lti" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_LTI_TYPE_ID){ echo 'class="blackk"';} ?> ><input name="ddl_type" type="radio" value="<?php echo CV_PERFORMANCE_CYCLE_LTI_TYPE_ID; ?>" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_LTI_TYPE_ID){ echo 'checked="checked"';} ?> />Long Term Incentive <br>Plan</li>
                                    </label>
                                </a>
                            <?php } else { ?>
                                <a>
                                    <label style=" <?php echo $cur_pointer; ?>" class="solid">
                                        <li class="wow animated flipInX inactive_plans" data-wow-delay=".5s" id="lbl_salary" > Long Term Incentive <br>Plan</li>
                                    </label>
                                </a>
                            <?php } ?>
                            <?php if(get_module_status('rnr_module')) { ?>
                                <a href="#">
                                    <label style=" <?php echo $cur_pointer; ?>" onclick="set_plan_type('lbl_rr');" class="solid">
                                        <li class="wow animated flipInX" data-wow-delay=".5s"  id="lbl_rr" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID){ echo 'class="blackk"';} ?>><input name="ddl_type" type="radio" value="<?php echo CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID; ?>" <?php if(isset($edit_dtls) and $edit_dtls["type"] == CV_PERFORMANCE_CYCLE_R_AND_R_TYPE_ID){ echo 'checked="checked"';} ?> />Rewards & Recognition<br> Plan</li>
                                    </label>
                                </a>
                            <?php } else { ?>
                                <a>
                                    <label style=" <?php echo $cur_pointer; ?>" class="solid">
                                        <li class="wow animated flipInX inactive_plans" data-wow-delay=".5s" id="lbl_salary" > Rewards & Recognition<br> Plan</li>
                                    </label>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">

                    <div class="form-group my-form wow animated fadeInDown" data-wow-delay=".8s">
                        <label for="inputEmail3" class="col-sm-3 col-xs-12 control-label removed_padding paddingSam">Plan Name <!-- <span  type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php //echo $val[0] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span> --></label>
                        <div class="col-sm-9 col-xs-12 form-input removed_padding">
                            <input id="txt_performance_cycle_name" name="txt_performance_cycle_name" type="text" class="form-control" required="required" maxlength="100" value="<?php if(isset($edit_dtls)){echo $edit_dtls["name"];} ?>">
                        </div>
                    </div>

                    <div class="form-group my-form wow animated fadeInDown" data-wow-delay=".9s">
                        <label for="inputEmail3" class="col-sm-3 col-xs-12 control-label removed_padding paddingSam">Start Date <!-- <span  type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php //echo $val[1] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span> --></label>
                        <div class="col-sm-9 col-xs-12 form-input removed_padding">
                            <input id="txt_start_dt" name="txt_start_dt" type="text" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" onblur="checkDateFormat(this)" value="<?php if(isset($edit_dtls) and $edit_dtls["start_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($edit_dtls["start_date"]));} ?>" autocomplete="off" <?php if(isset($edit_dtls_disable) and $edit_dtls_disable){ echo '';} ?>>
                            <!-- <input id="txt_start_dt" name="txt_start_dt" type="text" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" onblur="checkDateFormat(this)" value="<?php if(isset($edit_dtls) and $edit_dtls["start_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($edit_dtls["start_date"]));} ?>" autocomplete="off" onkeypress="return false;" <?php if(isset($edit_dtls_disable) and $edit_dtls_disable){ echo '';} ?>> -->
                        </div>
                    </div>
                    <div class="form-group my-form wow animated fadeInDown" data-wow-delay="1s">
                        <label for="inputEmail3" class="col-sm-3 col-xs-12 control-label removed_padding paddingSam">End Date <!-- <span  type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php //echo $val[2] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span> --></label>
                        <div class="col-sm-9 col-xs-12 form-input removed_padding">
                            <input id="txt_end_dt" name="txt_end_dt" type="text" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" onblur="checkDateFormat(this)" value="<?php if(isset($edit_dtls) and $edit_dtls["end_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($edit_dtls["end_date"]));} ?>" autocomplete="off">

                            <!-- <input id="txt_end_dt" name="txt_end_dt" type="text" class="form-control" required="required" maxlength="10" onchange="CheckFromDateToDate('txt_start_dt','txt_end_dt');" onblur="checkDateFormat(this)" value="<?php if(isset($edit_dtls) and $edit_dtls["end_date"] != "0000-00-00"){ echo date('d/m/Y', strtotime($edit_dtls["end_date"]));} ?>" autocomplete="off" onkeypress="return false;"> -->
                        </div>
                    </div>

                   <div class="form-group my-form wow animated fadeInDown" data-wow-delay="1.1s" style="display:none;">
                        <label for="inputEmail3" class="col-sm-3 col-xs-12 control-label removed_padding paddingSam">Description <span  type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[4] ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
                        <div class="col-sm-9 col-xs-12 form-input removed_padding">
                            <input id="txt_description" name="txt_description" type="text" class="form-control" value="<?php if(isset($edit_dtls)){echo $edit_dtls["description"];} ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-10 col-sm-2 text-right wow animated fadeInDown" data-wow-delay="1.2s">
                            <input type="submit" id="btnAdd" value="<?php if(isset($edit_dtls)){echo "Update";}else{ echo "Add";} ?>" class="btn btn-success" />
                            <!--<button class="btn btn-success">Cancel</button>-->
                        </div>
                    </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
<?php } ?>
    	<div class="col-md-12 background-cls wow animated fadeInUp" data-wow-delay=".9s">
        	<?php if(get_module_status('salary_module') && $salary_cycles_list){?>
            	<div class="mailbox-content" style="overflow-x:auto">
                    <h4 id="cyc" style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px;"> Existing Annual Salary Review Plans</h4>
                    <div class="table-responsive">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th class="hidden-xs" width="5%">S.No</th>
                                <th width="36%">Plan Name</th>
                                <!--<th>Cycle Type</th>-->
                                <th width="9%">Start Date</th>
                                <th width="9%">End Date</th>
                                <!--<th>Description</th>-->
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                         <?php $i=0;
                             foreach($salary_cycles_list as $row)
                             {
                                $id = $row["id"];
                                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                                echo "<td>".$row["name"]."</td>";
                               /* echo "<td>";
                                if($row["type"] == CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID)
                                {
                                     echo "Bonus";
                                }
                                elseif($row["type"] == CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID)
                                {
                                     echo "Salary";
                                }
                                echo "</td>";*/

                                if($row["start_date"] != '0000-00-00')
                                {
                                     echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
                                }
                                else
                                {
                                     echo "<td></td>";
                                }
                                if($row["end_date"] != '0000-00-00')
                                {
                                    echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                                }
                                else
                                {
                                   echo "<td></td>";
                                }

                                //echo "<td>".$row["description"]."</td>";
                                echo "<td>";
								if(helper_have_rights(CV_PERFORMANCE_CYCLE_ID, CV_INSERT_RIGHT_NAME))
								{
									echo "<a  href='".site_url("performance-cycle/".$row["id"]."")."'>Edit</a> |";
									if(!$row["salary_rules_count"])
									{ ?>
									
                                        <a href="<?php echo site_url("performance-cycle/".$row["id"]."/1"); ?>">Delete</a> |
									<?php }
								}
                               /* if($row["type"] == CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID)
                                {
                                     echo "<a href='".site_url("bonus-rule-list/$id")."'>Bonus Rules</a>";
                                }
                                elseif($row["type"] == CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID)
                                {*/
                                     echo "<a href='".site_url("salary-rule-list/".$row["id"]."")."'>
                                     Annual Salary Review Plan Rules</a> ";
                                     echo " | <a href='".site_url("performance_cycle/coverage/".$row["id"]."/salary")."'>Employees Covered</a> ";
                                //}
                               // echo "<a href='".site_url("salary-rule-list/".$row["id"]."")."'>Salary Rules</a>";
                               // echo " | <a href='".site_url("bonus-rule-list/$id")."'>Bonus Rules</a>";
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                             }
                         ?>
                        </tbody>
                       </table>
            </div>
            </div>
            <?php } ?>

            <?php if(get_module_status('bonus_module') && $bonus_cycles_list){?>
            	<div class="mailbox-content" style="overflow-x:auto">
                    <h4 id="bons"  style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px;">Existing Annual Bonus/Incentive Review Plans</h4>
                    <div class="table-responsive">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th class="hidden-xs" width="5%">S.No</th>
                                <th width="36%">Plan Name</th>
                                <th width="9%">Start Date</th>
                                <th width="9%">End Date</th>
                                <!--<th>Description</th>-->
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                         <?php $i=0;
                             foreach($bonus_cycles_list as $row)
                             {
                                $id = $row["id"];
                                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                                echo "<td>".$row["name"]."</td>";

                                if($row["start_date"] != '0000-00-00')
                                {
                                     echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
                                }
                                else
                                {
                                     echo "<td></td>";
                                }
                                if($row["end_date"] != '0000-00-00')
                                {
                                    echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                                }
                                else
                                {
                                   echo "<td></td>";
                                }

                               // echo "<td>".$row["description"]."</td>";
                                echo "<td>";
                                echo "<a  href='".site_url("performance-cycle/".$row["id"]."")."'>Edit</a> | ";
								if(!$row["bonus_rules_count"])
								{
									echo "<a  href='".site_url("performance-cycle/".$row["id"]."/1")."'>Delete</a> | ";
								}
                               /* if($row["type"] == CV_PERFORMANCE_CYCLE_BONUS_TYPE_ID)
                                {*/
                                     echo " <a href='".site_url("bonus-rule-list/$id")."'>Annual Bonus/Incentive Review Plan Rules</a>";
                                     echo " | <a href='".site_url("performance_cycle/coverage/".$id."/bonus")."'>Employees Covered</a>";
                                /*}
                                elseif($row["type"] == CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID)
                                {
                                     echo "<a href='".site_url("salary-rule-list/".$row["id"]."")."'>Salary Rules</a>";
                                }*/
                               // echo "<a href='".site_url("salary-rule-list/".$row["id"]."")."'>Salary Rules</a>";
                               // echo " | <a href='".site_url("bonus-rule-list/$id")."'>Bonus Rules</a>";
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                             }
                         ?>
                        </tbody>
                       </table>
            </div>
            </div>
            <?php } ?>

            <?php if(get_module_status('sip_module') && $sale_cycles_list){?>
            	<div class="mailbox-content" style="overflow-x:auto">
                    <h4 id="bons"  style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px;">Existing Sales Incentive Plans</h4>
                    <div class="table-responsive">
                        <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                    <th class="hidden-xs" width="5%">S.No</th>
                                    <th width="36%">Plan Name</th>
                                    <th width="9%">Start Date</th>
                                    <th width="9%">End Date</th>
                                    <!--<th>Description</th>-->
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                             <?php $i=0;
                                 foreach($sale_cycles_list as $row)
                                 {
                                    $id = $row["id"];
                                    echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                                    echo "<td>".$row["name"]."</td>";

                                    if($row["start_date"] != '0000-00-00')
                                    {
                                         echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
                                    }
                                    else
                                    {
                                         echo "<td></td>";
                                    }
                                    if($row["end_date"] != '0000-00-00')
                                    {
                                        echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                                    }
                                    else
                                    {
                                       echo "<td></td>";
                                    }

                                    //echo "<td>".$row["description"]."</td>";
                                    echo "<td>";
                                    echo "<a href='".site_url("performance-cycle/".$row["id"]."")."'>Edit</a> | ";
                                    if(!$row["sip_rules_count"])
                                    {
                                        echo "<a  href='".site_url("performance-cycle/".$row["id"]."/1")."'>Delete</a> | ";
                                    }

									 echo "<a href='".site_url("sip-rule-list/$id")."'>Sales Incentive Plan Rules</a>";
									 echo " | <a href='".site_url("performance_cycle/coverage/".$id."/sip")."'>Employees Covered</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $i++;
                                 }
                             ?>
                            </tbody>
                           </table>
            		</div>
            	</div>
            <?php } ?>

            <?php if(get_module_status('lti_module') && $lti_cycles_list){?>
            <div class="mailbox-content" id="ltiplan" style="overflow-x:auto">
                    <h4 id="lti"  style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px;">Existing Long Term Incentive Plans</h4>
                    <div class="table-responsive">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th class="hidden-xs" width="5%">S.No</th>
                                <th width="36%">Plan Name</th>
                                <th width="9%">Start Date</th>
                                <th width="9%">End Date</th>
                                <!--<th>Description</th>-->
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                         <?php $i=0;
                             foreach($lti_cycles_list as $row)
                             {
                                $id = $row["id"];
                                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                                echo "<td>".$row["name"]."</td>";

                                if($row["start_date"] != '0000-00-00')
                                {
                                     echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
                                }
                                else
                                {
                                     echo "<td></td>";
                                }
                                if($row["end_date"] != '0000-00-00')
                                {
                                    echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                                }
                                else
                                {
                                   echo "<td></td>";
                                }

                                //echo "<td>".$row["description"]."</td>";
                                echo "<td>";
                                echo "<a  href='".site_url("performance-cycle/".$row["id"]."")."'>Edit</a> | ";
								if(!$row["lti_rules_count"])
								{
									echo "<a  href='".site_url("performance-cycle/".$row["id"]."/1")."'>Delete</a> | ";
								}
                                echo "<a  href='".site_url("lti-rule-list/$id")."'>Long Term Incentive Plan Rules</a>";
                                 echo " | <a href='".site_url("performance_cycle/coverage/".$id."/lti")."'>Employees Covered</a>";
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                             }
                         ?>
                        </tbody>
                       </table>
            </div>
            </div>
            <?php } ?>

            <?php if(get_module_status('rnr_module') && $rnr_cycles_list){?>
            <div class="mailbox-content" id="rnrplan" style="overflow-x:auto">
                    <h4 style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px;">Existing Reward & Recognition Plans</h4>
                    <div class="table-responsive">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>
                                <th class="hidden-xs" width="5%">S.No</th>
                                <th width="36%">Plan Name</th>
                                <th width="9%">Start Date</th>
                                <th width="9%">End Date</th>
                                <!--<th>Description</th>-->
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">
                         <?php $i=0;
                             foreach($rnr_cycles_list as $row)
                             {
                                $id = $row["id"];
                                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                                echo "<td>".$row["name"]."</td>";

                                if($row["start_date"] != '0000-00-00')
                                {
                                     echo "<td class='text-center'>".date("d/m/Y", strtotime($row["start_date"]))."</td>";
                                }
                                else
                                {
                                     echo "<td></td>";
                                }
                                if($row["end_date"] != '0000-00-00')
                                {
                                    echo "<td class='text-center'>".date("d/m/Y", strtotime($row["end_date"]))."</td>";
                                }
                                else
                                {
                                   echo "<td></td>";
                                }

                                //echo "<td>".$row["description"]."</td>";
                                echo "<td>";
                                echo "<a href='".site_url("performance-cycle/".$row["id"]."")."'>Edit</a> | ";
								if(!$row["rnr_rules_count"])
								{
									echo "<a  href='".site_url("performance-cycle/".$row["id"]."/1")."'>Delete</a> | ";
								}
                                echo "<a  href='".site_url("rnr-rule-list/$id")."'>Reward & Recognition Plan Rules</a>";
                                 echo " | <a  href='".site_url("performance_cycle/coverage/".$id."/rnr")."'>Employees Covered</a>";
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                             }
                         ?>
                        </tbody>
                       </table>
            </div>
            </div>
            <?php } ?>



        </div>
</div>
</div>
<style>
h4{margin-bottom:0px}
/* .plans ul a li{height:62px; padding: 6px 15px; border-radius: 60px; background-color: rgb(78,94,106, .8); color: #fff; border:2px solid #fff;}
.plans ul a li:hover{background-color: rgb(78,94,106, .3); }
.plans ul a label{line-height: 20px; font-weight: bold; font-size: 13px;} */
.removed_padding input{background-color: unset !important; border:none;}

</style>
<script>

$(document).ready(function()
{
    $( "#txt_start_dt,#txt_end_dt" ).datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
       // yearRange: "1995:new Date().getFullYear()",
     });
 });

function CheckFromDateToDate(FromDate, ToDate)
{
	document.getElementById("spn_error_msg").innerHTML ="";
    var sessionLanguage;
    var str1 = document.getElementById(FromDate).value; //Fromdate
    var str2 = document.getElementById(ToDate).value;  //todate

    var sptdate1 = str1.replace("-", "/").replace("-", "/").split("/");
    var sptdate2 = str2.replace("-", "/").replace("-", "/").split("/");
    var datestring1 = sptdate1[1] + "/" + sptdate1[0] + "/" + sptdate1[2];
    var datestring2 = sptdate2[1] + "/" + sptdate2[0] + "/" + sptdate2[2];
    var date1 = new Date(datestring1)
    var date2 = new Date(datestring2);
    if (date2 < date1)
    {
        //alert("Start date must be less than end date.");
		document.getElementById("spn_error_msg").innerHTML ="<div align='left' style='color:red;'><b>Start date must be less than end date.</b></div>";
        document.getElementById(FromDate).value = "";
		play_msg("Start date must be less than end date.");
        return false;
    }
    else {
        return true;
    }
}
</script>

<!-- Common popup to give a alert msg Start -->
<script type="text/javascript">
<?php if($this->session->flashdata("message")){?>
$("#common_popup_for_alert").html('<?php echo "".$this->session->flashdata("message").""; ?>');
    $.magnificPopup.open({
        items: {
            src: '#common_popup_for_alert'
        },
        type: 'inline'
    });
setTimeout(function(){ $('#common_popup_for_alert').magnificPopup('close');}, 3000);
<?php } ?>
</script>
<!--  Common popup to give a alert msg End -->
<style type="text/css">
.mailbox-content table tr td{color: #000 !important;}
 /* a.rulebtn{ margin-right:3px; transition: .5s; display:inline-block; font-size:11px !important; border-radius:       4px; margin-bottom: 3px !important; color: #000 !important; padding: 3px 6px !important;           text-decoration: none !important; border:1px solid rgb(78,94,106, .1);
            background-color: rgb(78,94,106, .1)}
 a.rulebtn:hover{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;
                  color: #fff !important; border:1px solid red;
                 -webkit-box-shadow: 4px 4px 5px 0px rgba(191,191,191,1);
                 -moz-box-shadow: 4px 4px 5px 0px rgba(191,191,191,1);
                 box-shadow: 4px 4px 5px 0px rgba(191,191,191,1);} */
</style>
