<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="javascript:void(0)">Connect & Learn</a></li>
        <li class="active">Trends Add </li>
    </ol>
</div>
<div id="main-wrapper" class="container"><div class="row">
    <div class="col-md-12">
      	<div class="panel panel-white">
		   <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
             <?php echo form_open_multipart('trend/add'); ?> 
          	<div class="panel-body">
          		
					<div class="form-group">
						<label for="Title" class="wht_lvl">Title</label>
						
                                                <input type="text" name="Title" value="<?php echo $this->input->post('Title'); ?>" class="form-control" id="Title" required="" maxlength="150" />
						
					</div>
					<div class="form-group">
						<label for="Document" class="wht_lvl">Document</label>
						
							<input type="file" name="Document" class="form-control" id="Document" required accept="image/*,application/pdf" data-filetype="jpg,jpeg,png,gif,pdf"/>
						
					</div>
					<div class="form-group">
						<label for="Description" class="wht_lvl">Description</label>
						
							<textarea name="Description" class="form-control" id="Description" required="" maxlength="500"><?php echo $this->input->post('Description'); ?></textarea>
						
					</div>
                    <button type="submit" class="btn btn-success pull-right">
            		<i class="fa fa-check"></i> Save
            	</button>
				</div>
			
          	
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>
</div>
<script src="<?php echo base_url("assets/js/custom.js"); ?>"></script>