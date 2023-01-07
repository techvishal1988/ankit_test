<div class="page-breadcrumb">
<div class="container">
    <div class="col-sm-4">
        <ol class="breadcrumb ">
            <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
            <li class="active"> Staff List (<?php if(isset($is_hr)){echo "Not In Any HR Criteria";}else{echo "Not In Any Plan"; } ?>)</li> 
        </ol>
    </div>    
   </div>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-12">            
       <div class="mailbox-content pad_bot">
       <?php echo $this->session->flashdata('message'); ?>               
        
        <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
            <thead>
                <tr>
                    <th class="hidden-xs" width="5%">S.No</th>
                   <!-- <th>Employee Full Name</th>
                    <th>Email</th>
                    <th>Business Unit 3 = current business unit of the employee</th>
                    <th>Function</th>
                    <th>Designation/Title</th>
                    <th>Grade</th>
                    <th>Level</th>   
                    <th>Date of joining for Increment purposes</th>
                    <th>Performance Rating for this fiscal year</th>-->
                    <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                    <th><?php echo $business_attributes[1]["display_name"]; ?></th>
                    <th><?php echo $business_attributes[6]["display_name"]; ?></th>                            
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
                echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                /*echo "<td><a href='".base_url("staff-detail/").$row["id"]."'>".$row["name"]."</a></td>";
                echo "<td>".$row["email"]."</td>";
                echo "<td>".$row["business_unit_3"]."</td>";
                echo "<td>".$row["function"]."</td>";
                echo "<td>".$row["desig"]."</td>";
                 echo "<td>".$row["grade"]."</td>";
                echo "<td>".$row["level"]."</td>";
                echo "<td>".$row["date_of_joining"]."</td>";
                echo "<td>".$row["performance_rating"]."</td>";*/
				
				echo "<td>".$row["name"]."</td>";
				echo "<td>".$row["email"]."</td>";
				echo "<td>".$row["business_unit_3"]."</td>";
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
</div>
  