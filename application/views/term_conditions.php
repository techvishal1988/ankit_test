<!DOCTYPE html>
<html>
<head>        
    <!-- Title -->
    <title><?php echo $title; ?></title>        
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
     <link rel="shortcut icon" href="<?php echo base_url() ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url() ?>/favicon.ico" type="image/x-icon">
    
    <!-- Styles -->
    <link href="<?php echo base_url("assets/plugins/pace-master/themes/blue/pace-theme-flash.css"); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url("assets/plugins/uniform/css/uniform.default.min.css"); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url("assets/plugins/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/plugins/fontawesome/css/font-awesome.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/plugins/line-icons/simple-line-icons.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/waves/waves.min.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/switchery/switchery.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/plugins/3d-bold-navigation/css/style.css"); ?>" rel="stylesheet" type="text/css"/>	
    
    <!-- Theme Styles -->
    <link href="<?php echo base_url("assets/css/modern.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/custom.css"); ?>" rel="stylesheet" type="text/css"/>

    <script src="<?php echo base_url("assets/plugins/jquery/jquery-3.3.1.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/3d-bold-navigation/js/modernizr.js"); ?>"></script>
    
    
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body class="page-login">
    <style>
        .page-inner{
            background-image: url('<?php echo base_url("assets/lg_bg.jpg"); ?>');
            margin: 0 !important;
        }
        .login-logo{
                margin-bottom: 40px !important;
        }
        .panel-login{
                border-top: none !important;
				width: unset;
        }
        .login-box .logo-name{
             font-size: 16px;
                 text-align: center;
    color: #4D4D4D;
    font-weight: bold;
        }
        /*#btn_login{
            background: #4D4D4D;
        }*/
        #main-wrapper{
                margin-top: 10% !important;
        }

      
        .page-content {
            background-image: url(<?php echo base_url("assets/lg_bg.jpg"); ?>);
        }

       .tandc{display:block; width:100%;}
       .tandc h3.titttle{text-align: center;}
       .tandc p{text-align: justify;}
       .tandc .form-group{margin-left: 0px;}
       .tandc input[type=checkbox]{margin-right: 10px; margin-top: 3px;}
       .tandc .form-group label{ vertical-align: top; }
       .tandc .form-group .btnp{margin-left:10px; background-color: #4D4D4D;}
       .page-content #main-wrapper.wth_alert {
    margin-top: 9.5% !important;
}
    </style>
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper" class="wth_alert">
            <div class="text-center login-logo"><img class="logo_sz" src="<?php echo base_url("assets/login_logo.png"); ?>" alt="" /></div>
            <div class="col-md-8 col-md-offset-2" style="margin-bottom: 1%;">
               <div class="center panel-login" style="background: #fff;  /*opacity: 0.7*/;"> 
                <div class="panel-body">
                    <div class="">

                       <div class="tandc">
                        <h3 class="titttle">Terms and Condition</h3>
                      
                      
                       <?php echo $this->session->flashdata('message'); ?>
                       <P>
                           This application has been launched for users who are authorised by your company for its eligible employees under an agreement for compensation management activities. This application contains sensitive information and all users are expected to maintain the confidentiality of the information shared, processed and stored in the application with all respectives as per the confidentiality clause of your employment contract. By signing into this application and agreeing to these terms and conditions, you also consent that your personal identifiable information, which is well protected by the application's GDPR compliant application architecture, information security and Data Privacy policies of your company as well as the application developer, can be used for processing compensation related activities as per your company's rewards programs. All users have the right to withdraw the consent of sharing personal identifiable information on this application by sending a formal written communication to your company's HR representative. All users of this application also consent to respect the rights of the application developer and will not copy, reproduce, download, reverse engineer, re-publish, sell, distribute or resell the architecture design, features and functionalities of this application in any form or shape during the employment of the company or even after leaving the company. The Company and the application developer has the right to periodically get consent on the terms and conditions from all users.
                       </P>
                       <!-- <p>The company hold the sole right to revise the terms of service to make them applicable to users who are above 18 years of age and not of unsound mind and to include provisions on the right of the Company to launch, change, upgrade, impose conditions, suspend, or stop any services without prior consent of the user; user's restriction with respect to copying, reproducing, downloading, reverse engineering, re-publishing, selling, distributing or reselling the services in any form or manner; no liability of Company with respect to the information, content, structure or any trademarks of the user websites; no liability of the Company for any third party websites or links provided on the user websites; etc. The relationship creates on user a duty to periodically check the terms of service and stay updated on its requirements.</p> -->
                         <form class="form-horizontal" method="post" action="">
                          
                        	<?php echo HLP_get_crsf_field();?>
                            
                            <div class="form-group">
                                <input type="checkbox" id="txt_term" class="" name="txt_term" value="1"  required><label class="form-check-label" for="exampleCheck1">I agree to the terms and conditions.</label> 
                            </div>
                            <div class="form-group text-center">
                              <input type="submit" id="btn_login" value="Accept"  name="submit" class="btn btn-success" />
                              <a href="<?php echo site_url("logout"); ?>" class="btn btnp btn-success">Decline</a>
                            </div>
                            </div>             
              
                        </form>
                       </div>
                    </div>
                </div>
               </div>    
        </div><!-- Main Wrapper -->
        
        <?php $this->load->view('common/footer'); ?>
        
    </div><!-- Page Inner -->

</main><!-- Page Content -->


<!-- Javascripts -->

<script src="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/pace-master/pace.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/jquery-blockui/jquery.blockui.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/switchery/switchery.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/uniform/jquery.uniform.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/classie/classie.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/waves/waves.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/modern.min.js"); ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>



</body>
</html>