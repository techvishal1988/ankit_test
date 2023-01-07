<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active"><?php echo (isset($title)) ? $title : 'Manage'; ?></lti>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
    <div class="row mb20">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-white">
                <?php echo $this->session->flashdata('message'); ?>    
                <?php
                if (helper_have_rights(CV_CITY_ID, CV_INSERT_RIGHT_NAME)) {
                    ?>
                    <div class="panel-body">
                        <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">

                            <?php echo HLP_get_crsf_field(); ?>
                            <div class="form-group my-form">
                                <label for="inputEmail3" class="col-sm-3 col-xs-3  control-label removed_padding">Name</label>
                                <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                    <input id="txt_name" name="txt_name" type="text" class="form-control" required="required" maxlength="50" <?php if (isset($detail)) { ?> value="<?php echo $detail["name"]; ?>" <?php } ?> >
                                </div>
                            </div>   

                            <?php if (isset($url_key) and $url_key == "manage-city") { ?>
                                <div class="form-group my-form">
                                    <label for="inputPassword3" class="col-sm-3 col-xs-3 control-label removed_padding">Tier</label>
                                    <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                        <select id="ddl_tier" name="ddl_tier" class="js-states form-control" tabindex="-1" style=" width: 100%">
                                            <option value="">Select</option>
                                            <?php foreach ($tier_list as $trow) { ?>
                                                <option value="<?php echo $trow['id'] ?>" <?php if (isset($detail) and $detail["tier_id"] == $trow['id']) { ?> selected="selected" <?php } ?>><?php echo $trow['name'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>  
                            <?php } ?>  
                            <?php if (isset($url_key) and ($url_key == "manage-business-level-1" or $url_key == "manage-business-level-2" or $url_key == "manage-business-level-3" or $url_key == "manage-ratings")) { ?>
                                <div class="form-group my-form">
                                    <label for="inputEmail3" class="col-sm-3 col-xs-3  control-label removed_padding">Order</label>
                                    <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                        <input id="txt_order" name="txt_order" type="text" class="form-control" onkeyup="validate_onkeyup_num(this);" onblur="validate_onblure_num(this);" required="required" maxlength="2" <?php if (isset($detail)) { ?> value="<?php echo $detail["order_no"]; ?>" <?php } ?> >
                                    </div>
                                </div> 
                            <?php } ?>
                            <?php if (isset($url_key) and $url_key == "manage-functions" OR $url_key == "manage-sub-functions") { 
                                if (isset($detail)) { 
                                    $useremail = get_user_email($detail["owner_id"]);
                                }
                                ?>
                                <div class="form-group my-form">
                                    <label for="inputEmail3" class="col-sm-3 col-xs-3  control-label removed_padding">Owner</label>
                                    <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                        <input id="txt_owner_id" name="txt_owner_id" type="text" class="form-control" required="required" maxlength="100" <?php if (isset($detail)) { ?> value="<?php echo $useremail; ?>" <?php } ?>  >
                                    </div>
                                </div> 
                            <?php } ?>

                            <div class="form-group my-form">
                                <label for="inputPassword3" class="col-sm-3 col-xs-3 control-label removed_padding">Status</label>
                                <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                    <select id="ddl_status" name="ddl_status" class="js-states form-control" tabindex="-1" style=" width: 100%">
                                        <option  value="1" <?php if (isset($detail) and $detail["status"] == 1) { ?> selected="selected" <?php } ?> >Active</option>
                                        <option value="0" <?php if (isset($detail) and $detail["status"] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>                           

                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <?php if (isset($detail)) { ?>
                                        <input type="submit" id="btnAdd" value="Update" class="btn btn-success" />
                                    <?php } else { ?>
                                        <input type="submit" id="btnAdd" value="Add" class="btn btn-success" />
                                    <?php } ?>
                                    <!--<button class="btn btn-success">Cancel</button>-->
                                </div>
                            </div>
                        </form>
                    </div>             
                <?php } ?>
            </div>
        </div>

    </div>

    <div class="row mb20">
        <div class="col-md-12 background-cls">
        <?php if (isset($url_key) and $url_key == "manage-city") { ?>
                <div class="mailbox-content">
                    <div class="upload_div managecity">
                        <form class="frm_cstm_popup_cls_manage_city"  method="post" autocomplete="off" action="<?php echo site_url("upload-city-data/"); ?>" enctype="multipart/form-data" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_manage_city')">
                            <?php echo HLP_get_crsf_field(); ?>

                            <div class="upload_file">
                                <input type="file" name="myfile" id="myfile" class="form-control" title="Choose a file csv to upload" required accept="application/msexcel*">
                            </div>
                            <div class="upload_btn">
                                <input type="submit" name="uploadfile" value="Upload File" class="btn btn-success">
                            </div>
                            <div class="download_btn">
                                <a href="<?php echo base_url('download-city-sample-file/'); ?>" class="downloadcsv"><input type="button" value="Download File Format" class="btn btn-success"></a>
                            </div>
                        </form> 
                    </div>
                </div>
            <?php } ?>
            <div class="mailbox-content">
                <table id="example" class="table  border editorder" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Name</th>
                            <?php if (isset($url_key) and $url_key == "manage-city") { ?>                                
                                 <th>Tier</th>
                            <?php } ?>
                            <?php if (isset($url_key) and ($url_key == "manage-grade" or $url_key == "manage-business-level-1" or $url_key == "manage-business-level-2" or $url_key == "manage-business-level-3" or $url_key == "manage-ratings" or $url_key == "designation"  or $url_key == "manage-level")) { ?>
                                <th>Order</th>
                            <?php } ?>
                                 <?php if (isset($url_key) and $url_key == "manage-functions" OR $url_key == "manage-sub-functions") { ?>
                                <th>Owner</th>
                            <?php } ?>
                            <th>Status</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body" <?php if(isset($url_key)  && ($url_key == "manage-grade" or $url_key == "designation" or $url_key == "manage-level")) { ?> class="swap" <?php }?>>
                        <?php
                        $i = 0;
                        foreach ($list as $row) { ?>

                            <?php if(isset($url_key)  && ($url_key == "manage-grade" or $url_key == "designation" or $url_key == "manage-level")) {//currently use for manage-grade, designation, manage-level ?>

                                <tr class="ui-state-default myClass" data="<?=$row['id']?>" order="<?=$row['order_no']?>">

                            <?php } else if (isset($url_key) and ($url_key == "manage-business-level-1" or $url_key == "manage-business-level-2" or $url_key == "manage-business-level-3" or $url_key == "manage-ratings")) { ?>

                                <tr>

                            <?php } ?>

                           <?php echo "<td class='hidden-xs'><strong>" . ($i + 1) . "</strong></td>";
                                 echo "<td><strong>" . $row["name"] . "</strong></td>";

                            $status_image = "<td class='text-center' title='Inactive'><img src='" . base_url("assets/images/inactive.png") . "' alt='' /></td>";
                            if ($row["status"] == 1) {
                                $status_image = "<td class='text-center' title='Active'><img src='" . base_url("assets/images/active.png ") . "' alt='' /></td>";
                            }

                            if (isset($url_key) and $url_key == "manage-city") {                                
                                if ($row["tier_name"] != "" and $row["tier_name"] != "0") {
                                    echo "<td>" . $row["tier_name"] . "</td>";
                                } else {
                                    echo "<td></td>";
                                }
                            }

                            if(isset($url_key)  && ($url_key == "manage-grade" or $url_key == "designation" or $url_key == "manage-level")) {//currently use for manage-grade, designation

                                echo '<td class="order"><strong>'. $row["order_no"] .'</strong></td>';

                            } else if (isset($url_key) and ($url_key == "manage-business-level-1" or $url_key == "manage-business-level-2" or $url_key == "manage-business-level-3" or $url_key == "manage-ratings")) {

                                echo '<td class="order"><input type="hidden" data-id="' . $row["id"] . '" value="' . $row["order_no"] . '"/><input onblur="updateOrder(this);" onKeyUp="validate_onkeyup_num(this);" maxlength="2" type="text" value="' . $row["order_no"] . '"/><span class="fa fa-edit" onclick="focusOn(this);"></span></td>';

                            }

                            if (isset($url_key) and $url_key == "manage-functions" OR $url_key == "manage-sub-functions") {
                                 
                                
                                if ($row["owner_id"] != "" and $row["owner_id"] != "0") {
                                    $useremail = get_user_email($row["owner_id"]);
                                    echo "<td>" . $useremail . "</td>";
                                } else {
                                    echo "<td></td>";
                                }
                            }

                            echo $status_image;

                            $status_image = "<img src='" . base_url("assets/images/inactive.png") . "' alt='' />";
                            if ($row["status"] == 1) {
                                $status_image = "<img src='" . base_url("assets/images/active.png ") . "' alt='' />";
                            }
                            echo "<td class='text-center'>";
                            if (helper_have_rights(CV_CITY_ID, CV_INSERT_RIGHT_NAME)) {
                                echo '<a href="' . site_url($url_key . "/" . $row["id"]) . '"><span class="fa fa-edit"></span></a>';
                            }
                            echo "</td>";
                            echo "</tr>";
                            $i++; ?>

                            </tr>

                        <?php }
                        ?>  

                    </tbody>
                </table>                    
            </div>
        </div>
    </div>
</div>
<script>
 var csrf_token_val = '<?php echo $this->security->get_csrf_hash(); ?>';

  $( function() {
    $( "#txt_owner_id" ).autocomplete({
        minLength: 2,        
        source: "<?php echo base_url("admin/admin_dashboard/autocomplete_email_for_approver"); ?>",
        select: function(event, ui) {

     }
    });
  } );


  <?php if (isset($url_key) and ($url_key == "manage-grade" or $url_key == "manage-business-level-1" or $url_key == "manage-business-level-2" or $url_key == "manage-business-level-3" or $url_key == "manage-ratings" or $url_key == "designation"  or $url_key == "manage-level")) { ?>

    function focusOn(ths) {
        $(ths).closest("td").find("input[type=text]").focus();
    }

    function updateOrder(ths) {
        var csrf_val = $('input[name=csrf_test_name]'),
                coltd = $(ths).closest("td"),
                prethis = coltd.find("input[type=hidden]"),
                currthis = coltd.find("input[type=text]"),
                preval = (prethis.val() != '') ? prethis.val() : '0',
                id = prethis.data('id');

        var currval = (currthis.val() != '') ? currthis.val() : '0';
        if (preval != currval) {
            $('#loading').show();
            $.ajax({
                url: "<?php echo site_url($url_key); ?>",
                type: 'POST',
                data: {id: id, txt_order: currval, csrf_test_name: csrf_val.val()}
            }).done(function (data) {
                try {
                    var res = JSON.parse(data);
                    if (res.status) {
                        prethis.val(res.value);
                        currthis.val(res.value);
                        csrf_val.val(res.csrf);
                    }
                } catch (e) {
                }
                $('#loading').hide();
            }).fail(function () {
                $('#loading').hide();
            });
        }
    }

    function swap() {
        var csrf_val = $('input[name="<?php echo $this->security->get_csrf_token_name(); ?>"]').val();
        var id=[];
        var data = [];
        $(".myClass").each(function(){
            id.push($(this).attr('data'));
        });
        $("#loading").show();
        var url = "<?php echo site_url($url_key); ?>";
        $.ajax({
            type:"post",
            url: url,
            data:{dataArr:id, csrf_test_name:csrf_val},
                success: function(result)
            {
               location.reload();
               $("#loading").hide();
            }
        });
    }

    $( function() {

        //for designation, grade, level
        $( ".swap" ).sortable({
            items: "tr:not(.ui-state-disabled)",
            update: function( event, ui ) { swap(); }
        });

    });

<?php } ?>
  </script>