<style>
@media screen and (max-width: 767px)
{
.overflowCss{
	    overflow-x: scroll !important;
}
}

.downloadcsv{ text-decoration : none !important; color: #000;}
.downloadcsv:hover{ text-decoration : none !important; color: #000;}


</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("staff"); ?>">Employees</a></li>
        <li class="active"><?php echo $title ?></li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
    <h3>Upload File</h3>
</div>
</div> -->
<div class="modal fade" id="emailTemplate" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
                    <?php echo HLP_get_crsf_field();?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><label style="font-size: 16px;">Email To be send</label></h4>

        </div>
        <div class="modal-body" id="setBody">

        </div>



        <div class="modal-footer" id="setFooter">
          <button type="submit" class="btn btn-primary">Send Mail12</button>
        </div>

      </div>

    </div>
</div>
<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-white">
            <div class="panel-body">
                <?php echo $this->session->flashdata('message');
                    echo $msg;
					if($this->session->userdata("errors_file_data"))
					{
						echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button> <b>Some rows having incorrect data, to get error's file click on the download link below.</b></div><b><div style='margin-bottom:15px;' class='text-center'><a class='btn btn-primary' href=".site_url("upload/download_error_file")." target='_blank'>Download Error File</a></div></b>";

						$this->session->set_userdata(array("errors_file_data_new"=>$this->session->userdata("errors_file_data")));
						$this->session->unset_userdata('errors_file_data');
					}
                                        $tooltip=getToolTip('upload-file');$val=json_decode($tooltip[0]->step);
                ?>
                <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="<?php echo site_url($formaction); ?>" enctype="multipart/form-data" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                	<?php echo HLP_get_crsf_field();?>

                    <div class="form-group my-form no_bot_mar">
                        <div class="col-sm-11 form-input browse-wrap">
                        <div class="title">Choose a csv file to upload</div>
                            <input type="file" name="myfile" id="myfile" class="form-control upload" title="Choose a file csv to upload" required accept="application/msexcel*">
                        </div>
                        <span class="upload-path"></span>
                    </div>

                    <div class="">
                        <div class="col-sm-12 text-center mob-center">
                            <input type="submit" id="btnAdd" value="<?php echo !empty($button_title) ? $button_title : 'Upload'; ?>" class="btn btn-success" /> 
                            <span style="float: unset; margin-top: 8px; color: #fff;" type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="right" title="<?php echo !empty($button_tooltip) ? $button_tooltip : ''; ?>" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12 background-cls">
   <div class="mailbox-content overflowCss">
        <h4 class="mar_bot" style="background-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>; padding:10px; <?php if(!$uploaded_file_list){ echo "text-align:center;"; } ?>">&nbsp;
		<?php if($uploaded_file_list){
                if(!empty($company_dtls)) {
                    $market_data_by = $company_dtls['market_data_by'];
                }
        ?>Historical uploads <?php }	?>
        <span class="<?php if($uploaded_file_list){ echo "flot_r"; } else{ echo "float_l";} ?>">
        <?php
            if(helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_VIEW_RIGHT_NAME)  && ($action == "bulk_upload"))
                { ?>
                    <a class="downloadcsv" href="<?php echo site_url("business-attributes"); ?>">Business Attributes</a>&nbsp;|&nbsp;
                <?php }
        ?>
        <a href="<?php echo base_url('download-sample/' . $actionpath);?>" class="downloadcsv">Download File Format</a>
        <!--Harshit <a href="javascript:void(0);" class="downloadcsv" onclick="download_sample('<?php echo $market_data_by; ?>')">Download File Format</a> -->

        <span>
        </h4>
		<?php $upload_id_to_set_manager_role=0;
			if($uploaded_file_list){ ?>
        	<div class="table-responsive">
        <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>
                <th class="hidden-xs" width="5%">S.No</th>
                <th>Uploaded By Name</th>
                <th>Uploaded File Name</th>
                <th>Uploaded DateTime</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body">
         <?php $i=0;
             foreach($uploaded_file_list as $row)
             {
                $id = $row["id"];
                echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                echo "<td>".$row["name"]."</td>";
																echo "<td>".$row["uploaded_file_name"]."</td>";
                echo "<td>".date("d/m/Y H:i:s", strtotime($row["upload_date"]))."</td>";
                echo "<td>";
                if($row["status"]==1)
                {
                    echo "<a href='".site_url("mapping-head/$id")."'>Map Headers</a>";
                }
																elseif($row["status"]==2)
                {
                   echo "Completed";
                   echo " | <a data-toggle='tooltip' data-original-title='Upload data' data-placement='bottom' href='".base_url('email-filter/').$id."' alt='Send Email' title='Send Email'><i class='fa fa-envelope' aria-hidden='true'></i></a>";
																			if($row["is_manager_role_updated"] == 2)
																			{
																				$upload_id_to_set_manager_role = $id;
																			}
                }
                elseif($row["status"]==3)
                {
                   echo "No Data";
                }
                else
                {
                    echo "In Active";
                }
                if( (CV_DEFAULT_FILE_NAME != $row["original_file_name"]) && !empty($row["original_file_name"]) && file_exists(FCPATH."uploads/".$row["original_file_name"]) ){
                    echo '&nbsp; | &nbsp;<a href="'.base_url('uploads/'.$row["original_file_name"]).'" download="'.$row["uploaded_file_name"].'">Download</a>';
                }
                echo "</td>";
                echo "</tr>";
                $i++;
             }
         ?>
        </tbody>
       </table>
       </div>
       <?php } ?>

       <!--Harshit <a href="<?php echo base_url('uploads/default_single_benchmark.csv');?>" id="download_single" download style="display:none;">Single</a>
       <a href="<?php echo base_url('uploads/default_multiple_benchmark.csv');?>" id="download_multiple" download style="display:none;">Multiple</a> -->
    </div>
</div>


</div>
 <script type="text/javascript">
    var span = document.getElementsByClassName('upload-path');
    // Button
    var uploader = document.getElementsByName('myfile');
    // On change
    for( item in uploader ) {
      // Detect changes
      uploader[item].onchange = function() {
        // Echo filename in span
        span[0].innerHTML = this.files[0].name;
        var filename = this.files[0].name;
        var file_ext = filename.split('.').pop();
       // if((this.files[0].type != "text/comma-separated-values") && (this.files[0].type != "application/vnd.ms-excel") && (this.files[0].type != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
        if(file_ext != 'csv')
        {
            span[0].innerHTML = "";
            $("#myfile").val("");
            custom_alert_popup("Selected file type should csv only.")
        }
        else if(this.files[0].size > (40*1024*1000))
        {
            $("#myfile").val("");
            span[0].innerHTML = "";
            custom_alert_popup("Selected file size should be less than 40MB.")
        }
      }
    }

    /*Harshit function download_sample(btype){
        var type = '<?php echo CV_MARKET_SALARY_ELEMENT; ?>';
        if(type == btype){
            document.getElementById("download_single").click();
        } else {
            document.getElementById("download_multiple").click();
            // document.getElementById("download_single").click();
        }

    }*/
	<?php if($upload_id_to_set_manager_role){ ?>
		$.get('<?php echo site_url("upload/set_role_for_managers/".$upload_id_to_set_manager_role);?>');
	<?php } ?>
  function get_type (id) {
   var ancoreTag='';
   var usertype=id.split('_');
  ancoreTag='<a class="btn btn-primary" href="<?=site_url("sent_email_new_employee/")?>'+usertype[1]+'/'+usertype[0]+'">Send Mail</a>';
  $("#setFooter").html(ancoreTag);
  }

    function openEmailTemplatePopup(ruleId) {

  var ancoreTag,bodytag='';

 $('#loading').show();
 var csrf_val = $('input[name=csrf_test_name]');
        $.ajax({
            url: '<?Php echo site_url('upload/getEmailTemplate?ruleId='); ?>'+ruleId,
            type: 'get',
            success: function (res) {

              if(res!=0)
              {

                  ancoreTag='<a class="btn btn-primary" href="<?=site_url("sent_email_new_employee/")?>'+ruleId+'/0">Send Mail</a>';
                    bodytag=res;
                  $("#setFooter").html(ancoreTag);
                  $("#setBody").html(bodytag);
              }
              else
              {
                  bodytag="No Email Template Created Yet.Please Create Email Template First.";

                  $("#setBody").html(bodytag);
              }
              $("#loading").hide();

            }
        });

      $("#emailTemplate").modal('show');
}
</script>
