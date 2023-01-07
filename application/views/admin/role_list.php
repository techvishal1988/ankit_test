<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li>General Settings</li>
        <li class="active">Role Permission</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
	<div class="col-md-7  col-md-offset-2 background-cls">
       <div class="mailbox-content">
           <?php echo $this->session->flashdata('message'); ?>
           <?php echo $msg;?>
        
            <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
            <thead>
                <tr>
                    <th class="hidden-xs" width="5%">Sr.No</th>
                    <th>Name</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbl_body">                   
             <?php $i=0;
             $tooltip=getToolTip('role-permission');$val=json_decode($tooltip[0]->step);
             $view_role = json_decode(CV_VIEW_ROLE_ARRAY);
             foreach($roles as $row)
             {
                 if($row['id']!=6){
                    echo "<tr><td class='hidden-xs'>". ($i + 1) ."</td>";
                    echo '<td>'.$row["name"].' <span style=" float: none;" type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="'. $val[$i].'" data-original-title=""><i class="fa fa-info-circle" aria-hidden="true"></i></span></td>';
                    echo '<td>
                                <a title="Role Permissions" href="'.site_url("view-role-permissions/".$row["id"]).'">Role Permissions</a>&nbsp;|&nbsp;';

                            if(in_array($row["id"],$view_role)) {
                                echo '<a title="Role Permissions" href="'.site_url("add-hr/".$row["id"]).'">Add Employee Role</a>&nbsp;|&nbsp;
                                <a title="Role Permissions" href="'.site_url("view-user-right-details/".$row["id"]).'">View users</a>';
                            }    
                                
                    echo    '</td>';	
                    echo "</tr>";                        
                     $i++;}
               } ?>                     
            </tbody>
           </table>                    
        </div>
    </div>
</div>
</div>