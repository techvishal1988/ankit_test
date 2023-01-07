<style>
 .page-inner{padding:0 0 40px;}
    .page-title h3{}
    .page-title h3 span{ text-transform:capitalize; font-style:italic; font-size:18px; color:#000;}
    .page-title p{font-style:italic; font-size:14px; color:#000;}

    .page-title .dropdown .avatar{ width:50px; height:50px; margin:-30px 0px -15px 0px;}
    .page-title .dropdown .fa-bell{ color:#999 !important;} 


    .links{ display:block; width:100%; background:url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat; background-size:cover; padding:53px 0px 15px 0px;}
    .links .details{}
    .links .details ul{  padding:0px 0px 30px 0px;}
    .links .details ul li{ font-size:17px;text-align:center; color:#FFF; width:20%; display:inline-block; padding:55px 30px;  margin:0px 0px 3px 0px; border-radius:0px;
                 }
    .links .details ul li a{ font-size:18px; color:#FFF; text-decoration:none;}

    .blue_bg{ background-color:#09F !important;}

    @media (max-width:640px){
      .links .details ul li{ width:80%; margin:40px 0px 0px 0px;}
      .links .details ul li:last-child{margin-bottom:40px;}
      
      }
      
    @media (min-width:641px) and (max-width:1199px){
      .links .details ul li{ width:43%; margin:40px 30px 0px 0px;}
      .links .details ul li a{font-size:20px;}



</style>

<div class="page-title">

    <div class="container">

        <div class="page-title-heading">
        
        	<div class="top-menu">
                
                <ul class="nav navbar-nav navbar-left">
                    <!--<li>	
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </li>-->
                 <?php /*?>   <li class="dropdown">
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
                            
                            <img class="img-circle avatar" src="<?php echo base_url("assets/images/avatar.png"); ?>" width="40" height="40" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-list" role="menu">
                            <li role="presentation"><a href="<?php echo site_url("profile"); ?>"><i class="fa fa-user"></i>Profile</a></li>
                            <li role="presentation" class="divider"></li>
                           <!-- <li role="presentation"><a href="lock-screen.html"><i class="fa fa-lock"></i>Lock screen</a></li>-->
                            <li role="presentation"><a href="<?php echo site_url("logout"); ?>"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                        </ul>
                    </li>
                    <li>
                       <h3><?php echo $this->session->userdata('username_ses');?>&nbsp;
            <span><?php if($this->session->userdata('role_ses')==1)
        {echo "HR Admin";}//"Super Admin";}
        elseif($this->session->userdata('role_ses')==2)
        {
          echo "HR Admin";
        }
        elseif($this->session->userdata('role_ses')==3)
        {
          echo "HR Partner Level 1";
        }
        elseif($this->session->userdata('role_ses')==4)
        {
            echo "HR Partner Level 2";
        }
        elseif($this->session->userdata('role_ses')==5)
        {
            echo "HR Head";
        }
        elseif($this->session->userdata('role_ses')==9)
        {
            echo "Rewards Lead";
        }
        elseif($this->session->userdata('role_ses')==10)
        {
          echo "Manager";
        }
        else
        {
          echo "";
        }
			?></span></h3>
            		   <!--<p>Proxy as another user</p>  -->         
                    </li>
                    
                </ul><!-- Nav -->
            </div>

        </div>

        

        <div class="links">
  <div class="container">
      <div class="details">
          
	  <?php
          //echo '<pre />';print_r($this->session->userdata());
          if($this->session->userdata('role_ses')==11){ ?>
          <ul>
            
            
            
             
            <a href="<?php echo base_url("index.php/employee/dashboard/view_employee_increment_dtls/1/22/1"); ?>"> <li>
            <div class="icon-box">
            	<i class="fa fa-compass blue_bg"></i>

                <h5> Salary increase and promotion</h5>
            </div></li> </a>
            
            
            
           

            <a href="<?php echo base_url('index.php/employee/dashboard/view_employee_bonus_increment_dtls/3/2/1') ?>">
            <li>
            <div class="icon-box">
                <i class="fa fa-user red"></i>
                <h5> Annual <br />bonus</h5>
            </div>
            </li>
            </a><br />
            
            <a  href="<?php echo base_url('employee/comingsoon-lti') ?>"> <li>
            <div class="icon-box">
                <i class="fa fa-compass blue_bg"></i>
                <h5>Long term <br />incentive</h5>
            </div></li> </a>
            <a  href="<?php echo base_url('employee/comingsoon-randr') ?>"> <li>
            <div class="icon-box">
                <i class="fa fa-compass blue_bg"></i>
                <h5>Reward and Recognition </h5>
            </div></li> </a>
            
            </ul>
	  <?php } ?>
        </div>
    </div>
</div>

    </div>

</div>


<!--<div class="links">
  <div class="container">
      <div class="details">      
          <ul>
            <a href="<?php echo site_url("employee/recomend-salary-increase"); ?>"><li class="blue_bg">Recomend <br>Salary Increase</li></a>
            <a href="#<?php //echo site_url("performance-cycle"); ?>"><li>Allocate  <br>Bonus</li></a><br />
            <a href="#<?php //echo site_url("business-attributes"); ?>"><li>Allocate Long<br> Term Incentive</li></a>
            <a href="#<?php //echo site_url("upload-data"); ?>"><li class="blue_bg">Recognize A  <br> Team Member</li></a>
            
            </ul>
        </div>
    </div>
</div> -->


<audio id="dv_correct_sound" >

  <source src="<?php echo base_url();?>audio/thank_you_for_calling.mp3" type="audio/mpeg" />

</audio>
<script type="text/javascript">
ravi();
function ravi()
{
  //document.getElementById('dv_correct_sound').play();
  //
  //setTimeout(function() {return true;},5000);return false;
}
</script>
<style>

.padding_off{padding:10px 0px 0px 0px !important; color:#000 !important;}


.links .details ul{ padding-top:10px; position:relative; z-index:1; text-align:center !important; }
.links .details ul li{ color:#666 !important; padding:30px; text-align:center; transition: .5s ease-in-out; }
.links .details ul li{ background:rgba(255,255,255, 0.5);}
.links .details ul li .icon-box{display:block; width:100%;}
.links .details ul li .icon-box i{ color:#FFF; padding:10px; border-radius:100%; height:80px; width:80px; font-size: 27px; padding:27px;}
.links .details ul li .icon-box h5{ font-family:"Helvetica Neue",Helvetica,Arial,sans-serif; font-size:16px;}
.links .details ul li:hover{box-shadow:0 0 15px 9px #183348; z-index:2; position:relative;}
.red{ background-color:#C30;}
.sky-blue{ background-color:#36F;}

 /* @media(max-width:767px){.links .details ul li:hover{width:100%;}}  */


<?php /*?>.scroll_user{ height:200px; overflow-y:scroll;}
.inline-bttn{}
.top-menu .navbar-nav > li.inline-bttn a{ display:inline !important; margin-top:-17px !important;}<?php */?>
</style>
<div id="empmodal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>This section can customized as per organization requirement.</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>