<link rel="stylesheet" href="
   <?php echo base_url('assets/chartjs') ?>/css/custom.css">
<style>
.fstElement:hover{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstElement:foucs{box-shadow: 0 0 5px #<?php echo $this->session->userdata("company_color_ses"); ?>!important;
border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important;}
.fstChoiceItem{background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border: 1px solid #<?php echo $this->session->userdata("company_color_ses"); ?>!important; font-size:1em;}
.fstResultItem{ font-size:1em;}
.fstResultItem.fstFocused, .fstResultItem.fstSelected{ background-color:#<?php echo $this->session->userdata("company_color_ses"); ?>!important; border-top-color:#<?php echo $this->session->userdata("company_light_color_ses"); ?>!important;}
.fstControls{line-height:13px;}
/*.rule-form .form-control{height:38px !important;} */
.rule-form .control-label{line-height:38px !important;}
.fstControls{width: 39em !important;}
.my-form{    background: #fff !important;}
.fstResults{position:inherit !important; z-index:999;}
.form-input{padding-left: 0px;}
/*.frm_inpt{height: 30px;}*/
.form-horizontal .control-label{line-height: 29px;}
.form-horizontal .fstMultipleMode {
    padding-top: 3px !important;}
</style>

  <div class="page-breadcrumb">
      <ol class="breadcrumb container">
      <li>General Settings</li>
      <li class="active">Upload Company Financials</li>
  </ol>
  </div>
<div id="main-wrapper" style="margin-top:0px;">

<div class="container">
  <div class="row mb20">
  	<div class="col-md-6 col-md-offset-3">
          <div class="custom-panell wow animated bounceInUp" data-wow-delay=".75s">
              <div class="panel-body">
                  <!--<p id="msg">-->
                  <?php $tooltip=getToolTip('edit-company');$val=json_decode($tooltip[0]->step);?><!--</p>-->
                  
                    <?php if(($msg) or $this->session->flashdata('message')){?>
                        <div class="">
                            <?php echo $this->session->flashdata('message');
                        if($msg){echo $msg;} ?>
                        </div>  
                    <?php } ?> 
                    
                    
					<form method="post" class="form-horizontal custom-form-design" style=" margin-bottom: 8px;">

						<div class="add_data" style="margin-bottom: 8px; padding-bottom: 1px;">
						   <legend >Profit-Cost-Revenue Details</legend>
							<div class="form-group my-form nobg">
								<?php echo HLP_get_crsf_field();?>

				                <div class="col-sm-12">
				                	<label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">Country :</label>
									   <div class="col-sm-8 col-xs-12 form-input">
				                         <select  name="country" class="form-control" id="country">
										  <option value="" disabled selected>Select Country</option>
									     </select>
									  </div>
				                </div>

				                <div class="col-sm-12">
				                  <label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">City :</label>
									<div class="col-sm-8 col-xs-12 form-input">
				                     <select name="city" class="form-control" id="city">
										<option value="" disabled selected>Select City</option>
									 </select>
									</div>
				                </div>

				                <div class="col-sm-12">
				                	<label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">Buisness Unit :</label>
									<div class="col-sm-8 col-xs-12 form-input">
									  <select  name="bu" class="form-control" id="bu">
										<option value="" disabled selected>Select BU</option>
									  </select>
									</div>
				                </div>

				                <div class="col-sm-12">
				                  <label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">Financial Year :</label>
									 <div class="col-sm-8 col-xs-12 form-input">
										<select  name="financial_year" class="form-control" id="financial_year_add">
										   <option value="" disabled selected>Select Year</option>
										</select>
									</div>
				                </div>
				      
								<div class="col-sm-12">
								   <label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">Cost per FTE :</label>
								    <div class="col-sm-8 col-xs-12 form-input">
				                       <input type="text"  name="cost" placeholder="Enter Cost" value="<?php echo isset($detail['cost'])?$detail['cost']:'' ?>" class="form-control" />
								    </div>
								</div>

							    <div class="col-sm-12">
								 <label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">Revenue per FTE :</label>
							      <div class="col-sm-8 col-xs-12 form-input">
				            	   <input type="text"  name="revenue" placeholder="Enter Revenue" value="<?php echo isset($detail['revenue'])?$detail['revenue']:'' ?>" class="form-control" />
							     </div>
							    </div>

								<div class="col-sm-12">
				                  <label for="inputEmail3" class="col-sm-4 col-xs-3 control-label ">Profit per FTE :</label>
								   <div class="col-sm-8 col-xs-12 form-input">
				                     <input type="text"  name="profit" placeholder="Enter Profit" value="<?php echo isset($detail['profit'])?$detail['profit']:'' ?>" class="form-control" />
								   </div>
								</div>

								<div class="col-sm-12">

									<?php if (isset($detail)) { ?>
                                        <input type="submit" id="btnAdd" value="Update" class="btn btn-success pull-right" />
                                    <?php } else { ?>
                                        <input type="submit" id="btnAdd" value="Add" class="btn btn-success pull-right" />
									<?php } ?>
									


								</div>

							</div>
		                </div>
                	</form>
	           </div>
          </div>
        </div>
   <!-- table for dispaly added data start --> 
    <div class="col-sm-12">
    	<div class="table-restonsive">
    		<table class="table border">
    			<thead>
    				<tr>
    					<th>Date of entry</th>
    					<th>Country</th>
    					<th>City</th>
    					<th>Buisness Unit</th>
    					<th>Financial Year</th>
    					<th>Total HR Cost</th>
    					<th>Total Revenue</th>
    					<th>Total Profit</th>
    					<th>Edit</th>
    				</tr>
    			</thead>
    			<tbody>
					<?php foreach($list as $row) {?>
    				<tr>
    					<td><?php print $row['createdon'] ?></td>
    					<td><?php print $row['country'] ?></td>
    					<td><?php print $row['city'] ?></td>
    					<td><?php print $row['business_level'] ?></td>
    					<td><?php print $row['financial_year'] ?></td>
    					<td class="text-right"><?php print $row['cost'] ?></td>
    					<td class="text-right"><?php print $row['revenue'] ?></td>
    					<td class="text-right"><?php print $row['profit'] ?></td>
    					<td class="text-center"><a data-toggle="" data-original-title="Edit " data-placement="bottom" href="<?php echo site_url($url_key . "/" . $row["id"]) ?>" alt="Edit" title=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					</tr>
					<?php } ?>
    			</tbody>
    		</table>
    	</div>
    </div>

<!-- table for dispaly added data ends --> 
</div>


  </div>
</div>

<script src="
   <?php echo base_url('assets/chartjs') ?>/js/nodejs_support.js"></script>

<script>
	$(document).ready(function() {
	
		var nodejs_api_helper = new NodeJs_API_Helper('<?php echo $_COOKIE['Acc3ssTo73n']; ?>');    
	       
	
	       getFinancialYear(nodejs_api_helper,<?php echo isset($detail['year_id'])?$detail['year_id']:'' ?>);
	       getCity(nodejs_api_helper,<?php echo isset($detail['city_id'])?$detail['city_id']:'' ?>);
	       getCountry(nodejs_api_helper,<?php echo isset($detail['country_id'])?$detail['country_id']:'' ?>);
	       getBU(nodejs_api_helper,<?php echo isset($detail['business_unit_id'])?$detail['business_unit_id']:'' ?>);
	       
	
	   		$("#profit").on("input", function(evt) {
	    	   var self = $(this);
	    	   self.val(self.val().replace(/[^0-9\.]/g, ''));
	    	   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
	    	   {
	    	     evt.preventDefault();
	    	   }
			 });
			 
	       $("#revenue").on("input", function(evt) {
	    	   var self = $(this);
	    	   self.val(self.val().replace(/[^0-9\.]/g, ''));
	    	   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
	    	   {
	    	     evt.preventDefault();
	    	   }
			 });
			 
	       $("#cost").on("input", function(evt) {
	    	   var self = $(this);
	    	   self.val(self.val().replace(/[^0-9\.]/g, ''));
	    	   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
	    	   {
	    	     evt.preventDefault();
	    	   }
			 });
			 /*
	       $( '#add_data_button' ).click(function() {
	           
	           
	    	   if ($("#financial_year_add").find(":selected").val() === ''){
	               custom_alert_popup("Please select a financial year and then proceed!");
	               $('#financial_year_add').focus();
	
	               return false;
	           }else  if ($("#country").find(":selected").val() === ''){
	               custom_alert_popup("Please select a country and then proceed!");
	               $('#country').focus();
	
	               return false;
	           }else  if ($("#city").find(":selected").val() === ''){
	               custom_alert_popup("Please select a city and then proceed!");
	               $('#city').focus();
	
	               return false;
	           } else if ($("#bu").find(":selected").val() === ''){
	               custom_alert_popup("Please select a BU and then proceed!");
	               $('#bu').focus();
	
	               return false;
	           }
	           else
	               {
	
	        	   var body= {
	        	    	   "year_id":$("#financial_year_add").find(":selected").val(),
	        	    	   "country_id":$("#country").find(":selected").val(),
	        	    	   "city_id":$("#city").find(":selected").val(),
	        	    	   "business_unit_id":$("#bu").find(":selected").val(),
	        	    	   "revenue":$("#revenue").val(),
	        	    	   "cost":$("#cost").val(),
	        	    	   "profit":$("#profit").val()};
	        	   //alert(JSON.stringify(body));
	        	   addData(nodejs_api_helper,body);
	        	   
	        	  
	        	   
	           }



	    	  
			  });*/
	
	
	   });
	
	 getFinancialYear = function(nodejs_api_helper,edit_value) {
			var url = nodejs_api_helper.base_url+'/financial_year';
			$.ajax(nodejs_api_helper.getAjaxCommonSettings(url))
			.done(function (response) {
	
				$('#rpt_loading').hide();
	
				//var dropdown = $("#financial_year"); 
				var dropdown2 = $("#financial_year_add"); 
	
				var years = JSON.parse(response).data;
	
				for (var i = 0; i < years.length; i++) {
					var selected = (edit_value==years[i].id)? "selected":"";
					var option = "<option "+selected+" value='"+years[i].id+"'>"
					+ years[i].name
					+"</option>";
					//console.log(option);
					//dropdown.append(option);
					dropdown2.append(option);
				}
	
			})
			.fail(function()  {
				custom_alert_popup("Sorry. Server unavailable. ");
				$('#rpt_loading').hide();
			});
		}
		 
	 
	   getCountry = function(nodejs_api_helper,edit_value) {
		var url = nodejs_api_helper.base_url+'/country';
		$.ajax(nodejs_api_helper.getAjaxCommonSettings(url))
		.done(function (response) {
	
			$('#rpt_loading').hide();
	
			var dropdown = $("#country"); 
	
			var country_id = JSON.parse(response).data;
	
			for (var i = 0; i < country_id.length; i++) {
				var selected = (edit_value==country_id[i].id)? "selected":"";
				var option = "<option "+selected+" value='"+country_id[i].id+"'>"				
				+ country_id[i].name
				+"</option>";
				//console.log(option);
				dropdown.append(option);
			}
	
		})
		.fail(function()  {
			custom_alert_popup("Sorry. Server unavailable. ");
			$('#rpt_loading').hide();
		});
	}
	
	getCity = function(nodejs_api_helper,edit_value) {
		var url = nodejs_api_helper.base_url+'/city';
		$.ajax(nodejs_api_helper.getAjaxCommonSettings(url))
		.done(function (response) {
	
			$('#rpt_loading').hide();
	
			var dropdown = $("#city"); 
	
			var city = JSON.parse(response).data;
	
			for (var i = 0; i < city.length; i++) {
				var selected = (edit_value==city[i].id)? "selected":"";
				var option = "<option "+selected+" value='"+city[i].id+"'>"					
				+ city[i].name
				+"</option>";
				//console.log(option);
				dropdown.append(option);
			}
	
		})
		.fail(function()  {
			custom_alert_popup("Sorry. Server unavailable. ");
			$('#rpt_loading').hide();
		});
	}
	
	getBU = function(nodejs_api_helper,edit_value) {
		var url = nodejs_api_helper.base_url+'/bu';
		$.ajax(nodejs_api_helper.getAjaxCommonSettings(url))
		.done(function (response) {
	
			$('#rpt_loading').hide();
	
			var dropdown = $("#bu"); 
	
			var bu = JSON.parse(response).data;
	
			for (var i = 0; i < bu.length; i++) {
				var selected = (edit_value==bu[i].id)? "selected":"";
				var option = "<option "+selected+" value='"+bu[i].id+"'>"					
				+ bu[i].name
				+"</option>";
				//console.log(option);
				dropdown.append(option);
			}
	
		})
		.fail(function()  {
			custom_alert_popup("Sorry. Server unavailable. ");
			$('#rpt_loading').hide();
		});
	}
	
</script>   



