
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<?php 
if(!isset($is_open_frm_manager_side))
{
	$is_open_frm_manager_side = 0;
}
if(!isset($is_open_frm_hr_side))
{
	$is_open_frm_hr_side = 0;
}

$is_bulk_upload_btn_enabled = 0;

if($is_open_frm_hr_side){?>
	<div class="page-breadcrumb">
		<div class="row">
			<div class="col-md-8">
				<ol class="breadcrumb wn_btn">
					<li><a href="<?php echo base_url("performance-cycle"); ?>"><?php echo $this->lang->line('plan_name_txt'); ?></a></li>
					<li><a href="<?php echo site_url("salary-rule-list/".$rule_dtls['performance_cycle_id']); ?>">Rule List</a></li>
					<li class="active"><?php echo $title; ?></li>
				</ol>
			</div>
			
			<div class="col-md-4 text-right">
				<div class="btn btn-success" id="showfilter" >Show Filters</div>
				<a class="btn btn-success" href="<?php echo base_url('increments/exportLogReport/'.$rule_dtls["id"]) ?>">Export Log Report</a>
				<a class="btn btn-success" href="<?php echo base_url('increments/get_hr_emps_file_to_upload_increments/'.$rule_dtls["id"]) ?>">Download Data</a>
				<?php
				if($rule_dtls['status'] < CV_STATUS_RULE_RELEASED and $rule_dtls['start_date'] <= date("Y-m-d") and date("Y-m-d") <= $rule_dtls['end_date'])
				{
					$is_bulk_upload_btn_enabled = 1; ?>
					<a id="hrf_upload_<?php echo $rule_dtls['id']; ?>" class="btn" onclick="show_increment_bulk_upload_dv(<?php echo $rule_dtls['id']; ?>)" href="javascript:;"><i class="fa fa-upload" style="color: #fff" aria-hidden="true"></i></a>
				<?php
				} ?>
			</div>
		</div>
	</div>
<?php }else{ ?>
	<div class="page-breadcrumb">
		<ol class="breadcrumb container-fluid">
			<li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>
			<li class="active"><?php echo $title; ?></li>        
		</ol>    
	</div>
<?php } ?>

