<?php 
    if(!helper_have_rights(CV_CBNETWORK, CV_INSERT_RIGHT_NAME))
		{
			$clsshide='style="display:none;"';
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
            <?php } else { ?>
            <li><a href="javascript:void(0)">Connect & Learn</a></li>
            <?php } ?>
            <li class="active">Internal C & B Network</li>
        </ol>
    </div>
   
    <div class="col-md-4 p_r0 text-right" <?php echo @$cstyle ?>>
        <a <?php echo $clsshide ?> href="<?php echo base_url('cbnetwork/add') ?>" class="btn btn-success">Add</a>
    </div>
   </div>
  </div>  
</div>
<div id="main-wrapper" class="container">
    <div class="row">
    <div class="col-md-12 background-cls">
        <div class="box mailbox-content">
            
            <div class="box-body">
              <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
                <div class="table-responsive">
                <table class="table border p_b0" id="cbnetwork">
                    <thead>
						
						<th class="select-filter">Name</th>
						<th class="select-filter">Title</th>
						<th class="select-filter">Company</th>
						<th>Industry</th>
						<th>Country</th>
						<th>Contact</th>
						<th>Email</th>
                                                <!--<th>Document</th>-->
						<th <?php echo $clsshide ?>>Actions</th>
                </thead>
                <tbody>
                    <?php foreach($internal_c_and_b_network as $i){ ?>
                    <tr>
						
						<td><?php echo $i['Name']; ?></td>
						<td><?php echo $i['Title']; ?></td>
						<td><?php echo $i['Company']; ?></td>
						<td><?php echo $i['Industry']; ?></td>
						<td><?php echo $i['Country']; ?></td>
						<td><?php echo $i['Contact']; ?></td>
						<td><?php echo $i['Email']; ?></td>
                                                 <!--<td><?php if($i['Document']!=''){ ?><a title="View Document" href="<?php echo $i['Document']; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?></td>-->
						<td class="text-center" <?php echo $clsshide ?>>
                            <a data-original-title="Edit" data-placement="bottom" data-toggle="tooltip" href="<?php echo site_url('cbnetwork/edit/'.$i['internalCBID']); ?>" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
                            <a class="anchor_cstm_popup_cls_intcanb_delete_<?php echo $i['internalCBID']; ?>" data-original-title="Delete" data-placement="bottom" data-toggle="tooltip" href="<?php echo site_url('cbnetwork/remove/'.$i['internalCBID']); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_intcanb_delete_<?php echo $i['internalCBID']; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')"> <i class="fa fa-trash " aria-hidden="true"></i></a>
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
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
</script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    // DataTable
    $('#cbnetwork').DataTable({ "ordering": false});
 
   
} );
</script>
<style type="text/css">
/*#cbnetwork th{color: #4E5E6A !important;}*/
#cbnetwork_length label,#cbnetwork_filter label{color: #fff !important;}
#cbnetwork_length select,#cbnetwork_filter input{color: #000 !important;}
</style>