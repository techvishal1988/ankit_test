<style>
.table{
	background-color:#fff;
}
</style>
<div class="page-breadcrumb">
<div class="container-fluid compp_fluid">
 <div class="row">
  <div class="col-md-8 padl0">
    <ol class="breadcrumb wn_btn">
      <?php 
        //echo $this->session->userdata('role_ses');
        if($this->session->userdata('is_manager_ses') == 1 and isset($is_open_frm_manager_side))
        {
            $first='<li><a href="'.base_url("manager/myteam").'">My Team</a></li>';
            $style='style="display:none"';
            $url=base_url("manager/dashboard/bonus_rules");
            $caption='Bonus rule list';
           
        }
        else {
            $style='';
            $url=base_url("bonus-rule-list/".$rule_dtls['performance_cycle_id']);
            $caption='Rule List';
            $first='<li><a href="'.base_url("performance-cycle").'">'.$this->lang->line('plan_name_txt').'</a></li>';
        }
        
        ?>
      <?php echo @$first ?>
      <li><a href="<?php echo $url; ?>"><?php echo $caption ?></a></li>
      <li class="active">Increment Calculation</li>
    </ol>
  </div>
  <div class="col-md-4 text-right padr0" <?php echo $style ?>> <a class="btn btn-success" href="<?php echo base_url('increments/exportemplistbonus/'.@$rule_dtls["id"]) ?>">Download Data</a> </div>
  </div>
 </div>
</div>
<div id="main-wrapper" class="container-fluid compp_fluid">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <div class="row mb20 padl0 padr0">
    <div class="col-md-12">
    	<?php /*?><p>Plan Name : <b><?php echo $rule_dtls["name"]; ?></b></p>
        <p>Rule Name : <b><?php echo $rule_dtls["bonus_rule_name"]; ?>
        	| <a data-toggle="tooltip" data-original-title="Print Rule" data-placement="bottom" target="_blank" href="<?php echo base_url('printpreview-bonus/'.$rule_dtls['id']) ?>"><i class="fa fa-info-circle" aria-hidden="true" style="color:#FF6600"></i></a>
        </b></p><?php */?>
      <div class="panel panel-white"> 
        <?php echo $this->session->flashdata('message');
              $this->load->view('manager/bonus_rule_list_table', $rlr); ?>
      </div>
    </div>
  </div>
</div>
<script>
function show_remark_dv(obj)
{
	$("#dv_remark_"+obj).show();
	$("#btn_reject_"+obj).hide();
}

function hide_remark_dv(obj)
{
	$("#dv_remark_"+obj).hide();
	$("#btn_reject_"+obj).show();
}
</script>