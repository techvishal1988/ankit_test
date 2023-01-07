<!DOCTYPE html>
<html>

    <!-- Title -->
    <title><?php echo $title; ?></title>
    <meta name="google" content="notranslate" />
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
    <link href="<?php echo base_url("assets/plugins/slidepushmenus/css/component.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/weather-icons-master/css/weather-icons.min.css"); ?>" rel="stylesheet" type="text/css"/>	
    <link href="<?php echo base_url("assets/plugins/metrojs/MetroJs.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css" />	

        
    <!-- Theme Styles -->
    <link href="<?php echo base_url("assets/css/modern.min.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/custom.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/samshul.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/common.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/modern_v2.css"); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url("assets/css/common.css"); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/jquery-confirm.css"); ?>">
  
   
    
    <script src="<?php echo base_url("assets/plugins/jquery/jquery-3.3.1.min.js"); ?>"></script>
	
	<script src="<?php echo base_url("assets/js/responsivevoice.js"); ?>"></script>

    <script src="<?php echo base_url("assets/js/wow.min.js"); ?>"></script>
     
	<audio id="player1" src="" class="speech" hidden></audio>

    

<script>  
 $(window).on('load', function () {
       var browsername = $.browser.name === 'msie' ? "Internet Explorer" : $.browser.name;
       if(browsername == 'Internet Explorer'){

     $("head").append('<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/all-ie-only.css"); ?>" />'); 
    } 
 });

var BASE_URL = '<?php echo base_url(); ?>';
function play_msg(text_msg)
{
	if(text_msg !='')
	{
		responsiveVoice.speak("" + text_msg +"");
	}
}	
</script>

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
    
<div id="rpt_loading" style="position:fixed;width:100%;height:100%; top:0; z-index:99999999; background:#000;display:none; opacity:.8;">
    <img src="<?php echo base_url("assets/loading.gif"); ?>" style="margin-left:46.5%; margin-top:18%;" />
</div>

<div id="loading" style="position:fixed;width:100%;height:100%; top:0; z-index:99999999; background:#000;display:none; opacity:.8;">
    <img src="<?php echo base_url("assets/loading.gif"); ?>" style="margin-left:46.5%; margin-top:18%;" />
</div>

<script type="text/javascript">
$(function()
{
    $("#loading").show();
});

/*$(window).load(function()
{*/ 
$(window).on('load', function() { 
    $("#loading").hide(); 
});
$(window).on("load", function(){
	try
	{
		$.ready.then(function(){
			$("#loading").hide();// Both ready and loaded (document is ready & window is loaded)
		});
	}
	catch(e)
	{
		//console.log(e);
	}
})
</script>



<body class="page-header-fixed compact-menu page-horizontal-bar" id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">
    <div class="overlay"></div>
    <div id="common_popup_for_alert" class="mfp-hide common_popup_for_alert"></div>
    <?php //$this->load->view('common/search'); ?><!-- Search Form -->     
    
    <main class="page-content content-wrap">
    
        <?php $this->load->view('common/header'); ?>
    
        <div class="page-inner">
           
            
            <?php if(isset($ruleDetails)){
                $this->load->view($body,$ruleDetails);
            }else{
                $this->load->view($body);
            }
             ?>    
                
           
            
             <?php $this->load->view('common/footer'); ?>
            
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    
    <?php //$this->load->view('common/mobile-navigation.php'); ?>

    <!-- Javascripts -->
   
    <script src="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/pace-master/pace.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-blockui/jquery.blockui.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/switchery/switchery.min.js"); ?>"></script>
    <script src="<?php //echo base_url("assets/plugins/uniform/jquery.uniform.min.js"); ?>"></script>
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
    <script src=<?php echo base_url('assets/js/') ?>saveSvgAsPng.js></script>
    <script src=<?php echo base_url('assets/js/') ?>common.js></script>
    <script src="<?php echo base_url("assets/js/jquery.browser.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery-confirm.js"); ?>"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.6.11/core.js" integrity="sha256-oXaJ4U5H2gHjb5yYDoLAbqGblleajKeTEJ2rHZeXFIk=" crossorigin="anonymous"></script> -->
<!-- Common popup to give a alert msg Start -->
<style>
.common_popup_for_alert 
{
    position: relative;
   /* background: #FFF;
    padding: 20px;*/
    width: auto;
    max-width: 40%;
    margin: 75px auto;
    text-align: left;
}
.mfp-container
{
    height: 50% !important;
}
</style>
<!--  Common popup to give a alert msg End -->  

</body>
</html>