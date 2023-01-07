<?php 
    if(!helper_have_rights(CV_TREND, CV_INSERT_RIGHT_NAME))
		{
			$clsshide='style="display:none;"';
		}
?>
<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
    <div class="col-sm-8">
      <ol class="breadcrumb wn_btn">
        <li><a href="javascript:void(0)">Connect & Learn</a></li>
        <li>C & B Trends</li>
      </ol>
    </div>
    <div class="col-md-4 text-right">
        <a <?php echo $clsshide ?> href="<?php echo site_url('trend/add'); ?>" class="btn btn-success btn-sm">Add</a>
    </div>
    </div>
   </div>
</div>

<div id="main-wrapper" class="container">
    
<div class="row">
    <div class="col-md-12">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title trend">Trends Listing  </h3>
            </div>
            <!-- <div class="box-body">
                   
                <table class="table border" id="trends">
                    <thead>
						
						<th>Title</th>
						<th>Document</th>
						<th>Description</th>
						<th <?php echo $clsshide ?>>Actions</th>
                </thead>
                <tbody>
                    <?php foreach($trends as $t){ ?>
                    <tr>
						
						<td><?php echo $t['Title']; ?></td>
						<td><?php if($t['Document']!=''){ ?><a href="<?php echo $t['Document']; ?>" target="_blank">View</a><?php } ?></td>
						<td><?php echo $t['Description']; ?></td>
						<td <?php echo $clsshide ?>>
                            <a href="<?php echo site_url('trend/edit/'.$t['TrendID']); ?>" > Edit</a> |
                            <a href="<?php echo site_url('trend/remove/'.$t['TrendID']); ?>"> Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                                
            </div> -->
            <div class="row">
                
                <?php foreach($trends as $t){ ?>
                <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3">
                    <div class="panel panel-default custom-panel card">
                        <div class="panel-body">
                            <h4>
                                <?php echo $t['Title']; ?>
                            </h4>
                            <p class="disp">
                            <?php echo $t['Description']; ?>
                            </p>
                           <!--  <p>
                            Click to view document:
                            <?php if($t['Document']!=''){ ?><a class="btn btn-success" href="<?php //echo $t['Document']; ?>" title="View" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?></td>
                            </p> -->
                            <p class="text-right optn"><?php if($t['Document']!=''){ ?><a class="btn btn-success" data-placement="bottom" data-toggle="tooltip"  href="<?php echo $t['Document']; ?>" title="View Document" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a><?php } ?></td>
                                <a class="btn btn-info" data-placement="bottom" data-toggle="tooltip"  href="<?php echo site_url('trend/edit/'.$t['TrendID']); ?>" title="Edit" > <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a class="btn btn-danger anchor_cstm_popup_cls_trend_delete_<?php echo $t['TrendID']; ?>" data-placement="bottom" data-toggle="tooltip"  href="<?php echo site_url('trend/remove/'.$t['TrendID']); ?>" title="Delete" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_trend_delete_<?php echo $t['TrendID']; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')"> <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
    var table = $('#trends').DataTable({
                 "ordering": false
            });
 
   
} );
</script>