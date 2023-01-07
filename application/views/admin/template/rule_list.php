<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <?php if(($this->session->userdata('role_ses')==10 )) { ?>
              
            <li><a href="<?php echo base_url('manager/self') ?>"> My Self </a></li>    
            <?php } else { ?>
            <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
            <?php } ?>
        <!--<li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>-->
        <li class="active"><?php echo @$b_title; ?></li>
        
    </ol>    
</div>

<div id="main-wrapper" class="container">
<div class="col-md-12 background-cls">
   <div class="mailbox-content">
<?php //echo '<pre />'; print_r($bonus);
     
      if(count($salary_rule_list)==0 && count($bonus)==0 && count($lti)==0)
      {
          echo '<p> Data not found.</p>';
      }
     
      ?>
       <?php if(count($salary_rule_list)>0) { ?>
   	<table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th width="70%">Salary Rule Name</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body">                   
         <?php 
                $i=1; 
                foreach($salary_rule_list as $rule)
                {

                  $conditions=" rule_id='".$rule['id']."' and (letter_status=2 or letter_status=3) and user_id='".$this->session->userdata('userid_ses')."' ";
                 $letter_status=$this->admin_model->get_table_row("employee_salary_details", 'user_id,letter_path',$conditions);  

                 ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo ucfirst($rule['salary_rule_name']); ?></td>
                        
                        <?php /*?><td><a href="<?php echo base_url('admin/template/view_letter/'.$rule['id'].'/'.$rule['performance_cycle_id'].'/'.$rule['template_id'].'/'.$this->session->userdata('userid_ses')) ?>">View letter</a></td><?php */?>
                        <td>
                            <?php if(!empty($letter_status)){
                            $url=base64_encode($rule['id'].'/'.$this->session->userdata('userid_ses'));
                             ?>
                            <a target="_blank" href="<?php echo base_url('admin/template/view_letter/'.$url) ?>">View letter</a><?php }else{ echo 'Letter not release yet.'; } ?></td>
                    </tr>
            
                <?php $i++; }
                ?>
           
               
            
        </tbody>
       </table> 
        <?php } ?>
        <?php if(count($bonus)>0) { ?>
       <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th width="70%">Bonus Rule Name</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body">                   
         <?php 
                $i=1; 
                foreach($bonus as $rule)
                { ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $rule['bonus_rule_name'] ?></td>
                        
                        <td><a href="<?php echo base_url('admin/template/view_letter_bonus/'.$rule['id'].'/'.$this->session->userdata('userid_ses')) ?>">View letter</a></td>
                    </tr>
            
                <?php $i++; }
                ?>
           
               
            
        </tbody>
       </table> 
        <?php } ?>
       <?php if(count($lti)>0) { ?>
       
       <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th width="70%">Lti Rule Name</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body">                   
         <?php 
                $i=1; 
                foreach($lti as $rule)
                { ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $rule['rule_name'] ?></td>
                        
                        <!--<td><a href="<?php //echo base_url('admin/template/view_letter/'.$rule['id'].'/'.$this->session->userdata('userid_ses')) ?>">View letter</a></td>-->
                        <td><a href="javascript:void(0)" onclick="custom_alert_popup('Coming soon')">View letter</a></td>
                    </tr>
            
                <?php $i++; }
                ?>
           
               
            
        </tbody>
       </table> 
       <?php } ?>
       
                         
    </div>
</div>
</div>
