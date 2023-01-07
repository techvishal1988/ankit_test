<style>
/*Start shumsul*/
    .page-inner{
		padding:0 0 40px;
			  background: url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat !important;
              background-size: cover !important;
              display: table;
              width: 100%;
		}
		
/*End shumsul*/
.links .details ul li {
		width: 200px;
	}
    .page-title h3{}
    .page-title h3 span{ text-transform:capitalize; font-style:italic; font-size:18px; color:#000;}
    .page-title p{font-style:italic; font-size:14px; color:#000;}

    .page-title .dropdown .avatar{ width:50px; height:50px; margin:-30px 0px -15px 0px;}
    .page-title .dropdown .fa-bell{ color:#999 !important;} 


    .links{ display:table-cell; vertical-align: middle; width:100%; background:url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat; background-size:cover; padding:0 0px 0 0px;}
    .links .details{}
    .links .details ul{ padding:0 !important;margin:0;}
    .links .details ul li{ font-size:17px; color:#FFF;  text-align:center; display:inline-block; padding:55px 30px; border-radius:0px;
                 }
    .links .details ul li a{ font-size:18px; color:#FFF; text-decoration:none;}

    .blue_bg{ background-color:#09F !important;}
	
/*start shumsul*/
	.links .details ul {
    padding-top: 0;
    position: relative;
    z-index: 1;
    top: 0;
    max-width: 611px;
    margin: 0 auto;
}

.page-inner {
    /* margin-top: 108px; */
	/* padding: 0 0 76px; */
}

/* .centerTop{
	top:200px !important;
} */
/*End shumsul*/


br {
    display: none !important;
}
    @media (max-width:767px){
      .links .details ul li{ margin:40px 0px 0px 0px;}
      .links .details ul li:last-child{margin-bottom:40px;}
       
	   .links .details ul {
        top: 5px;
         }
		 
		 .centerTop{
	    /* top:20px !important; */
}

      }
      /* .custom-container {
              margin-top: 20px;
          } */
      
    @media (min-width:768px) and (max-width:1199px){
      .links .details ul li{ margin:40px 30px 0px 0px;}
      .links .details ul li a{font-size:20px;}
      #brak{
              display:none;
          }
      }
      
</style>

<?php /*?><div class="links">
  <div class="container">
      <div class="details">
          <ul>
            <a href="<?php echo site_url("staff"); ?>" onclick="return ravi();"><li class="blue_bg">Manage <br>Employees</li></a>
            <a href="<?php echo site_url("performance-cycle"); ?>"> <li>Manage  <br>Performance Cycles</li> </a><br />
            <a href="<?php echo site_url("business-attributes"); ?>"><li>Manage<br> General Settings</li></a>
            <a href="<?php echo site_url("upload-data"); ?>"><li class="blue_bg">Manage  <br> Upload Files</li></a>
            
            </ul>
        </div>
    </div>
</div><?php */?>

<div class="links">
  <div class="container">
      <?php echo $this->session->flashdata('msg');  ?>
      <div class="details">
	 
          <ul class="text-center">
             <a href="<?php echo site_url("dashboard/hr"); ?>"><li style="margin-left:2px;"> 
            <div class="icon-box">
            	<!--<i class="fa fa-cogs sky-blue"></i>

                <h5>HR</h5>-->
				<?php if($this->session->userdata('role_ses') == CV_ROLE_BUSINESS_UNIT_HEAD){ ?>
				<img src="<?php echo base_url() ?>assets/img/bussiness-unit-head.png" class="img-thumbnail">
				<?php }else{ ?>
				<img src="<?php echo base_url() ?>assets/img/hr1.png" class="img-thumbnail">
				<?php } ?>
            </div></li></a>
            <?php if($this->session->userdata('is_manager_ses')==1) { ?>
            <a href="<?php echo site_url("manager/myteam"); ?>">
            <li>
            <div class="icon-box">
            	<!--<i class="fa fa-users red"></i>
                <h5>My Team</h5>-->
				<img src="<?php echo base_url() ?>assets/img/admin7.png" class="img-thumbnail">
            </div>
            </li>
            </a>
            <?php } ?>
             <a href="<?php echo site_url("manager/self"); ?>"><li> 
            <div class="icon-box">
            	<!--<i class="fa fa-user sky-blue" ></i>

                <h5>MySelf</h5>-->
				<img src="<?php echo base_url() ?>assets/img/admin8.png" class="img-thumbnail">
            </div></li></a>
            
            
          </ul> 
	 
          <br />
            <br />
            <p></p>
            <br />
        </div>
    </div>
</div>


<audio id="dv_correct_sound" >

  <source src="<?php echo base_url();?>audio/thank_you_for_calling.mp3" type="audio/mpeg" />

</audio>
<script type="text/javascript">
<?php if($this->session->userdata('username_ses')){?>
	<?php /*?>play_msg('Welcome to <?php echo $this->session->userdata('username_ses'); ?> on Dashboard.');<?php */?>
<?php } ?>
//ravi();
function ravi()
{
  document.getElementById('dv_correct_sound').play();
  //
  //setTimeout(function() {return true;},5000);return false;
}
function ravi1()
{
    $("#common_popup_for_alert").html('<b>Coming Soon...</b>');
     $.magnificPopup.open({
        items: {
            src: '#common_popup_for_alert'
        },
        type: 'inline'
    });
setTimeout(function(){ $('#common_popup_for_alert').magnificPopup('close');}, 3000);
}
</script>

<style>

.padding_off{padding:10px 0px 0px 0px !important; color:#000 !important;}


.links .details ul{ padding-top:10px; position:relative; z-index:1;}
.links .details ul li{ color:#666 !important; padding:30px; transition: .5s ease-in-out; }
.links .details ul li{ background:rgba(255,255,255, 0.5);}
.links .details ul li .icon-box{display:block; width:100%;}
.links .details ul li .icon-box i{ color:#FFF; padding:10px; border-radius:100%; height:80px; width:80px; font-size: 27px; padding:27px;}
.links .details ul li .icon-box h5{ font-family:"Helvetica Neue",Helvetica,Arial,sans-serif; font-size:16px;}
.links .details ul li:hover{box-shadow:0 0 15px 9px #183348; z-index:2; position:relative;}
.red{ background-color:#C30;}
.sky-blue{ background-color:#36F;}

@media(max-width:767px){.links .details ul li:hover{width:100%;}}


<?php /*?>.scroll_user{ height:200px; overflow-y:scroll;}
.inline-bttn{}
.top-menu .navbar-nav > li.inline-bttn a{ display:inline !important; margin-top:-17px !important;}<?php */?>
</style>