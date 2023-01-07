<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Employee</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-12">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); ?>      
            <div class="panel-body">
            <div class="form-horizontal">                
                <div id="dv_partial_page_data">
                <?php //echo '<pre />'; print_r($staff_list); 
                $is_enable_approve_btn=0; if($staff_list){?>
                	<table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Employee Full Name</th>
							<th>Email</th>
                            <th>Business Unit 3 = current business unit of the employee</th>
                            <th>Designation/Title</th>
							<th>Function</th>
                            <th>Grade</th>
                            <th>Level</th>   
                            <th>Date of joining for Increment purposes</th>
                            <th>Performance Rating for this fiscal year</th> 
                            <!-- <th>Propose Salary Increase</th>
                            <th>Allocate Bonus</th> 
                            <th>Allocate Long Term Incentive</th>
                            <th>Recognise employee</th>
                            <th> Action </th> -->
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0; $is_enable_approve_btn=1;
                     $manager_emailid = strtolower($this->session->userdata('email_ses'));
                     $rule_id = $staff_list[0]["rule_id"];
                     foreach($staff_list as $row)
                     {
                        if($row["emp_salary_status"] < 5 and strtolower($row["manager_emailid"]) != $manager_emailid)
                        {
                            $is_enable_approve_btn=0;
                        }
						 
                        echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
						echo "<td><a href='".site_url("manager/staff-detail/").$row["id"]."'>".$row["name"]."</a></td>";
						//echo "<td>".$row["name"]."</td>";
						echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["business_unit_3"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
						echo "<td>".$row["function"]."</td>";
                        echo "<td>".$row["grade"]."</td>";
                        echo "<td>".$row["level"]."</td>";
                        echo "<td>".$row["date_of_joining"]."</td>";
                        echo "<td>".$row["performance_rating"]."</td>";
                       /*echo "<td>".$row["desig"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
                        
                        echo "<td><a href='".site_url("manager/view-employee-increments/".$rule_id."/".$row["id"]."/".$row["upload_id"])."'>View Increment</a></td>";*/
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
    </div>
    
</div>
</div>