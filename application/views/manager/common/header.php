<?php if($this->session->userdata("company_color_ses")){?>
<?php /*?><style type="text/css">
    .btn{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}
</style><?php */?>

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
    background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>;
    float: left;
    border-radius: 5px 0px 0px 5px;
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
</style>
<?php } 
if($this->session->userdata('role_ses')==10||$this->session->userdata('role_ses')==6)
{
    echo "<style>.page-inner{margin-top: 0px !important;}</style>";
}

?>
 <div class="navbar" style="background:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;">
    <div class="navbar-inner container">
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    
        <div class="logo-box">
            <a href="#" class="logo-text"><span>
			<?php if($this->session->userdata('companyname_ses')){echo $this->session->userdata('companyname_ses');}elseif(isset($title) and ($title) ){echo $title;}else{ echo "Manager Dashboard"; } ?></span></a>
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown"><i class="fa fa-bell"></i><span class="badge badge-success pull-right">0</span></a>
                        <ul class="dropdown-menu title-caret dropdown-lg" role="menu">
                            <li><p class="drop-title">You have 3 pending tasks !</p></li>
                            <li class="dropdown-menu-list slimscroll tasks">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#">
                                            <div class="task-icon badge badge-success"><i class="icon-user"></i></div>
                                            <span class="badge badge-roundless badge-default pull-right">1min ago</span>
                                            <p class="task-details">New user registered.</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="task-icon badge badge-danger"><i class="icon-energy"></i></div>
                                            <span class="badge badge-roundless badge-default pull-right">24min ago</span>
                                            <p class="task-details">Database error.</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="task-icon badge badge-info"><i class="icon-heart"></i></div>
                                            <span class="badge badge-roundless badge-default pull-right">1h ago</span>
                                            <p class="task-details">Reached 24k likes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="drop-all"><a href="#" class="text-center">All Tasks</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                            <span class="user-name"><?php echo $this->session->userdata('username_ses'); ?><i class="fa fa-angle-down"></i></span>
                            <img class="img-circle avatar" src="<?php echo base_url("assets/images/avatar.png"); ?>" width="40" height="40" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-list" role="menu">
                            <li role="presentation"><a href="<?php echo site_url("manager/profile"); ?>"><i class="fa fa-user"></i>Profile</a></li>
                            <li role="presentation" class="divider"></li>
                           <!-- <li role="presentation"><a href="lock-screen.html"><i class="fa fa-lock"></i>Lock screen</a></li>-->
                            <li role="presentation"><a href="<?php echo site_url("logout"); ?>"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                        </ul>
                    </li>
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
        </div>
    </div>
</div><!-- Navbar -->
<div class="page-sidebar sidebar horizontal-bar">
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu">
            <li class="nav-heading"><span>Navigation</span></li>
            <li><a href="<?php echo site_url("dashboard"); ?>"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li>
           <!--  <li><a href="<?php //echo site_url("manager/profile"); ?>"><span class="menu-icon icon-user"></span><p>My Profile</p></a></li> -->
            <!-- <li class="droplink"><a href="#"><span class="menu-icon icon-users"></span><p>Employees</p><span class="arrow"></span></a>
                <ul class="sub-menu">
                    <li class="hr_settings"><a href="<?php echo site_url("staff"); ?>">Staff List</a></li>
                    <li class="no_hr"><a href="<?php echo site_url("add-staff"); ?>">Add Staff</a></li>                    
                </ul>
            </li> -->
          <?php /*?>  <li class="droplink">
            <a href="<?php echo site_url("manager/performance-cycle"); ?>"><span class="menu-icon icon-users"></span><p>Performance Cycle</p><span class="arrow"></span></a>
            </li><?php */?>
            <li><a href="<?php echo base_url('manager/comingsoon-report'); ?>"><span class="menu-icon icon-notebook"></span><p>Reports</p></a></li>
            <!-- <li><a href="#"><span class="menu-icon icon-note"></span><p>Compensation Review</p></a></li> -->
           <!--  <li  class="droplink hr_settings"><a href="#"><span class="menu-icon icon-settings"></span><p>General Setting</p></a>
                <ul class="sub-menu">
                    <li><a href="<?php echo site_url("business-attributes"); ?>">Business Attributes</a></li>
                    <li><a href="<?php echo site_url("designation"); ?>">Manage Designation</a></li>
                    <li><a href="<?php echo site_url("manage-grade"); ?>">Manage Grade</a></li>
                    <li><a href="<?php echo site_url("country"); ?>">Manage Country</a></li>
                    <li><a href="<?php echo site_url("manage-city"); ?>">Manage City</a></li>
                    <li><a href="manage-business-unit.php">Manage Business Unit</a></li>
                    <li><a href="manage-function-subfunction.php">Manage Function/Subfunction</a></li>
                    
                    
                    <li><a href="manage-education-keyskills.php">Manage Education/Key Skills</a></li>
                    <li><a href="manage-critical-talent.php">Manage Critical Talent</a></li>
                    <li><a href="manage-critical-position-holder.php">Manage Critical Position Holder</a></li>
                    <li><a href="manage-special-category.php">Manage Special Category</a></li>
                    <li><a href="salary-increment-rules.php">Salary Increment Rules</a></li>
                    <li><a href="manage-module.php">Manage Module</a></li>
                </ul>
            </li> -->
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->
