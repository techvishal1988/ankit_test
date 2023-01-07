<style>
@media screen and (max-width: 767px)
{.overflowCss{ overflow-x: scroll !important;}}
.downloadcsv{ text-decoration : none !important; color: #000;}
.downloadcsv:hover{ text-decoration : none !important; color: #000;}
/********dynamic colour for table from company colour***********/
.tablecustm{background-color: #fff;}
.tablecustm>thead>tr:nth-child(odd)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),".9"); ?>!important; }
.tablecustm>thead>tr:nth-child(even)>th{background:<?php echo  hex2rgb($this->session->userdata('company_color_ses'),"0.6"); ?>!important;}
/********dynamic colour for table from company colour***********/
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active"><?php echo $title ?></li>
    </ol>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-white">
            <div class="panel-body">
                <?php echo $this->session->flashdata('message');
					  echo $this->session->flashdata('error_file_message'); ?>
                <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" enctype="multipart/form-data" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                	<?php echo HLP_get_crsf_field();?>

                    <div class="form-group my-form no_bot_mar confor_promotion">
                        <div class="row">
                         
                        <div class="col-sm-3 padrt0">
                         <a class="btn btn-success" href="<?php echo base_url('download-promotion-upgrade-data');?>">Download File Format</a>
                        </div>

                         <div class="col-sm-6">
                          <div class="form-input browse-wrap">    
                           <div class="title">Choose a csv file to upload</div>
                            <input type="file" name="promotion_upgrade_file" id="promotion_upgrade_file" data-toggle="tooltip control-label" data-placement="top"  class="form-control upload" title="Choose a file csv to upload" required accept="application/msexcel*">
                           </div> 
                          </div>

                       
                        
                        <div class="col-sm-3 mob-center padlt0">  
                            <input data-toggle="tooltip control-label" data-placement="bottom" type="submit" id="btnAdd" value="Upload" class="btn btn-success" />
                        </div>
                        <div class="col-sm-12 text-center">
                            <span class="upload-path" style="display: none;"></span>
                        </div>
                     </div> 
                    </div>                   
                </form>
            </div>
        </div>
    </div>
</div>

<?php if($tbl_data){?>
	<div class="col-md-12 background-cls">
	   <div class="mailbox-content overflowCss">
		  <div class="table-responsive">
			<table class="table border tablecustm" style="width: 100%; cellspacing: 0;">
			<thead>
				<tr>
					<th class="hidden-xs" width="5%">S.No</th>
					<th colspan="3">From</th>
					<th colspan="3">To</th>
				</tr>
				<tr>
					<th></th>
					<th>Designation</th>
					<th>Grade</th>
					<th>Level</th>
					<th>Designation</th>
					<th>Grade</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach($tbl_data as $row)
				{ ?>	
				  <tr>
					  <td><?php echo $i; ?></td>
					  <td><?php if(isset($designations_list[$row["designation_frm"]])){ echo $designations_list[$row["designation_frm"]]; } ?></td>
					  <td><?php if(isset($grades_list[$row["grade_frm"]])){ echo $grades_list[$row["grade_frm"]]; } ?></td>
					  <td><?php if(isset($levels_list[$row["level_frm"]])){ echo $levels_list[$row["level_frm"]]; } ?></td>
					  <td><?php if(isset($designations_list[$row["designation_to"]])){ echo $designations_list[$row["designation_to"]]; } ?></td>
					  <td><?php if(isset($grades_list[$row["grade_to"]])){ echo $grades_list[$row["grade_to"]]; } ?></td>
					  <td><?php if(isset($levels_list[$row["level_to"]])){ echo $levels_list[$row["level_to"]]; } ?></td>
				  </tr>
				<?php $i++;
				} ?>
			</tbody>
		   </table>
		   </div>
		 
	
		</div>
	</div>
<?php } ?>

</div>
 <script type="text/javascript">
 var span = document.getElementsByClassName('upload-path');

    // Button
    var uploader = document.getElementsByName('promotion_upgrade_file');
    // On change
    for( item in uploader ) {
      // Detect changes
      uploader[item].onchange = function() {

      	$(".upload-path").show();
        // Echo filename in span
        span[0].innerHTML = this.files[0].name;
        var filename = this.files[0].name;
        var file_ext = filename.split('.').pop();
       // if((this.files[0].type != "text/comma-separated-values") && (this.files[0].type != "application/vnd.ms-excel") && (this.files[0].type != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
        if(file_ext != 'csv')
        {
            span[0].innerHTML = "";
            $("#promotion_upgrade_file").val("");
            custom_alert_popup("Selected file type should csv only.")
        }
        else if(this.files[0].size > (40*1024*1000))
        {
            $("#promotion_upgrade_file").val("");
            span[0].innerHTML = "";
            custom_alert_popup("Selected file size should be less than 40MB.")
        }
      }
    }
</script>
