<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Mapping List</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
			<div class="col-md-12">
    
       <div class="mailbox-content pad_b_10">
       <?php echo $this->session->flashdata('message'); ?>
        <?php //if(($this->uri->segment('1')) == 'saved-salary-mappings'){
                $postUrl = 'mapping-head/';
                $sheeType = 'S';
            /*}else{
                $postUrl = '/mapping-employee-head/';
                $sheeType = 'E';
            }*/ 
            ?>
        <form method="post" action="<?php echo site_url().$postUrl.$upload_id;?>" >
			<?php echo HLP_get_crsf_field();?>
            <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th class="hidden-xs" width="5%">S.No</th>
                        <th>Title</th>
                        <th>Created On</th>
                    </tr>
                </thead>
                <tbody id="tbl_body">                   
                 <?php $i=0;
                 foreach($mappings as $row)
                 {
                   /* if($row['sheet_type'] == $sheeType)
                    {*/
                        echo "<td align='center'><div class='beg_color'><label><input type='radio' value='".$row["id"]."' name='selectedMapping'/><span></span></label></td><td class='hidden-xs'>". ($i + 1) ."</td>";
                        echo "<td>".$row["title"]."</td>";
                        echo "<td>".$row["created_on"]."</td>";        
                        echo "</tr>";
                        $i++;
                    /*} */                       
                 }
                 ?>  
                                 
                </tbody>
               </table>       
            <input type="submit" name="saveMapping" value="Map With" class="btn btn-success mar_t_10 pull-right"> 
            </form>
        </div>
    </div>
</div>
</div>
