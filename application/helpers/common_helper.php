<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI_OBJ = & get_instance();
$CI_OBJ->first_approver_arr = array();

function HLP_is_valid_web_token()
{
    $CI = & get_instance();

	if(!$CI->session->userdata('userid_ses') or !$CI->session->userdata('proxy_userid_ses') or !$CI->session->userdata('role_ses') or !$CI->session->userdata('dbname_ses') or !$CI->session->userdata('proxy_user_web_token_ses'))
	{
		redirect(site_url("logout"));
	}

	HLP_is_cross_origin_req();//To check request is coming from our server or not
	HLP_is_url_direct_access();

	$CI->db->select("web_token");
	$CI->db->from("login_user");
	$CI->db->where(array("id"=>$CI->session->userdata('proxy_userid_ses'), "web_token" => $CI->session->userdata('proxy_user_web_token_ses')));
	$data = $CI->db->get()->row_array();
	if(!$data)
	{
		redirect(site_url("logout"));
	}
}

function HLP_is_cross_origin_req()
{
	$base_url = base_url();
	//if((isset($_SERVER["HTTP_REFERER"]) and strpos($_SERVER['HTTP_REFERER'], $_SERVER['USER_PORTAL_BASE_URL']) === 0) or $_SERVER['REQUEST_METHOD'] === 'GET')
	//if((isset($_SERVER["HTTP_REFERER"]) and strpos($_SERVER['HTTP_REFERER'], CV_REQUEST_SCHEME.$_SERVER['HTTP_HOST'].$_SERVER['USER_PORTAL_BASE_URL']) === 0) or $_SERVER['REQUEST_METHOD'] === 'GET')
	if((isset($_SERVER["HTTP_REFERER"]) and strpos($_SERVER['HTTP_REFERER'], $base_url) === 0) or $_SERVER['REQUEST_METHOD'] === 'GET')
	{
		return;
	}
	redirect(site_url("logout"));
}

function HLP_generate_web_token()
{
	$salt = hash('sha256', time() . mt_rand());
    return $new_key = substr($salt, 0, 32);die;
}

function HLP_get_crsf_field()
{
    $CI = & get_instance();
	$key = '<input type="hidden" name="'. $CI->security->get_csrf_token_name().'" value="'. $CI->security->get_csrf_hash().'">';
	return $key;
}

function HLP_need_to_enable_captcha()
{
	$enable_captcha = 1;//Yes
    if(in_array($_SERVER['HTTP_HOST'], array("localhost", "preview.compport.com", "demo.compport.com")))
	{
		$enable_captcha = 0;//No
	}
	return $enable_captcha;
}

//Note :: This function is used to get amount in required format with required no of decimals
function HLP_get_formated_amount_common($amt_val, $max_decimals=0)
{
    $formated_amt_val = number_format($amt_val, $max_decimals, '.', ',');
	return $formated_amt_val;
}

//Note :: This function is used to round the value nearest to given value
function HLP_get_round_off_val($val_to_roundoff, $roundoff_to_nearest=1)
{
	//round(5004/1,0)*100; //To round nearest 1
	//round(5004/10,0)*10; //To round nearest 10
	//round(5004/25,0)*25; //To round nearest 25
	//round(5004/50,0)*50; //To round nearest 50
	//round(5004/100,0)*100; //To round nearest 100
	//round(5004/1000,0)*100; //To round nearest 1000	
    return round($val_to_roundoff/$roundoff_to_nearest, 0)*$roundoff_to_nearest;
}

//Note :: This function is used to get percentage with required no of decimals
function HLP_get_formated_percentage_common($per_val, $max_decimals=2)
{
	//$formated_per_val = round($per_val, $max_decimals);
	$formated_per_val = number_format((float)$per_val, $max_decimals, '.', '');
	return $formated_per_val;
}

function helper_have_rights($page_id, $rights_type)
{
	$CI = & get_instance();
	$rights_ses_name = $rights_type.'_rights_arr_ses';
	$rights_arr = $CI->session->userdata($rights_ses_name);
	if(in_array($page_id, $rights_arr)==true or $CI->session->userdata('role_ses')==1 or $CI->session->userdata('role_ses')==2)
	{
		return true;
	}
	else
	{

                //$pages=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43);
                if($CI->session->userdata('is_manager_ses')==1 && in_array($page_id,$rights_arr)==true)
                {
                    return true;
                }
                else {

		return false;
                }

	}
}

// Code start by omkar
function have_access($pageID,$userRights)
{
    $CI = & get_instance();
    $rights_ses_name = $userRights.'_rights_arr_ses';
    $rights_arr = $CI->session->userdata($rights_ses_name);
    if(in_array($pageID, $rights_arr)==true or $CI->session->userdata('role_ses')==1 or $CI->session->userdata('role_ses')==2)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*function HL_scan_uploaded_file($f_name, $f_relative_path)
{
	if($_SERVER['HTTP_HOST'] == "localhost")
	{
		return true;
	}
	$f_absolute_path = FCPATH.$f_relative_path;
    $curl = curl_init();	
	curl_setopt_array($curl, array(
							CURLOPT_URL => "http://scanner-service:8080/scan",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 0,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($f_absolute_path), 'name'=>$f_name),
						));
	
	$response = curl_exec($curl);
	$err = curl_error($curl);			
	curl_close($curl);
	$final_result = "Uploaded file having some virus.";
	if($err)
	{
	  $final_result = "Error :".$err;
	}
	else
	{
		if(trim($response) == "Everything ok : true")
		{
			$final_result = true;
		}			  
	}
	return $final_result;
}*/

function HL_scan_uploaded_file($f_name, $f_temp_path)
{
	if($_SERVER['HTTP_HOST'] == "localhost")
	{
		return true;
	}
    $curl = curl_init();	
	curl_setopt_array($curl, array(
							CURLOPT_URL => "http://scanner-service:8080/scan",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 0,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($f_temp_path), 'name'=>$f_name),
						));
	
	$response = curl_exec($curl);
	$err = curl_error($curl);			
	curl_close($curl);
	$final_result = "Uploaded file having some virus.";
	if($err)
	{
	  $final_result = "Error :".$err;
	}
	else
	{
		if(trim($response) == "Everything ok : true")
		{
			$final_result = true;
		}			  
	}
	return $final_result;
}

function downloadcsv($data, $f_name="") {

	$filename = time() . ".csv";
	if($f_name)
	{
		$filename = $f_name;
	}
	     

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	ExportCSVFile($data);
}
function ExportCSVFile($records)
{
	 $fh = fopen( 'php://output', 'w' );
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  fputcsv($fh, array_keys($row));
			  $heading = true;
			}
			 fputcsv($fh, array_values($row));
			 //fputcsv($fh, array_values($row), ',', "'");

		  }
  fclose($fh);
}
function createDataTable($tableid,$isSearch,$searchingindexarr,$removesortingarr,$url,$href, $callForStaffList = false, $hide_field_array = array())
{//if staff is true then execute if condition else execute previous code
   ?>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
        <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
        </script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" ></script>
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" ></script>
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" ></script>
        <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js" ></script>
        <script type="text/javascript">
	$(document).ready(function() {
		//ajax datatable pipeline start
		$.fn.dataTable.pipeline = function ( opts ) {
// Configuration options
var conf = $.extend( {
pages: 5,     // number of pages to cache
url: '',      // script url
data: null,   // function or object with parameters to send to the server
			  // matching how `ajax.data` works in DataTables
method: 'GET' // Ajax HTTP method
}, opts );

// Private variables for storing the cache
var cacheLower = -1;
var cacheUpper = null;
var cacheLastRequest = null;
var cacheLastJson = null;

return function ( request, drawCallback, settings ) {
var ajax          = false;
var requestStart  = request.start;
var drawStart     = request.start;
var requestLength = request.length;
var requestEnd    = requestStart + requestLength;

if ( settings.clearCache ) {
	// API requested that the cache be cleared
	ajax = true;
	settings.clearCache = false;
}
else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
	// outside cached data - need to make a request
	ajax = true;
}
else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
		  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
		  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
) {
	// properties changed (ordering, columns, searching)
	ajax = true;
}

// Store the request for checking next time around
cacheLastRequest = $.extend( true, {}, request );

if ( ajax ) {
	// Need data from the server
	if ( requestStart < cacheLower ) {
		requestStart = requestStart - (requestLength*(conf.pages-1));

		if ( requestStart < 0 ) {
			requestStart = 0;
		}
	}

	cacheLower = requestStart;
	cacheUpper = requestStart + (requestLength * conf.pages);

	request.start = requestStart;
	request.length = requestLength*conf.pages;

	// Provide the same `data` options as DataTables.
	if ( $.isFunction ( conf.data ) ) {
		// As a function it is executed with the data object as an arg
		// for manipulation. If an object is returned, it is used as the
		// data object to submit
		var d = conf.data( request );
		if ( d ) {
			$.extend( request, d );
		}
	}
	else if ( $.isPlainObject( conf.data ) ) {
		// As an object, the data given extends the default
		$.extend( request, conf.data );
	}
        //$("#loading").css('display','block');
	settings.jqXHR = $.ajax( {
		"type":     conf.method,
		"url":      conf.url,
		"data":     request,
		"dataType": "json",
		"cache":    false,
		"success":  function ( json ) {
                    if(json.data.length==0)
                    {
                        $("#loading").css('display','none');
                    }
                   cacheLastJson = $.extend(true, {}, json);

			if ( cacheLower != drawStart ) {
				json.data.splice( 0, drawStart-cacheLower );
			}
			if ( requestLength >= -1 ) {
				json.data.splice( requestLength, json.data.length );
			}

			drawCallback( json );
		}
	} );
}
else {
	json = $.extend( true, {}, cacheLastJson );
	json.draw = request.draw; // Update the echo for each response
	json.data.splice( 0, requestStart-cacheLower );
	json.data.splice( requestLength, json.data.length );

	drawCallback(json);
}
}
};
		$.fn.dataTable.Api.register( 'clearPipeline()', function () {
                    return this.iterator( 'table', function ( settings ) {
                    settings.clearCache = true;
                    } );
                    } );

		//ajax datatable pipeline end
		var col=0;
		var searchingindex=<?php echo json_encode( $searchingindexarr) ?>;

		var href=<?php echo json_encode( $href) ?>;
		<?php if($isSearch){ ?>
		 $('#<?php echo $tableid ?> thead th').each( function () {
			 for(var k=0;k<searchingindex.length;k++)
			 {
				 if(searchingindex[k]==col)
				 {
					 var title = $(this).text();
					// $(this).html( '<span style="    margin-left: 20px;">'+title+'<span><br /><input style="width:120px;margin-left: 20px;" type="text" placeholder="'+title+'" />' );
					$(this).html( '<span>'+title+'<span><br><input class="placeholder" type="text" placeholder="Filter" />' );
				 }
			 }


			col++;
		} );
		<?php } ?>

		<?php if($callForStaffList) {//for staff list ?>

			var table = $('#<?php echo $tableid ?>').DataTable({

				"order": [],
				"aoColumnDefs": [
					{ orderable: false, targets: 1 },
					{ orderable: false, targets: 2 }
				],
				"processing": true,
				"serverSide": true,
				"ajax": $.fn.dataTable.pipeline( {
					url: '<?php echo $url ?>',
					pages: 5 // number of pages to cache
				} ),
				"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
					$("#loading").css('display','none');
					var label='';
					var ccount='';
					if(parseInt(aData['emp_count_in_salary_rules'])<=0 && parseInt(aData['emp_count_in_bonus_rules'])<= 0)
					{
						ccount='';
					}
					else
					{
						//ccount+='1';
					}

					for(var l=0;l<href.length;l++)
					{
						if(aData[href[l]["label"]]==undefined)
						{
							label=href[l]["label"];
						}
						else
						{
							label=aData[href[l]["label"]];

							if(parseInt(label)==1)
							{
								label='<a '+href[l]["javascript"]+' href="'+href[l]["url"]+aData['id']+'/'+0+'/staff">Active</a>';
							} else if(parseInt(label)==0) {

								label='<a '+href[l]["javascript"]+' href="'+href[l]["url"]+''+aData['id']+'/'+1+'/staff">Inactive</a>';
							}

							//$("td:first", nRow).html(iDisplayIndex +1);
							$('td:eq('+href[l]['where']+')', nRow).html(label);
							//$("td:first", nRow).html(iDisplayIndex +1);
							$('td:eq('+href[l]['where']+')', nRow).html('<a ' +href[l]["javascript"]+ ' href="'+href[l]["url"]+'' + aData[href[l]["end"]] + '/' + href[l]["customparams"] + '">' +
							label + '</a>');
						}

						if(Array.isArray(href[l]))
						{
							var nar=href[l];
							var str='';
							label='';
							for(var nr=0; nr<nar.length;nr++)
							{
								if(aData[nar[nr]["label"]]==undefined)
								{
									label=nar[nr]["label"];
								}
								else
								{
									label=aData[nar[nr]["label"]];
								}

								if(ccount=='')
								{
									str +='<a ' +nar[nr]["javascript"]+ ' href="'+nar[nr]["url"]+'' + aData[nar[nr]["end"]] + '/' + nar[nr]["customparams"] + '">' + label + '</a> | ';

								}
								else
								{
									if(label=='Delete')
									{
									str +='<a ' +nar[nr]["javascript"]+ ' href="'+nar[nr]["url"]+'' + aData[nar[nr]["end"]] + '/' + nar[nr]["customparams"] + '">' + label + '</a> | ';
									}
								}

							}

							//$("td:first", nRow).html(iDisplayIndex +1);
							$('td:eq('+href[l][0]['where']+')', nRow).html(str.slice(0,-3));

						} else {
						}
					}

					return nRow;

				},

				"columns": [
					{ "data": "name" },
					{ "data": "id" },
					{ "data": "status" },
					<?php if ($hide_field_array["employee_code"] != 'hide') { ?> { "data": "employee_code" }, <?php } ?>
					<?php if ($hide_field_array["email"] != 'hide') { ?> { "data": "email" }, <?php } ?>
					<?php if ($hide_field_array["country"] != 'hide') { ?> { "data": "country" }, <?php } ?>
					<?php if ($hide_field_array["city"] != 'hide') { ?> { "data": "city" }, <?php } ?>
					<?php if ($hide_field_array["business_level_1"] != 'hide') { ?> { "data": "group" }, <?php } ?>
					<?php if ($hide_field_array["business_level_2"] != 'hide') { ?> { "data": "division" }, <?php } ?>
					<?php if ($hide_field_array["business_level_3"] != 'hide') { ?> { "data": "business_unit_3" }, <?php } ?>
					<?php if ($hide_field_array["function"] != 'hide') { ?> { "data": "function" }, <?php } ?>
					<?php if ($hide_field_array["subfunction"] != 'hide') { ?> { "data": "subfunction" }, <?php } ?>
					<?php if ($hide_field_array["designation"] != 'hide') { ?> { "data": "desig" }, <?php } ?>
					<?php if ($hide_field_array["grade"] != 'hide') { ?> { "data": "grade" }, <?php } ?>
					<?php if ($hide_field_array["level"] != 'hide') { ?> { "data": "level" }, <?php } ?>
					<?php if ($hide_field_array["company_joining_date"] != 'hide') { ?> { "data": "company_joining_date" }, <?php } ?>
					<?php if ($hide_field_array["increment_purpose_joining_date"] != 'hide') { ?> { "data": "date_of_joining" }, <?php } ?>
					<?php if ($hide_field_array["rating_for_current_year"] != 'hide') { ?> { "data": "performance_rating" }, <?php } ?>
					<?php if ($hide_field_array["currency"] != 'hide') { ?> { "data": "currency" }, <?php } ?>
					<?php if ($hide_field_array["current_base_salary"] != 'hide') { ?> { "data": "current_base_salary" }, <?php } ?>
					<?php if ($hide_field_array["current_target_bonus"] != 'hide') { ?> { "data": "current_target_bonus" }, <?php } ?>
					<?php if ($hide_field_array["total_compensation"] != 'hide') { ?> { "data": "total_compensation" }, <?php } ?>
					<?php if ($hide_field_array["approver_1"] != 'hide') { ?> { "data": "approver_1" }, <?php } ?>
					<?php if ($hide_field_array["manager_name"] != 'hide') { ?> { "data": "manager_name" }, <?php } ?>
				],
				buttons: [
				],
				// ajax data load end
			});

		<?php } else {//previous code ?>

		var table = $('#<?php echo $tableid ?>').DataTable({
			 //dom: 'Bfrtip',

			"order": [],
			"aoColumnDefs": [
					  //{ 'orderable': false, 'targets': [<?php //echo json_encode( $removesortingarr) ?>] }
                                          { orderable: false, targets: 1 },
                                          { orderable: false, targets: 2 }
				   ],
			"processing": true,
			"serverSide": true,
			"ajax": $.fn.dataTable.pipeline( {
				url: '<?php echo $url ?>',
				pages: 5 // number of pages to cache
			} ),
			"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                                $("#loading").css('display','none');
				//alert(href.length);
				//console.log(nRow);
				var label='';
                                //console.log(aData);
                                var ccount='';
                                 if(parseInt(aData['emp_count_in_salary_rules'])<=0 && parseInt(aData['emp_count_in_bonus_rules'])<= 0)
                                    {

                                      ccount='';
                                    }
                                    else
                                    {

                                         //ccount+='1';
                                    }



			  for(var l=0;l<href.length;l++)
			  {

				  if(aData[href[l]["label"]]==undefined)
				  {
					  label=href[l]["label"];

				  }
				  else
				  {
					   label=aData[href[l]["label"]];

						if(parseInt(label)==1)
						{
							label='<a '+href[l]["javascript"]+' href="'+href[l]["url"]+aData['id']+'/'+0+'/staff">Active</a>';
						}
						  else if(parseInt(label)==0)
						  {
							 label='<a '+href[l]["javascript"]+' href="'+href[l]["url"]+''+aData['id']+'/'+1+'/staff">Inactive</a>';
						  }

                                       //  $("td:first", nRow).html(iDisplayIndex +1);
                                         $('td:eq('+href[l]['where']+')', nRow).html(label);
                                       //  $("td:first", nRow).html(iDisplayIndex +1);
				   $('td:eq('+href[l]['where']+')', nRow).html('<a ' +href[l]["javascript"]+ ' href="'+href[l]["url"]+'' + aData[href[l]["end"]] + '/' + href[l]["customparams"] + '">' +
					label + '</a>');
				  }
				  if(Array.isArray(href[l]))
				  {
					  var nar=href[l];
					  var str='';
					  label='';
                                          for(var nr=0; nr<nar.length;nr++)
					  {
						  if(aData[nar[nr]["label"]]==undefined)
							{
								label=nar[nr]["label"];
							}
							else
							{
								 label=aData[nar[nr]["label"]];
							}
                                                       if(ccount=='')
                                                       {

                                                               str +='<a ' +nar[nr]["javascript"]+ ' href="'+nar[nr]["url"]+'' + aData[nar[nr]["end"]] + '/' + nar[nr]["customparams"] + '">' +
                                                                label + '</a> | ';

                                                       }
                                                       else
                                                       {
                                                           if(label=='Delete')
                                                            {
                                                           str +='<a ' +nar[nr]["javascript"]+ ' href="'+nar[nr]["url"]+'' + aData[nar[nr]["end"]] + '/' + nar[nr]["customparams"] + '">' +
                                                            label + '</a> | ';
                                                            }
                                                       }









					  }


                      // console.log("nRow"+nRow+":: iDisplayIndex"+iDisplayIndex);
					  //$("td:first", nRow).html(iDisplayIndex +1);
					  $('td:eq('+href[l][0]['where']+')', nRow).html(str.slice(0,-3));

				  }
				  else
				  {

//				   $("td:first", nRow).html(iDisplayIndex +1);
//				   $('td:eq('+href[l]['where']+')', nRow).html('<a ' +href[l]["javascript"]+ ' href="'+href[l]["url"]+'' + aData[href[l]["end"]] + '/' + href[l]["customparams"] + '">' +
//					label + '</a>');
				  }
			}

			  return nRow;

		},
			"columns": [
				{ "data": "name" },
				{ "data": "id" },
				{ "data": "status" },
				<?php if ($hide_field_array["employee_code"] != 'hide') { ?> { "data": "employee_code" }, <?php } ?>
				<?php if ($hide_field_array["email"] != 'hide') { ?> { "data": "email" }, <?php } ?>
				<?php if ($hide_field_array["business_level_3"] != 'hide') { ?> { "data": "business_unit_3" }, <?php } ?>
				<?php if ($hide_field_array["function"] != 'hide') { ?> { "data": "function" }, <?php } ?>
				<?php if ($hide_field_array["designation"] != 'hide') { ?> { "data": "desig" }, <?php } ?>
				<?php if ($hide_field_array["grade"] != 'hide') { ?> { "data": "grade" }, <?php } ?>
				<?php if ($hide_field_array["level"] != 'hide') { ?> { "data": "level" }, <?php } ?>
				<?php if ($hide_field_array["increment_purpose_joining_date"] != 'hide') { ?> { "data": "date_of_joining" }, <?php } ?>
				<?php if ($hide_field_array["rating_for_current_year"] != 'hide') { ?> { "data": "performance_rating" }, <?php } ?>				
			],
			buttons: [
				//'copyHtml5',
			   // 'excelHtml5',
			   // 'csvHtml5',
			   // 'pdfHtml5'
			],
			// ajax data load end
		});

		<?php } ?>

		table.columns().every( function () {
		var that = this;

		$( 'input', this.header() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
                            if((this.value).length>=2) {
								$("#loading").css('display','block');
				that.search( this.value ).draw();
                            }
                            else if(event.which===8 || event.which===46)
                            {
                                that.search( this.value ).draw();
                            }
			}
		} );
	} );
        table.columns().iterator( 'column', function (ctx, idx) {
            $( table.column(idx).header() ).append('<span class="sort-icon"/>');
          } );
	} );

</script>

<?php }

function getempdesc($emparr, $empid)
{
    //echo '<pre />';
    //print_r($emparr);
    foreach($emparr as $emp)
    {
        if($emp['id']==$empid)
        {
            return $emp;
        }
    }
}

function getinformation($page_id)
{
     $CI =& get_instance();
     $result= $CI->db->query('select * from tooltip_page where tooltip_page_id='.$page_id);
     //$CI->db->last_query(); die;
      return $result->result();
}
 // Code end by omkar

function help_get_notifications($condition_arr)
{
    $CI =& get_instance();
    $CI->db->select("*");
	$CI->db->from("notifications");
	if($condition_arr)
	{
		$CI->db->where($condition_arr);
	}
	$CI->db->order_by("createdon","desc");
	return $CI->db->get()->result_array();
}

function get_emp_salary_review()
{
    $CI = get_instance();
    $CI->load->model('rule_model');
	$uid = $CI->session->userdata('userid_ses');
	$rule_dtls = $CI->rule_model->get_table_row('salary_rule_users_dtls', 'user_id', 'user_id = '.$uid.' AND rule_id IN(SELECT id FROM hr_parameter WHERE status = '.CV_STATUS_RULE_RELEASED.')', "user_id desc");

	if($rule_dtls)
	{
		//$user_dtls = $CI->rule_model->get_table_row('login_user', 'upload_id', array("id"=>$uid), "id desc");
	   	//return 'href="'.base_url('employee/dashboard/view_employee_increment_dtls/').$rule_dtls["id"].'/'.$uid.'/'.$user_dtls["upload_id"].'"';
		return 'href="'.base_url('employee/dashboard/view_emp_salary_dtls').'"';
	}
	else
	{
		$msg="custom_alert_popup('No data found.')";
		return 'href="javascript:void(0)" onclick="'.$msg.'"';
	}
}

function get_emp_bonus_review()
{
	$CI = get_instance();
    $CI->load->model('rule_model');
	$uid = $CI->session->userdata('userid_ses');
	//$rule_dtls = $CI->rule_model->get_table_row('hr_parameter_bonus', 'id', 'FIND_IN_SET('.$uid.',user_ids) and status='.CV_STATUS_RULE_RELEASED, "id desc");
	$rule_dtls = $CI->rule_model->get_table_row('bonus_rule_users_dtls', 'user_id', 'user_id = '.$uid.' AND rule_id IN(SELECT id FROM hr_parameter_bonus WHERE status = '.CV_STATUS_RULE_RELEASED.')', "user_id desc");

	if($rule_dtls)
	{
	   	return 'href="'.base_url('employee/dashboard/view_emp_bonus_dtls').'"';
	}
	else
	{
		$msg="custom_alert_popup('No data found for bonus/incentive.')";
        return 'href="javascript:void(0)" onclick="'.$msg.'"';
	}
}

function get_emp_lti_review()
{
	$CI = get_instance();
    $CI->load->model('rule_model');
	$uid = $CI->session->userdata('userid_ses');
	//$rule_dtls = $CI->rule_model->get_table_row('lti_rules', 'id', 'FIND_IN_SET('.$uid.',user_ids) and status='.CV_STATUS_RULE_RELEASED, "id desc");
	$rule_dtls = $CI->rule_model->get_table_row('lti_rule_users_dtls', 'user_id', 'user_id = '.$uid.' AND rule_id IN(SELECT id FROM lti_rules WHERE status = '.CV_STATUS_RULE_RELEASED.')', "user_id desc");

	if($rule_dtls)
	{
	   	return 'href="'.base_url('employee/view-emp-lti-dtls').'"';
	}
	else
	{
		$msg="custom_alert_popup('No data found for long term incentive.')";
		return 'href="javascript:void(0)" onclick="'.$msg.'"';
	}
}

function get_emp_rnr_review()
{
	$CI = get_instance();
    $CI->load->model('rule_model');
	$CI->load->model('performance_cycle_model');

	$uid = $CI->session->userdata('userid_ses');
	$rule_dtls = $CI->rule_model->get_table_row('proposed_rnr_dtls', 'id', array("proposed_rnr_dtls.user_id"=>$uid, "proposed_rnr_dtls.status"=>1), "id desc");

	$current_dt = date("Y-m-d");
	$rnr_rule_for_anyone = $CI->performance_cycle_model->get_rnr_rules_list(array("performance_cycle.start_date <="=>$current_dt, "performance_cycle.end_date >="=>$current_dt, "rnr_rules.status"=>6, "rnr_rules.award_type"=>4, "rnr_rules.status !="=>CV_STATUS_RULE_DELETED));

	if(($rule_dtls) or ($rnr_rule_for_anyone))
	{
		return 'href="'.base_url('employee/view-emp-rnr-dtls').'"';
	}
	else
	{
		$msg="custom_alert_popup('No data found for R & R.')";
		return 'href="javascript:void(0)" onclick="'.$msg.'"';
	}
}

//function GetEmpAllDataFromEmpId($staff_list)
//{
//    $CI = & get_instance();
//    $CI->load->model('admin_model');
//    $attrarr=[];
//    $attributes =  $CI->admin_model->staff_attributes_for_export();
//
//    foreach($attributes as $val)
//    {
//      $attrarr[$val['display_name']]=$val['display_name'];
//    }
////     echo '<pre />';
////    print_r($attrarr); die;
//    for($z=0;$z<count($staff_list);$z++)
//    {
//        $emparr=[];
//        $temparr=[];
//        $tupleData = $CI->admin_model->staffDetails($staff_list[$z]['id']);
//        $staffDetail = $CI->admin_model->completeStafDetails_fordownload(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));
//        for($k=0;$k<count($staffDetail);$k++)
//        {
//            foreach($attrarr as $at)
//            {
//                if($staffDetail[$k]['display_name']==$at)
//                {
//
//                     $emparr[$at]= $staffDetail[$k]['value'];
//                }
//
//            }
//             array_push($temparr,$emparr);
//
//        }
//
//        $staffDetail=$temparr;
//        foreach(end($staffDetail) as $key=>$val)
//        {
//           $staff_list[$z][$key] =$val;
//        }
//
//    }
//    foreach($staff_list as $key => $item) {
//
//        foreach ($item as $k=>$v)
//        {
//          if ($k === 'id') {
//            //echo $k.'<br />'; die;
//          unset($staff_list[$key][$k]);
//        }
//        }
//
//
//      }
//    return $staff_list;
//
//}

//create function for download staff list using array
function GetEmpAllDataFromEmpId_ruleList($emp_list,$rule_id) {
	$CI = & get_instance();
	$rules = $CI->db->select('*')->where('id',$rule_id)->get('hr_parameter')->row();
    $CI->load->model('admin_model');
    $CI->load->model('rule_model');
    $attrarr = [];
    $data=array('market_salary','market_salary_ctc');
    //$cond=['module_name',$data];
    $attributes = $CI->admin_model->staff_attributes_for_export($data);

    foreach ($attributes as $val) {
        $attrarr[$val['display_name']] = $val['display_name'];

        if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
        $str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
        }
		elseif($val['id']==CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR ;
        }
        elseif($val['id']==CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_CURRENT_YEAR;
        }
        elseif($val['id']==CV_BA_ID_RATING_FOR_2ND_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_3RD_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_4TH_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_5TH_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR;
        }

		else{
            $str[]="login_user.".$val['ba_name'];
        }
    }

   	$strdata = implode(",",$str);
    $emp_ids = $CI->rule_model->array_value_recursive('user_id', $emp_list);
    $empDetail = $CI->admin_model->get_emp_dtls_for_export_ruleList($strdata,$emp_ids,'',$rule_id);
	$emparr = [];
    $temparr = [];

    for ($k = 0; $k < count($empDetail); $k++) {
        foreach ($attributes as $at) {
			$emparr[$at['display_name']] = $empDetail[$k][$at['ba_name']];
        }

        if(isset($empDetail[$k]['increment_applied_on_salary'])){
				$emparr['Current Salary being reviewed']=HLP_get_formated_amount_common($empDetail[$k]["increment_applied_on_salary"]);
			}
		if(isset($empDetail[$k]['increment_applied_on_salary'])){
				$emparr['Current Salary being reviewed']=HLP_get_formated_amount_common($empDetail[$k]["increment_applied_on_salary"]);
			}
			if(isset($empDetail[$k]['current_target_bonus'])){
				$emparr['Current variable salary']=HLP_get_formated_amount_common($empDetail[$k]["current_target_bonus"]);
			}

			$total_sal_incr_per = $empDetail[$k]["manager_discretions"];
			//2
			  if($rules->salary_position_based_on == "2")//Salary Positioning Based On Quartile
                {
                  $current_position_pay_range = $empDetail[$k]["post_quartile_range_name"];
                }
                else
                {
                  // if($empDetail[$k]["market_salary"]){
                  //   $current_position_pay_range = HLP_get_formated_percentage_common(($empDetail[$k]["increment_applied_on_salary"]/$empDetail[$k]["market_salary"])*100).' %';
                  // }else{
                  //   $current_position_pay_range = 0;
                  // }
                	$current_position_pay_range = HLP_get_formated_percentage_common($empDetail[$k]["crr_val"]).'%';
                }
			$emparr['Current Positioning in pay range']=$current_position_pay_range;
			//3
			$emparr['Salary Increment Amount']=HLP_get_formated_amount_common(($empDetail[$k]["increment_applied_on_salary"]*$total_sal_incr_per)/100 - $empDetail[$k]["sp_increased_salary"]);
			//4
			$total_sal_incr_per = ($empDetail[$k]["manager_discretions"]);
			$emparr['Salary increase recommended by manager']=HLP_get_formated_percentage_common($total_sal_incr_per).' %';
			//5
			$all_hikes_total = $empDetail[$k]["performnace_based_increment"]+$empDetail[$k]["crr_based_increment"];
			$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rules->Manager_discretionary_increase/100);
			$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rules->Manager_discretionary_decrease/100);

			$emparr['Salary increase range']=  (HLP_get_formated_percentage_common($manager_max_dec_per) .'% to '. HLP_get_formated_percentage_common($manager_max_incr_per).'%' ) ;


		$emparr['Salary Comments']=$empDetail[$k]["salary_comment"];
			//}
			//6 remaining

			$emparr['Promotion Increase amount']=  HLP_get_formated_amount_common($empDetail[$k]["sp_increased_salary"]);
			//7
             $sp_per=$empDetail[$k]["sp_manager_discretions"];
			$emparr['Promotion Increase %age']=HLP_get_formated_percentage_common((float)$sp_per);
			//8
			$emparr['Promotion Comments']=$empDetail[$k]["promotion_comment"];

			$emparr['Final Total Increment Amount']=(HLP_get_formated_amount_common(($empDetail[$k]["final_salary"]-$empDetail[$k]["increment_applied_on_salary"])+$empDetail[$k]["sp_increased_salary"]));
			//9
			$emparr['Final Total increment %age']=(HLP_get_formated_percentage_common((float)$sp_per+$empDetail[$k]["manager_discretions"])).'%';
			//10
			$emparr['Final New Salary']=HLP_get_formated_amount_common($empDetail[$k]["final_salary"]);

 $totalrevised=$empDetail[$k]["current_target_bonus"] + ($empDetail[$k]["current_target_bonus"]*($empDetail[$k]["sp_manager_discretions"] + $empDetail[$k]["manager_discretions"])/100);
			$emparr['Revised Variable Salary']=HLP_get_formated_amount_common($totalrevised);
			//11

			$emparr['New Positioning in Pay range']=HLP_get_formated_percentage_common(($empDetail[$k]["final_salary"]/$empDetail[$k]["market_salary"])*100).'%';
			//12

			$emparr[$rules->esop_title]=$empDetail[$k]["esop"];
			//13
			$emparr[$rules->pay_per_title]=$empDetail[$k]["pay_per"];

			//14
			if($empDetail[$k]["retention_bonus"] !=''){
				$emparr[$rules->retention_bonus_title?$rules->retention_bonus_title:'bonus_recommendation_title']=$empDetail[$k]["retention_bonus"];
			}
			//15
			//$emparr['Reco from First additional box']='000';
       array_push($temparr, $emparr);
    }


    return $temparr;
}

