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
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
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
    <link href="<?php echo base_url("assets/css/common.css"); ?>" rel="stylesheet" type="text/css"/>
    
    <script src="<?php echo base_url("assets/plugins/3d-bold-navigation/js/modernizr.js"); ?>"></script>
    
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body class="page-login">

<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper" class="wth_alert">
                 <div class="text-center login-logo"><img class="logo_sz" src="<?php echo base_url("assets/login_logo.png"); ?>" alt="" /></div>
                <div class="col-md-3 center panel-login" style="background: #fff;  opacity: 0.7;">
                <div class="panel-body">
                    <div class="login-box">
                        <a class="logo-name text-lg">Forgot Password</a>
                       <p id="msg" class="text-center m-t-md"><?php if($msg){echo $msg;} ?></p> 
                        <form class="m-t-md" method="post" action="">
                        	<?php echo HLP_get_crsf_field();?>
                            <div class="form-group">
                                <input type="text" id="email" name="email" class="form-control" placeholder="Employee Id / Email" value="" required>
                            </div>
                            
                            <input type="submit" id="btn_login" value="Submit"  name="submit" class="btn btn-twitter btn-block" />
                            
                        </form>
                    </div>
                    <a href="<?php echo site_url(); ?>" class="display-block text-center m-t-md text-sm "><b>Click here to Login</b></a>
                </div>
                </div>
        </div><!-- Main Wrapper -->
        
        <?php $this->load->view('common/footer'); ?>
        
    </div><!-- Page Inner -->

</main><!-- Page Content -->


<!-- Javascripts -->
<script src="<?php echo base_url("assets/plugins/jquery/jquery-3.3.1.min.js"); ?>"></script>
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
<style>
.page-inner{background-image: url('<?php echo base_url("assets/lg_bg.jpg"); ?>'); margin: 0 !important;}
#main-wrapper{margin-top: 10% !important;}
#main-wrapper.wth_alert{margin-top: 5.5% !important;}
.page-content {background-image: url(<?php echo base_url("assets/lg_bg.jpg"); ?>);}
</style>
</body>
</html>
