<?php if(isset($bussiness_levels) && count($bussiness_levels)>0){
	$i = 0; 
	foreach($bussiness_levels as $attrKey=>$attrName){?>
        <div class="form-group" id="dv_business_level_achievement_<?php echo $attrName['business_attribute_id']; ?>">
          <div class="row">
            <div class="col-sm-12">
              <div class="form_head clearfix">
                <div class="col-sm-12">
                  <ul>
                    <li>
                      <div class="form_tittle">
                        <h4>
                          <?php  echo $attrName['display_name']; ?> Actual Achievement
                          <input type="hidden" name="hf_business_level[]" value="<?php echo $attrName['id'].CV_CONCATENATE_SYNTAX.$attrName['ba_name']; ?>" />
                        </h4>
                      </div>
                    </li>
                    <li>
                      <div class="form_info"> <span type="button" class="btn btn-default" data-toggle="tooltip"  data-placement="bottom" title="<?php //echo $rule_val[4] ?>"><i class="themeclr fa fa-info-circle" aria-hidden="true"></i></span> </div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="form_sec clearfix">
                <?php if(isset($attrName['bussiness_level_values']) && count($attrName['bussiness_level_values'])>0){                        foreach($attrName['bussiness_level_values'] as $subAttr){ ?>
                            <div class="col-sm-12">
                              <div class="col-sm-6 removed_padding">
                                <label for="inputEmail3" class="control-label">
                                  <?php  echo $subAttr['name']; ?>
                                </label>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-input">
                                  <input type="hidden" name="hf_business_level_element_val_<?php echo $i; ?>[]" value="<?php echo $attrName['id'].CV_CONCATENATE_SYNTAX.$subAttr['id'].CV_CONCATENATE_SYNTAX.$subAttr['name']; ?>" />
                                  <input type="text" name="txt_business_level_element_val_<?php echo $i; ?>[]" class="form-control" maxlength="6" onKeyUp="validate_percentage_onkeyup_common(this,3);" onBlur="validate_percentage_onblure_common(this,3);" value="<?php if($rule_dtls["business_level_achievement"])
												{
													$old_bl_arr = json_decode($rule_dtls["business_level_achievement"],true);
													foreach($old_bl_arr as $bl_key=> $bl_val)
													{ 
														$bl_key_arr = explode(CV_CONCATENATE_SYNTAX, $bl_key);
														if($attrName['id'].CV_CONCATENATE_SYNTAX.$subAttr['id'].CV_CONCATENATE_SYNTAX.$subAttr['name']==$bl_key){echo $bl_val; continue;}
													} }?>">
                                </div>
                              </div>
                            </div>
                <?php } }?>
              </div>
            </div>
          </div>
        </div>
<?php $i++;} } ?>
