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

    <script src="<?php echo base_url("assets/plugins/jquery/jquery-3.3.1.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/3d-bold-navigation/js/modernizr.js"); ?>"></script>
    
</head>
<body class="page-login">

<main class="page-content">
    <div class="page-inner no-margin nomargin">
        <div id="main-wrapper" class="wth_alert">
                <div class="text-center login-logo"><img class="logo_sz" src="<?php echo base_url("assets/login_logo.png"); ?>" alt="" /></div>
                <div class="col-md-3 center panel-login" style="background: #fff;  opacity: 0.7;">
                <div class="panel-body">
                    <div class="login-box">
                        <a class="logo-name text-lg">Reset Password</a>
                       <span id="msg" class="resetpassmsg m-t-md"><?php if($msg){echo $msg;} ?></span> 
                        <form class="m-t-md" method="post" action="">
                        	<?php echo HLP_get_crsf_field();?>
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="" required>
                            </div>
                            <div class="form-group input-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="New Password" value="" maxlength="20" onBlur="validate();" required>
                                <span class="input-group-btn">
                                  <button toggle="#password" class="btn btn_white btn-default toggle-password" type="button"><i class="fa fa-fw fa-eye"></i></button>
                                </span>
                            </div>
                            <div class="form-group input-group">
                                <input type="password" id="passconf" name="passconf" class="form-control" placeholder="Confirm Password " value="" maxlength="20" onBlur="validate();" required>
                                <span class="input-group-btn">
                                  <button toggle="#passconf" class="btn btn_white btn-default toggle-password" type="button"><i class="fa fa-fw fa-eye"></i></button>
                                </span>
                            </div>
                            
                            <input type="submit" id="btn_login" value="Submit"  name="submit" class="btn btn-twitter btn-block" />
                            
                        </form>
                    </div>
                    <a href="<?php echo site_url(); ?>" class="display-block text-center m-t-md text-sm">Login</a>
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
<style>
.page-inner{background-image: url('<?php echo base_url("assets/lg_bg.jpg"); ?>');margin: 0 !important;}
#main-wrapper{margin-top: 10% !important;}
#main-wrapper.wth_alert{margin-top: 5.5% !important;}
.page-content {background-image: url(<?php echo base_url("assets/lg_bg.jpg"); ?>);}
</style>

<script>
function validate()
{
    var new_password = $('#password').val();
    var confirm_password = $('#passconf').val();
    if(confirm_password=='' || new_password == '')
    {   return;     }
    
    var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!~#%*?&])[A-Za-z\d$@$!~#%*?&]{8,}/;
    if(!pattern.test(new_password))
    {
        custom_alert_popup('Password must contain at least 8 characters including \n one uppercase letter, one lowercase letter, one number and one special character.');
        $('#password').val('');
        return;
    }
        
    if(new_password != confirm_password)
    {
        custom_alert_popup('New password and confirm password are not same.');
        $('#passconf').val('');  
    }
}

</script>
</body>
</html>