<div id="main-wrapper" class="container-fluid">
	<div class="col-md-12">
		<div class="mailbox-content manager_landing">
			<div class="col-sm-12">
				<div class="col-sm-4">
					<div id="container1"></div>
				</div>
				<div class="col-sm-4">
					<div id="container2"></div>
				</div>
				<div class="col-sm-4"></div>
			</div>
			<?php echo $this->session->flashdata('message');
			echo $msg;
			if($salary_rule_list)
			{ ?>
				
				<?php  $this->view('salary/increment_filter', array('comment' => $comment)); ?>
				
				
				<div class="panel-group" id="accordion">
				<?php 
				$count=1;
				foreach($salary_rule_list as $k=>$rl)
				{?>
					<div class="panel panel-default">	
						<?php 
						if($is_open_frm_manager_side == 1)
						{?>				
							<div class="panel-heading panelpp">
								<h4  class="panel-title" style="text-transform: capitalize; color:#000 !important;cursor: pointer;width:100%; position:unset; padding: 10px;">
									<!-- <div style="font-size:20px; position:relative; padding-top:14px;; margin-top:2px;" class="right-arrow pull-right">
										<?=($count==1) ? '-':'+'?>
									</div> -->
									<span style='font-size: 18px; font-weight: bold;'><?php echo $rl['name'],' - '.$rl['salary_rule_name'] ?></span>
									

                                    <ul class="links_penel">
	                                 <li>	
										<a  data-toggle="tooltip" data-original-title="Download Data" data-placement="bottom" href="<?php echo base_url('manager/dashboard/download_rule_emp_lists/'.$rl['id']) ?>"><i  class="fa fa-download themeclr" aria-hidden="true"></i></a>
									 </li>	
	                                <li style="display: none;">
										<a style="display:block; float: right; right: <?php if($rl['status'] == 6){echo "130";}else{echo "100";}?>px; position: absolute;margin-top: 8px;" data-toggle="tooltip" data-original-title="Download Data" data-placement="bottom" href="<?php echo base_url('manager/dashboard/download_rule_emp_lists/'.$rl['id']) ?>"><i style='font-size: 22px;padding-top: 10px;' class="fa fa-download themeclr" aria-hidden="true"></i></a>
	                                </li>
										<?php if($rl['status'] == 6){?>
									<li>		
										<a id="hrf_upload_<?php echo $rl['id']; ?>"  data-toggle="tooltip" data-original-title="Bulk Upload" data-placement="bottom" onclick="show_increment_bulk_upload_dv(<?php echo $rl['id']; ?>)" href="javascript:;"><i  class="fa fa-upload themeclr" aria-hidden="true"></i></a>
									</li>		
										<?php } ?>
	                                 <li>
										<a  data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rl['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
								    </li>		
	                                 <li style="position: relative !important;">
										<a data-toggle="tooltip" data-original-title="Rating and average increase distribution" data-placement="top" target="_blank" href="#"><i class="fa fa-th-list themeclr rating_btn" aria-hidden="true"></i></a>
									 </li>

									 <div class="ratingg" style="display: none;">
										<?php 
										
										$rating_distribution_dtls = HLP_get_rating_distribution_dtls($rl['id'], $this->session->userdata('email_ses')); ?>
										<table class="table ">
											<thead>
												<tr>
													<th> </th>
													<?php $rating_wise_total_emps = 0;
													foreach ($rating_distribution_dtls as $rd_head_row)
													{ 
														$rating_wise_total_emps += $rd_head_row['rating_wise_emp_cnt'];;?>
														<th> <?php echo $rd_head_row['performance_rating']; ?></th>
													<?php 
													} ?>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="text-left">Rating Distribution</th>											
													<?php 
													foreach ($rating_distribution_dtls as $rd_item_row)
													{ ?>
														<td class="text-center">
															<?=  HLP_get_formated_percentage_common(($rd_item_row["rating_wise_emp_cnt"]/$rating_wise_total_emps)*100, 0).'% ('.$rd_item_row["rating_wise_emp_cnt"].')' ?>
														</td>
													<?php
													} ?>
												</tr>										
												<tr>
													<th class="text-left">Avg Increase By Rating</th>
												
													<?php 
													foreach ($rating_distribution_dtls as $rd_item_row)
													{ ?>
													<td class="text-center"><?=  HLP_get_formated_percentage_common($rd_item_row["avg_increase"]).'%' ?></td>
													<?php 
													} ?>
												
												</tr>
												
												<tr>
													<th class="text-left">Budget Total / Available (Utilized) </th>											
													<?php 
													foreach ($rating_distribution_dtls as $rd_item_row)
													{ ?>
														<td class="text-center">
															<?php 
																$rating_available_bdgt = $rd_item_row["rating_wise_allocated_bdgt"] - $rd_item_row["rating_wise_used_bdgt"];
																$rating_utilize_per = 0;
																if($rating_utilize_per != 0)
																{
																	$rating_utilize_per = (($rd_item_row["rating_wise_allocated_bdgt"]-$rating_available_bdgt)/$rd_item_row["rating_wise_allocated_bdgt"])*100;
																}
																
															echo HLP_get_formated_amount_common($rd_item_row["rating_wise_allocated_bdgt"]). " / ". HLP_get_formated_amount_common($rating_available_bdgt)." (".HLP_get_formated_percentage_common($rating_utilize_per, 0)."%)"; ?>
														</td>
													<?php
													} ?>
												</tr>
											</tbody>                     
										</table>
									</div>	
                                </ul>


								</h4>
								

							</div>
						<?php 
						}
						$active='';
						if(isset($_SESSION['active']) and $_SESSION['active']=='collapse'.$count)
						{
							$active="collapse in";
							unset($_SESSION['active']);
						}
						else
						{
							if(empty($_SESSION['active']))
							{
								if($count==1)
								{
									$active='collapse in';
								}
							}
						} ?>
						<div id="collapse<?php echo $count ?>" class="panel-collapse collapse <?=$active?>" >
							<?php 							
								echo $this->method_call->get_managers_list_for_salary_rule_ajax($rl['id'], $count.'_'.$rl['id']);
							 ?>
						</div>
					</div>					
					<?php $count++; 
				}				
			}
			elseif($is_open_frm_manager_side == 1)
			{ 
				$adhoc_salary_review_dtls = HLP_get_adhoc_salary_review_for_val();
				if($adhoc_salary_review_dtls["adhoc_salary_review_for"] == CV_ADHOC_FULL_TIME)
				{
					echo '<p><a class="btn btn-success" href="'.base_url("manager/dashboard/emp_list_for_adhoc_salary_rule").'">Recommend special Salary increase</p></a>';
				}
				elseif($adhoc_salary_review_dtls["adhoc_salary_review_for"] == CV_ADHOC_ANNIVERSARY_TIME)
				{
					echo '<p><a class="btn btn-success" href="'.base_url("manager/dashboard/emp_list_for_adhoc_salary_rule").'">Anniversary Based Salary</p></a>';
				}
			} ?>  
			<?php 
			if($is_open_frm_manager_side == 1 and isset($salary_rule_list_released))
			{ ?>
				<h3>Released rule(s) - Final employee list</h3>
				
				<?php $count=1;
				foreach($salary_rule_list_released as $rl)
				{ ?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 data-toggle="collapse" data-parent="#accordion" href="#collapsee<?php echo $count ?>" class="panel-title expand" style="color:#4E5E6A !important;cursor: pointer;width:100%;">
								<div style="font-size:20px; position:absolute; top:0px; right:-12px; padding-top:4px; margin-top:2px;" class="right-arrow pull-right">+</div>
								<a href="#"><span style='font-size: 15px; font-weight: bold;'><?php echo $rl['name'],' - '.$rl['salary_rule_name'] ?></span></a>
							
							</h4>
							<a style="display:none; float: right; right: 90px; position: absolute;margin-top: -3px;" data-toggle="tooltip" data-original-title="Download rule list" data-placement="bottom" target="_blank" href="<?php echo base_url('manager/download-rule-emp-list/'.$rl['id']) ?>"><i class="fa fa-download themeclr" aria-hidden="true"></i></a>
						
							<a style="    float: right; right: 66px; position: absolute;margin-top: -3px;" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rl['id']) ?>"><i style='font-size: 22px;padding-top: 7px; position: absolute; right: -3px;' class="fa fa-print themeclr" aria-hidden="true"></i></a>
						</div>
						<div id="collapsee<?php echo $count ?>" class="panel-collapse collapse" >
						<?php echo $this->method_call->view_increments_list_manager_after_release($rl['id'],'re_'.$count.'_'.$rl['id']); ?>
						
						</div>
					</div>
				
				<?php $count++; 
				} ?>
				
			<?php 
			} ?>  
		</div>
	</div>
</div>

