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
    .links .details ul{  padding:0 !important;}
    .links .details ul li{ font-size:17px; color:#FFF; display:inline-block; padding:55px 30px; border-radius:0px;
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

<div class="links">
  <div class="container custom-container"> 
      
      <div class="row">
        <div class="col-md-offset-3 col-md-6" style="padding: 0px 5px;">
        <?php if($this->session->flashdata('msg')!='') { ?>

          <div id="fmsg" class="alert alert-info alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><b><?php echo $this->session->flashdata('msg');  ?> </b></span></div>

         <!--  <div id="fmsg"><?php //echo $this->session->flashdata('msg');  ?></div> -->

            <?php } ?>
        
            
        </div>
          <div class="col-md-12">
              <div class="details">
                
	    <?php if($this->session->userdata('role_ses')<10) { ?>
            <ul>
                <a href="<?php echo site_url("staff"); ?>">
                    <li> 
                        <div class="icon-box">
                            <img src="<?php echo base_url() ?>assets/img/updated/manage_employee.png" class="img-thumbnail">
                        </div>
                    </li>
                </a>
                <?php if(get_module_status('compensation_plan')) { ?>
                    <a href="<?php echo site_url("performance-cycle"); ?>"> 
                        <li>
                            <div class="icon-box">
                                <img src="<?php echo base_url() ?>assets/img/updated/setup_comp_plans.png" class="img-thumbnail">
                            </div>
                        </li> 
                    </a>
                <?php } ?>
                <a href="<?php echo site_url('view-roles'); ?>" >
                    <li> 
                        <div class="icon-box">
                            <img src="<?php echo base_url() ?>assets/img/updated/manage_role_setup.png" class="img-thumbnail">
                        </div>
                    </li>
                </a>
                <br id="brak" />
                <?php if(get_module_status('survey_module')) { ?>
                    <a href="<?php echo base_url('survey') ?>">
                        <li>
                            <div class="icon-box">
                                <img src="<?php echo base_url() ?>assets/img/updated/manage_surveys.png" class="img-thumbnail">
                            </div>
                        </li>
                    </a>
                <?php } ?>
                <?php if(get_module_status('analytics_module')) { ?>
                    <a href="<?php echo site_url("report/headcount") ?>" >
                        <li>
                            <div class="icon-box">
                                <img src="<?php echo base_url() ?>assets/img/updated/analytics_and_reports.png" class="img-thumbnail">
                            </div>
                        </li>
                    </a>
                <?php } ?>
                <a href="<?php echo base_url('admin/tooltip') ?>"> 
                    <li>
                        <div class="icon-box">
                            <img src="<?php echo base_url() ?>assets/img/updated/manage_tooltips.png" class="img-thumbnail">
                        </div>
                    </li> 
                </a>
            </ul>
	    <?php } else if($this->session->userdata('role_ses')==10) { ?>
	  
	  	  <ul class="centerTop text-center">
            <a href="<?php echo site_url("manager/myteam"); ?>"> <li>
            <div class="icon-box">
            	<!--<i class="fa fa-compass blue_bg"></i>

                <h5> My team</h5>-->
				<img src="<?php echo base_url() ?>assets/img/admin7.png" alt="admin7" class="img-thumbnail">
            </div></li> </a>
            
            <!--<a href="<?php echo site_url("manager/view-manager-employees"); ?>"> <li>-->
            <a href="<?php echo site_url("manager/self"); ?>">
            <li>
            <div class="icon-box">
            	<!--<i class="fa fa-user red"></i>
                <h5> Myself</h5>-->
				<img src="<?php echo base_url() ?>assets/img/admin8.png" class="img-thumbnail">
            </div>
            </li>
            </a><br />
            
            
            
            </ul>
	  <?php } ?>
           <?php
          //echo '<pre />';print_r($this->session->userdata());
          if($this->session->userdata('role_ses')==11){ ?>
          <ul>
            
            
            
             
            <!--<a <?php //echo get_emp_salary_review(); ?>>-->
            <?php /*?> 
               <a <?php echo get_emp_salary_review(); ?>> 
                <li><div class="icon-box">    	
				           <img src="<?php echo base_url() ?>assets/img/icon1.png" class="img-thumbnail">
                  </div>
                </li> 
               </a>
            <?php */?>   
              <a href="<?php echo base_url('admin/template/rules'); ?>"> <li>
            <div class="icon-box">
            	<!--<i class="fa fa-list blue_bg"></i>

                <h5>Compensation Statement</h5>-->
				<img src="<?php echo base_url() ?>assets/img/icon2.png" class="img-thumbnail">
            </div></li> </a>
             <a href="<?php echo base_url('employee/dashboard/donutgraph/'); ?>"> <li>
            <div class="icon-box">
            	<!--<i class="fa fa-compass blue_bg"></i>

                <h5> Salary increase and promotion</h5>-->
				<img src="<?php echo base_url() ?>assets/img/icon3.png" class="img-thumbnail">
            </div></li> </a>
            <br id="brak" />
            <?php if(get_module_status('bonus_module')) { ?>
            <a <?php echo get_emp_bonus_review() ?>>
            <li>
            <div class="icon-box">
                <!--<i class="fa fa-user red"></i>
                <h5> Annual <br />bonus</h5>-->
				<img src="<?php echo base_url() ?>assets/img/icon4.png" class="img-thumbnail">
            </div>
            </li>
            </a>
            <?php } ?>
            <?php if(get_module_status('lti_module')) { ?>
            <a  <?php echo get_emp_lti_review() ?>> <li>
            <div class="icon-box">
                <!--<i class="fa fa-compass blue_bg"></i>
                <h5>Long term <br />incentive</h5>-->
				<img src="<?php echo base_url() ?>assets/img/icon5.png" class="img-thumbnail">
            </div></li> </a>
            <?php } ?>
            <?php if(get_module_status('rnr_module')) { ?>
            <a  <?php echo get_emp_rnr_review() ?>> <li>
            <div class="icon-box">
                <!--<i class="fa fa-compass blue_bg"></i>
                <h5>Reward and Recognition </h5>-->
				<img src="<?php echo base_url() ?>assets/img/icon6.png" class="img-thumbnail">
            </div></li> </a>
            <?php } ?>
            <?php if(helper_have_rights(CV_SURVEY, CV_INSERT_RIGHT_NAME) && get_module_status('survey_module')) { ?>
                <a href="<?php echo base_url('survey/users') ?>">
                <li>
                  <div class="icon-box">      
                   <img src="<?php echo base_url() ?>assets/img/participatesurvey.png" class="img-thumbnail">
                  </div>
                </li>
                </a>
                <?php } ?>
     
            
            
            </ul>
	  <?php } ?>
          <!-- <br />
            <br /> -->
            <!-- <p></p> -->
            <!-- <br /> -->
        </div>
          </div>
      </div>
        
    </div>
</div>


<audio id="dv_correct_sound" >

  <source src="<?php echo base_url();?>audio/thank_you_for_calling.mp3" type="audio/mpeg" />

</audio>
<script type="text/javascript">
    $(document).ready(function(){
        var theader = Math.round($('.navbar-inner').height());
        var tsidebar = Math.round($('.page-sidebar').height());
        var tfooter = Math.round($('.page-footer').height());
        var panelheight = Math.round($(document).height()); 
        var actheight = panelheight - ( theader + tsidebar + tfooter );
        var pheight = actheight +  'px !important';
        $('.page-inner').css('height', pheight);
    });

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
.links .details ul li{ color:#666 !important; padding:20px; transition: .5s ease-in-out; }
.links .details ul li{ background:rgba(255,255,255, 0.5);}
.links .details ul li .icon-box{display:block; text-align: center; width:100%;}
.links .details ul li .icon-box i{ color:#FFF; padding:10px; border-radius:100%; height:80px; width:80px; font-size: 27px; padding:27px;}
.links .details ul li .icon-box h5{  font-size:16px;}
.links .details ul li:hover{box-shadow:0 0 15px 9px #183348; z-index:2; position:relative;}
.red{ background-color:#C30;}
.sky-blue{ background-color:#36F;}

/* @media(max-width:767px){.links .details ul li:hover{width:100%;}} */


<?php /*?>.scroll_user{ height:200px; overflow-y:scroll;}
.inline-bttn{}
.top-menu .navbar-nav > li.inline-bttn a{ display:inline !important; margin-top:-17px !important;}<?php */?>
</style>
