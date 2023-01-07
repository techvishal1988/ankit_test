<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Voucher List</li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<div class="row mb20">
            <div class="col-md-12">
       <div class="mailbox-content pad_b_10">
       <?php echo $this->session->flashdata('message'); echo $msg;  ?>
        <div class="row">
            <?php foreach($voucher->vouchers as $k => $vlist) { ?>
            <div class="xoxo col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3" >
                <div class="thumbnail bootsnipp-thumb" style="padding-bottom: 20px;overflow: hidden;">
                    <a onclick="openmodal('<?php echo $vlist->product_id; ?>');" data-toggle="modal" data-target="#xoxodetail">
                        <img class="danlazy" id="img<?php echo $vlist->product_id; ?>" src="<?php echo $vlist->product_image; ?>" width="320" height="151" alt="<?php echo $vlist->product_name; ?>" style="width: 100%;height: 151px; cursor: pointer;">
                    </a>
                    <div class="prod_info">
                        <p class="pull-right view-counts">
                            <a class="tip" id="prince<?php echo $vlist->product_id; ?>" data-toggle="tooltip" title="" data-original-title="Price"><?php echo $vlist->product_denminations[0] .' '. $vlist->currency_code; ?> <i class="icon-thumbs-up"></i></a> 

                            <a><span class="hide label label-info tip" id="valid<?php echo $vlist->product_id; ?>" data-toggle="tooltip" title="" data-original-title="expiry on"><?php echo ($vlist->product_expiry_and_validity); ?></span></a>
                        </p>
                        <p class="pull-left prod_name">
                            <a id="name<?php echo $vlist->product_id; ?>"><?php echo $vlist->product_name; ?></a>
                        </p>
                    </div>
                    
                    <div class="caption xoxo_desc" id="desc<?php echo $vlist->product_id; ?>"><?php echo html_entity_decode($vlist->product_description); ?></div>
                    <div class="hide" id="htouse<?php echo $vlist->product_id; ?>"><?php echo html_entity_decode($vlist->product_description); ?></div>
                    <div class="hide" id="country<?php echo $vlist->product_id; ?>"><?php echo ($vlist->country_name); ?></div>
                    <div class="xoxo_readmore btnview pull-right" data-toggle="modal" data-target="#xoxodetail" onclick="openmodal('<?php echo $vlist->product_id; ?>');">
                    Read More...</div>
                    <input type="hidden" id="denomination<?php echo $vlist->product_id; ?>" name="denomination" value='<?php echo json_encode($vlist->product_denminations); ?>' />

                    <div class="xoxo_buy">
                        <button data-toggle="modal" data-target="#xoxodetail" class="btn btn-primary btn-block" onclick="openmodal('<?php echo $vlist->product_id; ?>');" type="button">Redeem</button>  
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="xoxodetail" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form class="form-horizontal" method="post" action="<?php echo base_url('xoxoday/voucher-booking');?>"> 
            <?php echo HLP_get_crsf_field();?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Voucher Details</h4>
          <input type="hidden" id="mdpid" name="product_id">
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                <img id="mdimg" src="https://res.cloudinary.com/dyyjph6kx/image/upload/gift_vouchers/image/data/GiftVoucher/cafe.jpg"/>
              </div>
              <div class="col-md-6">
                <div><h2 id="mdtitle"> Cafe Coffee Day </h2></div>
                <div>
                <table>
                  <tr>
                      <td> <span>Price :</span></td>
                      <td><span id="mdprice"> <!-- 500 --> INR</span>
                    <select id="mdpriceoption" name="denomination"></select></td>
                  </tr>
                  <tr>
                      <td><span>Country :</span></td> 
                      <td><span id="mdcountry"> India</span></td>
                  </tr> 
                </table>    
                </div>
                <div class="hide">
                    <span>validity upto :</span>
                    <span id="mdvalid"> 3 months.</span>
                </div>
              </div>
          </div>
          <div class="row">
          <br>
              <div class="col-md-12"><h4>Description</h4></div>
              <div class="col-md-12" id="mddesc"></div>
          </div>
          <div class="row">
            <div class="col-md-12"><h4>How to use</h4></div>
              <div class="col-md-12" id="mdhtouse"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Redeem</button>
        </div>
        </form>
      </div>
      
    </div>
</div>
<script type="text/javascript">
    
    function openmodal(id) {
        $('#mdpid').val(id);
        $('#mdimg').attr('src',$('#img'+id).attr('src'));
        $('#mdtitle').html($('#name'+id).html());
        /*$('#mdprice').text($('#prince'+id).text());*/
        $('#mdcountry').html($('#country'+id).html());
        $('#mdvalid').html($('#valid'+id).html());
        $('#mddesc').html($('#desc'+id).html());
        $('#mdhtouse').html($('#htouse'+id).html());

        var arr = $.parseJSON($('#denomination'+id).val());
        var str = "";
        $.each(arr, function( i, val ) {
          str += '<option value="'+val+'">'+val+'</option>';
        });
        $('#mdpriceoption').html(str);
    }

    function formsubmit() {
        var id = $('#mdpid').val();
        console.log(id);
        $( "#submit"+id ).trigger( "click" );
    }
</script>
