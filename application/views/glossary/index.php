<div class="page-breadcrumb">
 <div class="container">
   <div class="row">
    <div class="col-md-4 p_l0">
        <ol class="breadcrumb wn_btn">
            <?php if(($this->session->userdata('role_ses')==10 || $this->session->userdata('role_ses')==11)) { 
                 $cstyle='style="display:none;"'?>
            <li><a href="javascript:void(0)"> Policies & FAQs</a></li>    
            <?php } else { ?>
            <li><a href="javascript:void(0)">Connect & Learn</a></li>
            <?php } ?>
            <li class="active">Glossary</li>
        </ol>
    </div>
    <?php
    if(!helper_have_rights(CV_GLOSSARY, CV_INSERT_RIGHT_NAME))
		{
			$hdcls='style="display:none"';
		}
    
    ?>
    <div class="col-md-8 p_r0 text-right" <?php echo @$cstyle ?>>
        <a href="<?php echo base_url('glossary/add') ?>" class="btn btn-success" <?php echo $hdcls ?>>Add</a>
    </div>
   </div>
  </div>  
    
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    
    <div class="col-md-12 background-cls">
        <div class="box-body">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            <?php //echo '<pre />'; print_r($templatedesc); ?>
            <div class="mailbox-content">
                <table class="table border p_b0" id="glossary">
                    <thead>
                    <th>Term</th>
                    <th>Description</th>
                    <th <?php echo $hdcls ?>>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($glossary as $g){ ?> 
                        <tr>
                            <td><?php echo $g->text ?></td>
                            <td><?php echo $g->meaning ?></td>
                            <td class="text-center" <?php echo $hdcls ?>>
                                
                                <a data-placement="bottom" data-toggle="tooltip" title="Edit" href="<?php echo base_url('glossary/edit/'.$g->id) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | <a class="anchor_cstm_popup_cls_trend_delete_<?php echo $g->id; ?>" data-placement="bottom" data-toggle="tooltip" title="Delete" href="<?php echo base_url('glossary/delete/'.$g->id) ?>" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_trend_delete_<?php echo $g->id; ?>','<?php echo CV_CONFIRMATION_MESSAGE;?>')"><i class="fa fa-trash " aria-hidden="true"></i></a> 
                                
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
    $('#glossary').DataTable(
            {
                 "ordering": false
            });
 
   
} );
</script>