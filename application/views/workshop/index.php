<?php 
    if(!helper_have_rights(CV_WORKSHOP, CV_INSERT_RIGHT_NAME))
		{
			$clsshide='style="display:none;"';
		}
?>
<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
    <div class="col-md-8 p_l0">
        <ol class="breadcrumb wn_btn">
            <li><a href="javascript:void(0)">Connect & Learn</a></li>
            <li class="active">F2F C&B Conferences/workshops</li>
        </ol>
    </div>
   <div class="col-md-4 p_r0 text-right">
        <a <?php echo $clsshide ?> href="<?php echo site_url('workshop/add'); ?>" class="btn btn-success btn-sm">Add</a>
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
  
                <table class="table border p_b0" id="workshop">
                    <thead>
						
						<th>Title</th>
						<th>Date</th>
						<th>Location</th>
                        <th>Type</th>
						<th>Organized By</th>
						<th>Website</th>
						<!--<th>Description</th>
                                                <th>Document</th>-->
						<th <?php echo $clsshide ?>>Actions</th>
                </thead>
                <tbody>
                    <?php foreach($workshop as $w){ ?>
                    <tr>
						<td><?php echo $w['Title']; ?></td>
						<td><?php if($workshop['date'] != "0000-00-00"){ echo date('d/m/Y', strtotime($w['date']));} ?></td>
						<td><?php echo $w['location']; ?></td>
                        <td><?php echo $w['workshop_type']; ?></td>
						<td><?php echo $w['organised_by']; ?></td>
						<td><?php echo $w['website']; ?></td>
						<?php /*?><td><?php echo $w['Description']; ?></td>
                                                <td><?php if($w['Document']!=''){ ?><a title="View Document" href="<?php echo $w['Document']; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?></td><?php */?>
						<td class="text-center" <?php echo $clsshide ?>>
                            <a data-placement="bottom" data-toggle="tooltip" title="Edit" href="<?php echo site_url('workshop/edit/'.$w['WorkshopID']); ?>" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
                            <a class="anchor_cstm_popup_cls_trend_delete_<?php echo $w['WorkshopID']; ?>" data-placement="bottom" data-toggle="tooltip" title="Delete" href="<?php echo site_url('workshop/remove/'.$w['WorkshopID']); ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_trend_delete_<?php echo $w['WorkshopID']; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')"> <i class="fa fa-trash " aria-hidden="true"></i></a>
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
  
 
    // DataTable
    var table = $('#workshop').DataTable({
                 "ordering": false
            });
 

} );
</script>