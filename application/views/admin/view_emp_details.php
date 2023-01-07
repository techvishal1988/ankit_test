<style>
.e-main-head{display:block; width:100%;}
.e-main-head .sub-head{border-bottom:1px #CCC solid; height:22px; margin-bottom:25px;}
.e-main-head .sub-head h2{}
.e-main-head .sub-head h2 span{ background: #ffffff none repeat scroll 0 0; padding:6px 0px;}
.m10{margin-top:10px;}
.e-main-head .inner-info{display:block; width:100%;}
.e-main-head .inner-info h4{margin:0px; font-size:20px; font-weight:normal;}
.e-main-head .inner-info h4 span{margin-left:20px; font-size:18px; font-weight:normal;}
</style>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Employee Details</li>
    </ol>
</div>
<div id="main-wrapper" class="container">
        	       
<div class="rule-form">
 <?php $i = 0; $str =""; 
	foreach($staffDetail as $value)
	{
		//if(($value["display_name_override"] != '') && ($value["uploaded_value"] != ''))
		if(($value["display_name"] != '') && ($value["value"] != ''))
		{ 
			if($i==0)
			{
				$str .= '<div class="form-group">
				<div class="row">
					<div class="col-sm-12">
						<div class="row">						
							<div class="col-sm-4 removed_padding" >
								<label for="inputEmail3" class="control-label" style="padding-left: 12px !important;" title="'.ucfirst($value["display_name"]).'">'. substr(ucfirst($value["display_name"]),0,50).'</label>
							</div>
							<div class="col-sm-2 removed_padding">
								<div class="form-input">                                    	
									<input type="text" class="form-control" value="'. substr($value["value"],0,50).'" title="'. $value["value"].'" disabled="disabled" />
								</div>
							</div>';
				$i++;
		   }
		   else
		   {
				$i = 0;
				$str .= '<div class="col-sm-4 removed_padding" style="padding-left: 15px !important;">
								<label for="inputEmail3" class="control-label" style=" padding-left: 12px !important;" title="'.ucfirst($value["display_name"]).'">'. substr(ucfirst($value["display_name"]),0,50).'</label>
							</div>
							<div class="col-sm-2 removed_padding">
								<div class="form-input">                                    	
									<input type="text" class="form-control" value="'. substr($value["value"],0,50).'" title="'.$value["value"].'" disabled="disabled" />
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>          ';
		   }
		
		} } 
		
		if($i==1)
		{
			$i = 0;
			$str .= '</div>
				</div>
			</div>
		</div>          ';
		}
		
		echo $str;
		   ?>
</div>
                            
                        
                          
                           
