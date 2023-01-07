<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        
        <li class="active">Notifications</li>

    </ol>    
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="col-md-12 background-cls">
   <div class="mailbox-content">
<?php $notifications = help_get_notifications(array("to_user_id"=>$this->session->userdata('userid_ses'), "is_readed"=>0)); ?>
   	
       <?php if(count($notifications)==0) { echo "<span style='color:#fff;'>No record found.</span>"; } else { ?> 
        <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th>Notification</th>
                <th>Message</th>
                
            </tr>
        </thead>
        <tbody id="tbl_body">                   
             <?php $i=1;
             foreach($notifications as $n)
             { ?>
            <tr>
                <td><?php echo $i ?></td>
                <td>
                    <?php echo $n['notification_for'] ?>
                </td>
                 <td>
                    <?php echo $n['message'] ?>
                </td>
                
            </tr>
            <?php $i++; }
             
             ?>               
        </tbody>
       </table> 
       <?php } ?>
    
       
   	
                                     
    </div>
</div>
</div>

