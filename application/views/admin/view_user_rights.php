<div class="page-breadcrumb">
<div class="container">
<div class="row">
<div class="col-sm-4 col-xs-9 p_l0">
    <ol class="breadcrumb wn_btn">
        <li>General Setting</li>
        <li class="active">User Rights</li>
    </ol>
    </div>
    <?php 
        if(helper_have_rights(CV_HR_RIGHTS_ID, CV_INSERT_RIGHT_NAME))
		{
    ?>
    <div class="col-sm-8 col-xs-3 p_r0 text-right">
     <!--   <a class="btn btn-success"  href="<?php echo site_url("add-hr"); ?>">Add HR</a> -->
    </div>
                <?php } ?>
   </div>
</div>
</div>

<div id="main-wrapper" class="container">
    <div class="row mb20">
        <div class="col-md-12 col-xs-12 background-cls">
        
           <div class="mailbox-content" style="overflow-x:auto">
           <?php echo $msg; echo $this->session->flashdata('message'); ?>
           <?php if($emp_not_any_cycle_counts > 0){echo '
           <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
           <span aria-hidden="true">×</span></button>'
             . $emp_not_any_cycle_counts. ' employees are left, those are not in any HR criteria. 
             <a href="'. site_url("employee-not-in-hr-criteria/1").'" >
             Click Here </a> to view these employee list.</div>';} ?>

            <?php if($rights_details){$cnt = 1+count($rights_details); $per = round(100/$cnt)?>
            <div class="table-responsive">    
            <table id="example" class="table border" style="width: 100%; cellspacing: 0; overflow:scroll !important">
                <thead>
                    <!--- loop for Role Start -->
                    <tr>
                        
                        <th width="<?php echo $per; ?>%">Role Name</th>
                        <?php foreach ($rights_details as $value) 
                        { ?>
                            <th width="<?php echo $per; ?>%"><?php echo $value['role']; ?></th>
    
                        <?php    } ?>
                    </tr>
                    <tr>
                    <th>Access to</th>
                    <?php foreach ($rights_details as $value) 
                        { ?>
                            <th><?php echo $value['user_name']; ?> 
                           <a class="anchor_cstm_popup_cls_userright_<?php echo $value['user_id']; ?>" data-toggle="tooltip" data-original-title="Delete" data-placement="bottom" onclick="return request_custom_anchor_confirm('anchor_cstm_popup_cls_userright_<?php echo $value['user_id']; ?>', 'Are You Sure?')" alt="Delete" title="" href="<?php echo base_url('delete-role/'.$value['user_id'].'/'.$value['role_id']); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></th>
                            
                        <?php    } ?>
                    </tr>
    
                </thead>
                <tbody id="tbl_body">                   
                 <?php 
                 $m = 0;
                 foreach ($rights_details as $row)
                 {  
                    $arr = array();
                    foreach($row['country_list'] as $key)
                    {
                        array_push($arr,$key["name"]);
                    } 
    
                    if($arr)
                    {
                        $country[$m] = implode(", ",$arr); 
                    }else{
                        $country[$m] =  "All";
                    }
    
                    $arr1 = array();
                    foreach($row['bussiness_level_1_list'] as $key1)
                    {
                        array_push($arr1,$key1["name"]); 
                    }
    
                    if($arr1)
                    {
                        $bussiness_level_1[$m] = implode(", ",$arr1); 
                    }else{
                        $bussiness_level_1[$m] =  "All";
                    }
    
                    $arr7 = array();
                    foreach($row['bussiness_level_2_list'] as $key7)
                    {
                        array_push($arr7,$key7["name"]); 
                    }
                    if($arr7)
                    {
                        $bussiness_level_2[$m] = implode(", ",$arr7); 
                    }else{
                        $bussiness_level_2[$m] =  "All";
                    }
    
                    $arr8 = array();
                    foreach($row['bussiness_level_3_list'] as $key8)
                    {
                        array_push($arr8,$key8["name"]); 
                    }
                    if($arr8)
                    {
                        $bussiness_level_3[$m] = implode(", ",$arr8); 
                    }else{
                        $bussiness_level_3[$m] =  "All";
                    }
    
                     $arr2 = array();
                     foreach($row['sub_function_list'] as $key2)
                     {
                        array_push($arr2, $key2["name"]);
                     }
    
                     if($arr2){$sub_function[$m] = implode(", ",$arr2); }else{$sub_function[$m] = "All";}
					 
					$arr11 = array();
					foreach($row['sub_subfunction_list'] as $key11)
					{
						array_push($arr11, $key11["name"]);
					}
					
					if($arr11)
					{
						$sub_subfunction[$m] = implode(", ",$arr11);
					}
					else
					{
						$sub_subfunction[$m] = "All";
					}
					 
                    $arr3 = array();
                    foreach($row['city_list'] as $key3)
                    {
                        array_push($arr3,$key3["name"]);
                    } 
    
                    if($arr3){$city_list[$m] = implode(", ",$arr3); }else{$city_list[$m] = "All";}
    
                    $arr4 = array();
                    foreach($row['function_list'] as $key4)
                    {
                        array_push($arr4,$key4["name"]);
                    }
    
                    if($arr4){$function_list[$m] = implode(", ",$arr4); }else{$function_list[$m] = "All";}
    
                    $arr5 = array();
                    foreach($row['designation_list'] as $key5)
                    {
                        array_push($arr5,$key5["name"]);
                    }
                    if($arr5){$designation_list[$m] = implode(", ",$arr5); }else{$designation_list[$m] = "All";}
    
                    $arr6 = array();
                    foreach($row['grade_list'] as $key6)
                    {
                        array_push($arr6,$key6["name"]);
                    }
                    if($arr6){$grade_list[$m] = implode(", ",$arr6); }else{$grade_list[$m] = "All";}
					
					
					
					
					$arr9 = array();
                    foreach($row['level_list'] as $key9)
                    {
                        array_push($arr9,$key9["name"]);
                    }
                    if($arr9){$level_list[$m] = implode(", ",$arr9); }else{$level_list[$m] = "All";}
    
                    $m++;
    
                 }
    
                 
                    echo "<tr>";
                    echo "<th>Country</th>"; 
                    foreach ($country as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th>City</th>"; 
                    foreach ($city_list as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
    
                    
                    echo "<tr>";
                    echo "<th>Business Level 1</th>"; 
                    foreach ($bussiness_level_1 as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<th>Business Level 2</th>"; 
                    foreach ($bussiness_level_2 as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<th>Business Level 3</th>"; 
                    foreach ($bussiness_level_3 as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<th>Functions</th>"; 
                    foreach ($function_list as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                   
                    echo "<tr>";
                    echo "<th>Sub-Functions</th>"; 
                    foreach ($sub_function as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
					
					echo "<tr>";
                    echo "<th>Sub-Sub-Functions</th>"; 
                    foreach ($sub_subfunction as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<th>Designation</th>"; 
                    foreach ($designation_list as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
    
                    echo "<tr>";
                    echo "<th>Grade</th>"; 
                    foreach ($grade_list as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
					
					echo "<tr>";
                    echo "<th>Level</th>"; 
                    foreach ($level_list as $value)
                    {
                         echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
					
               
                 ?>  
                </tbody>
               </table>
            </div>

    
               <?php }else{echo '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
               <b>No record found. </b></div>'; }?>                  
            </div>
        </div>
    </div>
</div>