function GetEmpAllDataFromEmpId($emp_list) {
    $CI = & get_instance();
    $CI->load->model('admin_model');
    $CI->load->model('rule_model');
    $attrarr = [];
    $attributes = $CI->admin_model->staff_attributes_for_export();

if($CI->session->userdata('market_data_by_ses')==CV_MARKET_SALARY_CTC_ELEMENT)
{
$benchmark_type_remove=$CI->admin_model->get_table_row('business_attribute','group_concat(id) as id',['module_name'=>CV_MARKET_SALARY_ELEMENT]);
}else
{
  $benchmark_type_remove=$CI->admin_model->get_table_row('business_attribute','group_concat(id) as id',['module_name'=>CV_MARKET_SALARY_CTC_ELEMENT]);
}
$remove_att_id=explode(',',$benchmark_type_remove['id']);
$tempattributes_array=[];
    foreach ($attributes as $val) {
        $attrarr[$val['display_name']] = $val['display_name'];
        if(in_array($val['id'],$remove_att_id)) {
            continue;
        }
        $tempattributes_array[]=$val;

        //if (in_array($val['ba_name'],array(CV_BA_NAME_BUSINESS_LEVEL_1,CV_BA_NAME_BUSINESS_LEVEL_2,CV_BA_NAME_BUSINESS_LEVEL_3,CV_BA_NAME_COUNTRY,CV_BA_NAME_CITY,CV_BA_NAME_FUNCTION,CV_BA_NAME_SUBFUNCTION,CV_BA_NAME_DESIGNATION,CV_BA_NAME_GRADE,CV_BA_NAME_LEVEL,CV_BA_NAME_EDUCATION,CV_BA_NAME_CRITICAL_TALENT,CV_BA_NAME_CRITICAL_POSITION,CV_BA_NAME_SPECIAL_CATEGORY,CV_BA_NAME_CURRENCY))) {
        if(in_array($val['id'], array(CV_BA_ID_COUNTRY, CV_BA_ID_CITY, CV_BUSINESS_LEVEL_ID_1, CV_BUSINESS_LEVEL_ID_2, CV_BUSINESS_LEVEL_ID_3, CV_FUNCTION_ID, CV_SUB_FUNCTION_ID, CV_SUB_SUB_FUNCTION_ID, CV_DESIGNATION_ID, CV_GRADE_ID, CV_LEVEL_ID, CV_BA_ID_EDUCATION, CV_BA_ID_CRITICAL_TALENT, CV_BA_ID_CRITICAL_POSITION, CV_BA_ID_SPECIAL_CATEGORY, CV_CURRENCY_ID, CV_BA_ID_COST_CENTER, CV_BA_ID_EMPLOYEE_TYPE, CV_BA_ID_EMPLOYEE_ROLE)))
		{
        	$str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
        }
		elseif($val['id']==CV_PERFORMANCE_RATING_FOR_LAST_YEAR_ID)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_LAST_YEAR ;
        }
        elseif($val['id']==CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_CURRENT_YEAR;
        }
        elseif($val['id']==CV_BA_ID_RATING_FOR_2ND_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_2ND_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_3RD_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_3RD_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_4TH_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_4TH_LAST_YEAR;
        }
         elseif($val['id']==CV_BA_ID_RATING_FOR_5TH_LAST_YEAR)
        {
            $str[] = "(SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR . ") AS " . CV_BA_NAME_RATING_FOR_5TH_LAST_YEAR;
        }
		else{
            $str[]="login_user.".$val['ba_name'];
        }
    }
    $strdata = implode(",",$str);
    $emp_ids = $CI->rule_model->array_value_recursive('id', $emp_list);
    $emparr = [];
	$temparr = [];
	$empDetail = [];

	if (!empty($strdata) && !empty($emp_ids)) {
		$empDetail = $CI->admin_model->get_emp_dtls_for_export($strdata,$emp_ids);
	}

	$req_formatted_date_fields_array = array('company_joining_date', 'increment_purpose_joining_date', 'start_date_for_role', 'end_date_for_role',
											'effective_date_of_last_salary_increase', 'effective_date_of_2nd_last_salary_increase', 'effective_date_of_3rd_last_salary_increase',
											'effective_date_of_4th_last_salary_increase', 'effective_date_of_5th_last_salary_increase', 'employee_movement_into_bonus_plan');

	for ($k = 0; $k < count($empDetail); $k++) {

		foreach ($tempattributes_array as $at) {

			if(in_array($at['ba_name'], $req_formatted_date_fields_array) && !empty($empDetail[$k][$at['ba_name']]) && $empDetail[$k][$at['ba_name']] != '0000-00-00') {
				//get formatted date
				$emparr[$at['display_name']] = getFormattedDate($empDetail[$k][$at['ba_name']]);
			} else {
				$emparr[$at['display_name']] = $empDetail[$k][$at['ba_name']];
			}
		}

		array_push($temparr, $emparr);
	}

    return $temparr;
}

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.

   return preg_replace('/__+/', '_', $string); // Replaces multiple hyphens with single one.
}
function GetEmpAllDataFromEmpIdForReport($emp_list, $cond = false)
{
	$emparr = [];
	$temparr = [];

	if (empty($emp_list)) {
		return $temparr;
	}
	//if cond is true then use updated code else use previous code
    $CI = & get_instance();
    $CI->load->model('admin_model');
    $attrarr	=  [];
	$attributes =  $CI->admin_model->staff_attributes_for_export();

	if($cond) {

		//if required other attribute then add attribute name in below array, now only required these values
		$required_attributes_array = array('employee_code', 'name', 'email', 'country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function',
		'subfunction', 'designation', 'grade', 'level', 'gender', 'company_joining_date', 'increment_purpose_joining_date', 'rating_for_current_year', 'currency', 'current_base_salary',
		'current_target_bonus', 'total_compensation', 'approver_1', 'manager_name', 'sub_subfunction', 'education', 'critical_talent', 'critical_position', 'special_category',
		'promoted_in_2_yrs', 'successor_identified', 'readyness_level', 'urban_rural_classification');

		//if required other attribute then add attribute name in below array, now only required these values
		$manage_table_fields_array = array('country', 'city', 'business_level_1', 'business_level_2', 'business_level_3', 'function', 'subfunction', 'designation', 'grade', 
		'level', 'rating_for_current_year' ,'education', 'critical_talent', 'critical_position', 'special_category', 'currency', 'sub_subfunction');

		foreach($attributes as $val)
		{
			if(in_array($val['ba_name'], $required_attributes_array)) {

				$attrarr[$val['ba_name']] =	$val['display_name'];

				if(in_array($val['ba_name'], $manage_table_fields_array)) {

					$str[] = "manage_".$val['ba_name'].".name AS ".$val['ba_name'];

				} else {

					$str[] = "login_user.".$val['ba_name'];

				}
			}
		}

	} else {

		foreach($attributes as $val)
		{
			if($val['ba_name']=='salary_after_last_increase')
			{
				break;
			}
			  $attrarr[$val['ba_name']]=$val['display_name'];
			  if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
				$str[]="manage_".$val['ba_name'].".name AS ".$val['ba_name'];
			}
			elseif($val['id'] == CV_PERFORMANCE_RATING_FOR_THIS_FISICAL_YEAR_ID) {
				$str[]= "manage_". $val['ba_name'] . ".name AS " . $val['ba_name'];//"(SELECT name FROM manage_rating_for_current_year WHERE manage_rating_for_current_year.id = login_user.".$val['ba_name'].") AS ".$val['ba_name'];
			}
			else{
				$str[]="login_user.".$val['ba_name'];
			}
		}

		foreach($attributes as $val)
		{
			if($val['ba_name']=='Gender')
			{
				$attrarr[$val['ba_name']]=$val['ba_name'];
				$str[]="login_user.".$val['ba_name'];
			}

		}

	}

	$strdata = implode(",",$str);

	$emp_ids = $CI->rule_model->array_value_recursive('id', $emp_list);

	if (!empty($strdata) && !empty($emp_ids)) {

		$empDetail = $CI->admin_model->get_emp_dtls_for_export($strdata, $emp_ids, true);

		for ($k = 0; $k < count($empDetail); $k++) {
			foreach ($attrarr as $key => $at) {
				$emparr[$at] = $empDetail[$k][$key];
				$emparr[$key] = $empDetail[$k][$key];
			}
			array_push($temparr, $emparr);
		}
	}

    return $temparr;
}
/* CB - Harshit
function GetEmpAllDataFromEmpIdForReport($staff_list)
{
    $CI = & get_instance();
    $CI->load->model('admin_model');
    $attrarr=[];
    $attributes =  $CI->admin_model->staff_attributes_for_export();

    foreach($attributes as $val)
    {
        if($val['ba_name']=='Salary after last increase')
        {
            break;
        }
      $attrarr[$val['ba_name']]=$val['ba_name'];
    }
    foreach($attributes as $val)
    {
        if($val['ba_name']=='Gender')
        {
            $attrarr[$val['ba_name']]=$val['ba_name'];
        }

    }
//     echo '<pre />';
//    print_r($attrarr); die;
    for($z=0;$z<count($staff_list);$z++)
    {
        $emparr=[];
        $temparr=[];
        $tupleData = $CI->admin_model->staffDetails($staff_list[$z]['id']);
        $staffDetail = $CI->admin_model->completeStafDetails_fordownload(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));
        for($k=0;$k<count($staffDetail);$k++)
        {
            foreach($attrarr as $at)
            {
                if($staffDetail[$k]['ba_name']==$at)
                {

                     $emparr[clean($at)]= $staffDetail[$k]['value'];
                }

            }
             array_push($temparr,$emparr);

        }

        $staffDetail=$temparr;
        foreach(end($staffDetail) as $key=>$val)
        {
           $staff_list[$z][$key] =$val;
        }

    }
    foreach($staff_list as $key => $item) {

        foreach ($item as $k=>$v)
        {
          if ($k === 'id' || $k=="Performance_Rating_for_last_year_for_reporting_only") {
            //echo $k.'<br />'; die;
          unset($staff_list[$key][$k]);
        }
        }


      }
    return $staff_list;

}*/
function GetEmpAllDataFromEmpIdForReportNew($staff_list)
{
    $CI = & get_instance();
    $CI->load->model('admin_model');
    $attrarr=[];
    $attributes =  $CI->admin_model->staff_attributes_for_export();

    foreach($attributes as $val)
    {
        $attrarr=array("Employee Full name","Email ID","Country","City","Business Unit level 1 (top level in the organisation)","Business Unit level 2 (next level up in the organisation)","Business Unit 3 = current business unit of the employee","Function","Sub Function","Designation/Title","Grade","Level","Educational qualification/ Key skill","Identified Critical talent","Identified critical position","Special category (maternity, dissability, etc)","Date of Joining the company","Date of joining for Increment purposes","Start date for role (for bonus calculation only)","End date of the role (for bonus calculation only)","Bonus/ Sales Incentive applicable","Recently Promoted","Performance Rating for this fiscal year","Currency","Current Base salary","Current target bonus","Allowance 1","Allowance 2","Allowance 3","Allowance 4","Allowance 4","Allowance 6","Allowance 7","Allowance 8","Allowance 9","Allowance 10","Total compensation");
        if(!in_array($val['ba_name'],$attrarr))
        {
            break;
        }
      $attrarr[$val['ba_name']]=$val['ba_name'];
    }
    foreach($attributes as $val)
    {
        if($val['ba_name']=='Gender')
        {
            $attrarr[$val['ba_name']]=$val['ba_name'];
        }

    }

    $SalaryTotalElement=$CI->admin_model->getSalaryTotalElement();
    $target_sal_elem=$CI->admin_model->BussinessAttr($SalaryTotalElement[0]['target_sal_elem']);
    $total_sal_elem=$CI->admin_model->BussinessAttr($SalaryTotalElement[0]['total_sal_elem']);
//         echo '<pre />';
//    print_r($target_sal_elem); die;
    for($z=0;$z<count($staff_list);$z++)
    {
        $emparr=[];
        $temparr=[];
        $tupleData = $CI->admin_model->staffDetails($staff_list[$z]['id']);
        $MarketData = $CI->admin_model->get_employee_market_salary_dtls_for_graph($staff_list[$z]['id'],$tupleData['data_upload_id']);
        $staffDetail = $CI->admin_model->completeStafDetails_fordownload(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));
        foreach($MarketData as $md)
        {
           array_push($attrarr,$md['ba_name']);
        }


//        echo '<pre />';
//        print_r($staffDetail); die;
        for($k=0;$k<count($staffDetail);$k++)
        {
            foreach($attrarr as $at)
            {
                if($staffDetail[$k]['ba_name']==$at)
                {
                    $emparr[clean($at)]=array(
                        "name"=>$staffDetail[$k]['display_name'],
                        "value"=>$staffDetail[$k]['value']
                    );
                     //$emparr[clean($at)]= $staffDetail[$k]['value'];
                }

            }
            foreach($target_sal_elem as $tse)
            {
                if($staffDetail[$k]['ba_name']==$tse['ba_name'])
                {

                   $target_salary=$target_salary+$staffDetail[$k]['value'];


                }

            }
            foreach($total_sal_elem as $tse)
            {
                if($staffDetail[$k]['ba_name']==$tse['ba_name'])
                {

                   $totalSalary=$totalSalary+$staffDetail[$k]['value'];

                }

            }

            $emparr['Total_Target_Salary']=array(
                        "name"=>'Total Target Salary',
                        "value"=>round($target_salary)
                    );
            $emparr['Total_Salary']=
                    array(
                        "name"=>'Total Salary',
                        "value"=>round($totalSalary)
                    );

             array_push($temparr,$emparr);

        }

        $staffDetail=$temparr;
        foreach(end($staffDetail) as $key=>$val)
        {
           $staff_list[$z][$key] =$val;
        }

    }
    foreach($staff_list as $key => $item) {

        foreach ($item as $k=>$v)
        {
          if ($k === 'id' || $k=="Performance_Rating_for_last_year_for_reporting_only") {
            //echo $k.'<br />'; die;
          unset($staff_list[$key][$k]);
        }
        }


      }
    return $staff_list;

}
function GetEmpAllDataFromEmpsal($staff_list)
{
    $CI = & get_instance();
    $CI->load->model('admin_model');
    $attrarr=[];
    $attributes =  $CI->admin_model->staff_attributes();
    foreach($attributes as $val)
    {
      $attrarr[$val['ba_name']]=$val['ba_name'];
    }
    for($z=0;$z<count($staff_list);$z++)
    {
        $emparr=[];
        $temparr=[];
        $tupleData = $CI->admin_model->staffDetails($staff_list[$z]['id']);
        $staffDetail = $CI->admin_model->completeStafDetails(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));
        for($k=0;$k<count($staffDetail);$k++)
        {
            foreach($attrarr as $at)
            {
                if($staffDetail[$k]['ba_name']==$at)
                {

                     $emparr[clean($at)]= $staffDetail[$k]['value'];
                }

            }
             array_push($temparr,$emparr);

        }

        $staffDetail=$temparr;
        foreach(end($staffDetail) as $key=>$val)
        {
           $staff_list[$z][$key] =$val;
        }

    }
    return $staff_list;

}

function donutgraph()
{
    $CI = get_instance();
    $CI->load->model('performance_cycle_model');
    $CI->load->model('rule_model');
    $data["salary_cycles_list"] = $CI->performance_cycle_model->get_performance_cycles(array("status"=>1, "type"=>CV_PERFORMANCE_CYCLE_SALARY_TYPE_ID));
    $end=end($data["salary_cycles_list"]);
    $data["salary_rule_list"] = $CI->performance_cycle_model->get_salary_rules_list(array("hr_parameter.performance_cycle_id"=>$end['id']));
    $data['rule_id']=$data["salary_rule_list"][0]['id'];
    $data['staff_list'] = $CI->rule_model->get_rule_wise_emp_list_for_increments($data["salary_rule_list"][0]['id']);
    $ruleID='';
    foreach($data['staff_list'] as $msl)
            {
                if($msl['id']==$CI->session->userdata('userid_ses'))
                {
                   $userId=$msl['id'];
                   $uploadID=$msl['upload_id'];
                   $ruleID=$data["salary_rule_list"][0]['id'];
                }

            }
            if($ruleID=='')
            {
               $msg="custom_alert_popup('You have not came in any rule.')";
               return 'href="javascript:void(0)" onclick="'.$msg.'"';
            }
        else {
            return 'href="'.base_url('employee/dashboard/donutgraph/').$ruleID.'/'.$userId.'/'.$uploadID.'"';
        }


}

function setManager($roleID)
{
    $CI = get_instance();
    $CI->load->model('admin_model');
    $rols= $CI->admin_model->get_table('roles','id',array('id>'=>1,'id<='=>10,'id!='=>6));
    $rids=[];
     foreach($rols as $r)
     {
         $rids[]=$r['id'];
     }

    if(in_array($roleID,$rids))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function IsHR($roleID)
{
    $CI = get_instance();
    $CI->load->model('admin_model');
    $rols= $CI->admin_model->get_table('roles','id',array('id>'=>1,'id<='=>9,'id!='=>6));
    $rids=[];
     foreach($rols as $r)
     {
         $rids[]=$r['id'];
     }
    if(in_array($roleID,$rids))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function get_managers_for_manual_bdgt($budget_type,$rule_id)
	{
		 $CI = get_instance();
                $CI->load->model('rule_model');
		if($rule_id)
		{
			$data["rule_dtls"] = $CI->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));
			$managers = $CI->rule_model->get_managers_for_manual_bdgt($data["rule_dtls"]["user_ids"]);

			if($managers)
			{
				$str = '<table class="table table-bordered">';
                $str .= '<thead><tr>';

                $str .= '<th>Manager Name</th><th>No of Employees</th><th>Calculated Budget</th>';

                if($budget_type == "Manual")
                {
	                $str .= '<th>Final Budget</th>';
	            }
	            if($budget_type == "Automated but x% can exceed")
                {
	                $str .= '<th>Percentage</th>';
	            }
                $str .= '</tr></thead><tbody>';
                $t=0;
                $TEmp=0;
				foreach ($managers as $row)
				{
					$manager_emp_budget_dtls =calculate_budgt_manager_wise($rule_id, $row['first_approver']);
					$manager_budget = $manager_emp_budget_dtls["budget"];
					$str .= '<tr><td>';
					if($row['manager_name'])
					{
				    	$str .= $row['manager_name'];
					}
					else
					{
						$str .= $row['first_approver'];
					}
	              	$t=$t+$manager_budget;
                        $TEmp=$TEmp+$manager_emp_budget_dtls["total_emps"];
	              	$str .= '</td><td>'.$manager_emp_budget_dtls["total_emps"].'</td><td>'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common($manager_budget).'
	              			<input type="hidden" value="'.$manager_budget.'" name="hf_pre_calculated_budgt[]" />
	              			<input type="hidden" id="'.$row['first_approver'].'" value="'.$row['first_approver'].'" name="hf_managers[]" /></td>';

	              	if($budget_type == "Manual")
                	{
						$str .= '<td><input type="text" class="form-control" name="txt_manual_budget_amt[]" id="txt_manual_budget_amt" placeholder="Budget Amount"  value="'.$manager_budget.'"  maxlength="10" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" required="required">
			        		</td>';
			        }

			        if($budget_type == "Automated but x% can exceed")
	                {
		                $str .= '<td><input type="text" class="form-control" name="txt_manual_budget_per[]" id="txt_manual_budget_per" placeholder="Percentage" value=""  maxlength="5" onKeyUp="validate_onkeyup(this);" onBlur="validate_onblure(this);" required="required"></td>';
		            }
			        $str .= '</tr>';
				}
                                $str.='<tr><td style="text-align: right;">Total</td><td>'.$TEmp.'</td><td >'.$manager_emp_budget_dtls['currency']['currency_type'].' '.HLP_get_formated_amount_common(($t)).'</td></tr>';
				$str .= '</tbody></table>';
				echo $str;
			}
			else
			{
				echo "";
			}
		}
	}
      function calculate_budgt_manager_wise($rule_id, $manager_email)
	{
                $CI = get_instance();
                $CI->load->model('rule_model');
		$rule_dtls =$CI->rule_model->get_rule_dtls_for_performance_cycles(array("hr_parameter.id"=>$rule_id));

		$total_max_budget = 0;
		$managers_emp_arr = $CI->rule_model->get_managers_employees("row_owner.user_id in (".$rule_dtls['user_ids'].") and row_owner.first_approver='".$manager_email."'");

		foreach($managers_emp_arr as $row)
		{
			$employee_id = $row;
                        $currency = $CI->rule_model->get_employee_salary_dtls(array("employee_salary_details.rule_id"=>$rule_id, "employee_salary_details.user_id"=>$employee_id));
			$increment_applied_on_amt = 0;
			$performnace_based_increment_percet=0;

			$users_last_tuple_dtls = $CI->rule_model->get_table_row("tuple", "*", array("tuple.user_id"=>$employee_id), "id desc");

			/*$increment_applied_on_arr = $CI->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_INCREMENT_APPLIED_ON));

			if($increment_applied_on_arr)
			{
				$increment_applied_on_amt = $increment_applied_on_arr[0]["uploaded_value"];
			}*/

			$increment_applied_on_arr = $CI->rule_model->get_salary_applied_on_elements_val($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], $rule_dtls["salary_applied_on_elements"]);

			if($increment_applied_on_arr)
			{
				foreach($increment_applied_on_arr as $salary_elem)
				{
					if($salary_elem["value"])
					{
						$increment_applied_on_amt += $salary_elem["value"];
					}
				}
			}

			$emp_salary_rating = $CI->rule_model->get_user_performance_ratings($employee_id, $users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("status"=>1, "module_name"=>CV_RATING_ELEMENT));

			$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value)
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$performnace_based_increment_percet = $value;
					}
				}
			}
			else
			{
				$performnace_based_increment_percet = $rating_dtls["all"];
			}

			$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);

			$emp_market_salary = 0;
			$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);

			//if($rule_dtls["comparative_ratio"] == "yes")
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value)
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
						$emp_market_salary_arr = $CI->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
						$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
					}
				}
			}
			else
			{
				$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
				$emp_market_salary_arr = $CI->rule_model->get_user_cell_value_frm_datum($users_last_tuple_dtls["data_upload_id"], $users_last_tuple_dtls["row_num"], array("business_attribute_id"=>$val_arr[0]));
				$emp_market_salary = $emp_market_salary_arr['uploaded_value'];
			}

			$crr_per = 0;
			if($emp_market_salary > 0)
			{
				$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;//$performnace_based_salary/$emp_market_salary;
				if($rule_dtls["comparative_ratio"] == "yes")
				{
					$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
				}
			}

			$i=0; $crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
			foreach($crr_arr as $row1)
			{
				if($i==0)
				{
					if($crr_per <= $row1["max"])
					{
						break;
					}
				}
				elseif(($i+1)==count($crr_arr))
				{
					if($crr_per > $row1["max"])
					{
						break;
					}
				}
				else
				{
					if($row1["min"] < $crr_per and $crr_per <= $row1["max"])
					{
						break;
					}
				}
				$i++;
			}

			$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
			$crr_tbl_arr = $crr_tbl_arr_temp[$i];
			$rang_index = $i;
			$crr_based_increment_percet = 0;
			$j=0;
			//if($rule_dtls["comparative_ratio"] == "yes")
			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value)
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($emp_salary_rating) and strtoupper($key_arr[1]) == strtoupper($emp_salary_rating[0]["value"]))
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
					}
					$j++;
				}
			}
			else
			{
				$crr_based_increment_percet =  $crr_tbl_arr[$j];
			}
			//CB:: Ravi on 22-12-17
			//$current_emp_total_salary = ($increment_applied_on_amt) + (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($increment_applied_on_amt*$rule_dtls["standard_promotion_increase"])/100) + (($crr_based_increment_percet*$performnace_based_increment_percet)/100);
			//$total_max_budget += $current_emp_total_salary;
			$total_max_budget += (($increment_applied_on_amt*$performnace_based_increment_percet)/100) + (($crr_based_increment_percet*$increment_applied_on_amt)/100);
		}
		//return $total_max_budget;
		return array("total_emps"=>count($managers_emp_arr), "budget"=>$total_max_budget,"currency"=>$currency);
	}
 function getBonusEmp($ruleID)
 {
   $CI = get_instance();
   $CI->load->model('manager_model');
   return $CI->manager_model->list_of_manager_emps_for_bonus_increment($ruleID);
 }
 function getBonusEmpReleased($ruleID)
 {
   $CI = get_instance();
   $CI->load->model('manager_model');
   return $CI->manager_model->list_of_manager_emps_for_bonus_increment_after_released($ruleID);
 }
 function gerLitEmp($ruleID)
 {
     $CI = get_instance();
     $CI->load->model('manager_model');
     return $CI->manager_model->list_of_manager_emps_for_lti_incentives($ruleID);
 }
 function gerLitEmpReleased($ruleID)
 {
     $CI = get_instance();
     $CI->load->model('manager_model');
     return $CI->manager_model->list_of_manager_emps_for_lti_incentives_after_released($ruleID);
 }

 function getSurveyAnswer($questionID)
 {
     $CI = get_instance();
     $CI->load->model('Survey_model');
     return $CI->Survey_model->get_data('survey_answers',$where=['question_id'=>$questionID]);
 }
 function getSurveySubQuestion($questionID)
 {
     $CI = get_instance();
     $CI->load->model('Survey_model');
     return $CI->Survey_model->get_data('survey_questions',$where=['p_qid'=>$questionID]);
 }
 function chkEmpSurvey($userID,$surveyID)
 {
     $CI = get_instance();
     $CI->load->model('Survey_model');
     $res=$CI->Survey_model->get_data('user_survey_response',$where=['survey_id'=>$surveyID,"user_id"=>$userID, "status"=>2]);
     if(count($res)==0)
     {
         return true;
     }
     else
     {
         return false;
     }
 }
 function getToolTip($page)
 {
     $CI = get_instance();
     $CI->load->model('Tooltip_model');
     return $CI->Tooltip_model->gettooltipdetail($page);
 }
 function attrTemplate($ids)
 {
     $CI = get_instance();
     $CI->load->model('Template_model');
     return $CI->Template_model->BussinessAttr($ids);
 }
 /* CB - Harshit
function GetEmpAllDataForPayRange($staff_list,$type)
{
    $empPersonal=array("Employee Full name","Email ID","Country","City","Business Unit level 1 (top level in the organisation)","Business Unit level 2 (next level up in the organisation)","Business Unit 3 = current business unit of the employee","Function","Sub Function","Designation/Title","Grade","Level","Educational qualification/ Key skill","Identified Critical talent","Identified critical position","Special category (maternity, dissability, etc)","Date of Joining the company","Date of joining for Increment purposes","Start date for role (for bonus calculation only)","End date of the role (for bonus calculation only)","Bonus/ Sales Incentive applicable","Recently Promoted","Performance Rating for this fiscal year","Currency","Current Base salary","Current target bonus","Gender");
    //Current Base salary
    $cbs=array("Market Base Salary Level Min","Market Base Salary Level 1","Market Base Salary Level 2","Market Base Salary Level 3","Company 1","Base Salary Min","Company 1 Base Salary Max","Company 1 Base Salary Average","Company 2 Base Salary Min","Company 2 Base Salary Max","Company 2 Base Salary Average","Company 3 Base Salary Min","Company 3 Base Salary Max","Company 3 Base Salary Average","Average Base Salary Min","Average Base Salary Max","Average Base Salary Average","Market Base Salary Level 4","Market Base Salary Level 5","Market Base Salary Level 6","Market Base Salary Level 7","Market Base Salary Level 8","Market Base Salary Level 9","Market Base Salary Level 10","Market Base Salary Level Max","Gender");
    // target
    $tagetArr=array("Market Target Salary Level Min","Market Target Salary Level 1","Market Target Salary Level 2","Market Target Salary Level 3","Company 1 Target Salary Min","Company 1 Target Salary Max","Company 1 Target Salary Average","Company 2 Target Salary Min","Company 2 Target Salary Max","Company 2 Target Salary Average","Company 3 Target Salary Min","Company 3 Target Salary Max","Company 3 Target Salary Average","Average Target Salary Min","Average Target Salary Max","Average Target Salary Average","Market Target Salary Level 4","Market Target Salary Level 5","Market Target Salary Level 6","Market Target Salary Level 7","Market Target Salary Level 8","Market Target Salary Level 9","Market Target Salary Level 10","Market Target Salary Level Max","Gender");

    // total
    $totalArr=array("Market Total Salary Level Min","Market Total Salary Level 1","Market Total Salary Level 2","Market Total Salary Level 3","Company 1 Total Salary Min","Company 1 Total Salary Max","Company 1 Total Salary Average","Company 2 Total Salary Min","Company 2 Total Salary Max","Company 2 Total Salary Average","Company 3 Total Salary Min","Company 3 Total Salary Max","Company 3 Total Salary Average","Average Total Salary Min","Average Total Salary Max","Average Total Salary Average","Market Total Salary Level 4","Market Total Salary Level 5","Market Total Salary Level 6","Market Total Salary Level 7","Market Total Salary Level 8","Market Total Salary Level 9","Market Total Salary Level 10","Market Total Salary Level Max","Gender");

    $CI = & get_instance();
    $CI->load->model('admin_model');
    $attrarr=[];
    $attributes =  $CI->admin_model->attributes_for_pay_range();

    // Get total elements for salary and target salary
    $SalaryTotalElement=$CI->admin_model->getSalaryTotalElement();


    $target_sal_elem=$CI->admin_model->BussinessAttr($SalaryTotalElement[0]['target_sal_elem']);
    $total_sal_elem=$CI->admin_model->BussinessAttr($SalaryTotalElement[0]['total_sal_elem']);

//    echo '<pre />';
//    print_r($target_sal_elem);
//    die;


    foreach($attributes as $val)
    {
      if(in_array($val['ba_name'],$empPersonal))
      {
          $attrarr[$val['ba_name']]=$val['ba_name'];
      }
       if($type=="base_salary")
       {
         if(in_array($val['ba_name'],$cbs))
         {
             $attrarr[$val['ba_name']]=$val['ba_name'];
         }
       }
       if($type=="target_salary")
       {
         if(in_array($val['ba_name'],$tagetArr))
         {
             $attrarr[$val['ba_name']]=$val['ba_name'];
         }
       }
       if($type=="total_salary")
       {
         if(in_array($val['ba_name'],$totalArr))
         {
             $attrarr[$val['ba_name']]=$val['ba_name'];
         }
       }
      //$attrarr[$val['ba_name']]=$val['ba_name'];
    }
//     echo '<pre />';
//    print_r($attrarr); die;
    for($z=0;$z<count($staff_list);$z++)
    {
        $target_salary=0;
        $totalSalary=0;
        $emparr=[];
        $temparr=[];
        $tupleData = $CI->admin_model->staffDetails($staff_list[$z]['id']);
        $staffDetail = $CI->admin_model->completeStafDetails_fordownload(array('row_num'=>$tupleData['row_num'],'data_upload_id'=>$tupleData['data_upload_id']));
//        echo '<pre />';
//        print_r($staffDetail); die;
        for($k=0;$k<count($staffDetail);$k++)
        {

            foreach($attrarr as $at)
            {
                if($staffDetail[$k]['ba_name']==$at)
                {

                     $emparr[clean($at)]= $staffDetail[$k]['value'];
                }

            }
            foreach($target_sal_elem as $tse)
            {
                if($staffDetail[$k]['ba_name']==$tse['ba_name'])
                {

                   $target_salary=$target_salary+$staffDetail[$k]['value'];

                }

            }
            foreach($total_sal_elem as $tse)
            {
                if($staffDetail[$k]['ba_name']==$tse['ba_name'])
                {

                   $totalSalary=$totalSalary+$staffDetail[$k]['value'];
                }

            }

            $emparr['Total_Target_Salary']=round($target_salary);
            $emparr['Total_Salary']=round($totalSalary);
            array_push($temparr,$emparr);

        }

        $staffDetail=$temparr;

        foreach(end($staffDetail) as $key=>$val)
        {
           $staff_list[$z][$key] =$val;
        }

    }
//    echo '<pre />';
//    print_r(end($staff_list));
    foreach($staff_list as $key => $item) {
        if(sizeof($item)==1)
        {
            unset($staff_list[$key]);
        }
        foreach ($item as $k=>$v)
        {
          if ($k === 'id') {
            //echo $k.'<br />'; die;
          unset($staff_list[$key][$k]);
        }
        }


      }
//          echo '<pre />';
//    print_r($staff_list);  die;
    return $staff_list;

}*/

