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
                <div class="panel-body">
                    <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                        <?php echo HLP_get_crsf_field(); ?>
                        <div class="form-group my-form">
                            <label for="inputEmail3" class="col-sm-3 col-xs-3  control-label removed_padding">Name</label>
                            <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                <input id="txt_name" name="txt_name" type="text" class="form-control" required="required" maxlength="50" placeholder="Name" <?php if(isset($detail)){?> value="<?php echo $detail["name"]; ?>" <?php } ?>>
                            </div>
                        </div>   
                       <div class="form-group my-form">
                            <label for="inputEmail3" class="col-sm-3 col-xs-3  control-label removed_padding">%age</label>
                            <div class="col-sm-9 col-xs-9 form-input removed_padding">
                                <input id="txt_per" name="txt_per" type="text" class="form-control" required="required"  onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);"    placeholder="%age" <?php if(isset($detail)){?> value="<?php echo $detail["per_val"]; ?>" <?php } ?>>
                            </div>
                        </div>
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
                            </div>
                        </div> 

                    </form>
                </div>             

            </div>
        </div>

    </div>

    <div class="row mb20">
        <div class="col-md-12 background-cls">
            <div class="mailbox-content">
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <!--<th class="hidden-xs" width="4%"><input type="checkbox" class="check-mail-all"></th>-->
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Name</th>
                            <th>%age</th>
                         
                             <th>Status</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                        <?php
                        $i = 0;
                        foreach ($list as $row) {
                            echo "<td class='hidden-xs'>" . ($i + 1) . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                             $status_image = "<td class='text-center' title='Inactive'><img src='".base_url("assets/images/inactive.png")."' alt='' /></td>";
                        if($row["status"] == 1)
                        {
                            $status_image = "<td class='text-center' title='Active'><img src='".base_url("assets/images/active.png ")."' alt='' /></td>";
                        }
                            echo "<td>" . $row["per_val"] . "</td>";
                          
                             echo $status_image; 

                        $status_image = "<img src='".base_url("assets/images/inactive.png")."' alt='' />";
                        if($row["status"] == 1)
                        {
                            $status_image = "<img src='".base_url("assets/images/active.png ")."' alt='' />";
                        }
                            echo "<td class='text-center'>";

                            echo '<a href="' . site_url($url_key . "/" . $row["id"]) . '"><span class="fa fa-edit"></span></a>';

                            echo "</td>";
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
