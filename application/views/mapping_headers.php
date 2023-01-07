<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("staff"); ?>">Employees</a></li>
        <li><a href="<?php echo site_url("upload-data"); ?>">Upload Data</a></li>
        <li class="active">Mapping Headers</li>
    </ol>
</div>



<div id="main-wrapper" class="container">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
        <div id="dv_error_msg"></div>
        <?php echo $this->session->flashdata('message');
        	echo $msg; ?>
            <div class="">
            
                <div class="mailbox-content beg_color">
                	<form class="form-horizontal frm_cstm_popup_cls_default" id="frm_mapping" action="<?php echo site_url("upload/insert_headers");?>" method="post" onsubmit="return request_custom_confirm('frm_cstm_popup_cls_default')"> 
                    <?php echo HLP_get_crsf_field();?>
                    <div class="row mar_b_10">
                    <div class="col-sm-8">
                	<label style="color:#000 !important; margin-top:5px;"><input type="checkbox" id="mappingId" onclick="saveMappingdtl(this);" name="saveMapping" value="" style="opacity:1; margin-top:1px;"><span style="vertical-align: sub;" class="w_hit_col">Do You Want To Save This Mapping?&nbsp;&nbsp;</span></label>
                	<input type="text" id="mappText" name="mappingName" placeholder="Enter the name you want to save" style="display: none">
                	</div>
                	<div class="col-sm-4">
                	<div style="text-align: right" ><a href="<?php echo site_url('saved-salary-mappings/').$upload_id;?>" class="btn btn-success">Use Old Mappings</a></div>
                	</div>
                	</div>
                    <input type="hidden" name="hf_upload_id" value="<?php echo $upload_id; ?>" />
                        <table id="example" class="table border" style="width: 100%; cellspacing: 0;">
                            <thead>
                                <tr>
                                    <th class="hidden-xs" width="5%">S.No</th>
                                    <th>Header Name</th>
                                    <th> Mapping </th>
                                    <!--<th>Enter Display Name</th>-->
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                            <script>$ids = [];</script>
                             <?php $i=0; $ids;
                        
                            $ddl_map_opt_list = "";
                            $requiredFields =array();

                         	foreach($business_attribute_list as $row)
                             {
                             	if(($row["is_required"] == 1)){
                             		array_push($requiredFields,$row["display_name"]);
                             	}
                                 $ddl_map_opt_list .= "<option value='".$row["id"]."".CV_CONCATENATE_SYNTAX."".$row["ba_name"]."'>".$row["display_name"]."</option>";
                                 echo "<input name='hf_attribute_ids[]' value='".$row["id"]."' type='hidden' />"; 
                             }
                        	$requiredFields = array_unique($requiredFields);
                             foreach($header_list as $key=>$row)
                             {
                                echo "<td class='hidden-xs'>". ($i + 1) ."</td>";
                                echo "<td>".$row."</td>";
								 echo "<td><select name='ddl_mapping[]' onchange='selChange(this);' class='sel_mapp' id='sel_data".$i."' required>";
                                echo "<option value='N/A'> Select Mapping </option>";
                                echo $ddl_map_opt_list;						
                                echo "</select></td>";								
                                //echo "<td><input name='txt_head_name[]' value='".$row."' type='text' id='txt".$i."' />";                                
                                echo "</tr>";
                                $i++;
                             }
                             ?>  
                            </tbody>
                           </table>
                           
                        <div class="m-t-lg mob-center"> 
                        <?php if($requiredFields){ ?>                      
                             <input type="submit" class="btn btn-twitter m-b-sm add-btn" value="Save" id="btnSave7" />
                        <?php } ?>
                        </div>                    
                	</form>                    
                 </div>
            </div>
        </div>
    </div>
</div><!-- Row -->
</div>

<script>
$(document).ready(function(){
	function setSelected(){
		  <?php if(isset($savedMapping[0]["mapp_data"]) && ($savedMapping[0]["mapp_data"] != '')){ ?>
		    var setSelected = '<?php echo $savedMapping[0]["mapp_data"]; ?>';
		    $.each((JSON.parse(setSelected)),function(key,value){
		    	setTimeout(function(){selChange($("#sel_data"+key));},2000);
		    	document.getElementById('sel_data'+key).value=value;
				if((document.getElementById('sel_data'+key).value).trim()=="")
				{
					document.getElementById('sel_data'+key).value="N/A";
				}
		    });
		<?php  }?>

	}

	setTimeout(function(){setSelected();},2000);
});