function GetEmpAllDataForPayRange($staff_list,$type)
{
    $empPersonal=array(CV_BA_NAME_EMP_FULL_NAME, CV_BA_NAME_EMP_EMAIL, CV_BA_NAME_COUNTRY, CV_BA_NAME_CITY, CV_BA_NAME_BUSINESS_LEVEL_1, CV_BA_NAME_BUSINESS_LEVEL_2, CV_BA_NAME_BUSINESS_LEVEL_3, CV_BA_NAME_FUNCTION, CV_BA_NAME_SUBFUNCTION, CV_BA_NAME_DESIGNATION, CV_BA_NAME_GRADE, CV_BA_NAME_LEVEL, CV_BA_NAME_EDUCATION, CV_BA_NAME_CRITICAL_TALENT, CV_BA_NAME_CRITICAL_POSITION, CV_BA_NAME_SPECIAL_CATEGORY, CV_BA_NAME_COMPANY_JOINING_DATE, CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE, CV_BA_NAME_START_DATE_FOR_ROLE, CV_BA_NAME_END_DATE_FOR_ROLE, CV_BA_NAME_BONUS_INCENTIVE_APPLICABLE, CV_BA_NAME_RECENTLY_PROMOTED, CV_BA_NAME_RATING_FOR_CURRENT_YEAR, CV_BA_NAME_CURRENCY, CV_BA_NAME_CURRENT_BASE_SALARY, CV_BA_NAME_CURRENT_TARGET_BONUS, CV_BA_NAME_GENDER);
    //Current Base salary
    $cbs=array(CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_MIN, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_1, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_2, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_3, CV_BA_NAME_COMPANY_1_BASE_SALARY_MIN, CV_BA_NAME_COMPANY_1_BASE_SALARY_MAX, CV_BA_NAME_COMPANY_1_BASE_SALARY_AVERAGE, CV_BA_NAME_COMPANY_2_BASE_SALARY_MIN, company_2_base_salary_max, CV_BA_NAME_COMPANY_2_BASE_SALARY_AVERAGE, CV_BA_NAME_COMPANY_3_BASE_SALARY_MIN, CV_BA_NAME_COMPANY_3_BASE_SALARY_MAX, CV_BA_NAME_COMPANY_3_BASE_SALARY_AVERAGE, CV_BA_NAME_AVERAGE_BASE_SALARY_MIN, CV_BA_NAME_AVERAGE_BASE_SALARY_MAX, CV_BA_NAME_AVERAGE_BASE_SALARY_AVERAGE, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_4, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_5, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_6, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_7, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_8, CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_9, "Market Base Salary Level 10", CV_BA_NAME_MARKET_BASE_SALARY_LEVEL_MAX, CV_BA_NAME_GENDER);
    // target
    $tagetArr=array(CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_MIN, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_1, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_2, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_3, CV_BA_NAME_COMPANY_1_TARGET_SALARY_MIN, CV_BA_NAME_COMPANY_1_TARGET_SALARY_MAX, CV_BA_NAME_COMPANY_1_TARGET_SALARY_AVERAGE, CV_BA_NAME_COMPANY_2_TARGET_SALARY_MIN, CV_BA_NAME_COMPANY_2_TARGET_SALARY_MAX, CV_BA_NAME_COMPANY_2_TARGET_SALARY_AVERAGE, CV_BA_NAME_COMPANY_3_TARGET_SALARY_MIN, CV_BA_NAME_COMPANY_3_TARGET_SALARY_MAX, CV_BA_NAME_COMPANY_3_TARGET_SALARY_AVERAGE, CV_BA_NAME_AVERAGE_TARGET_SALARY_MIN, CV_BA_NAME_AVERAGE_TARGET_SALARY_MAX, CV_BA_NAME_AVERAGE_TARGET_SALARY_AVERAGE, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_4, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_5, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_6, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_7, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_8, CV_BA_NAME_MARKET_TARGET_SALARY_LEVEL_9,"Market Target Salary Level 10", CV_BA_NAME_MARKET_TARGET_SALARY_SEVEL_MAX, CV_BA_NAME_GENDER);

    // total
    $totalArr=array(CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_MIN, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_1, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_2, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_3, CV_BA_NAME_COMPANY_1_TOTAL_SALARY_MIN, CV_BA_NAME_COMPANY_1_TOTAL_SALARY_MAX, CV_BA_NAME_COMPANY_1_TOTAL_SALARY_AVERAGE, CV_BA_NAME_COMPANY_2_TOTAL_SALARY_MIN, company_2_sotal_salary_max, CV_BA_NAME_COMPANY_2_TOTAL_SALARY_AVERAGE, CV_BA_NAME_COMPANY_3_TOTAL_SALARY_MIN, CV_BA_NAME_COMPANY_3_TOTAL_SALARY_MAX, CV_BA_NAME_COMPANY_3_TOTAL_SALARY_AVERAGE, average_total_salary_min, average_total_salary_max, CV_BA_NAME_AVERAGE_TOTAL_SALARY_AVERAGE, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_4, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_5, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_6, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_7, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_8, CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_9, "Market Total Salary Level 10", CV_BA_NAME_MARKET_TOTAL_SALARY_LEVEL_MAX, CV_BA_NAME_GENDER);

    $CI = & get_instance();
    $CI->load->model('admin_model');
    $attrarr=[];
    $attributes =  $CI->admin_model->attributes_for_pay_range("ba_name, display_name, id");

    // Get total elements for salary and target salary
    $SalaryTotalElement=$CI->admin_model->getSalaryTotalElement("target_sal_elem, total_sal_elem");

    $target_sal_elem=$CI->admin_model->BussinessAttr($SalaryTotalElement[0]['target_sal_elem']);
    $total_sal_elem=$CI->admin_model->BussinessAttr($SalaryTotalElement[0]['total_sal_elem']);

    foreach($attributes as $val)
    {
      	if(in_array($val['ba_name'],$empPersonal))
      	{
          	$attrarr[$val['ba_name']]=$val['display_name'];
          	if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
	        	$str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
	        }else{
	            $str[]="login_user.".$val['ba_name'];
	        }
      	}
       	if($type=="base_salary")
       	{
         	if(in_array($val['ba_name'],$cbs))
         	{
             	$attrarr[$val['ba_name']]=$val['display_name'];
             	if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
		        	$str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
		        }else{
		            $str[]="login_user.".$val['ba_name'];
		        }
         	}
       	}
       	if($type=="target_salary")
       	{
         	if(in_array($val['ba_name'],$tagetArr))
         	{
             	$attrarr[$val['ba_name']]=$val['display_name'];
             	if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
		        	$str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
		        }else{
		            $str[]="login_user.".$val['ba_name'];
		        }
         	}
       	}
       	if($type=="total_salary")
       	{
         	if(in_array($val['ba_name'],$totalArr))
         	{
             	$attrarr[$val['ba_name']]=$val['display_name'];
             	if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
		        	$str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
		        }else{
		            $str[]="login_user.".$val['ba_name'];
		        }
         	}
       	}

    }

    $strdata = implode(",",$str);

	$emp_ids = $CI->rule_model->array_value_recursive('id', $staff_list);

	$emparr = [];
	$temparr = [];
	$empDetail = [];

    if (!empty($strdata) && !empty($emp_ids)) {
		$empDetail = $CI->admin_model->get_emp_dtls_for_export($strdata,$emp_ids);
	}

    for ($k = 0; $k < count($empDetail); $k++) {
    	$target_salary=0;
        $totalSalary=0;
        foreach ($attrarr as $key => $at) {
            $emparr[$at] = $empDetail[$k][$key];
            $emparr[$key] = $empDetail[$k][$key];
        }

        foreach($target_sal_elem as $tse)
        {
            if(isset($empDetail[$k][$tse['ba_name']]))
            {
               $target_salary=$target_salary+$empDetail[$k][$tse['ba_name']];
            }
        }
        foreach($total_sal_elem as $tlse)
        {
            if(isset($empDetail[$k][$tlse['ba_name']]))
            {

               $totalSalary=$totalSalary+$empDetail[$k][$tlse['ba_name']];
            }
        }

        $emparr['Total_Target_Salary']=round($target_salary);
        $emparr['Total_Salary']=round($totalSalary);


        array_push($temparr, $emparr);
	}

    return $temparr;
}


function HLP_upload_img($f_name, $f_upload_path, $f_max_size=1024, $f_ext_arr = array("jpg", "jpeg", "png", "gif"))
{
	$CI = & get_instance();
	$out_put = array();

	$f_mime_type_arr = array("image/jpeg", "image/png", "image/gif", "application/pdf");
	$f_mime_type = strtolower($_FILES[$f_name]['type']);
	//echo "<pre>";print_r($f_mime_type);die;

	$file_type = explode('.',$_FILES[$f_name]['name']);

	if(count($file_type)==2)
	{
		$f_type = strtolower(end($file_type));

		if(in_array($f_type, $f_ext_arr) and in_array($f_mime_type, $f_mime_type_arr))
		{
			$config['upload_path'] = $f_upload_path;
			$config['allowed_types'] = implode("|", $f_ext_arr);
			$config['max_size'] = $f_max_size;//In KB

			$config['encrypt_name'] = TRUE;
			$CI->load->library('upload', $config);
			$CI->upload->initialize($config);
			$CI->upload->set_allowed_types('*');
			if ($CI->upload->do_upload($f_name))
			{
				 $upload_data = $CI->upload->data();
				 $out_put[0] = $upload_data['file_name'];
				 $out_put[1] = 1;
			}
			else
			{
				$out_put[0] = $CI->upload->display_errors();
			}
		}
		else
		{
			$out_put[0] = "Invalid file format/size.";
		}
	}
	else
	{
		$out_put[0] = "Uploaded file is invalid.";
	}
	return $out_put;
}

function HLP_requested_is_valid($uid)// Check the request is by correct user/for correct user
{
    $CI = & get_instance();
	$flag = false;
	$role = $CI->session->userdata('role_ses');
	$logedin_usr_id = $CI->session->userdata('userid_ses');

	if($role <= 2)//Admin Type of Users
	{
		$flag = true;
	}
	elseif($role <= 9)//HR Type of Users
	{
		if($logedin_usr_id == $uid)//Employee Type of Users
		{
			$flag = true;
		}
		else
		{
			$hr_emps_arr = HLP_get_hr_emps_arr($logedin_usr_id);
			if($hr_emps_arr)
			{
				$current_usr_index = array_search($uid, array_column($hr_emps_arr, 'id'));
				if($current_usr_index === FALSE)
				{
					if($CI->session->userdata('is_manager_ses')==1)
					{
						$email_id = $CI->session->userdata('email_ses');
						$manager_emps_arr = HLP_get_manager_emps_arr($email_id);
						if($manager_emps_arr)
						{
							$current_usr_index = array_search($uid, array_column($manager_emps_arr, 'id'));
							if($current_usr_index === FALSE)
							{
								//$flag = false;
							}
							else
							{
								$flag = true;
							}
						}
					}
					//$flag = false;
				}
				else
				{
					$flag = true;
				}
			}
		}
	}
	elseif($role == 10)//Manager Type of Users
	{
		if($logedin_usr_id == $uid)//Employee Type of Users
		{
			$flag = true;
		}
		else
		{
			$email_id = $CI->session->userdata('email_ses');
			$manager_emps_arr = HLP_get_manager_emps_arr($email_id);
			if($manager_emps_arr)
			{
				$current_usr_index = array_search($uid, array_column($manager_emps_arr, 'id'));
				if($current_usr_index === FALSE)
				{
					//$flag = false;
				}
				else
				{
					$flag = true;
				}
			}
		}
	}
	elseif($role == 11 and $logedin_usr_id == $uid)//Employee Type of Users
	{
		$flag = true;
	}
	return $flag;
}

function HLP_get_manager_emps_arr($email_id)// Get list of user as per hr rights
{
    $CI = & get_instance();
	$CI->load->model('admin_model');
	$manager_emps_arr = $CI->admin_model->get_table('login_user', 'id', "(login_user.".CV_BA_NAME_APPROVER_1." = '$email_id' OR login_user.".CV_BA_NAME_APPROVER_2." = '$email_id' OR login_user.".CV_BA_NAME_APPROVER_3." = '$email_id' OR login_user.".CV_BA_NAME_APPROVER_4." = '$email_id')", "id DESC");
	return $manager_emps_arr;
}

function HLP_get_hr_emps_arr($hr_user_id, $is_need_usr_ids_only=0)// Get list of user as per hr rights
{   $CI = & get_instance();
	$CI->load->model('common_model');
	$CI->load->model('admin_model');

	$country_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_country","country_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_country");
	if(!$country_arr)
	{
		return array();
	}
	$city_arr =  $CI->common_model->get_user_rights_comma_seprated("rights_on_city","city_id", array("status"=>1, "user_id"=>$hr_user_id),"manage_city");
	$bl1_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_business_level_1","business_level_1_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_business_level_1");
	$bl2_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_business_level_2","business_level_2_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_business_level_2");
	$bl3_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_business_level_3","business_level_3_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_business_level_3");
	$designation_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_designations","designation_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_designation");
	$function_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_functions","function_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_function");
	$sub_function_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_sub_functions","sub_function_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_subfunction");
	$grade_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_grades","grade_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_grade");
	$level_arr = $CI->common_model->get_user_rights_comma_seprated("rights_on_levels","level_id", array("status"=>1, "user_id"=>$hr_user_id), "manage_level");

	$where ="login_user.role > 2 and login_user.status = 1";
	if($country_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_COUNTRY." in (".$country_arr.")";
	}

	if($city_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_CITY." in (".$city_arr.")";
	}

	if($bussiness_level_1_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_1." in (".$bussiness_level_1_arr.")";
	}

	if($bussiness_level_2_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_2." in (".$bussiness_level_2_arr.")";
	}

	if($bussiness_level_3_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_BUSINESS_LEVEL_3." in (".$bussiness_level_3_arr.")";
	}

	if($function_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_FUNCTION." in (".$function_arr.")";
	}

	if($sub_function_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_SUBFUNCTION." in (".$sub_function_arr.")";
	}

	if($designation_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_DESIGNATION." in (".$designation_arr.")";
	}

	if($grade_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_GRADE." in (".$grade_arr.")";
	}

	if($level_arr)
	{
		$where .= " and login_user.".CV_BA_NAME_LEVEL." in (".$level_arr.")";
	}
	if($is_need_usr_ids_only)
	{
		$CI->db->simple_query('SET SESSION group_concat_max_len=9999999');
		$hr_emps_arr = $CI->admin_model->get_table_row("login_user", "GROUP_CONCAT(CONCAT(id) SEPARATOR ',') AS usr_ids", $where, "id ASC");
	}
	else
	{
		$hr_emps_arr = $CI->admin_model->get_employees_as_per_rights($where);
	}
	return $hr_emps_arr;
}

function HLP_convert_currency($from_currency, $to_currency, $amt_val)// To use it for Currency conversion
{
	if($from_currency != $to_currency)
	{
		$CI = & get_instance();
		$CI->load->model('admin_model');
		$rates_arr = $CI->admin_model->get_table_row("currency_rates", "rate", array("from_currency"=>$from_currency, "to_currency"=>$to_currency));
		if($rates_arr)
		{
			$amt_val = $amt_val*$rates_arr["rate"];
		}
		else
		{
			$amt_val = 0;
		}
	}
	return $amt_val;
}

function HLP_get_unique_ids_for_filters($usr_ids, $frm_column_ids, $column_name)//Getting only those ids for which employees are exist for the required columns
{
	if(empty($usr_ids))
	{
		$usr_ids=0;
	}
	if(empty($frm_column_ids))
	{
		$frm_column_ids=0;
	}

	$CI = & get_instance();
	$CI->load->model('admin_model');
	$CI->db->simple_query('SET SESSION group_concat_max_len=9999999');
	$ids_arr = $CI->admin_model->get_table_row("login_user", "GROUP_CONCAT(DISTINCT(".$column_name.")) AS ids", "id in (".$usr_ids.") AND ".$column_name." in (".$frm_column_ids.")");
	return $ids_arr["ids"];
}

function HLP_get_filter_names($table_name, $column_name, $condition_arr)//Getting filter vales (Names) in comma seprated
{
	$CI = & get_instance();
	$CI->load->model('admin_model');
	$CI->db->simple_query('SET SESSION group_concat_max_len=9999999');
	$names_arr = $CI->admin_model->get_table_row($table_name, "GROUP_CONCAT(CONCAT(".$column_name.") SEPARATOR ', ') AS names", $condition_arr);
	return $names_arr["names"];
}

/*function HLP_get_managers_emps_total_budget($rule_id, $rule_user_ids, $manager_email)
{
	$CI = & get_instance();
	$CI->db->select("sum(final_salary - increment_applied_on_salary) as used_budget");
	$CI->db->from("employee_salary_details");
	$CI->db->where("employee_salary_details.rule_id = ".$rule_id." AND employee_salary_details.user_id in (select user_id from row_owner where first_approver = '".$manager_email."' AND user_id in (".$rule_user_ids."))");
	$data = $CI->db->get()->row_array();
	return $data["used_budget"];
}

function HLP_get_managers_emps_total_budget($rule_id, $manager_email)
{
	$CI = & get_instance();
	$CI->db->select("SUM(final_salary - increment_applied_on_salary) AS used_budget");
	$CI->db->from("employee_salary_details");
	$CI->db->where("employee_salary_details.rule_id = ".$rule_id." AND employee_salary_details.user_id IN (SELECT id FROM login_user WHERE ".CV_BA_NAME_APPROVER_1." = '".$manager_email."' AND id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id."))");
	$data = $CI->db->get()->row_array();
	return $data["used_budget"];
}*/

