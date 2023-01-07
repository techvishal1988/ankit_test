<div class="page-breadcrumb">
<div class="row">
<div class="col-sm-4 col-xs-12">
    <ol class="breadcrumb wn_btn">
        <!--<li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li class="active">
         <?php if($this->uri->segment(1)=="hr-list"){echo "HR";}else{echo "Employee";}?>
         List</li>
    </ol>
    </div>
    <?php
            if(helper_have_rights(CV_STAFF_ID, CV_INSERT_RIGHT_NAME))
		{
        ?>
    <div class="col-sm-8 col-xs-12 mob_left text-right">
        <?php if($this->uri->segment(1)=="hr-list"){?>
            <a class="btn btn-success btn-w120"  href="<?php echo base_url("add-hr"); ?>">Add HR</a>
        <?php }else{?>
            <a class="btn btn-success btn-w120"  href="<?php echo base_url("add-staff"); ?>">Add Employee</a>
            &nbsp;<a href="<?php echo base_url('staffexport') ?>"  class="btn btn-success">Download Data</a>
            &nbsp;<a class="btn btn-success btn-w120"  href="<?php echo base_url("upload-data"); ?>">Upload Data</a>
            &nbsp;<a class="btn btn-success btn-w120"  href="<?php echo base_url("bulk-delete"); ?>">Bulk Delete</a>
            &nbsp;<a class="btn btn-success btn-w120"  href="<?php echo base_url("bulk-active"); ?>">Bulk Active</a>
            &nbsp;<a class="btn btn-success btn-w120"  href="<?php echo base_url("bulk-inactive"); ?>">Bulk Inactive</a>
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

   table.dataTable thead .sorting,table.dataTable thead .sorting_asc,table.dataTable thead .sorting_desc {
            background-position: left !important;
            background-position-x: 0px !important;
           /* background-position-y: 59px !important;*/
            background-size: 25px !important;
   }
   .sorting{
       width: 130px !important;
   }

    /*.breadcrumb{
            padding: 8px 0px !important;
    }*/
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


	   /*shumsul*/

/*new css add by pramod*/

 /* .mailbox-content .table-scroll.heightfrtbl{background-color: #f9f9f9 !important; max-height: 63vh !important;}
	  #example_length{
    text-align:left !important;
    width: 100%;
    background-color: #f9f9f9;
    padding: 5px 0px 0px 5px;
    border-bottom: 1px solid #ddd;
	  }

    .dataTables_wrapper{background-color:#f9f9f9;}

    .dataTables_wrapper .dataTables_length label{color: #000 !important;}

    .mailbox-content .dataTables_wrapper .dataTables_info{padding: 15px 10px 10px 10px; color: #000 !important; }

    .mailbox-content .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {margin-left: 10px; border: 1px solid #000;color: #000 !important;}
    .mailbox-content .dataTables_wrapper .dataTables_paginate .paginate_button{color: #000!important;}
    .mailbox-content .dataTables_wrapper .dataTables_paginate .paginate_button.next {border: 1px solid #000;}

     .mailbox-content .dataTables_wrapper .dataTables_paginate .paginate_button.current,  .mailbox-content .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #000 !important;
    border: 1px solid #000 !important;}

    .mailbox-content .dataTables_wrapper .dataTables_paginate .paginate_button:hover{color: #000 !important;}
    .mailbox-content .dataTables_wrapper .dataTables_paginate{padding: 10px !important;}*/
    .table-scroll {max-height: 63vh !important;}
    .myclsemp{padding:0px 0px 10px 0px !important; }
    .table-scroll tr td:first-child {position: -webkit-sticky;position: sticky;left: 0;}
    #main-wrapper{margin-bottom: 0px;}
</style>

<div id="main-wrapper" style="margin-left: 15px;margin-right: 15px; margin-top: 10px;">
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">-->
<div class="row">
			<div class="col-md-12">
               <div class="mailbox-content" style="overflow-x:auto">
                   <div class="myclsemp nobg">
               <?php echo $this->session->flashdata('message'); ?>
                <?php echo $msg; ?>
                <!--<div class="row mb20">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <form action="" method="post">
                                    <div style="margin-top:6px;" class="col-sm-1"><label for="email">Search :</label></div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="Search by Name,Email"  name="txt_keyword" id="txt_keyword" value="<?php //if(isset($keyword)){echo $keyword; }?>">
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
              <div class="table-scroll ">
                <table id="example" class="table border" style="width: 100%; ">
                    <thead>
                        <tr>
                            <th><?php echo $business_attributes[0]["display_name"]; ?></th>
                            <th> Action </th>
                            <th> Status </th>
                            <?php if ($hide_field_array["employee_code"] != 'hide') { ?> <th><?php echo $business_attributes[165]["display_name"];?></th> <?php } ?>
                            <?php if ($hide_field_array["email"] != 'hide') { ?> <th><?php echo $business_attributes[1]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["country"] != 'hide') { ?> <th><?php echo $business_attributes[2]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["city"] != 'hide') { ?> <th><?php echo $business_attributes[3]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["business_level_1"] != 'hide') { ?> <th><?php echo $business_attributes[4]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["business_level_2"] != 'hide') { ?> <th><?php echo $business_attributes[5]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["business_level_3"] != 'hide') { ?> <th><?php echo $business_attributes[6]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["function"] != 'hide') { ?> <th><?php echo $business_attributes[7]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["subfunction"] != 'hide') { ?> <th><?php echo $business_attributes[8]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["designation"] != 'hide') { ?> <th><?php echo $business_attributes[9]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["grade"] != 'hide') { ?> <th><?php echo $business_attributes[10]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["level"] != 'hide') { ?> <th><?php echo $business_attributes[11]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["company_joining_date"] != 'hide') { ?> <th><?php echo $business_attributes[16]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["increment_purpose_joining_date"] != 'hide') { ?> <th><?php echo $business_attributes[17]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["rating_for_current_year"] != 'hide') { ?> <th><?php echo $business_attributes[23]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["currency"] != 'hide') { ?> <th><?php echo $business_attributes[34]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["current_base_salary"] != 'hide') { ?> <th><?php echo $business_attributes[35]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["current_target_bonus"] != 'hide') { ?> <th><?php echo $business_attributes[36]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["total_compensation"] != 'hide') { ?> <th><?php echo $business_attributes[47]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["approver_1"] != 'hide') { ?> <th><?php echo $business_attributes[63]["display_name"]; ?></th> <?php } ?>
                            <?php if ($hide_field_array["manager_name"] != 'hide') { ?> <th><?php echo $business_attributes[67]["display_name"]; ?></th> <?php } ?>
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
</div>
<div style="height: 10px;"></div>
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
                        $searchingindexarr=array(0,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
                        $removesortingarr=array(0),
                        $ajaxurl=base_url('/ajaxemplist'),
                        $href=[
                                [
                                    "javascript"=>'',
                                    "url"=>base_url().'view-employee/',
                                    "end"=>"id",
                                    "customparams"=>"",
                                    "label"=>"name",
                                    "where"=>"0"
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
                                        "javascript"=>'onclick="return confirm('.$rv="'Are you sure?'".')"',
                                        "url"=>base_url().'delete-employee/',
                                        "end"=>"id",
                                        "customparams"=>$this->uri->segment(1),
                                        "label"=>"Delete",
                                        "where"=>"1"
                                   ]

                                ],


                            ],
                            true,
                            $hide_field_array
                    ); ?>
<!--<style>
  .dataTables_wrapper .dataTables_paginate .paginate_button:hover{color:#000 !important;}
</style>-->
