<div class="links four_tiles">
  <div class="container custom-container">
    
      <div class="details">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
          <ul>
             <a href="<?php echo site_url('ready-to-launch-survey'); ?>">
              <li class="fr_tiles_mar_lt"> 
               <div class="icon-box">
                <img src="<?php echo base_url() ?>assets/img/launch_survey.png" class="img-thumbnail">
               </div>
              </li>
             </a>
            <a href="<?php echo site_url("survey/create"); ?>">
             <li> 
              <div class="icon-box">
               <img src="<?php echo base_url() ?>assets/img/design_survey.png" class="img-thumbnail">
              </div>
             </li>
            </a>
      
            <a href="<?php echo site_url("survey/dashboard-analytics"); ?>">
              <li >
               <div class="icon-box">
                 <img src="<?php echo base_url() ?>assets/img/dashboard.png" class="img-thumbnail">
               </div>
              </li>
            </a>
            <a href="<?php echo site_url("survey/aim-zone"); ?>"> 
             <li>
              <div class="icon-box">
               <img src="<?php echo base_url() ?>assets/img/action_planning.png" class="img-thumbnail">
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

.links.four_tiles .details{}
.links.four_tiles .details ul { padding-top: 0 !important; padding-left: 0px; position: relative; z-index: 1;  top: 0; max-width: 381px; margin: 0 auto;}
.links.four_tiles .details ul li a{ font-size:18px; color:#FFF; text-decoration:none;}
.links.four_tiles .details ul li{margin: 1px 0 2px 0px; width: 49% !important; font-size:17px; display:inline-block; background:rgba(255,255,255, 0.5); color:#666 !important; padding:20px; transition: .5s ease-in-out; border-radius:0px; }
.links.four_tiles .details ul li .icon-box{display:block; width:100%; text-align: center;}
.links .details ul li:hover{box-shadow:0 0 15px 9px #183348; z-index:2; position:relative;}
br.dash {display: none !important;}
/****Dashboard csss start****/


@media (max-width:767px)
{
.links.four_tiles .details ul{padding: 8% 0%!important;}  
.links.four_tiles .details ul li{ width: 68% !important;}
.links.four_tiles .details ul li:last-child{margin-bottom:40px;}
.links.four_tiles .details ul {top: 5px; padding-left: 0px;}
}
      
@media (min-width:768px) and (max-width:1199px)
{
.links.four_tiles .details ul li{ margin:40px 30px 0px 0px;}
.links.four_tiles .details ul li a{font-size:20px;}
#brak{display:none;}
}

</style>
