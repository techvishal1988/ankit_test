<style>
     .bg{
	<?php /*?>background: url(<?php echo base_url() ?>assets/salary/img/bg-1.png);<?php */?>
	background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
	background-size: cover;
            min-height: 550px;
        
}

</style>
<?php
if(!helper_have_rights(CV_CB_POLOCIES, CV_INSERT_RIGHT_NAME))
        {
                $hdcls='style="display:none;"';
        }
?>
<div class="page-breadcrumb">
 <div class="container">
   <div class="row">
    <div class="col-md-8 p_l0">
        <ol class="breadcrumb wn_btn">
            <?php if(($this->session->userdata('role_ses')==10 || $this->session->userdata('role_ses')==11)) {
                $cstyle='style="display:none;"'?>
            <li><a href="javascript:void(0)"> Policies & FAQs</a></li>    
            <?php } else {  ?>
            <li><a href="javascript:void(0)">Connect & Learn</a></li>
            <?php } ?>
            <li class="active">C & B Policies</li>
        </ol>
    </div>
    
    <div class="col-md-4 p_r0 text-right" <?php echo @$cstyle ?>>
        <a href="<?php echo base_url('c_and_b/add') ?>" class="btn btn-success" <?php echo $hdcls ?>>Add</a>
    </div>
   </div>
  </div> 
    
    
</div>

<div id="main-wrapper" class="container ">
    <div class="row">
    <div class="col-md-12 background-cls">
        <div class="box mailbox-content">
            
            <div class="box-body table-responsive">
                <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
                <table class="table border p_b0" id="pp">
                    <thead>
						
						<th>Title</th>
						<th>Description</th>
						<th>Document</th>
						<th <?php echo $hdcls ?>>Actions</th>
                </thead>
                <tbody>
                    <?php foreach($c_and_b_policies as $c){ ?>
                    <tr>
						
						<td><?php echo $c['Title']; ?></td>
						<td><?php echo $c['Description']; ?></td>
                                                <td class="text-center"><?php if($c['Document']!=''){ ?><a data-placement="bottom" data-toggle="tooltip"  title="View Document" href="<?php echo $c['Document']; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?></td>
						<td class="text-center" <?php echo $hdcls ?>>
                                                    <a data-placement="bottom" data-toggle="tooltip"  title="Edit" href="<?php echo site_url('c_and_b/edit/'.$c['cnbID']); ?>" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
                                                    <a class="anchor_cstm_popup_cls_trend_delete_<?php echo $c['cnbID']; ?>" data-placement="bottom" data-toggle="tooltip"  title="Delete" href="<?php echo site_url('c_and_b/remove/'.$c['cnbID']); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_trend_delete_<?php echo $c['cnbID']; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')"> <i class="fa fa-trash " aria-hidden="true"></i></a>
                                                </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                                
            </div>
        </div>
    </div>
</div>

</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
</script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
    // Setup - add a text input to each footer cell
   
    var table = $('#pp').DataTable({
                 "ordering": false
            });
 
   
} );
</script>