<div class="modal fade" id="increment_bulk_upload_dv" role="dialog">
  <div class="modal-dialog" role="document">
    <!-- Modal content-->
    <div class="modal-content">
		<form id="frm_increment_bulk_upload" class="form-horizontal frm_cstm_popup_cls_bulk" method="post" action=""  onsubmit="return request_custom_confirm('frm_cstm_popup_cls_bulk')" enctype="multipart/form-data" >
			<?php echo HLP_get_crsf_field(); ?>
			<div class="modal-header headp">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">
				<label style="font-size: 16px;">Update Increment</label>
			  </h4>
			  <input type="hidden" id="hf_rule_id" name="hf_rule_id">
			</div>
			<div class="modal-body">
				<div class="row">
			  		<br>
					<div class="form-group my-form">	
						<div class="col-sm-12 form-input removed_padding">
							<input type="file" name="increments_file" id="increments_file" class="form-control" title="Choose a file csv to upload" required accept="application/msexcel*">
						</div>
					</div>   
				</div>
			</div>
			<div class="modal-footer">
			<div class="row">
				<div class="col-sm-12 text-right">
					<input type="submit" name="btn_upload"  value="Upload" class="btn btn-success">
					<a id="hrf_d_file_format" href="" class="downloadcsv"><input type="button" value="Download File Format" class="btn btn-success"></a>
				</div>
			</div>
			</div>	
		</form>
      
    </div>
  </div>
</div>

<!-- Start :: Salary/Promotion Comments section -->
<div class="modal fade" id="salary_promotion_comment_dv" role="dialog">
  <div class="modal-dialog" role="document">
    <!-- Modal content-->
    <div class="modal-content">
		
			<div class="modal-header headp">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<label style="font-size: 16px;">Comments</label>
				</h4>
			</div>
			<div class="modal-body">
				<form id="frm_salary_promotion_comment" class="form-horizontal" method="post" action="<?php echo site_url("increments/ins_upd_salary_promotion_comment/".$is_open_frm_manager_side); ?>" onsubmit="return ins_upd_salary_promotion_comment(this);" >
					<?php echo HLP_get_crsf_field(); ?>
					<input type="hidden" id="hf_usr_tbl_id" name="hf_usr_tbl_id" />
						<div class="row">
							<br>
							<div class="form-group my-form">	
								<div class="col-sm-12 form-input removed_padding">
									<input type="text" name="txt_comment" id="txt_comment" class="form-control" required maxlength="150">
								</div>
							</div>   
						</div>
						<div class="row">
						<div class="col-sm-12 text-right">
							<input type="submit" value="Save" class="btn btn-success"/>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer" id="dv_salary_promotion_comment_tbl">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<table class="table border table-responsive rule-list" style="width: 100%; cellspacing: 0;">
							<thead>
								<tr>
									<th>Name</th>
									<th>Role</th>
									<th>Comment</th>																		
									<th>Date</th>
								</tr>
							</thead>
							<tbody id="tbl_body_salary_promotion_comment"> 
							</tbody>
						</table>
					</div>
				</div>
			</div>      
    </div>
  </div>
</div>
<script>
function show_comments_dv(tbl_id, can_edit)
{
	$('#dv_salary_promotion_comment_tbl').hide();
	$('#frm_salary_promotion_comment').hide();
	
	var comment_dtls = $("#hf_comment_dtls_"+tbl_id).val();
	if(comment_dtls)
	{
		create_comments_tbl(comment_dtls);
	}
	if(can_edit==1)
	{
		$("#hf_usr_tbl_id").val(tbl_id);
		$('#frm_salary_promotion_comment').show();
	}
	$('#salary_promotion_comment_dv').modal("show");
}

function create_comments_tbl(comment_dtls)
{
	
	var data = JSON.parse(comment_dtls);
	$("#tbl_body_salary_promotion_comment").html(""); 
	var str = "";
	for(var i=0; i< data.length; i++)
	{console.log(data[i].c_by_name);
		str += "<tr><td>"+data[i].c_by_name+"</td><td>"+data[i].type+"</td><td>"+data[i].msg+"</td><td>"+data[i].c_on+"</td></tr>";
	}
	console.log(str);
	$("#tbl_body_salary_promotion_comment").html(str); 
	$('#dv_salary_promotion_comment_tbl').show();
}

function ins_upd_salary_promotion_comment(frm)
{
	var form=$("#"+frm.id);	
	if($("#txt_comment").val()=="")
	{
		return false;
	}
	$("#loading").css('display','block');
	var tbl_id = $("#hf_usr_tbl_id").val();
	$.ajax({
		type:"POST",
		url:form.attr("action"),
		data:form.serialize(),
		success: function(response)
		{
			var data = JSON.parse(response);
			if(data.status)
			{
				$("#hf_comment_dtls_"+tbl_id).val(data.new_comment_dtls);
				$("#txt_comment").val("");
				create_comments_tbl(data.new_comment_dtls);
			}		
			set_csrf_field();
			$("#loading").css('display','none');
		}
	});
	return false;
}
</script>
<!-- End :: Salary/Promotion Comments section -->

<script>
$(this).click( function (obj)
{
	if($(obj.target).closest('table').hasClass('myTable'))
	{
		var id=$('#accordion1 .in').attr("id");
		$("#"+id).removeClass('in');
		$changeIcon=$(".expand1").find(">:first-child");		
		$changeIcon.text('+');
	}
});
$(".table-scroll").scrollTop(localStorage.getItem("TopManger"));
$(".table-scroll").scrollLeft(localStorage.getItem("LeftManger"));

// localStorage.removeItem("TopManger");
// localStorage.removeItem("LeftManger");
$(".table-scroll").scroll(function ()
{
	var scrollTop = $(this).scrollTop();
	var scrollLeft = $(this).scrollLeft();
	//var iCurScrollPos2 = $("#examplep").scrollTop();
	localStorage.setItem("TopManger",scrollTop);
	localStorage.setItem("LeftManger",scrollLeft);
	// console.log("TopManger:"+scrollTop);
	// console.log("LeftManger:"+scrollLeft);
});

