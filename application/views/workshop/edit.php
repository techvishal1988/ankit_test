<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="javascript:void(0)">Connect & Learn</a></li>
    <li class="active">Workshop Edit</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-white">
        <div class="box-header with-border">
          <h3 class="box-title w_hit_col" >Workshop Edit</h3>
        </div>
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
	
 <form class="frm_cstm_popup_cls_workshop" method="post" action="<?php echo base_url('workshop/edit/'.$workshop['WorkshopID']); ?>" enctype='multipart/form-data' onsubmit="return request_custom_confirm('frm_cstm_popup_cls_workshop')">
      <?php echo HLP_get_crsf_field();?>
        <div class="panel-body">
          <div class="form-group">
            <label for="Title" class="wht_lvl" >Title</label>
            <input type="text" name="Title" value="<?php echo ($this->input->post('Title') ? $this->input->post('Title') : $workshop['Title']); ?>" class="form-control" id="Title" required maxlength="150" />
          </div>
          <div class="form-group">
            <label for="date" class="wht_lvl">Date</label>
            <input type="text" id="date" name="date" value="<?php if($this->input->post('date')){echo $this->input->post('date');}elseif($workshop['date'] != "0000-00-00"){ echo date('d/m/Y', strtotime($workshop['date']));} ?>" class="form-control" required maxlength="10" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/>
          </div>
          <div class="form-group">
            <label for="location" class="wht_lvl" >Location</label>
            <input type="text" name="location" value="<?php echo ($this->input->post('location') ? $this->input->post('location') : $workshop['location']); ?>" class="form-control" id="location" required maxlength="100" />
          </div>
          <div class="form-group">
            <label for="location" class="wht_lvl" >Type</label>
            <select class="form-control" name="workshop_type" required>
              <option value="Conferences">Conference </option>
              <option value="Event" <?php if($this->input->post('workshop_type')=="Event"){echo "selected='selected'";}elseif($workshop['workshop_type']=="Event"){echo "selected='selected'";} ?>>Event </option>
            </select>
          </div>
          <div class="form-group">
            <label for="organised_by" class="wht_lvl">Organised By</label>
            <input type="text" name="organised_by" value="<?php echo ($this->input->post('organised_by') ? $this->input->post('organised_by') : $workshop['organised_by']); ?>" class="form-control" id="organised_by" required maxlength="50" />
          </div>
          <div class="form-group">
            <label for="website" class="wht_lvl" >Website</label>
            <input type="text" name="website" value="<?php echo ($this->input->post('website') ? $this->input->post('website') : $workshop['website']); ?>" class="form-control" id="website" required maxlength="100" />
          </div>
          <div class="form-group">
            <label for="Document" class="wht_lvl" >Document</label>
            <input type="file" name="Document" class="form-control" id="Document" accept="image/*,application/pdf" data-filetype="jpg,jpeg,png,gif,pdf" />
          </div>
          <div class="form-group">
            <label for="Description" class="wht_lvl" >Description</label>
            <div class="form-group">
              <textarea name="Description" class="form-control" id="Description" required maxlength="500"><?php echo ($this->input->post('Description') ? $this->input->post('Description') : $workshop['Description']); ?></textarea>
            </div>
          </div>
          
          <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-check"></i> Update </button>
        </div>
       </form>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url("assets/js/custom.js"); ?>"></script>
<script>
$(document).ready(function()
{
    $( "#date" ).datepicker({ 
    dateFormat: 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
       // yearRange: "1995:new Date().getFullYear()",
     });      
 });
</script>