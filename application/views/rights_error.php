<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">No Rights</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-white">        
            <div class="panel-body">
                <div align='left' style='color:red;' id='notify'>
                    <span><b>
                    <?php echo $this->session->flashdata('message'); echo $msg; ?>  
                    </b></span>
                </div> 
            </div>
        </div>
    </div>
</div>
</div>