function HLP_get_managers_emps_total_budget($rule_dtls_params_arr, $manager_email)
{
	$CI = & get_instance();
	$data = $CI->db->query("SELECT IF(".$rule_dtls_params_arr["include_promotion_budget"]." = 1, SUM((final_salary*rate) - (increment_applied_on_salary*rate)), SUM((final_salary*rate) - (increment_applied_on_salary*rate) - (sp_increased_salary*rate))) AS final_total_used_budget,
SUM(increment_applied_on_salary*performnace_based_increment*rate*0.01) AS merit_allocated_budget,
SUM(increment_applied_on_salary*crr_based_increment*rate*0.01) AS market_allocated_budget,
SUM(increment_applied_on_salary*final_merit_hike*rate*0.01) AS merit_used_budget,
SUM(increment_applied_on_salary*final_market_hike*rate*0.01) AS market_used_budget,
SUM(sp_increased_salary*rate) AS promotion_used_budget,
SUM(increment_applied_on_salary*rate) AS emps_current_total_salary
FROM `employee_salary_details`
JOIN manage_currency ON UPPER(manage_currency.name) = UPPER(employee_salary_details.currency)
JOIN currency_rates ON currency_rates.from_currency = manage_currency.id AND currency_rates.to_currency = ".$rule_dtls_params_arr["to_currency_id"]."
WHERE `employee_salary_details`.`rule_id` = ".$rule_dtls_params_arr["id"]." AND employee_salary_details.approver_1 = '".$manager_email."'")->row_array();
	return $data;
}

//CB::Ravi on 20-05-19, To get all the Downline Manager's list of the given Manager

function HLP_get_downline_managers_recursive($manager_email, $rule_id)
{
	$CI = & get_instance();
	$CI->load->model('rule_model');

	$managers_list = $CI->rule_model->get_table("employee_salary_details", "DISTINCT(`approver_1`) AS approver_1", "rule_id = ".$rule_id." AND (approver_2 = '".$manager_email."' OR approver_3 = '".$manager_email."' OR approver_4 = '".$manager_email."')", "id ASC");
	if($managers_list)
	{
		foreach($managers_list as $row)
		{
			//$CI->first_approver_arr[] = strtolower($row[CV_BA_NAME_EMP_EMAIL]);
			if(!in_array(strtolower($row["approver_1"]), $CI->first_approver_arr))
			{
				$CI->first_approver_arr[] = strtolower($row["approver_1"]);
				//HLP_get_downline_managers_recursive($row[CV_BA_NAME_EMP_EMAIL]);
			}
		}
	}

	/*else
	{
		return $this->first_approver_arr;
	} */
}
//@Piy 13Dec19  //need to check thorughly used in user_model
function HLP_convert_array_to_string_where_clause($condition)
{
 if(is_array($condition))
  {  $cond=[];
  foreach ($condition as $fldname => $fldvalue) {
    $cond[]="`{$fldname}`='{$fldvalue}'";
  }
  $condition_str=implode(" and ",$cond  );
 }
 else
 {
 $condition_str= $condition;
 }
 return $condition_str;
}

//CB::Ravi on 20-05-19, To get Total as Well Used Budget of the given Manager's (With Downline Managers)
function HLP_get_downline_managers_budget($rule_dtls, $manager_email, $managers_arr=[], $current_manager=0)
{
	$CI = & get_instance();
	$CI->load->model('rule_model');
	$rule_id = $rule_dtls["id"];
	$CI->first_approver_arr = array();
	if(!$current_manager)
	{
		$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
	}

	$CI->first_approver_arr[] = strtolower($manager_email);
	HLP_get_downline_managers_recursive($manager_email, $rule_id);
	$first_approver_arr = array_unique($CI->first_approver_arr);
	$manager_total_bdgt = $manager_total_used_bdgt = $manager_direct_emps_used_bdgt = 0;
	
	$m_direct_emps_merit_allocated_budget = $m_direct_emps_market_allocated_budget = $m_direct_emps_merit_used_budget = $m_direct_emps_market_used_budget = $m_direct_emps_promotion_used_budget = $m_direct_emps_current_total_salary = 0;
	$m_all_emps_merit_allocated_budget = $m_all_emps_market_allocated_budget = $m_all_emps_merit_used_budget = $m_all_emps_market_used_budget = $m_all_emps_promotion_used_budget = $m_all_emps_current_total_salary = 0;
	
	$rule_dtls_params_arr = array("id"=>$rule_id, "include_promotion_budget"=>$rule_dtls["include_promotion_budget"], "to_currency_id"=>$rule_dtls["to_currency_id"]);
	foreach($managers_arr as $key => $value)
	{
		$m_used_bdgt = 0;
		if($current_manager)
		{
			if(strtolower($value[0]) == strtolower($manager_email))
			{
				$manager_total_bdgt += $value[1] + (($value[1]*$value[2])/100);
				$m_bdgt_dtls = HLP_get_managers_emps_total_budget($rule_dtls_params_arr, strtolower($value[0]));
				$m_used_bdgt = $m_bdgt_dtls["final_total_used_budget"];
				$manager_total_used_bdgt += $m_used_bdgt;
				$manager_direct_emps_used_bdgt = $m_used_bdgt;
				
				$m_direct_emps_merit_allocated_budget = $m_bdgt_dtls["merit_allocated_budget"];
				$m_direct_emps_market_allocated_budget = $m_bdgt_dtls["market_allocated_budget"];
				$m_direct_emps_merit_used_budget = $m_bdgt_dtls["merit_used_budget"];
				$m_direct_emps_market_used_budget = $m_bdgt_dtls["market_used_budget"];
				$m_direct_emps_promotion_used_budget = $m_bdgt_dtls["promotion_used_budget"];
				$m_direct_emps_current_total_salary = $m_bdgt_dtls["emps_current_total_salary"];
				
				$m_all_emps_merit_allocated_budget += $m_bdgt_dtls["merit_allocated_budget"];
				$m_all_emps_market_allocated_budget += $m_bdgt_dtls["market_allocated_budget"];
				$m_all_emps_merit_used_budget += $m_bdgt_dtls["merit_used_budget"];
				$m_all_emps_market_used_budget += $m_bdgt_dtls["market_used_budget"];
				$m_all_emps_promotion_used_budget += $m_bdgt_dtls["promotion_used_budget"];
				$m_all_emps_current_total_salary += $m_bdgt_dtls["emps_current_total_salary"];
				break;
			}
		}
		else
		{
			if($rule_dtls['budget_accumulation']==1)
			{
				if(in_array(strtolower($value[0]), $first_approver_arr))
				{
					$manager_total_bdgt += $value[1] + (($value[1]*$value[2])/100);
					$m_bdgt_dtls=HLP_get_managers_emps_total_budget($rule_dtls_params_arr, strtolower($value[0]));
					$m_used_bdgt = $m_bdgt_dtls["final_total_used_budget"];
					$manager_total_used_bdgt += $m_used_bdgt;
					
					$m_all_emps_merit_allocated_budget += $m_bdgt_dtls["merit_allocated_budget"];
					$m_all_emps_market_allocated_budget += $m_bdgt_dtls["market_allocated_budget"];
					$m_all_emps_merit_used_budget += $m_bdgt_dtls["merit_used_budget"];
					$m_all_emps_market_used_budget += $m_bdgt_dtls["market_used_budget"];
					$m_all_emps_promotion_used_budget += $m_bdgt_dtls["promotion_used_budget"];
					$m_all_emps_current_total_salary += $m_bdgt_dtls["emps_current_total_salary"];
				}
				if(strtolower($value[0]) == strtolower($manager_email))
				{
					$manager_direct_emps_used_bdgt = $m_used_bdgt;
					
					$m_direct_emps_merit_allocated_budget = $m_bdgt_dtls["merit_allocated_budget"];
					$m_direct_emps_market_allocated_budget = $m_bdgt_dtls["market_allocated_budget"];
					$m_direct_emps_merit_used_budget = $m_bdgt_dtls["merit_used_budget"];
					$m_direct_emps_market_used_budget = $m_bdgt_dtls["market_used_budget"];
					$m_direct_emps_promotion_used_budget = $m_bdgt_dtls["promotion_used_budget"];
					$m_direct_emps_current_total_salary = $m_bdgt_dtls["emps_current_total_salary"];
				}
			}
			else
			{
				if(strtolower($value[0]) == strtolower($manager_email))
				{
					$manager_total_bdgt += $value[1] + (($value[1]*$value[2])/100);
					$m_bdgt_dtls=HLP_get_managers_emps_total_budget($rule_dtls_params_arr, strtolower($value[0]));
					$m_used_bdgt = $m_bdgt_dtls["final_total_used_budget"];
					$manager_total_used_bdgt += $m_used_bdgt;
					$manager_direct_emps_used_bdgt = $m_used_bdgt;
					
					$m_direct_emps_merit_allocated_budget = $m_bdgt_dtls["merit_allocated_budget"];
					$m_direct_emps_market_allocated_budget = $m_bdgt_dtls["market_allocated_budget"];
					$m_direct_emps_merit_used_budget = $m_bdgt_dtls["merit_used_budget"];
					$m_direct_emps_market_used_budget = $m_bdgt_dtls["market_used_budget"];
					$m_direct_emps_promotion_used_budget = $m_bdgt_dtls["promotion_used_budget"];
					$m_direct_emps_current_total_salary = $m_bdgt_dtls["emps_current_total_salary"];
					
					$m_all_emps_merit_allocated_budget += $m_bdgt_dtls["merit_allocated_budget"];
					$m_all_emps_market_allocated_budget += $m_bdgt_dtls["market_allocated_budget"];
					$m_all_emps_merit_used_budget += $m_bdgt_dtls["merit_used_budget"];
					$m_all_emps_market_used_budget += $m_bdgt_dtls["market_used_budget"];
					$m_all_emps_promotion_used_budget += $m_bdgt_dtls["promotion_used_budget"];
					$m_all_emps_current_total_salary += $m_bdgt_dtls["emps_current_total_salary"];
					break;
				}
			}
		}
	}

	$managers_downline_arr = array();
	foreach($first_approver_arr as $approver_email)
	{
		$approver_dtls = $CI->rule_model->get_table_row("login_user", CV_BA_NAME_EMP_FULL_NAME.", (SELECT manage_function.name FROM manage_function WHERE manage_function.id = login_user.".CV_BA_NAME_FUNCTION.") AS m_function_name", array(CV_BA_NAME_EMP_EMAIL=>$approver_email));
		$managers_downline_arr[] = array("m_name"=>$approver_dtls[CV_BA_NAME_EMP_FULL_NAME], "m_email"=>strtolower($approver_email), "m_function_name"=>$approver_dtls["m_function_name"]);
	}
	return array("manager_total_bdgt" => $manager_total_bdgt, "manager_total_used_bdgt" => $manager_total_used_bdgt, "manager_direct_emps_used_bdgt"=>$manager_direct_emps_used_bdgt,
		"m_direct_emps_merit_allocated_budget"=>$m_direct_emps_merit_allocated_budget,
		"m_direct_emps_market_allocated_budget"=>$m_direct_emps_market_allocated_budget,
		"m_direct_emps_promotion_allocated_budget"=>0,		
		"m_direct_emps_merit_available_budget"=>$m_direct_emps_merit_allocated_budget -$m_direct_emps_merit_used_budget,
		"m_direct_emps_market_available_budget"=>$m_direct_emps_market_allocated_budget - $m_direct_emps_market_used_budget,
		"m_direct_emps_promotion_available_budget"=>0-$m_direct_emps_promotion_used_budget,
		
		"m_all_emps_merit_allocated_budget"=>$m_all_emps_merit_allocated_budget,
		"m_all_emps_market_allocated_budget"=>$m_all_emps_market_allocated_budget,
		"m_all_emps_promotion_allocated_budget"=>0,		
		"m_all_emps_merit_available_budget"=>$m_all_emps_merit_allocated_budget -$m_all_emps_merit_used_budget,
		"m_all_emps_market_available_budget"=>$m_all_emps_market_allocated_budget - $m_all_emps_market_used_budget,
		"m_all_emps_promotion_available_budget"=>0-$m_all_emps_promotion_used_budget,
			
		"m_direct_emps_merit_allocated_budget_per"=>($m_direct_emps_merit_allocated_budget/$m_direct_emps_current_total_salary)*100,
		"m_direct_emps_market_allocated_budget_per"=>($m_direct_emps_market_allocated_budget/$m_direct_emps_current_total_salary)*100,
		"m_direct_emps_promotion_allocated_budget_per"=>0,		
		"m_direct_emps_merit_available_budget_per"=>(($m_direct_emps_merit_allocated_budget -$m_direct_emps_merit_used_budget)/$m_direct_emps_current_total_salary)*100,
		"m_direct_emps_market_available_budget_per"=>(($m_direct_emps_market_allocated_budget - $m_direct_emps_market_used_budget)/$m_direct_emps_current_total_salary)*100,
		"m_direct_emps_promotion_available_budget_per"=>((0-$m_direct_emps_promotion_used_budget)/$m_direct_emps_current_total_salary)*100,
		
		"m_all_emps_merit_allocated_budget_per"=>($m_all_emps_merit_allocated_budget/$m_direct_emps_current_total_salary)*100,
		"m_all_emps_market_allocated_budget_per"=>($m_all_emps_market_allocated_budget/$m_direct_emps_current_total_salary)*100,
		"m_all_emps_promotion_allocated_budget_per"=>0,		
		"m_all_emps_merit_available_budget_per"=>(($m_all_emps_merit_allocated_budget -$m_all_emps_merit_used_budget)/$m_direct_emps_current_total_salary)*100,
		"m_all_emps_market_available_budget_per"=>(($m_all_emps_market_allocated_budget - $m_all_emps_market_used_budget)/$m_direct_emps_current_total_salary)*100,
		"m_all_emps_promotion_available_budget_per"=>((0-$m_all_emps_promotion_used_budget)/$m_direct_emps_current_total_salary)*100,		
		"managers_downline_arr"=>$managers_downline_arr, 'key'=>$key);
}


//CB::Ravi on 20-05-19, To update user's all the required Data as Per New given Performance Rating
function HLP_update_users_performance_rating_for_salary_rule($rule_dtls, $emp_current_sal_dtls, $new_rating_dtls, $salary_elem_ba_list, $req_by = 1)
{
	//Note :: $req_by (1=Called this function By Manager, 2=Called this function By HR)
	$CI = & get_instance();
	$CI->load->model('rule_model');

	$rule_id = $rule_dtls["id"];
	$user_id = $emp_current_sal_dtls["user_id"];

	$can_edit_data = 0;//No
	if(!empty($emp_current_sal_dtls) and $CI->session->userdata('role_ses') < 10 and ($rule_dtls["status"] == 6 or $rule_dtls["status"] == 7))
	{
		$can_edit_data = 1;//Yes
	}
	elseif(!empty($emp_current_sal_dtls) and $CI->session->userdata('role_ses') == 10 and $rule_dtls["status"] == 6 and $emp_current_sal_dtls["status"] < 5)
	{
		$can_edit_data = 1;//Yes
	}

	//if($rule_dtls["status"] == 6 and ($emp_current_sal_dtls) and ($new_rating_dtls))
	if($can_edit_data == 1 and ($new_rating_dtls))
	{
		$modules_select_arr = array();
		foreach($salary_elem_ba_list as $ba_row)
		{
			$modules_select_arr[] = $ba_row['ba_name'];
		}
		$modules_select_str = implode(",", $modules_select_arr);

		//$user_id_based_condition = "login_user.id IN (SELECT user_id FROM salary_rule_users_dtls WHERE rule_id = ".$rule_id." AND user_id = ".$user_id.")";
		//$select_str = "login_user.id, login_user.".CV_BA_NAME_APPROVER_1.", login_user." . CV_BA_NAME_CURRENCY . ", login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS performance_rating_name";
		$user_id_based_condition = "login_user.id = ".$user_id;
		$select_str = "login_user.id, login_user.".CV_BA_NAME_COUNTRY.", login_user.".CV_BA_NAME_GRADE.", login_user.".CV_BA_NAME_LEVEL.", login_user.".CV_BA_NAME_APPROVER_1.", login_user." . CV_BA_NAME_CURRENCY . ", login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ", (SELECT name FROM manage_rating_for_current_year mr WHERE mr.id = login_user." . CV_BA_NAME_RATING_FOR_CURRENT_YEAR . ") AS performance_rating_name, (SELECT rate FROM currency_rates cr WHERE cr.status=1 AND cr.from_currency = login_user.".CV_BA_NAME_CURRENCY." AND cr.to_currency = ".$rule_dtls['to_currency_id']." limit 1) AS currency_conversion_rate";
		$select_str .= "," . $modules_select_str;
		//$staff_list = $CI->rule_model->get_users_list_for_salary_rule($select_str, $user_id_based_condition);
		$users_dtls = $CI->rule_model->get_table_row("login_user", $select_str, $user_id_based_condition);
		if($rule_dtls["hike_multiplier_basis_on"])
		{
			$hike_multiplier_basis_on = CV_BA_NAME_COUNTRY;
			if($rule_dtls["hike_multiplier_basis_on"]=="2")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_GRADE;
			}
			elseif($rule_dtls["hike_multiplier_basis_on"]=="3")
			{
				$hike_multiplier_basis_on = CV_BA_NAME_LEVEL;
			}
			//$hike_multiplier_arr = json_decode($rule_dtls["hike_multiplier_dtls"], true);
			$multiplier_wise_per_dtls = json_decode($rule_dtls["multiplier_wise_per_dtls"], true);
		}
		
		//if($staff_list)
		if($users_dtls)
		{
			//$users_dtls = $staff_list[0];
			$users_dtls["performance_rating_name"] = $new_rating_dtls["name"];
			$users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR] = $new_rating_dtls["id"];
			$increment_applied_on_amt = $emp_current_sal_dtls["increment_applied_on_salary"];
			$total_per_to_increase_salary=0;
			$performnace_based_increment_percet=0;
			$performance_rating_name = $users_dtls["performance_rating_name"];
			$performance_rating_id = $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR];
			
			//$hike_multiplier_val = 1;//0;
			/*if(isset($hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]))
			{
				$hike_multiplier_val = $hike_multiplier_arr[$users_dtls[$hike_multiplier_basis_on]]/100;
			}*/

			$currency_conv_rate = 0;
			//$currency_rate_dtls = $CI->rule_model->get_table_row("currency_rates", "rate", "status=1 AND from_currency = ".$users_dtls[CV_BA_NAME_CURRENCY]." AND to_currency = ".$rule_dtls['to_currency_id'], "id ASC");
			//if($currency_rate_dtls)
			if($users_dtls["currency_conversion_rate"])
			{
				//$currency_conv_rate = $currency_rate_dtls["rate"];
				$currency_conv_rate = $users_dtls["currency_conversion_rate"];
			}

			//*************** Note :: Proreta Calculation Start ***************/
			$proreta_multiplier = $emp_current_sal_dtls["proreta_multiplier"];
			//$total_per_to_increase_salary = $total_per_to_increase_salary*$proreta_multiplier;
			//*************** Note :: Proreta Calculation End ***************/

			/*$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
			$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
			$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
			$max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"], true);
			$recently_promoted_max_hike_arr = json_decode($rule_dtls["if_recently_promoted"], true);*/			
			if($rule_dtls["hike_multiplier_basis_on"])
			{
				$rating_dtls = $multiplier_wise_per_dtls["rating"][$users_dtls[$hike_multiplier_basis_on]];
				$comparative_ratio_dtls=$multiplier_wise_per_dtls["mkt_elem"][$users_dtls[$hike_multiplier_basis_on]];
				$crr_tbl_arr_temp = $multiplier_wise_per_dtls["crr"][$users_dtls[$hike_multiplier_basis_on]];
				$max_hike_arr = $multiplier_wise_per_dtls["max_per"][$users_dtls[$hike_multiplier_basis_on]];
				$recently_promoted_max_hike_arr = $multiplier_wise_per_dtls["recently_max_per"][$users_dtls[$hike_multiplier_basis_on]];
			}
			else
			{
				$rating_dtls = json_decode($rule_dtls["performnace_based_hike_ratings"],true);
				$comparative_ratio_dtls = json_decode($rule_dtls["comparative_ratio_calculations"],true);
				$crr_tbl_arr_temp = json_decode($rule_dtls["crr_percent_values"], true);
				$max_hike_arr = json_decode($rule_dtls["Overall_maximum_age_increase"], true);
				$recently_promoted_max_hike_arr = json_decode($rule_dtls["if_recently_promoted"], true);
			}

			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($rating_dtls as $key => $value)
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$performnace_based_increment_percet = $value;
						break;
					}
				}
			}
			else
			{
				$performnace_based_increment_percet = $rating_dtls["all"];
			}

			$performnace_based_increment_percet = HLP_get_formated_percentage_common($performnace_based_increment_percet*$proreta_multiplier);
			$performnace_based_salary = $increment_applied_on_amt + (($increment_applied_on_amt*$performnace_based_increment_percet)/100);

			$emp_market_salary = 0;
			$market_salary_column = "";
			$crr_per = 0;

			if($rule_dtls['salary_position_based_on'] != "2")//Salary Positioning Not Based On Quartile
			{
				if($rule_dtls["performnace_based_hike"] == "yes")
				{
					foreach($comparative_ratio_dtls as $key => $value)
					{
						$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
						if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
						{
							$val_arr =  explode(CV_CONCATENATE_SYNTAX, $value);
							$emp_market_salary = $users_dtls[$val_arr[1]];
							$market_salary_column = $val_arr[1];
							break;
						}
					}
				}
				else
				{
					$val_arr =  explode(CV_CONCATENATE_SYNTAX, $comparative_ratio_dtls["all"]);
					$emp_market_salary = $users_dtls[$val_arr[1]];
					$market_salary_column = $val_arr[1];
				}

				if($emp_market_salary > 0)
				{
					$crr_per = ($increment_applied_on_amt/$emp_market_salary)*100;
					if($rule_dtls["comparative_ratio"] == "yes")
					{
						$crr_per = ($performnace_based_salary/$emp_market_salary)*100;
					}
				}
				else
				{
					$emp_market_salary = 0;
				}
			}

			$i=0;
			$min_mkt_salary = $min_mkt_salary_to_bring_emp_to_min_salary = 0;
			$pre_quartile_range_name = "";
			$increment_applied_on_amt_for_quartile = $increment_applied_on_amt;
			if($rule_dtls["comparative_ratio"] == "yes")
			{
				$increment_applied_on_amt_for_quartile = $performnace_based_salary;
			}
			$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
			foreach($crr_arr as $key => $row1)
			{
				if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
				{
					$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $key);
					if($i==0)
					{
						if($increment_applied_on_amt_for_quartile < $users_dtls[$quartile_range_arr[1]])
						{
							$min_mkt_salary_to_bring_emp_to_min_salary = $users_dtls[$quartile_range_arr[1]];
							$pre_quartile_range_name = " < ".$row1["max"];
							break;
						}
					}
					else
					{
						if($min_mkt_salary <= $increment_applied_on_amt_for_quartile and $increment_applied_on_amt_for_quartile < $users_dtls[$quartile_range_arr[1]])
						{
							$pre_quartile_range_name = $row1["min"]." To ".$row1["max"];
							break;
						}
					}

					if(($i+1)==count($crr_arr))
					{
						if($increment_applied_on_amt_for_quartile >= $users_dtls[$quartile_range_arr[1]])
						{
							$i++;
							$pre_quartile_range_name = " > ".$row1["max"];
							break;
						}
					}
					$min_mkt_salary = $users_dtls[$quartile_range_arr[1]];
				}
				else
				{
					if($i==0)
					{
						if($crr_per < $row1["max"])
						{
							$pre_quartile_range_name = " < ".$row1["max"];
							break;
						}
					}
					else
					{
						if($row1["min"] <= $crr_per and $crr_per < $row1["max"])
						{
							$pre_quartile_range_name = $row1["min"]." To ".$row1["max"];
							break;
						}
					}

					if(($i+1)==count($crr_arr))
					{
						if($crr_per >= $row1["max"])
						{
							$i++;
							$pre_quartile_range_name = " > ".$row1["max"];
							break;
						}
					}
				}
				$i++;
			}

			$max_hike = 0;
			$recently_promoted_max_hike = 0;
			
			$crr_tbl_arr = $crr_tbl_arr_temp[$i];
			$rang_index = $i;
			$crr_based_increment_percet = 0;
			$j=0;

			if($rule_dtls["performnace_based_hike"] == "yes")
			{
				foreach ($comparative_ratio_dtls as $key => $value)
				{
					$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
					if(($users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR]) and $key_arr[0] == $users_dtls[CV_BA_NAME_RATING_FOR_CURRENT_YEAR])
					{
						$crr_based_increment_percet =  $crr_tbl_arr[$j];
						$max_hike = $max_hike_arr[$j];
						$recently_promoted_max_hike = $recently_promoted_max_hike_arr[$j];
						break;
					}
					$j++;
				}
			}
			else
			{
				$crr_based_increment_percet =  $crr_tbl_arr[$j];
				$max_hike = $max_hike_arr[$j];
				$recently_promoted_max_hike = $recently_promoted_max_hike_arr[$j];
			}

			if($rule_dtls['bring_emp_to_min_sal'] == 1 and $rule_dtls['salary_position_based_on'] == "2" and $i == 0 and $min_mkt_salary_to_bring_emp_to_min_salary > 0)//Salary Positioning Based On Quartile Case
			{
				$crr_based_increment_percet = HLP_get_mkt_hike_to_bring_emp_to_min_salary($increment_applied_on_amt, $min_mkt_salary_to_bring_emp_to_min_salary, $performnace_based_increment_percet, $crr_based_increment_percet);
			}
			else
			{
				$crr_based_increment_percet = HLP_get_formated_percentage_common($crr_based_increment_percet*$proreta_multiplier);
			}
			$total_per_to_increase_salary = $performnace_based_increment_percet + $crr_based_increment_percet;

			$current_emp_final_salary = $increment_applied_on_amt + ($increment_applied_on_amt*$total_per_to_increase_salary)/100;

			$emp_final_bdgt = $increment_applied_on_amt*$total_per_to_increase_salary/100;
			if($rule_dtls["overall_budget"] == "No limit")
			{
				//$emp_final_bdgt = 0;// No limit set for budget//Commented this line because we need this bdgt
			}
			elseif($rule_dtls["overall_budget"] == "Automated but x% can exceed")
			{
				$bdgt_x_per_exceed_val = 0;
				$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
				foreach($managers_arr as $key => $value)
				{
					if(strtoupper($users_dtls[CV_BA_NAME_APPROVER_1]) == strtoupper($value[0]))
					{
						$bdgt_x_per_exceed_val = $value[2];
						break;
					}
				}
				$emp_final_bdgt += ($emp_final_bdgt*$bdgt_x_per_exceed_val)/100;
			}

			if($rule_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $rule_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT or $req_by == 2)
			{
				$rule_dtls["manager_can_exceed_budget"] = CV_MANAGER_CAN_EXCEED_BUDGET;
				$manager_total_bdgt_dtls = array("manager_total_bdgt" => 0, "manager_total_used_bdgt" => 0);
			}
			else
			{
				$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($CI->session->userdata('email_ses')));
			}

			//$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($CI->session->userdata('email_ses')));
			$manager_emps_total_used_budget = $manager_total_bdgt_dtls["manager_total_used_bdgt"];
			$manager_emps_total_used_budget = $manager_emps_total_used_budget - ($emp_current_sal_dtls["final_salary"] - $increment_applied_on_amt)*$currency_conv_rate;

			$total_max_budget = $manager_total_bdgt_dtls["manager_total_bdgt"];
			$increased_salary = $increment_applied_on_amt*$total_per_to_increase_salary/100;
			$promotion_increased_salary = $increment_applied_on_amt*$emp_current_sal_dtls["sp_manager_discretions"]/100;
			$manager_emps_total_used_budget_new = $manager_emps_total_used_budget + ($increased_salary*$currency_conv_rate);
			if($rule_dtls["include_promotion_budget"] == 1)
			{
				$manager_emps_total_used_budget_new += $promotion_increased_salary*$currency_conv_rate;
			}

			if($total_max_budget >= $manager_emps_total_used_budget_new or $rule_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET or $rule_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_GO_IN_NEGATIVE_BUDGET or $rule_dtls["manager_can_exceed_budget"] == CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT)
			{


				##################   Edited By KingJuliean ##########################

				if($req_by==2)
				{
					        $temp="";
							$promotionComment=[];


							$promotionComment[]=array(
									'email'=>strtolower($CI->session->userdata('email_ses'))
									,"name"=>$CI->session->userdata('username_ses')
									,"increment_per"=>HLP_get_formated_percentage_common($total_per_to_increase_salary)
									,"permotion_per"=>HLP_get_formated_percentage_common($emp_current_sal_dtls["sp_manager_discretions"])
									,"changed_by"=>'HR'
									,"role"=>"HR"
									,"rating"=>$performance_rating_name
									,"final_salary"=>$current_emp_final_salary
									,"final_increment_amount"=>$current_emp_final_salary-$emp_current_sal_dtls["increment_applied_on_salary"]
									,"final_increment_per"=>HLP_get_formated_percentage_common($emp_current_sal_dtls["sp_manager_discretions"]+$total_per_to_increase_salary),
									"createdby_proxy" => $CI->session->userdata('proxy_userid_ses'),
									"createdon" => date("Y-m-d H:i:s")

								);



							if($emp_current_sal_dtls['promotion_comment']!="")
							{
								$temp=json_decode($emp_current_sal_dtls['promotion_comment'],true);
								if(json_last_error()=== JSON_ERROR_NONE)
								{
									for($i=0;$i<count($temp);$i++)
									{
										if($temp[$i]['email']!=strtolower($CI->session->userdata('email_ses')))
										{
											$promotionComment[]=$temp[$i];
										}


									}

								}
							}

							$reportLog=json_encode($promotionComment);
				}
				else
				{
					$reportLog=$emp_current_sal_dtls['promotion_comment'];
				}



			############################################################################

				$db_arr =array(
					/*"performnace_based_increment" => $performnace_based_increment_percet,					
					"performance_rating_id" => $performance_rating_id,
					"budget_to_make_cr1" => $emp_market_salary - $increment_applied_on_amt,
					"crr_val" => $crr_per,
					"crr_based_increment" => $crr_based_increment_percet,
					"pre_quartile_range_name" => $pre_quartile_range_name,
					"market_salary" => $emp_market_salary,					
					"market_salary_column" => $market_salary_column,					
					"mkt_salary_after_promotion" => $emp_market_salary,
					"crr_after_promotion" => $crr_per,
					"quartile_range_name_after_promotion" => $pre_quartile_range_name,
					"emp_final_bdgt" => $emp_final_bdgt,
					"actual_salary" => $current_emp_final_salary,
					"max_hike" => $max_hike,
					"recently_promoted_max_hike" => $recently_promoted_max_hike,
					"sp_manager_discretions"=>0,
					"sp_increased_salary"=>0,
					"emp_new_designation"=>"",
					"emp_new_grade"=>"",
					"emp_new_grade"=>"",
					*/
					"performance_rating" => $performance_rating_name,
					"post_quartile_range_name" => HLP_get_quartile_position_range_name($users_dtls, $current_emp_final_salary, $crr_arr),					
					"final_merit_hike" => $performnace_based_increment_percet,
					"final_market_hike" => $crr_based_increment_percet,
					"final_salary" => $current_emp_final_salary,					
					"manager_discretions"=>$total_per_to_increase_salary,					
					"promotion_comment"=>$reportLog,
					"updatedby" =>$CI->session->userdata('userid_ses'),
					"updatedon" =>date("Y-m-d H:i:s"),
					"updatedby_proxy"=>$CI->session->userdata("proxy_userid_ses"));
					//echo "<pre>";print_r($db_arr);die;
				$CI->manager_model->update_tbl_data("employee_salary_details", $db_arr, array("id"=>$emp_current_sal_dtls["id"]));
				$response =array("status"=>true,"message"=>"Data updated successfully.", "updated_data"=>$db_arr);
			}
			else
			{
				$response =array("status"=>false,"message"=>"You can not change the performance rating of the employee, because your budget has been exceeded.");
			}
		}
		else
		{
			$response =array("status"=>false,"message"=>"Invalid employee.");
		}
	}
	else
	{
		$response =array("status"=>false,"message"=>"Invalid request.");
	}
	return	$response;
}

//CB::Ravi on 27-04-19, To check current Manager can Modify Salary Hikes or Not of the User
function HLP_is_manager_can_edit_salary_hikes($salary_n_rule_dtls, $current_manager_email)
{
	$flag = 0;//1=Yes(Can Modiffy the Hikes), 0=No(Can Not Modiffy the Hikes)
	$approver_level_of_manager = 0;//Current Manager is Which type of approver level
	$current_manager_email = strtoupper($current_manager_email);

	if(($salary_n_rule_dtls["rule_status"] == 6 or $salary_n_rule_dtls["rule_status"] == 7) and $salary_n_rule_dtls["salary_hike_approval_status"] <5)
	{
		if($salary_n_rule_dtls['budget_accumulation'] == 1)
		{
			if($current_manager_email == strtoupper($salary_n_rule_dtls["manager_emailid"]))
			{
				$flag = 1;
			}
		}
		elseif($salary_n_rule_dtls['budget_accumulation'] == 2 and $salary_n_rule_dtls["salary_hike_approval_status"] == 1 and $current_manager_email == strtoupper($salary_n_rule_dtls["approver_1"]))
		{
			$flag = 1;
		}
	}

	if($current_manager_email == strtoupper($salary_n_rule_dtls["approver_1"]))
	{
		$approver_level_of_manager = 1;
	}
	elseif($current_manager_email == strtoupper($salary_n_rule_dtls["approver_2"]))
	{
		$approver_level_of_manager = 2;
	}
	elseif($current_manager_email == strtoupper($salary_n_rule_dtls["approver_3"]))
	{
		$approver_level_of_manager = 3;
	}
	elseif($current_manager_email == strtoupper($salary_n_rule_dtls["approver_4"]))
	{
		$approver_level_of_manager = 4;
	}
	return array("is_access_to_edit"=>$flag, "approver_level_of_manager"=>$approver_level_of_manager);
}

function HLP_get_managers_emps_total_budget_bonus($rule_id, $manager_email)
{
	$CI = & get_instance();
	$CI->db->select("SUM(final_bonus) AS used_budget");
	$CI->db->from("employee_bonus_details");
	$CI->db->where("employee_bonus_details.rule_id = ".$rule_id." AND employee_bonus_details.user_id IN (SELECT id FROM login_user WHERE ".CV_BA_NAME_APPROVER_1." = '".$manager_email."' AND id IN (SELECT user_id FROM bonus_rule_users_dtls WHERE rule_id = ".$rule_id."))");
	$data = $CI->db->get()->row_array();
	return $data["used_budget"];
}

function HLP_get_managers_emps_total_budget_lti($rule_id, $manager_email)
{
	$CI = & get_instance();
	$CI->db->select("SUM(final_incentive) AS used_budget");
	$CI->db->from("employee_lti_details");
	$CI->db->where("employee_lti_details.rule_id = ".$rule_id." AND employee_lti_details.user_id IN (SELECT id FROM login_user WHERE ".CV_BA_NAME_APPROVER_1." = '".$manager_email."' AND id IN (SELECT user_id FROM lti_rule_users_dtls WHERE rule_id = ".$rule_id."))");
	$data = $CI->db->get()->row_array();
	return $data["used_budget"];
}

function HLP_get_adhoc_salary_review_for_val()
{
	$CI = & get_instance();
	$CI->db->select("adhoc_salary_review_for, preserved_days");
	$CI->db->from("manage_company");
	$CI->db->where(array("id"=>$CI->session->userdata('companyid_ses')));
	return $CI->db->get()->row_array();
}

//Note :: Below function is used for getting salary table for letters
function get_with_without_salary_tbl($defult_salary_elem_list, $salary, $with_current_salary=0)
{
	$str = '<div class="table-responsive">
				<table id="example" class="table border table-responsive" style="width: 100%; cellspacing: 0;">
					<thead>
						<tr>
							<th>Element Name</th>';
							if($with_current_salary)
							{
								$str .= '<th>Current</th>';
							}
							$str .= '<th>Revised</th>
						</tr>
					</thead>
					<tbody id="tbl_body">';
					$sal_elem_arr =  explode(",", $salary[0]['salary_applied_on_elements']);

					$current_sal_total = $revised_sal_total = 0;
					foreach($defult_salary_elem_list as $row)
					{
						$elem_val = $salary[0][str_replace(' ','_',strtolower($row['ba_name']))];
						if($elem_val)
						{
							$str .= "<tr>";
							$str .= "<td>".$row["display_name"]."</td>";

							if($with_current_salary)
							{
								$str .= "<td class='txtalignright'>".HLP_get_formated_amount_common($elem_val)."</td>";
								$current_sal_total += $elem_val;
							}

							$elem_revised_val = $elem_val;
							if(in_array($row["id"], $sal_elem_arr))
							{
								$elem_revised_val = $elem_val + ($elem_val*$salary[0]['manager_discretions'])/100;
							}
							$str .= "<td class='txtalignright'>".HLP_get_formated_amount_common($elem_revised_val)."</td>";
							$revised_sal_total += $elem_revised_val;
							$str .= "</tr>";
						}
					}

					$str .= '<tr><td style="text-align: right;">Total </td>';
					if($with_current_salary)
					{
						$str .= '<td class="txtalignright"><b>'.HLP_get_formated_amount_common($current_sal_total).'</b></td>';
					}
					$str .= '<td class="txtalignright"><b>'.HLP_get_formated_amount_common($revised_sal_total).'</b></td></tr>';
					$str .= '</tbody>
				</table>
			</div>';
	return $str;
}

/*--- Function USed for CURL Methods in Xoxoday ---*/
function xoxoday_CURL($url, $method, $paramArray = array())
{
	$data = array();
	if( $url !='' && $method !='' ) {

		$curl = curl_init();
		$param = array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		  )
		);
		if( isset($paramArray) && !empty($paramArray) ){
			if (is_array($paramArray)){
				foreach ($paramArray as $key => $value) {
					$str .= "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"".$key."\"\r\n\r\n".$value."\r\n";
				}
				$str .= "------WebKitFormBoundary7MA4YWxkTrZu0gW--";
				$param[CURLOPT_POSTFIELDS] = $str;
			}else{
				$param[CURLOPT_POSTFIELDS] = $paramArray;
			}
		}
		curl_setopt_array($curl, $param);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		  // echo "cURL Error #:" . $err;
		} else {
		  $data = json_decode($response);
        	// echo "<pre>"; print_r($data);die();
		}
	}
	return $data;
}

function HLP_DateConversion($date, $addDays='', $formate = "d-m-Y")
{
	if( strtotime($date) > 0 ){
		return date($formate, strtotime($date.$addDays));
	}
	return "";
}

function HLP_Pagination($url, $total_rows, $cur_page, $per_page, $num_links=3)
{
	// If our item count or per-page total is zero there is no need to continue.
	// Note: DO NOT change the operator to === here!
	if ($total_rows == 0 OR $per_page == 0)
	{
		return '';
	}

	// Calculate the total number of pages
	$num_pages = (int) ceil($total_rows / $per_page);

	// Is there only one page? Hm... nothing more to do here then.
	if ($num_pages === 1)
	{
		return '';
	}
	// Check the user defined number of links.
	$num_links = (int) $num_links;

	// Calculate the start and end numbers. These determine
	// which number to start and end the digit links with.
	$start	= 1;
	$end	= $num_pages;

	// And here we go...
	$output = '<ul class="pagination">';

	if($cur_page != $start){//$cur_page > ($num_links + 1 + ! $num_links)
		$output .= '<li><a href="'.$url.'/1"> First </a></li>';
	}

	if($cur_page >= 2){
		$output .= '<li><a href="'.$url.'/'.($cur_page-1).'"> Prev </a></li>';
	}

	// Write the digit links
	for ($loop = $start; $loop <= $end; $loop++)
	{
		if ($cur_page == $loop)
		{
			// Current page
			$output .= '<li class="active"><a>'.$cur_page.'</a></li>';
		}
		else
		{
			$output .= '<li><a href="'.$url.'/'. $loop.'">'.$loop.'</a></li>';
		}
	}

	if($cur_page < $num_pages){
		$output .= '<li><a href="'.$url.'/'. ($cur_page+1).'"> Next </a></li>';
	}

	if($cur_page != $end){//($cur_page + $num_links + ! $num_links) < $num_pages)
		$output .= '<li><a href="'.$url.'/'. $num_pages.'"> Last </a></li>';
	}
	$output .= '</ul>';

	return $output;
}

function HLP_Check_IMG($path)
{
	 if(!empty($path) && file_exists($path) ){
		return $path;
	 }
     return base_url().'assets/dummy.png';

}

function HLP_unsetEmptyVal($value)
{
	if (is_array($value)){
		foreach ($value as $key => $item) {
			if (is_array($item) ) {
				foreach ($item as $k => $val) {
					if(empty($val)){ unset($value[$key][$k]);}
				}
			}
			if (empty($item)){ unset($value[$key]); }
		}
		return $value;
	}
	return $value;
}

function HLP_getSurveyUserAnswerMulti($questionID, $surveyID, $userId)
{
	//echo $questionID;
	$CI = get_instance();
    //$CI->load->model('Survey_model');

     $CI->db->select('GROUP_CONCAT(usa.surveyAnsID) as ids');
        $CI->db->from('user_survey_response as usr');
        $CI->db->join('user_survey_answer as usa','usa.user_survey_response_id = usr.id');
		$CI->db->where("usr.user_id=".$userId." and usr.survey_id=".$surveyID);
        $result = $CI->db->get()->row();
        return $result;
}

function HLP_getSurveyUserAnswer($questionID, $surveyID, $userId)
{
	$CI = get_instance();
    $CI->load->model('Survey_model');
    return $CI->Survey_model->getuserAnswer(['usr.survey_id'=>$surveyID, "usa.question_id"=>$questionID, "usr.user_id"=>$userId]);
}

//***************** create by rajesh on 05-01-2019
function get_key_cross_cell_per_old_val($grade_id,$function_id,$subfunction_id){
    $CI = get_instance();
    $CI->load->model('Admin_model');
    $perarr =  $CI->Admin_model->get_key_cross_cell_val($grade_id,$function_id,$subfunction_id);
return $perarr['per_val'];
}


