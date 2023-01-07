<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active"><?php echo @$breadcrumb ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <div class="row">
        <div class="col-md-3">
           <div class="mailbox-content">
                <div class="form-group">
                    <?php
           
                    if($report_for=='base_salary')
                    {
                        $l1='selected';
                    }
                    if($report_for=='target_salary')
                    {
                        $l2='selected';
                    }
                    if($report_for=='total_salary')
                    {
                        $l3='selected';
                    }

                    ?>
                    <label style="color: #000 !important">Select Type</label>
                    <select class="form-control" id="reporttype" onchange="redirect(this.value)">
                     <option value="base_salary" <?php echo $l1 ?>>Base Salary</option>
                     <option value="target_salary" <?php echo $l2 ?>>Target Salary</option>
                     <option value="total_salary" <?php echo $l3 ?>>Total</option>
                     </select>
                 </div>
            </div>
        </div>

</div>
   
<div class="row">
    <div class="col-md-12 " id="responsedata" style="    padding-bottom: 60px;">
        <div class="table-responsive">
             <?php // echo '<pre />'; print_r($staff); ?>
    <table class="table table-bordered" id="rtt">
            <thead>
            <?php foreach($staff as $val)
            {
                foreach($val as $key=>$val) {
                ?>
                <th><?php echo str_replace('_',' ',$key) ?></th>
            <?php } 
                break;
                } ?>
                </thead>
                <tbody>
                    <?php 
                    foreach($staff as $stf) { 
                        echo '<tr>';
                        foreach($stf as $k=>$v) {?>
                        
                            <td><?php echo $stf[$k] ?></td>
                        
                    <?php  } echo '</tr>'; } ?>
                </tbody>
            
        </table>
        </div>
       
    </div>
</div>

</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" ></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" ></script>

                
<script>
function getType(val)
{
    $('#loading').show();
    $.ajax({
    type : "GET",
    url : "<?php echo base_url('report/payRangeAjax/') ?>"+val,
    //data : {reportfor:$('#reporttype').val()},
        success : function(result) {
       $('#responsedata').html(result);
       $('#loading').hide();
    }
});
}
$(function() {
  //$("#reporttype").trigger( "onchange" );
});

function redirect(val)
{
        urll='<?php echo base_url() ?>report/payRange/'+val;
        window.location.href =urll;
}
$(document).ready(function() {
     $('#rtt').DataTable({ 
            "ordering": false,
             dom: 'Bfrtip',
             buttons: [
            'csvHtml5'
           
        ]
    });
} );
</script>
