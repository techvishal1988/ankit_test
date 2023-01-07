<?php 
    if(!helper_have_rights(CV_TOOLTIP, CV_INSERT_RIGHT_NAME))
		{
			$clsshide='style="display:none;"';
		}
?>
<div class="page-breadcrumb">
<div class="container">
<div class="row">
<div class="col-sm-8" style="padding-left: 0px;">
    <ol class="breadcrumb wn_btn">
        <li>General Settings</li>
        <li class="active">Tooltip</li>
    </ol>
    </div>
    <div class="col-md-4 text-right" style="padding-right: 0px;">
         <a <?php echo $clsshide ?> href="<?php echo base_url('admin/tooltip/create') ?>" class="btn btn-primary pull-right" >Create</a>  
    </div>
</div>
  
   </div>
</div>


<div id="main-wrapper" class="container">

<div class="row mb20">
	<div class="col-md-12 background-cls">
            
               <div class="mailbox-content" style="overflow-x:auto">
               <?php echo @$this->session->flashdata('msg');  ?>
                  
                   
                <?php if(count($tooltips)!=0) { ?>    
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th> 
                            <th>Page</th>
                            <th <?php echo $clsshide ?>>Action</th>
                                
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0;
                     foreach($tooltips as $row)
                     {
                        // Note :: If we needs to add some more columns in table then must add header name as above which are comes dynamically
                        echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                        echo "<td>".$row->description."</td>";
                        echo "<td $clsshide >".'<a title="Edit" href="'.base_url().'index.php/admin/tooltip/create/'.$row->tooltip_page_id.'" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'."</td>";
                        //echo "<td $clsshide >".'<a title="Edit" href="'.base_url().'index.php/admin/tooltip/create/'.$row->tooltip_page_id.'" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a  href="'.base_url().'index.php/admin/tooltip/delete/'.$row->tooltip_page_id.'" >Delete</a>'."</td>";
			echo "</tr>";
                $i++;
                     }
                     ?>  
                     </tbody>
                   </table>       
                <?php } ?>
                   
                </div>
            </div>
</div>
   
</div>
<style type="text/css">
.breadcrumb{padding-left: 0px !important;}    
</style>

  
 