$(window).scroll(function ()
{
	var scrollMainTop = $(this).scrollTop();
	localStorage.setItem("MainTopManger",scrollMainTop);
	// console.log(scrollMainTop);
});

localStorage.setItem("parenttab",'');
// current tab redirection code by rahul
 //alert(localStorage.getItem("rurl"));
if(localStorage.getItem("rurl")!=null && localStorage.getItem("rurl")!='first')
{
	setTimeout(function()
	{
		//$('#'+localStorage.getItem("parenttab")).addClass('tabselect');
		$('#'+localStorage.getItem("rurl")).addClass('collapse in');	
		var tr=localStorage.getItem("call_parameters").split(',');
		showTable(tr[0].replace(/\'/g, ''), tr[1], localStorage.getItem("rurl"));
		localStorage.setItem("parenttab",'');
		localStorage.setItem("rurl",'first');
		localStorage.setItem("call_parameters",'');
		$(".table-scroll").scrollTop(localStorage.getItem("TopManger"));
		$(".table-scroll").scrollLeft(localStorage.getItem("LeftManger"));
		$(window).scrollTop(localStorage.getItem("MainTopManger"));
	
		//   $('html, body').animate({
		//   scrollTop: $("#"+localStorage.getItem("rurl")).offset().top
		// }, 1000);
	}, 800);
}
else
{
	$(window).scrollTop(localStorage.getItem("MainTopManger"));
}

function url_redirect()
{
	localStorage.setItem("parenttab", $('#accordion .in').attr("id"));
  	//alert($('#accordion1 .in').attr("id"));
	if($('#accordion1 .in').attr("id")!=undefined)
	{
		var test=$("#"+$('#accordion1 .in').attr("id")).parent().children(':first-child').find('h4').attr("onclick").replace("showTable(", "");
		var call_parameters=test.replace(")", "");
		localStorage.setItem("parenttab", $('#accordion .tabselect').attr("id"));
		localStorage.setItem("rurl", $('#accordion1 .in').attr("id"));
		localStorage.setItem("call_parameters", call_parameters);
	}
	else
	{
		// localStorage.setItem("parenttab",'');
		localStorage.setItem("rurl",'first');
		localStorage.setItem("call_parameters",'');
	}
}

$(function()
{
	$(".expand").on( "click", function()
	{
		// $(this).next().slideToggle(200);
		$expand = $(this).find(">:first-child");
		var expand = $expand.text();
		$(".expand").find(">:first-child").text("+");
		if(expand != "-")
		{
			$expand.text("-");		
		}
		else
		{
			$expand.text("+");
		}
	});

	$(".expand1").on( "click", function()
	{
		// $(this).next().slideToggle(200);
		$expand = $(this).find(">:first-child");
		var expand = $expand.text();
		$(".expand1").find(">:first-child").text("+");
		if(expand != "-")
		{
			$expand.text("-");
		}
		else
		{
			$expand.text("+");
		}
	});
});

function showTable(email,id,divId,newId)
{
    if($("#"+divId).html()==="No Data")
    {
		$("#loading").show();
		var aurl = "<?php echo site_url($urls_arr["emp_increments_list_url"]);?>"+"/"+id+"/"+email+"/"+newId;

		$("#"+divId).load(aurl,function ()
		{
			$("#"+divId).removeClass("hide");
			$("#loading").hide();
		
			$('#table_'+newId+' thead tr').clone(true).addClass('secondHeader').appendTo( '#table_'+newId+' thead' );
			$('#table_'+newId+' thead tr:eq(1) th').each( function (i)
			{
				//var title = $(this).text();
				$(this).html( '<input class="filter_placeholder" type="text" placeholder="Filter" />' );
		 
				$( 'input', this ).on( 'keyup change', function () {
					if ( table.column(i).search() !== this.value ) {
						table
							.column(i)
							.search( this.value )
							.draw();
					}
				});
			});
			var table = $('#table_'+newId).DataTable({
				orderCellsTop: true,       
				searching: true,
				 paging: false, 
				 info: false         
			   // fixedHeader: true
			});
		});
    }
}

function getper(obj, cp,tbl_id,increment_applied_on_salary)
{
	var oldsal=increment_applied_on_salary;
	if(cp>0)
	{
		$("#hf_"+obj+"_hike_amt_"+tbl_id).val(cp);
		$("#salary_per_"+obj+tbl_id).val(get_formated_percentage_common(parseInt(cp)/(parseInt(oldsal))*100));
		$("#salary_per_hidden_"+obj+tbl_id).val(get_formated_percentage_common_without_round(parseInt(cp)/(parseInt(oldsal))*100));
	}
	else
	{
		$("#hf_"+obj+"_hike_amt_"+tbl_id).val(0);
		$("#salary_per_"+obj+tbl_id).val("");
	}
}

function getamt(obj, cp,tbl_id,increment_applied_on_salary)
{
	var oldsal=increment_applied_on_salary;
	var cp=$("#salary_per_"+obj+tbl_id).val();
	if(cp>0)
	{
		var increment_amt = (oldsal*cp)/100;
		$("#hf_"+obj+"_hike_amt_"+tbl_id).val(increment_amt);
		$("#salary_increment_"+obj+tbl_id).val(Math.round(increment_amt));
	}
	else
	{
		$("#hf_"+obj+"_hike_amt_"+tbl_id).val(0);
		$("#salary_increment_"+obj+tbl_id).val(0);
	}
}

function getperr(cp,tbl_id,increment_applied_on_salary)
{
	var oldsal=increment_applied_on_salary;
	if(cp>0)
	{
		$("#hf_promotion_increment"+tbl_id).val(cp);
		$("#promotion_per"+tbl_id).val(get_formated_percentage_common(parseInt(cp)/(parseInt(oldsal))*100));
		$("#promotion_per_hidden"+tbl_id).val(get_formated_percentage_common_without_round(parseFloat(cp)/(parseInt(oldsal))*100));
	}
	else
	{
		$("#hf_promotion_increment"+tbl_id).val(0);
		$("#promotion_per"+tbl_id).val("");
	}
}

function getamtt(cp,tbl_id,increment_applied_on_salary)
{
	var oldsal=increment_applied_on_salary;
	var cp=$("#promotion_per"+tbl_id).val();
	if(cp>0)
	{
		var promotion_increment_amt = (oldsal*cp)/100;
		$("#hf_promotion_increment"+tbl_id).val(promotion_increment_amt);
		$("#promotion_increment"+tbl_id).val(Math.round(promotion_increment_amt));
	}
	else
	{
		$("#hf_promotion_increment"+tbl_id).val(0);
		$("#promotion_increment"+tbl_id).val(0);
	}
}

//// salary increase
function salary_edit(obj,tbl_id,increment_applied_on_salary)
{
	$("#salary_increment_"+obj+tbl_id).show();
	$("#salary_per_"+obj+tbl_id).show();
	$(".salary_close_"+obj+tbl_id).show();
	$(".salary_edit_"+obj+tbl_id).toggleClass('fa-edit fa-check');
	$(".salary_edit_"+obj+tbl_id).attr('onclick', 'update_salary_increment_amount("'+obj+'",'+tbl_id+','+increment_applied_on_salary+')');
}

function salary_close(obj,tbl_id,increment_applied_on_salary)
{
	$(".salary_element_"+obj+tbl_id).show();
	$("#salary_increment_"+obj+tbl_id).hide();
	$("#salary_per_"+obj+tbl_id).hide();
	//$("#salary_comment"+tbl_id).hide();
	$(".salary_close_"+obj+tbl_id).hide();
	$(".salary_edit_"+obj+tbl_id).toggleClass('fa-check fa-edit');
	$(".salary_edit_"+obj+tbl_id).attr('onclick', 'salary_edit("'+obj+'",'+tbl_id+','+increment_applied_on_salary+')');
}
//salary increase end

function promotion_edit(tbl_id,standard_promotion_increase,manager_can_exceed_budget)
{
	$(".promotion_element"+tbl_id).hide();
	$(".promotion_edit"+tbl_id).show();	
	<?php //if($is_open_frm_hr_side){ ?>
	$("#ddl_emp_new_designation_"+tbl_id).show();
	<?php //} ?>
	
	$("#promotion_increment"+tbl_id).show();
	$("#promotion_per"+tbl_id).show();
	$("#txt_emp_new_designation"+tbl_id).show();
	$("#promotion_per"+tbl_id).focus();
	$(".promotion_close"+tbl_id).show();
	$(".promotio_del"+tbl_id).show();
	$(".promotion_edit"+tbl_id).toggleClass('fa-edit fa-sign-out');
	$(".promotion_edit"+tbl_id).attr('onclick', 'update_salary_promotions('+tbl_id+','+standard_promotion_increase+','+manager_can_exceed_budget+')');
	getamtt($("#promotion_per"+tbl_id).val(), tbl_id, $("#hf_increment_applied_on_salary"+tbl_id).val())
	
	if($("span").hasClass("promotio_del"+tbl_id)!= true)
	{
		$("#loading").show();
		var emp_id = $("#hf_emp_id_"+tbl_id).val();
		$.ajax(
		{
			url: "<?php echo site_url("increments/get_promotion_suggestion_dtls/");?>"+emp_id, success: function(result)
			{
				$("#loading").hide();
				if(result)
				{
					var response = JSON.parse(result);
					if(response.status)
					{
						if($(".cls_emp_new_designation"+tbl_id).val()=="" && response.emp_s_designation)
						{
							$(".cls_emp_new_designation"+tbl_id).val(response.emp_s_designation)
						}
						if($(".cls_emp_new_grade"+tbl_id).val()=="" && response.emp_s_grade)
						{
							$(".cls_emp_new_grade"+tbl_id).val(response.emp_s_grade)
						}
						if($(".cls_emp_new_level"+tbl_id).val()=="" && response.emp_s_level)
						{
							$(".cls_emp_new_level"+tbl_id).val(response.emp_s_level)
						}
					}			
				}
			}
		});
	}
}

function promotion_close(tbl_id, standard_promotion_increase, manager_can_exceed_budget, reset_chk)
{
	$(".promotion_element"+tbl_id).show();
	$("#promotion_increment"+tbl_id).hide();
	$("#promotion_per"+tbl_id).hide();
	$("#promotion_comment"+tbl_id).hide();
	$("#txt_emp_new_designation"+tbl_id).hide();
	$(".promotion_close"+tbl_id).hide();
	$(".promotio_del"+tbl_id).hide();
	$(".promotion_edit"+tbl_id).toggleClass('fa-sign-out fa-edit');
	$(".promotion_edit"+tbl_id).attr('onclick', 'promotion_edit('+tbl_id+','+standard_promotion_increase+','+manager_can_exceed_budget+')');
	
	$("#ddl_emp_new_designation_"+tbl_id).hide();
	if(reset_chk)
	{
		$(".promotion_edit"+tbl_id).hide();	
		$("#chk_dfault_promotion"+tbl_id).prop("checked", false);
	}
}

function show_performance_rating_spn(obj)
{
	$(obj).closest("td").find("input[type=select]").focus();
	$(obj).closest("td").find(".cls_ddl_performance_rating").show();
	$(obj).closest("td").find(".spn_performance_rating").hide();
}

function upd_emp_performance_rating_for_salary(empid, rule_id, rating_id, table_id)
{
	//url_redirect();
	if(rating_id > 0)
	{
		//con = $(".in").attr('id');
		$("#loading").show();
		var aurl = "<?php echo site_url($urls_arr["modify_rating_url"]);?>/"+rule_id+"/"+empid+"/"+rating_id;
		$.ajax(
		{
			url: aurl, success: function(result)
			{
				$("#loading").hide();
				if(result)
				{
					var response = JSON.parse(result);
					if(response.status)
					{
						<?php /*?>window.location.href= "<?php echo current_url();?>";<?php */?>
						reset_emp_row_and_managers_bdgt_dtls(table_id, response);
					}
					else
					{
						custom_alert_popup(response.message);
					}
				}
			}
		});
	}
	else
	{
		custom_alert_popup("Please select performance rating.");
	}
}


function update_salary_increment_amount(obj, table_id,increment_applied_on_salary)
{
	//url_redirect();
	//var perval = ($("#salary_increment_"+obj+table_id).val()/increment_applied_on_salary)*100;
	//var salary_comment = $("#salary_comment"+table_id).val();
	//con = $(".in").attr('id');
	
	var perval = ($("#hf_"+obj+"_hike_amt_"+table_id).val()/increment_applied_on_salary)*100;
	
	$("#loading").show();
	var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
	$.post("<?php echo site_url($urls_arr["modify_increment_url"]); ?>",{"emp_sal_id":table_id, "new_per" : perval,"hike_type":obj, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},function(data)
	{
		if(data)
		{
			var response = JSON.parse(data);
			$("#txt_name").val(response.emp_name);
			if(response.status)
			{
				<?php /*?>window.location.href= "<?php echo current_url();?>";<?php */?>
				reset_emp_row_and_managers_bdgt_dtls(table_id, response);
			}
			else
			{
				custom_alert_popup(response.msg);
			}
			$("#loading").hide();
		}
		set_csrf_field();
	});
}

function set_default_promotion_to_emp(table_id,standard_promotion_increase,manager_can_exceed_budget)
{
	if($("#chk_dfault_promotion"+table_id).is(":checked"))
	{
		var promotion_increment_amt = ($('#hf_increment_applied_on_salary'+table_id).val()*standard_promotion_increase)/100;
		$("#hf_promotion_increment"+tbl_id).val(promotion_increment_amt);
		$("#promotion_increment"+table_id).val(Math.round(promotion_increment_amt));
	}
	else
	{
		$("#hf_promotion_increment"+tbl_id).val(0);
		$("#promotion_increment"+table_id).val(0);
	}
	update_salary_promotions(table_id,standard_promotion_increase,manager_can_exceed_budget);
}

function update_salary_promotions(table_id,standard_promotion_increase,manager_can_exceed_budget)
{
	//url_redirect();
	con = $(".in").attr('id');
	
	if(($('#promotion_per'+table_id).val()*1) > standard_promotion_increase && manager_can_exceed_budget != <?php echo CV_MANAGER_CAN_EXCEED_BUDGET; ?> && manager_can_exceed_budget != <?php echo CV_MANAGER_CAN_EXCEED_BUDGET_AND_SUBMIT; ?>)
	{
		custom_alert_popup("Promotion hike can not be increase more than "+standard_promotion_increase+"%");
		return;
	}
	<?php
		if($is_open_frm_hr_side==1)
		{
			$other_then_promotion_col_arr = array("new_designation", "new_level");				
			if($rule_dtls['promotion_basis_on']==1)
			{
				$promotion_col_name = CV_BA_NAME_DESIGNATION;
				$other_then_promotion_col_arr = array("new_grade", "new_level");	
			}
			elseif($rule_dtls['promotion_basis_on']==3)
			{
				$promotion_col_name = CV_BA_NAME_LEVEL;
				$other_then_promotion_col_arr = array("new_designation", "new_grade");
			}?>
			
			update_emp_promotion_basis_on('emp_<?php echo $other_then_promotion_col_arr[0]; ?>', table_id);
			update_emp_promotion_basis_on('emp_<?php echo $other_then_promotion_col_arr[1]; ?>', table_id);
		<?php 	
		} ?> 
				
	var promotion_comment = $("#promotion_comment"+table_id).val();
	var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
	var emp_promotion_per = ($('#hf_promotion_increment'+table_id).val())/(($('#hf_increment_applied_on_salary'+table_id).val()))*100;
	$("#loading").show();
	$.ajax({
		type:"POST",
		url:'<?php echo site_url($urls_arr["modify_promotion_url"]) ?>/'+table_id,
		data:{txt_emp_sp_salary_per:emp_promotion_per, txt_emp_new_designation:$('#ddl_emp_new_designation_'+table_id).val(),"promotion_comment":promotion_comment,"con":con, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},
		success: function(data)
		{
			var response = JSON.parse(data);
			if(response.status)
			{
				<?php /*?>$("#loading").css('display','none');
				window.location.href= "<?php echo current_url();?>";<?php */?>				
				reset_emp_row_and_managers_bdgt_dtls(table_id, response);
			}
			else
			{          
				$("#loading").css('display','none');
				custom_alert_popup(response.msg);
				$(".promoprice").focus();
			}
			set_csrf_field();
		}      
	});
}

function deletepromotion(tbl_id)
{
	//url_redirect();
	con = $(".in").attr('id');
	$("#loading").show();
	$.ajax({
		type:"GET",
		url:'<?php echo site_url($urls_arr["delete_promotion_url"]) ?>/'+tbl_id+'/'+con,
		success: function(data)
		{
			var response = JSON.parse(data);
			if(response.status)
			{
				<?php /*?>$("#loading").hide();
				window.location.href= "<?php echo current_url();?>";<?php */?>
				reset_emp_row_and_managers_bdgt_dtls(tbl_id, response);
			}
			else
			{
				$("#loading").hide();
				custom_alert_popup(response.msg);
			}
		}
	});
}

function reset_emp_row_and_managers_bdgt_dtls(table_id, response)
{
	$('#tbl_tr_'+table_id).html(response.emp_row_dtls);
	$.each(response.managers_bdgt_dtls_arr,function(key,val)
	{
		//var utilize_per = (((val.m_total_bdgt.replace(/,/g, '')*1)-(val.m_availble_total_bdgt.replace(/,/g, '')*1))/(val.m_total_bdgt.replace(/,/g, '')*1))*100;
		$('#dv_m_total_bdgt_'+key).html(val.m_total_bdgt+" ("+val.utilize_per+")%");
		$('#dv_m_availble_total_bdgt_'+key).html(val.m_availble_total_bdgt);
		$('#dv_m_direct_reports_bdgt_'+key).html(val.m_direct_reports_bdgt);
		$('#dv_m_direct_emps_availble_bdgt_'+key).html(val.m_direct_emps_availble_bdgt);
		
		$('#dv_m_direct_emps_merit_allocated_bdgt_'+key).html(val.m_direct_emps_merit_allocated_budget);
		$('#dv_m_direct_emps_market_allocated_bdgt_'+key).html(val.m_direct_emps_market_allocated_budget);
		$('#dv_m_direct_emps_promotion_allocated_bdgt_'+key).html(val.m_direct_emps_promotion_allocated_budget);
		$('#dv_m_direct_emps_merit_available_bdgt_'+key).html(val.m_direct_emps_merit_available_budget);
		$('#dv_m_direct_emps_market_available_bdgt_'+key).html(val.m_direct_emps_market_available_budget);
		$('#dv_m_direct_emps_promotion_available_bdgt_'+key).html(val.m_direct_emps_promotion_available_budget);
		
		$('#dv_m_all_emps_merit_allocated_bdgt_'+key).html(val.m_all_emps_merit_allocated_budget);
		$('#dv_m_all_emps_market_allocated_bdgt_'+key).html(val.m_all_emps_market_allocated_budget);
		$('#dv_m_all_emps_promotion_allocated_bdgt_'+key).html(val.m_all_emps_promotion_allocated_budget);
		$('#dv_m_all_emps_merit_available_bdgt_'+key).html(val.m_all_emps_merit_available_budget);
		$('#dv_m_all_emps_market_available_bdgt_'+key).html(val.m_all_emps_market_available_budget);
		$('#dv_m_all_emps_promotion_available_bdgt_'+key).html(val.m_all_emps_promotion_available_budget);
		
		$('#dv_m_direct_emps_merit_allocated_bdgt_per_'+key).html(val.m_direct_emps_merit_allocated_budget_per);
		$('#dv_m_direct_emps_market_allocated_bdgt_per_'+key).html(val.m_direct_emps_market_allocated_budget_per);
		$('#dv_m_direct_emps_promotion_allocated_bdgt_per_'+key).html(val.m_direct_emps_promotion_allocated_budget_per);
		$('#dv_m_direct_emps_merit_available_bdgt_per_'+key).html(val.m_direct_emps_merit_available_budget_per);
		$('#dv_m_direct_emps_market_available_bdgt_per_'+key).html(val.m_direct_emps_market_available_budget_per);
		$('#dv_m_direct_emps_promotion_available_bdgt_per_'+key).html(val.m_direct_emps_promotion_available_budget_per);
		
		$('#dv_m_all_emps_merit_allocated_bdgt_per_'+key).html(val.m_all_emps_merit_allocated_budget_per);
		$('#dv_m_all_emps_market_allocated_bdgt_per_'+key).html(val.m_all_emps_market_allocated_budget_per);
		$('#dv_m_all_emps_promotion_allocated_bdgt_per_'+key).html(val.m_all_emps_promotion_allocated_budget_per);
		$('#dv_m_all_emps_merit_available_bdgt_per_'+key).html(val.m_all_emps_merit_available_budget_per);
		$('#dv_m_all_emps_market_available_bdgt_per_'+key).html(val.m_all_emps_market_available_budget_per);
		$('#dv_m_all_emps_promotion_available_bdgt_per_'+key).html(val.m_all_emps_promotion_available_budget_per);
	});
	$("#loading").css('display','none');
}

function additional_fields_edit(tbl_id)
{
	$(".additional_fields_element"+tbl_id).hide();
	$(".additional_fields"+tbl_id).show();
	$(".additional_fields_close"+tbl_id).show();
	$(".additional_fields_edit"+tbl_id).toggleClass('fa-edit fa-check');
	$(".additional_fields_edit"+tbl_id).attr('onclick', 'update_emp_additional_field_dtls("esop",'+tbl_id+')');
}

function additional_fields_close(tbl_id)
{
	$(".additional_fields_element"+tbl_id).show();
	$(".additional_fields"+tbl_id).hide();
	$(".additional_fields_close"+tbl_id).hide();
	$(".additional_fields_edit"+tbl_id).toggleClass('fa-check fa-edit');
	$(".additional_fields_edit"+tbl_id).attr('onclick', 'additional_fields_edit('+tbl_id+')');
}

function update_emp_additional_field_dtls(field_name,tbl_id)
{
	url_redirect();
	var emp_sal_id = $.trim(tbl_id);
	var esop_val = "";
	var retention_bonus_val = "";
	var pay_per_val = "";
	
	if($("#txt_esop"+tbl_id).length)
	{
		esop_val = $("#txt_esop"+tbl_id).val();
	}
	if($("#txt_retention_bonus"+tbl_id).length)
	{
		retention_bonus_val = $("#txt_retention_bonus"+tbl_id).val();
	}	
	if($("#txt_pay_per"+tbl_id).length)
	{
		pay_per_val = $("#txt_pay_per"+tbl_id).val();
	}

	if(emp_sal_id>0)
	{
		$("#loading").css('display','block');
		var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
		$.post("<?php echo site_url("increments/update_emp_additional_field_dtls"); ?>",{"emp_sal_id":emp_sal_id, "esop_val" : esop_val, "retention_bonus_val" : retention_bonus_val, "pay_per_val" : pay_per_val, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},function(data)
		{
			if(data)
			{
				var response = JSON.parse(data);
				if(response.status)
				{
					additional_fields_close(tbl_id);
					if($("#txt_esop"+tbl_id).length)
					{
						$(".additional_fields_esop"+tbl_id).html(esop_val);
					}
					if($("#txt_retention_bonus"+tbl_id).length)
					{
						$(".additional_fields_retention_bonus"+tbl_id).html(retention_bonus_val);
					}	
					if($("#txt_pay_per"+tbl_id).length)
					{
						$(".additional_fields_pay_per"+tbl_id).html(pay_per_val);
					}
					
					<!-- Note :: Start :: RSU Section For Fresh Work Only -->
					<?php 
					$rsu_enabled_for_domains_arr = explode(",", CV_RSU_ENABLED_FOR_DOMAINS_ARRAY);
					if(in_array($this->session->userdata('domainname_ses'), $rsu_enabled_for_domains_arr))
					{ ?>
						if(esop_val == "")
						{
							esop_val = 0;
						}					
						var final_rsu_amt = $("#hf_emp_new_total_fixed_salary_"+tbl_id).val()*esop_val;
						$("#td_emp_new_total_fixed_salary_"+tbl_id).html(get_formated_amount_common(final_rsu_amt));
						
						var rsu_division_val = $("#hf_emp_rsu_division_val_"+tbl_id).val();
						var emp_final_rsu = 0;
						if(rsu_division_val>0)
						{										
							emp_final_rsu = final_rsu_amt/rsu_division_val;
						}
						$("#spn_emp_new_total_fixed_salary_"+tbl_id).html(get_formated_amount_common(emp_final_rsu));
					<?php } ?>						
					<!-- Note :: End :: RSU Section For Fresh Work Only -->
											
					$("#loading").css('display','none');
				}
				else
				{
					$("#loading").css('display','none');
					custom_alert_popup(response.msg);
				}
			}
			set_csrf_field();
			$("#loading").css('display','none');
		});
	}
}

function update_emp_promotion_basis_on(based_on, emp_sal_id)
{
	if(emp_sal_id>0)
    {
		var new_position_id = $("#ddl_"+based_on+emp_sal_id).val();
		var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
		$.post("<?php echo site_url("increments/update_emp_promotion_basis_on"); ?>",{"emp_sal_id":emp_sal_id, "new_position_id" : new_position_id, "new_position_for" : based_on, '<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},function(data)
		{
			 set_csrf_field();
        });
    }
}

function show_increment_bulk_upload_dv(r_id)
{
	$("#hf_rule_id").val(r_id);
	$("#hrf_d_file_format").attr("href", "<?php echo site_url($urls_arr["increment_file_format_d_url"]); ?>/"+r_id);
	$('#frm_increment_bulk_upload').attr('action', '<?php echo site_url($urls_arr["increment_file_upload_url"]); ?>/'+r_id);
	$('#increment_bulk_upload_dv').modal("show");
}




<?php if($this->session->flashdata('open_manager_panel')){?>
	$(document).ready(function()
	{
		$("#hrf_<?php echo $this->session->flashdata('open_manager_panel'); ?>").trigger('click')
	})
<?php } ?>


/*$(".rating_btn").click(function(){
  $(".ratingg").toggle();
});
*/


$(document).ready(function(){
    
    $('.rating_btn').click( function(e) {
        
        e.preventDefault(); // stops link from making page jump to the top
        e.stopPropagation(); // when you click the button, it stops the page from seeing it as clicking the body too
        $('.ratingg').toggle();
        
    });
    
    $('.ratingg').click( function(e) {
        
        e.stopPropagation(); // when you click within the content area, it stops the page from seeing it as clicking the body too
        
    });
    
    $('body').click( function() {
       
        $('.ratingg').hide();
        
    });
   
});

</script>

<style type="text/css">
.salary_comment, .promotion_comment{display: block;
width: 100%;
padding: 10px;
background-color: #f5f5f7;}  
.modal-header.headp{margin-bottom: 0px;}
.collapse.in{height: auto !important;display:block;}

#ratting_graph0,#increase_graph0,#ratting_graph1,#increase_graph1,#ratting_graph2,#increase_graph2 {
  min-width: 120px;
  max-width: 500px;
  margin: 0 auto;
  height : 50px;
}
.highcharts-credits{
  display: none;
}
.right-arrow{cursor: pointer;}
    
	.redColor{color:red;}
	.tabselect{ display: block;height: auto !important; }
   .form-horizontal select.form-control{height: 23px !important;
    padding: 2px 4px !important;
    font-size: 13px !important;
}
</style>

