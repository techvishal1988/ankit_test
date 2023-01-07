<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="javascript:void(0)">Connect & Learn</a></li>
    <li class="active">Workshop Add</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-white"> 
	  <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
    <?php echo form_open_multipart('workshop/add'); ?>
        <div class="panel-body">
          <div class="form-group">
            <label for="Title" class="wht_lvl">Title</label>
            <input type="text" name="Title" value="<?php echo $this->input->post('Title'); ?>" class="form-control" id="Title" required maxlength="150"/>
          </div>
          <div class="form-group">
            <label for="date" class="wht_lvl" >Date</label>
            <input type="text" name="date" id="date" value="<?php echo $this->input->post('date'); ?>" class="form-control" required  maxlength="10" autocomplete="off" onkeypress="return false;" onblur="checkDateFormat(this)"/>
          </div>
          <div class="form-group">
            <label for="location"  class="wht_lvl" >Location</label>
            <input type="text" name="location" value="<?php echo $this->input->post('location'); ?>" class="form-control" id="location" required maxlength="100"/>
          </div>
          <div class="form-group">
            <label for="location"  class="wht_lvl" >Type</label>
            <select class="form-control" name="workshop_type" required>
              <option value="Conferences">Conference </option>
              <option value="Event">Event </option>
            </select>
          </div>
          <div class="form-group">
            <label for="organised_by"  class="wht_lvl" >Organised By</label>
            <input type="text" name="organised_by" value="<?php echo $this->input->post('organised_by'); ?>" class="form-control" id="organised_by" required  maxlength="50"/>
          </div>
          <div class="form-group">
            <label for="website"  class="wht_lvl" >Website</label>
            <input type="url" name="website" value="<?php echo $this->input->post('website'); ?>" class="form-control" id="website" required  maxlength="100"  />
          </div>
          <div class="form-group">
            <label for="Document"  class="wht_lvl" >Document</label>
            <input type="file" name="Document" class="form-control" id="Document" required accept="image/*,application/pdf" data-filetype="jpg,jpeg,png,gif,pdf" />
          </div>
          <div class="form-group">
            <label for="Description"  class="wht_lvl" >Description</label>
            <textarea name="Description" class="form-control" id="Description" required  maxlength="500"><?php echo $this->input->post('Description'); ?></textarea>
          </div>
          <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-check"></i> Save </button>
        </div>
        <?php echo form_close(); ?> </div>
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

     $('input[type="url"]').on('blur', function(){
        var string = $(this).val();
        if (!string.match(/^https?:/) && string.length) {
          string = "http://" + string;
          $(this).val(string)
        }
      });
 });
 
</script>