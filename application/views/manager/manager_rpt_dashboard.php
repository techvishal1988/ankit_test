<div class="links">
  <div class="container custom-container">
      <div class="details">
          <ul>
             <a href="<?php echo site_url("report/headcount"); ?>">
              <li> 
               <div class="icon-box">
				        <img src="<?php echo base_url() ?>assets/img/headcount-report.png" class="img-thumbnail">
               </div>
              </li>
             </a>
            
            <a href="<?php echo site_url("report/salary_analysis"); ?>">
              <li >
               <div class="icon-box">
  				       <img src="<?php echo base_url() ?>assets/img/salary-analysis-report.png" class="img-thumbnail">
               </div>
              </li>
            </a>

            <a href="<?php echo site_url("report/compposition"); ?>">
             <li> 
              <div class="icon-box">
				       <img src="<?php echo base_url() ?>assets/img/comp-positioning-report.png" class="img-thumbnail">
              </div>
             </li>
            </a>
            <br class="dash" id="brak" />

            <a href="<?php echo site_url("report/pay_range"); ?>"> 
             <li>
              <div class="icon-box">
				       <img src="<?php echo base_url() ?>assets/img/pay-range-report.png" class="img-thumbnail">
              </div>
             </li>
            </a>
            
            <a href="<?php echo site_url("stack/paymix"); ?>">
             <li>
              <div class="icon-box">
				       <img src="<?php echo base_url() ?>assets/img/paymix-report.png" class="img-thumbnail">
              </div>
             </li>
            </a>
            
            <a href="<?php echo site_url("report/dbreports"); ?>" > 
             <li>
              <div class="icon-box">
                <img src="<?php echo base_url() ?>assets/img/db-report.png" class="img-thumbnail">
              </div>
             </li> 
            </a>
            
            </ul>
        </div>
    </div>
</div>


<style>
.page-inner{padding:0 0 40px;
            background: url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat !important;
            background-size: cover !important;
            display: table;
            width: 100%;}
    
.links{ display:table-cell; vertical-align: middle; width:100%; background:url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat; background-size:cover; padding:0 0px 0 0px;}


/****Dashboard csss start****/
.links .details{}
.links .details ul { padding-top: 0 !important; padding-left: 0px; position: relative; z-index: 1;  top: 0; max-width: 611px; margin: 0 auto;}
.links .details ul li a{ font-size:18px; color:#FFF; text-decoration:none;}
.links .details ul li{font-size:17px; display:inline-block; background:rgba(255,255,255, 0.5); color:#666 !important; padding:20px; transition: .5s ease-in-out; border-radius:0px; }
.links .details ul li .icon-box{display:block; width:100%; text-align: center;}
.links .details ul li .icon-box i{ color:#FFF; padding:10px; border-radius:100%; height:80px; width:80px; font-size: 27px; padding:27px;}
.links .details ul li .icon-box h5{ font-family:"Helvetica Neue",Helvetica,Arial,sans-serif; font-size:16px;}
.links .details ul li:hover{box-shadow:0 0 15px 9px #183348; z-index:2; position:relative;}
br.dash {display: none !important;}
/****Dashboard csss start****/


@media (max-width:767px)
{
.links .details ul li{ margin:40px 0px 0px 0px;}
.links .details ul li:last-child{margin-bottom:40px;}
.links .details ul {top: 5px; padding-left: 0px;}
}
      
@media (min-width:768px) and (max-width:1199px)
{
.links .details ul li{ margin:40px 30px 0px 0px;}
.links .details ul li a{font-size:20px;}
#brak{display:none;}
}

</style>