function selChange(str)
{	
	var prevValue = $(str).data('previous');
	$('select').not(str).find('option[value="'+prevValue+'"]').show();    
	var value = $(str).val();
	$(str).data('previous',value); 
	
	if($(str).val() != 'N/A')
	{	
		$('select').not(str).find('option[value="'+value+'"]').hide(); 
	}
}

$(function()
{						
	$('#btnSave').click(function()
	{		
		var requredArray = new Array();
	    <?php foreach($requiredFields as $key => $val){ ?>
	        requredArray.push('<?php echo $val; ?>');
	    <?php } ?>
		var i = 0;var x = 0;var y = 0;var z = 0;var increment_applied_on = 0;
		$("select[name='ddl_mapping[]']").each( function (key, v)
		{
			if($(this).val() != 'N/A')
			{
				i = 1;
				var ddl_txt = $(this).find('option:selected').text();
				requredArray = jQuery.grep(requredArray, function(value){
					  return value != ddl_txt;
					});
				<?php /*?>var splt_arr = ($(this).val()).split('<?php echo CV_CONCATENATE_SYNTAX; ?>')
				if(requredArray.indexOf(splt_arr[1]) != '-1'){
					requredArray = jQuery.grep(requredArray, function(value) {
					  return value != splt_arr[1];
					});
					
				}<?php */?>								
			}			
		});
		if(i == 0)
		{
			custom_alert_popup("You must map the headers.");
			return false;	
		}
		else if(requredArray.length > 0)
		{
			var errorString = "Below mentioned fields are mandatory-\n";
			for(var i=0;i< requredArray.length;i++){
				errorString += requredArray[i]+"\n";
			}
			custom_alert_popup(errorString);
			return false;
		}		

		$("#loading").css('display','block');
	
		var str = "";
		var sel = "";
		var sel_type = "";
		var sel_mapp = "";
		
		$('#tbl_body input[type=text]').each(function ()
		{
			str+=$(this).val() + ",";		
		});
				
		$('#tbl_body .sel').each(function()
		{		
			sel += $(this).val() + ",";		
		});
		
		$('#tbl_body .sel_data').each(function()
		{
			sel_type += $(this).val() + ",";		
		});
		
		$('#tbl_body .sel_mapp').each(function()
		{
			sel_mapp += $(this).val() + ",";		
		});
		
		//To remove the extra $ at end  
		if(str != "") 
		{
			str = str.substring(0,str.length-1);
		}
		if(sel != "")
		{
			sel = sel.substring(0,sel.length - 1);
		}
		
		if(sel_type != "")
		{
			sel_type = sel_type.substring(0,sel_type.length - 1);
		}
		if(sel_mapp != "")
		{
			sel_mapp = sel_mapp.substring(0,sel_mapp.length - 1);
		}

		var form=$("#frm_mapping");
		$.ajax({
			type:"POST",
			url:"<?php echo site_url("upload/insert_headers");?>",
			data:form.serialize(),
		
			success: function(response)
	        {
	        	$("#loading").css('display','none');
	    		if(response)
	            {
					$('#loading').show();
	                window.location.href= "<?php echo site_url("update-approvel/".$upload_id);?>";
	    		} 
	            else
	            {
	            	window.location.href= "<?php echo site_url("upload-data");?>";
	                //show error
	    		}
			}
		});

	});		
});

function saveMappingdtl(isChecked){
	var isChecked = document.getElementById("mappingId").checked;
	if(isChecked == true){
		$('#mappText').show();
	}else{
		$('#mappText').val('');
		$('#mappText').hide();
	}
}
<?php if(!$requiredFields)
{?>
	$("#dv_error_msg").html('<div align="left" style="color:red;" id="notify"><span><b>Before mapping headers, you must have set Email ID business attributes as Active & Required.</b></span></div>');
<?php } ?>
</script>