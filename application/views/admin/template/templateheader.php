
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="javascript:void(0)">General Setting</a></li>
        <li class="active">Template</li>
    </ol>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-3">
        
    </div>
    <div class="col-md-9">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for ="temptile" style="color:#000 !important"> Upload latter format </label>
                        <input type="file" name="latterhead" class="form-control" /> 
                    </div>
                    <input type="submit" name="save" value="save" class="btn btn-primary pull-right" />
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>
