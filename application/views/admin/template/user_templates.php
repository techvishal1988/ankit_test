<div class="page-breadcrumb">
<div class="container">
<div class="col-sm-4">
    <ol class="breadcrumb ">
        <li><a href="javascript:void(0)">General Setting</a></li>
        <li class="active">
       PDF List</li> 
    </ol>
    </div>
  
   </div>
</div>


<div id="main-wrapper" class="container">

<div class="row mb20">
	<div class="col-md-12">
            
               <div class="mailbox-content" style="overflow-x:auto">
               <?php echo @$this->session->flashdata('message'); 
               //echo '<pre />';print_r($pdf)  ;?>
                 <?php if(count($pdf)!=0) { ?>  
                <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                        <tr>
                            <th class="hidden-xs" width="5%">S.No</th> 
                            <th>PDF Name</th>
                            <th>Action</th>
                                
                        </tr>
                    </thead>
                    <tbody id="tbl_body">                   
                     <?php $i=1;
                     foreach($pdf as $p)
                     { ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $p->Pdf_name ?></td>
                            <td><a href="<?php echo $p->Pdf_link ?>" class="btn btn-primary" target="_blank">View</a></td>
                        </tr>
                        
                <?php $i++;
                     }
                     ?>  
                     </tbody>
                   </table>         
                 <?php } 
                 else {
                     echo 'PDF not found.';
                 }
                 ?>
                </div>
            </div>
</div>
  
</div>

  
 