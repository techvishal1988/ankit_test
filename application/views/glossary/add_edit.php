<?php
    if(@$glossary[0]->text!='')
    {
        $btnName='update';
        $btnCaption='Update';
        $bc='Edit';
    }
    else
    {
        $btnName='save';
        $btnCaption='Save';
        $bc='Add';
    }
?>

<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="javascript:void(0)">Connect & Learn</a></li>
        <li class="active"><?php echo $bc ?> Glossary</li>
    </ol>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-white">
         <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>
            <?php //echo '<pre />'; print_r($templatedesc); ?>
            <div class="panel-body">
                <form class="form-horizontal frm_cstm_popup_cls_gadd" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_gadd')">
                	<?php echo HLP_get_crsf_field();?>
                    <input type="hidden" name="id" value="<?php echo @$glossary[0]->id ?>" />
                    <div class="form-group no_mar">
                        <label for ="temptile" class="wht_lvl"> Text</label>
                        <input required="true" type="text"  name="textname" value="<?php echo @$glossary[0]->text ?>" placeholder="Enter Text"  class="form-control" maxlength="250"/>
                    </div>
                    
                    <div class="form-group no_mar">
                        <label for ="description" class="wht_lvl"> Meaning</label>
                        <textarea  class="form-control" name="meaning" placeholder="Enter Your Meaning" required="true" maxlength="500"><?php echo @$glossary[0]->meaning ?></textarea>
                       
                    </div>
                    
                    <input type="submit" name="<?php echo $btnName ?>" value="<?php echo $btnCaption ?>" class="btn btn-primary pull-right" />
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>
