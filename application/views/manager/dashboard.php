<style>

.page-title h3{}
.page-title h3 span{ text-transform:capitalize; font-style:italic; font-size:18px; color:#000;}
.page-title p{font-style:italic; font-size:14px; color:#000;}

.page-title .dropdown .avatar{ width:50px; height:50px; margin:-30px 0px -15px 0px;}
.page-title .dropdown .fa-bell{ color:#999 !important;} 


.links{ display:block; width:100%;}
.links .details{}
.links .details ul{ text-align:center; padding:0px 0px 30px 0px;}
.links .details ul li{ font-size:17px; color:#FFF; width:20%; display:inline-block; padding:55px 30px; background-color:#F60; margin:40px 40px 0px 0px; border-radius:0px; 
            -webkit-box-shadow: 0px 0px 15px 7px rgba(173,113,173,1);
            -moz-box-shadow: 0px 0px 15px 7px rgba(173,113,173,1);
            box-shadow: 0px 0px 15px 7px rgba(173,113,173,1) ,inset 0px 0px 6px 3px rgba(87,85,87,1);
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
  } 



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
                       <h3><?php echo $this->session->userdata('username_ses'); ?>,&nbsp;
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
          echo "Employee";
        }
			?></span></h3>
			
			<!--Proxy Work Start-->	
			   <?php /*?><a href="#" class="dropdown-toggle padding_off waves-effect waves-button waves-classic" data-toggle="dropdown">Proxy as another user   </a><?php */?> 
			   <div id="lnk_set_proxy">
			   <a href="javascript:;"  onclick="$('#dv_proxy_search').show(); $('#lnk_set_proxy').hide();" class="padding_off waves-effect waves-button waves-classic">Proxy as another user   </a>
			   <?php if($this->session->userdata('userid_ses') != $this->session->userdata('proxy_userid_ses')){?>
			   <a href="<?php echo site_url("reset-proxy"); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_default_resetproxy','Are your sure, You want to reset proxy account?')" style="display:inline-block !important;"><button type="button" class="btn btn-success anchor_cstm_popup_cls_default_resetproxy">Reset Proxy</button></a>
			   <?php } ?>
			   </div>
			<style>
			/* css for autocomplete */
			 .ui-autocomplete {         
					  max-height: 200px; 
					  overflow-y: auto;         
					  overflow-x: hidden;         
					  padding: 0px;
					  margin: 0px;
					} 
			
			</style>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
			<div class="form-group my-form " id="dv_proxy_search" style="display:none;">
			<form class="form-horizontal" method="post" action="<?php echo site_url("set-proxy"); ?>">
			<div class="col-sm-6 form-input ">
				<input id="txt_proxy_search" name="txt_proxy_search" type="email" class="form-control" required="required" maxlength="50">
			</div>
			<div class="col-sm-3 form-input ">
			<button type="submit" class="btn btn-success" style="display:inline-block !important;">Set Proxy</button>
			</div>
			<div class="col-sm-3 form-input removed_padding">
			<a href="javascript:;" onclick="$('#dv_proxy_search').hide(); $('#lnk_set_proxy').show();" style="display:inline-block !important;"><button type="button" class="btn btn-success">Cancel</button></a>
			</div>
			</form>
			</div>
			<script>
			  $( function() {    
				$( "#txt_proxy_search" ).autocomplete({
					minLength: 2,        
					source: '<?php echo site_url("dashboard/get_users_for_proxy"); ?>',
					select: function(event, ui) {
				 }
				});
			  } );
			</script>
  
		   <?php /*?><ul class="dropdown-menu dropdown-list scroll_user" role="menu">
			   <?php 
				if($this->session->userdata('prox_users_ses_list'))
					{
						echo $this->session->userdata('prox_users_ses_list');
					}
			   ?>
			</ul><?php */?>   
			<!--Proxy Work End--> 
            <!--<p>Proxy as another user</p>  -->         
                    </li>
                    
                </ul><!-- Nav -->
            </div>

        </div>

        

        <div class="clearfix"></div>

    </div>

</div>


<div class="links">
  <div class="container">
      <div class="details">      
          <ul>
            <a href="<?php echo site_url("manager/view-increments-list"); ?>"><li class="blue_bg">View <br>Increments List</li></a>
            <a href="<?php echo site_url("manager/view-manager-employees"); ?>"><li>My  <br>Employees</li></a><br />
           <?php /*?> <a href="#<?php //echo site_url("business-attributes"); ?>"><li>Allocate Long<br> Term Incentive</li></a>
            <a href="#<?php //echo site_url("upload-data"); ?>"><li class="blue_bg">Recognize A  <br> Team Member</li></a><?php */?>
            
            </ul>
        </div>
    </div>
</div>


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

.padding_off{padding:5px 0px 0px 0px !important; color:#000 !important;}
<?php /*?>.scroll_user{ height:200px; overflow-y:scroll;}
.inline-bttn{}
.top-menu .navbar-nav > li.inline-bttn a{ display:inline !important; margin-top:-17px !important;}<?php */?>
</style>