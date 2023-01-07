<div class="page-breadcrumb">
  <div class="container-fluid compp_fluid">
    <div class="row">
      <div class="col-sm-8 padl0">
      <ol class="breadcrumb">
          <li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>
          <li class="active"><?php echo $b_title; ?></li>
      </ol>
      </div>
      <div class="col-sm-4"></div>    
   </div>
  </div>
</div>

<div id="main-wrapper" class="container-fluid compp_fluid">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="col-md-12 background-cls">
   <div class="mailbox-content">
    <?php echo $this->session->flashdata('message');
      echo $msg;
     $is_show_null_record_msg = 1;
     if(isset($rule_list)){ $is_show_null_record_msg = 0; ?>
       <div class="panel-group" id="accordion">
           <?php foreach($rule_list as $k => $rl) {  ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k+1; ?>" class="panel-title expand" style="color:#4E5E6A !important;cursor: pointer;width: 100%;">
                     <div class="right-arrow pull-right">+</div>
                    <a href="#"><?php echo $rl['name'],' - '.$rl['sip_rule_name'] ?></a>
                    
                  </h4>
                    <a style="    float: right; right: 56px; position: absolute;margin-top: -3px;" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rl['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
                </div>
                <div id="collapse<?php echo $k+1; ?>" class="panel-collapse collapse">
                    
                    <?php echo $this->session->flashdata('message'); 
					$data["rule_dtls"] = $rl;
					$data["staff_list"] = $rl["staff_list"];
                    $this->load->view('sip/sip_rules_emp_list_table',$data); ?>
               
              </div>
            </div>
           
           <?php } ?>
    <?php } ?>  
    <?php  if(isset($rule_list_released)) { $is_show_null_record_msg = 0; ?>
       <h3>Released rule(s) - Final employee list</h3>
           <?php foreach($rule_list_released as $Kl => $rlr) {  ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapsee<?php echo $Kl+1; ?>" class="panel-title expand" style="color:#4E5E6A !important;cursor: pointer;width: 100%;">
                     <div class="right-arrow pull-right">+</div>
                    <a href="#"><?php echo $rlr['name'],' - '.$rlr['sip_rule_name'] ?></a>
                    
                  </h4>
                    <a style="    float: right; right: 56px; position: absolute;margin-top: -3px;" data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rlr['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
                </div>
                <div id="collapsee<?php echo $Kl+1; ?>" class="panel-collapse collapse">

                    <?php echo $this->session->flashdata('message'); 
                    $data["rule_dtls"] = $rlr;
					$data["staff_list"] = $rlr["staff_list"];
                    $this->load->view('sip/sip_rules_emp_list_table',$data); ?>
               
                </div>
            </div>
           
           <?php } ?>
       </div>
    <?php } ?>  

        
    <?php if($is_show_null_record_msg)
	{
		echo "<p>".$this->lang->line('msg_no_record_found')."</p>";
	}?>  
    </div>
</div>
</div>
<script>
$(function()
{
  $(".expand").on( "click", function()
  {
    $expand = $(this).find(">:first-child");
    var expand = $expand.text();
    $(".expand").find(">:first-child").text("+");
    if(expand != "-")
      $expand.text("-");
  });
});
</script>