
<style>
    .table tr td span{
        color: #676767 !important;
    }
</style>
<div class="page-breadcrumb ">
  <div class="container">
   <div class="row">
    <div class="col-md-4">
        <ol class="breadcrumb wn_btn">
             <li class="active">Employee salary Graph</li>
        </ol>
    </div>
    <div class="col-md-8 text-right">
        <a <?php echo @$clsshide ?> href="<?php echo base_url('admin/admin_dashboard/employee_graph_filters') ?>" class="btn btn-success">Add</a>
    </div>
  </div>
</div>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    
    <div class="col-md-12 ">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            <?php //echo '<pre />'; print_r($templatedesc); ?>
            <div class="panel-body">
                  <?php if(count($survey)!=0) { ?>
                <table class="table border" id="glossary">
                    <thead>
                    <th>Left Half</th>
                    <th>Right Half</th>
                    <!--<th>Action</th>-->
                    </thead>
                    <tbody>
                        <?php foreach ($survey as $g){ ?> 
                        <tr>
                            <td>
                                <?php 
                                $left = json_decode($g['left_half']);
                                if (json_last_error() === 0) {
                                    // Is valid json
                                    echo $left->top_left.'<br />';
                                    echo $left->center_left.'<br />';
                                    echo $left->bottom_left;
                                } else {
                                    echo $g['left_half'];
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $right = json_decode($g['right_half']);
                                if (json_last_error() === 0) {
                                    // Is valid json
                                    echo $right->top_right.'<br />';
                                    echo $right->center_right.'<br />';
                                    echo $right->bottom_right;
                                } else {
                                    echo $g['right_half'];
                                }
                                ?>
                            </td>
                            <?php /*                            
                            <td>
                                <a  href="<?php echo base_url('admin/admin_dashboard/employee_graph_create/'.$g['esg_id']) ?>">Edit</a> 
                            </td> */?>
                        </tr>
                            
                            <?php } ?>
                    </tbody>
                </table>
                 <?php } else {echo 'Data not found';} ?>
            </div>

             

        </div>
    </div>

</div>
</div>
