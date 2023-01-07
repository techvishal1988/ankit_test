<?php if($this->session->userdata("company_color_ses")){?>
 <style>
  .page-inner, .links{
    background: url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat;
    background-size: cover;
    background-attachment: fixed;
}   
 </style>   
<style type="text/css">



.panel-white,.mailbox-content{
    background: rgba(0,0,0,0.4);
    border: 0px !important;
}

.panel-white  p,.mailbox-content p {
    background: #fff;
    text-align: center;
    padding: 10px;
    font-size: 14px;
    margin-bottom: 0px;
/*  margin-top: 10px;*/
    }

.h4, .h5, .h6, h4, h5, h6{margin-top: 0px;}

.table{margin-bottom: 0px;}
    
.background-cls{
    background: rgba(0,0,0,0.4);
    padding-left: 0px;
    padding-right: 0px;
    padding-bottom: 10px;
    }

.background-cls .mailbox-content{background:transparent !important;}
.table {margin-bottom: 0px;padding-bottom: 10px;}

.mailbox-content,.panel-white{
    padding-top: 10px;
    padding-bottom: 0px;
    padding-left: 10px;
    padding-right: 10px;
    }

.background-cls p:not(:first-child){margin-top: 10px;}
#dv_release_list p{margin-top: 10px; }
#res .table .form-group .tinput{width: 95%;}
.dataTables_wrapper{margin-bottom: 0px;}
.qlbl,.anssurvey{text-align: left !important;}
.surveyquestion{
    padding-left: 15px !important;
    padding-right: 15px !important;
    }
    .myclsemp
    {
            background: #fff;
            padding: 10px;
            overflow: inherit;
    }
    .panel .panel-body
    {
        padding: 0px;
    padding-bottom: 10px;
    }
    .page-title
    {
        border-bottom: unset;
    }
    .custom-panel{
        padding: 10px
    }
    .btn{
		background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}
	
	
	.table tr td i,.themeclr {
        color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;
}
#dismiss{
        background-color: #<?php echo $this->session->userdata("company_color_ses"); ?> !important;
}
.beg_color input[type="radio"]+span:before{ border:2px #999 solid; background-color:#fff !important; }
.beg_color input[type="radio"]:hover + span:before{border:2px #<?php echo $this->session->userdata("company_color_ses"); ?> solid;}
.beg_color input[type="radio"]:checked + span:before{ content:"\2713" !important; background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important; color:#FFF !important; border:2px #<?php echo $this->session->userdata("company_color_ses"); ?> solid !important;}

.beg_color input[type="checkbox"]+span:before{border:2px #999 solid; background-color:#fff;
}
.beg_color input[type="checkbox"]:hover + span:before{border:2px #<?php echo $this->session->userdata("company_color_ses"); ?> solid;}
.beg_color input[type="checkbox"]:checked + span:before{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>; color:#FFF; border:2px #<?php echo $this->session->userdata("company_color_ses"); ?> solid;}

.form-control:focus
{
  box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?> !important;
  border: 2px solid #<?php echo $this->session->userdata("company_color_ses"); ?> !important;
} 

.control-label
{ 
    background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>;
    float: left;
    border-radius:unset;
    position: relative;
    text-align: left !important;
	padding-left:9px !important;
    line-height:34px;
    color:#fff;
    font-size:14px;
}  

.removed_padding
{
  padding: 0px !important;
} 
.form-horizontal .control-label{ text-align:left !important; padding-left:9px !important; padding-top:2px;}
.whitecls .fstChoiceItem{
    color:#fff;
}
.whitecls .fstChoiceItem .fstChoiceRemove{
    color:#fff;
}
.blackcls .fstChoiceItem{
    color:#000;
}
.whitecls .fstChoiceItem .fstChoiceRemove{
    color:#fff;
}
.controlwhitecls .control-label,.controlwhitecls .mailbox-content h4{
    color:#fff !important;
}
.controlblackcls .control-label,.controlblackcls .mailbox-content h4{
    color:#000 !important;
}
.black{
    color:#000 !important;
}
.white{
    color:#fff !important;
}

label span i{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}

<!--shumsul-->
.modal-header {
    background-color:#FF0101 !important;
    color: #fff;
    margin-bottom: 20px;
}

<!--shumsul-->

</style>
<?php }
if($this->session->userdata('role_ses')==1 || $this->session->userdata('role_ses')==3 || $this->session->userdata('role_ses')==10 || $this->session->userdata('role_ses')==5|| $this->session->userdata('role_ses')==11 || $this->session->userdata('role_ses')==4 || $this->session->userdata('role_ses')==6 || $this->session->userdata('role_ses')==9)
{
   
    echo "<style>.page-horizontal-bar.page-header-fixed .horizontal-bar{    padding-top: 0px !important;}}</style>";
}

?>

<!--This script is used for hide show menu bar togggle
<script>
$(document).ready(function(){
    $(".samBar").click(function(){
        $(".clsnav").toggle();
    });
	
	$(".samBar").click(function(){
        $('.page-inner').addClass('page-innerMargin');
    });
	

});
</script>
-->

<style>

/***pramod**/
.page-horizontal-bar .accordion-menu>li ul li.drop_submenup{position: relative; }
.page-horizontal-bar .accordion-menu>li ul li.drop_submenup ul.submenup{ width: 100%; /*max-height:150px; overflow-y:scroll;*/
    /*padding-left:4%;*/background-color: #000; /*transition: 5s ease-in-out!important;*/ }

.page-horizontal-bar .accordion-menu>li ul li.drop_submenup a i.iconb{float: right; margin-top: 3px;}
.page-horizontal-bar .accordion-menu>li ul li.drop_submenup a.manage_back{padding-right: 13px !important;}
.page-horizontal-bar .accordion-menu>li ul li.drop_submenup a i.iconp{float: right; margin-top: 0px; 
    font-size: 20px;}
/* .page-horizontal-bar .accordion-menu>li ul li.drop_submenup:hover>ul.submenup{
    display: inline-block!important;
    position: relative;
    top: 0px;
    background-color: #dcdcdc;
    width: 100%;
    padding-left:8%;
    border-right: 1px solid #dcdcdc;
 } */

 @media (max-width: 767px) {
.page-horizontal-bar.compact-menu .menu.accordion-menu ul{overflow:scroll; }
.page-horizontal-bar .accordion-menu>li ul li.drop_submenup >ul.submenup{
    position: relative;
    left: 0px;
    top: 0px !important;
    background-color: #dcdcdc;
    width: 100%;
}

}
/***pramod**/

 
    .sub-menu{
            left: auto !important;
    right: 100%;
    margin-left: 0px !important;
    margin-right: -35px !important;
}
 .sub-menup{
            left: auto !important;
    right: 100%;
    margin-left: 0px !important;
    margin-right: -35px !important;
}
.horizontal-bar .accordion-menu>li>ul{
     left: auto;
}
.horizontal-bar .accordion-menu li .cstman{
    left: 12px !important;
}


#dismiss{
        background-color: #<?php echo $this->session->userdata("company_color_ses"); ?> !important;
}
</style>

<script>
    
     function hex2rgb(hex) {
        // long version
        r = hex.match(/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i);
        if (r) {
                return r.slice(1,4).map(function(x) { return parseInt(x, 16); });
        }
        // short version
        r = hex.match(/^#([0-9a-f])([0-9a-f])([0-9a-f])$/i);
        if (r) {
                return r.slice(1,4).map(function(x) { return 0x11 * parseInt(x, 16); });
        }
        return null;
  }
    //Color text change
  $('label').addClass('ractive');
   
 function setcolor(){
    var rc=hex2rgb('#<?php echo $this->session->userdata("company_color_ses"); ?>').toString();
    
    var rgb = rc.split(',');
    var c = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
    
    //http://www.w3.org/TR/AERT#color-contrast
    var o = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);
    if(o > 125) {
    // if(o > 135) {
       $('#myPage').addClass('blackcls');
       $('.mailbox-content h4').addClass('black');
        $('label').addClass('black');
        }else{ 
     
        $('#myPage').addClass('whitecls');
        $('.mailbox-content h4').addClass('white');
        $('label').addClass('white');
    }
    var r = Math.round(Math.random() * 255);
    var g = Math.round(Math.random() * 255);
    var b = Math.round(Math.random() * 255);

    rgb[0] = r;
    rgb[1] = g;
    rgb[2] = b;                
  

}

 function setcolorlabel(){
    var rc=hex2rgb('#<?php echo $this->session->userdata("company_light_color_ses"); ?>').toString();
    
    var rgb = rc.split(',');
    var c = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
    /*console.log(c);*/
    //http://www.w3.org/TR/AERT#color-contrast
    var o = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);
    //if(o > 125) {
    if(o > 135) {
       $('#myPage').addClass('controlblackcls');
        $('.mailbox-content h4').addClass('black');
        $('label').addClass('black');
        $('label.wht_lvl').addClass('white');
    }else{ 
     
        $('#myPage').addClass('controlwhitecls');
        $('.mailbox-content h4').addClass('white');
        $('label').addClass('white');

    }
    var r = Math.round(Math.random() * 255);
    var g = Math.round(Math.random() * 255);
    var b = Math.round(Math.random() * 255);

    rgb[0] = r;
    rgb[1] = g;
    rgb[2] = b;                
  

}


/*******set colour for table header text according to the background colour by adding class tablecustm********/

 function settabletxtcolor(){
    var rc=hex2rgb('#<?php echo $this->session->userdata("company_color_ses"); ?>').toString();
    
    var rgb = rc.split(',');
    var c = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
    
    //http://www.w3.org/TR/AERT#color-contrast
    var o = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);
   
    if(o > 125) {

        $('.tablecustm thead tr th').addClass('black');
        
        }else{ 

        $('.tablecustm thead tr th').addClass('white');
        }

    var r = Math.round(Math.random() * 255);
    var g = Math.round(Math.random() * 255);
    var b = Math.round(Math.random() * 255);

    rgb[0] = r;
    rgb[1] = g;
    rgb[2] = b;                 
}

/*******set colour for table header text according to the background colour by adding class tablecustm********/

/*******set colour for table header text according to the background colour by adding class tablecustm********/

 function common_txtcolor_set(){
    var rc=hex2rgb('#<?php echo $this->session->userdata("company_color_ses"); ?>').toString();
    
    var rgb = rc.split(',');
    var c = 'rgb('+rgb[0]+','+rgb[1]+','+rgb[2]+')';
    
    //http://www.w3.org/TR/AERT#color-contrast
    var o = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);
   
    if(o > 125) {

        $('.top-menu .navbar-nav li span, .top-menu .navbar-nav li b, input.btn, .btn, input[type=button], .table.rule-list tr td i, label span i, .jconfirm .jconfirm-box .jconfirm-buttons .btn-confirm-pop, .custom_icon_color i').addClass('black');
        /*$('table tr.custom_icon_color span i').css("color","#000 !important");*/
        }else{ 

        $('.top-menu .navbar-nav li span, .top-menu .navbar-nav li b, input.btn, .btn, input[type=button], .table.rule-list tr td i, label span i, .jconfirm .jconfirm-box .jconfirm-buttons .btn-confirm-pop, .custom_icon_color i').addClass('white');
        /*$('.custom_icon_color span i').css("color","#fff !important");*/
        }

    var r = Math.round(Math.random() * 255);
    var g = Math.round(Math.random() * 255);
    var b = Math.round(Math.random() * 255);

    rgb[0] = r;
    rgb[1] = g;
    rgb[2] = b;                 
}

/*******set colour for table header text according to the background colour by adding class tablecustm********/


//window.onload=setcolor(),setcolorlabel();
window.onload = setTimeout(function(){ setcolor(),setcolorlabel(),settabletxtcolor(),common_txtcolor_set(); }, 100);
</script>
<div class="navbar" style="background:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;">
    <div class="navbar-inner container-fluid pad30rl" >
        <div class="sidebar-pusher">
            <a href="javascript:void(0);"  class="waves-effect waves-button waves-classic push-sidebar samBar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    
        <div class="logo-box wow animated fadeInDown" data-wow-delay=".1s">
            <a href="<?php echo site_url("dashboard"); ?>" class="logo-text">
        
            <img src="<?php echo $this->session->userdata("company_logo_ses"); ?>" />

            <span style="display:none;"><?php if($this->session->userdata('companyname_ses')){echo $this->session->userdata('companyname_ses');}elseif(isset($title) and ($title) ){echo $title;}else{ echo "Dashboard"; } ?></span></a>
        </div><!-- Logo Box -->
		
       <!-- <div class="search-button">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
        </div>-->
        <div class="topmenu-outer" style="background:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;">
            <div class="top-menu">
                
                <ul class="nav navbar-nav navbar-right wow animated fadeInDown" data-wow-delay=".1s">
				
                    <?php $notifications = help_get_notifications(array("to_user_id"=>$this->session->userdata('userid_ses'), "is_readed"=>0)); ?>

                    <?php if(0 ){ ?>
					<li><a href="javascript:;" class="navbar-right" style="cursor:text;"><span style="font-size: 18px;">Welcome </span><b><?php echo $this->session->userdata('proxy_username_ses'); ?></b> <span class="menu-icon "></span>
                    
                    <?php if($this->session->userdata('proxy_userid_ses') != $this->session->userdata('userid_ses')){?>
                    <!-- <br /> -->
                   <span style="font-size: 15px;"> Proxy as</span> <b><?php echo $this->session->userdata('username_ses'); ?></b> 
                    <?php } ?>
                    </a>
                    
                    </li>

                    <?php } ?>

                    <?php if(!empty($this->session->userdata('userid_ses')) && !empty($this->session->userdata('proxy_userid_ses')) ){//user login ?>

                        <li>
                            <?php if($this->session->userdata('proxy_userid_ses') == $this->session->userdata('userid_ses')){//user ?>
                                <span class="cp_name">Welcome 
                                    <a href="<?php echo site_url("view-employee/".$this->session->userdata('userid_ses')); ?>"><b><?php echo $this->session->userdata('username_ses'); ?></b></a>
                                </span>
                            <?php } else {//proxy ?>
                                <span class="cp_name">Welcome <b><?php echo $this->session->userdata('proxy_username_ses'); ?></b> <span class="cp_name">Proxy as </span>
                                <b><a href="<?php echo site_url("view-employee/".$this->session->userdata('userid_ses')); ?>"><?php echo $this->session->userdata('username_ses'); ?></a></b> 
                            </span>
                            <?php }?>
                        </li>

                    <?php } ?>
                    
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
			
			
        </div>
    </div>
    <div class="page-sidebar sidebar horizontal-bar clsnav">
    <div class="container-fluid page-sidebar-inner">
        <ul class="menu accordion-menu wow animated fadeInDown" data-wow-delay=".5s">
            
			
			
			<li class="nav-heading"><span>Navigation</span></li>
			<?php if(helper_have_rights(CV_DASHBOARD_ID, CV_VIEW_RIGHT_NAME)){?>
                        <li style="float: left;"><a href="<?php echo site_url("dashboard"); ?>"><span class="menu-icon icon-home"></span></a></li>
                        
			
			<?php } ?>
                        <li style="    float: left; position: absolute;" class="droplink hr_settings hr-link"><a href="<?php echo base_url('dashboard/notifications') ?>" ><span class="menu-icon icon-bell" > <span class="badge badge-success pull-right" id="spn_notify_cnt"><?php if(isset($notifications) and ($notifications)){echo count($notifications);}else{echo "0";}?></span></span></a>
            </li>
                        <?php if($this->session->userdata('sub_session') < 10){
				
				if(helper_have_rights(CV_STAFF_ID, CV_VIEW_RIGHT_NAME)){?>
            <li><a href="<?php echo site_url("staff"); ?>"><p><span class="menu-icon icon-user"></span> <span class="hide-text">
                Employees</span></p></a></li>
			
			<?php } if(helper_have_rights(CV_PERFORMANCE_CYCLE_ID, CV_VIEW_RIGHT_NAME) && get_module_status('compensation_plan')){?>           
            <li class="droplink">
            <a href="<?php echo site_url("performance-cycle"); ?>"><p><span class="menu-icon icon-users"></span> <span class="hide-text">Compensation Plans</span></p><span class="arrow"></span></a>
            </li>
            <?php }} if($this->session->userdata('sub_session')<=10){
                if(helper_have_rights(CV_REPORTS, CV_VIEW_RIGHT_NAME) && get_module_status('analytics_module')){ ?>
                <li class="droplink hr_settings"><a href="javascript:void(0)"><p><span class="fa fa-bar-chart"></span><span class="hide-text"> Analytics/Reports</span></p></a>
                    <ul  class="sub-menu menueMar cstman repotrs_div">
                    <?php if(0 && helper_have_rights(CV_PAY_RANGE_ANALYSIS, CV_VIEW_RIGHT_NAME)) { ?>
                    <!--<li><a href="<?php echo site_url("report/grade/1"); ?>">Pay Range Analysis</a></li>-->
                    <?php } ?>
                    <?php if(0 && helper_have_rights(CV_ALLOCATED_BUDGET, CV_VIEW_RIGHT_NAME)) { ?>
                    <!--<li><a href="<?php echo site_url("report/budget"); ?>">Allocated Budget</a></li>-->
                    <?php } ?>
                      <?php if(0 && helper_have_rights(CV_SALAERY_INCREASE_ANALYSIS, CV_VIEW_RIGHT_NAME)) { ?>
                    <!--<li><a href="<?php echo site_url("report/salary_increase_both/1"); ?>">Salary Increase Range Analysis</a></li>-->
                      <?php } ?>
                    <!--<li><a href="<?php //echo site_url("stack/get_crr_rpt_data_function"); ?>">Population Distribution on CR Range</a></li>-->
                    <!--<li><a href="<?php //echo site_url("report/get_crr_rpt_data_rating"); ?>">Population Distribution on CR Range By Rating</a></li>-->
                    <!--<li><a href="<?php //echo site_url("stack/paymix"); ?>">Pay Mix Analysis</a></li>-->
                    
                   <div class="saprate-sec-report"> 
                    <ul class="sap-report core">
                      <h4>Core Reports</h4>  
                        <?php if($this->session->userdata('role_ses')==1){ ?>
                        <li><i class="fa fa-dot-circle-o"></i><a style="padding-left:8px !important;" href="<?php echo site_url("report/employee_historical_report"); ?>">Employee History</a></li>
                        <?php } ?>
                        <?php if(helper_have_rights(CV_HEADCOUNT_REPORT, CV_VIEW_RIGHT_NAME)) { ?>
                        <li><i class="fa fa-dot-circle-o"></i> <a style="padding-left:6px !important;" href="<?php echo site_url("report/headcount"); ?>">Headcount</a></li>
                        <?php } ?>
                        <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/turnover"); ?>">Turnover</a></li>

                        
                    </ul>

                    <ul class="sap-report compensa">
                      <h4>Compensation Reports ( Rule Based )</h4> 
                       <?php if(helper_have_rights(CV_COMPPISITING_REPORT, CV_VIEW_RIGHT_NAME)) { ?>
                    <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/compposition-rule-wise"); ?>">Comp Positioning</a></li>
                    <?php } ?> 
                     
                    <?php if($this->session->userdata('sub_session')<10){ ?>
                    <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/salary-increase"); ?>">Overall Salary Growth</a></li>
                     <?php } ?>
                      <?php if($this->session->userdata('sub_session')<10){ ?>
                    <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/salary-increase-budget"); ?>">Salary Increase Budget Allocation vs Utilisation</a></li>
                    <?php } ?>
                        <?php if(helper_have_rights(CV_SALARY_ANALYSIS_REPORT, CV_VIEW_RIGHT_NAME)) { ?>
                    <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/salary_analysis"); ?>">Salary Increase Range</a></li>
                    <?php } ?>
                       
                    </ul>

                    <ul class="sap-report productivity">
                      <h4>Cost & Productivity Reports</h4>  
                        <?php if($this->session->userdata('sub_session')<10){ ?>
                        <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/employee_cost_new"); ?>">Employee Cost</a></li>
                        <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/profit_revenue_cost_fte"); ?>">Employee Productivity</a></li>
                        <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/profit_revenue_cost_sales"); ?>">Sales Employee Productivity</a></li>
                       <?php } ?>
                    </ul>

                    <ul class="sap-report Telent">
                      <h4>Telent Reports</h4> 
                      <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/identified-report"); ?>">Identified Successor</a></li>

                      <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/performance-rating"); ?>">Performance Rating Distribution</a></li>

                      <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/potential-rating"); ?>">Potential Rating Distribution</a></li>

                      <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/promotion-report"); ?>">Promotion Cases Distribution</a></li>

                        <?php if(helper_have_rights(CV_PAYMIX_REPORT, CV_VIEW_RIGHT_NAME)) { ?>
                    <li style="display:none;"><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/paymix"); ?>">Pay Mix Report</a></li>
                    <?php } ?>
                    
                    
                    <?php if(helper_have_rights(CV_PAY_RANGE_ANALYSIS, CV_VIEW_RIGHT_NAME)) { ?>
                    <li style="display:none;"><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/pay_range"); ?>">Pay Range</a></li>
                    <?php } ?>

                   <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/successor-readyness-report"); ?>">Successor's Readiness Level </a></li>
                    
                    <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/promoted-successor-report"); ?>">Successor's Who Got Promoted</a></li>
                    
                   <?php if($this->session->userdata('sub_session')<10){ ?>
                        
                        <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/talent_distribution"); ?>">Talent Rating Distribution</a></li>
                        
                        <li><i class="fa fa-dot-circle-o"></i><a href="<?php echo site_url("report/talent_performance_distribution"); ?>">Talent vs Performance Rating Distribution</a></li>
                    <?php } ?>
                    
                    <?php if($this->session->userdata('sub_session')<10){if(helper_have_rights(CV_DB_REPORT, CV_VIEW_RIGHT_NAME)) { ?>
                    <!-- <li><i class="fa fa-dot-circle-o"></i><a href="<?php //echo site_url("report/dbreports"); ?>">Database</a></li> -->
                    <?php }} ?>
                    
                    
                    </ul>

                   </div>

                    
                    
                    </ul>
                </li>
                <?php } ?>
            
            
            <?php if($this->session->userdata('sub_session') < 10){ if(helper_have_rights(CV_SURVEY, CV_VIEW_RIGHT_NAME) && get_module_status('survey_module')){
			
			if($this->session->userdata('companyid_ses') == CV_SURVEY_COMPANY_ID){ ?> 
            <li><a href="<?php echo site_url("survey/users"); ?>"><p><span class="menu-icon icon-list"></span> <span class="hide-text">Surveys</span></p><span class="arrow"></span></a></li>
            <?php } else{ ?> 
            <li><a href="<?php echo site_url("survey"); ?>"><p><span class="menu-icon icon-list"></span> <span class="hide-text">Surveys</span></p><span class="arrow"></span></a></li>
            <?php } } } } ?>


            <?php if($this->session->userdata('sub_session')==10 && $this->router->fetch_class()!=" dashboard" && $this->router->fetch_method()!="index") { ?>

                <?php if(get_module_status('salary_module')){ ?>
                    <li><a href="<?php echo base_url('manager/dashboard/salary_rules'); ?>"><span class="menu-icon icon-user"></span><p>Salary Review</p></a></li>
                <?php } ?>

                <?php if(get_module_status('bonus_module')){ ?>
                    <li><a href="<?php echo base_url('manager/dashboard/bonus_rules'); ?>"><span class="menu-icon icon-users"></span><p>Bonus/Incentive</p></a></li>
                <?php } ?>

                <?php if(get_module_status('lti_module')){ ?>
                    <li><a href="<?php echo base_url('manager/dashboard/lti_rules'); ?>"><span class="menu-icon icon-notebook"></span><p>LTI</p></a></li>
                <?php } ?>

                <?php if(get_module_status('rnr_module')){ ?>
                    <li><a href="<?php echo base_url('manager/view-emp-list-for-rnr'); ?>"><span class="menu-icon icon-notebook"></span><p>R & R</p></a></li>
                <?php } ?>

            <?php } ?>
            
            <?php if($this->session->userdata('sub_session')==11){
                    if($this->session->userdata('companyid_ses') != CV_SURVEY_COMPANY_ID){ ?>
            
                    <?php /*?> <li><a <?php echo get_emp_salary_review() ?>><span class="menu-icon icon-user"></span><p>Salary Review</p></a></li><?php */?>
                    <?php if(get_module_status('bonus_module')){ ?>
                        <li><a <?php echo get_emp_bonus_review() ?>><span class="menu-icon icon-users"></span><p>Bonus Review</p></a>        </li>
                    <?php } ?>

                    <?php if(get_module_status('lti_module')){ ?>
                        <li><a <?php echo get_emp_lti_review() ?>><span class="menu-icon icon-notebook"></span><p>LTI</p></a></li>
                    <?php } ?>

                    <?php if(get_module_status('rnr_module')){ ?>
                        <li><a <?php echo get_emp_rnr_review() ?>><span class="menu-icon icon-notebook"></span><p>R & R</p></a></li>
                    <?php } ?>

		        <?php } ?>
                <?php if(helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME) && get_module_status('survey_module')) { ?>
                    <li><a href="<?php echo base_url('survey/users') ?>"><span class="menu-icon icon-list"></span><p>Survey</p></a></li>
                <?php } ?>
            <?php } ?>	
			
			
			
			<!--shumsul-->
			
                        
                        <?php
                                
                                if($this->session->userdata('sub_session') < 10){
                                    ?>
                                    
                                    <?php
                                } else {
                        if($this->session->userdata('companyid_ses') != CV_SURVEY_COMPANY_ID){
                        ?>    
			<li  class="droplink hr_settings"><a href="#"><p><span class="menu-icon icon-note"></span> Policies & FAQs</p></a>
                    <ul class="sub-menu menueMar cstman">
                        <li><a href="<?php echo base_url('c_and_b') ?>">C&B Policies</a></li>
					<li><a href="<?php echo base_url('glossary') ?>">Glossary of terms</a></li>
					<li><a href="<?php echo base_url('faq') ?>">FAQs</a></li>
					<li><a href="<?php echo base_url('cbnetwork') ?>">Internal C&B Network</a></li>
                    

                    <!--<li><a href="<?php //echo site_url("view-user-right-details"); ?>">User Rights</a></li> -->
                </ul>
            </li>
                                <?php  }} ?>
		
            <?php if($this->session->userdata('sub_session')!=11 &&  $this->session->userdata('sub_session')!=10) {
			if($this->session->userdata('companyid_ses') != CV_SURVEY_COMPANY_ID){ ?>
		<li  class="droplink hr_settings"><a href="#"><p><span class="menu-icon icon-book-open"></span><span class="hide-text"> Connect & Learn</span></p></a>
                <ul class="sub-menu menueMar cstman">
                    <?php if(helper_have_rights(CV_TREND, CV_VIEW_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('trend') ?>">C&B Trends</a></li> <?php } ?>
                    <?php if(helper_have_rights(CV_CBNETWORK, CV_INSERT_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('cbnetwork') ?>">C&B Network</a></li><?php } ?>
                    <?php if(helper_have_rights(CV_WORKSHOP, CV_VIEW_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('workshop') ?>">F2F C&B Conferences/workshops</a></li><?php } ?>
                    <?php if(helper_have_rights(CV_CB_POLOCIES, CV_VIEW_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('c_and_b') ?>">C&B Policies</a></li><?php } ?>
                    <?php if(helper_have_rights(CV_GLOSSARY, CV_VIEW_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('glossary') ?>">Glossary of terms</a></li><?php } ?>
                    <?php if(helper_have_rights(CV_FAQ, CV_VIEW_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('faq/listing') ?>">FAQs</a></li><?php } ?>
                    <?php if(helper_have_rights(CV_INTERNAL_CB_NETWORK, CV_VIEW_RIGHT_NAME)){ ?><li><a href="<?php echo base_url('cbnetwork') ?>">Internal C&B Network</a></li><?php } ?>
                </ul>
            </li>
            <?php }} ?>
			
			<!-- <li class="droplink">
            <a href="<?php //echo site_url("aop-dashboard"); ?>"><p><span class="menu-icon icon-users"></span> <span class="hide-text">AOP</span></p><span class="arrow"></span></a>
            
            </li> -->
			
			
				<?php if($this->session->userdata('userid_ses') != $this->session->userdata('proxy_userid_ses')){?>
			  <li  class="droplink hr_settings"> <a class="anchor_cstm_popup_cls_default_resetproxy" href="<?php echo site_url("reset-proxy"); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_default_resetproxy', 'Are your sure, You want to reset proxy account?')" style="display:inline-block !important;"><span class="menu-icon icon-user-following" ></span><p >Reset Proxy</p></a></li>
			   <?php } else { if($this->session->userdata('sub_session')<10) {
			   if($this->session->userdata('companyid_ses') != CV_SURVEY_COMPANY_ID){ ?>
				<li  class="droplink hr_settings"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><p><span class="menu-icon icon-user-follow"></span> <span class="hide-text">Proxy</span></p></a>
                           <?php } } }?>
            </li>

            
            <li style="float:right;    position: absolute; right: 30px;"  class="droplink hr_settings"><a href="#"><span class="menu-icon icon-settings"></span></a>
                <ul  class="sub-menu menueMar">
                  
                  <?php if($this->session->userdata('sub_session') < 10){
				
				if(helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME)){?>
                          
                    

                    
                    <li class="drop_submenup ">
                        <a href="#" class="manage_back" style="display:none;"> <i class="iconb fa fa-chevron-right"></i>Back 
                            
                        </a>
                        <a href="#" class="manage_tool">Manage 
                            <i class="iconp fa fa-ellipsis-h"></i>
                        </a>
                        <ul class="submenup sub-menu">
                    <?php 
							if($this->session->userdata('role_ses') <= 2){?>
                         		<li><a href="<?php echo site_url("final-salary-structure "); ?>">
                         Manage Salary Structure</a></li>
                         <?php } 
						 
                         if(helper_have_rights(CV_DESIGNATION_LIST, CV_VIEW_RIGHT_NAME))
                            { ?>
                            <li class="drop_submenup"><a href="<?php echo site_url("designation"); ?>">Manage Designation</a>                             
                            </li>        
                           <?php }
                           if(helper_have_rights(CV_MANAGE_GRADE, CV_VIEW_RIGHT_NAME))
                            { ?>
                                  <li><a href="<?php echo site_url("manage-grade"); ?>">Manage Grade</a></li>  
                            <?php }
                            if(helper_have_rights(CV_LEVEL_LIST, CV_VIEW_RIGHT_NAME))
                            { ?>
                                  <li><a href="<?php echo site_url("manage-level"); ?>">Manage Level</a></li>
                            <?php }
                            if(helper_have_rights(CV_COUNTRY_ID, CV_VIEW_RIGHT_NAME))
                            { ?>
                                  <li><a href="<?php echo site_url("country"); ?>">Manage Country</a></li>  	
                            <?php }
                            if(helper_have_rights(CV_CITY_ID, CV_VIEW_RIGHT_NAME))
                                { ?>
                                      <li><a href="<?php echo site_url("manage-city"); ?>">Manage City</a></li> 
                                <?php }   
                            if(helper_have_rights(CV_MANAGE_BUSINESS_LEVEL_1, CV_VIEW_RIGHT_NAME))
                            { ?>
                              <li><a href="<?php echo site_url("manage-business-level-1"); ?>">Manage Business Level 1</a></li>  
                            <?php }
                            if(helper_have_rights(CV_MANAGE_BUSINESS_LEVEL_2, CV_VIEW_RIGHT_NAME))
                                { ?>
                                      <li><a href="<?php echo site_url("manage-business-level-2"); ?>">Manage Business Level 2</a></li>
                                <?php }
                            if(helper_have_rights(CV_MANAGE_BUSINESS_LEVEL_3, CV_VIEW_RIGHT_NAME))
                                { ?>
                                     <li><a href="<?php echo site_url("manage-business-level-3"); ?>">Manage Business Level 3</a></li>
                                <?php }    
                            if(helper_have_rights(CV_MANAGE_FUNCTIONS, CV_VIEW_RIGHT_NAME))
                            { ?>
                                  <li><a href="<?php echo site_url("manage-functions"); ?>">Manage Function</a></li>
                            <?php }
                            if(helper_have_rights(CV_MANAGE_SUB_FUNCTIONS, CV_VIEW_RIGHT_NAME))
                                { ?>
                                      <li><a href="<?php echo site_url("manage-sub-functions"); ?>">Manage Sub Function</a></li>  
                            <?php } ?>
                            <li><a href="<?php echo site_url("manage-ratings"); ?>">Manage Ratings</a></li>  
                            <?php
								if(helper_have_rights(CV_MANAGE_CURRENCY, CV_VIEW_RIGHT_NAME))
								{?>
                                <li><a href="<?php echo site_url("manage-currency"); ?>">Manage Currency</a></li>
                           <?php } 
                                if(helper_have_rights(CV_CURRENCY_RATES, CV_VIEW_RIGHT_NAME))
								{?>
                                <li><a href="<?php echo site_url("currency-rates"); ?>">Currency Rates / Conversion</a></li>
                           <?php } ?>

                           <li><a href="<?php echo site_url("tier"); ?>">Tier Masters</a></li>
                           <li><a href="<?php echo site_url("tenure-classification"); ?>">Tenures Classification</a></li>
						   <li><a href="<?php echo site_url("configure-promotion-upgrade-data"); ?>">Configure Promotion Upgrade Data</a></li>
                    
                    	</ul>
                    </li>
                    <?php if(helper_have_rights(CV_TOOLTIP, CV_VIEW_RIGHT_NAME)){?> 
                                <li  class="hr_settings mdrop">
                                    <!-- <a href="<?php //echo base_url('admin/tooltip') ?>">Tooltips</a> -->
                                    <?php } ?>
                 
                    
                    <?php 
                        if(helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME))
                            { ?>
                                  <li class="mdrop"><a href="<?php echo site_url("business-attributes"); ?>">Business Attributes</a></li>  
                            <?php }
                    ?>
                    
                    
                    
                    
                    <?php if(helper_have_rights(CV_CREATE_TEMPLATE, CV_INSERT_RIGHT_NAME)){ ?> <li class="mdrop"><a href="<?php echo base_url('admin/template/template') ?>">Create Letter Template</a></li> <li class="mdrop"><a href="<?php echo base_url('dashboard/emailTemplate') ?>">Create Email Template</a></li>
                    <li class="mdrop"><a href="<?php echo base_url('admin/table_settings') ?>">Salary Review Table settings</a></li>

                <?php } ?>
                    <li class="mdrop"><a href="<?php echo base_url('/admin/admin_dashboard/employee_graph_filters')  ?>">Total Rewards Page settings</a></li>
                    <?php 
                    if(helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME))
                        { ?>
                              <li class="mdrop"><a href="<?php echo site_url("view-roles"); ?>">Role Permissions</a></li>
                        <?php }
                    
                    ?>
                        
                    <?php
                    if(helper_have_rights(CV_HR_RIGHTS_ID, CV_VIEW_RIGHT_NAME))
                            { ?>
                    <!-- <li class="mdrop"><a href="<?php //echo site_url("view-user-right-details"); ?>">Add HR Role</a></li> --> 
                    <li class="mdrop"><a href="<?php echo site_url("view-roles"); ?>">Add HR Role</a></li>                
                            <?php }
                    
                    ?>
                     
					 <?php if($this->session->userdata('role_ses') <= 2){?>
					<!--  <li class="mdrop"><a href="<?php echo site_url("edit-company-info"); ?>">Total Rewards Statement settings</a></li> -->
                     <li class="mdrop"><a href="<?php echo site_url("edit-company-info"); ?>">Edit Company Profile</a></li>
					 <?php } ?>
                    <!--<li><a href="<?php //echo site_url("view-user-right-details"); ?>">User Rights</a></li> -->
                    <?php }} ?>
                    
                    <li class="mdrop"><a href="<?php echo site_url("change-password"); ?>">Change Password</a></li>

                    <?php if($this->session->userdata('sub_session') < 10){?>
                    
                    <li class="mdrop"><a href="<?php echo site_url("market-data-upload"); ?>">Upload Pay Range Data</a></li>
                     <li class="mdrop"><a href="<?php echo site_url("enter-prc"); ?>">Upload Company Financials</a></li>
                    <?php } ?>

                </ul>
            </li>
            
                                
            <li  class="droplink hr_settings" style="float: right;"><a href="javascript:;" onclick="log_out();"><span class="menu-icon icon-logout"> </span></a>
                <form id="frm_logout" class="" action="<?php if ( $this->session->userdata('ssologin_ses') && !($this->session->userdata('ssologin_ses_reverse_logout'))) {echo base_url('ssologin/index.php?slo');} else {echo base_url('logout');} ?>" method="POST" style="display: none;">
                	<?php echo HLP_get_crsf_field();?>	
                </form>
            </li>			
			
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->
</div><!-- Navbar -->



<script>
function mark_notification_readed()
{
	var num = $("#hf_notify_cnt").val();
	if(num > 0)
	{
		$.ajax({
        type:"GET",
        url:"<?php echo site_url("dashboard/mark_notification_readed");?>", 
        success: function(response)
        {
            if(response)
            {
				$("#hf_notify_cnt").val(0);
				$("#spn_notify_cnt").html("0");
            }
        }
    });
	}
}
</script>
<style>

.ui-autocomplete-input{
	border:1px solid red;
	z-index: 99999999 !important;
	
}

</style>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
	  
    
      <!-- Modal content-->
      <div class="modal-content launch-modal">
        <div class="modal-header">
          <button  type="button" class="close " data-dismiss="modal" >&times;</button>
          <h4 class="modal-title">Proxy</h4>
        </div>
        <div class="modal-body">
		<form class="form-horizontal" method="post" action="<?php echo site_url("set-proxy"); ?>" >
        	<?php echo HLP_get_crsf_field();?>
		    <div class="col-sm-12 col-md-6 col-lg-6 text-center">
			    <input id="txt_proxy_search" name="txt_proxy_search" type="text" autofocus class="form-control" required="required" maxlength="50">
			</div>
			
		    <div class="col-sm-12 col-md-6 col-lg-6 proxyBtn text-center">
			   
			   <button type="submit" class="btn btn-success" style="display:inline-block !important;">Set Proxy</button>
			   <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
			</div>
               
		

			</form>
        </div>
        <div class="modal-footer">
          
		  
        </div>
		
      </div>
      
    </div>
  </div>
  <script>
  $('li.drop_submenup a.manage_tool').click(function(){
  	$(this).next('ul').slideToggle();
        
    $('.manage_back').show();
    $('.manage_tool').hide();
    $('.mdrop').hide();
  });

  $('.manage_back').click(function(){
    $('.manage_tool').trigger('click');
    $('.submenup').slideUp('slow');
   /* $('.submenup').css("display","none");*/
    $('.manage_back').hide();
    $('.mdrop').show();
    $('.manage_tool').show();
  });

  function log_out()
  {
    custom_confirm_popup_callback('Are your sure, You want to logout?',function(result)
    {
      if(result)
      {
      $( "#frm_logout" ).submit();
      }
    }
   );
  }

  	/*function log_out()
	{
		var conf = confirm('Are your sure, You want to logout?');
		if(conf)
		{
			$( "#frm_logout" ).submit();
		}
	}*/
  </script>
  
<script>
//Note :: This function is used to get amount in required format with required no of decimals
function get_formated_amount_common(amt_val, max_decimals=0)
{
	//var formated_amt_val = Number(amt_val).toFixed(max_decimals).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	var formated_amt_val = Number(Math.round(amt_val+'e'+max_decimals)+'e-'+max_decimals).toFixed(max_decimals).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	return formated_amt_val;
}
//Note :: This function is used to get percentage with required no of decimals
function get_formated_percentage_common(per_val, max_decimals=2)
{
	//var formated_per_val = Number(Math.round(per_val +'e2')+'e-2').toFixed(max_decimals);
	 var formated_per_val = Number(Math.round(per_val+'e'+max_decimals)+'e-'+max_decimals).toFixed(max_decimals);
	return formated_per_val;
}
function get_formated_percentage_common_without_round(per_val, max_decimals=2)
{
    //var formated_per_val = Number(Math.round(per_val +'e2')+'e-2').toFixed(max_decimals);
     var formated_per_val = Number(per_val);
     
    return formated_per_val;
}
</script>
<script>
              new WOW().init();
              </script>