//***************** create by rahul on 07-01-2019
function HLP_getExternalamount($function_id, $sub_id, $grade_id, $aop_avg_sal, $view = '') {

	foreach($aop_avg_sal as $avs) {
	    $aop_actuval_salary = $avs['actuval_salary']; // value
	    $aop_project_salary = $avs['project_salary']; // value
		$aop_wage_amount 	= $avs['aop_value']; // value
	    $aop_function_id    = $avs['function_id'];
	    $aop_subfunction_id = $avs['subfunction_id'];
	    $aop_grade_id       = $avs['grade_id'];
	    $aop_grade_percent  = $avs['grade_percent'];  // Value for next grade project salary calculation
		$external_hires_firstmonth  = $avs['external_hires'];

		// Check if $aop_actuval_salary value are same then same grade actual amount other wise next grade actual salary
	    $aop_function_id    = $avs['lowergrade_salary'];  // next grade actucal salary [current_base_salary + allowance_2] total amount

	    //$aop_aop_value = ($avs['aop_value'] / 100) * $aop_actuval_salary;  // percentage value
		$external_amount = 0;
	    if($aop_grade_id == $grade_id && $sub_id == $aop_subfunction_id) {
			$external_amount = floatval($aop_actuval_salary) + floatval($aop_project_salary) + floatval($aop_wage_amount);
	    } else if($aop_grade_id == $grade_id && $function_id == $aop_function_id) {
			$external_amount = floatval($aop_actuval_salary) + floatval($aop_project_salary) + floatval($aop_wage_amount);
		} else if($aop_grade_id == $grade_id) {
			$external_amount = floatval($aop_actuval_salary) + floatval($aop_project_salary) + floatval($aop_wage_amount);
		}
		if($external_amount != 0) {
			$lowgradesalary = $avs['lowergrade_salary'];
			if($lowgradesalary == 0){
				$inc = 0;
			} else {
				$internal_average = intval($avs['internal_average']);
				//$inc = $lowgradesalary * (($internal_average + 100) / 100);
				$inc = $lowgradesalary * (($internal_average) / 100);
			}

			if(!empty($view)) {
				return $aop_actuval_salary.'_'.$avs['lowergrade_salary'];
			} else {
				return $external_amount.'_'.$avs['lowergrade_salary'].'_'.$inc;
			}

		}
	}
}


//***************** create by rajesh on 09-01-2019
function get_target_for_adjustment_val($grade_id){
    $CI = get_instance();
    $CI->load->model('Admin_model');
   return $tararr =  $CI->Admin_model->get_target_adjustment_val($grade_id);

}

function HLP_get_min_pay_capping_master_row($grade_id, $tenure_id, $tier_id) {
    $CI = get_instance();
    $CI->load->model('Admin_model');
    $masterarr = $CI->Admin_model->get_min_pay_capping_master_row($grade_id, $tenure_id);
    return $dtlsarr = $CI->Admin_model->get_min_pay_capping_dtls_row($masterarr['id'], $tier_id);
}

function HLP_get_min_pay_capping_master_capping_row($grade_id, $tenure_id) {
    $CI = get_instance();
    $CI->load->model('Admin_model');
    return $masterarr = $CI->Admin_model->get_min_pay_capping_master_row($grade_id, $tenure_id);
}

function get_user_email($id){
    $CI = get_instance();
    $CI->load->model('Admin_model');
    $data['user_detais'] = $CI->Admin_model->get_table_row("login_user", "*", array("id" => $id));
return $data['user_detais']['email'];
}

function get_emp_val($id){
    $CI = get_instance();
    $CI->load->model('Admin_model');
   return $tararr =  $CI->Admin_model->get_table_row("login_user","id,name,email",array("id"=>$id));

}

function HLP_sort_multidimensional_array($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}

function hex2rgb($colour, $opecity ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        echo  "rgb(".$r.",".$g.",".$b.",".$opecity.")";
}


function getParticipantsCount($surveyId = null){
	//return $surveyId ;
	 $CI = get_instance();
    //$CI->load->model('Admin_model');
	 $result = $CI->db->select('count(survey_id) as count')->where('survey_id',$surveyId)->get("survey_users_id_dtls")->row();
	 //echo $CI->db->last_query();
   return $result->count;
	//return 10;
}

function getQuestionCount($surveyId = null){
	//return $surveyId ;
	 $CI = get_instance();
    //$CI->load->model('Admin_model');
	 $result = $CI->db->select('count(survey_id) as count')->where('survey_id',$surveyId)->get("survey_questions")->row();
	 //echo $CI->db->last_query();
   return $result->count;
	//return 10;
}

function getQuestion(){
	//return $surveyId ;
	 $CI = get_instance();
    //$CI->load->model('Admin_model');
	 $result = $CI->db->select('*')->get("survey_questions")->result();
	 //echo $CI->db->last_query();
   return $result;
	//return 10;
}

function HLP_get_salary_element_based_final_salary_row($allowance_id,$flaxi_plan_id='') {
    $CI = get_instance();
    $CI->load->model('Admin_model');
   return $masterarr = $CI->Admin_model->get_final_salary_sturcture_row($allowance_id,$flaxi_plan_id);

}

function HLP_get_salary_element_based_final_salary_grade_wise_row($allowance_id,$grade_id) {
    $CI = get_instance();
    $CI->load->model('Admin_model');
   return $masterarr = $CI->Admin_model->get_final_salary_sturcture_grade_wise_row($allowance_id,$grade_id);

}


function HLP_get_calculate_final_salary($fixed_amount,$grade_id){

     $CI = get_instance();
    $CI->load->model('common_model');
    $CI->load->model('admin_model');


        $ba_base_salary_arr = $CI->common_model->get_table("business_attribute", "id", "status = 1 and ba_name_cw = 'Base/Basic'");
        $ba_esic_arr = $CI->common_model->get_table("business_attribute", "id", "status = 1 and ba_name_cw = 'ESIC'");

$base_salary_id = $ba_base_salary_arr[0]['id'];
 $esic_id = $ba_esic_arr[0]['id'];

 $final_base_salary_arr = $CI->admin_model->get_final_salary_sturcture_grade_wise_row($base_salary_id,$grade_id);

 $final_esic_arr = $CI->admin_model->get_final_salary_sturcture_grade_wise_row($esic_id,$grade_id);

 $special_allowance_arr = $CI->common_model->get_table("final_salary_structure", "*", "type_of_element=5 and grade_id = ".$grade_id);

 $allowance_arr = $CI->common_model->get_table("business_attribute", "display_name,ba_name", "status = 1 and id = ".$special_allowance_arr[0]['allowance_id']);


$base_salary = $esic_salary =$grade_val = $esic_per = 0;
/* actuall base salary */
 $base_salary = ($fixed_amount * $final_base_salary_arr['amount'])/100;

 /*Esic calculation*/

 if($final_esic_arr['salary_condition']==1){
if($base_salary<=$final_esic_arr['applicability']){
    $esic_per = $final_esic_arr['amount'];
}else{
    $esic_per = 0;
}
 }else if($final_esic_arr['salary_condition']==2){
if($base_salary > $final_esic_arr['applicability']){
    $esic_per = $final_esic_arr['amount'];
}else{
    $esic_per = 0;
}
}else if($final_esic_arr['salary_condition']==3){
if($fixed_amount <= $final_esic_arr['applicability']){
    $esic_per = $final_esic_arr['amount'];
}else{
    $esic_per = 0;
}
}else if($final_esic_arr['salary_condition']==4){
if($fixed_amount > $final_esic_arr['applicability']){
    $esic_per = $final_esic_arr['amount'];
}else{
    $esic_per = 0;
}
}else{
    $esic_per = 0;
}
 $esic_salary = ($base_salary * $esic_per)/100;


 $base_salary = $base_salary - $esic_salary;

$final_salary_grade_wise_arr = $CI->admin_model->get_final_salary_structure_grade_wise($grade_id);


 $final_salary_arr = array();

foreach ($final_salary_grade_wise_arr as $salary_value) {

  if($salary_value['allowance_id'] == $base_salary_id){

$final_salary_arr[$salary_value['ba_name']]=$base_salary;
}else if($salary_value['allowance_id'] == $esic_id){

$final_salary_arr[$salary_value['ba_name']]=$esic_salary;
}else if($salary_value['type_of_element'] != 5){

if($salary_value['type_of_element']!=4){
    $grade_val = 0;
if($salary_value['salary_condition']==1){

if($base_salary<=$salary_value['applicability']){
    $grade_val = $salary_value['amount'];
}else{
    $grade_val = 0;
}
 }else if($salary_value['salary_condition']==2){
if($base_salary > $salary_value['applicability']){
    $grade_val = $salary_value['amount'];
}else{
    $grade_val = 0;
}
}else if($salary_value['salary_condition']==3){
if($fixed_amount <= $salary_value['applicability']){
    $grade_val = $salary_value['amount'];
}else{
    $grade_val = 0;
}
}else if($salary_value['salary_condition']==4){
if($fixed_amount > $salary_value['applicability']){
    $grade_val = $salary_value['amount'];
}else{
    $grade_val = 0;
}
}else{
    $grade_val =$salary_value['amount'];
}

$salary = 0;
if($salary_value['type_of_element'] == 1){
    $salary = ($fixed_amount*$grade_val)/100;
}else if($salary_value['type_of_element'] == 2){
   $salary = ($base_salary*$grade_val)/100;
}else if($salary_value['type_of_element'] == 3){
 $salary =$grade_val;
}
$final_salary_arr[$salary_value['ba_name']]=$salary;
if($salary_value['fixed_salary_element']==1){
    $total_salary  += $salary ;
}

}else{
   $final_salary_arr[$salary_value['ba_name']]=0;
}



}


}

if($final_base_salary_arr['fixed_salary_element']==1){
    $total_salary = $total_salary+$base_salary;
}
if($final_esic_arr['fixed_salary_element']==1){
$total_salary = $total_salary+$esic_salary;
}
//print_r($special_allowance_arr);
$final_salary_arr[$allowance_arr[0]['ba_name']]=$fixed_amount-$total_salary;

return json_encode($final_salary_arr);




    }

function HLP_get_quartile_position_range_name($users_dtls, $salary_to_be_checked, $ranges_arr)
{
	$i=0;
	$min_mkt_salary = 0;
	$min = $max = $quartile_range_name = "";
	foreach($ranges_arr as $key => $row1)
	{
		$key_arr = explode(CV_CONCATENATE_SYNTAX, $key);
		//echo "<pre>";print_r($row1);die;
		if($i==0)
		{
			if($salary_to_be_checked < $users_dtls[$key_arr[1]])
			{
				$quartile_range_name = " < ".$row1["max"];
				break;
			}
		}
		else
		{
			if($min_mkt_salary <= $salary_to_be_checked and $salary_to_be_checked < $users_dtls[$key_arr[1]])
			{
				$quartile_range_name = $row1["min"]." To ".$row1["max"];
				break;
			}
		}

		if(($i+1)==count($ranges_arr))
		{
			if($salary_to_be_checked >= $users_dtls[$key_arr[1]])
			{
				$i++;
				$quartile_range_name = " > ".$row1["max"];
				break;
			}
		}
		$min_mkt_salary = $users_dtls[$key_arr[1]];
		$i++;
	}
	return $quartile_range_name;



}

############## Created By Kingjuliean ##################


function getSingleTableData($table_name,$conditions,$select){
	//return $surveyId ;
	 $CI = get_instance();

	  return $CI->db->query(" SELECT ".$select." FROM ".$table_name." where ".$conditions." ")->result();


}
##########################################################

function get_approved_right($id){

	$CI =get_instance();
	$app_arr = $CI->common_model->get_table("employee_salary_details", "approver_1,approver_2,approver_3,approver_4", " id = ".$id);
	return $app_arr;
}

function HLP_get_template_rating_data($template_id, $rating_id) {
    $CI = & get_instance();
    $CI->db->select("*");
    $CI->db->from("template_rating_desc");
    $CI->db->where(array("template_id" => $template_id, "raing_id" => $rating_id));
   return $data = $CI->db->get()->row_array();

}

//*Start :: CB::Ravi on 297-05-09 To upload bulk Increments By the HR/Managers *********************
function HLP_get_manager_hr_emps_file_to_upload_increments_NIU($rule_dtls, $staff_list,$manager_emailid,$role='',$fileName="emps-file-for-bulk-increments.csv")
{
	$CI = & get_instance();
	$CI->load->model('common_model');
	$grade_list = $CI->common_model->get_table("manage_grade", "id, name", "", "order_no asc");
	$designation_list = $CI->common_model->get_table("manage_designation", "id, name", "", "order_no asc");
	$level_list = $CI->common_model->get_table("manage_level", "id, name", "", "order_no asc");
	
	$is_open_frm_manager_side = 0;
	$is_open_frm_hr_side = 0;
	if($role=='manager')
	{
		$is_open_frm_manager_side = 1;
	}
	else
	{
		$is_open_frm_hr_side = 1;
	}
	
	$promotion_col_name = CV_BA_NAME_GRADE;
	$other_then_promotion_col_arr = array("designation", "level");
	if($rule_dtls['promotion_basis_on']==1)
	{
		$promotion_col_name = CV_BA_NAME_DESIGNATION;
		$other_then_promotion_col_arr = array("grade", "level");
	}
	elseif($rule_dtls['promotion_basis_on']==3)
	{
		$promotion_col_name = CV_BA_NAME_LEVEL;
		$other_then_promotion_col_arr = array("designation", "grade");
	}
	
	if($is_open_frm_hr_side != 1)
	{
		$other_then_promotion_col_arr = array();
	}

	if($is_open_frm_manager_side == 1)
	{
		/*if($rule_dtls['promotion_can_edit']==2)
		{
			$head_arr = array("Email Id", "Performance Rating", "Salary Increment Percentage",  "Promotion Recommendation(Yes/No)");
		}
		else
		{
			$head_arr = array("Email Id", "Performance Rating", "Salary Increment Percentage", "New Designation", "Promotion Recommendation(Yes/No)");

			if($rule_dtls['promotion_basis_on'] == 2)
			{
				$head_arr[4] = "New Grade";
			}
			elseif($rule_dtls['promotion_basis_on'] == 3)
			{
				$head_arr[4] = "New Level";
			}
		}*/

		if($rule_dtls['esop_right']==1)
		{
			$colName="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==2)
		{
			$colName="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_4";
		}
		if($rule_dtls['pay_per_right']==1)
		{
			$colName2="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==2)
		{
			$colName2="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_4";
		}
		
		if($rule_dtls['retention_bonus_right']==1)
		{
			$colName3="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==2)
		{
			$colName3="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==3)
		{
			$colName3="approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==4)
		{
			$colName3="approver_4";
		}
		$checkApproverEsopRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName);		
		$checkApproverPayPerRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName2);		
		$checkApproverBonusRecommandetionRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName3);
	}
	else
	{
		/*if($rule_dtls['promotion_basis_on']==1 || $rule_dtls['promotion_basis_on']==0 || $rule_dtls['promotion_basis_on']==2)
		{
			$head_arr = array("Email Id", "Performance Rating", "Merit Increase Percentage", "Salary Increase Percentage", "Total Increase Percentage", "New Designation","New Grade","Promotion Recommendation(Yes/No)");
		}
		else if($rule_dtls['promotion_basis_on']==3)
		{
			$head_arr = array("Email Id", "Performance Rating", "Merit Increase Percentage", "Salary Increase Percentage", "Total Increase Percentage", "New Level","Promotion Recommendation(Yes/No)");
		}*/		
		
		$checkApproverEsopRights = 1;
		$checkApproverPayPerRights = 1;      
		$checkApproverBonusRecommandetionRights = 1;
	}
	
	$head_arr = array("Email Id", "Performance Rating", "Merit Increase Percentage", "Salary Increase Percentage", "Total Increase Percentage", "Promotion Recommendation(Yes/No)", "Promotion Percentage");
	
	if($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and $rule_dtls['promotion_can_edit']==1))
	{
		$head_arr[] = ucfirst("New ".$promotion_col_name);
	}
	
	if($other_then_promotion_col_arr)
	{
		$head_arr[] = ucfirst("New ".$other_then_promotion_col_arr[0]);
		$head_arr[] = ucfirst("New ".$other_then_promotion_col_arr[1]);
	}

	if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
	{
		$head_arr[] = $rule_dtls["esop_title"];
	}
	if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
	{
		$head_arr[] = $rule_dtls["pay_per_title"];
	}
	if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
	{
		$head_arr[] = $rule_dtls["retention_bonus_title"];
	}

	$head_arr[] = "Employee Full name";
	$head_arr[] = "Employee Code";
	$head_arr[] = "City";
	$head_arr[] = "Bussiness Unit";
	$head_arr[] = "Super Business Unit";
	$head_arr[] = "Function";
	$head_arr[] = "Department Name";
	$head_arr[] = "Designation/Title";
	$head_arr[] = "Grade";
	$head_arr[] = "Date of Joining";
	$head_arr[] = "Current Salary being reviewed";
	$head_arr[] = "Current variable salary";
	$head_arr[] = "Current Positioning in pay range";
	$head_arr[] = "Salary increase range";
	$head_arr[] = "Final Total Increment Amount";
	$head_arr[] = "Final Total increment %age";
	$head_arr[] = "Final New Salary";
	$head_arr[] = "Revised Variable Salary";
	$head_arr[] = "New Positioning in Pay Range";
	$head_arr[] = "BU Level-3 (Area)";
	$head_arr[] = "Sub Sub Function";
	$head_arr[] = "Education";
	$head_arr[] = "Identified talent";
	$head_arr[] = "Critical Position holder";
	$head_arr[] = "Special Category-1";
	$head_arr[] = "Recently Promoted";
	$head_arr[] = "Currency";
	$head_arr[] = "Manager Name";

	$csv_file = $fileName;
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="'.$csv_file.'"');
	$fp = fopen('php://output', 'wb');
	fputcsv($fp, $head_arr);

	foreach($staff_list as $row)
	{
		$emp_revised_final_roundup_sal = HLP_get_round_off_val($row["final_salary"], $rule_dtls["rounding_final_salary"]);
		/*if($role=="manager")
		{
			if($rule_dtls['promotion_can_edit']==2)
			{
				$promotion_txt="";
				if($row['sp_manager_discretions']>0)
				{
					$promotion_txt="Yes";
				}
				$item_arr = array($row['email_id'], $row['performance_rating'], HLP_get_formated_percentage_common($row['manager_discretions']), $promotion_txt);
			}
			else
			{
				$item_arr = array($row['email_id'], $row['performance_rating'], HLP_get_formated_percentage_common($row['manager_discretions']), $row['emp_new_designation'], HLP_get_formated_percentage_common($row['sp_manager_discretions']));
				if($rule_dtls['promotion_basis_on'] == 2)
				{
					$item_arr[4] = $row['emp_new_grade'];
				}
				elseif($rule_dtls['promotion_basis_on'] == 3)
				{
					$head_arr[4] = $row['emp_new_level'];
				}
			}
		}
		else
		{*/
		
		$denominator = $row["max_salary_for_penetration"] - $row["min_salary_for_penetration"];
		
		$item_arr = array($row['email_id'], $row['performance_rating'], HLP_get_formated_percentage_common($row['final_merit_hike']), HLP_get_formated_percentage_common($row['final_market_hike']), HLP_get_formated_percentage_common($row['manager_discretions']));
		
		$promotion_txt="";
		if($row['emp_new_'.$promotion_col_name]>0)
		{
			$promotion_txt="Yes";
		}
		$item_arr[] = $promotion_txt;
		$item_arr[] = $row['sp_manager_discretions'];
		if($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and $rule_dtls['promotion_can_edit']==1))
		{
			$display_name1 = "";
			foreach (${$promotion_col_name."_list"} as $othr_row)
			{
				if($row['emp_new_'.$promotion_col_name]==$othr_row['id'])
				{
					$display_name1 = $othr_row['name'];
					break;
				}
			}
			$item_arr[] = $display_name1;
		}
		if($other_then_promotion_col_arr)
		{
			$display_name2 = $display_name3 = "";
			foreach (${$other_then_promotion_col_arr[0]."_list"} as $othr_row)
			{
				if($row['emp_new_'.$other_then_promotion_col_arr[0]]==$othr_row['id'])
				{
					$display_name2 = $othr_row['name'];
					break;
				}
			}
			foreach (${$other_then_promotion_col_arr[1]."_list"} as $othr_row)
			{
				if($row['emp_new_'.$other_then_promotion_col_arr[1]]==$othr_row['id'])
				{
					$display_name3 = $othr_row['name'];
					break;
				}
			}			
			$item_arr[] = $display_name2;
			$item_arr[] = $display_name3;
		}			
		//}
		
		$sp_per = $row["sp_manager_discretions"];
		$all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];		
		$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rule_dtls["Manager_discretionary_increase"]/100);
		$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rule_dtls["Manager_discretionary_decrease"]/100);		
				
		/*if($role=='manager')
		{
			if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
			{
				$item_arr[] = $row["esop"];
			}
			if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
			{
				$item_arr[] = $row["pay_per"];
			}
			if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
			{
				$item_arr[] = $row["retention_bonus"];
			}
		}
		else
		{
			if($rule_dtls["esop_title"] != "")
			{
				$item_arr[] = $row["esop"];
			}
			if($rule_dtls["pay_per_title"] != "")
			{
				$item_arr[] = $row["pay_per"];
			}
			if($rule_dtls["retention_bonus_title"] != "")
			{
				$item_arr[] = $row["retention_bonus"];
			}
		}*/
		if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
		{
			$item_arr[] = $row["esop"];
		}
		if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
		{
			$item_arr[] = $row["pay_per"];
		}
		if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
		{
			$item_arr[] = $row["retention_bonus"];
		}

		$item_arr[] = $row["emp_name"];
		$item_arr[] = $row["employee_code"];
		$item_arr[] = $row["city"];
		$item_arr[] = $row["business_level_1"];
		$item_arr[] = $row["business_level_2"];
		$item_arr[] = $row["function"];
		$item_arr[] = $row["sub_function"];
		$item_arr[] = $row["designation"];
		$item_arr[] = $row["grade"];
		$item_arr[] = $row["joining_date_for_increment_purposes"];

		$item_arr[] = round($row["increment_applied_on_salary"]);
		//$item_arr[] = round($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["sp_manager_discretions"] + $row["manager_discretions"])/100));
		$item_arr[] = round($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["manager_discretions"])/100));
		
		if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
		{
		  //$current_position_pay_range = $row["post_quartile_range_name"];
		  $numerator = $row["increment_applied_on_salary"] - $row["min_salary_for_penetration"];
		  $current_position_pay_range = HLP_get_range_penetration_for_salary($numerator, $denominator);
		}
		else
		{
		  //$current_position_pay_range = HLP_get_formated_percentage_common($row["crr_val"]).'%';
		  	if($row["mkt_salary_after_promotion"])
			{
				$current_position_pay_range = HLP_get_formated_percentage_common(($row["increment_applied_on_salary"]/$row["mkt_salary_after_promotion"])*100).'%';
			}
			else
			{
				$current_position_pay_range = '0.00%';
			}
		}
		$item_arr[] = $current_position_pay_range;
		$item_arr[] = HLP_get_formated_percentage_common($manager_max_dec_per)." - ".HLP_get_formated_percentage_common($manager_max_incr_per)."%";
		$item_arr[] = HLP_get_formated_amount_common($emp_revised_final_roundup_sal-$row["increment_applied_on_salary"]);
		//$item_arr[] = HLP_get_formated_percentage_common((float)$sp_per+$row["manager_discretions"])."%";
		$item_arr[] = HLP_get_formated_percentage_common($row["manager_discretions"])."%";
		$item_arr[] = HLP_get_formated_amount_common($emp_revised_final_roundup_sal);
		//$item_arr[] = HLP_get_formated_amount_common($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["sp_manager_discretions"] + $row["manager_discretions"])/100));
		$item_arr[] = HLP_get_formated_amount_common($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["manager_discretions"])/100));

		if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
		{
			//$item_arr[]= $row["post_quartile_range_name"];
			$numerator = $emp_revised_final_roundup_sal - $row["min_salary_for_penetration"];
		  	$item_arr[] = HLP_get_range_penetration_for_salary($numerator, $denominator);
		}
		else
		{
			if($row["mkt_salary_after_promotion"])
			{
				$item_arr[]= HLP_get_formated_percentage_common(($emp_revised_final_roundup_sal/$row["mkt_salary_after_promotion"])*100).'%';
			}
			else
			{
				$item_arr[] = 0;
			}
		}

		$item_arr[] =$row['business_level_3'];
		$item_arr[] =$row['sub_sub_function'];
		$item_arr[] =$row['education'];
		$item_arr[] =$row['critical_talent'];
		$item_arr[] =$row['critical_position'];
		$item_arr[] =$row['special_category'];
		$item_arr[] =$row['recently_promoted'];
		$item_arr[] =$row['currency'];
		$item_arr[] =$row['manager_name'];
		fputcsv($fp, $item_arr);
	}
	fclose($fp);
}

