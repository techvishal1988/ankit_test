<script type = "text/javascript"  src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<div id="main-wrapper" class="container">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<div class="col-md-3">
   <div class="mailbox-content">
       <div class="form-group">
           <label style="color: #000 !important">Select Report Type</label>
           <select class="form-control" id="foo" onchange="getType(this.value)">
            <option value="1">Grade</option>
            <option value="2">Level</option>
            <option value="3">Designation/Title</option>
            </select>
           <p id="loading" style="display: none;">Please while loading.</p>
       </div>
        
        </div>
</div>
 <div class="col-md-3">
        <div class="mailbox-content">
            <div class="form-group">
           <label style="color: #000 !important">Performance Cycle</label>
           <select class="form-control"  onchange="getcycle(this.value)">
               <option value="">Please select cycle</option>
               <?php foreach($salary_cycles_list as $cl) {
                   
                   if($l==$cl['id'])
                   {
                       $sl='selected';
                   }
                   else {
                       $sl='';
                   }
                   ?>
               
               <option value="<?php echo $cl['id'] ?>" <?php echo $sl ?>> <?php echo $cl['name'] ?> </option>
              <?php } ?>
           </select>
       </div>
        </div></div>
</div>
<div id="graph" style="    margin-top: -50px;  position: absolute;"></div>
<script>
function getType(val)
 {
	$('#loading').show();
	var urll='';
	if(val==1)
	{
		urll='<?php echo base_url() ?>report/grade/'+val;
	}
	if(val==2)
	{
		urll='<?php echo base_url() ?>report/level/'+val;
	}
	if(val==3)
	{
		urll='<?php echo base_url() ?>report/designation/'+val;
	}
        window.location.href =urll;
	 $.ajax({
		  url: urll,
		  beforeSend: function( xhr ) {
			xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
		  }
		})
		  .success(function( data ) {
			$('#loading').hide();
			$('#graph').html(data);
		  });
		
			
 }

 $( "#foo" ).trigger( "onchange" );
 
 </script>
  