<div class="page-breadcrumb">
<div class="container">
<div class="col-sm-4">
    <ol class="breadcrumb ">
        <li><a href="javascript:void(0)">General Setting</a></li>
        <li class="active">
         Employee</li> 
    </ol>
    </div>
  
   </div>
</div>


<div id="main-wrapper" class="container">

<div class="row mb20">
	<div class="col-md-12">
            
               <div class="mailbox-content" style="overflow-x:auto">
               <?php echo @$this->session->flashdata('message');  ?>
                   <div class="row">
                       <div class="col-md-4">
                           <select class="form-control" id="templateid">
                           <?php
                            foreach ($template as $t)
                            {
                                echo '<option value="'.$t->TemplateID.'">'.$t->TemplateTitle.'</option>';
                            }
                           
                           ?>
                       </select>
                        
                   </div>
                   <div class="col-md-1">
                       <a onclick="getSelected()" href="javascript:void(0)" class="btn btn-primary pull-right">Get PDF</a>
                   </div>
                   </div>
                   
                    
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th> 
                            <th><input type="checkbox"  id="select_all" /></th>
                            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[1]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[6]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[7]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[9]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[10]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[11]["display_name"]; ?></th>   
                            <th><?php echo $business_attributes[17]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[23]["display_name"]; ?></th> 
                                
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0;
                     foreach($staff_list as $row)
                     {
                        // Note :: If we needs to add some more columns in table then must add header name as above which are comes dynamically
                        echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                        echo '<td><input type="checkbox" name="chk[]" class="checkbox" value="'.$row["id"].'"/></td>';
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["business_unit_3"]."</td>";
                        echo "<td>".$row["function"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
                        echo "<td>".$row["grade"]."</td>";
                        echo "<td>".$row["level"]."</td>";
                        echo "<td>".$row["date_of_joining"]."</td>";
                        echo "<td>".$row["performance_rating"]."</td>";
			echo "</tr>";
                $i++;
                     }
                     ?>  
                     </tbody>
                   </table>                    
                </div>
            </div>
</div>
    <form method="post" id="frmtemplate" action="">
        <input type="hidden" name="empids" id="empids" />
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});

    function getSelected()
    {   
        var srt='';
         $('.checkbox').each(function(){
             if(this.checked)
             {
                 srt+=$(this).val()+',';
                 
             }
            });
            $('#empids').val(srt.replace(/,\s*$/, ""));
             $('#frmtemplate').attr('action', '<?php echo base_url('admin/template/savepdf/') ?>'+$('#templateid').val());
            $('#frmtemplate').submit();
                               
    }
</script>
  
 