function HLP_bulk_upload_hr_managers_direct_emps_increments_NIU($rule_dtls, $file_path, $manager_emailid, $req_by=1)
{
	//Note :: $req_by (1=Called this function By Manager, 2=Called this function By HR)
	$CI = & get_instance();
	$CI->load->model('rule_model');
	$CI->load->model('manager_model');
	$rule_id = $rule_dtls["id"];
	$type_of_hike_can_edit_arr = explode(",", $rule_dtls["type_of_hike_can_edit"]);
	
	$grade_list = $CI->common_model->get_table("manage_grade", "id, name", "", "order_no asc");
	$designation_list = $CI->common_model->get_table("manage_designation", "id, name", "", "order_no asc");
	$level_list = $CI->common_model->get_table("manage_level", "id, name", "", "order_no asc");
	
	$promotion_col_name = CV_BA_NAME_GRADE;
	$promotion_tbl_name = "manage_grade";
	$other_then_promotion_col_arr = array(CV_BA_NAME_DESIGNATION, CV_BA_NAME_LEVEL);
	if($rule_dtls['promotion_basis_on']==1)
	{
		$promotion_col_name = CV_BA_NAME_DESIGNATION;
		$promotion_tbl_name = "manage_designation";
		$other_then_promotion_col_arr = array(CV_BA_NAME_GRADE, CV_BA_NAME_LEVEL);
	}
	elseif($rule_dtls['promotion_basis_on']==3)
	{
		$promotion_col_name = CV_BA_NAME_LEVEL;
		$promotion_tbl_name = "manage_level";
		$other_then_promotion_col_arr = array(CV_BA_NAME_DESIGNATION, CV_BA_NAME_GRADE);
	}
	
	$promotion_tbl_and_col_dtls = array(
									"promotion_tbl_name"=>$promotion_tbl_name,
									"promotion_col_name"=>$promotion_col_name,
									"other_then_promotion_col_name1"=>$other_then_promotion_col_arr[0],
									"other_then_promotion_col_name2"=>$other_then_promotion_col_arr[1]
									);	
	
	if($req_by == 1)
	{
		$other_then_promotion_col_arr = array();
	}
	
	if($req_by == 1)
	{
		if($rule_dtls['esop_right']==1)
		{
			$colName="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==2)
		{
			$colName="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_4";
		}
		if($rule_dtls['pay_per_right']==1)
		{
			$colName2="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==2)
		{
			$colName2="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_4";
		}
		
		if($rule_dtls['retention_bonus_right']==1)
		{
			$colName3="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==2)
		{
			$colName3="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==3)
		{
			$colName3="approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==4)
		{
			$colName3="approver_4";
		}
		$checkApproverEsopRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName);		
		$checkApproverPayPerRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName2);		
		$checkApproverBonusRecommandetionRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName3);
	}
	else
	{		
		$checkApproverEsopRights = 1;
		$checkApproverPayPerRights = 1;      
		$checkApproverBonusRecommandetionRights = 1;
	}
	
	$ins_columns = "email_id, performance_rating, merit_hike, market_hike, total_hike, promotion_recommendation, promotion_percentage";
	if($req_by == 2 or ($req_by == 1 and $rule_dtls['promotion_can_edit']==1))
	{
		$ins_columns .= ", emp_new_".$promotion_col_name;
	}
	
	if($other_then_promotion_col_arr)
	{
		$ins_columns .= ", emp_new_".$other_then_promotion_col_arr[0];
		$ins_columns .= ", emp_new_".$other_then_promotion_col_arr[1];
	}

	if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
	{
		$ins_columns .= ", esop_val";
	}
	if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
	{
		$ins_columns .= ", pay_per_val";
	}
	if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
	{
		$ins_columns .= ", retention_bonus_val";
	}

	$emps_list = $CI->manager_model->bulk_upload_managers_direct_emps_increments($rule_dtls, $ins_columns, $file_path, $req_by);

	$salary_elem_ba_list = $CI->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");

	$ins_cnt = 0;
	$error_arr = array();
	if($emps_list)
	{
		foreach($emps_list as $row)
		{
			if(($row["new_performance_rating_id"]) and $row["new_performance_rating_id"] != $row["old_performance_rating_id"])
			{				
				$emp_current_sal_dtls = array(
										"id"=>$row["id"], 
										"user_id"=>$row["user_id"],
										"increment_applied_on_salary"=>$row["increment_applied_on_salary"],
										"proreta_multiplier"=>$row["proreta_multiplier"],
										"final_salary"=>$row["final_salary"],
										"sp_manager_discretions"=>$row["sp_manager_discretions"],
										"promotion_comment"=>$row["promotion_comment"],
										"status"=>$row["status"]);
				$new_rating_dtls=array("id"=>$row["new_performance_rating_id"],"name"=>$row["performance_rating"]);

				$rating_upd_dtls = HLP_update_users_performance_rating_for_salary_rule($rule_dtls, $emp_current_sal_dtls, $new_rating_dtls, $salary_elem_ba_list, $req_by);

				if($rating_upd_dtls["status"]==true)
				{
					$row["market_salary"] =  $rating_upd_dtls["updated_data"]["market_salary"];					
					$row["mkt_salary_after_promotion"] =  $rating_upd_dtls["updated_data"]["mkt_salary_after_promotion"];					
					$row["crr_after_promotion"] =  $rating_upd_dtls["updated_data"]["crr_after_promotion"];
					$row["quartile_range_name_after_promotion"] =  $rating_upd_dtls["updated_data"]["quartile_range_name_after_promotion"];					
					$row["final_merit_hike"] =  $rating_upd_dtls["updated_data"]["final_merit_hike"];
					$row["final_market_hike"] =  $rating_upd_dtls["updated_data"]["final_market_hike"];
					$row["manager_discretions"] =  $rating_upd_dtls["updated_data"]["manager_discretions"];
					$row["sp_manager_discretions"] =  $rating_upd_dtls["updated_data"]["sp_manager_discretions"];
					$row["final_salary"] =  $rating_upd_dtls["updated_data"]["final_salary"];
					$row["promotion_comment"] =  $rating_upd_dtls["updated_data"]["promotion_comment"];
				}
				else
				{
					$error_arr[] = array("user_id"=>$row["user_id"], "error_msg"=>$row["message"]);
					$CI->manager_model->update_tbl_data("tbl_temp_bulk_upload_emp_increments", array("is_error"=>1, "error_msg"=>$row["message"]), array("id"=>$row["ttbu_pk_id"]));
					continue;
				}
			}

			$emp_new_suggested_position = $emp_new_position_name = "";
			$emp_new_suggested_promotion_per = 0;
			
			if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr))
			{
				if(strtolower($row["promotion_recommendation"])=='yes')
				{
					//$emp_new_suggested_promotion_per = $row["emp_default_standard_promotion"];
					$emp_new_suggested_promotion_per = $row["promotion_percentage"];
				}
			}
			else
			{
				if(strtolower($row["promotion_recommendation"])=='yes')
				{
					$emp_new_suggested_promotion_per = $row["emp_default_standard_promotion"];
				}
			}
			
			if($req_by==1)
			{	
				if($rule_dtls['promotion_can_edit']==1 and $row["emp_new_".$promotion_col_name] != "")
				{
					$emp_new_position_name = $row["emp_new_".$promotion_col_name];
				}
			}
			else
			{
				if($row["emp_new_".$promotion_col_name] != "")
				{
					$emp_new_position_name = $row["emp_new_".$promotion_col_name];
				}
			}
			
			if($emp_new_position_name != "")
			{
				foreach (${$promotion_col_name."_list"} as $othr_row)
				{
					if(strtolower($row['emp_new_'.$promotion_col_name])==strtolower($othr_row['name']))
					{
						$emp_new_suggested_position = $othr_row['id'];
						break;
					}
				}
			}			
			
			if(strtolower($row["promotion_recommendation"])=='yes')
			{
				$row["performance_rating_id"] = $row['new_performance_rating_id'];
				$row["emp_new_suggested_promotion_per"] = $emp_new_suggested_promotion_per;
				$row["emp_new_suggested_position"] = $emp_new_suggested_position;
				$row["promotion_basis_on"] = $rule_dtls['promotion_basis_on'];
				$row["hike_multiplier_basis_on"] = $rule_dtls['hike_multiplier_basis_on'];
				$row["multiplier_wise_per_dtls"] = $rule_dtls['multiplier_wise_per_dtls'];
				$row["comparative_ratio_calculations"] = $rule_dtls['comparative_ratio_calculations'];
				$row["crr_percent_values"] = $rule_dtls['crr_percent_values'];
				$row["comparative_ratio_range"] = $rule_dtls['comparative_ratio_range'];				
				$row["salary_position_based_on"] = $rule_dtls['salary_position_based_on'];
				$row["bring_emp_to_min_sal"] = $rule_dtls['bring_emp_to_min_sal'];
				$row["performnace_based_hike"] = $rule_dtls['performnace_based_hike'];				
				$row["include_promotion_budget"] = $rule_dtls['include_promotion_budget'];	
				$row["promotion_tbl_and_col_dtls"] = $promotion_tbl_and_col_dtls;			
				$new_dtls_after_promotion = HLP_get_new_mkt_dtls_after_promotion(1, $row);
				
				
				$temp="";
				$promotionComment=[];
				$promotionComment[]=array(
						"email"=>strtolower($CI->session->userdata('email_ses')),
						"name"=>$CI->session->userdata('username_ses'),
						"increment_per"=>HLP_get_formated_percentage_common($new_dtls_after_promotion["n_final_total_hike"]),
						"permotion_per"=>HLP_get_formated_percentage_common($new_dtls_after_promotion["n_promotion_hike"]),
						"changed_by"=>($req_by==1)? "Manager":"HR",
						"role"=>($req_by==1)? "Manager":"HR",
						"rating"=>$row['performance_rating'],
						"final_salary"=>$new_dtls_after_promotion["n_final_salary"],
						"final_increment_amount"=>$new_dtls_after_promotion["n_final_salary"] - $row["increment_applied_on_salary"],
						"final_increment_per"=>HLP_get_formated_percentage_common($row["final_merit_hike"] + $new_dtls_after_promotion["n_promotion_hike"] + $new_dtls_after_promotion["n_market_hike"]),
						"createdby_proxy" => $CI->session->userdata('proxy_userid_ses'),
						"createdon" => date("Y-m-d H:i:s")
					);
	
				if($row['promotion_comment']!="")
				{
					$temp=json_decode($row['promotion_comment'],true);
					if(json_last_error()=== JSON_ERROR_NONE)
					{
						for($i=0; $i<count($temp); $i++)
						{
							if($temp[$i]["email"]!=strtolower($CI->session->userdata('email_ses')))
							{
								$promotionComment[]=$temp[$i];
							}
						}
					}
				}				
				
				$row["manager_discretions"] =  $new_dtls_after_promotion["n_final_total_hike"];
				$row["final_salary"] =  $new_dtls_after_promotion["n_final_salary"];
				$row["final_market_hike"] =  $new_dtls_after_promotion["n_market_hike"];
				$row["mkt_salary_after_promotion"] =  $new_dtls_after_promotion["n_market_salary_for_crr"];
				$row["crr_after_promotion"] =  $new_dtls_after_promotion["n_crr_val"];
				$row["sp_increased_salary"] =  $new_dtls_after_promotion["n_promotion_salary"];
				$row["sp_manager_discretions"] =  $new_dtls_after_promotion["n_promotion_hike"];
				$row['emp_new_'.$promotion_col_name] = $new_dtls_after_promotion["emp_new_post_id"];
				$row["quartile_range_name_after_promotion"] =  $new_dtls_after_promotion["quartile_range_name_after_promotion"];
				$row["post_quartile_range_name"] =  $new_dtls_after_promotion["post_quartile_range_name"];
				$row["promotion_comment"] =  json_encode($promotionComment);				
			}
			
			if(in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr))
			{
				$row["final_merit_hike"] =  $row["merit_hike"];			
			}
			
			if(in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr))
			{
				$row["final_market_hike"] =  $row["market_hike"];			
			}
			
			if(in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr))
			{
				$row["manager_discretions"] =  $row["total_hike"];	
				$row["final_salary"] = $row["increment_applied_on_salary"] + ($row["increment_applied_on_salary"]*$row["manager_discretions"])/100;	
			}
			else
			{
				$new_final_total_hike = $row["final_merit_hike"]+$row["final_market_hike"];
				if($rule_dtls["include_promotion_budget"] == 1)
				{
					$new_final_total_hike += $row["sp_manager_discretions"];
				}
				$total_hike = $row["final_merit_hike"]+$row["final_market_hike"]+$row["sp_manager_discretions"];
				$row["manager_discretions"] =  $new_final_total_hike;
				$row["final_salary"] = $row["increment_applied_on_salary"] + ($row["increment_applied_on_salary"]*$total_hike)/100;
			}
			
			$temp="";
			$salaryComment=[];
			$salaryComment[]=array(
							"email"=>strtolower($CI->session->userdata('email_ses')),
							"name"=>$CI->session->userdata('username_ses'),
							"increment_per"=>HLP_get_formated_percentage_common($row["manager_discretions"]),
							"permotion_per"=>HLP_get_formated_percentage_common($row['sp_manager_discretions']),
							"changed_by"=>($req_by==1)? "Manager":"HR",
							"role"=>($req_by==1)? "Manager":"HR",
							"rating"=>$row['performance_rating'],
							"final_salary"=>$row["final_salary"],
							"final_increment_amount"=>$row["final_salary"]-$row["increment_applied_on_salary"],
							"final_increment_per"=>HLP_get_formated_percentage_common($row["final_merit_hike"]+$row["final_market_hike"]+$row["sp_manager_discretions"]),
							"createdby_proxy" => $CI->session->userdata('proxy_userid_ses'),
							"createdon" => date("Y-m-d H:i:s")
				);

			if($row['promotion_comment']!="")
			{
				$temp=json_decode($row['promotion_comment'],true);
				if(json_last_error()=== JSON_ERROR_NONE)
				{
					for($i=0; $i<count($temp); $i++)
					{
						if($temp[$i]['email'] != strtolower($CI->session->userdata('email_ses')))
						{
							$salaryComment[]=$temp[$i];
						}
					}
				}
			}

			$db_arr = array(
						"final_merit_hike"=>$row["final_merit_hike"],
						"final_market_hike"=>$row["final_market_hike"],
						"manager_discretions"=>$row["manager_discretions"],						
						"final_salary"=>$row["final_salary"],
						"mkt_salary_after_promotion"=>$row["mkt_salary_after_promotion"],
						"crr_after_promotion"=>$row["crr_after_promotion"],						
						"quartile_range_name_after_promotion"=>$row["quartile_range_name_after_promotion"],
						"promotion_comment"=>$row["promotion_comment"],
						"updatedon" =>date("Y-m-d H:i:s"),
						"updatedby" =>$CI->session->userdata('userid_ses'),
						"updatedby_proxy"=>$CI->session->userdata("proxy_userid_ses"));
			
			$post_quartile_range_name = "";
			if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
			{
				$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
				$post_quartile_range_name = HLP_get_quartile_position_range_name($row, $row["final_salary"], $crr_arr);
			}
			$db_arr["post_quartile_range_name"] = $post_quartile_range_name;
			if(strtolower($row["promotion_recommendation"])=='yes')
			{
				$db_arr["sp_increased_salary"] = $row["sp_increased_salary"];				
				$db_arr["sp_manager_discretions"] = $row["sp_manager_discretions"];
				$db_arr["emp_new_".$promotion_col_name] = $row["emp_new_".$promotion_col_name];
			}
			
			if($other_then_promotion_col_arr)
			{
				foreach (${$other_then_promotion_col_arr[0]."_list"} as $othr_row)
				{
					if(strtolower($row['emp_new_'.$other_then_promotion_col_arr[0]])==strtolower($othr_row['name']))
					{
						$db_arr['emp_new_'.$other_then_promotion_col_arr[0]] = $othr_row['id'];
						break;
					}
				}
				foreach (${$other_then_promotion_col_arr[1]."_list"} as $othr_row)
				{
					if(strtolower($row['emp_new_'.$other_then_promotion_col_arr[1]])==strtolower($othr_row['name']))
					{
						$db_arr['emp_new_'.$other_then_promotion_col_arr[1]] = $othr_row['id'];
						break;
					}
				}
			}
			
			
			if(!isset($db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name1"]]))
			{
				$db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name1"]] = $new_dtls_after_promotion["other_then_promotion_col_name1"];
			}
			if(!isset($db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name2"]]))
			{
				$db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name2"]] = $new_dtls_after_promotion["other_then_promotion_col_name2"];
			}
			
			if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
			{
				$db_arr["esop"] = $row["esop_val"];
			}
			if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
			{
				$db_arr["pay_per"] = $row["pay_per_val"];
			}
			if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
			{
				$db_arr["retention_bonus"] = $row["retention_bonus_val"];
			}

			//echo "<pre>";print_r($db_arr);die;
			//$CI->manager_model->update_tbl_data("employee_salary_details", $db_arr, array("rule_id"=>$rule_id, "user_id"=>$row["user_id"]));
			$CI->manager_model->update_tbl_data("employee_salary_details", $db_arr, array("id"=>$row["id"]));
			$ins_cnt++;
		}

	}
	$invalid_data = $CI->rule_model->get_table("tbl_temp_bulk_upload_emp_increments","*", array("is_error"=>1));
	return array("insert_counts"=>$ins_cnt, "invalid_data"=>$invalid_data);
}

function HLP_get_manager_hr_emps_file_to_upload_increments($rule_dtls, $staff_list,$manager_emailid,$role='',$fileName="emps-file-for-bulk-increments.csv")
{
	$CI = & get_instance();
	$CI->load->model('common_model');
	$grade_list = $CI->common_model->get_table("manage_grade", "id, name", "", "order_no asc");
	$designation_list = $CI->common_model->get_table("manage_designation", "id, name", "", "order_no asc");
	$level_list = $CI->common_model->get_table("manage_level", "id, name", "", "order_no asc");
	
	$is_open_frm_manager_side = 0;
	$is_open_frm_hr_side = 0;
	if($role=='manager')
	{
		$is_open_frm_manager_side = 1;
	}
	else
	{
		$is_open_frm_hr_side = 1;
	}
	
	$promotion_col_name = CV_BA_NAME_GRADE;
	$other_then_promotion_col_arr = array("designation", "level");
	if($rule_dtls['promotion_basis_on']==1)
	{
		$promotion_col_name = CV_BA_NAME_DESIGNATION;
		$other_then_promotion_col_arr = array("grade", "level");
	}
	elseif($rule_dtls['promotion_basis_on']==3)
	{
		$promotion_col_name = CV_BA_NAME_LEVEL;
		$other_then_promotion_col_arr = array("designation", "grade");
	}
	
	if($is_open_frm_hr_side != 1)
	{
		$other_then_promotion_col_arr = array();
	}

	if($is_open_frm_manager_side == 1)
	{
		/*if($rule_dtls['promotion_can_edit']==2)
		{
			$head_arr = array("Email Id", "Performance Rating", "Salary Increment Percentage",  "Promotion Recommendation(Yes/No)");
		}
		else
		{
			$head_arr = array("Email Id", "Performance Rating", "Salary Increment Percentage", "New Designation", "Promotion Recommendation(Yes/No)");

			if($rule_dtls['promotion_basis_on'] == 2)
			{
				$head_arr[4] = "New Grade";
			}
			elseif($rule_dtls['promotion_basis_on'] == 3)
			{
				$head_arr[4] = "New Level";
			}
		}*/

		if($rule_dtls['esop_right']==1)
		{
			$colName="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==2)
		{
			$colName="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_4";
		}
		if($rule_dtls['pay_per_right']==1)
		{
			$colName2="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==2)
		{
			$colName2="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_4";
		}
		
		if($rule_dtls['retention_bonus_right']==1)
		{
			$colName3="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==2)
		{
			$colName3="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==3)
		{
			$colName3="approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==4)
		{
			$colName3="approver_4";
		}
		$checkApproverEsopRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName);		
		$checkApproverPayPerRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName2);		
		$checkApproverBonusRecommandetionRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName3);
	}
	else
	{
		/*if($rule_dtls['promotion_basis_on']==1 || $rule_dtls['promotion_basis_on']==0 || $rule_dtls['promotion_basis_on']==2)
		{
			$head_arr = array("Email Id", "Performance Rating", "Merit Increase Percentage", "Salary Increase Percentage", "Total Increase Percentage", "New Designation","New Grade","Promotion Recommendation(Yes/No)");
		}
		else if($rule_dtls['promotion_basis_on']==3)
		{
			$head_arr = array("Email Id", "Performance Rating", "Merit Increase Percentage", "Salary Increase Percentage", "Total Increase Percentage", "New Level","Promotion Recommendation(Yes/No)");
		}*/		
		
		$checkApproverEsopRights = 1;
		$checkApproverPayPerRights = 1;      
		$checkApproverBonusRecommandetionRights = 1;
	}
	
	$head_arr = array("Email Id", "Performance Rating", "Merit Increase Percentage", "Salary Increase Percentage", "Total Increase Percentage");
	
	if($rule_dtls['promotion_basis_on'] > 0)
	{
		$head_arr[] = "Promotion Recommendation(Yes/No)";
		$head_arr[] = "Promotion Percentage";
		if($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and $rule_dtls['promotion_can_edit']==1))
		{
			$head_arr[] = ucfirst("New ".$promotion_col_name);
		}
		
		if($other_then_promotion_col_arr)
		{
			$head_arr[] = ucfirst("New ".$other_then_promotion_col_arr[0]);
			$head_arr[] = ucfirst("New ".$other_then_promotion_col_arr[1]);
		}
	}

	if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
	{
		$head_arr[] = $rule_dtls["esop_title"];
	}
	if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
	{
		$head_arr[] = $rule_dtls["pay_per_title"];
	}
	if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
	{
		$head_arr[] = $rule_dtls["retention_bonus_title"];
	}

	$head_arr[] = "Employee Full name";
	$head_arr[] = "Employee Code";
	$head_arr[] = "City";
	$head_arr[] = "Bussiness Unit";
	$head_arr[] = "Super Business Unit";
	$head_arr[] = "Function";
	$head_arr[] = "Department Name";
	$head_arr[] = "Designation/Title";
	$head_arr[] = "Grade";
	$head_arr[] = "Date of Joining";
	$head_arr[] = "Current Salary being reviewed";
	$head_arr[] = "Current variable salary";
	$head_arr[] = "Current Positioning in pay range";
	$head_arr[] = "Salary increase range";
	$head_arr[] = "Final Total Increment Amount";
	$head_arr[] = "Final Total increment %age";
	$head_arr[] = "Final New Salary";
	$head_arr[] = "Revised Variable Salary";
	$head_arr[] = "New Positioning in Pay Range";
	$head_arr[] = "BU Level-3 (Area)";
	$head_arr[] = "Sub Sub Function";
	$head_arr[] = "Education";
	$head_arr[] = "Identified talent";
	$head_arr[] = "Critical Position holder";
	$head_arr[] = "Special Category-1";
	$head_arr[] = "Recently Promoted";
	$head_arr[] = "Currency";
	$head_arr[] = "Manager Name";

	$csv_file = $fileName;
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="'.$csv_file.'"');
	$fp = fopen('php://output', 'wb');
	fputcsv($fp, $head_arr);

	foreach($staff_list as $row)
	{
		$emp_revised_final_roundup_sal = HLP_get_round_off_val($row["final_salary"], $rule_dtls["rounding_final_salary"]);
		/*if($role=="manager")
		{
			if($rule_dtls['promotion_can_edit']==2)
			{
				$promotion_txt="";
				if($row['sp_manager_discretions']>0)
				{
					$promotion_txt="Yes";
				}
				$item_arr = array($row['email_id'], $row['performance_rating'], HLP_get_formated_percentage_common($row['manager_discretions']), $promotion_txt);
			}
			else
			{
				$item_arr = array($row['email_id'], $row['performance_rating'], HLP_get_formated_percentage_common($row['manager_discretions']), $row['emp_new_designation'], HLP_get_formated_percentage_common($row['sp_manager_discretions']));
				if($rule_dtls['promotion_basis_on'] == 2)
				{
					$item_arr[4] = $row['emp_new_grade'];
				}
				elseif($rule_dtls['promotion_basis_on'] == 3)
				{
					$head_arr[4] = $row['emp_new_level'];
				}
			}
		}
		else
		{*/
		
		$denominator = $row["max_salary_for_penetration"] - $row["min_salary_for_penetration"];
		
		$item_arr = array($row['email_id'], $row['performance_rating'], HLP_get_formated_percentage_common($row['final_merit_hike']), HLP_get_formated_percentage_common($row['final_market_hike']), HLP_get_formated_percentage_common($row['manager_discretions']));
		
		if($rule_dtls['promotion_basis_on'] > 0)
		{
			$promotion_txt="";
			if($row['emp_new_'.$promotion_col_name]>0)
			{
				$promotion_txt="Yes";
			}
			$item_arr[] = $promotion_txt;
			$item_arr[] = $row['sp_manager_discretions'];
			if($is_open_frm_hr_side == 1 or ($is_open_frm_manager_side == 1 and $rule_dtls['promotion_can_edit']==1))
			{
				$display_name1 = "";
				foreach (${$promotion_col_name."_list"} as $othr_row)
				{
					if($row['emp_new_'.$promotion_col_name]==$othr_row['id'])
					{
						$display_name1 = $othr_row['name'];
						break;
					}
				}
				$item_arr[] = $display_name1;
			}
			if($other_then_promotion_col_arr)
			{
				$display_name2 = $display_name3 = "";
				foreach (${$other_then_promotion_col_arr[0]."_list"} as $othr_row)
				{
					if($row['emp_new_'.$other_then_promotion_col_arr[0]]==$othr_row['id'])
					{
						$display_name2 = $othr_row['name'];
						break;
					}
				}
				foreach (${$other_then_promotion_col_arr[1]."_list"} as $othr_row)
				{
					if($row['emp_new_'.$other_then_promotion_col_arr[1]]==$othr_row['id'])
					{
						$display_name3 = $othr_row['name'];
						break;
					}
				}			
				$item_arr[] = $display_name2;
				$item_arr[] = $display_name3;
			}
		}		
		//}
		
		$sp_per = $row["sp_manager_discretions"];
		$all_hikes_total = $row["performnace_based_increment"]+$row["crr_based_increment"];		
		$manager_max_incr_per = $all_hikes_total + ($all_hikes_total*$rule_dtls["Manager_discretionary_increase"]/100);
		$manager_max_dec_per = $all_hikes_total - ($all_hikes_total*$rule_dtls["Manager_discretionary_decrease"]/100);		
				
		/*if($role=='manager')
		{
			if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
			{
				$item_arr[] = $row["esop"];
			}
			if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
			{
				$item_arr[] = $row["pay_per"];
			}
			if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
			{
				$item_arr[] = $row["retention_bonus"];
			}
		}
		else
		{
			if($rule_dtls["esop_title"] != "")
			{
				$item_arr[] = $row["esop"];
			}
			if($rule_dtls["pay_per_title"] != "")
			{
				$item_arr[] = $row["pay_per"];
			}
			if($rule_dtls["retention_bonus_title"] != "")
			{
				$item_arr[] = $row["retention_bonus"];
			}
		}*/
		if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
		{
			$item_arr[] = $row["esop"];
		}
		if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
		{
			$item_arr[] = $row["pay_per"];
		}
		if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
		{
			$item_arr[] = $row["retention_bonus"];
		}

		$item_arr[] = $row["emp_name"];
		$item_arr[] = $row["employee_code"];
		$item_arr[] = $row["city"];
		$item_arr[] = $row["business_level_1"];
		$item_arr[] = $row["business_level_2"];
		$item_arr[] = $row["function"];
		$item_arr[] = $row["sub_function"];
		$item_arr[] = $row["designation"];
		$item_arr[] = $row["grade"];
		$item_arr[] = $row["joining_date_for_increment_purposes"];

		$item_arr[] = round($row["increment_applied_on_salary"]);
		//$item_arr[] = round($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["sp_manager_discretions"] + $row["manager_discretions"])/100));
		$item_arr[] = round($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["manager_discretions"])/100));
		
		if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
		{
		  //$current_position_pay_range = $row["post_quartile_range_name"];
		  $numerator = $row["increment_applied_on_salary"] - $row["min_salary_for_penetration"];
		  $current_position_pay_range = HLP_get_range_penetration_for_salary($numerator, $denominator);
		}
		else
		{
		  //$current_position_pay_range = HLP_get_formated_percentage_common($row["crr_val"]).'%';
		  	if($row["mkt_salary_after_promotion"])
			{
				$current_position_pay_range = HLP_get_formated_percentage_common(($row["increment_applied_on_salary"]/$row["mkt_salary_after_promotion"])*100).'%';
			}
			else
			{
				$current_position_pay_range = '0.00%';
			}
		}
		$item_arr[] = $current_position_pay_range;
		$item_arr[] = HLP_get_formated_percentage_common($manager_max_dec_per)." - ".HLP_get_formated_percentage_common($manager_max_incr_per)."%";
		$item_arr[] = HLP_get_formated_amount_common($emp_revised_final_roundup_sal-$row["increment_applied_on_salary"]);
		//$item_arr[] = HLP_get_formated_percentage_common((float)$sp_per+$row["manager_discretions"])."%";
		$item_arr[] = HLP_get_formated_percentage_common($row["manager_discretions"])."%";
		$item_arr[] = HLP_get_formated_amount_common($emp_revised_final_roundup_sal);
		//$item_arr[] = HLP_get_formated_amount_common($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["sp_manager_discretions"] + $row["manager_discretions"])/100));
		$item_arr[] = HLP_get_formated_amount_common($row["current_target_bonus"] + ($row["current_target_bonus"]*($row["manager_discretions"])/100));

		if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
		{
			//$item_arr[]= $row["post_quartile_range_name"];
			$numerator = $emp_revised_final_roundup_sal - $row["min_salary_for_penetration"];
		  	$item_arr[] = HLP_get_range_penetration_for_salary($numerator, $denominator);
		}
		else
		{
			if($row["mkt_salary_after_promotion"])
			{
				$item_arr[]= HLP_get_formated_percentage_common(($emp_revised_final_roundup_sal/$row["mkt_salary_after_promotion"])*100).'%';
			}
			else
			{
				$item_arr[] = 0;
			}
		}

		$item_arr[] =$row['business_level_3'];
		$item_arr[] =$row['sub_sub_function'];
		$item_arr[] =$row['education'];
		$item_arr[] =$row['critical_talent'];
		$item_arr[] =$row['critical_position'];
		$item_arr[] =$row['special_category'];
		$item_arr[] =$row['recently_promoted'];
		$item_arr[] =$row['currency'];
		$item_arr[] =$row['manager_name'];
		fputcsv($fp, $item_arr);
	}
	fclose($fp);
}

