<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Employees List For MidTerm Rule</li>
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
                <?php if($staff_list){?>
                	<table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[1]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[6]["display_name"]; ?></th>                            
                            <th><?php echo $business_attributes[9]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[10]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[11]["display_name"]; ?></th>   
                            <th><?php echo $business_attributes[17]["display_name"]; ?></th>
                            <th><?php echo $business_attributes[23]["display_name"]; ?></th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0;
                     $manager_emailid = strtolower($this->session->userdata('email_ses'));
                     $adhoc_salary_review_dtls = HLP_get_adhoc_salary_review_for_val();
					 
                     foreach($staff_list as $row)
                     {						 
                        echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
						echo "<td>".$row["name"]."</td>";
						echo "<td>".$row["email"]."</td>";
                        echo "<td>".$row["business_unit_3"]."</td>";
                        echo "<td>".$row["desig"]."</td>";
                        echo "<td>".$row["grade"]."</td>";
                        echo "<td>".$row["level"]."</td>";
                        echo "<td>".$row["date_of_joining"]."</td>";
                        echo "<td>".$row["performance_rating"]."</td>";
						echo "<td>";
						if($adhoc_salary_review_dtls["adhoc_salary_review_for"] == CV_ADHOC_FULL_TIME)
						{
							echo "<a href='".site_url("manager/dashboard/adhoc_rule_salary_review/".$row["id"])."'>Salary Review</a>";
						}
						elseif($adhoc_salary_review_dtls["adhoc_salary_review_for"] == CV_ADHOC_ANNIVERSARY_TIME)
						{
							$today_date = date('Y-m-d');
							$end_date = date(date("Y")."-m-d",strtotime($row["date_of_joining"]));
							$start_date = date('Y-m-d', strtotime('-'.$adhoc_salary_review_dtls["preserved_days"].' days', strtotime($end_date)));
							if($start_date <= $today_date and $today_date <= $end_date)
							{
								echo "<a href='".site_url("manager/dashboard/adhoc_rule_salary_review/".$row["id"])."'>Salary Review</a>";
							}
						}
                        echo "</td>";                       
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