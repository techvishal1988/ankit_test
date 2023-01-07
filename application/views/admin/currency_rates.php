<div class="page-breadcrumb">
  <ol class="breadcrumb container">
    <li>General Settings</li>
    <li class="active"><?php echo $title; ?></li>
  </ol>
</div>
<div id="main-wrapper" class="container">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <div class="row mb20">
    <div class="col-md-12">
      <div class="panel panel-white"> <?php echo $this->session->flashdata('message');
        if(helper_have_rights(CV_CURRENCY_RATES, CV_INSERT_RIGHT_NAME))
		{ ?>
        <div class="panel-body">
          <form class="form-horizontal frm_cstm_popup_cls_default" method="post" action=""  onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')">
            <?php echo HLP_get_crsf_field();?>
            <div class="row">
              <div class="col-md-12">
                <div class="">
                    <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                    <thead>
                      <tr>
                        <th>Currency Code</th>
                        <?php foreach($currencys_list as $row){ echo "<th>".$row["name"]."</th>";} ?>
                      </tr>
                    </thead>
                    <tbody id="tbl_body">
                      <?php 
                        foreach($currencys_list as $frm_row)
                        {
                            echo "<tr>";
                            echo "<td style='width:150px;' align='center'> From - ".$frm_row["name"]."</td>";
                            foreach($currencys_list as $to_row)
                            {?>
                    			<td>
                                	<input type="text" id="txt_rates_<?php echo $frm_row["id"]."_".$to_row["id"]; ?>" name="txt_rates_<?php echo $frm_row["id"]."_".$to_row["id"]; ?>" class="form-control" required onKeyUp="validate_percentage_onkeyup_common(this,5,6);" onBlur="validate_percentage_onblure_common(this,5,6);" maxlength="12" style="text-align:center;" />
                                </td>
                      <?php }
                            echo "</tr>";
                        }
                    ?>
                        </tbody>
                    </table>
                  
                    <div class="row">
                        <div class="col-sm-12 overrt_btn">
                            <input type="submit" id="btnAdd" value="Submit" class="btn btn-success" />
                        </div>
                    </div>
                </div>
              </div>
            </div>
            
          </form>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<script>

var rates = '<?php echo $rates; ?>';
$.each(JSON.parse(rates),function(key,val)
{
	//console.log(val);
	$("#txt_rates_"+ val.from_currency +"_"+ val.to_currency).val(val.rate);
});
</script>