function HLP_bulk_upload_hr_managers_direct_emps_increments($rule_dtls, $file_path, $manager_emailid, $req_by=1)
{
	//Note :: $req_by (1=Called this function By Manager, 2=Called this function By HR)
	$CI = & get_instance();
	$CI->load->model('rule_model');
	$CI->load->model('manager_model');
	$rule_id = $rule_dtls["id"];
	$type_of_hike_can_edit_arr = explode(",", $rule_dtls["type_of_hike_can_edit"]);
	
	$grade_list = $CI->common_model->get_table("manage_grade", "id, name", "", "order_no asc");
	$designation_list = $CI->common_model->get_table("manage_designation", "id, name", "", "order_no asc");
	$level_list = $CI->common_model->get_table("manage_level", "id, name", "", "order_no asc");
	
	$promotion_col_name = CV_BA_NAME_GRADE;
	$promotion_tbl_name = "manage_grade";
	$other_then_promotion_col_arr = array(CV_BA_NAME_DESIGNATION, CV_BA_NAME_LEVEL);
	if($rule_dtls['promotion_basis_on']==1)
	{
		$promotion_col_name = CV_BA_NAME_DESIGNATION;
		$promotion_tbl_name = "manage_designation";
		$other_then_promotion_col_arr = array(CV_BA_NAME_GRADE, CV_BA_NAME_LEVEL);
	}
	elseif($rule_dtls['promotion_basis_on']==3)
	{
		$promotion_col_name = CV_BA_NAME_LEVEL;
		$promotion_tbl_name = "manage_level";
		$other_then_promotion_col_arr = array(CV_BA_NAME_DESIGNATION, CV_BA_NAME_GRADE);
	}
	
	$promotion_tbl_and_col_dtls = array(
									"promotion_tbl_name"=>$promotion_tbl_name,
									"promotion_col_name"=>$promotion_col_name,
									"other_then_promotion_col_name1"=>$other_then_promotion_col_arr[0],
									"other_then_promotion_col_name2"=>$other_then_promotion_col_arr[1]
									);	
	
	if($req_by == 1)
	{
		$other_then_promotion_col_arr = array();
	}
	
	if($req_by == 1)
	{
		if($rule_dtls['esop_right']==1)
		{
			$colName="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==2)
		{
			$colName="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_3,approver_4";
		}
		else if($rule_dtls['esop_right']==3)
		{
			$colName="approver_4";
		}
		if($rule_dtls['pay_per_right']==1)
		{
			$colName2="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==2)
		{
			$colName2="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_3,approver_4";
		}
		else if($rule_dtls['pay_per_right']==3)
		{
			$colName2="approver_4";
		}
		
		if($rule_dtls['retention_bonus_right']==1)
		{
			$colName3="approver_1,approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==2)
		{
			$colName3="approver_2,approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==3)
		{
			$colName3="approver_3,approver_4";
		}
		else if($rule_dtls['retention_bonus_right']==4)
		{
			$colName3="approver_4";
		}
		$checkApproverEsopRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName);		
		$checkApproverPayPerRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName2);		
		$checkApproverBonusRecommandetionRights=HLP_find_approver($rule_dtls['id'],$manager_emailid,$colName3);
	}
	else
	{		
		$checkApproverEsopRights = 1;
		$checkApproverPayPerRights = 1;      
		$checkApproverBonusRecommandetionRights = 1;
	}
	
	$ins_columns = "email_id, performance_rating, merit_hike, market_hike, total_hike";
	
	if($rule_dtls['promotion_basis_on'] > 0)
	{
		$ins_columns .= ", promotion_recommendation";
		$ins_columns .= ", promotion_percentage";
		
		if($req_by == 2 or ($req_by == 1 and $rule_dtls['promotion_can_edit']==1))
		{
			$ins_columns .= ", emp_new_".$promotion_col_name;
		}
		
		if($other_then_promotion_col_arr)
		{
			$ins_columns .= ", emp_new_".$other_then_promotion_col_arr[0];
			$ins_columns .= ", emp_new_".$other_then_promotion_col_arr[1];
		}
	}

	if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
	{
		$ins_columns .= ", esop_val";
	}
	if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
	{
		$ins_columns .= ", pay_per_val";
	}
	if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
	{
		$ins_columns .= ", retention_bonus_val";
	}

	$emps_list = $CI->manager_model->bulk_upload_managers_direct_emps_increments($rule_dtls, $ins_columns, $file_path, $req_by);

	$salary_elem_ba_list = $CI->rule_model->get_salary_elements_list("id, ba_name, module_name, display_name", "(business_attribute.module_name = '" . CV_SALARY_ELEMENT . "' OR business_attribute.module_name = '" . CV_BONUS_APPLIED_ON . "' OR business_attribute.module_name = '" . CV_MARKET_SALARY_ELEMENT . "')");

	$ins_cnt = 0;
	$error_arr = array();
	if($emps_list)
	{
		foreach($emps_list as $row)
		{
			if(($row["new_performance_rating_id"]) and $row["new_performance_rating_id"] != $row["old_performance_rating_id"])
			{				
				$emp_current_sal_dtls = array(
										"id"=>$row["id"], 
										"user_id"=>$row["user_id"],
										"increment_applied_on_salary"=>$row["increment_applied_on_salary"],
										"proreta_multiplier"=>$row["proreta_multiplier"],
										"final_salary"=>$row["final_salary"],
										"sp_manager_discretions"=>$row["sp_manager_discretions"],
										"promotion_comment"=>$row["promotion_comment"],
										"status"=>$row["status"]);
				$new_rating_dtls=array("id"=>$row["new_performance_rating_id"],"name"=>$row["performance_rating"]);

				$rating_upd_dtls = HLP_update_users_performance_rating_for_salary_rule($rule_dtls, $emp_current_sal_dtls, $new_rating_dtls, $salary_elem_ba_list, $req_by);

				if($rating_upd_dtls["status"]==true)
				{
					$row["market_salary"] =  $rating_upd_dtls["updated_data"]["market_salary"];					
					$row["mkt_salary_after_promotion"] =  $rating_upd_dtls["updated_data"]["mkt_salary_after_promotion"];					
					$row["crr_after_promotion"] =  $rating_upd_dtls["updated_data"]["crr_after_promotion"];
					$row["quartile_range_name_after_promotion"] =  $rating_upd_dtls["updated_data"]["quartile_range_name_after_promotion"];					
					$row["final_merit_hike"] =  $rating_upd_dtls["updated_data"]["final_merit_hike"];
					$row["final_market_hike"] =  $rating_upd_dtls["updated_data"]["final_market_hike"];
					$row["manager_discretions"] =  $rating_upd_dtls["updated_data"]["manager_discretions"];
					$row["sp_manager_discretions"] =  $rating_upd_dtls["updated_data"]["sp_manager_discretions"];
					$row["final_salary"] =  $rating_upd_dtls["updated_data"]["final_salary"];
					$row["promotion_comment"] =  $rating_upd_dtls["updated_data"]["promotion_comment"];
				}
				else
				{
					$error_arr[] = array("user_id"=>$row["user_id"], "error_msg"=>$row["message"]);
					$CI->manager_model->update_tbl_data("tbl_temp_bulk_upload_emp_increments", array("is_error"=>1, "error_msg"=>$row["message"]), array("id"=>$row["ttbu_pk_id"]));
					continue;
				}
			}

			$emp_new_suggested_position = $emp_new_position_name = "";
			$emp_new_suggested_promotion_per = 0;
			
			if($rule_dtls['promotion_basis_on'] > 0)
			{
				if(in_array(CV_SALARY_PROMOTION_HIKE, $type_of_hike_can_edit_arr))
				{
					if(strtolower($row["promotion_recommendation"])=='yes')
					{
						//$emp_new_suggested_promotion_per = $row["emp_default_standard_promotion"];
						$emp_new_suggested_promotion_per = $row["promotion_percentage"];
					}
				}
				else
				{
					if(strtolower($row["promotion_recommendation"])=='yes')
					{
						$emp_new_suggested_promotion_per = $row["emp_default_standard_promotion"];
					}
				}
				
				if($req_by==1)
				{	
					if($rule_dtls['promotion_can_edit']==1 and $row["emp_new_".$promotion_col_name] != "")
					{
						$emp_new_position_name = $row["emp_new_".$promotion_col_name];
					}
				}
				else
				{
					if($row["emp_new_".$promotion_col_name] != "")
					{
						$emp_new_position_name = $row["emp_new_".$promotion_col_name];
					}
				}
				
				if($emp_new_position_name != "")
				{
					foreach (${$promotion_col_name."_list"} as $othr_row)
					{
						if(strtolower($row['emp_new_'.$promotion_col_name])==strtolower($othr_row['name']))
						{
							$emp_new_suggested_position = $othr_row['id'];
							break;
						}
					}
				}			
				
				if(strtolower($row["promotion_recommendation"])=='yes')
				{
					$row["performance_rating_id"] = $row['new_performance_rating_id'];
					$row["emp_new_suggested_promotion_per"] = $emp_new_suggested_promotion_per;
					$row["emp_new_suggested_position"] = $emp_new_suggested_position;
					$row["promotion_basis_on"] = $rule_dtls['promotion_basis_on'];
					$row["hike_multiplier_basis_on"] = $rule_dtls['hike_multiplier_basis_on'];
					$row["multiplier_wise_per_dtls"] = $rule_dtls['multiplier_wise_per_dtls'];
					$row["comparative_ratio_calculations"] = $rule_dtls['comparative_ratio_calculations'];
					$row["crr_percent_values"] = $rule_dtls['crr_percent_values'];
					$row["comparative_ratio_range"] = $rule_dtls['comparative_ratio_range'];				
					$row["salary_position_based_on"] = $rule_dtls['salary_position_based_on'];
					$row["bring_emp_to_min_sal"] = $rule_dtls['bring_emp_to_min_sal'];
					$row["performnace_based_hike"] = $rule_dtls['performnace_based_hike'];				
					$row["include_promotion_budget"] = $rule_dtls['include_promotion_budget'];	
					$row["promotion_tbl_and_col_dtls"] = $promotion_tbl_and_col_dtls;			
					$new_dtls_after_promotion = HLP_get_new_mkt_dtls_after_promotion(1, $row);
					
					
					$temp="";
					$promotionComment=[];
					$promotionComment[]=array(
							"email"=>strtolower($CI->session->userdata('email_ses')),
							"name"=>$CI->session->userdata('username_ses'),
							"increment_per"=>HLP_get_formated_percentage_common($new_dtls_after_promotion["n_final_total_hike"]),
							"permotion_per"=>HLP_get_formated_percentage_common($new_dtls_after_promotion["n_promotion_hike"]),
							"changed_by"=>($req_by==1)? "Manager":"HR",
							"role"=>($req_by==1)? "Manager":"HR",
							"rating"=>$row['performance_rating'],
							"final_salary"=>$new_dtls_after_promotion["n_final_salary"],
							"final_increment_amount"=>$new_dtls_after_promotion["n_final_salary"] - $row["increment_applied_on_salary"],
							"final_increment_per"=>HLP_get_formated_percentage_common($row["final_merit_hike"] + $new_dtls_after_promotion["n_promotion_hike"] + $new_dtls_after_promotion["n_market_hike"]),
							"createdby_proxy" => $CI->session->userdata('proxy_userid_ses'),
							"createdon" => date("Y-m-d H:i:s")
						);
		
					if($row['promotion_comment']!="")
					{
						$temp=json_decode($row['promotion_comment'],true);
						if(json_last_error()=== JSON_ERROR_NONE)
						{
							for($i=0; $i<count($temp); $i++)
							{
								if($temp[$i]["email"]!=strtolower($CI->session->userdata('email_ses')))
								{
									$promotionComment[]=$temp[$i];
								}
							}
						}
					}				
					
					$row["manager_discretions"] =  $new_dtls_after_promotion["n_final_total_hike"];
					$row["final_salary"] =  $new_dtls_after_promotion["n_final_salary"];
					$row["final_market_hike"] =  $new_dtls_after_promotion["n_market_hike"];
					$row["mkt_salary_after_promotion"] =  $new_dtls_after_promotion["n_market_salary_for_crr"];
					$row["crr_after_promotion"] =  $new_dtls_after_promotion["n_crr_val"];
					$row["sp_increased_salary"] =  $new_dtls_after_promotion["n_promotion_salary"];
					$row["sp_manager_discretions"] =  $new_dtls_after_promotion["n_promotion_hike"];
					$row['emp_new_'.$promotion_col_name] = $new_dtls_after_promotion["emp_new_post_id"];
					$row["quartile_range_name_after_promotion"] =  $new_dtls_after_promotion["quartile_range_name_after_promotion"];
					$row["post_quartile_range_name"] =  $new_dtls_after_promotion["post_quartile_range_name"];
					$row["promotion_comment"] =  json_encode($promotionComment);				
				}
			}
			
			if(in_array(CV_SALARY_MERIT_HIKE, $type_of_hike_can_edit_arr))
			{
				$row["final_merit_hike"] =  $row["merit_hike"];			
			}
			
			if(in_array(CV_SALARY_MARKET_HIKE, $type_of_hike_can_edit_arr))
			{
				$row["final_market_hike"] =  $row["market_hike"];			
			}
			
			if(in_array(CV_SALARY_TOTAL_HIKE, $type_of_hike_can_edit_arr))
			{
				$row["manager_discretions"] =  $row["total_hike"];	
				$row["final_salary"] = $row["increment_applied_on_salary"] + ($row["increment_applied_on_salary"]*$row["manager_discretions"])/100;	
			}
			else
			{
				$new_final_total_hike = $row["final_merit_hike"]+$row["final_market_hike"];
				if($rule_dtls["include_promotion_budget"] == 1)
				{
					$new_final_total_hike += $row["sp_manager_discretions"];
				}
				$total_hike = $row["final_merit_hike"]+$row["final_market_hike"]+$row["sp_manager_discretions"];
				$row["manager_discretions"] =  $new_final_total_hike;
				$row["final_salary"] = $row["increment_applied_on_salary"] + ($row["increment_applied_on_salary"]*$total_hike)/100;
			}
			
			$temp="";
			$salaryComment=[];
			$salaryComment[]=array(
							"email"=>strtolower($CI->session->userdata('email_ses')),
							"name"=>$CI->session->userdata('username_ses'),
							"increment_per"=>HLP_get_formated_percentage_common($row["manager_discretions"]),
							"permotion_per"=>HLP_get_formated_percentage_common($row['sp_manager_discretions']),
							"changed_by"=>($req_by==1)? "Manager":"HR",
							"role"=>($req_by==1)? "Manager":"HR",
							"rating"=>$row['performance_rating'],
							"final_salary"=>$row["final_salary"],
							"final_increment_amount"=>$row["final_salary"]-$row["increment_applied_on_salary"],
							"final_increment_per"=>HLP_get_formated_percentage_common($row["final_merit_hike"]+$row["final_market_hike"]+$row["sp_manager_discretions"]),
							"createdby_proxy" => $CI->session->userdata('proxy_userid_ses'),
							"createdon" => date("Y-m-d H:i:s")
				);

			if($row['promotion_comment']!="")
			{
				$temp=json_decode($row['promotion_comment'],true);
				if(json_last_error()=== JSON_ERROR_NONE)
				{
					for($i=0; $i<count($temp); $i++)
					{
						if($temp[$i]['email'] != strtolower($CI->session->userdata('email_ses')))
						{
							$salaryComment[]=$temp[$i];
						}
					}
				}
			}

			$db_arr = array(
						"final_merit_hike"=>$row["final_merit_hike"],
						"final_market_hike"=>$row["final_market_hike"],
						"manager_discretions"=>$row["manager_discretions"],						
						"final_salary"=>$row["final_salary"],
						"mkt_salary_after_promotion"=>$row["mkt_salary_after_promotion"],
						"crr_after_promotion"=>$row["crr_after_promotion"],						
						"quartile_range_name_after_promotion"=>$row["quartile_range_name_after_promotion"],
						"promotion_comment"=>$row["promotion_comment"],
						"updatedon" =>date("Y-m-d H:i:s"),
						"updatedby" =>$CI->session->userdata('userid_ses'),
						"updatedby_proxy"=>$CI->session->userdata("proxy_userid_ses"));
			
			$post_quartile_range_name = "";
			if($rule_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
			{
				$crr_arr = json_decode($rule_dtls["comparative_ratio_range"], true);
				$post_quartile_range_name = HLP_get_quartile_position_range_name($row, $row["final_salary"], $crr_arr);
			}
			$db_arr["post_quartile_range_name"] = $post_quartile_range_name;
			
			if($rule_dtls['promotion_basis_on'] > 0)
			{
				if(strtolower($row["promotion_recommendation"])=='yes')
				{
					$db_arr["sp_increased_salary"] = $row["sp_increased_salary"];				
					$db_arr["sp_manager_discretions"] = $row["sp_manager_discretions"];
					$db_arr["emp_new_".$promotion_col_name] = $row["emp_new_".$promotion_col_name];
				}
				
				if($other_then_promotion_col_arr)
				{
					foreach (${$other_then_promotion_col_arr[0]."_list"} as $othr_row)
					{
						if(strtolower($row['emp_new_'.$other_then_promotion_col_arr[0]])==strtolower($othr_row['name']))
						{
							$db_arr['emp_new_'.$other_then_promotion_col_arr[0]] = $othr_row['id'];
							break;
						}
					}
					foreach (${$other_then_promotion_col_arr[1]."_list"} as $othr_row)
					{
						if(strtolower($row['emp_new_'.$other_then_promotion_col_arr[1]])==strtolower($othr_row['name']))
						{
							$db_arr['emp_new_'.$other_then_promotion_col_arr[1]] = $othr_row['id'];
							break;
						}
					}
				}
				
				
				if(!isset($db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name1"]]))
				{
					$db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name1"]] = $new_dtls_after_promotion["other_then_promotion_col_name1"];
				}
				if(!isset($db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name2"]]))
				{
					$db_arr['emp_new_'.$promotion_tbl_and_col_dtls["other_then_promotion_col_name2"]] = $new_dtls_after_promotion["other_then_promotion_col_name2"];
				}
			}
			
			if($rule_dtls["esop_title"] != "" && !empty($checkApproverEsopRights))
			{
				$db_arr["esop"] = $row["esop_val"];
			}
			if($rule_dtls["pay_per_title"] != "" && !empty($checkApproverPayPerRights))
			{
				$db_arr["pay_per"] = $row["pay_per_val"];
			}
			if($rule_dtls["retention_bonus_title"] != "" && !empty($checkApproverBonusRecommandetionRights))
			{
				$db_arr["retention_bonus"] = $row["retention_bonus_val"];
			}

			//echo "<pre>";print_r($db_arr);die;
			//$CI->manager_model->update_tbl_data("employee_salary_details", $db_arr, array("rule_id"=>$rule_id, "user_id"=>$row["user_id"]));
			$CI->manager_model->update_tbl_data("employee_salary_details", $db_arr, array("id"=>$row["id"]));
			$ins_cnt++;
		}

	}
	$invalid_data = $CI->rule_model->get_table("tbl_temp_bulk_upload_emp_increments","*", array("is_error"=>1));
	return array("insert_counts"=>$ins_cnt, "invalid_data"=>$invalid_data);
}
//*End :: CB::Ravi on 29-05-09 To upload bulk Increments By the HR/Managers *********************
function HLP_get_rating_distribution_dtls($rule_id, $manager_email)
{
	$CI = & get_instance();
	/*$result= $CI->db->query("SELECT employee_salary_details.performance_rating_id, employee_salary_details.performance_rating, (select order_no from manage_rating_for_current_year where manage_rating_for_current_year.id = employee_salary_details.performance_rating_id) AS p_order_no,
(SELECT count(*) FROM employee_salary_details esd WHERE esd.rule_id = ".$rule_id." AND esd.performance_rating_id = employee_salary_details.performance_rating_id AND (esd.`approver_1`='".$manager_email."' OR esd.`approver_2`='".$manager_email."' OR esd.`approver_3`='".$manager_email."' OR esd.`approver_4`='".$manager_email."')) AS rating_wise_emp_cnt,
(SELECT avg(esd_inc.manager_discretions) FROM employee_salary_details esd_inc WHERE esd_inc.rule_id = ".$rule_id." AND esd_inc.performance_rating_id = employee_salary_details.performance_rating_id AND (esd_inc.`approver_1`='".$manager_email."' OR esd_inc.`approver_2`='".$manager_email."' OR esd_inc.`approver_3`='".$manager_email."' OR esd_inc.`approver_4`='".$manager_email."')) AS avg_increase
FROM `employee_salary_details`
WHERE rule_id = ".$rule_id." AND
(employee_salary_details.`approver_1`='".$manager_email."' OR employee_salary_details.`approver_2`='".$manager_email."' OR employee_salary_details.`approver_3`='".$manager_email."' OR employee_salary_details.`approver_4`='".$manager_email."')
group by employee_salary_details.performance_rating_id order by p_order_no ASC, employee_salary_details.performance_rating ASC");*/


	$result= $CI->db->query("SELECT esd.performance_rating_id, esd.performance_rating, mrcy.order_no AS p_order_no, COUNT(esd.performance_rating_id) AS rating_wise_emp_cnt, AVG(esd.manager_discretions) AS avg_increase, SUM(esd.increment_applied_on_salary*esd.performnace_based_increment*esd.emp_currency_conversion_rate*0.01) AS rating_wise_allocated_bdgt, SUM(esd.increment_applied_on_salary*esd.final_merit_hike*esd.emp_currency_conversion_rate*0.01) AS rating_wise_used_bdgt, SUM(esd.increment_applied_on_salary) AS rating_wise_emp_salary  
FROM `employee_salary_details`esd, manage_rating_for_current_year mrcy WHERE rule_id = ".$rule_id." AND mrcy.id = esd.performance_rating_id AND (esd.`approver_1`='".$manager_email."' OR esd.`approver_2`='".$manager_email."' OR esd.`approver_3`='".$manager_email."' OR esd.`approver_4`='".$manager_email."') GROUP BY esd.performance_rating_id, esd.performance_rating, p_order_no ORDER BY p_order_no ASC, esd.performance_rating ASC");
     //print_r($result->result_array()); die;
    return $result->result_array();
}


function HLP_get_employee_rating_data($manager_email,$rule_id,$status=1) {
	$total = 0;
    $CI = & get_instance();
    $CI->db->select("e.performance_rating,count(e.performance_rating) as count,sum(e.manager_discretions) as ratting_increase_total,count(e.manager_discretions) as ratting_count");
    $CI->db->from("employee_salary_details as e");
    $CI->db->join("manage_rating_for_current_year as r",'e.performance_rating=r.name');
    $CI->db->where(array("e.manager_emailid" => $manager_email,'e.rule_id'=>$rule_id));
    $CI->db->where("e.status < ",'5');
    $CI->db->order_by("r.order_no");
    $CI->db->group_by("performance_rating");
   	$data = $CI->db->get()->result_array();
   	//echo $this->db->last_query();
   	//return $data = $CI->db->get()->rusult_array();
   	//$final = $data;
   	foreach ($data as $key => $value) {
   		$total += $value['count'];

   	}
   	$fianl_data = array('results'=>$data,'total_ratting'=>$total);
   	//echo $key;
   	//$data['total_ratting'] = $total;
   	return $fianl_data;
   	print_r($fianl_data);
   	die;

}

####################### kingjuliean ############################


################################################################
#          													   #
#															   #
#  Find the Approver Which has into the table                  #
#                                                              #
#															   #
################################################################

function HLP_find_approver($ruleId,$approver_emailId,$colName)
	{
		$CI = & get_instance();

		return $CI->db->query("SELECT id FROM employee_salary_details where rule_id='".$ruleId."' and '".$approver_emailId."' IN (".$colName.") ")->result();

	}
############ Get SMTP DEtails FOR Sending Mail #############
	function HLP_GetSMTP_Details($id='')
	{
		  $CI = & get_instance();
		  if(empty($id))
		  {
		  	$id=$CI->session->userdata('companyid_ses');
		  }

		  $CI->load->model('admin_model');//AB: Ravi on 07-07-19, because admin model instance was missing
		  $smtp_detail=$CI->admin_model->get_table_row("manage_company", "smtp_detail", array("id" =>$id));

            $smtpdetail=unserialize($smtp_detail['smtp_detail']);

            if($smtpdetail['user']=='' || $smtpdetail['password']=='' || $smtpdetail['host']=='' || $smtpdetail['port']=='' || $smtpdetail['connections']=='' || $smtpdetail['email']=='' || $smtpdetail['name']=='')
            {
            // default smtp details
            $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => SMTP_HOST,
            'smtp_port' => SMTP_PORT,
            'smtp_user' => SMTP_USER,
            'smtp_pass' => SMTP_PASSWORD,
            'smtp_crypto' => SMTP_CONNECTION,
            'charset' => 'utf-8',
            'mailtype' => 'html'
            );
            $mail_fromname=FROM_NAME;
            $email_from=FROM_EMAIL;
            }
            else
            {
            // company provided smtp details
            $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => $smtpdetail['host'],
            'smtp_port' => $smtpdetail['port'],
            'smtp_user' => $smtpdetail['user'],
            'smtp_pass' => $smtpdetail['password'],
            'smtp_crypto' => $smtpdetail['connections'],
            'charset' => 'utf-8',
            'mailtype' => 'html'
            );
            $email_from=$smtpdetail['email'];
            $mail_fromname=$smtpdetail['name'];
            }
            $data=array('email_from'=>$email_from,'mail_fromname'=>$mail_fromname,'result'=>$email_config);

            return $data;
	}

################################################################
################# Random AlphaNumaric Password ############
function HLP_generateRandomStringPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function DownloadSalaryStructure($staff_list,$flexiid,$type,$ruleid,$flexi_plan_type,$gradelevel_list)
{
    $CI = & get_instance();
    $CI->load->model('admin_model');
    $CI->load->model('rule_model');
    $attrarr = [];
    $attributes = $CI->db->query("SELECT * FROM `business_attribute` WHERE business_attribute.status = 1 AND (business_attribute.module_name = '".CV_SALARY_ELEMENT."' OR business_attribute.module_name = '".CV_BONUS_APPLIED_ON."' OR id In(2,48,169)) ORDER BY `business_attribute`.`ba_attributes_order` ASC")->result_array();


$tempattributes_array=[];
// $att_list_array = [];
    foreach ($attributes as $val) {
        $attrarr[$val['display_name']] = $val['display_name'];

        $tempattributes_array[]=$val;

       /* if(in_array($val['id'], array(3,4,5,6,7,8,9,10,11,12,13,14,15,16,35,136))) {
        $str[]="manage_".$val['ba_name'].".name as ".$val['ba_name'];
        }
		else{*/

            $str[]="login_user.".$val['ba_name'];
        //}
    }

    $str[]="login_user.id";
   $strdata = implode(",",$str);
    $filter_emp_list=array();
    foreach ($staff_list as $key => $value) {
    	array_push($filter_emp_list, $value['id']);
    }

	$final_user_list=array();
	$empDetail = array();

    if($type==2)
    {
	   $empDetail = $CI->admin_model->get_emp_dtls_for_export_ruleList($strdata, $filter_emp_list,'manager',$ruleid);
    }
    else
    {
		$ruleid=0;
		if (!empty($strdata) && !empty($filter_emp_list)) {
			$empDetail = $CI->admin_model->get_emp_dtls_for_export($strdata,$filter_emp_list);
		}
    }

    $emparr = [];
    $temparr = [];
$remove_attname=array('education','critical_talent','critical_position','special_category','start_date_for_role','end_date_for_role','bonus_incentive_applicable','recently_promoted','performance_achievement','rating_for_current_year','rating_for_last_year','rating_for_2nd_last_year','rating_for_3rd_last_year','rating_for_4th_last_year','rating_for_5th_last_year','increment_applied_on');

 foreach ($tempattributes_array as $value)
 {
 	if(in_array($value['ba_name'],$remove_attname))
	  {
	    continue;
	  }
 	$att_list_array[$value['id']]=$value['ba_name'];
 }

for ($k = 0; $k < count($empDetail); $k++) {

 foreach ($tempattributes_array as $at) {
     $flag=0;
      if(in_array($at['ba_name'],$remove_attname))
          {
            continue;
          }

   if(array_search($at['ba_name'], $att_list_array))
	{

    $allowance_id= array_search($at['ba_name'], $att_list_array);
    $salary_brakup=$CI->admin_model->get_table_row('final_salary_structure','*',['allowance_id'=>$allowance_id,'flaxi_plan_id'=>$flexiid]);
	    if(!empty($salary_brakup))
	    {

	      $cal_amount=explode(',',$salary_brakup['amount']);
	    }
	    $flag=1;
    }
 if(array_search($empDetail[$k][$flexi_plan_type], $gradelevel_list))
     {

    $arr_index= array_search($empDetail[$k][$flexi_plan_type], $gradelevel_list);
     	if($flag==1)
        {
        	//$type=2(accordding rule) $type=1 (core data)
		 if($type==2)
		 {
           $total_compensation=$empDetail[$k]['final_salary'];
		 }else
		 {
            $total_compensation=$empDetail[$k]['total_compensation'];
		 }

         if($at['ba_name']!='increment_purpose_joining_date')
         	$amount=$cal_amount[intval($arr_index)];
         	if($amount!='')
         	{
         		if($at['ba_name']!='total_compensation')
         		{
         			 $empDetail[$k][$at['ba_name']]=$total_compensation*$amount/100;
         		}
         	//
         	}
        }
     }

     $emparr[$at['display_name']] = $empDetail[$k][$at['ba_name']];

        }
        $emparr['Revised Fixed Salary'] ='0';
        array_push($temparr, $emparr);
    }
    return $temparr;
}

function HLP_get_table_data($tbl_name, $select_flds, $whr_arr, $ordr_by="id ASC")
{
	$CI = get_instance();
	$CI->load->model('rule_model');
	return $CI->rule_model->get_table($tbl_name, $select_flds, $whr_arr, $ordr_by);
}

function get_business_attribute_status_array($data){

	$hide_field_array = array();
	$hide_field_array['employee_code'] = '';
	$hide_field_array['name'] = '';
	$hide_field_array['email'] = '';
	$hide_field_array['country'] = '';
	$hide_field_array['city'] = '';
	$hide_field_array['business_level_1'] = '';//group
	$hide_field_array['business_level_2'] = '';//division
	$hide_field_array['business_level_3'] = '';//Area
	$hide_field_array['function'] = '';
	$hide_field_array['subfunction'] = '';
	$hide_field_array['designation'] = ''; //title
	$hide_field_array['grade'] = '';
	$hide_field_array['level'] = '';
	$hide_field_array['company_joining_date'] = '';//Date of Joining
	$hide_field_array['increment_purpose_joining_date'] = '';//Date of joining for salary review purpose
	$hide_field_array['rating_for_current_year'] = ''; //Performance Rating
	$hide_field_array['currency'] = '';
	$hide_field_array['current_base_salary'] = '';//Base Salary
	$hide_field_array['current_target_bonus'] = ''; //Current target bonus
	$hide_field_array['total_compensation'] = '';
	$hide_field_array['approver_1'] = '';
	$hide_field_array['manager_name'] = '';
	$hide_field_array['gender'] = '';
	$hide_field_array['start_date_for_role'] = '';
	$hide_field_array['sub_subfunction'] = '';
	$hide_field_array['education'] = '';
	$hide_field_array['critical_talent'] = '';
	$hide_field_array['critical_position'] = '';
	$hide_field_array['special_category'] = '';
	$hide_field_array['urban_rural_classification'] =  '';

	if(!empty($data)) {

		foreach($data as $key => $value) {

			if ($value['ba_name'] == 'employee_code') { if ($value['status'] == 0 ) { $hide_field_array['employee_code'] = 'hide'; }}
			if ($value['ba_name'] == 'name') { if ($value['status'] == 0 ) { $hide_field_array['name'] = 'hide'; }}
			if ($value['ba_name'] == 'email') { if ($value['status'] == 0 ) { $hide_field_array['email'] = 'hide'; }}
			if ($value['ba_name'] == 'country') { if ($value['status'] == 0 ) { $hide_field_array['country'] = 'hide'; }}
			if ($value['ba_name'] == 'city') { if ($value['status'] == 0 ) { $hide_field_array['city'] = 'hide'; }}
			if ($value['ba_name'] == 'business_level_1') { if ($value['status'] == 0 ) { $hide_field_array['business_level_1'] = 'hide'; }}
			if ($value['ba_name'] == 'business_level_2') { if ($value['status'] == 0 ) { $hide_field_array['business_level_2'] = 'hide'; }}
			if ($value['ba_name'] == 'business_level_3') { if ($value['status'] == 0 ) { $hide_field_array['business_level_3'] = 'hide'; }}
			if ($value['ba_name'] == 'function') { if ($value['status'] == 0 ) { $hide_field_array['function'] = 'hide'; }}
			if ($value['ba_name'] == 'subfunction') { if ($value['status'] == 0 ) { $hide_field_array['subfunction'] = 'hide'; }}
			if ($value['ba_name'] == 'designation') { if ($value['status'] == 0 ) { $hide_field_array['designation'] = 'hide'; }}
			if ($value['ba_name'] == 'grade') { if ($value['status'] == 0 ) { $hide_field_array['grade'] = 'hide'; }}
			if ($value['ba_name'] == 'level') { if ($value['status'] == 0 ) { $hide_field_array['level'] = 'hide'; }}
			if ($value['ba_name'] == 'company_joining_date') { if ($value['status'] == 0 ) { $hide_field_array['company_joining_date'] = 'hide'; }}
			if ($value['ba_name'] == 'increment_purpose_joining_date') { if ($value['status'] == 0 ) { $hide_field_array['increment_purpose_joining_date'] = 'hide'; }}
			if ($value['ba_name'] == 'rating_for_current_year') { if ($value['status'] == 0 ) { $hide_field_array['rating_for_current_year'] = 'hide'; }}
			if ($value['ba_name'] == 'currency') { if ($value['status'] == 0 ) { $hide_field_array['currency'] = 'hide'; }}
			if ($value['ba_name'] == 'current_base_salary') { if ($value['status'] == 0 ) { $hide_field_array['current_base_salary'] = 'hide'; }}
			if ($value['ba_name'] == 'current_target_bonus') { if ($value['status'] == 0 ) { $hide_field_array['current_target_bonus'] = 'hide'; }}
			if ($value['ba_name'] == 'total_compensation') { if ($value['status'] == 0 ) { $hide_field_array['total_compensation'] = 'hide'; }}
			if ($value['ba_name'] == 'approver_1') { if ($value['status'] == 0 ) { $hide_field_array['approver_1'] = 'hide'; }}
			if ($value['ba_name'] == 'manager_name') { if ($value['status'] == 0 ) { $hide_field_array['manager_name'] = 'hide'; }}
			if ($value['ba_name'] == 'gender') { if ($value['status'] == 0 ) { $hide_field_array['gender'] = 'hide'; }}
			if ($value['ba_name'] == 'start_date_for_role') { if ($value['status'] == 0 ) { $hide_field_array['start_date_for_role'] = 'hide'; }}
			if ($value['ba_name'] == 'sub_subfunction') { if ($value['status'] == 0 ) { $hide_field_array['sub_subfunction'] = 'hide'; } }
			if ($value['ba_name'] == 'education') { if ($value['status'] == 0 ) { $hide_field_array['education'] = 'hide'; } }
			if ($value['ba_name'] == 'critical_talent') { if ($value['status'] == 0 ) { $hide_field_array['critical_talent'] = 'hide'; } }
			if ($value['ba_name'] == 'critical_position') { if ($value['status'] == 0 ) { $hide_field_array['critical_position'] = 'hide'; } }
			if ($value['ba_name'] == 'special_category') { if ($value['status'] == 0 ) { $hide_field_array['special_category'] = 'hide'; } }
			if ($value['ba_name'] == 'urban_rural_classification') { if ($value['status'] == 0  ) { $hide_field_array['urban_rural_classification'] = 'hide'; } }
		}

	}

	return $hide_field_array;

}


/* Return field name with business attributes , if required more filelds then add easily */
function get_business_attribute_display_name_array($data, $req_attibute_field_name_array =  false){

	$display_name_field_array = array();
	$attibute_field_name_array = array();
	$display_name_field_array['employee_code'] = 'Employee Code';
	$display_name_field_array['name'] = 'Employee Full name';
	$display_name_field_array['email'] = 'Email ID';
	$display_name_field_array['country'] = 'Country';
	$display_name_field_array['city'] = 'City';
	$display_name_field_array['business_level_1'] = 'Group';//group
	$display_name_field_array['business_level_2'] = 'Division';//division
	$display_name_field_array['business_level_3'] = 'Area';//Area
	$display_name_field_array['function'] = 'Function';
	$display_name_field_array['subfunction'] = 'Sub Function';
	$display_name_field_array['designation'] = 'Title'; //title
	$display_name_field_array['grade'] = 'Grade';
	$display_name_field_array['level'] = 'Level';
	$display_name_field_array['gender'] = 'Gender';
	$display_name_field_array['company_joining_date'] = 'Date of Joining';//Date of Joining
	$display_name_field_array['increment_purpose_joining_date'] = 'Date of joining for salary review purpose';//Date of joining for salary review purpose
	$display_name_field_array['rating_for_current_year'] = 'Performance Rating'; //Performance Rating
	$display_name_field_array['currency'] = 'Currency';
	$display_name_field_array['current_base_salary'] = 'Base Salary';//Base Salary
	$display_name_field_array['current_target_bonus'] = 'Current target bonus'; //Current target bonus
	$display_name_field_array['total_compensation'] = 'Total compensation';
	$display_name_field_array['approver_1'] = 'Approver-1';
	$display_name_field_array['manager_name'] = 'Manager Name';
	$display_name_field_array['sub_subfunction'] = 'Sub Sub Function';
	$display_name_field_array['education'] = 'Education';
	$display_name_field_array['critical_talent'] = 'Identified talent';
	$display_name_field_array['critical_position'] = 'Critical Position holder';
	$display_name_field_array['special_category'] = 'Special Category-1';
	$display_name_field_array['promoted_in_2_yrs'] = 'Promoted in 2 yrs';
	$display_name_field_array['successor_identified'] = 'Successor Identified';
	$display_name_field_array['readyness_level'] = 'Readyness level';
	$display_name_field_array['urban_rural_classification'] = 'Urban/Rural classification';

	$attibute_field_name_array['employee_code'] = '';
	$attibute_field_name_array['name'] = '';
	$attibute_field_name_array['email'] = '';
	$attibute_field_name_array['country'] = '';
	$attibute_field_name_array['city'] = '';
	$attibute_field_name_array['business_level_1'] = '';//group
	$attibute_field_name_array['business_level_2'] = '';//division
	$attibute_field_name_array['business_level_3'] = '';//Area
	$attibute_field_name_array['function'] = '';
	$attibute_field_name_array['subfunction'] = '';
	$attibute_field_name_array['designation'] = '';//title
	$attibute_field_name_array['grade'] = '';
	$attibute_field_name_array['level'] = '';
	$attibute_field_name_array['gender'] = '';
	$attibute_field_name_array['company_joining_date'] = '';//Date of Joining
	$attibute_field_name_array['increment_purpose_joining_date'] = '';//Date of joining for salary review purpose
	$attibute_field_name_array['rating_for_current_year'] = '';//Performance Rating
	$attibute_field_name_array['currency'] = '';
	$attibute_field_name_array['current_base_salary'] = '';//Base Salary
	$attibute_field_name_array['current_target_bonus'] = '';//Current target bonus
	$attibute_field_name_array['total_compensation'] = '';
	$attibute_field_name_array['approver_1'] = '';
	$attibute_field_name_array['manager_name'] = '';
	$attibute_field_name_array['sub_subfunction'] = '';
	$attibute_field_name_array['education'] = '';
	$attibute_field_name_array['critical_talent'] = '';
	$attibute_field_name_array['critical_position'] = '';
	$attibute_field_name_array['special_category'] = '';
	$attibute_field_name_array['promoted_in_2_yrs'] = '';
	$attibute_field_name_array['successor_identified'] = '';
	$attibute_field_name_array['readyness_level'] = '';
	$attibute_field_name_array['urban_rural_classification'] = '';

	if(!empty($data)) {

		foreach($data as $key => $value) {

			if ($value['ba_name'] == 'employee_code') {$attibute_field_name_array['employee_code'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['employee_code'] = $value['display_name']; } }
			if ($value['ba_name'] == 'name') {$attibute_field_name_array['name'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['name'] = $value['display_name']; } }
			if ($value['ba_name'] == 'email') {$attibute_field_name_array['email'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['email'] = $value['display_name']; } }
			if ($value['ba_name'] == 'country') {$attibute_field_name_array['country'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['country'] = $value['display_name']; } }
			if ($value['ba_name'] == 'city') {$attibute_field_name_array['city'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['city'] = $value['display_name']; } }
			if ($value['ba_name'] == 'business_level_1') {$attibute_field_name_array['business_level_1'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['business_level_1'] = $value['display_name']; } }
			if ($value['ba_name'] == 'business_level_2') {$attibute_field_name_array['business_level_2'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['business_level_2'] = $value['display_name']; } }
			if ($value['ba_name'] == 'business_level_3') {$attibute_field_name_array['business_level_3'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['business_level_3'] = $value['display_name']; } }
			if ($value['ba_name'] == 'function') {$attibute_field_name_array['function'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['function'] = $value['display_name']; } }
			if ($value['ba_name'] == 'subfunction') {$attibute_field_name_array['subfunction'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['subfunction'] = $value['display_name']; } }
			if ($value['ba_name'] == 'designation') {$attibute_field_name_array['designation'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['designation'] = $value['display_name']; } }
			if ($value['ba_name'] == 'grade') {$attibute_field_name_array['grade'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['grade'] = $value['display_name']; } }
			if ($value['ba_name'] == 'level') {$attibute_field_name_array['level'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['level'] = $value['display_name']; } }
			if ($value['ba_name'] == 'company_joining_date') {$attibute_field_name_array['company_joining_date'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['company_joining_date'] = $value['display_name']; } }
			if ($value['ba_name'] == 'increment_purpose_joining_date') {$attibute_field_name_array['increment_purpose_joining_date'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['increment_purpose_joining_date'] = $value['display_name']; } }
			if ($value['ba_name'] == 'rating_for_current_year') {$attibute_field_name_array['rating_for_current_year'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['rating_for_current_year'] = $value['display_name']; } }
			if ($value['ba_name'] == 'currency') {$attibute_field_name_array['currency'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['currency'] = $value['display_name']; } }
			if ($value['ba_name'] == 'current_base_salary') {$attibute_field_name_array['current_base_salary'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['current_base_salary'] = $value['display_name']; } }
			if ($value['ba_name'] == 'current_target_bonus') {$attibute_field_name_array['current_target_bonus'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['current_target_bonus'] = $value['display_name']; } }
			if ($value['ba_name'] == 'total_compensation') {$attibute_field_name_array['total_compensation'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['total_compensation'] = $value['display_name']; } }
			if ($value['ba_name'] == 'approver_1') {$attibute_field_name_array['approver_1'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['approver_1'] = $value['display_name']; } }
			if ($value['ba_name'] == 'manager_name') {$attibute_field_name_array['manager_name'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['manager_name'] = $value['display_name']; } }
			if ($value['ba_name'] == 'gender') {$attibute_field_name_array['gender'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['gender'] = $value['display_name']; } }
			if ($value['ba_name'] == 'sub_subfunction') {$attibute_field_name_array['sub_subfunction'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['sub_subfunction'] = $value['display_name']; } }
			if ($value['ba_name'] == 'education') {$attibute_field_name_array['education'] = $value['ba_name'];  if ($value['display_name'] != 'education' ) { $display_name_field_array['education'] = $value['display_name']; } }
			if ($value['ba_name'] == 'critical_talent') {$attibute_field_name_array['critical_talent'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['critical_talent'] = $value['display_name']; } }
			if ($value['ba_name'] == 'critical_position') {$attibute_field_name_array['critical_position'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['critical_position'] = $value['display_name']; } }
			if ($value['ba_name'] == 'special_category') {$attibute_field_name_array['special_category'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['special_category'] = $value['display_name']; } }
			if ($value['ba_name'] == 'promoted_in_2_yrs') {$attibute_field_name_array['promoted_in_2_yrs'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['promoted_in_2_yrs'] = $value['display_name']; } }
			if ($value['ba_name'] == 'successor_identified') {$attibute_field_name_array['successor_identified'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['successor_identified'] = $value['display_name']; } }
			if ($value['ba_name'] == 'readyness_level') {$attibute_field_name_array['readyness_level'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['readyness_level'] = $value['display_name']; } }
			if ($value['ba_name'] == 'urban_rural_classification') {$attibute_field_name_array['urban_rural_classification'] = $value['ba_name']; if ($value['display_name'] != '' ) { $display_name_field_array['urban_rural_classification'] = $value['display_name']; } }

		}

	}

	if ($req_attibute_field_name_array) {

		$res = array(
			'display_name_field_array' => $display_name_field_array,
			'attibute_field_name_array' => $attibute_field_name_array,
		);

		return $res;

	} else {
		return $display_name_field_array;
	}

}

/* get module status enable or disable */
function get_module_status($module_name = ''){

	if($module_name == '') {
		return false;
	}

	$ci = & get_instance();
	if ($module_name == 'compensation_plan') {

		if (empty($ci->session->userdata('salary_module')) && 
			empty($ci->session->userdata('bonus_module')) && 
			empty($ci->session->userdata('sip_module')) && 
			empty($ci->session->userdata('lti_module')) && 
			empty($ci->session->userdata('rnr_module'))
		) {
			return false;
		} else {
			return true;
		}

	} else if(!empty($ci->session->userdata($module_name))) {
		return true;
	}

	return false;
}

/* To check request, if user direct access url then redirect to dashboard */
function HLP_is_url_direct_access()
{
	if(in_array($_SERVER['HTTP_HOST'], array("localhost", "uat.compport.com")))
	{
		return;
	}
	
	$ci = & get_instance();
	$allowed_url = array('/','/logout', '/logout/','/dashboard', '/dashboard/', '/employee/dashboard', '/employee/dashboard/');

	if(!$ci->input->is_ajax_request() && 
		empty($_SERVER['HTTP_REFERER']) && 
	   !empty($_SERVER['REDIRECT_QUERY_STRING']) &&
	   !in_array($_SERVER['REDIRECT_QUERY_STRING'], $allowed_url)
	) {
		$ci->session->set_flashdata("msg", "You can't be access this url, Please contact to admin.");
		if(!empty($ci->session->userdata('role_ses')) && $ci->session->userdata('role_ses') == 11)
		{
			redirect(site_url('employee/dashboard'));
		} else {
			redirect(site_url("dashboard"));
		}
	}

}

/*** Start :: To get new dtls after promotion like new crr, new market salary, new market hike **
Note :: $req_by = 1 (Means method called from HR), $req_by = 2 (Means method called from Manager)
*/
function HLP_get_new_mkt_dtls_after_promotion($req_by, $rule_n_emp_sal_dtls)
{	
	$CI = & get_instance();
	$CI->load->model('rule_model');
	/*$promotion_tbl_name = "manage_designation";
	$promotion_col_name = CV_BA_NAME_DESIGNATION;
	$promotion_cnd_str = "status = 1 ";
	
	if($rule_n_emp_sal_dtls["promotion_basis_on"] == "2")
	{
		$promotion_col_name = CV_BA_NAME_GRADE;
		$promotion_tbl_name = "manage_grade";
	}
	elseif($rule_n_emp_sal_dtls["promotion_basis_on"] == "3")
	{
		$promotion_col_name = CV_BA_NAME_LEVEL;
		$promotion_tbl_name = "manage_level";
	}*/
	$promotion_tbl_and_col_dtls = $rule_n_emp_sal_dtls["promotion_tbl_and_col_dtls"];
	$promotion_tbl_name = $promotion_tbl_and_col_dtls["promotion_tbl_name"];
	$promotion_col_name = $promotion_tbl_and_col_dtls["promotion_col_name"];
	$promotion_other_col_val1 = 0;
	$promotion_other_col_val2 = 0;
	$promotion_cnd_str = "status = 1 ";
	
	$promotion_dtls = "";
	if($rule_n_emp_sal_dtls["emp_new_suggested_position"])
	{
		$emp_new_post_id = $rule_n_emp_sal_dtls["emp_new_suggested_position"];
		$promotion_cnd_str .= " AND id = ".$rule_n_emp_sal_dtls["emp_new_suggested_position"];
		$promotion_dtls = $CI->rule_model->get_table_row($promotion_tbl_name, "id, name", $promotion_cnd_str, "order_no ASC");
	}
	else
	{
		$promotion_upgradation_cnd = "status = 1 AND (designation_frm = ".$rule_n_emp_sal_dtls[CV_BA_NAME_DESIGNATION]." OR designation_frm = 0) AND (grade_frm = ".$rule_n_emp_sal_dtls[CV_BA_NAME_GRADE]." OR grade_frm = 0) AND (level_frm = ".$rule_n_emp_sal_dtls[CV_BA_NAME_LEVEL]." OR level_frm = 0)";
		$new_promotion_upgradation_dtls = $CI->rule_model->get_table_row("tbl_promotion_up_gradation", "designation_to, grade_to, level_to", $promotion_upgradation_cnd, "id ASC");
		if($new_promotion_upgradation_dtls[$promotion_col_name."_to"]>0)
		{
			$emp_new_post_id = $new_promotion_upgradation_dtls[$promotion_col_name."_to"];
			$promotion_dtls = array("id"=>$new_promotion_upgradation_dtls[$promotion_col_name."_to"]);
			
			$promotion_other_col_val1 = $new_promotion_upgradation_dtls[$promotion_tbl_and_col_dtls["other_then_promotion_col_name1"]."_to"];
			$promotion_other_col_val2 = $new_promotion_upgradation_dtls[$promotion_tbl_and_col_dtls["other_then_promotion_col_name2"]."_to"];
		}
	}
	
	if(!$promotion_dtls)
	{
		$promotion_tbl_lst_dtls = $CI->rule_model->get_table($promotion_tbl_name, "id, name", "status = 1", "order_no ASC");			
		foreach($promotion_tbl_lst_dtls as $p_key => $p_row)
		{
			if($rule_n_emp_sal_dtls[$promotion_col_name] == $p_row["id"])
			{
				$emp_new_post_id = $p_row["id"];
				$promotion_dtls = $p_row;
				if(isset($promotion_tbl_lst_dtls[$p_key+1]))
				{
					$emp_new_post_id = $promotion_tbl_lst_dtls[$p_key+1]["id"];
					$promotion_dtls = $promotion_tbl_lst_dtls[$p_key+1];
				}
				break;
			}
		}
	}		
	
	$rule_n_emp_sal_dtls[$promotion_col_name] = $promotion_dtls["id"];
	$new_mkt_salary = $rule_n_emp_sal_dtls["market_salary"];
	$mkt_sal_cnd = "is_error = 0 AND (country = ".$rule_n_emp_sal_dtls[CV_BA_NAME_COUNTRY]." OR country = '') AND (city = ".$rule_n_emp_sal_dtls[CV_BA_NAME_CITY]." OR city = '') AND (business_level_1 = ".$rule_n_emp_sal_dtls[CV_BA_NAME_BUSINESS_LEVEL_1]." OR business_level_1 = '') AND (business_level_2 = ".$rule_n_emp_sal_dtls[CV_BA_NAME_BUSINESS_LEVEL_2]." OR business_level_2 = '') AND (business_level_3 = ".$rule_n_emp_sal_dtls[CV_BA_NAME_BUSINESS_LEVEL_3]." OR business_level_3 = '') AND (function = ".$rule_n_emp_sal_dtls[CV_BA_NAME_FUNCTION]." OR function = '') AND (subfunction = ".$rule_n_emp_sal_dtls[CV_BA_NAME_SUBFUNCTION]." OR subfunction = '') AND (sub_subfunction = ".$rule_n_emp_sal_dtls[CV_BA_NAME_SUB_SUBFUNCTION]." OR sub_subfunction = '') AND (grade = ".$rule_n_emp_sal_dtls[CV_BA_NAME_GRADE]." OR grade = '') AND (level = ".$rule_n_emp_sal_dtls[CV_BA_NAME_LEVEL]." OR level = '') AND (designation = ".$rule_n_emp_sal_dtls[CV_BA_NAME_DESIGNATION]." OR designation = '') AND (education = ".$rule_n_emp_sal_dtls[CV_BA_NAME_EDUCATION]." OR education = '') AND (job_code = '".$rule_n_emp_sal_dtls[CV_BA_NAME_JOB_CODE]."' OR job_code = '') AND (job_name = '".$rule_n_emp_sal_dtls[CV_BA_NAME_JOB_NAME]."' OR job_name = '') AND (job_level = '".$rule_n_emp_sal_dtls[CV_BA_NAME_JOB_LEVEL]."' OR job_level = '') AND (urban_rural_classification = '".$rule_n_emp_sal_dtls[CV_BA_NAME_URBAN_RURAL_CLASSIFICATION]."' OR urban_rural_classification = '')";
	$new_mkt_salary_dtls = $CI->rule_model->get_table_row("tbl_market_data", $rule_n_emp_sal_dtls["market_salary_column"], $mkt_sal_cnd, "id DESC");
	if($new_mkt_salary_dtls[$rule_n_emp_sal_dtls["market_salary_column"]]>0)
	{
		$new_mkt_salary = $new_mkt_salary_dtls[$rule_n_emp_sal_dtls["market_salary_column"]];
	}
	
	$emp_sal_aftr_promotion = $rule_n_emp_sal_dtls["increment_applied_on_salary"] + ($rule_n_emp_sal_dtls["increment_applied_on_salary"]*($rule_n_emp_sal_dtls["final_merit_hike"] + $rule_n_emp_sal_dtls["emp_new_suggested_promotion_per"])/100);
	
	$crr_aftr_promotion = 0;
	if($new_mkt_salary > 0)
	{
		$crr_aftr_promotion = ($emp_sal_aftr_promotion/$new_mkt_salary)*100;
	}		
	
	if($rule_n_emp_sal_dtls["hike_multiplier_basis_on"])
	{
		$hike_multiplier_basis_on = CV_BA_NAME_COUNTRY;
		if($rule_n_emp_sal_dtls["hike_multiplier_basis_on"]=="2")
		{
			$hike_multiplier_basis_on = CV_BA_NAME_GRADE;
		}
		elseif($rule_n_emp_sal_dtls["hike_multiplier_basis_on"]=="3")
		{
			$hike_multiplier_basis_on = CV_BA_NAME_LEVEL;
		}
		$multiplier_wise_per_dtls = json_decode($rule_n_emp_sal_dtls["multiplier_wise_per_dtls"], true);
		
		if(isset($multiplier_wise_per_dtls["crr"][$rule_n_emp_sal_dtls[$hike_multiplier_basis_on]]))
		{
			//$rating_dtls = $multiplier_wise_per_dtls["rating"][$rule_n_emp_sal_dtls[$hike_multiplier_basis_on]];
			$comparative_ratio_dtls=$multiplier_wise_per_dtls["mkt_elem"][$rule_n_emp_sal_dtls[$hike_multiplier_basis_on]];
			$crr_tbl_arr_temp = $multiplier_wise_per_dtls["crr"][$rule_n_emp_sal_dtls[$hike_multiplier_basis_on]];
			/*$max_hike_arr = $multiplier_wise_per_dtls["max_per"][$rule_n_emp_sal_dtls[$hike_multiplier_basis_on]];
			$recently_promoted_max_hike_arr = $multiplier_wise_per_dtls["recently_max_per"][$rule_n_emp_sal_dtls[$hike_multiplier_basis_on]];*/
		}
		else
		{
			//$rating_dtls = json_decode($rule_n_emp_sal_dtls["performnace_based_hike_ratings"], true);
			$comparative_ratio_dtls = json_decode($rule_n_emp_sal_dtls["comparative_ratio_calculations"], true);
			$crr_tbl_arr_temp = json_decode($rule_n_emp_sal_dtls["crr_percent_values"], true);
			/*$max_hike_arr = json_decode($rule_n_emp_sal_dtls["Overall_maximum_age_increase"], true);
			$recently_promoted_max_hike_arr = json_decode($rule_n_emp_sal_dtls["if_recently_promoted"], true);*/
		}		
	}
	else
	{
		//$rating_dtls = json_decode($rule_n_emp_sal_dtls["performnace_based_hike_ratings"], true);
		$comparative_ratio_dtls = json_decode($rule_n_emp_sal_dtls["comparative_ratio_calculations"], true);
		$crr_tbl_arr_temp = json_decode($rule_n_emp_sal_dtls["crr_percent_values"], true);
		/*$max_hike_arr = json_decode($rule_n_emp_sal_dtls["Overall_maximum_age_increase"], true);
		$recently_promoted_max_hike_arr = json_decode($rule_n_emp_sal_dtls["if_recently_promoted"], true);*/
	}
	
	$i=0;
	$min_mkt_salary = $min_mkt_salary_to_bring_emp_to_min_salary = 0;
	$quartile_range_name_after_promotion = "";
	/*$increment_applied_on_amt_for_quartile = $rule_n_emp_sal_dtls["increment_applied_on_salary"];
	if($rule_n_emp_sal_dtls["comparative_ratio"] == "yes")
	{
		$increment_applied_on_amt_for_quartile = $rule_n_emp_sal_dtls["increment_applied_on_salary"] + ($rule_n_emp_sal_dtls["increment_applied_on_salary"]*$rule_n_emp_sal_dtls["final_merit_hike"]/100);
	}*/
	$increment_applied_on_amt_for_quartile = $emp_sal_aftr_promotion;
	
	$crr_arr = json_decode($rule_n_emp_sal_dtls["comparative_ratio_range"], true);
	foreach($crr_arr as $key => $row1)
	{
		if($rule_n_emp_sal_dtls['salary_position_based_on'] == "2")//Salary Positioning Based On Quartile
		{	
			$quartile_range_arr = explode(CV_CONCATENATE_SYNTAX, $key);
			if($i==0)
			{ 
				if($increment_applied_on_amt_for_quartile < $rule_n_emp_sal_dtls[$quartile_range_arr[1]])
				{
					$min_mkt_salary_to_bring_emp_to_min_salary = $rule_n_emp_sal_dtls[$quartile_range_arr[1]];
					$quartile_range_name_after_promotion = " < ".$row1["max"];
					break;
				}
			}
			else
			{
				if($min_mkt_salary <= $increment_applied_on_amt_for_quartile and $increment_applied_on_amt_for_quartile < $rule_n_emp_sal_dtls[$quartile_range_arr[1]])
				{
					$quartile_range_name_after_promotion = $row1["min"]." To ".$row1["max"];
					break;
				}
			}
			
			if(($i+1)==count($crr_arr))
			{
				if($increment_applied_on_amt_for_quartile >= $rule_n_emp_sal_dtls[$quartile_range_arr[1]])
				{
					$i++;
					$quartile_range_name_after_promotion = " > ".$row1["max"];
					break;
				}
			}
			$min_mkt_salary = $rule_n_emp_sal_dtls[$quartile_range_arr[1]];
		}
		else
		{		
			if($i==0)
			{ 
				if($crr_aftr_promotion < $row1["max"])
				{
					$quartile_range_name_after_promotion = " < ".$row1["max"];
					break;
				}
			}
			else
			{
				if($row1["min"] <= $crr_aftr_promotion and $crr_aftr_promotion < $row1["max"])
				{
					$quartile_range_name_after_promotion = $row1["min"]." To ".$row1["max"];
					break;
				}
			}
			
			if(($i+1)==count($crr_arr))
			{
				if($crr_aftr_promotion >= $row1["max"])
				{
					$i++;
					$quartile_range_name_after_promotion = " > ".$row1["max"];
					break;
				}
			}
		}
		$i++; 
	}
	
	/*$max_hike_aftr_promotion = 0;
	$recently_promoted_max_hike_aftr_promotion = 0;*/
	
	$crr_tbl_arr = $crr_tbl_arr_temp[$i];
	$rang_index = $i;	
	$crr_based_increment_percet_aftr_promotion = 0;
	$j=0;
	
	if($rule_n_emp_sal_dtls["performnace_based_hike"] == "yes")
	{
		foreach ($comparative_ratio_dtls as $key => $value) 
		{
			$key_arr =  explode(CV_CONCATENATE_SYNTAX, $key);
			if(($rule_n_emp_sal_dtls["performance_rating_id"]) and $key_arr[0] == $rule_n_emp_sal_dtls["performance_rating_id"])
			{
				$crr_based_increment_percet_aftr_promotion =  $crr_tbl_arr[$j];
				/*$max_hike_aftr_promotion = $max_hike_arr[$j];
				$recently_promoted_max_hike_aftr_promotion = $recently_promoted_max_hike_arr[$j];*/
				break;
			}
			$j++;
		}
	}
	else
	{
		$crr_based_increment_percet_aftr_promotion =  $crr_tbl_arr[$j];
		/*$max_hike_aftr_promotion = $max_hike_arr[$j];
		$recently_promoted_max_hike_aftr_promotion = $recently_promoted_max_hike_arr[$j];*/
	}
	
	
	if($rule_n_emp_sal_dtls['bring_emp_to_min_sal'] == 1 and $rule_n_emp_sal_dtls['salary_position_based_on'] == "2" and $i == 0 and $min_mkt_salary_to_bring_emp_to_min_salary > 0)//Salary Positioning Based On Quartile Case
	{
		$crr_based_increment_percet_aftr_promotion = HLP_get_mkt_hike_to_bring_emp_to_min_salary($rule_n_emp_sal_dtls["increment_applied_on_salary"], $min_mkt_salary_to_bring_emp_to_min_salary, $rule_n_emp_sal_dtls["final_merit_hike"], $crr_based_increment_percet_aftr_promotion);
	}
	
	$n_final_total_hike = $rule_n_emp_sal_dtls["final_merit_hike"]+$crr_based_increment_percet_aftr_promotion;
	if($rule_n_emp_sal_dtls["include_promotion_budget"] == 1)
	{
		$n_final_total_hike += $rule_n_emp_sal_dtls["emp_new_suggested_promotion_per"];
	}
	$total_hike = $rule_n_emp_sal_dtls["final_merit_hike"] + $crr_based_increment_percet_aftr_promotion + $rule_n_emp_sal_dtls["emp_new_suggested_promotion_per"];
	$n_final_salary = $rule_n_emp_sal_dtls["increment_applied_on_salary"] + ($rule_n_emp_sal_dtls["increment_applied_on_salary"]*$total_hike)/100;
	
	$final_result = array("n_market_salary_for_crr"=>$new_mkt_salary, "n_crr_val"=>$crr_aftr_promotion, "n_promotion_hike"=>$rule_n_emp_sal_dtls["emp_new_suggested_promotion_per"], "n_promotion_salary"=>($rule_n_emp_sal_dtls["increment_applied_on_salary"]*$rule_n_emp_sal_dtls["emp_new_suggested_promotion_per"])/100, "n_market_hike"=>$crr_based_increment_percet_aftr_promotion, "n_final_total_hike"=>$n_final_total_hike, "n_final_salary"=>$n_final_salary, "promotion_col_name"=>"emp_new_".$promotion_col_name, "emp_new_post_id"=>$emp_new_post_id, "other_then_promotion_col_name1"=>$promotion_other_col_val1, "other_then_promotion_col_name2"=>$promotion_other_col_val2,"quartile_range_name_after_promotion"=>$quartile_range_name_after_promotion, "post_quartile_range_name" => HLP_get_quartile_position_range_name($rule_n_emp_sal_dtls, $n_final_salary, $crr_arr));	
	//echo "<pre>";print_r($final_result);die;
	return $final_result;
}
/*** End :: To get new dtls after promotion like new crr, new market salary, new market hike ***/

/*** Start :: To get Pro-Rated Multiplier for Salary Increments Into Salary Rule ***/
function HLP_get_pro_rated_multiplier_for_salary($rule_dtls, $emp_joining_dt)
{	
	$proreta_multiplier = 1;//Default
	//$joining_dt = date("Y-m-d",strtotime($users_dtls[CV_BA_NAME_INCREMENT_PURPOSE_JOINING_DATE]));
	if($rule_dtls["prorated_increase"] == "yes")
	{
		/*if(strtotime($joining_dt) <= strtotime($rule_dtls["start_dt"]))
		{
			$proreta_multiplier = 1;
		}
		else*/
		if(strtotime($emp_joining_dt) <= strtotime($rule_dtls["pp_end_dt"]))
		{
			$numerator = round((strtotime($rule_dtls["pp_end_dt"]) - strtotime($emp_joining_dt)) / (60 * 60 * 24));
			$denominator = round((strtotime($rule_dtls["pp_end_dt"]) - strtotime($rule_dtls["pp_start_dt"])) / (60 * 60 * 24));
			$proreta_multiplier = HLP_get_formated_percentage_common(($numerator/$denominator));
		}
		else
		{
			$proreta_multiplier = 0;
		}					
	}
	if($rule_dtls["prorated_increase"] == "fixed_period")
	{
		if(strtotime($rule_dtls["start_dt"]) < strtotime($emp_joining_dt) and strtotime($emp_joining_dt) <= strtotime($rule_dtls["end_dt"]))
		{
			$numerator = round((strtotime($rule_dtls["pp_end_dt"]) - strtotime($emp_joining_dt)) / (60 * 60 * 24));
			$denominator = round((strtotime($rule_dtls["pp_end_dt"]) - strtotime($rule_dtls["pp_start_dt"])) / (60 * 60 * 24));
			$proreta_multiplier = HLP_get_formated_percentage_common(($numerator/$denominator));
		}					
	}
	elseif($rule_dtls["prorated_increase"] == "fixed-percentage")
	{
		$range_of_doj_arr = json_decode($rule_dtls["fixed_percentage_range_of_doj"],true);
		foreach($range_of_doj_arr as $key=> $doj_range) 
		{
			if(strtotime(date('Y-m-d', strtotime($doj_range["From"]))) <= strtotime($emp_joining_dt) and strtotime($emp_joining_dt) >= strtotime(date('Y-m-d', strtotime($doj_range["To"]))))
			{
				$proreta_multiplier = $doj_range["Percentage"]/100;
				break;
			}					
		}				
	}
	return $proreta_multiplier;
}
/*** End :: To get Pro-Rated Multiplier for Salary Increments Into Salary Rule ***/

/*** Start :: To get Range Penetration Name for Salary Increments List Page Into Salary Rule ***/
function HLP_get_range_penetration_for_salary($numerator, $denominator)
{	
	$range_penetration_name = "";
	if($denominator)
	{
		$cal_val = HLP_get_formated_percentage_common(($numerator/$denominator)*100);
		if($cal_val<0)
		{
			$range_penetration_name = "< Min";
		}
		elseif($cal_val>=0 and $cal_val<25)
		{
			$range_penetration_name = $cal_val."%(Q1)";
		}
		elseif($cal_val>=25 and $cal_val<50)
		{
			$range_penetration_name = $cal_val."%(Q2)";
		}
		elseif($cal_val>=50 and $cal_val<75)
		{
			$range_penetration_name = $cal_val."%(Q3)";
		}
		elseif($cal_val>=75 and $cal_val<100)
		{
			$range_penetration_name = $cal_val."%(Q4)";
		}
		elseif($cal_val>=100)
		{
			$range_penetration_name = "> Max";
		}										
	}
	return $range_penetration_name;
}
/*** End :: To get Range Penetration Name for Salary Increments List Page Into Salary Rule ***/

/*** Start :: To get Market Hike To Bring Employee To Min Salary Into Salary Rule ***/
function HLP_get_mkt_hike_to_bring_emp_to_min_salary($current_salary, $min_mkt_salary, $merit_hike, $mkt_hike)
{	
	$total_diff = (($min_mkt_salary - $current_salary)/$current_salary)*100;
	$min_val = $total_diff - $merit_hike;
	return min($min_val, $mkt_hike);
}
/*** End :: To get Market Hike To Bring Employee To Min Salary Into Salary Rule ***/

/** Get formatted date , Pass date and format */
function getFormattedDate($date, $format = "d-M-y") {

	$formatted_date = '';

	if(!empty($date) && $date != '0000-00-00'){
		$formatted_date = date($format, strtotime($date));
	}
	return $formatted_date;
}

function dd($data, $stopScript = true) {

	print '<br><pre>';
	print_r($data);
	print '<br>';

	if($stopScript) {
		die;
	}

}

function HLP_getCellFromColnum($colNum) {
	return ($colNum < 26 ? chr(65+$colNum) : chr(65+floor($colNum/26)-1) . chr(65+ ($colNum % 26)));
}

function HLP_generateXls($listInfo,$header, $fileName ='download.xlsx') {
	// load excel library
	$this->load->library('Excel');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	// set Header    
	$colNum = 0;
	foreach ($header as $k => $v) {
		$objPHPExcel->getActiveSheet()->SetCellValue(HLP_getCellFromColnum($colNum) . '1', $v);
		$colNum++;
	}
	// set Row
	$rowCount = count($header)? 2:1;
	foreach ($listInfo as $list) {
		$colNum = 0;
		foreach ($list as $k => $str) {
			$cell = HLP_getCellFromColnum($colNum) . $rowCount;
			$objPHPExcel->getActiveSheet()->SetCellValue($cell, $str);			
			$colNum++;
		}
		$rowCount++;
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $fileName . '"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
}

function HLP_generateCSV($records, $header = [], $fileName = 'download.csv', $savefile = false)
{

	if ($savefile) {
		$filePath = dirname(APPPATH) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileName;
		$file = fopen($filePath, 'wb');
		// output each row of the data
		if ($header) fputcsv($file, $header);
		// output each row of the data
		foreach ($records as $row) {
			fputcsv($file, $row);
		}
		fclose($file);

		if (file_exists($filePath)) {
			return true;
		} else {
			return false;
		}
	} else {
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$fileName");
		header("Content-Type: application/csv;");

		// file creation 
		$file = fopen('php://output', 'w');
		if ($header) fputcsv($file, $header);
		foreach ($records as $key => $value) {
			fputcsv($file, $value);
		}
		fclose($file);
		exit;
	}
}