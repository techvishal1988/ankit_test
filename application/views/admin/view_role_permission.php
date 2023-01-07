<style type="text/css">
    .mailbox-content table tbody tr:nth-child(2n+1)
    {
        background-color: #fff !important;
    }
    .table tr th .tooltipcls i.themeclr{ color:#<?php echo $this->session->userdata("company_color_ses"); ?> !important;}
 
</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <!--<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li>General Settings</li>
        <li class="active"><a href="<?php echo site_url("view-roles"); ?>">Role Permission</a> / <?php echo $role[0]->name ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-12 background-cls">
    
       <div class="mailbox-content">
       <?php echo $this->session->flashdata('message'); ?>
        <?php echo $msg; 
        //10-Manager
        //11-Manager
//        echo '<pre />';
//        print_r($role[0]->name);
        $arr=[];
        $seg=$this->uri->segment(2);
        $report_arr=array(13,34,35,36,37);
        if($seg==10)
        {
            $arr=[1,9,11,25,26,27,28,29,34,35,36,37,38,39,40,41,42,43,44,46,47,48,49,50,51,52,53,58,61,62,63,64,71];
            $roltxt='-manager';
        }
		elseif($seg==5 || $seg==9)
        {
            $arr=[1,2,30,25,26,27,12,9,23,30,31,32,33,11,34,35,36,37,38,39,40,41,44,45,46,47,48,49,50,51,52,53,54,55,56,57,60,61,62,63,64,65,66,67,71];
            $roltxt='-hr';
        }
        elseif($seg==2 ||$seg==3||$seg==4||$seg==7)
        {
            $arr=[1,2,25,26,27,12,9,11,34,35,36,37,38,39,40,41,44,45,47,48,49,50,51,52,53,54,60,61,62,63,64,65,71];
            $roltxt='-hr';
        }
        elseif($seg==11)
        {
           //$arr=[1,25,26,28,29,38,39,40,41,44,47,48,49,50,51,52,53]; 
		   $arr=[1,25,26,38,39,40,41,44,47,48,49,50,51,52,53,71]; 
           $roltxt='-employee';
        }
        else {
            foreach($pages_details as $a)
            {
                 array_push($arr,$a['page_id']); 
            }
          
        }
       
        ?>
        <?php 
          if(!helper_have_rights(CV_ROLE_PERMISSION, CV_INSERT_RIGHT_NAME))
		{
              
                $dis='disabled';
                echo '<style>.beg_color input[type="checkbox"]:hover + span:before{border:2px #999 solid !important}</style>';
          }
         ?>  
         <form class="frm_cstm_popup_cls_default" action="" method="post" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
         	<?php echo HLP_get_crsf_field();?>
            <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                <thead>
                    <tr>
                        <th class="hidden-xs" width="5%">S.No</th>
                        <th>Page Name</th>                    
                        <th align="center" style="text-align:center">
                <div class="beg_color" >
                    <label style="color:#000 !important;">&nbsp;Full Access <span style=" float: none;" type="button" data-toggle="tooltip control-label" data-placement="bottom" title="Defined user of this role will be able to conduct all the actions on the selected pages." data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
                                    <input <?php echo @$dis ?> type="checkbox" name="chk_insert_all" id="chk_insert_all" style="opacity:1; margin-top:1px;" onclick="check_uncheck_all(this, 'insert');"><span></span></label>
                            </div>
                        </th>
                        <th align="center" style="text-align:center">
                        <div class="beg_color" >
                                <label style="color:#000 !important;">&nbsp;View Access <span style=" float: none;" type="button" data-toggle="tooltip control-label" data-placement="bottom" title="Defined user of this role will be able to only view the information on the selected pages." data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span>
                                    <input <?php echo @$dis ?> type="checkbox" name="chk_view_all" id="chk_view_all" style="opacity:1; margin-top:1px;" onclick="check_uncheck_all(this, 'view');"><span></span></label>
                            </div> 
                        </th>
    <!--                    <th align="center">
                            <div class="beg_color">
                                <label>&nbsp;Update &nbsp;
                                    <input type="checkbox" name="chk_update_all" id="chk_update_all" style="opacity:1; margin-top:1px;" onclick="check_uncheck_all(this, 'update');"><span></span></label>
                            </div>
                        </th>-->
    <!--                    <th align="center">
                            <div class="beg_color">
                                <label>&nbsp;Delete &nbsp;
                                    <input type="checkbox" name="chk_delete_all" id="chk_delete_all" style="opacity:1; margin-top:1px;" onclick="check_uncheck_all(this, 'delete');"><span></span></label>
                            </div>
                        </th>-->
                    </tr>
                </thead>
               
                <tbody id="tbl_body">                   
                 <?php $i=0;
                  $tooltip=getToolTip('role-permission-detail'.$roltxt);
                  $val=json_decode($tooltip[0]->step);
                  $loopcounter = 0;
                foreach($pages_details as $row)
                {
                    if(in_array($row["page_id"],$arr))
                    {
                        
                    if($row["page_id"]!=1)
                    {
                        $loopcounter++;
                    echo "<tr>";
                    echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                    echo '<td>'.$row["page_name"].' <span style=" float: none;" type="button" data-toggle="tooltip control-label" data-placement="bottom" title="'.$val[$i].'" data-original-title=""><i class="fa fa-info-circle themeclr" aria-hidden="true"></i></span></td>'; ?>
                   
                        <input type="hidden" name="permission_id" value="<?php echo $row["page_id"]; ?>">             
                                        
                        <td align="center">
                          <?php if(!in_array($row["page_id"],$report_arr)) { ?>  
                        <div class="beg_color">
                            <label>&nbsp; 
                                <input <?php echo @$dis ?> type="checkbox" name="chk_insert[]" class="lstchild" value="<?php echo $row["page_id"]; ?>" id="chk_insert_<?php echo $row["page_id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                        </div>
                          <?php } ?>
                        </td>   
                        <td align="center">
                        <div class="beg_color">
                            <label>&nbsp; 
                                <input <?php echo @$dis ?> type="checkbox" name="chk_view[]" class="lstview"  value="<?php echo $row["page_id"]; ?>" id="chk_view_<?php echo $row["page_id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                        </div>
                        </td>             
    <!--                    <td align="center">
                        <div class="beg_color">
                            <label>&nbsp; 
                            <input type="checkbox" name="chk_update[]" value="<?php echo $row["page_id"]; ?>" id="chk_update_<?php echo $row["page_id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                        </div>
                         </td>-->
    <!--                    <td align="center">
                        <div class="beg_color">
                            <label>&nbsp; 
                            <input type="checkbox" name="chk_delete[]" value="<?php echo $row["page_id"]; ?>" id="chk_delete_<?php echo $row["page_id"]; ?>" style="opacity:1; margin-top:1px;"><span></span></label>
                        </div>                     
                         </td>                   -->
                 <?php echo "</tr>";
                    $i++;  }
                    else
                    {
                        echo '<input type="hidden" value="1" name="chk_insert[]" />';
                    }
                    
                    }} ?>  
                 </tbody>
               </table> 
         <?php 
          if(helper_have_rights(CV_ROLE_PERMISSION, CV_INSERT_RIGHT_NAME))
		{  
         ?>    
           <div class="row">
                    <div class="col-sm-12">
                    <div class="overrt_btn">                    
                        <input type="submit" class="btn btn-primary" value="Submit" />
                    </div>
                </div>
            </div>
                <?php } ?>
         </form>                     
        </div>
    </div>
</div>
</div>
<script>
var rows = <?php echo $role_permissions ?>;
if(rows.length > 0)
{
	for(var i=0; i<(rows.length); i++)
	{			
		//alert(rows[i].view);
		if(rows[i].view==1)
		{
			$("#chk_view_"+rows[i].page_id).prop('checked', true);
		}
		if(rows[i].insert==1)
		{
			$("#chk_insert_"+rows[i].page_id).prop('checked', true);
		}
		if(rows[i].update==1)
		{
			$("#chk_update_"+rows[i].page_id).prop('checked', true);
		}
		if(rows[i].delete==1)
		{
			$("#chk_delete_"+rows[i].page_id).prop('checked', true);
		}
	}
}

function check_uncheck_all(obj, evnt)
{
	var val = $(obj).is(":checked");
	
	$("input[name='chk_"+ evnt +"[]']").each(function ()
	{
		$(this).prop('checked', val);
	});
}

$(document).ready(function(){

    var full_check_counter = '<?php echo $loopcounter;?>';
    var counter_check = 0;
    var check_counter_view = 0;
    $('input.lstchild:checkbox:checked').each(function () {
        counter_check++;
    });

    $('input.lstview:checkbox:checked').each(function () {
        check_counter_view++;
    });
    
    if(counter_check == full_check_counter) {
        if($("#chk_insert_all").prop('checked') == false){
            $('#chk_insert_all').trigger('click');
        }
    }

    if(check_counter_view == full_check_counter) {
        if($("#chk_view_all").prop('checked') == false){
            $('#chk_view_all').trigger('click');
        }
    }


    
    $('#chk_insert_all').click(function(){
        if($("#chk_insert_all").prop('checked') == true){
            if($("#chk_view_all").prop('checked') == false){
                $('#chk_view_all').trigger('click');
            }
        } else {
            if($("#chk_view_all").prop('checked') == true){
                $('#chk_view_all').trigger('click');
            }
        }
    });

    $('#chk_view_all').click(function(){
        if($("#chk_view_all").prop('checked') == false){
            if($("#chk_insert_all").prop('checked') == true){
                $('#chk_insert_all').trigger('click');
            }
        } else {

        }
    });

    $('.lstchild').click(function(){
        var access_id = $(this).attr('id');
        if($(this).prop('checked')) {
            var res = access_id.split("_");
            if(res.length == 3) {
                var view_access = 'chk_view_' + res[2];
                if($("#" + view_access).prop('checked') == false){
                    $("#" + view_access).trigger('click');
                }
            }
        } 
        
        // Check full access 
        var full_check_counter = '<?php echo $loopcounter;?>';
        var check_counter = 0;
        $('input.lstchild:checkbox:checked').each(function () {
            check_counter++;
        });
        
        if(check_counter == full_check_counter) {
            if($("#chk_insert_all").prop('checked') == false){
                $('#chk_insert_all').trigger('click');
            }
        }
    });

    $('.lstview').click(function(){
        var access_id = $(this).attr('id');
        if(!$(this).prop('checked')) {
            var res = access_id.split("_");
            if(res.length == 3) {
                var view_access = 'chk_insert_' + res[2];
                if($("#" + view_access).prop('checked') == true){
                    $("#" + view_access).trigger('click');
                }
            }
        }
        var check_view_counter = 0;
        $('input.lstview:checkbox:checked').each(function () {
            check_view_counter++;
        });
        
        if(check_view_counter == full_check_counter) {
            if($("#chk_view_all").prop('checked') == false){
                $('#chk_view_all').trigger('click');
            }
        }
    });

}); 
</script>