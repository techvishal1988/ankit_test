<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active"><?php echo (isset($title)) ? $title : 'Manage'; ?></lti>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <div class="row mb20">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-white">
                <?php echo $this->session->flashdata('message'); ?>  
                <div class="panel-body">
                    <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                        <?php echo HLP_get_crsf_field(); ?>
                        <div class="tenure_classi">
                            <div class="col-sm-12">    
                                <div class="form-group rv1 input_fields_container" style="margin-bottom:0px !important;" >
                                    <?php
                                    if ($list) {
                                        $i = 1;
                                        foreach ($list as $listrow) {
                                            if ($listrow['slot_no'] != "" && $listrow['end_month'] != 1000) {
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <input type="text" name="txt_slot[]" class="form-control" id="txt_slot<?php echo $i; ?>"  value="<?php echo $listrow['slot_no'] ?>" placeholder="Slot Name" required="required" maxlength="50">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="txt_start[]" class="form-control" id="txt_start<?php echo $i; ?>" value="<?php echo $listrow['start_month'] ?>" readonly="" placeholder="Range Start" required="required" maxlength="3" onKeyUp="validate_onkeyup_num(this, 3);" onBlur="validate_onblure_num(this, 3);">
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="txt_end[]" class="form-control" id="txt_end<?php echo $i; ?>" value="<?php echo $listrow['end_month'] ?>" placeholder="Range End" required="required" maxlength="3" onKeyUp="validate_onkeyup_num(this, 3);  put_start_val(<?php echo $i; ?>);"  onBlur="validate_onblure_num(this, 3);">
                                                    </div>
                                                    <div class="col-sm-1"><button type="button" class="btn btn-danger remove_field" >Delete</button></div>
                                                    <div class="col-sm-3" style="display:none;">
                                                   <a href="<?php echo site_url("min-pay-capp/" . $listrow["id"]); ?>"><button type="button" class="btn btn-danger" >Set Min Salary Band Wise</button></a>
                                                    </div>

                                                </div>



                                                <?php
                                            }else{
                                               $i--; 
                                            } $i++;
                                        }
                                        $k = $i - 1;
                                    } else {
                                        $k = 1;
                                        ?>


                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="text" name="txt_slot[]" class="form-control" id="txt_slot1"  placeholder="Slot Name" required="required" maxlength="50">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="txt_start[]" class="form-control" id="txt_start1" value="<?php
                                                if ($listrow['end_month']) {
                                                    echo $listrow['end_month'];
                                                } else {
                                                    echo 0;
                                                }
                                                ?>" readonly="" placeholder="Range Start" required="required" maxlength="3" onKeyUp="validate_onkeyup_num(this, 3);" onBlur="validate_onblure_num(this, 3);">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" name="txt_end[]" class="form-control" id="txt_end1" placeholder="Range End" required="required" maxlength="3" onKeyUp="validate_onkeyup_num(this, 3); put_start_val(1);"  onBlur="validate_onblure_num(this, 3);">
                                            </div>
                                            <div class="col-sm-3"></div>
                                        </div>
<?php } ?>
                                </div>

                                <div class="row" >
                                    <div class="pull-right" style="margin-right:52px;">
                                        <input  style="margin-left:10px;" type="submit" id="btnAdd" value="Save" class="btn btn-success pull-right" />
                                        <a class="btn btn-success add_more_row pull-right">Add Tenure</a>
                                    </div>   
                                </div>
                            </div>
                        </div> 
                        <!-- <div class="row">
                            <div class="col-sm-12 text-right">
                              <input type="submit" id="btnAdd" value="Save" class="btn btn-success" />
                            </div>
                        </div> -->
                    </form>
                </div>             

            </div>
        </div>

    </div>
    
    <div class="row mb20">
        <div class="col-md-8 col-md-offset-2 background-cls">
            <div class="mailbox-content">
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Name</th>
                            <th>Start Year</th>
                            <th>End Year</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                        <?php
                        $i = 0;
                        foreach ($list as $row) {
                            echo "<td class='hidden-xs'>" . ($i + 1) . "</td>";
                            echo "<td>" . $row["slot_no"] . "</td>";
                            echo "<td>" . $row["start_month"] . "</td>";
							if ($row['end_month'] != 1000) {
								echo "<td>" .  $row["end_month"] . "</td>";
							}
							else
							{
								echo "<td></td>";
							}

							echo "<td class='text-center'>";	
								//echo '<a href="' . site_url($url_key . "/" . $row["id"]) . '"><span class="fa fa-edit"></span></a>';
								 ?>
								<a href="<?php echo site_url("min-pay-capp/" . $row["id"]); ?>">Set Minimum Salary Band Wise</a>
							<?php echo "</td>";
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
<style type="text/css">
    .tenure_classi{display: block; width: 100%;}
    .tenure_classi input{margin-bottom: 10px;}  
    .tenure_classi input.btn{margin-bottom: 0px;}
</style>
<script>
    $(document).ready(function () {
        var max_fields_limit = 100;
        var x = '<?php echo $k; ?>';

        $('.add_more_row').click(function (e) {

            e.preventDefault();
            if (x < max_fields_limit) {
                //alert(x);
                var endval = $("#txt_end" + (x)).val();

                x++;
                $('.input_fields_container').append('<div class="row"><div class="col-sm-3"><input type="text" name="txt_slot[]" class="form-control" id="txt_slot' + x + '"  placeholder="Slot Name" required="required" maxlength="50"></div><div class="col-sm-2"><input type="text" name="txt_start[]" class="form-control" id="txt_start' + x + '" value="" readonly="" placeholder="Range Start" required="required" maxlength="3" onKeyUp="validate_onkeyup_num(this,3);" onBlur="validate_onblure_num(this,3);"></div><div class="col-sm-2"><input type="text" name="txt_end[]" class="form-control" id="txt_end' + x + '" value=""  placeholder="Range End" required="required" maxlength="3" onKeyUp="validate_onkeyup_num(this,3); put_start_val(' + x + ');" onBlur="validate_onblure_num(this,3);"></div> <div class="col-sm-1" ><button type="button" class="btn btn-danger remove_field" >Delete</button></div>');
                $("#txt_start" + x).val(endval);
            }
        });
        $('.input_fields_container').on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).closest(".row").remove();
            x--;
        })

    });
    function put_start_val(key) {

        $("#txt_start" + (key + 1)).val($("#txt_end" + (key)).val());
    }
</script>