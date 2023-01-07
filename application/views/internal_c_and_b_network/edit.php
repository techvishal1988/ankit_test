<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li><a href="javascript:void(0)">Connect & Learn</a></li>
    <li class="active">C & B Network Edit</li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-white"> 
	  <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
     <form class="frm_cstm_popup_cls_cbnetwork" method="post" action="<?php echo base_url('cbnetwork/edit/'.$internal_c_and_b_network['internalCBID']); ?>" enctype='multipart/form-data' onsubmit="return request_custom_confirm('frm_cstm_popup_cls_cbnetwork')"> 
       <?php echo HLP_get_crsf_field();?>
        <div class="panel-body">
          <div class="form-group">
            <label for="Name" class="wht_lvl">Name</label>
            <input type="text" name="Name" value="<?php echo ($this->input->post('Name') ? $this->input->post('Name') : $internal_c_and_b_network['Name']); ?>" class="form-control" id="Name" required maxlength="50"/>
          </div>
          
          <div class="form-group">
            <label for="Contact" class="wht_lvl">Contact</label>
            <input type="text" name="Contact" value="<?php echo ($this->input->post('Contact') ? $this->input->post('Contact') : $internal_c_and_b_network['Contact']); ?>" class="form-control" id="Contact" required maxlength="10" onKeyUp="validate_onkeyup_num(this);" onBlur="validate_onblure_num(this);"/>
          </div>
          <div class="form-group">
            <label for="Email" class="wht_lvl" >Email</label>
            <input type="email" name="Email" value="<?php echo ($this->input->post('Email') ? $this->input->post('Email') : $internal_c_and_b_network['Email']); ?>" class="form-control" id="Email" required maxlength="30"/>
          </div>
          <div class="form-group">
            <label for="Title" class="wht_lvl">Title</label>
            <input type="text" name="Title" value="<?php echo ($this->input->post('Title') ? $this->input->post('Title') : $internal_c_and_b_network['Title']); ?>" class="form-control" id="Title" required maxlength="150"/>
          </div>
          <div class="form-group">
            <label for="Company" class="wht_lvl" >Company</label>
            <input type="text" name="Company" value="<?php echo ($this->input->post('Company') ? $this->input->post('Company') : $internal_c_and_b_network['Company']); ?>" class="form-control" id="Company" required maxlength="100"/>
          </div>
          <div class="form-group">
            <label for="Industry" class="wht_lvl" >Industry</label>
            <input type="text" name="Industry" value="<?php echo ($this->input->post('Industry') ? $this->input->post('Industry') : $internal_c_and_b_network['Industry']); ?>" class="form-control" id="Industry" required maxlength="100"/>
          </div>
          <div class="form-group">
            <label for="Country" class="wht_lvl">Country</label>
            <input type="text" name="Country" value="<?php echo ($this->input->post('Country') ? $this->input->post('Country') : $internal_c_and_b_network['Country']); ?>" class="form-control" id="Country" required maxlength="50"/>
          </div>
         
          
          <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-check"></i> Update </button>
        </div>
      </form>
     </div>
    </div>
  </div>
</div>
