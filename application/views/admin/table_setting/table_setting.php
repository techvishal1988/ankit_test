<style>

@media screen and (max-width: 767px)
{
	.lll{
	width:320px !important;
	
}
.marginTopbtn{
	margin-top:5px;
}
}
.ui-state-disabled
{
    opacity: .90 !important;
filter: Alpha(Opacity=35);
background-color: #fff !important;
}
</style>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
<li>General Settings</li>
        
        <li class="active">Salary Review Table settings</li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
     <div class="row">
        <div class="col-sm-5 mob-center">
            <h3>Business Attributes</h3>
        </div>

        <div class="col-sm-7 mob-center">
            <div class="pull-right">
                <a href="<?php //echo site_url("add-business-attributes"); ?>"><button class="btn btn-success" type="button">Add Business Attributes</button></a>
            </div>
        </div>
    </div>
</div>
</div> -->

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row">
			<div class="col-md-12 background-cls" style="padding-top: 0px !important;">
               <div class="mailbox-content" style="padding-top: 0px !important;">
                <?php echo $msg; echo $this->session->flashdata('message'); ?> 
               <?php 
                    if(!helper_have_rights(CV_GENERAL_SETTINGS_ID, CV_INSERT_RIGHT_NAME))
                    {
                        $dis='disabled';
                        $style='style="display:none;"';
                         echo '<style>.beg_color input[type="checkbox"]:hover + span:before{border:2px #999 solid !important}</style>';
                    }
               ?>
                                              
                </div>
            </div>
</div>

    <div class="row mb40">
      <div class="panel panel-white pad_b_10" style="padding-top: 0px;">
        <?php if(count($table_attribute_list)==0){
            echo '<div class="alert alert-danger alert-dismissable fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong></strong> No result found.
                  </div>';
        } ?>
		


  <form class="frm_cstm_popup_cls_default" action="<?php echo site_url("updateSettings"); ?>" method="post" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
    <?php echo HLP_get_crsf_field();?>              
			<div class="table-responsive">
                <table id="example" class="table border" style="width:100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <?php /*?><!--<th class="hidden-xs" width="4%"><input type="checkbox" class="check-mail-all"></th>--><?php */?>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Attribute Name</th>  
                            <th>New Display Name</th>
                            <th> Show/Hide </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=1;
                     foreach($table_attribute_list as $row)
                        {


                         ?>
                            <tr class="ui-state-default myClass <?=$row->attribute_name=='name'? 'ui-state-disabled':''?>" data="<?=$row->id?>" order='<?=$row->col_attributes_order?>'>
                            <td class="hidden-xs"><?=$i++?></td>
                            <td ><?=$row->desciption ?></td>
                            <td><input type="text" name="display_name[]" value="<?=$row->display_name?>" class="form-control lll" maxlength="45"/>
                        <input type="hidden" name="id[]" value="<?=$row->id?>" class="form-control" /></td>
                        <td>
                            <?php if($row->is_lock==0) { if($row->status==1) {  ?>
                            <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" checked="checked" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                        <?php } else { ?>
                             <div class="beg_color">
                            <label class="black white">&nbsp; <input id="ck_active_<?=$row->id?>" class="ck_active" type="checkbox" name="chk_ba_active[]" value="<?=$row->id?>" onclick="checkUncheck('<?=$row->id?>')" style="opacity:1; margin-top:1px;"><span></span></label>
                            </div>
                        <?php } } else { ?>
                                Locked  
                        <?php } ?>
                        </td>
                        </tr>
                     <?php } ?>   
                                            
						

                     
                    </tbody>
                   </table> 
				   </div><!--End responsive div-->
                   
                    <div class="row">
                            <div class="col-sm-12">
                            <div class="overrt_btn">                    
                            	<input <?php echo @$style ?>  type="submit" class="btn btn-primary pull-right" value="Save" />
                            </div>
                        </div>
                    </div>
					 
                 </form>
				 
				  </div>
              				 
                   </div> 
</div>

<script>
    $( function() {
    $( "#tbl_body" ).sortable({
      items: "tr:not(.ui-state-disabled)",
      update: function( event, ui ) { swap(); }
    });
 
    // $( "#sortable2" ).sortable({
    //   cancel: ".ui-state-disabled"
    // });
 
    //$( "#sortable1 li, #sortable2 li" ).disableSelection();
  } );

function swap(event,ui) {

    // console.log("event:"+$(this).html());
    // console.log("ui:"+ui);
    var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
    var id=[];
    var order=[];
     $(".myClass").each(function(){
        //var p = $(this).position();
       // alert($(this).attr('data'));
       
        id.push($(this).attr('data')); 
        order.push($(this).attr('order')); 
      });

      $("#loading").show();
            var aurl = "<?php echo site_url('admin/table_settings/changeOrder');?>";
            $.ajax({
                 type:"POST",
                url: aurl,
                data:{data:id,'<?php echo $this->security->get_csrf_token_name(); ?>': csrf_val},
                 success: function(result)
                
                {
                    location.reload(); 
                    $("#loading").hide();
                  
                }
            });
     
     
    
}
    function checkUncheck(id)
        {
           // alert($("#ck_active_"+id).prop('checked'));
           // return false;
           var status;
           if($("#ck_active_"+id).prop('checked'))
           {
            status=1;
           }
           else
           {
            status=0;
           }
            $("#loading").show();
            var aurl = "<?php echo site_url('admin/table_settings/updateTableHideShow');?>/"+id+"/"+status;
            $.ajax({
                url: aurl,
                 success: function(result)
                {
                   
                    $("#loading").hide();
                  
                }
            });
        }

</script>

