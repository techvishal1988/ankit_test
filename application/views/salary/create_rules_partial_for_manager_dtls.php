 <style>
#dv_budget_manual table tr td .form-control
{
	margin-bottom:0px !important;
}

#dv_budget_manual table tr td
{
	vertical-align: middle;
}
.pad_r0{padding-right: 0px !important;}

</style>
<form id="frm_rule_step4" class="rule-form" method="post" onsubmit="return set_rules(this);" action="<?php echo site_url("rules/set_rules/".$rule_dtls['id']."/4"); ?>" enctype="multipart/form-data">
  <?php echo HLP_get_crsf_field();?>
  <div class="form-group">
    <div class="row">
      <div class="col-sm-12">
        <div class="form_head pad_rt_0 clearfix">
          <div class="col-sm-12">
            <ul>
              <li>
                <div class="form_tittle">
                  <?php 
                            $tooltip=getToolTip('salary-rule-page-4');$val=json_decode($tooltip[0]->step); 
                            ?>
                  <h4>Define Budget Allocation</h4>
                </div>
              </li>
              <li>
                <div class="form_info">
                  <button type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="Define rules related to budget management in this section and see the outcome table below by approver-1."><i style="font-size: 20px;" class="fa fa-info-circle themeclr" aria-hidden="true"></i></button>
                </div>
              </li>
              <?php /*?><li class="color-detail preinc <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "pull-right"; }?> ">
                <div class="color_info"> <span class="c_grn"></span><span> Pre increase population distribution</span> </div>
                <div class="color_info"> <span class="c_blue"></span><span> Post increase population distribution</span> </div>
              </li>
              <li class="color-detail mar0 pull-right" style=" <?php if($rule_dtls['salary_position_based_on'] == "2"){echo "display:none;"; }?> ">
                <div class="color_info"> <span class="c_yello" id="spn_improvement_pre_avg_crr"></span><span> Average Comparative ratio before increase </span> </div>
                <div class="color_info"> <span class="c_yello" id="spn_improvement_post_avg_crr"></span><span> Average Comparative ratio after increase </span> </div>
                <div class="color_info"> <span class="c_yello" id="spn_improvement_avg_crr"></span><span> Total improvement in the average comparative ratio </span> </div>
              </li><?php */?>
				<input type="hidden" name="hf_improvement_pre_avg_crr" id="hf_improvement_pre_avg_crr" />
				<input type="hidden" name="hf_improvement_post_avg_crr" id="hf_improvement_post_avg_crr" />
				<input type="hidden" name="hf_improvement_avg_crr" id="hf_improvement_avg_crr" />
            </ul>
          </div>
        </div>
        <div class="form_sec clearfix">
          <div class="col-sm-12">
            <?php  echo $partial_body; ?>
            <div class="col-sm-6 removed_padding">
              <label class="control-label">Budget accumulation as per approver’s hierarchy <span class="myTip" style="margin-left: 10px;" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, it would continue to accumulate the budgets from Approver-1 to Approver-2 to Approver-3 and finally to Approver-4. In case of “No”, the budget saved will retain with the respective approvers only." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            </div>
            <div class="col-sm-6 pad_r0">
              <select class="form-control" name="ddl_budget_accumulation" required>
                <option value="1" <?php if($rule_dtls['budget_accumulation'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                <option value="2" <?php if($rule_dtls['budget_accumulation'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
              </select>
            </div>
            <div class="col-sm-6 removed_padding">
              <label class="control-label">Include promotion budget in the overall allocated budget <span class="myTip tooltipcls" style="margin-left: 10px;" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, all budget limits included in the manager’s budget allocation will also include any salary increase given towards promotions recommendations. Otherwise, it will be excluded from the overall budget allocated to managers." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            </div>
            <div class="col-sm-6 pad_r0">
              <select class="form-control" name="ddl_include_promotion_budget" required>
                <option value="1" <?php if($rule_dtls['include_promotion_budget'] == '1'){ echo 'selected="selected"'; } ?> >Yes</option>
                <option value="2" <?php if($rule_dtls['include_promotion_budget'] != '1'){ echo 'selected="selected"'; } ?> >No</option>
              </select>
            </div>
			<div class="col-sm-6 removed_padding">
              <label class="control-label">Define budget management rule <span style="margin-left: 10px;" class="myTip tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="If you select “Yes”, managers will be able cross all limits at individual limit but will be restricted to the allocated overall budget while submission. Otherwise they will be restricted to recommend increase within the defined increase limits for individuals as well." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            </div>
          

            <div class="col-sm-6 pad_r0">
              <select class="form-control" name="ddl_manager_can_exceed_budget" required>
                <option value="1" <?php if($rule_dtls['manager_can_exceed_budget'] == 1){ echo 'selected="selected"'; } ?> >Don't apply individual limits but limits on overall budget</option>
                <option value="2" <?php if($rule_dtls['manager_can_exceed_budget'] == 2){ echo 'selected="selected"'; } ?> >Apply both limits</option>
               <option value="3" <?php if($rule_dtls['manager_can_exceed_budget'] == 3){ echo 'selected="selected"'; } ?> >Apply individual limits but no limits on overall budget</option>  
               <option value="4" <?php if($rule_dtls['manager_can_exceed_budget'] == 4){ echo 'selected="selected"'; } ?> >Don't apply any limits</option>     
              </select>
            </div>
			
			<div class="col-sm-6 removed_padding">
              <label class="control-label">Calculate budget on employees prorated salary <span style="margin-left: 10px;" class="myTip tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="<?php echo $val[2]?:'Click “Yes” In case all in-active employees to be covered in this plan eg. Maternity case, long leave cases, etc. ' ?>" data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            </div>
            <div class="col-sm-6 pad_r0">
              <select class="form-control" id="ddl_show_prorated_current_sal" name="ddl_show_prorated_current_sal" required onchange="rest_managers_budget_area();">
				<option value="1" <?php if($rule_dtls['show_prorated_current_sal'] == 1){ echo 'selected="selected"'; } ?> >Yes</option>
				<option value="2" <?php if($rule_dtls['show_prorated_current_sal'] == 2){ echo 'selected="selected"'; } ?> >No</option>
			  </select>
            </div>
			
            <div class="col-sm-6 removed_padding">
              <label class="control-label">Check and define overall budget allocation <span class="myTip tooltipcls" style="margin-left: 10px;" data-toggle="tooltip control-label" data-placement="top" title="This section allows you to build your budgets according to your methodology. “No Limit” means, even while managers will see individual salary increase recommendation and overall recommended budget, they will be able to cross it by any %age or amount.“Automated locked” means, all budgets will be locked as per the recommended increases and if managers would like to increase somebody’s salary, they will have to decrease another increase for another employees first to create a pool.“Automated but x% can exceed” allows you to allocate positive of negative budget allocation for specific managers as per your choice." data-original-title=""><i class="fa fa-info" aria-hidden="true"></i></span></label>
            </div>
            <div class="col-sm-2">
              <select class="form-control" name="ddl_overall_budget" required id="ddl_overall_budget" onchange="rest_managers_budget_area();">
                <option value="">Select</option>
                <option value="No limit" <?php if($rule_dtls["overall_budget"]=="No limit"){echo 'selected="selected"';} ?>>No limit</option>
                <option value="Automated locked" <?php if($rule_dtls["overall_budget"]=="Automated locked"){echo 'selected="selected"';} ?>>Automated locked</option>
                <option value="Automated but x% can exceed" <?php if($rule_dtls["overall_budget"]=="Automated but x% can exceed"){echo 'selected="selected"';} ?>>Automated but x% can exceed</option>
                <?php /*?><option value="Manual" <?php if($rule_dtls["overall_budget"]=="Manual"){echo 'selected="selected"';} ?>>Manual</option> <?php */?>
              </select>
            </div>
            <div class="col-sm-2 p_l0">
              <select class="form-control" name="ddl_to_currency" id="ddl_to_currency" required onchange="rest_managers_budget_area();">
                <?php foreach($currencys as $currency){?>
                <option value="<?php echo $currency["id"]; ?>" <?php if($rule_dtls["to_currency_id"]){ if($rule_dtls["to_currency_id"] == $currency["id"]){echo 'selected="selected"';}}elseif($default_currency[CV_BA_NAME_CURRENCY] == $currency["id"]){echo 'selected="selected"';} ?>><?php echo $currency["name"]; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-2 p_l0 pad_r0">
              <button type="button" style="margin-top:1px; width: 100%;" class="btn p_btn btn-success" onclick="get_budget_dtls();">Show me the Money</button>
            </div>
			
			
          </div>
         


          <div class="col-sm-2 p_l0 col-sm-offset-10">
            <a id="dv_budget_list_btn" style="display: none; width:105%" href="javascript:void();" class="btn btn-primary pull-right" onclick="shw_hid_budget();">Show Budget List</a>
          </div>
          <div class="col-sm-12">
            <div class="form-group" id="dv_budget_manual" style="display:none; margin-top: 10px;"> </div>
          </div>
		  
		  <div class="col-sm-12">
		  	<div class="col-sm-4 removed_padding cls_x_per">
              <label class="control-label">Select File To Upload x%</label>
            </div>
			<div class="col-sm-8 cls_x_per" style="padding-right: 0px;">
			  <input style="width:54%; display: inline-block;" type="file" name="increments_file" id="increments_file" class="form-control" title="Choose a file csv to upload" accept="application/msexcel*">
			 <a style="display: inline-block; vertical-align: top; margin-left: 5px; float: right;" id="hrf_d_file_format" href=">" class="downloadcsv">
          <input type="button" value="Download File Format" class="btn btn-success">
        </a>
				<!-- <a  id="export" class="btn btn-success">Download File Format</a> -->
			
        <button style="display: inline-block; vertical-align: top; width:23%; float: right;"  type="submit" name="upload_file" id="btnAdd_3rd_new" class="mar_l_5 btn btn-success">Upload File</button>
      </div>
		</div>	
        </div>
      </div>
    </div>
  </div>
  <div id="here_table" class="hide"></div>
  <!-- div added by pramod -->
  <div class="row" id="dv_review_plan_btn" style="display:none;">
    <div class="col-sm-12 text-right">
      <input  type="button" id="btn_next" value="Back" class="mar_l_5 btn btn-success btn-w130"  onclick="show_3rd_step_form();"/>
      <span class="dis_inl" id="dv_submit_3_step" style="display:none;">
	  <?php if($rule_dtls["rule_refresh_status"]==1){ ?>
	  	<button name="btn_refresh_rule" type="submit" id="btnAdd_3rd" class="mar_l_5 btn btn-success btn-w130">Refresh Rule Data</button>
	  <?php }else{ ?>
      	<button  type="submit" id="btnAdd_3rd" class="mar_l_5 btn btn-success btn-w130">Save As Draft</button>
	  <?php } ?>
      </span> </div>
  </div>
</form>
<style type="text/css">
  /********dynamic colour for table from company colour***********/
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/

</style>
<script>

function shw_hid_budget(){

  if ( $("#dv_budget_manual").css('display') == 'none' || $("#dv_budget_manual").html()==""){
     $("#dv_budget_manual").css('display', 'block');
      $("#dv_budget_list_btn").html("Hide Budget List");
  }
  else{
    $("#dv_budget_manual").css('display', 'none');
     $("#dv_budget_list_btn").html("Show Budget List");
  }
}


function get_budget_dtls()
{
	var bdgt_type = $("#ddl_overall_budget").val();
	var to_currency = $("#ddl_to_currency").val();
	var show_prorated_current_sal = $("#ddl_show_prorated_current_sal").val();
	if(bdgt_type)
	{
		show_hide_budget_dv(bdgt_type, to_currency, show_prorated_current_sal, '0');
	}
	else
	{
		custom_alert_popup("Please select 'Check and define overall budget allocation' first.");	
	}
	
}
show_hide_budget_dv('<?php echo $rule_dtls["overall_budget"]; ?>', $("#ddl_to_currency").val(), $("#ddl_show_prorated_current_sal").val(), '1');

function show_3rd_step_form()
{
	<?php $step3_url = site_url("rules/get_salary_rule_step2_frm/".$rule_dtls["id"]);
		if($rule_dtls["hike_multiplier_basis_on"])
		{
			$step3_url = site_url("rules/get_salary_rule_step3_frm/".$rule_dtls["id"]);
		}
	?>
	$("#loading").show();
	$.get("<?php echo $step3_url;?>", function(data)
	{
		if(data)
		{
			$("#loading").css('display','none');
			$("#dv_frm_1_btn").html('');
			$("#dv_partial_page_data").html('');
			$("#dv_partial_page_data_2").html(data);
		}
		else
		{
			$("#loading").css('display','none');
			window.location.href= "<?php echo site_url("salary-rule-list/".$rule_dtls["performance_cycle_id"]);?>";
		}
	}); 
}

function rest_managers_budget_area()
{ 
  $("#dv_budget_list_btn").hide();
	$("#dv_budget_manual").html("");
	$("#dv_review_plan_btn").hide();
	
	$(".cls_x_per").hide();
	if($("#ddl_overall_budget").val()=='Automated but x% can exceed')
	{
		//$(".cls_x_per").show();
	}
}
</script>
<script type='text/javascript'>
        $(document).ready(function () {
            function exportTableToCSV($table, filename) {
var budgt= $('input[name="hf_pre_calculated_budgt[]"]').map(function(){return this.value;}).get().join('&');
// var managername= $('input[name="hf_manager_names[]"]').map(function(){return this.value;}).get().join('&');
// var budgt= $('input[name="hf_pre_calculated_budgt[]"]').map(function(){return this.value;}).get().join('&');
// var budgt= $('input[name="hf_pre_calculated_budgt[]"]').map(function(){return this.value;}).get().join('&');
  //console.log(budgt);            
  var hf_pre_calculated_budgt = document.getElementsByName('hf_pre_calculated_budgt[]');
  var hf_manager_names = document.getElementsByName('hf_manager_names[]');
  var hf_emps_total_salary = document.getElementsByName('hf_emps_total_salary[]');
  var hf_managers = document.getElementsByName('hf_managers[]');
  var hf_manager_total_emps = document.getElementsByName('hf_manager_total_emps[]');
  var hf_budget_to_cr1 = document.getElementsByName('hf_budget_to_cr1[]');
  var increased = document.getElementsByName('increased[]');
  var budget_to_bring = document.getElementsByName('budget_to_bring []');
      var str='<table><tr><th>Name</th><th>Email Id</th><th>Automated but x% can exceed</th><th>Number Of Employee</th><th>Current Salary(EGP)</th><th>Budget as per the plan (EGP)</th><th>Revised Budget (EGP)</th><th>% Increased</th><th>Budget to bring all to their target positioning (only forreference)(EGP)</th></tr>';
      for(var i=0;i<hf_pre_calculated_budgt.length;i++)
      {
        ;
      str+='<tr><td>'+hf_manager_names[i].value+'</td><td>'+hf_managers[i].value+'</td><td>'+hf_budget_to_cr1[i].value+'</td><td>'+hf_manager_total_emps[i].value+'</td><td>'+Math.round(hf_emps_total_salary[i].value)+'</td><td>'+Math.round(hf_pre_calculated_budgt[i].value)+'</td><td>'+Math.round(hf_pre_calculated_budgt[i].value)+'</td><td>'+increased[i].value+'</td><td>'+budget_to_bring[i].value+'</td></tr>';
      }
        str+='</table>';
        //console.log(str);
        //return false;
            //  alert(inps.length);
               
               //$('table').$("tr:eq(1)").remove();
             
              // $table.find("th:nth-child(1)").after('<th>Email</th>');
              // $table.find("td:nth-child(1)").after('<td>df</td>');
             //   $table.find('tr:eq(1)').remove();
             //   var fiveth=$table.find("th:nth-child(5)");
             // var fivetd=$table.find("td:nth-child(5)");
             // $table.find("th:nth-child(2)").insertBefore(fiveth);
             // $table.find("td:nth-child(2)").insertBefore(fivetd);
               // $('table tr').find('td:eq(1),th:eq(1)').remove();
               // $('table tr').find('td:eq(2),th:eq(2)').remove();
             //  $table.find("th:nth-child(1)").remove();
              // $table.find("th:nth-child(1)").remove();
              // $table.find("td:nth-child(1)").remove(); 
//$table.find("td:nth-child(2)").remove();
$('#here_table').append(str);
$table = $('#here_table');
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
            $("#export").click(function (event) {
              
                // var outputFile = 'export'
                // var outputFile = window.prompt("What do you want to name your output file (Note: This won't have any effect on Safari)") || 'export';
               // outputFile = outputFile.replace('.csv','') + '.csv'
               outputFile = 'managers-x-increments.csv'
                 // $("#example").find("tr:gt(0)").remove();
                 //  $('#example').find("th:nth-child(1)").remove();
                 //  $('#example').find("td:nth-child(1)").remove();
                 // //  $('#example').find('td:eq(1),th:eq(1)').remove();
                 // $('table tr').find('td:eq(2),th:eq(2)').remove();
                // CSV
              exportTableToCSV.apply(this, [$('.tablecustm'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
        });

$(document).ready(function(){
  $('.myTip').tooltip()
});
    </script>