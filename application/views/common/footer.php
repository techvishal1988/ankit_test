<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<style>


.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, 
.pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover{background:#<?php echo $this->session->userdata('company_color_ses') ?> !important; border-color:#<?php echo $this->session->userdata('company_color_ses') ?> !important; }
 .jconfirm .jconfirm-box .jconfirm-buttons .btn-confirm-pop{background-color:#<?php echo $this->session->userdata('company_color_ses') ?> !important;}
  .jconfirm .jconfirm-box .jconfirm-buttons .btn-confirm-pop:hover{background-color:#<?php echo $this->session->userdata('company_color_ses') ?> !important;}

 .table.rule-list{}
 .table.rule-list tr td i{font-size:13px !important; width:23px; padding: 3px; border-radius:3px; background-color:#<?php echo $this->session->userdata('company_color_ses') ?> !important;}
 .custom_icon_color i{background-color:#<?php echo $this->session->userdata('company_color_ses') ?> !important;}
 			<?php /*?>.mycls{
	background-color: yellow !important;
}<?php */?>
.reset{
color:#<?php echo $this->session->userdata('company_color_ses') ?> !important;	
}
.modal-header{
	background-color:#<?php echo $this->session->userdata('company_color_ses') ?> !important;
}
 .ui-autocomplete {         
					  max-height: 200px; 
					  overflow-y: auto;         
					  overflow-x: hidden;         
					  padding: 0px;
					  margin: 0px;
					}
	.ui-autocomplete{
	
z-index:99999999999999999999 !important;		
}
@media only screen and (max-width: 600px) {
    #loading img {
           margin-left: 37% !important;
    margin-top: 50% !important;
    }
    .sub-menu{
            height: 255px !important;
            overflow-y: scroll !important;
    }
}
#graph{
        overflow-x: scroll;
}
.tooltipcls{
        /* color: #3DAED9 !important; */
    font-size: 15px !important;
    background: transparent !important;
    float: right;
    margin-right: 5px;
    cursor: pointer;
}
.table tr th .tooltipcls i{
        color: gray !important;
}
.table tr td .tooltipcls i{
        color: gray !important;
}
.details li{
        /* max-height: 190px; */
}
.tablealign th{
        text-align: right;
        
}
.tablealign{
        background-color: #f2f2f2;
}
.txtalignright{
    text-align: right;
}

.msgtxtalignment
{
    background-color:#f2f2f2;
	padding:10px;
}

.panel-body form fieldset legend, .mailbox-content h3
{
	background-color: rgba(255,255,255,0.8);
	padding: 5px !important;
	margin-bottom: 10px !important;
}

.user_messege{display: block;  position: fixed; bottom: 7%; right: 2%; }
.user_messege i{color: red; font-size: 18px; padding: 10px 15px; cursor: pointer; border-radius: 62%; background-color: #<?php echo $this->session->userdata("company_color_ses")?>; color: #fff; }
.user_messege:hover .survey_fix_message{visibility: visible;opacity: 1; }
.survey_fix_message { visibility: hidden; opacity: 0;
background-color: #<?php echo $this->session->userdata("company_color_ses")?>;}
.survey_fix_message i.picon{ font-size: 50px;
    position: absolute;
    right: -15px;
    bottom: -3px;
    padding: 0px;
    background-color: transparent;
    color: #<?php echo $this->session->userdata("company_color_ses")?>; }
</style>

<div class="page-footer footer navbar-fixed-bottom">
    <div class="container">
        <p class="no-s wow animated fadeInDown" data-wow-delay=".8s" style="color:#CCCCCC">
            <img src="<?php echo base_url('assets/footer_logo_new.png') ?>"/>
            <span class="foot-text">   
            designed and developed by <!-- <a href="javascript:void(0)" class="customfont" style="color: #CCCCCC;font-size: 13px;" > -->Compport IT Solutions, UAE.<!-- </a>  -->
            &nbsp;All Rights Reserved.</span>
        </p>
    </div>
</div>

<?php if($this->router->fetch_class()=="survey" and $this->session->userdata('role_ses') > 10){?>
<div style="display: none;" class="user_messege"><i class="fa fa-info" aria-hidden="true"></i>	
<div class='survey_fix_message'>
  <i class="fa picon fa-caret-right" aria-hidden="true"></i>
  <label style="line-height: 24px; font-size: 13px; text-align: left; letter-spacing: 0px;">This system is aimed and designed to protect
  your identity and individual responses as far as
  survey outcomes are concerned. There is
  nobody including the system designer who can
  view or access your individual responses in any
  form from this system.
  </label>
</div>
</div>
<?php } ?>

<script>
$(function() {
  $(".fstMultipleMode").addClass('dexpand');
});


$( function() {    
	$( "#txt_proxy_search" ).autocomplete({
		minLength: 2,        
		search: function(event, ui) {$('#loading').show();},
   		response: function(event, ui) {$('#loading').hide();},
		//source: '<?php //echo site_url("dashboard/get_users_for_proxy"); ?>',
		source: function( request, response ) {
			$.ajax({
				url: "<?php echo site_url("dashboard/get_users_for_proxy"); ?>",
				dataType: "json",
				data: {
					term: request.term
				},
				success: function( data )
				{
					if(data=="<?php echo CV_HTTP_UNAUTHORIZED ?>")
					{
						window.location = '<?php echo  site_url();?>';
					}
					else
					{
						response( data );
					}
				}
			});
		},
		select: function(event, ui) {
	 }
	});
} );

$('form').submit(function()
{
	//$(this).find("input[type='submit']").prop('disabled',true);
	//$(this).find("button[type='submit']").prop('disabled',true);
	//$(this).find("input[type='submit']").hide();
	//$(this).find("button[type='submit']").hide();
	$('#loading').show();
});

function request_confirm() {
  var ask_confirm = confirm('<?php echo CV_CONFIRMATION_MESSAGE;?>');
  if(ask_confirm) {
    $('#loading').css('z-index','99999999').css('opacity','0.8 !important');
    return true;
  } else {
    $('#loading').css('z-index','0').css('opacity','0.0 !important');
    return false;
  }
}


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
});setTimeout(function(){  common_txtcolor_set(); }, 100);
	
}



function custom_confirm_popup(frm_cls_name)
{   
	$.confirm({
		content:'<?php echo CV_CONFIRMATION_MESSAGE;?>',
		title: "Compport",
		buttons: {
			
			confirm: { 
				btnClass: 'btn-confirm-pop pull-right',
				action: function() {
				$("."+frm_cls_name).addClass("current_frm_submit_cls");
				$("."+frm_cls_name).submit();
			 }
			},
			cancel:{
			    btnClass: 'btn-cancel-pop',	
               action: function() {
				$('#loading').hide();
			}
		}
			
		}
	});setTimeout(function(){  common_txtcolor_set(); }, 100);
	
}

function request_custom_confirm(frm_cls_name)
{   
	if($("."+frm_cls_name).hasClass("current_frm_submit_cls"))
	{   
		return true;

	}
	else
	{   $('#loading').hide();
		custom_confirm_popup(frm_cls_name);
		return false;
	}
}




/***********************************************************************************/

function custom_confirm_popup_callback(msg,callback)
{   
	$.confirm({
		content:msg,
		title: "Compport",
		scrollToPreviousElementAnimate: false,
		buttons: {
			
			confirm: { 
				btnClass: 'btn-confirm-pop pull-right',
				action: function() {
				callback(true);

			 }
			},
			cancel:{
				
			    btnClass: 'btn-cancel-pop',	
               action: function() {
				callback(false);

			}
		}
			
		}
	});	setTimeout(function(){  common_txtcolor_set(); }, 100);
}


/**********************************************************************************/


/**********************************************************************************/

function custom_confirm_anchor_popup(frm_cls_name, msg)
{   
	$.confirm({
		content:msg,
		title: "Compport",
		buttons: {
			
			confirm: { 
				btnClass: 'btn-confirm-pop pull-right',
				action: function() {

				$("."+frm_cls_name).addClass("current_frm_submit_cls");
				window.location.href = $("."+frm_cls_name).attr('href');
			 }
			},
			cancel:{
			    btnClass: 'btn-cancel-pop',	
               action: function() {
				$('#loading').hide();
			}
		}
			
		}
	});setTimeout(function(){  common_txtcolor_set(); }, 100);
	
}

function request_custom_anchor_confirm(frm_cls_name, msg)
{   
	if($("."+frm_cls_name).hasClass("current_frm_submit_cls"))
	{   
		return true;
        
	}
	else
	{   $('#loading').hide();
		custom_confirm_anchor_popup(frm_cls_name, msg);
		return false;
	}
}


/**********************************************************************************/



function validate_negative_percentage_onblure_common(that, max_length=5, max_decimals=2)
{
	that.value = that.value.replace(/[^0-9.-]/g,'');
	if(isNaN(that.value))
	{
		that.value="0";
	}
	if(((that.value).split('.')).length>2)
	{
		var arr = (that.value).split('.');
		that.value=arr[0]+"."+arr[1];
	}
	
	if(((that.value).split('.')).length==2)
	{
		var arr = (that.value).split('.');
		if(arr[1].length > max_decimals)
		{
			 that.value=arr[0]+"."+arr[1].substring(0, max_decimals);
		}
		else if(arr[1].length==0)
		{
			 that.value=arr[0]+".0";
		}		    
	}
		
	if((that.value) && max_length==5 && Number(that.value)>100)//Means max value less or equal 99
	{
		that.value="";
	}
	else if((that.value) && max_length==3 && Number(that.value)>=1000)//Means max value less or equal 999
	{
		that.value="";
	}
	else if((that.value) && max_length==5 && Number(that.value) < -100)//Means max value less or equal -99
	{
		that.value="";
	}
	else if((that.value) && max_length==3 && Number(that.value) < -1000)//Means max value less or equal -999
	{
		that.value="";
	}
}

function validate_negative_percentage_onkeyup_common(that, max_length=5, max_decimals=2)
{
	that.value = that.value.replace(/[^0-9.-]/g,'');
	
	if(((that.value).split('.')).length > 2)
	{
		var arr = (that.value).split('.');
		that.value=arr[0]+"."+arr[1];
	}
	
	if(((that.value).split('.')).length == 2)
	{
		var arr = (that.value).split('.');
		if(arr[1].length > max_decimals)
		{
			 that.value=arr[0]+"."+arr[1].substring(0, max_decimals);
		} 		     
	}
		
	if((that.value) && max_length==5 && Number(that.value)>100)//Means max value less or equal 99
	{
		that.value="";
	}
	else if((that.value) && max_length==3 && Number(that.value)>=1000)//Means max value less or equal 999
	{
		that.value="";
	}
	else if((that.value) && max_length==9 && Number(that.value)>=1000000000)//Means max value less or equal 999999999
	{
		that.value="";
	}
	else if((that.value) && max_length==5 && Number(that.value) < -100)//Means max value less or equal -99
	{
		that.value="";
	}
	else if((that.value) && max_length==3 && Number(that.value) < -1000)//Means max value less or equal -999
	{
		that.value="";
	}
}

function validate_percentage_onblure_common(that, max_length=5, max_decimals=2)
{
	that.value = that.value.replace(/[^0-9.]/g,'');
	if(((that.value).split('.')).length>2)
	{
		var arr = (that.value).split('.');
		that.value=arr[0]+"."+arr[1];
	}
	
	if(((that.value).split('.')).length==2)
	{
		var arr = (that.value).split('.');
		if(arr[1].length > max_decimals)
		{
			 that.value=arr[0]+"."+arr[1].substring(0, max_decimals);
		}
		else if(arr[1].length==0)
		{
			 that.value=arr[0]+".0";
		}		    
	}
	
	if((that.value) && Number(that.value)<=0)
	{
		that.value="0";
	}
	
	if((that.value) && max_length==5 && Number(that.value)>100)//Means max value less or equal 99
	{
		that.value="";
	}
	else if((that.value) && max_length==3 && Number(that.value)>=1000)//Means max value less or equal 999
	{
		that.value="";
	}
}

function validate_percentage_onkeyup_common(that, max_length=5, max_decimals=2)
{
	that.value = that.value.replace(/[^0-9.]/g,'');
	if(((that.value).split('.')).length > 2)
	{
		var arr = (that.value).split('.');
		that.value=arr[0]+"."+arr[1];
	}
	
	if(((that.value).split('.')).length == 2)
	{
		var arr = (that.value).split('.');
		if(arr[1].length > max_decimals)
		{
			 that.value=arr[0]+"."+arr[1].substring(0, max_decimals);
		} 		     
	}
		
	if((that.value) && max_length==5 && Number(that.value)>100)//Means max value less or equal 99
	{
		that.value="";
	}
	else if((that.value) && max_length==3 && Number(that.value)>=1000)//Means max value less or equal 999
	{
		that.value="";
	}
	else if((that.value) && max_length==9 && Number(that.value)>=1000000000)//Means max value less or equal 999999999
	{
		that.value="";
	}
}

function validate_percentage_onkeyup_with_minus_sign_common(that, max_length=10, max_decimals=2)
{
	that.value = that.value.replace(/[^0-9.-]/g,'');
	if(((that.value).split('-')).length > 2)
	{
		that.value="";
	}
	if(((that.value).split('.')).length > 2)
	{
		var arr = (that.value).split('.');
		that.value=arr[0]+"."+arr[1];
	}
	
	if(((that.value).split('.')).length == 2)
	{
		var arr = (that.value).split('.');
		if(arr[1].length > max_decimals)
		{
			 that.value=arr[0]+"."+arr[1].substring(0, max_decimals);
		} 		     
	}
		
	// if((that.value) && max_length==5 && Number(that.value)>100)//Means max value less or equal 99
	// {
	// 	that.value="";
	// }
	// else if((that.value) && max_length==3 && Number(that.value)>=1000)//Means max value less or equal 999
	// {
	// 	that.value="";
	// }
	// else if((that.value) && max_length==9 && Number(that.value)>=1000000000)//Means max value less or equal 999999999
	// {
	// 	that.value="";
	// }
}

function validate_onkeyup_num(that)
{
    that.value = that.value.replace(/[^0-9]/g,'');
    if(((that.value).split('.')).length>1)
    {
        var arr = (that.value).split('.');
        that.value=arr[0];
    }
}

function validate_onblure_num(that)
{
    that.value = that.value.replace(/[^0-9]/g,'');
    if(((that.value).split('.')).length>1)
    {
        var arr = (that.value).split('.');
        that.value=arr[0];
    }

    if((that.value) && Number(that.value)<=0)
    {
        that.value="0";
    }
}
</script>
<?php /*?><script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script> <?php */?> 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

   <script>  
    (function () {  
        var  
         form = $('#datafordownload'),  
         cache_width = form.width(),  
         a4 = [595.28, 841.89]; // for a4 size paper width and height  
  
        $('#create_pdf').on('click', function () {  
            $('body').scrollTop(0);  
            createPDF();  
        });  
        //create pdf  
        function createPDF() {  
            getCanvas().then(function (canvas) {  
                var  
                 img = canvas.toDataURL("image/png"),  
                 doc = new jsPDF({  
                     unit: 'mm',  
                     format: 'a4',
                     orientation: 'landscape'
                 });  
                    doc.addImage(img, 'JPEG', 10, 10, 275, 150);  
                doc.save('Download_demo.pdf');  
                form.width(cache_width);  
            });  
        }  
  
        // create canvas object  
        function getCanvas() {  
            //form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');  
            return html2canvas(form, {  
                imageTimeout: 2000,  
                removeContainer: true  
            });  
        }  
  
    }());  
</script>  

<script>  
    /* 
 * jQuery helper plugin for examples and tests 
 */  
    (function ($) {  
        $.fn.html2canvas = function (options) {  
            var date = new Date(),  
            $message = null,  
            timeoutTimer = false,  
            timer = date.getTime();  
            html2canvas.logging = options && options.logging;  
            html2canvas.Preload(this[0], $.extend({  
                complete: function (images) {  
                    var queue = html2canvas.Parse(this[0], images, options),  
                    $canvas = $(html2canvas.Renderer(queue, options)),  
                    finishTime = new Date();  
  
                    $canvas.css({ position: 'absolute', left: 0, top: 0 }).appendTo(document.body);  
                    $canvas.siblings().toggle();  
  
                    $(window).click(function () {  
                        if (!$canvas.is(':visible')) {  
                            $canvas.toggle().siblings().toggle();  
                            throwMessage("Canvas Render visible");  
                        } else {  
                            $canvas.siblings().toggle();  
                            $canvas.toggle();  
                            throwMessage("Canvas Render hidden");  
                        }  
                    });  
                    throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br>", 4000);  
                }  
            }, options));  
  
            function throwMessage(msg, duration) {  
                window.clearTimeout(timeoutTimer);  
                timeoutTimer = window.setTimeout(function () {  
                    $message.fadeOut(function () {  
                        $message.remove();  
                    });  
                }, duration || 2000);  
                if ($message)  
                    $message.remove();  
                $message = $('<div ></div>').html(msg).css({  
                    margin: 0,  
                    padding: 10,  
                    background: "#000",  
                    opacity: 0.7,  
                    position: "fixed",  
                    top: 10,  
                    right: 10,  
                    fontFamily: 'Tahoma',  
                    color: '#fff',  
                    fontSize: 12,  
                    borderRadius: 12,  
                    width: 'auto',  
                    height: 'auto',  
                    textAlign: 'center',  
                    textDecoration: 'none'  
                }).hide().fadeIn().appendTo('body');  
            }  
        }; 
        var clicks = false;
        $('.samBar').click(function() {
            clicks ? $('.navbar').removeClass('changeNavbar') : $('.navbar').addClass('changeNavbar');
            clicks = !clicks;
            changeMenuHeight();
        });
        $(window).resize(function() {
            changeMenuHeight();
        });
        function changeMenuHeight() {
            if($(window).width() < 768) {
                $('.horizontal-bar .accordion-menu').css('min-height', $(window).height() - 60);
            } else {
                $('.horizontal-bar .accordion-menu').css('min-height', 'auto');
            }
        }
    })(jQuery);  


	function set_csrf_field()
	{
		$.get("<?php echo site_url("dashboard/get_crsf_field");?>", function(data)
		{
			if(data)
			{
				$('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val(data);
			}
		});
	}
	
	/* View password on click eye */
	$(".toggle-password").click(function() {

      $(this).find("i").toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
</script>  

<!-- /* Stop Autofill fields with browser cache */ -->
<!-- <script src="https://terrylinooo.github.io/jquery.disableAutoFill/assets/js/jquery.disableAutoFill.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function(){
	$('form').attr( "autocomplete", "off" );
	setTimeout(function(){
        $('form input[type=email]').val('');
        $('form input[type=password]').val('');
    }, 2000);
});
function loaderActivate() {
  $("#loading").show()
}

function searchTableLocal(str,id) {
	
	 var value = str.toLowerCase();
	 //console.log(value);
    $("#table_"+id+" tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}
<?php if($this->uri->segment(1)=='email-filter'){ ?>
$(document).ready(function() {
$('.fstQueryInput').each(function() {
  $(this).prop('required',false);
});
});<?php }?>
</script>  

