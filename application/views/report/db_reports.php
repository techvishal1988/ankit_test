<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid"> 
    <div class="row">
     <div class="col-sm-8" style="padding-left: 3px;">
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)"> Analytics/Reports</a></li>
            <li class="active"><?php echo @$breadcrumb ?></li>
        </ol>
      </div>
      <div class="col-sm-4"></div>
     </div>
    </div>    
</div>
<div class="page-title">
<div id="main-wrapper" class="container-fluid compp_fluid">
	<div class="text-center mt-4">
      <?php
	  		$val = array(0);
            $tooltip=getToolTip('dbreports');
			if($tooltip)
			{
				$val=json_decode($tooltip[0]->step);
			}
            
            ?>
      <h3 class="text20 textbold" style="background: #f5f5f5; padding: 10px; margin-left: -15px; margin-right: -15px;">Database Report <!-- <span style=" float: none;" type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title="<?php //echo $val[0] ?>"><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span> -->
      <div style="display: inline-block;">
              <form class="form-inline">
                <div class="form-group">
                   <?php 
                   $list=array(
                                array(
                                  'url'=>base_url('report/salaryReport'),
                                  'value'=>'Salary review database report'  
                                ),
                                array(
                                  'url'=>base_url('report/bonus_review'),
                                  'value'=>'Bonus Review database report'  
                                ),
                                array(
                                  'url'=>base_url('report/lti_review'),
                                  'value'=>'LTI Review database report'  
                                ),
                                array(
                                  'url'=>base_url('report/rnrreport'),
                                  'value'=>'R&R DB report'  
                                ),
                                array(
                                  'url'=>base_url('report/salarySummery'),
                                  'value'=>'Salary review summary report'  
                                ),
                                array(
                                  'url'=>base_url('report/bonusSummery'),
                                  'value'=>'Bonus allocation summary report'  
                                ),
                                array(
                                  'url'=>'',
                                  'value'=>'LTI allocation summary report'  
                                ),
                                array(
                                  'url'=>base_url('report/RnrSummery'),
                                  'value'=>'R&R Summary Report'  
                                )
                       );
                   
                   ?>
                    <label class="text20 textbold" style="color: #000 !important"><!-- Report Type -->for </label>
                    <select class="form-control report-selected-text" id="reporttype" style="margin-bottom: 2px !important;">
                    <option value="">Select Type</option> 
                     <?php foreach($list as $c) { ?>   
                     <option value="<?php echo $c['url'] ?>"><?php echo $c['value'] ?></option>
                     <?php } ?>
                     
                     </select>
                 </div>
                 <div class="form-group" id="rules" style="margin-bottom:0px;">
                   <input type="button" value="Generate Report" onclick="getType()" class="btn btn-primary" />
                </div>
                </form>
            </div>  

      </h3>
    </div>
    
    <?php /*?><div class="row background-cls" style="background: #fff;" >
        <div class="col-md-12">
           <div class="mailbox-content">
              <form class="form-inline" style="margin-bottom:8px;">
                <div class="form-group">
                   <?php 
                   $list=array(
                                array(
                                  'url'=>base_url('report/salaryReport'),
                                  'value'=>'Salary review database report'  
                                ),
                                array(
                                  'url'=>base_url('report/bonus_review'),
                                  'value'=>'Bonus Review database report'  
                                ),
                                array(
                                  'url'=>base_url('report/lti_review'),
                                  'value'=>'LTI Review database report'  
                                ),
                                array(
                                  'url'=>base_url('report/rnrreport'),
                                  'value'=>'R&R DB report'  
                                ),
                                array(
                                  'url'=>base_url('report/salarySummery'),
                                  'value'=>'Salary review summary report'  
                                ),
                                array(
                                  'url'=>base_url('report/bonusSummery'),
                                  'value'=>'Bonus allocation summary report'  
                                ),
                                array(
                                  'url'=>'',
                                  'value'=>'LTI allocation summary report'  
                                ),
                                array(
                                  'url'=>base_url('report/RnrSummery'),
                                  'value'=>'R&R Summary Report'  
                                )
                       );
                   
                   ?>
                    <label style="color: #000 !important">Report Type </label>
                    <select class="form-control" id="reporttype">
                    <option value="">Select Type</option> 
                     <?php foreach($list as $c) { ?>   
                     <option value="<?php echo $c['url'] ?>"><?php echo $c['value'] ?></option>
                     <?php } ?>
                     
                     </select>
                 </div>
                 <div class="form-group" id="rules" style="margin-bottom:0px;">
                   <input type="button" value="Generate Report" onclick="getType()" class="btn btn-primary" />
                </div>
                </form>
            </div>
        </div>
     
<!--        <div class="col-md-6">
            <button id="btnExport" onclick="javascript:xport.toXLS('rtt');" class="btn btn-default">
                    <img src="<?php echo base_url() ?>assets/reports/icons/PDF-Icon.png" alt="download pdf">
                </button>
        </div>-->

</div><?php */?>
  
<div class="row" id="responsedata"  >
    
             <?php // echo '<pre />'; print_r($staff); ?>
    
        
</div>

</div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<!-- <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script> -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" ></script>

                
<script>
function getType()
{
    var val=$('#reporttype').val();
    if(val!=='')
    {
      $('#loading').show();
        $.ajax({
        type : "GET",
        url : val,
        //data : {reportfor:$('#reporttype').val()},
        success : function(result) {  
            $('#loading').hide();
            $('#responsedata').html(result);
            $('#rtt').DataTable({ 
                "ordering": false,
                 dom: 'Bfrtip',
                 //"scrollX": true,
                 buttons: [
                 'excel', 'pdf', 'print'
                ]
            });
         },
         error : function(){
          $('#loading').hide();
         }
        });
    } else {
        $('#responsedata').html('Coming Soon');
    }
}


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
    #rtt_wrapper{
        margin-top: 10px !important;
    }
</style>