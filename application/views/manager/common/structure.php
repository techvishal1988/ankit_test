<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title><?php echo $title; ?></title>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    
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
    <link href="<?php echo base_url("assets/plugins/slidepushmenus/css/component.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/weather-icons-master/css/weather-icons.min.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/metrojs/MetroJs.min.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/toastr/toastr.min.css"); ?>" rel="stylesheet" type="text/css"/>	
            <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,300i,400" rel="stylesheet">
     <style>
    body {
      font-family: 'Roboto', sans-serif !important;
      
    }
  </style>
    <!-- Theme Styles -->
    <link href="<?php echo base_url("assets/css/modern.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/custom.css"); ?>" rel="stylesheet" type="text/css"/>
    
    <script src="<?php echo base_url("assets/plugins/jquery/jquery-3.3.1.min.js"); ?>"></script>
    <?php /*?><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>
		$(function(){
			
				
var email = $.cookie("name")
alert(email);

if(email == "" || email == null){
	window.location.href= "index.php";
}
				
				
			
			
		});
		</script><?php */?>
    <script src="<?php echo base_url("assets/plugins/3d-bold-navigation/js/modernizr.js"); ?>"></script>
    
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js'></script>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<div id="loading" style="position:fixed;width:100%;height:100%; top:0; z-index:9999; background:#000;display:none; opacity:.5;">
    <img src="<?php echo base_url("assets/loading.gif"); ?>" style="margin-left:50%; margin-top:15%;" />
</div>

</head>
<body class="page-header-fixed compact-menu page-horizontal-bar">
    <div class="overlay"></div>
    <div id="common_popup_for_alert" class="mfp-hide common_popup_for_alert"></div>
    <?php //$this->load->view('common/search'); ?><!-- Search Form -->     
    
    <main class="page-content content-wrap">
    
        <?php $this->load->view('manager/common/header'); ?>
    
        <div class="page-inner">
           
            
            <?php $this->load->view($body); ?>    
                
           
            
             <?php $this->load->view('manager/common/footer'); ?>
            
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
    <script src="<?php echo base_url("assets/plugins/3d-bold-navigation/js/main.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/waypoints/jquery.waypoints.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-counterup/jquery.counterup.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/toastr/toastr.min.js"); ?>"></script>
    
    <script src="<?php echo base_url("assets/plugins/chartsjs/Chart.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/modern.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/pages/charts-chartjs.js"); ?>"></script> 

    <?php /*?><script src="<?php echo base_url("assets/plugins/flot/jquery.flot.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/flot/jquery.flot.time.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/flot/jquery.flot.symbol.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/flot/jquery.flot.resize.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/flot/jquery.flot.tooltip.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/curvedlines/curvedLines.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/metrojs/MetroJs.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/pages/dashboard.js"); ?>"></script> <?php */?>


<!-- Common popup to give a alert msg Start -->
<style>
.common_popup_for_alert 
{
    position: relative;
    background: #FFF;
    padding: 20px;
    width: auto;
    max-width: 40%;
    margin: 75px auto;
    text-align: center;
}
.mfp-container
{
    height: 50% !important;
}
</style>
<!--  Common popup to give a alert msg End -->  

</body>
</html>