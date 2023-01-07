<?php 
if(!isset($is_open_frm_manager_side))
{
	$is_open_frm_manager_side = 0;
}
if(!isset($is_open_frm_hr_side))
{
	$is_open_frm_hr_side = 0;
} 

if(!isset($show_all_managers_data))
{
	$show_all_managers_data = 0;
} 
?>

<div class="panel-body" style="border: solid #ddd 1px; padding-bottom: 0px;">
	<div class="form-horizontal">
		<div id="dv_partial_page_data">  	
			<div class="col-sm-12 padlr5">			  
				<div class="panel-group" id="accordion1">
					<?php
						  $k=1;
						  $is_need_show_more_manager_link=0;//1=Yes, 0=No
						  foreach($managers_downline_arr as $row)
						  { 
							//if($manager_emailid == $row['m_email']){continue;}
							if(!in_array($row['m_email'], $all_managers_in_a_rule_arr)){continue;}
							if($is_open_frm_manager_side==1 and $k>1 and $show_all_managers_data != 1)
							{$is_need_show_more_manager_link=1;break;}
							$id_str = $k."_".$rule_dtls['id'];
							 ?>
							 


							<div class="panel panel-default">
								<div class="panel-heading panelpp">
									<h4 <?php if($k>1){?>data-toggle="collapse" data-parent="#accordion1"<?php } ?> href="#table_id_<?=$id_str?>" id="hrf_id_<?=$id_str?>" class="panel-title black white <?php if($k>1){echo "expand1 collapsed"; } ?>" style="color:#4E5E6A !important;cursor: pointer;width:100%;" aria-expanded="<?php if($k==1){echo "true"; }else{echo "false";}?>" onclick="showTable('<?=base64_encode($row['m_email'])?>',<?=$rule_dtls['id']?>,'table_id_<?=$id_str?>','<?=$id_str;?>')">
										<?php if($k>1){?><div style="font-size:22px; position:relative; padding-top:4px; margin-top:2px;" class="right-arrow pull-right">+</div><?php } ?>
										<a class="hr_end">
											<?php 
												/*if($is_open_frm_manager_side)
												{*/
													/*echo "Direct Reports Of ";*/
													echo "Team of ";
												/*}*/
												if($row['m_name'])
												{
													echo $row['m_name'];
												}
												else
												{
													echo $row['m_email'];
												}
												if($row['m_function_name'])
												{
													echo " : ".$row['m_function_name'];
												}
												?>
										</a>
										<b style="font-size: 11px; ">
										<?php 
										$manager_total_bdgt_dtls = array();
										$managers_arr = json_decode($rule_dtls['manual_budget_dtls'],true);
										foreach($managers_arr as $key => $value)
										{
											if(strtolower($row["m_email"]) == strtolower($value[0]))
											{												
												$manager_total_bdgt_dtls = HLP_get_downline_managers_budget($rule_dtls, strtolower($value[0]));
												$total_available_bdgt = $manager_total_bdgt_dtls["manager_total_bdgt"] - $manager_total_bdgt_dtls["manager_total_used_bdgt"];
												$utilize_per = (($manager_total_bdgt_dtls["manager_total_bdgt"]-$total_available_bdgt)/$manager_total_bdgt_dtls["manager_total_bdgt"])*100;
												
												echo "<span class='budget_list totl_budget'> Total / Available (Utilized) : " .$rule_dtls['rule_currency_name']." <rv id='dv_m_total_bdgt_".$k."'>". HLP_get_formated_amount_common($manager_total_bdgt_dtls["manager_total_bdgt"])."  </rv> / <rv id='dv_m_availble_total_bdgt_".$k."'>".HLP_get_formated_amount_common($total_available_bdgt)." (".HLP_get_formated_percentage_common($utilize_per)."%)</rv></span>";
												
												echo  "<span class='budget_list'> Direct Reports Total / Available : ".$rule_dtls['rule_currency_name']." <rv id='dv_m_direct_reports_bdgt_".$k."'>".HLP_get_formated_amount_common($value[1] + (($value[1]*$value[2])/100))."</rv> / <rv id='dv_m_direct_emps_availble_bdgt_".$k."'>".HLP_get_formated_amount_common(($value[1] + (($value[1]*$value[2])/100)) - $manager_total_bdgt_dtls["manager_direct_emps_used_bdgt"])."</rv></span>";
												break;
											}
										} ?>
										</b>
									</h4>
								</div>
								
								<?php if($manager_total_bdgt_dtls){?>
								<div style="position: relative;" class="<?php if($k >=2){ echo "popup_topalign_ince"; } ?>" > 
													<a data-toggle="tooltip" data-original-title="View Budget Details" data-placement="<?php if($k ==1){ echo "top"; }else{echo"bottom";} ?>" href="javascript:void();" lang="<?php echo $k; ?>" class="shw_btn_pop_budget" ><i class="fa fa-dollar themeclr" aria-hidden="true"></i></a>						
													 <div id="hike_wise_bdgt_<?php echo $k; ?>" class="allocated_budget_detail" style="display: none;">
													 	<div class="budget_allocated_table">
													 	  <div class="table-responsive">	
													 		<table class="table table-bordered">
													 			<thead>
													 				<tr>
													 				 <th colspan="2"></th>
													 				 <th colspan="2" class="grey_bg">Merit Increase</th>
													 				 <th colspan="2" class="redish_bg" <?php if($rule_dtls['promotion_basis_on']==0){echo 'style="display:none;"';} ?>>Promotion Increase</th>
													 				 <th colspan="2" class="blue_bg">Salary Correction</th>
													 				</tr>
                                                                    <tr>
                                                                    	<th colspan="2"></th>
                                                                    	<th class="grey_bg">Amount</th>
                                                                    	<th class="grey_bg">%age of salary </th>
                                                                    	<th class="redish_bg" <?php if($rule_dtls['promotion_basis_on']==0){echo 'style="display:none;"';} ?>>Amount</th>
                                                                    	<th class="redish_bg" <?php if($rule_dtls['promotion_basis_on']==0){echo 'style="display:none;"';} ?>>%age of salary</th>
                                                                    	<th class="blue_bg">Amount</th>
                                                                    	<th class="blue_bg">%age of salary </th>
                                                                    </tr>
													 			</thead>
													 			<tbody>
                                                                  <tr>
                                                                  	<td colspan="2" class="pad00">
                                                                  		<div class="team_alll">
                                                                  			<table>
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td style="width:53%;" class="text-right">Direct Team : </td>
                                                                  						<td>Allocated Budget</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="pdtp-0"></td>
                                                                  						<td class="pdtp-0">Available Budget</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  		</div>
                                                                  	</td>
                                                                  	<td colspan="2" class="pad00">
                                                                  		<table class="width-100">
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right"><sspan id="dv_m_direct_emps_merit_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_merit_allocated_budget"]); ?></sspan></td>
                                                                  						<td><sspan id="dv_m_direct_emps_merit_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_merit_allocated_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right pdtp-0"><sspan id="dv_m_direct_emps_merit_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_merit_available_budget"]); ?></sspan></td>
                                                                  						<td class="pdtp-0"><sspan id="dv_m_direct_emps_merit_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_merit_available_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  	</td>
                                                                    <td colspan="2" class="pad00" <?php if($rule_dtls['promotion_basis_on']==0){echo 'style="display:none;"';} ?>>
                                                                  		<table class="width-100">
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right"><sspan id="dv_m_direct_emps_promotion_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_promotion_allocated_budget"]); ?></sspan></td>
                                                                  						<td><sspan id="dv_m_direct_emps_promotion_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_promotion_allocated_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right pdtp-0"><sspan id="dv_m_direct_emps_promotion_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_promotion_available_budget"]); ?></sspan></td>
                                                                  						<td class="pdtp-0"><sspan id="dv_m_direct_emps_promotion_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_promotion_available_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  	</td>
                                                                  	<td colspan="2" class="pad00">
                                                                  		<table class="width-100">
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right"><sspan id="dv_m_direct_emps_market_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_market_allocated_budget"]); ?></sspan></td>
                                                                  						<td><sspan id="dv_m_direct_emps_market_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_market_allocated_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right pdtp-0"><sspan id="dv_m_direct_emps_market_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_direct_emps_market_available_budget"]); ?></sspan></td>
                                                                  						<td class="pdtp-0"><sspan id="dv_m_direct_emps_market_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_direct_emps_market_available_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  	</td>
                                                                  </tr>

                                                                   <tr>
                                                                  	<td colspan="2" class="pad00">
                                                                  		<div class="team_alll">
                                                                  			<table>
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td style="width:53%;" class="text-right">All Team collective : </td>
                                                                  						<td>Allocated Budget</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="pdtp-0"></td>
                                                                  						<td class="pdtp-0">Available Budget</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  		</div>
                                                                  	</td>
                                                                  	<td colspan="2" class="pad00">
                                                                  		<table class="width-100">
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right"><sspan id="dv_m_all_emps_merit_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_merit_allocated_budget"]); ?></sspan></td>
                                                                  						<td><sspan id="dv_m_all_emps_merit_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_merit_allocated_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right pdtp-0"><sspan id="dv_m_all_emps_merit_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_merit_available_budget"]); ?></sspan></td>
                                                                  						<td class="pdtp-0"><sspan id="dv_m_all_emps_merit_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_merit_available_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  	</td>
                                                                    <td colspan="2" class="pad00" <?php if($rule_dtls['promotion_basis_on']==0){echo 'style="display:none;"';} ?>>
                                                                  		<table class="width-100">
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right"><sspan id="dv_m_all_emps_promotion_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_promotion_allocated_budget"]); ?></sspan></td>
                                                                  						<td><sspan id="dv_m_all_emps_promotion_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_promotion_allocated_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right pdtp-0"><sspan id="dv_m_all_emps_promotion_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_promotion_available_budget"]); ?></sspan></td>
                                                                  						<td class="pdtp-0"><sspan id="dv_m_all_emps_promotion_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_promotion_available_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  	</td>
                                                                  	<td colspan="2" class="pad00">
                                                                  		<table class="width-100">
                                                                  				<tbody>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right"><sspan id="dv_m_all_emps_market_allocated_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_market_allocated_budget"]); ?></sspan></td>
                                                                  						<td><sspan id="dv_m_all_emps_market_allocated_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_market_allocated_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  					<tr>
                                                                  						<td class="width-50 text-right pdtp-0"><sspan id="dv_m_all_emps_market_available_bdgt_<?php echo $k; ?>"><?php echo HLP_get_formated_amount_common($manager_total_bdgt_dtls["m_all_emps_market_available_budget"]); ?></sspan></td>
                                                                  						<td class="pdtp-0"><sspan id="dv_m_all_emps_market_available_bdgt_per_<?php echo $k; ?>"><?php echo HLP_get_formated_percentage_common($manager_total_bdgt_dtls["m_all_emps_market_available_budget_per"]); ?></sspan>%</td>
                                                                  					</tr>
                                                                  				</tbody>
                                                                  			</table>
                                                                  	</td>
                                                                  </tr>
                                                                 </tbody>
													 			</table>
                                                               </div>
													 	</div>


													</div>
												   </div>
								<?php } ?>
								<div id="table_id_<?=$id_str?>" class="panel-collapse <?php if($k>1){echo "collapse"; } ?>  " aria-expanded="<?php if($k==1){echo "true"; }else{echo "false";}?>">No Data</div>
							</div>
					<?php 	$k++;
						  } ?>
				</div>
			  	<?php if($is_need_show_more_manager_link==1){?>
					<p><a href="<?php echo site_url("manager/managers-list-to-recommend-salary/".$rule_dtls['id']."/1");?>"><input type="button" class="btn btn-primary" value="View More Manager's Data" /></a></p>
				<?php } ?>
				<div class="row">
					<div class="col-sm-12 pull-right">
						<?php if($is_enable_approve_btn==1 and $is_open_frm_manager_side==1){?>
							<a class="anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_dtls['id']; ?>" href="<?php echo site_url("manager/send-for-next-level/".$rule_dtls['id']); ?>"  onclick="return  request_custom_anchor_confirm('anchor_cstm_popup_cls_submit_nxtlevl_<?php echo $rule_dtls['id']; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')">
								<input type="button" class="btn btn-twitter m-b-sm add-btn" value="Submit For Next Level" id="btnSave" />
							</a>
							<script>		
								$("#hrf_upload_<?php echo $rule_dtls['id']; ?>").show();
							</script>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
  .table{
    background-color:#fff;
  }
</style>
<?php /*?><script>
  function show_remark_dv(obj)
  {
    $("#dv_remark_"+obj).show();
    $("#btn_reject_"+obj).hide();
  }

  function hide_remark_dv(obj)
  {
    $("#dv_remark_"+obj).hide();
    $("#btn_reject_"+obj).show();
  }

</script><?php */?>


<script type="text/javascript">
$(document).ready(function() {

  <?php /*?><?php if(!$is_enable_approve_btn){ ?>
       $("#hrf_upload_37").hide();
  <?php } ?><?php */?>

 $('#mytable_<?=$newId?> thead tr').clone(true).addClass('secondHeader').appendTo( '#mytable_<?=$newId?>   thead');
    $('#mytable_<?=$newId?> thead tr:eq(1) th').each( function (i) {
        //var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Filter" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#mytable_<?=$newId?>').DataTable( {
        orderCellsTop: true,       
        searching: true,
        paging: false, 
        info: false         
       // fixedHeader: true
    } );
});



<?php if($rule_dtls['id']){ ?>	
	setTimeout(function(){ $("#hrf_id_1_<?php echo $rule_dtls['id']; ?>").trigger("click"); }, 700);
<?php } ?>

</script>
<script type="text/javascript">

$(document).ready(function()
{    
    $('.shw_btn_pop_budget').click( function(e)
	{
        //console.log(e.currentTarget.lang);
		var k = e.currentTarget.lang;
        e.preventDefault(); // stops link from making page jump to the top
        e.stopPropagation(); // when you click the button, it stops the page from seeing it as clicking the body too
        //$('.allocated_budget_detail').toggle();
		$('.allocated_budget_detail').hide();
		$('#hike_wise_bdgt_'+k).toggle();
    });
    
    $('.allocated_budget_detail').click( function(e)
	{        
        e.stopPropagation(); // when you click within the content area, it stops the page from seeing it as clicking the body too        
    });
    
    $('body').click( function()
	{       
        $('.allocated_budget_detail').hide();        
    });    
});
<?php /*?><script>
   $('.panel-body').tooltip({
    selector: '[data-toggle=tooltip]',
    container: 'body'
  });<?php */?>
</script>

<style>

   
table tr th{z-index: 5;} 
.dataTables_filter{display: none;}
</style>
