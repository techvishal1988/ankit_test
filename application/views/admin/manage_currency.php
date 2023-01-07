<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active">Manage Currency</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message');
        if(helper_have_rights(CV_MANAGE_CURRENCY, CV_INSERT_RIGHT_NAME))
		{ ?>      
            <div class="panel-body">
                <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action=""  onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
                	<?php echo HLP_get_crsf_field();?>
                    <div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 col-xs-3 control-label removed_padding">Name</label>
                        <div class="col-sm-9 col-xs-9 form-input removed_padding">
                            <input id="txt_display_name" name="txt_display_name" type="text" class="form-control" required="required" maxlength="50" <?php if(isset($currency_dtl)){?> value="<?php echo $currency_dtl["display_name"]; ?>" <?php } ?> >
                        </div>
                    </div>   
                    
                    <div class="form-group my-form">
                        <label for="inputEmail3" class="col-sm-3 col-xs-3 control-label removed_padding">Code</label>
                        <div class="col-sm-9 col-xs-9 form-input removed_padding">
                            <input id="txt_name" name="txt_name" type="text" class="form-control" required="required" maxlength="5" <?php if(isset($currency_dtl)){?> value="<?php echo $currency_dtl["name"]; ?>" <?php } ?> >
                        </div>
                    </div>                   

                    <div class="form-group my-form">
                        <label for="inputPassword3" class="col-sm-3 col-xs-3 control-label removed_padding">Status</label>
                        <div class="col-sm-9 col-xs-9 form-input removed_padding">
                            <select id="ddl_status" name="ddl_status" class="js-states form-control" tabindex="-1" style=" width: 100%">
                                <option  value="1" <?php if(isset($currency_dtl) and $currency_dtl["status"]==1){?> selected="selected" <?php } ?> >Active</option>
                                <option value="0" <?php if(isset($currency_dtl) and $currency_dtl["status"]==0){?> selected="selected" <?php } ?>>Inactive</option>
                            </select>
                        </div>
                    </div>                           
                    
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <?php if(isset($currency_dtl)){?>
                            <input type="submit" id="btnAdd" value="Update" class="btn btn-success" />
                            <?php }else{ ?>
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
               <div class="mailbox-content">
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <!--<th class="hidden-xs" width="4%"><input type="checkbox" class="check-mail-all"></th>-->
                            <th class="hidden-xs" width="5%">S.No</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=0;
                     foreach($currencys_list as $row)
                     {
                        echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                        echo "<td>".$row["display_name"]."</td>";
						echo "<td>".$row["name"]."</td>";
                        $status_image = "<td title='Inactive'><img src='".base_url("assets/images/inactive.png")."' alt='' /></td>";
                        if($row["status"] == 1)
                        {
                            $status_image = "<td title='Active'><img src='".base_url("assets/images/active.png ")."' alt='' /></td>";
                        }
                        echo $status_image; 

                        echo "<td>";      
                        if(helper_have_rights(CV_MANAGE_CURRENCY, CV_INSERT_RIGHT_NAME))
                        {
                            echo '<a href="'.site_url("manage-currency/".$row["id"]).'"><span class="fa fa-edit"></span></a>';                       
                        }
                        else
                        {
                            echo 'No Rights';
                        }
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
