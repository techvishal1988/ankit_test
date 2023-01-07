<?php
    if(@$faq[0]->id)
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
        <li class="active"><?php echo $bc ?> FAQ</li>
    </ol>
</div>


<div id="main-wrapper" class="container">
<div class="row mb20">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-white">
        <?php echo $this->session->flashdata('message'); if(@$msg){echo @$msg;} ?>   
            <?php //echo '<pre />'; print_r($templatedesc); ?>
            <div class="panel-body">
                <form class="form-horizontal frm_cstm_popup_cls_faqadd" method="post" action="" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_faqadd')">
                	<?php echo HLP_get_crsf_field();?>
                    <input type="hidden" name="id" value="<?php echo @$faq[0]->id ?>" />
                    <div class="form-group no_mar">
                        <label for ="temptile" class="wht_lvl"> Question</label>
                        <input required="true" type="text"  name="textname" value="<?php echo @$faq[0]->question ?>" placeholder="Enter question"  class="form-control" maxlength="250"/>
                    </div>
                    
                    <div class="form-group no_mar">
                        <label for ="description" class="wht_lvl"> Answer</label>
                        <textarea  class="form-control" name="meaning" placeholder="Enter answer" required="true" maxlength="500"><?php echo @$faq[0]->answer ?></textarea>
                       
                    </div>
                    
                    <input type="submit" name="<?php echo $btnName ?>" value="<?php echo $btnCaption ?>" class="btn btn-primary pull-right" />
                </form>
            </div>

             

        </div>
    </div>

</div>
</div>
