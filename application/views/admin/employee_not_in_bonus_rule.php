<div class="page-breadcrumb">
<div class="">
<div class="col-sm-8">
    <ol class="breadcrumb ">
        <li><a href="<?php echo base_url("performance-cycle"); ?>">Comp Plans</a></li>
        <li><a href="<?php echo base_url("bonus-rule-list/".$this->uri->segment(3)); ?>"><?php echo CV_BONUS_SIP_LABEL_NAME; ?> Rules</a></li>
        <li class="active">Employee not in <?php echo CV_BONUS_SIP_LABEL_NAME; ?> rule         </li> 
    </ol>
    </div>
    <?php
            if(helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME))
		{
        ?>
    <div class="col-sm-4 text-right">
        <?php if($this->uri->segment(1)=="hr-list"){?>
            <a class="btn btn-success"  href="<?php echo site_url("add-hr"); ?>">Add HR</a>
        <?php }else{?>
            
            
            <a href="<?php echo base_url('admin/admin_dashboard/empbonusexport/'.$performance_cycle_id) ?>"  class="btn btn-success">Download Data</a>
        <?php }?>
    </div>
                <?php } ?>
   </div>
</div>
<!-- <div class="page-title">
<div class="container">
    <h3>Staff List</h3>
</div>
</div> -->

<style type="text/css">
    .breadcrumb{
            padding: 8px 0px !important;
    }
    .ui-autocomplete {         
          max-height: 200px; 
          overflow-y: auto;         
          overflow-x: hidden;         
          padding: 0px;
          margin: 0px;
        }
       #example_filter input,#example_filter label{ display: none;} 
       .dataTables_processing{
                width: 100% !important;
                height: 100%!important;
                color: orange !important;
                display: none !important;
       }      
       table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled{
           background-position: left !important;
           background-size: 25px !important;
       }
       .table-scroll {max-height: 63vh !important;}
       .table-scroll tr td:first-child {position: -webkit-sticky;position: sticky;left: 0;}
</style>

<div id="main-wrapper" class="" style="    margin-left: 15px;margin-right: 15px">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
			<div class="col-md-12">
            
               <div class="mailbox-content" style="overflow-x:auto">
               <?php echo @$this->session->flashdata('message'); ?>
                <?php echo @$msg; ?>
                <!--<div class="row mb20">
                    <div class="col-md-12">                        
                        <div class="row">
                            <div class="form-group">
                                <form action="" method="post">
                                    <div style="margin-top:6px;" class="col-sm-1"><label for="email">Search :</label></div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="Search by Name,Email"  name="txt_keyword" id="txt_keyword" value="<?php if(isset($keyword)){echo $keyword; }?>">
                                    </div>                      
                                    <div class="col-sm-4">
                                        <input type="submit" id="btn_search" value="Search" class="btn btn-success" />
                                        <a href="<?php //echo base_url('staffexport') ?>"  class="btn btn-success">Export CSV</a>
                                    </div>
                                </form>                        
                            </div>                    
                        </div> 
                    </div>
                </div>-->
                <div class="table-scroll">
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                            <th> Action </th>
                            <th> Status</th>
                            <?php if ($hide_field_array["employee_code"] != 'hide') { ?> <th><?php echo $business_attributes[165]["display_name"];?></th> <?php } ?>
                            <?php if ($hide_field_array["email"] != 'hide') { ?> <th><?php echo $business_attributes[1]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["business_level_3"] != 'hide') { ?> <th><?php echo $business_attributes[6]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["function"] != 'hide') { ?> <th><?php echo $business_attributes[7]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["designation"] != 'hide') { ?> <th><?php echo $business_attributes[9]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["grade"] != 'hide') { ?> <th><?php echo $business_attributes[10]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["level"] != 'hide') { ?> <th><?php echo $business_attributes[11]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["increment_purpose_joining_date"] != 'hide') { ?> <th><?php echo $business_attributes[17]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["rating_for_current_year"] != 'hide') { ?> <th><?php echo $business_attributes[23]["display_name"]; ?></th> <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">
                    </tbody>
                </table>
                </div>
            </div>
        </div>
</div>
</div>
  <script>
  $( function() {    
    $( "#txt_keyword" ).autocomplete({
        minLength: 2,
        method: "POST",
        source: '<?php echo site_url("admin/admin_dashboard/autocomplete_email"); ?>',
        select: function(event, ui) {

     }
    });
  } );
  </script>
  <?php createDataTable(
                        $tableid='example',
                        $isSearch=true,
                        $searchingindexarr=array(0,3,4,5,6,7,8,9,10,11),
                        $removesortingarr=array(0),
                        $ajaxurl=base_url('admin/admin_dashboard/ajax_emp_not_in_bonus_rule_list/'.$performance_cycle_id),
                        $href=[
                                [
                                    "javascript"=>'',
                                    "url"=>base_url().'view-employee/',
                                    "end"=>"id",
                                    "customparams"=>"",
                                    "label"=>"name",
                                    "where"=>"3"  
                                ],
                                [
                                    
                                    "javascript"=>'onclick="return confirm('.$st="'Are you sure, You want to change status?'".')"',
                                    "url"=>base_url().'change-employee-status/',
                                    "end"=>"id",
                                    "customparams"=>"0/".$this->uri->segment(1),
                                    "label"=>"status",
                                    "where"=>"2"
                                ],
                                [
                                    
                                   [
                                        "javascript"=>'',
                                        "url"=>base_url().'edit-employee/',
                                        "end"=>"id",
                                        "customparams"=>"",
                                        "label"=>"Edit",
                                        "where"=>"1"
                                   ],
                                    [
                                        "javascript"=>'',
                                        "url"=>base_url().'delete-employee/',
                                        "end"=>"id",
                                        "customparams"=>$this->uri->segment(1),
                                        "label"=>"Delete",
                                        "where"=>"1"
                                   ]
                                ],
                            ],
                            false,
                            $hide_field_array
                    ); ?>
<style>
  .dataTables_wrapper .dataTables_paginate .paginate_button:hover{color:#000 !important;}
</style>