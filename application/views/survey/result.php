<?php //echo '<pre />'; print_r($this->session->userdata('company_bg_img_url_ses')) ?>
    <!-- Bootstrap core CSS -->
   
   <link href="<?php echo base_url() ?>assets/salary/css/style.css" rel="stylesheet" type="text/css">
 
  <style>
      
.bg{
 // background: url(<?php echo $this->session->userdata('company_bg_img_url_ses') ?>);
  background-size:cover;
}

/*Start shumsul*/
    .page-inner{
		padding:0 0 40px;
			  background: url(<?php echo $this->session->userdata('company_bg_img_url_ses'); ?>) 0 0 no-repeat !important;
              background-size: cover !important;
		}
		
/*End shumsul*/


.piechart
{
    position: relative;
    display: block;
    margin: 0 auto;
}
.centerLabel
{
    position: absolute;
    margin-left: 477px;
    text-align: center;
    margin-top: -270px;
}
@media(max-width:640px){
	.centerLabel
{
    position: absolute;
    margin-left: 124px;
    text-align: center;
    margin-top: -270px;
    font-size: 15px;
}
#totalsal{
font-size:10px;	
}
	
}
</style> 
   
   <?php 
   error_reporting(0);
//  echo '<pre />';
//  print_r($salary_dtls);
//   
	?>
   <div id="popoverlay" class=" popoverlay"></div>
   <div class="bg">
       <div class="container">
        <div class="row">
           
            <div class="col-md-12">
              
            <div class="card-2">
                
                <div id="piechart" style="width: 100%; height: 450px;padding: 0px;">
                </div>
                 
               
               
            </div>
            
	</div>
           
        </div>
    </div>
   </div>
   <?php //echo '<pre />'; print_r($result); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawdontpie);

      function drawdontpie() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Status'],
          //['Work',     11],
          <?php 
            $value='';
                foreach($result as $key=>$val)
                {
                    
                        $value.= "['".$key."',".$val."],";
                        
                    
                }
                echo rtrim($value,',');
               
          
          ?>
        ]);

        var options = {
          //title: 'Salary Components',
          pieHole: 0.4,
          pieSliceText: 'value-and-percentage',
          pieSliceTextStyle: {
            color: '#fff',
          },
          legend: 'bottom',
           chartArea : {left:20,top:20,width:"90%",height:"80%"}
          
           
        };

        var chartt = new google.visualization.PieChart(document.getElementById('piechart'));
        
        chartt.draw(data, options);
      }
    </script>