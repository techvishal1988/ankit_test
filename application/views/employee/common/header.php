<?php if($this->session->userdata("company_color_ses")){?>
<style type="text/css">
    .btn{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}

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
    background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>;
    float: left;
    border-radius: 5px 0px 0px 5px;
    position: relative;
    text-align: center !important;
    line-height:34px;
    color:#fff;
    font-size:15px;
}  

.removed_padding
{
  padding: 0px !important;
} 
<?php 
if($this->session->userdata('role_ses')==11)
{
    echo ".page-horizontal-bar.page-header-fixed .horizontal-bar{padding-top: 0px !important;}";
}

?>
</style>
<?php } ?>


<div class="navbar" style="background:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;">
    <div class="navbar-inner container" >
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    
        <div class="logo-box">
            <a href="<?php echo site_url("employee/dashboard"); ?>" class="logo-text">
        
            <img src="<?php echo $this->session->userdata("company_logo_ses"); ?>" />

            <span><?php if($this->session->userdata('companyname_ses')){echo $this->session->userdata('companyname_ses');}elseif(isset($title) and ($title) ){echo $title;}else{ echo "employee/dashboard"; } ?></span></a>
        </div><!-- Logo Box -->
       <!-- <div class="search-button">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
        </div>-->
        <div class="topmenu-outer" style="background:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;">
            <div class="top-menu">
                
                <ul class="nav navbar-nav navbar-right">
                    <!--<li>	
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </li>-->
                    <?php /*?><li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown" onclick="mark_notification_readed();">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-success pull-right" id="spn_notify_cnt"><?php if(isset($notifications) and ($notifications)){echo count($notifications);}else{echo "0";}?></span>
                        <input type="hidden" value="<?php if(isset($notifications) and ($notifications)){echo count($notifications);}else{echo "0";}?>" name="hf_notify_cnt" id="hf_notify_cnt" />
                        </a>
						<?php if(isset($notifications) and ($notifications)){ ?>
                        <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                            
                            <li>
                            <p class="drop-title">You have <?php echo count($notifications);?> new notifications !</p></li>
                            <li class="dropdown-menu-list slimscroll tasks">
                                <ul class="list-unstyled">
                                   <?php foreach($notifications as $row){?> 
                                   	<li>
                                        <a href="#">
                                            <div class="task-icon badge badge-success"><i class="fa fa-bell"></i></div>
                                            <!--<span class="badge badge-roundless badge-default pull-right">1min ago</span>-->
                                            <p class=""><?php echo $row["notification_for"]; ?></p>
                                            <p class="task-details"><?php echo $row["message"]; ?></p>
                                            
                                        </a>
                                    </li>
                                   <?php } ?> 
                                </ul>
                            </li>
                            <li class="drop-all"><a href="#" class="text-center">All Tasks</a></li>
                        </ul>
						<?php } ?>
						
                    </li><?php */?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                            <span class="user-name"><?php echo $this->session->userdata('username_ses'); ?><i class="fa fa-angle-down"></i></span>
                            <img class="img-circle avatar" src="<?php echo base_url("assets/images/avatar.png"); ?>" width="40" height="40" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-list" role="menu">
                            <li role="presentation"><a href="<?php echo site_url("profile"); ?>"><i class="fa fa-user"></i>Profile</a></li>
                            <li role="presentation" class="divider"></li>
                           <!-- <li role="presentation"><a href="lock-screen.html"><i class="fa fa-lock"></i>Lock screen</a></li>-->
                            <li role="presentation"><a href="<?php echo site_url("logout"); ?>"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                        </ul>
                    </li>
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
        </div>
    </div>
    <div class="page-sidebar sidebar horizontal-bar">
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu">
        	<li class="nav-heading"><span>Navigation</span></li>
		<li><a href="<?php echo base_url('index.php/employee/dashboard/') ?>"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li>
		<li><a href="<?php echo base_url('/index.php/employee/dashboard/view_employee_increment_dtls/1/22/1') ?>"><span class="menu-icon icon-user"></span><p>Salary Review</p></a></li>
		<li><a href="<?php echo base_url('index.php/employee/dashboard/view_employee_bonus_increment_dtls/3/2/1') ?>"><span class="menu-icon icon-users"></span><p>Bonus Review</p></a>        </li>
		<li><a href="<?php echo base_url('employee/comingsoon-lti'); ?>"><span class="menu-icon icon-notebook"></span><p>LTI</p></a></li>
		<li><a href="<?php echo base_url('employee/comingsoon-randr'); ?>"><span class="menu-icon icon-notebook"></span><p>R and R</p></a></li>
	</ul>
    </div><!-- Page Sidebar Inner -->
</div>
</div><!-- Navbar -->


<?php /*?><div <?php if($title != "employee/dashboard"){?>class="page-sidebar sidebar horizontal-bar"<?php } ?>>
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu">
            <?php if($title != "Dashboard"){?><li class="nav-heading"><span>Navigation</span></li>
            <li><a href="<?php echo site_url("employee/dashboard"); ?>"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li>            
			<?php } ?>
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><?php */?>
<!-- Page Sidebar -->

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