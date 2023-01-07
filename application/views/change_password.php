<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li>General Settings</li>
     <li class="active">Change Password</li>

  </ol>
</div>
<div id="main-wrapper" class="container change-pass">  
  <div class="row mb20">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-white"> 
	  	<?php echo $this->session->flashdata('message'); ?>
        <?php if($msg or validation_errors()) { ?>
             <div class="alert alert-danger">
                <?php if($msg){echo $msg ."<br/>"; } echo validation_errors();?>
            </div>
        <?php } ?>
        <div class="panel-body">
          <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
          	<?php echo HLP_get_crsf_field();?>
            <div class="form-group my-form">
              <label for="inputEmail3" class="col-sm-3 control-label removed_padding">Old Password</label>
              <div class="col-sm-9 form-input input-group removed_padding">
              	<input type="password" class="form-control" name="old_password" value="" maxlength="20" required id="oldpass">
                <span class="input-group-btn">
                  <button toggle="#oldpass" class="btn btn_white btn-default toggle-password" type="button"><i class="fa fa-fw fa-eye"></i></button>
                </span>
              </div>
            </div>
            <div class="form-group my-form">
              <label for="inputPassword3" class="col-sm-3 control-label removed_padding">New Password</label>
              <div class="col-sm-9 form-input input-group removed_padding">
                <input type="password" class="form-control" name="new_password" id="new_password" value="" maxlength="20" required onblur="validate();">
                <span class="input-group-btn">
                  <button toggle="#new_password" class="btn btn_white btn-default toggle-password" type="button"><i class="fa fa-fw fa-eye"></i></button>
                </span>
              </div>
            </div>
            <div class="form-group my-form">
              <label for="inputPassword3" class="col-sm-3 control-label removed_padding">Confirm Password</label>
              <div class="col-sm-9 form-input input-group removed_padding">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" maxlength="20" required onblur="validate();">
                <span class="input-group-btn">
                  <button toggle="#confirm_password" class="btn btn_white btn-default toggle-password" type="button"><i class="fa fa-fw fa-eye"></i></button>
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 text-right mob-center">
                <input type="submit" id="btnAdd" value="Update" class="btn btn-success" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .btn_white {
      background-color: #ffffff !important;
  }
  .input-group .btn {
    padding: 5px 12px;
}
</style>
<script>
function validate()
{
	var new_password = $('#new_password').val();
	var confirm_password = $('#confirm_password').val();
	if(confirm_password=='' || new_password == '')
	{	return;		}
	
	var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!~#%*?&])[A-Za-z\d$@$!~#%*?&]{8,}/;
    if(!pattern.test(new_password))
	{
		custom_alert_popup('Password must contain at least 8 characters including \n one uppercase letter, one lowercase letter, one number and one special character.');
        $('#new_password').val('');
		return;
    }
		
	if(new_password != confirm_password)
	{
		custom_alert_popup('New password and confirm password are not same.');
		$('#confirm_password').val('')	
	}
}

</script>