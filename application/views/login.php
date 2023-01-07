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
    <link href="<?php echo base_url("assets/css/common.css"); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/jquery-confirm.css"); ?>">

    
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
<style>
.page-inner{ background-image: url('<?php echo base_url("assets/lg_bg.jpg"); ?>'); margin: 0 !important;}
.page-content {background-image: url(<?php echo base_url("assets/lg_bg.jpg"); ?>);}
#main-wrapper{ margin-top: 10% !important;}
#main-wrapper.wth_alert{margin-top: 5.5% !important;}
</style>

<body class="page-login">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper" class="wth_alert">
            <div class="text-center login-logo"><img class="logo_sz" src="<?php echo base_url("assets/login_logo.png"); ?>" alt="" /></div>
            <div class="col-md-3 center panel-login" style="background: #fff;  opacity: 0.7;">
                <div class="panel-body">
                    <div class="login-box">
                        <a class="logo-name text-lg">Login to Your Account</a>
                       <p id="msg" class="text-center m-t-md">
                       <?php echo $this->session->flashdata('message'); ?>
                       <?php if($msg){echo $msg;} ?></p> 
                       <?php  if(!$sso || ($sso && $showloginbox)) { ?>
                               
                                <form autocomplete="off" class="m-t-md" method="post" action="<?php echo site_url(); ?>">
                                    <!-- Fake fields are a workaround for autofill getting the wrong fields -->
                                    <input autocomplete="off" style="display:none" type="text">
                                    <input autocomplete="off" style="display:none" type="password">
                                    <!-- Fake fields end-->
                                    <?php echo HLP_get_crsf_field();?>
                                    <div class="form-group">
                                        <input autocomplete="off" type="text" id="email" name="email" class="form-control" placeholder="Employee Id / Email" required>
                                    </div>

                                    <div class="form-group input-group">
                                    <input autocomplete="off" type="password" id="pass" name="password" class="form-control" placeholder="Password" required readonly onfocus="this.removeAttribute('readonly');">
                                    <span class="input-group-btn">
                                        <button toggle="#pass" class="btn btn-default toggle-password" type="button"><i class="fa fa-fw fa-eye"></i></button>
                                    </span>          
                                    </div>
                                    
                                    <?php if(HLP_need_to_enable_captcha()){ ?>
                                    <div class="g-recaptcha form-group captcha_rsz" style="" data-sitekey="<?php echo CV_CAPTCHA_SITE_KEY; ?>"></div>
                                    <?php } ?>
                                    <input type="submit" id="btn_login" value="Login" onClick="return checkval();" name="submit" class=" btn btn-twitter btn-block marbt15" />
                                    <?php if($sendemail){echo $sendemail;} ?>
                                    
                                </form>   <?php  } 
                                if($sso) {   ?>
                                <input name="button" id="btn_sso1" type="button" class="btn btn-twitter btn-block btn-sso-login" onClick="window.location.href='<?php echo base_url('ssologin/index.php?sso'); ?>'" value="SSO Login" />
                         
                            <?php } ?>
                    </div>
                    <?php  if(!$sso || ($sso && $showloginbox)){ ?>
                        <a style="text-decoration: none;" href="<?php echo site_url("forgot-password"); ?>" class="display-block text-center m-t-md text-sm"><b>Forgot Password?</b></a>
                            <?php
                            } ?>
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
<script src="<?php echo base_url("assets/js/jquery-confirm.js"); ?>"></script>
<?php /*?><script>
$(function()
{
	$('#btn_login').click(function()
	{		
		var email = $("#email").val();
		var pathName = email.split("@");
		var password = $("#pass").val();
		
		if(email =="" || password == "")
		{
			alert("Please check username or password");
			return false;
		}
	
		var post_data = {name: email, pass : password,is_admin:0,path : pathName[1]}
		$.post("<?php echo $base_url; ?>login",post_data, function(data, status)
		{	
			$cData = jQuery.parseJSON(data);
			console.log(data);	
			$move_to = $cData.status;
			console.log($move_to.status);
			
			if($move_to.status == 0)
			{
				$("#msg").html("Username or Password Incorrect or Your account is inactive.");
			}
			else if($move_to.status == 1)
			{
				$cmp_id=$move_to.result[0]["company_Id"];
				$desig = $move_to.result[0]["desig"];
				$.cookie("name", email);
				alert($cmp_id);
				$.cookie("company",$cmp_id);
				$.cookie("desig",$desig);
				//alert($.cookie("company"));
				
				window.location.href="index2.php"
			}	
		});		
	});
});
</script><?php */?>

<script>
function checkval()
{
	if(grecaptcha.getResponse() == "")
	{
		<?php if(HLP_need_to_enable_captcha()){ ?>
			custom_alert_popup("Please check the the captcha form!");
			return false;
		<?php } ?>
	}
	/*else
	{
		alert("Thank you");
	}*/
}
$(document).ready(function(){
    var docheight = $(document).height();
    var loginpheight = $('.page-login').height();
    if (typeof loginpheight === "undefined") {
        var basepath = '<?php echo  site_url();?>';
        window.location = basepath;
    }
});

function custom_alert_popup(alert_or_response_msg){
    $.alert({
    title: 'Compport',
    content:alert_or_response_msg,
    boxWidth: '500px',
    useBootstrap: false,
    buttons: {

        ok:{
            btnClass: 'btn-blue pull-right okbtn'
        }
    }
});
}
</script>

</body>
</html>