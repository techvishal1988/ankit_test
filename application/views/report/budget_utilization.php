<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active"><?php echo @$breadcrumb ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <div class="row">
        <div class="col-md-3">
           <div class="mailbox-content">
                <div class="form-group">
                   <?php
                   
                    $tooltip=getToolTip('budget-utilisation');
                    $val=json_decode($tooltip[0]->step);
                   ?>
                    <label style="color: #000 !important">Select Cycle <span style=" float: none;" type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title="<?php echo $val[0] ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                    <select class="form-control" id="reporttype" onchange="getType(this.value)">
                    <option value="">Select Rule</option> 
                     <?php foreach($cycle as $c) { ?>   
                     <option value="<?php echo $c['id'] ?>"><?php echo $c['name'] ?></option>
                     <?php } ?>
                     
                     </select>
                 </div>
            </div>
        </div>
        <div class="col-md-3">
           <div class="mailbox-content">
               <div class="form-group" id="rules">
                   
                 </div>
            </div>
        </div>
<!--        <div class="col-md-6">
            <button id="btnExport" onclick="javascript:xport.toXLS('rtt');" class="btn btn-default">
                    <img src="<?php echo base_url() ?>assets/reports/icons/PDF-Icon.png" alt="download pdf">
                </button>
        </div>-->

</div>
   
<div class="row">
    <div class="col-md-12 "  style="    padding-bottom: 60px;">
        
        <div class="table-responsive" id="responsedata">
             <?php // echo '<pre />'; print_r($staff); ?>
    
        </div>
       
    </div>
</div>

</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" ></script>

                
<script>
function getType(val)
{
    if(val!=='')
    {
    $('#loading').show();
    $.ajax({
    type : "GET",
    url : "<?php echo base_url('report/GetRules/') ?>"+val,
    //data : {reportfor:$('#reporttype').val()},
        success : function(result) {
          console.log(result);  
        $('#rules').html(result);
        $('#responsedata').html('');
        $('#loading').hide();
     }
    });
}
else {
$('#responsedata').html('');
$('#rules').html('');
}
}

function getRuleInfo(val)
{
    if(val!=='')
    {
    $('#loading').show();
    var newVal=val.split('+');
    $.post("<?php echo site_url("report/get_managers_for_manual_bdgt");?>",{budget_type: newVal[1], rid:newVal[0]}, function(data)
        {
            //console.log(newVal[2]);
            if(data)
            {
                $("#responsedata").html(data);
                $("#responsedata").show();
                
                var json_manual_budget_dtls = newVal[2];
                var i = 0;
                var items = [];               
                $.each(JSON.parse(json_manual_budget_dtls),function(key,valll)
                {
                   //alert(valll[0])
					if(newVal[1]=='Manual')
					{
						items.push(valll[1]);
					}
					if(newVal[1]=='Automated but x% can exceed')
					{
						items.push(valll[2]);
					}
                });
                if(newVal[1]=='Manual')
                {
                        $("input[name='txt_manual_budget_amt[]']").each( function (key, v)
                        {
                                $(this).val(items[i]);
                                $(this).prop('readonly',true);
                                calculat_percent_increased_val(1, items[i], (i+1));
                                i++;    
                        });
                        calculat_total_revised_bgt();
                }
                if(newVal[1]=='Automated but x% can exceed')
                {
					$("input[name='txt_manual_budget_per[]']").each( function (key, v)
					{
						$(this).val(Math.round(items[i]));
						$(this).prop('readonly',true);
						calculat_percent_increased_val(2, items[i], (i+1));
						i++;    
					});
					calculat_total_revised_bgt();
				}
            }
			$("#loading").hide();
                         $('#rtt').DataTable({ 
                        "ordering": false,
                         dom: 'Bfrtip',
                         buttons: [
                         'excel', 'pdf', 'print'

                    ]
                    
                });
        });
    }
    else {
        $('#responsedata').html('');
    }
}

$(function() {
  //$("#reporttype").trigger( "onchange" );
});
function calculat_percent_increased_val(typ, val, index_no)
{
    
	if(typ==1)
	{
		$("#td_revised_bdgt_"+ index_no).html(Math.round(val));	
		var increased_amt = ((val/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
		$("#td_increased_amt_"+ index_no).html(Math.round(increased_amt));	
	}
	else if(typ==2)
	{
		var increased_bdgt = ($("#hf_pre_calculated_budgt_"+ index_no).val()*val)/100;
		var revised_bdgt = (($("#hf_pre_calculated_budgt_"+ index_no).val()*1) + (increased_bdgt*1)).toFixed(0);
		$("#td_revised_bdgt_"+ index_no).html(Math.round(revised_bdgt));	
		//var increased_amt = ((revised_bdgt/$("#hf_incremental_amt_"+ index_no).val())*100).toFixed(2);
		//$("#td_increased_amt_"+ index_no).html(increased_amt);	
	}
}
function calculat_total_revised_bgt()
{
	var manager_cnt = $("#hf_manager_cnt").val();
	var val = 0;
	for(var i=1; i<manager_cnt; i++)
	{
		val += ($("#td_revised_bdgt_"+ i).html().replace(/[^0-9.]/g,''))*1;
	}
	$("#th_total_budget").html(val.toFixed(0));
}
$(document).ready(function() {
    
} );
var xport = {
  _fallbacktoCSV: true,  
  toXLS: function(tableId, filename) {   
    this._filename = (typeof filename == 'undefined') ? tableId : filename;
    
    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      custom_alert_popup("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xlsx'); 
  },
  toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }
    
    return 0;
  },
  _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it
      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};

</script>
<style>
    table.dataTable thead th, table.dataTable thead td{
            border-bottom: none !important;
    }
</style>
<style>
    #txt_manual_budget_amt{
                border: none !important;
                width: 118px;
                margin-left: 30px;
                margin-top: -25px;
                padding: 0px !important;
                    background: transparent !important;
    }
    .myspan{
        font-size: inherit !important;
        color:#4E5E6A !important;
    }
</style>