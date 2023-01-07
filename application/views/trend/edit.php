<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="javascript:void(0)">Connect & Learn</a></li>
        <li class="active">Trends Edit </li>
    </ol>
</div>
<div id="main-wrapper" class="container">
    <div class="row">
    <div class="col-md-12">
      	<div class="panel panel-white">
		  <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
		   <form class="frm_cstm_popup_cls_trend" method="post" action="<?php echo base_url('trend/edit/'.$trend['TrendID']); ?>" enctype='multipart/form-data' onsubmit="return request_custom_confirm('frm_cstm_popup_cls_trend')"> 
		   <?php echo HLP_get_crsf_field();?>	
			<div class="panel-body">
				
					<div class="form-group">
						<label class="wht_lvl" for="Title" >Title</label>
						
							<input type="text" name="Title" value="<?php echo ($this->input->post('Title') ? $this->input->post('Title') : $trend['Title']); ?>" class="form-control" id="Title" required="" maxlength="150" />
						
					</div>
                                        <div class="form-group">
						<label class="wht_lvl" for="Description" >Description</label>
						
							<textarea name="Description" class="form-control" id="Description" required="" maxlength="500"><?php echo ($this->input->post('Description') ? $this->input->post('Description') : $trend['Description']); ?></textarea>
						
					</div>
					<div class="form-group">
						<label class="wht_lvl" for="Document" >Document</label>
						
							<input type="file" name="Document" value="<?php echo ($this->input->post('Document') ? $this->input->post('Document') : $trend['Document']); ?>" class="form-control" id="Document" accept="image/*,application/pdf" data-filetype="jpg,jpeg,png,gif,pdf" />
						
					</div>
					
				<button type="submit" class="btn btn-success pull-right">
					<i class="fa fa-check"></i> Update
				</button>
			</div>
		  </form>				
		</div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/custom.js"); ?>"></script>