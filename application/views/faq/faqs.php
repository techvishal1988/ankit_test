
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.in").each(function(){
        	$(this).siblings(".panel-heading").find(".glyphicon").addClass("glyphicon-minus").removeClass("glyphicon-plus");
        });
        // Toggle heading color
        var clicks = 0;
        $('.panel-heading a').click(function() {
            $('.panel-heading a').removeClass('borderLeft');
            if(clicks == 0) {
                $(this).addClass('borderLeft');
                clicks++;
            } else {
                $(this).removeClass('borderLeft');
                clicks--;
            }
        });
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
            $(this).find('a').addClass('addBorderLeft');
        	$(this).parent().find(".glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });
    });
</script>

<style>

    .panel .panel-body{ padding-left: 15px; padding-top: 10px; }

    .panel-group .panel {
        margin-bottom: 20px;

    }

    .panel-default > .panel-heading a, .panel-default  {
        background-color: #fff !important;
        border-left: 3px solid #fff;
        margin-bottom: 0;
    }
    .panel-default > .panel-heading + .panel-collapse > .panel-body {
        border: 0;
    }
    .panel-default > .panel-heading a:hover, .panel-body
     {
        background-color: #FAFAFA !important;
    }

.marginTopFaq{
	    padding-top: 10px;
}

.panel-group .panel {
        border-radius: 0;
        box-shadow: none;
        border-color: #EEEEEE;
    }

    .panel-default > .panel-heading {
        padding: 0;
        border-radius: 0;
        color: #212121;
        background-color: #FAFAFA;
        border-color: #EEEEEE;
    }

    .panel-title {
        font-size: 14px;
    }

    .panel-title > a {
        display: block;
        padding: 15px;
        text-decoration: none;
    }

    .more-less {
        float: right;
        color: #212121;
    }

    .panel-default > .panel-heading + .panel-collapse > .panel-body {
        border-top-color: #EEEEEE;
    }

/* ----- v CAN BE DELETED v ----- */
body {
    //background-color: #26a69a;
}

.demo {
    padding-top: 60px;
    padding-bottom: 60px;
}
.panel{
	 
	     box-shadow: -2px 1px 1px 0px #cacaca !important;
}
.quesHead{
	color:#000;
}


 .bg{
	<?php /*?>background: url(<?php echo base_url() ?>assets/salary/img/bg-1.png);<?php */?>
	background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
	background-size: cover;
            min-height: 550px;
        
}
</style>

<div class="page-breadcrumb">
  <div class="container">
   <div class="row"> 
    <div class="col-md-8">
        <ol class="breadcrumb" style="padding-left:0px;">
        <?php if(($this->session->userdata('role_ses')==10 || $this->session->userdata('role_ses')==11)) { ?>
            <li><a href="javascript:void(0)"> Policies & FAQs</a></li>    
            <?php } else { ?>
            <li><a href="javascript:void(0)">Connect & Learn</a></li>
            <?php } ?>
        <li class="active">FAQs</li>
        </ol>
       </div>
      </div>
    </div>    
</div>



   <div id="popoverlay" class=" popoverlay"></div>
   <div class="container-fluid marginTopFaq bg">
       <div class="container">
        <div class="row">
           
            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php if(count($faq)==0) {
                    echo '<div class="alert alert-danger">
                          No data found. </div>';  
                } ?>
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php //echo '<pre />'; print_r($faq) 
                    
                    foreach($faq as $f)
                    { ?>
                        
                  
                   <div class="panel panel-default boxShadow">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $f->id ?>" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                <strong class="quesHead"><?php echo $f->question ?></strong>
                            </a>
                        </h4>
                    </div>
                    <div id="<?php echo $f->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body" style="color: #000 !important;">
                             <?php echo $f->answer ?> 
                        </div>
                    </div>
                </div>
                  
                    <?php }
               
               ?>
                  
               <!-- <div class="panel panel-default boxShadow">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                <strong class="quesHead">Question #01</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="more-less glyphicon glyphicon-plus"></i>
                                <strong class="quesHead " >Question #02</strong>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        <strong class="quesHead">Question #03</strong>
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div> -->

    </div>
            
	        </div>
           
        </div>
    </div>
   </div>

   