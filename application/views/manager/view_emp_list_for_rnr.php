<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-12">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); ?>      
            <div class="panel-body">
            <div class="form-horizontal ">                
                <div id="dv_partial_page_data" style="overflow-x: auto;">
                <?php $is_enable_approve_btn=0; if($staff_list){?>
                	<table id="example" class="table border  ">
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
                        
                        echo "<td><a href='".site_url("manager/propose-for-rnr/".$row["id"])."'>Propose R & R</a>";
						
						 echo "</td>";
                        echo "</tr>";
                $i++;
                     }
                     ?>  
                    </tbody>
                   </table>
                   <?php }else echo "<p>No record found.</p>"; ?>  
                </div>  
            </div>                 
            </div>
        </div>
    </div>
</div>
</div>