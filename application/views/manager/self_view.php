<div class="links">
  <div class="container">
      <div class="details">
          <ul>
          <?php /*?> 
             <a <?php echo get_emp_salary_review(); ?>> 
        			 <li>
                  <div class="icon-box">
      				      <img src="<?php echo base_url() ?>assets/img/icon1.png" class="img-thumbnail"> 
                  </div>
                </li>  
             </a>
          <?php */?>   
			
            <a href="<?php echo base_url('admin/template/rules'); ?>"> 
             <li>
               <div class="icon-box">
				         <img src="<?php echo base_url() ?>assets/img/icon2.png" class="img-thumbnail">
               </div>
             </li>
            </a>

            <a href="<?php echo base_url('employee/dashboard/total-rewards-statment/'); ?>"> 
              <li>
               <div class="icon-box">      	
  				      <img src="<?php echo base_url() ?>assets/img/icon3.png" class="img-thumbnail">
               </div>
              </li> 
            </a>
              <br id="brak" />
            <?php if(get_module_status('bonus_module')) { ?>
            <a <?php echo get_emp_bonus_review() ?>>
             <li>
              <div class="icon-box">
				        <img src="<?php echo base_url() ?>assets/img/icon4.png" class="img-thumbnail">
              </div>
             </li>
            </a>
            <?php } if(get_module_status('lti_module')) { ?>
            <a  <?php echo get_emp_lti_review() ?> > 
             <li>
              <div class="icon-box">    
				        <img src="<?php echo base_url() ?>assets/img/icon5.png" class="img-thumbnail">
              </div>
             </li> 
            </a>
            <?php } if(get_module_status('rnr_module')) { ?>
            <a  <?php echo get_emp_rnr_review() ?>> 
             <li>
              <div class="icon-box">    
  				      <img src="<?php echo base_url() ?>assets/img/icon6.png" class="img-thumbnail">
              </div>
             </li> 
            </a>
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
    .links .details ul{ /*text-align:center;*/ padding:0 !important;margin:0;}
    .links .details ul li{ font-size:17px; color:#FFF; display:inline-block; padding:55px 30px;  border-radius:0px;
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

<style>

.padding_off{padding:10px 0px 0px 0px !important; color:#000 !important;}


.links .details ul{ padding-top:10px; position:relative; z-index:1;}
.links .details ul li{ color:#666 !important; padding:20px; transition: .5s ease-in-out; }
.links .details ul li{ background:rgba(255,255,255, 0.5);}
.links .details ul li .icon-box{display:block; width:100%; text-align: center;}
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
