<?php 
if(!helper_have_rights(CV_FAQ, CV_INSERT_RIGHT_NAME))
		{
			 $hdcls='style="display:none;"';
		}
if(!helper_have_rights(CV_FAQ, CV_VIEW_RIGHT_NAME))
		{
			 $shcls='style="display:none;"';
		}
?>
<style>
    .table tr td span{
        color: #676767 !important;
    }
</style>
<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
    <div class="col-md-4 p_l0">
        <ol class="breadcrumb wn_btn">
           <?php if(($this->session->userdata('role_ses')==10 || $this->session->userdata('role_ses')==11)) { ?>
            <li><a href="javascript:void(0)"> Policies & FAQs</a></li>    
            <?php } else { ?>
            <li><a href="javascript:void(0)">Connect & Learn</a></li>
            <?php } ?>
            <li class="active">FAQs</li>
        </ol>
    </div>
    <div class="col-md-8 p_r0 text-right">
        <a <?php echo $hdcls ?> href="<?php echo base_url('faq/add') ?>" class="btn btn-success">Add</a>
    </div>
    
</div>
</div>
</div>


<div id="main-wrapper">
<div class="container">
<div class="row mb20">
    <div class="col-md-12 background-cls">
        <div class="">
        
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>  
            <?php //echo '<pre />'; print_r($templatedesc); ?>
            <div class="mailbox-content">
                <table class="table border p_b0" id="glossary">
                    <thead>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($glossary as $g){ ?> 
                        <tr>
                            <td><?php echo $g->question ?></td>
                            <td><?php echo $g->answer ?></td>
                            <td class="text-center">
                                
                                <a data-placement="bottom" data-toggle="tooltip" title="View Document" <?php echo $shcls ?> href="<?php echo base_url('faq/') ?>"><i class="fa fa-eye" aria-hidden="true"></i></a> <span <?php echo $hdcls ?>>|</span> <a data-placement="bottom" data-toggle="tooltip" title="Edit" <?php echo $hdcls ?> href="<?php echo base_url('faq/edit/'.$g->id) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <span <?php echo $hdcls ?>>|</span> <a class="anchor_cstm_popup_cls_faq_delete_<?php echo $g->id; ?>" data-placement="bottom" data-toggle="tooltip" title="Delete" <?php echo $hdcls ?> href="<?php echo base_url('faq/delete/'.$g->id) ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_faq_delete_<?php echo $g->id; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')"><i class="fa fa-trash " aria-hidden="true"></i></a> 
                                
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
    $('#glossary').DataTable({
                 "ordering": false
            });
} );
</script>