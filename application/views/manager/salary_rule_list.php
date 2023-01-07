<div class="page-breadcrumb">
    <ol class="breadcrumb container">
<!--        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>-->
        <li><a href="<?php echo base_url("manager/myteam"); ?>">My Team</a></li>
        <li class="active"><?php echo $b_title; ?></li>
        
    </ol>    
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="col-md-12">
   <div class="mailbox-content">
<?php echo $this->session->flashdata('message');
      echo $msg;
     
     // echo '<pre />';
     // print_r($salary_rule_list);
     if(isset($salary_rule_list)){ ?>
   	<table id="example" class="table border" style="width: 100%; cellspacing: 0;">
        <thead>
            <tr>                            
                <th class="hidden-xs" width="5%">S.No</th>
                <th>Plan Name</th>
                <th>Rule Name</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody id="tbl_body">                   
         <?php 
                $i=1; 
//                echo '<pre />';
//                print_r($salary_rule_list);
                foreach($salary_rule_list as $rule)
                { ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $rule['name'] ?></td>
                        <td>
                            <?php 
                            if(isset($rule['salary_rule_name']))
                                {
                                    echo $rule['salary_rule_name'];
                                    $urlparam=$rule['id'];
                                
                                }
                                else if(isset($rule['bonus_rule_name']))
                                {
                                    echo $rule['bonus_rule_name'];
                                    $emplist=getBonusEmp($rule['id']);
                                    $urlparam=$emplist[0]['rule_id'].'/'.$emplist[0]['id'].'/'.$emplist[0]['upload_id'];
                                    
                                }
                               else if(isset($rule['name']))
                                {
                                    echo $rule['name'];
                                    $emplist=gerLitEmp($rule['id']);
                                    $urlparam=$emplist[0]['rule_id'].'/'.$emplist[0]['id'].'/'.$emplist[0]['upload_id'];
                                    //$urlparam=$rule['id'];
                                
                                }
                        
                        ?></td>
                        <td>
                            <a href="<?php echo base_url('manager/'.$url.'/'.$urlparam) ?>"><?php echo $label ?></a>
                            
                            | <a data-toggle="tooltip" data-original-title="Print rule" data-placement="bottom" target="_blank" href="<?php echo base_url($print_url.'/'.$rule['id']) ?>"><i class="fa fa-print themeclr" aria-hidden="true"></i></a>
                            
                        </td>
                    </tr>
            
                <?php $i++; }
                ?>
           
               
            
        </tbody>
       </table> 
        
    <?php }else echo "<p>No record found.</p>"; ?>  
                         
    </div>
</div>
</div>
