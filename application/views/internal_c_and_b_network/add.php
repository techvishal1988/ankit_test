<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="javascript:void(0)">Connect & Learn</a></li>
    <li class="active">C & B Network Add</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-white"> 
	  	<?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
		<!-- <?php //echo form_open_multipart('cbnetwork/add','onsubmit="return request_confirm()"'); ?> -->
    <?php echo form_open_multipart('cbnetwork/add'); ?>
        <div class="panel-body">
          <div class="form-group">
            <label class="wht_lvl" for="Name">Name</label>
            <input type="text" name="Name" value="<?php echo $this->input->post('Name'); ?>" class="form-control" id="Name" required maxlength="50" />
          </div>
          <!--                                        <div class="form-group">
						<label for="Name" style="color:#000 !important">Type</label>
						
                                                <select class="form-control" >
                                                    <option value="Event">Event</option>
                                                    <option value="Conference">Conference</option>
                                                </select>
						
					</div>-->
          <div class="form-group">
            <label class="wht_lvl" for="Contact" >Contact</label>
            <input type="text" name="Contact" value="<?php echo $this->input->post('Contact'); ?>" class="form-control" id="Contact" required  maxlength="10" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"/>
          </div>
          <div class="form-group">
            <label class="wht_lvl" for="Email"  >Email</label>
            <input type="email" name="Email" value="<?php echo $this->input->post('Email'); ?>" class="form-control" id="Email" required  maxlength="30"/>
          </div>
          <div class="form-group">
            <label class="wht_lvl" for="Title" >Title</label>
            <input type="text" name="Title" value="<?php echo $this->input->post('Title'); ?>" class="form-control" id="Title" required  maxlength="150"/>
          </div>
          <div class="form-group">
            <label class="wht_lvl" for="Company" >Company</label>
            <input type="text" name="Company" value="<?php echo $this->input->post('Company'); ?>" class="form-control" id="Company" required maxlength="100"/>
          </div>
          <div class="form-group">
            <label class="wht_lvl" for="Industry" >Industry</label>
            <input type="text" name="Industry" value="<?php echo $this->input->post('Industry'); ?>" class="form-control" id="Industry" required maxlength="100"/>
          </div>
          <div class="form-group">
            <label class="wht_lvl" for="Country" >Country</label>
            <input type="text" name="Country" value="<?php echo $this->input->post('Country'); ?>" class="form-control" id="Country" required maxlength="50"/>
          </div>
          <!--                    <div class="form-group">
						<label style="color:#000 !important" for="Document" >Document</label>
						
                                                <input name="Document" type="file" class="form-control" id="Document"required />
						
					</div>-->
          
          <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-check"></i> Save </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
