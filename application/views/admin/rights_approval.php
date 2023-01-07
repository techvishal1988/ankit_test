<style>
.list_confict{width:100%; display:block; padding:0px 15px;}
.list_confict .hr_nm{}
.list_confict .hr_nm h3{}
.list_confict .hr_nm span{ color:#666; font-weight:normal;}
.list_confict .total_em{}
.list_confict .total_em h3{}
.list_confict .total_em span{color:#666; font-weight:normal;}
.list_confict .list_em{}

.mailbox-content tbody tr td .checkbox{margin:0px;}
.mailbox-content tbody tr td .checkbox label{padding-left:11px;}
.overrt_btn{ text-align:right; display:block; width:100%; padding-right:20px;}
.overrt_btn .btn-primary{ background-color:#00adef;}
</style>




<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Right Approval</li>
    </ol>
</div>
<!-- <div class="page-title">
<div class="container">
    <h3>Staff List</h3>
</div>
</div> -->

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="list_confict">
	<div class="row">
    	<div class="col-sm-3">
        	<div class="hr_nm">
            <h3>HR Name :<span>&nbsp;&nbsp;<?php if($right_dtls){echo $right_dtls[0]["user_name"];} ?></span></h3>
            </div>
        </div>
        <div class="col-sm-7">
        	<div class="total_em">
            <h3>Total Employee :<span>&nbsp;&nbsp;<?php echo count($employees); ?></span></h3>
            </div>
        </div>
    </div>
    <?php 
    $total_confilict_users = 0;
	if(count($employees) > 0)
	{
		foreach($employees as $row)
		{
			if($row["hr_user_id"]){ $total_confilict_users++; } 
		}
	}
	elseif(!$msg)
	{
		$msg = "<div align='left' style='color:red;' id='notify'><span><b>You have no employee as per created rights.</b></span></div>";
	}
	 			 
	if($total_confilict_users){?>	
    <div class="row">
      <div class="col-sm-4">
    	<div class="list_em">
        <h3>List of Conflict Employee</h3>
        </div>
     </div>  
    </div>
     <?php } ?>   
</div>
<form class="form-horizontal" method="post" action="">
<div class="row mb20">
	<div class="col-md-12">
       <div class="mailbox-content">
       <?php echo $this->session->flashdata('message'); 
             echo $msg;			 
		if($total_confilict_users){			
			?>        
        <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
            <thead>
                <tr>
                    <th class="hidden-xs" width="5%"><div class="checkbox"><label>All<input type="checkbox" name="chk_all" checked="checked" value="1"></label></div></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Business Unit</th>
                    <th>Designation</th>
                    <th>Grade</th>
                   <!--  <th> Old HR Name </th> -->
                </tr>
            </thead>
            <tbody>
            <?php foreach($employees as $row){?>
            <?php if($row["hr_user_id"]){ ?>
            <tr>
            <td> <div class="checkbox"><label><input type="checkbox" name="chk_emp[]" checked="checked" value="<?php echo $row["id"]; ?>"></label></div></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["country"]; ?></td>
            <td><?php echo $row["city"]; ?></td>
            <td><?php echo $row["bussiness_unit"]; ?></td>
            <td><?php echo $row["desig"]; ?></td>
            <td><?php echo $row["grade"]; ?></td>
            <!-- <td><?php //echo $row["name"]; ?></td> -->
            </tr>                   
            <?php }} ?>
             
            </tbody>
           </table> 
           <?php } ?>                   
        </div>
    </div>
</div>

<div class="row">
	<div class="col-sm-12">
    	<div class="overrt_btn">
        <?php if($employees){?>
         <input type="hidden" name="hf_total_confilict_users" value="<?php echo $total_confilict_users; ?>" />
        	<button type="submit" class="btn btn-primary">
			<?php if($total_confilict_users){echo "Over write with selectecd Employee";} else{echo "Approve";}?>
            
            </button>
            <?php } ?>
        </div>
    </div>
</div>
</form>
</div>
