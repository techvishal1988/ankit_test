<div class="page-breadcrumb">
    <ol class="breadcrumb container">
<!--        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>
        <li class="active"><?php echo $b_title; ?></li>
        
    </ol>    
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="col-md-12 background-cls">
   <div class="mailbox-content">
<?php echo $this->session->flashdata('message');
      echo $msg;
     
//      echo '<pre />';
//      print_r($salary_rule_list_released);
	 $is_show_null_record_msg = 1;
     if(isset($rule_list)){ $is_show_null_record_msg = 0; ?>
       <div class="panel-group" id="accordion">
           <?php foreach($rule_list as $k => $rl) {  ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1; ?>" class="panel-title expand" style="color:#4E5E6A !important; width:100%; cursor: pointer;">
                     <div class="right-arrow pull-right">+</div>
                    <a style="text-decoration:none;" href="#"><?php echo $rl['name'],' - '.$rl['rule_name'] ?></a>
                    
                  </h4>
                    <a style="    float: right; right: 55px; position: absolute;margin-top: -5px;" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rl['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
                </div>
                <div id="collapse<?php echo $k+1; ?>" class="panel-collapse collapse">
                    
                    <?php echo $this->session->flashdata('message'); 
                    $this->load->view('view_lti_incentive_list_table', $rl); ?>
               
              </div>
            </div>
           
           <?php } ?>
    <?php } ?> 
     
    <?php  if(isset($rule_list_released)) { $is_show_null_record_msg = 0; ?>
       <h3 class="secd_cont">Released LTI rule(s)</h3>
           <?php foreach($rule_list_released as $Kl => $rlr) {  ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapsee<?php echo $Kl+1; ?>" class="panel-title expand" style="color:#4E5E6A !important; width:100%;cursor: pointer;">
                     <div class="right-arrow pull-right">+</div>
                    <a style="text-decoration:none;" href="#"><?php echo $rlr['name'],' - '.$rlr['rule_name'] ?></a>
                    
                  </h4>
                    <a style="float: right; right: 55px; position: absolute;margin-top: -5px;" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rlr['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
                </div>
                <div id="collapsee<?php echo $Kl+1; ?>" class="panel-collapse collapse">

                    <?php echo $this->session->flashdata('message'); 
                    $this->load->view('view_lti_incentive_list_table', $rlr); ?>
               
                </div>
            </div>
           
           <?php } ?>
       </div>
    <?php } ?>
     
    <?php 
	if($is_show_null_record_msg)
	{
		echo "<p>".$this->lang->line('msg_no_record_found')."</p>";	
	}?>     
    </div>
</div>
</div>

<script>
$(function() {
  $(".expand").on( "click", function() {
    // $(this).next().slideToggle(200);
    $expand = $(this).find(">:first-child");
    var expand = $expand.text();
    $(".expand").find(">:first-child").text("+");
    if(expand != "-")
      $expand.text("-");
  });
});
</script>
