<link href="<?php echo base_url("assets/css/candidate_offer.css"); ?>" rel="stylesheet"/>
<div class="page-breadcrumb">
      <div class="container-fluid compp_fluid">
        <div class="row">
          <div class="col-sm-8 padl0">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url("candidate-offer"); ?>"> Candidate Offer Proposal</a></li>
          </ol>
          </div>
          <div class="col-sm-4"></div>    
       </div>
      </div>
    </div>
   <div id="main-wrapper">
      <div class="container-fluid compp_fluid"> 
          <div class="panel panel-white pad_b_10">
            <div class="candidate_offer_input">
              <div class="row">
               <div class="col-sm-4">
                <div class="cand_input">
            				<form name="candidateData" id="candidateData"  method="post" action="" enctype="multipart/form-data">
								<?php echo HLP_get_crsf_field();?>
            					<input type="text" class="form-control" name="candidateName"  id="candidateName" placeholder="Candidate Name" required>
            					<span id="candidateNameErr"></span>
                                <select class="form-control" id="country" name="country" required>
            						<option value="">Select Country</option>
                                  <?php if(!empty($country_det)){
                                      foreach($country_det as $key => $country_val) { ?>
            								<option value="<?php echo $country_val['id']; ?>" ><?php echo $country_val['name']; ?></option>
                                   <?php }
            					  } ?>
            					  <option value="0">NA</option>
            					</select>
            					<span id="countryErr"></span>
            					<select class="form-control" id="city" name="city" required>
            						<option value="">Select City</option>
                                  <?php if(!empty($city_det)){
                                      foreach($city_det as $key => $city_val) { ?>
            								<option value="<?php echo $city_val['id']; ?>" ><?php echo $city_val['name']; ?></option>
                                   <?php }
            					  } ?>
            					  <option value="0">NA</option>
            					</select>
            					<span id="cityErr"></span>
            					<select class="form-control" id="function" name="function" required>
            						<option value="">Select Function</option>
                                  <?php if(!empty($function_det)){
                                      foreach($function_det as $key => $function_val) { ?>
            								<option value="<?php echo $function_val['id']; ?>" ><?php echo $function_val['name']; ?></option>
                                   <?php }
            					  } ?>
            					  <option value="0">NA</option>
            					</select>
            					<span id="functionErr"></span>
                                <select class="form-control" id="grade" name="grade" required>
            						<option value="">Select Grade</option>
                                  <?php if(!empty($grade_det)){
                                      foreach($grade_det as $key => $grade_val) { ?>
            								<option value="<?php echo $grade_val['id']; ?>" ><?php echo $grade_val['name']; ?></option>
                                   <?php }
            					  } ?>
            					  <option value="0">NA</option>
            					</select>
            					<span id="gradeErr"></span>
                                <select class="form-control" id="level" name="level" required>
            						<option value="">Select Level</option>
                                  <?php if(!empty($level_det)){
                                      foreach($level_det as $key => $level_val) { ?>
            								<option value="<?php echo $level_val['id']; ?>" ><?php echo $level_val['name']; ?></option>
                                   <?php }
            					  } ?>
            					  <option value="0">NA</option>
            					  </select>
            					  <span id="levelErr"></span>
									<select class="form-control" id="title" name="title" required>
										<option value="">Select Title</option>
										<?php if(!empty($title_det)){
											foreach($title_det as $key => $title_val) { ?>
													<option value="<?php echo $title_val['id']; ?>" ><?php echo $title_val['name']; ?></option>
										<?php }
										} ?>
										<option value="0">NA</option>
									</select>
            					<span id="titleErr"></span>
									<select class="form-control" id="offer_rule" name="offer_rule" required>
										<option value="">Select Rule</option>
										<?php if(!empty($offer_rule_det)){
										foreach($offer_rule_det as $key => $rule_val) { ?>
										<option value="<?php echo $rule_val['id']; ?>" ><?php echo $rule_val['offer_rule_name']; ?></option>
										<?php }
										} ?>
									</select>
            					<!--<button type="button" class="btn btn-primary  pull-right">Let's start Posting
            						<i class="fa fa-angle-right hvr-icon" aria-hidden="true"></i>
            					</button>-->
								<div class="col-sm-12 paddr0 mob-center text-right creatSam" >
									<input type="submit" id="btnAdd" name="btn_next" value="Submit" class="btn btn-primary getGraphData">
								</div>
                    </form>
                  </div>
                </div>
                <div class="col-sm-4 padl0">
					<div class="card-body">
						<div id="targetChart" class="w-100">
							<div class="overlay_for_graph"><h4 class="text-center"> Target Pay Comparison</h4> </div>
						</div>
					</div>
                </div>
                <div class="col-sm-4 padl0">
					<div class="card-body">                      
						<div id="peerChart" class="w-100">
							<div class="overlay_for_graph"><h4 class="text-center"> Peer Comparison</h4> </div>
						</div>
					</div>
				</div>
			</div>
		</div>  
	</div>

          <div class="row mb40">
            <div class="col-sm-12">
               <div class="panel panel-white pad_b_10">
                  <div class="candidate_offer_table">    
                    <table class="table border">
                      <thead>
                        <tr>
                            <th rowspan="2">Compensation Elements</th>
                            <th colspan="2">Candidates current</th>
                            <th colspan="2">Proposed Package**</th>  
                            <th rowspan="2">%age increase on current</th>
                            <th rowspan="2">Comments</th>    
                        </tr>
                        <tr>
                          <th>Amount</th>
                          <th>%age of base</th>
                          <th>Amount</th>
                          <th>%age of base</th>    
                        </tr>
                    </thead>
                    <tbody>                   
                        <tr>
                            <td>Base salary</td>
                            <td class="text-center max_width100">
                                 <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                               <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100">
                                 Amount
                            </td> 
                             <td class="text-center max_width100">
                                % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr> 

                         <tr>
                            <td>Target bonus/ incentive</td>
                            <td class="text-center max_width100">
                                 <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                               <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100 ">
                                 Amount
                            </td> 
                             <td class="text-center max_width100">
                                % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr>

                         <tr>
                            <td>Target LTI/Retention bonus</td>
                            <td class="text-center max_width100">
                                 <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                                <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100">
                                 Amount
                            </td> 
                             <td class="text-center max_width100">
                                % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr>

                        <tr>
                          <td class="text-right">
                            <b>Total Achievement</b>
                          </td>
                          <td class="text-center"><b>Sum</b></td>
                          <td></td>
                          <td class="text-center"><b>Sum</b></td>
                          <td></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                        </tr>


                          <tr>
                            <td>Allowance-1 (LOV of allowances from database)</td>
                            <td class="text-center max_width100">
                                 <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                               <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100">
                                 Amount
                            </td> 
                             <td class="text-center max_width100">
                                % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr> 

                         <tr>
                            <td>Allowance-2 (LOV of allowances from database)</td>
                            <td class="text-center max_width100">
                                 <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                               <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100">
                                 Amount
                            </td> 
                             <td class="text-center max_width100">
                                 % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr>

                         <tr>
                            <td>Allowance-3 (LOV of allowances from database)</td>
                            <td class="text-center max_width100">
                                 <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                                <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100">
                                 Amount
                            </td> 
                             <td class="text-center max_width100">
                                 % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr>

                        <tr>
                            <td><input type="text" class="form-control" placeholder="Any additional allowances (manual input)*"></td>
                            <td class="text-center max_width100">
                                <input type="text" class="form-control">
                            </td> 
                            <td class="text-center max_width100">
                                <input type="text" class="form-control">
                            </td> 
                             <td class="text-center max_width100">
                                
                            </td> 
                             <td class="text-center max_width100">
                                 % Amount
                            </td> 
                            <td class="text-center max_width100"> 
                              20%
                            </td> 
                            <td class="text-center">
                               <textarea class="form-control"></textarea>
                            </td> 
                            
                        </tr>

                        <tr>
                          <td class="text-right">
                            <b>Total Achievement</b>
                          </td>
                          <td class="text-center"><b>Sum</b></td>
                          <td></td>
                          <td class="text-center"><b>Sum</b></td>
                          <td></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                        </tr>

                    </tbody>
                   </table> 
                 </div> 
               </div>
              </div>
            </div>   
        </div>
       </div>
 </div>
<script src="<?php echo base_url('assets/chartjs') ?>/js/highchart.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/exporting.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/no-data-to-display.js"></script>
<script src="<?php echo base_url('assets/chartjs') ?>/js/lodash.js"></script>
<script src="<?php echo base_url("assets/js/candidate_offer.js"); ?>"></script>