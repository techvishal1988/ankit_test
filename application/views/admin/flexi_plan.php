<style type="text/css">
.blackk{color: #fff !important; background-color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}
.disabled {
    pointer-events:none; //This makes it not clickable
    opacity:0.6;         //This grays it out to look disabled
}
</style>
<script type="text/javascript">
function set_plan_type(obj)
{
	<?php if(isset($edit_dtls_disable) and $edit_dtls_disable){?> return; <?php } ?>
  $('label li').removeClass('blackk');
  $("#"+obj).addClass('blackk')
}
</script>


<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Flexi Plans</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
   
    <!-- <div class="col-sm-12">
        <div class="panel panel-white">   
           
        </div>
    </div> -->

    	<div class="col-md-12 background-cls">
        <div class="col-md-12">
           <div class="pull-right">
                    <a style="margin-top: 10px;" class="btn btn-success" href="<?php echo site_url('flexi-plan-filters'); ?>">Add</a>
           </div>
        </div>
        	<?php if($salary_cycles_list){?>
            	<div class="mailbox-content" style="overflow-x:auto">
                    <h4 id="cyc" style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px;"> Flexi Plans</h4>
                    <div class="table-responsive">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                        <thead>
                            <tr>                            
                                <th class="hidden-xs" width="5%">S.No</th>
                                <th width="10%">Plan Name</th>
                                <!--<th>Cycle Type</th>-->
                                <th width="10%">Launched on</th>
                                <th width="25%">Open for employees to complete flexi pay</th>
                                <!--<th>Description</th>-->
                                <th width="15%"> Action </th>
                            </tr>
                        </thead>
                        <tbody id="tbl_body">                   
                         <?php 
                         //print_r($salary_cycles_list);
                             foreach($salary_cycles_list as $i=>$row)
                             {

  $resflexi=$this->admin_model->get_table_row('final_salary_structure', 'id',['flaxi_plan_id'=>$row["id"],'part_of_flexi_pay'=>1]) ;
                                $id = $row["id"];
                                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                                echo "<td>".$row['flexi_plan_name']."</td>";
                                if($row["launched_at"] != '')
                                {
                                     echo "<td>".date("d M Y", strtotime($row["launched_at"]))."</td>";
                                }
                                else
                                {
                                     echo "<td></td>";
                                }
                            if($row["employees_to_complete"] != '')
                                {
                                    echo "<td>".date("d M Y", strtotime($row["employees_to_complete"]))."</td>";
                                }
                                else
                                {
                                  if(count($resflexi)>0){echo "<td></td>";}else{
                                   echo "<td>Not applicable</td>"; 
                                  }
                                }                         
                                echo "<td>";  
                                echo "<a title='Edit' href='".site_url("flexi-plan-filters/".$row["id"]."")."'><i class='fa fa-pencil'></i></a><span>&nbsp;|&nbsp;</span>";
                                if(count($resflexi)>0){
                                echo "<a title='Launched' onclick='openlaunchedPopup(".$row["id"].")' ><i class='fa fa-rocket'></i></a><span>&nbsp;| &nbsp;</span> ";}
                                    echo "<a title='Copy' onclick='return confirm(\"Are you sure you want to copy?\")' href='".site_url("flexi-plan-copy/".$row["id"]."")."'><i  class='fa fa-copy'></i></a> <span>&nbsp;|&nbsp;</span> ";
                                    echo "<a title='Download salary structure for all employees' onclick='show_modal(".$row["id"].")'><i style='cursor: pointer;' class='fa fa-download'></i></a>&nbsp;<span>|&nbsp;</span>";          

  // echo "<a title='Upload salary structure for all employees' onclick='show_modal(".$row["id"].")'><i style='color: #4E5E6A !important;cursor: pointer;' class='fa fa-upload'></i></a>&nbsp;<span>|&nbsp;</span>";

                echo "<a title='Delete' onclick='return confirm(\"Are you sure you want to delete?\")' href='".site_url("flexi-plan-delete/".$row["id"]."")."'><i class='fa fa-trash'></i></a>&nbsp;<span>|&nbsp;</span>";
                 echo "<a title='Final Release'  href='#'><i  class='fa fa-location-arrow'></i></a>";

                                echo "</td>";
                                echo "</tr>";
                            
                             }
                         ?>                     
                        </tbody>
                       </table>                    
            </div>
            </div>
            <?php } ?>
           
      
            
            
                        
            
        </div>
</div>
</div>
<!-- upload file modal -->
<div class="modal fade" id="uploadpopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
                   
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><label style="font-size: 16px;">Upload Report</label></h4>
         
        </div>
        
        <div class="modal-body">
 <form class="frm_cstm_popup_cls_flexi_upload" method="post" action="<?php echo base_url('admin/admin_dashboard/upload_flexi_report'); ?>" enctype='multipart/form-data' id="upload_report" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_flexi_upload')">
            <?php echo HLP_get_crsf_field();?>
<div class="row">   
               <div class="col-md-12">
                        <div class="form-group my-form attireBlock">
                      <label style="padding-left: 10px !important;" class="col-sm-4 col-xs-12 control-label removed_padding black white">Select</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
          <input type="file" name="uploadfile" id="uploadfile" class="form-control" title="Choose a file csv to upload" required accept="application/msexcel*">
                      
                      </div>
                    </div>
                    </div>
                  
<div class="col-md-12">
<input type="hidden" name="uploadflexi_id" id="uploadflexi_id">
<input type="submit" class="btn btn-primary" name="" value="Upload">
</div>
            </div>
         </form>
         
        </div>

        
       
      </div>
      
    </div>
</div>

<!-- end -->

<div class="modal fade" id="downloadpopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
                   
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><label style="font-size: 16px;">Download/Upload Report</label></h4>
         
        </div>
        
        <div class="modal-body">
     <form class="frm_cstm_popup_cls_flexi_download" method="post" action="<?php echo base_url('admin/admin_dashboard/upload_flexi_report'); ?>" enctype='multipart/form-data' id="upload_report" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_flexi_download')">
            <?php echo HLP_get_crsf_field();?>
            <div class="row">
 <?php $rule_dtls = $this->rule_model->get_table("hr_parameter", 'id,salary_rule_name', "status >= 6 AND status != ".CV_STATUS_RULE_DELETED,''); ?>
               <div class="col-md-12">
                        <div class="form-group my-form attireBlock">
                      <label style="padding-left: 10px !important;" class="col-sm-4 col-xs-12 control-label removed_padding black white">Select</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
              <select class="form-control" id="downloadtype" name="downloadtype" onchange="download_data_rule(this.value)">
                  <option value="1">Download with core data.</option>
                  <option value="2">Download with rule.</option>
                        </select>
                      
                      </div>
                    </div>
                    </div>
                     <div class="col-md-12" id="rulelist" style="display: none;">
                        <div class="form-group my-form attireBlock">
                      <label style="padding-left: 10px !important;" class="col-sm-4 col-xs-12 control-label removed_padding black white">Select Rule</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                        <select class="form-control" id="ruleid" name="ruleid">
                          <option value="">Select Rule</option>
                          <?php 
                          if(!empty($rule_dtls))
                          {
                              foreach ($rule_dtls as $rule) {
                                if($rule['salary_rule_name']!='')
                                {
                               ?>
                               <option value="<?php echo $rule['id']; ?>"><?php echo $rule['salary_rule_name']; ?></option>
                               <?php
                               }
                              }
                          }
                           ?>
                          
                          
                        </select>
           <span id="down_error" style="color: red;"></span>
                      </div>
                    </div>
                    </div>

                     <div class="col-md-12">
                    

                        <div class="form-group my-form attireBlock">
                      <label style="padding-left: 10px !important;" class="col-sm-4 col-xs-12 control-label removed_padding black white">Select File</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
              <input type="file" name="uploadfile" id="uploadfile" class="form-control" title="Choose a file csv to upload" required accept="application/msexcel*">
                      
                      </div>
                    </div>
                  
                    </div>
                     <div class="col-md-12">
    <input type="hidden" name="flexi_id" id="flexi_id">
 <a onclick="return download_report('new')" id="downloadlink" class="btn btn-primary">Download</a>
 <a onclick="return download_report('existing')" id="downloadlink1" class="btn btn-primary">Download Existing Data</a>
 <input type="submit" class="btn btn-primary" name="" value="Upload">
    </div>
            </div>
         
         </form>
        </div>

        
       
      </div>
      
    </div>
</div>
<div class="modal fade" id="laucchedpopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
                   
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><label style="font-size: 16px;">Launched Details</label></h4>
         
        </div>
        
        <div class="modal-body">
            <div class="row">
                <form method="post" id="savedata" onsubmit="return save_data(this)">  
                <div class="col-md-12">
                     <?php echo HLP_get_crsf_field();?>
                    <div class="col-md-12">
                    <div class="form-group my-form attireBlock">
                      <label style="padding-left: 10px !important;" class="col-sm-4 col-xs-12 control-label removed_padding black white">How many days</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                       <input maxlength="2" id="noofdays" type="text" class="form-control" name="noofdays" placeholder="How many days" required="required" >
                       <span id="errmsg" style="color: red;"></span>
                      </div>
                    </div>

                      
                        </div>
                    <div class="col-md-12">
                        <div class="form-group my-form attireBlock">
                      <label style="padding-left: 10px !important;" class="col-sm-4 col-xs-12 control-label removed_padding black white">Launched Date</label>
                      <div class="col-sm-8 col-xs-12 removed_padding">
                       <input type="text" class="form-control" name="launched_date" id="launched_date" placeholder="Launched Date" required="required" value="<?php echo date('d/m/Y'); ?>">
                      </div>
                    </div>
                    </div>
                     <div class="col-md-12">
                 <input type="hidden" name="flexiid" id="flexiid">
                <input type="submit" class="btn btn-primary" name="Save">
                     </div>
                </div>
</form>
            </div>
         
         
        </div>

        
       
      </div>
      
    </div>
</div> 


<style>
h4{margin-bottom:0px}
</style>
<script> 
function submit_report()
{
  //alert();
  $.ajax({
  url: '<?php echo base_url('admin/admin_dashboard/upload_flexi_report'); ?>',
    type: 'POST',
    data: $('#upload_report').serialize(),
  })
  .done(function(data) {
    $('#loading').hide();
    console.log(data);
  });
  return false; 
}
function download_report(condition)
{
  
  $('#down_error').html('');
  flag=0;
  if($('#downloadtype').val()=='2')
  {
    if($('#ruleid').val()=='')
    {
      $('#down_error').html('Please select rule.');
      flag=1;
    }
  }

var url=$("#flexi_id").val()+'/'+$('#downloadtype').val()+'/'+$('#ruleid').val();
// alert(url);
// return false;
  if(flag==0)
  {
   // $("#downloadpopup").modal('hide');

   if(condition=='existing')
   {
     $('#downloadlink1').attr('href','<?php echo site_url('download-flexi-data'); ?>/'+url);
   }
   else
   {
    $('#downloadlink').attr('href','<?php echo site_url('download-salary-structure'); ?>/'+url);
   }
    
  }
  
} 
function upload_data_rule(str)
{
  $('#uploadruleid').removeAttr('required');
  $('#uploadrulelist').hide();
  if(str=='2'){
    $('#uploadrulelist').show();
   $('#uploadruleid').attr('required', 'required');
  }
}
function download_data_rule(str)
{
  $('#ruleid').removeClass('required');
  $('#rulelist').hide();
  if(str=='2'){
    $('#rulelist').show();
   $('#ruleid').addClass('required');
}
}
function show_uploadmodal(flexiid)
{
$('#uploadrulelist').hide();
$('#uploadtype').prop('selectedIndex',0);
$('#uploadruleid').prop('selectedIndex',0);
$("#uploadflexi_id").val(flexiid);
$("#uploadpopup").modal('show');
}

function show_modal(flexiid)
{
$('#rulelist').hide();
$('#downloadtype').prop('selectedIndex',0);
$('#ruleid').prop('selectedIndex',0);
$("#flexi_id").val(flexiid);
$("#downloadpopup").modal('show');
}
 function save_data(obj)
 {
   $.ajax({
            type: "POST",
            url: "<?php echo site_url("admin/admin_dashboard/flexi_plan_launched"); ?>",
            data:$('#savedata').serialize(),
            beforeSend(xhr){  
            },
            success: function(postBack){
                $('#loading').hide();
              location.reload();
            },error: function(data){
               
            }
        }); 

  return false;
 }  
$(document).ready(function () {
$("#launched_date").datepicker({ 
dateFormat: 'dd/mm/yy',
minDate:0,
changeMonth : true,
changeYear : true,
});
  $("#noofdays").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
function openlaunchedPopup(flexiid) {
$('#loading').show();
$('#flexiid').val(flexiid);
 $.ajax({
            type: "GET",
            url: "<?php echo site_url("admin/admin_dashboard/get_flexi_plan_launched"); ?>",
            data:{flexiid:flexiid},
            beforeSend(xhr){  
            },
            success: function(postBack){
                $('#loading').hide();
                var days=postBack.split('_');
                $('#launched_date').val(days[1]);
                $('#noofdays').val(days[0]);
            },error: function(data){
               
            }
        }); 

$("#laucchedpopup").modal('show');
}
 
function CheckFromDateToDate(FromDate, ToDate) 
{
	document.getElementById("spn_error_msg").innerHTML ="";
    var sessionLanguage;
    var str1 = document.getElementById(FromDate).value; //Fromdate
    var str2 = document.getElementById(ToDate).value;  //todate

    var sptdate1 = str1.replace("-", "/").replace("-", "/").split("/");
    var sptdate2 = str2.replace("-", "/").replace("-", "/").split("/");
    var datestring1 = sptdate1[1] + "/" + sptdate1[0] + "/" + sptdate1[2];
    var datestring2 = sptdate2[1] + "/" + sptdate2[0] + "/" + sptdate2[2];
    var date1 = new Date(datestring1)
    var date2 = new Date(datestring2);
    if (date2 < date1)
    {       
        //alert("Start date must be less than end date.");
		document.getElementById("spn_error_msg").innerHTML ="<div align='left' style='color:red;'><b>Start date must be less than end date.</b></div>";
        document.getElementById(FromDate).value = "";
		play_msg("Start date must be less than end date.");
        return false;
    }
    else {
        return true;
    }
}
</script>

<!-- Common popup to give a alert msg Start -->
<script type="text/javascript">
<?php if($this->session->flashdata("message")){?>
$("#common_popup_for_alert").html('<?php echo "".$this->session->flashdata("message").""; ?>');
    $.magnificPopup.open({
        items: {
            src: '#common_popup_for_alert'
        },
        type: 'inline'
    });
setTimeout(function(){ $('#common_popup_for_alert').magnificPopup('close');}, 3000);
<?php } ?>
</script>
<!--  Common popup to give a alert msg End -->
