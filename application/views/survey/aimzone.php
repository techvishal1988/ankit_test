<div class="page-breadcrumb">
  <div class="container">
   <div class="row">
    <div class="col-md-8">
        <ol class="breadcrumb wn_btn">
            <li><a href="<?= base_url('survey');?>">Survey</a></li>
            <li class="active">Action Planning Zone</li>
        </ol>
    </div>
      <div class="col-md-4 text-right">
        <div class="pull-right">
            <a href="<?php echo site_url("survey/aim-zone-details"); ?>"><button class="btn btn-success" type="button">Create New</button></a>
        </div>
      </div>
     </div>
    </div>
</div>
<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-12">
      <div class="mailbox-content pad_b_10">
      <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?> 
        <div class="survey_table">
          <?php if(isset($aimlist)&&!empty($aimlist)){?>
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="text-left" style="text-align:left !important; width:60px;" scope="col">S. No.</th>
                      <th class="text-left" style="text-align:left !important;" scope="col">Survey Name</th>
                      <th scope="col">Action Plan Owner</th>
                      <th scope="col">Starting Date</th>
                      <th scope="col">Status</th>
                      <th scope="col" style="width:150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=0; foreach ($aimlist as $key => $val) {  $i++;?>
                      <tr>
                        <td class="text-left" scope="row"><?php echo $i; ?></td>
                        <td class="text-left text-blue"><?php echo $val['survey_name']; ?></td>
                        <td class="text-center"><?php echo (!empty($val['name'])) ?$val['name']:$val['email']; ?></td>
                        <td class="text-center"><?php echo HLP_DateConversion($val['createdon'],'','d-m-Y H:i'); ?></td>
                        <td class="text-center"><?php echo (($val['status']) == CV_STATUS_ACTIVE) ?"Active":"In-Active"; ?></td>
                        <td class="text-center">
                            <a title="Edit" href="<?php echo base_url('survey/aim-zone-details/edit/').$val['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <span>|</span>
                            <a title="View" href="<?php echo base_url('survey/aim-zone-details/view/').$val['id'];?>"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table> 
            </div>
          <?php } else{ echo " No Record Found "; } ?>
        </div>
      </div>
    </div>
</div>
</div>
              


