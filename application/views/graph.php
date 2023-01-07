<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active">Graph</li>
    </ol>
</div>
<div class="page-title" style="background: #fff;border: none;">
       <?php 
       $total=0;
            foreach($attr as $at)
                {
                    if($at['value']!='')
                    {
                       $total=$total+ $at["value"];
                      
                    }
                }
                
        ?>
    <div class="container">
         <div class="row text-center">
            <div class="col-md-12" id="piechart" style="width: 900px; height: 500px;">
                </div>
             <div class="centerLabel">
                 <?php echo HLP_get_formated_amount_common($total) ?>
                 <p id="totalsal">Total Salary</p>
             </div>
            
        </div>

        

        <div class="clearfix"></div>

    </div>

</div>
<style>
.piechart
{
    position: relative;
}


.centerLabel
{
   position: absolute;
    left: 387px;
    top: 285px;
    font-size: 20px;
    text-align: center;
    color: black;
}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Salary Components'],
          //['Work',     11],
          <?php 
            $val='';
                foreach($attr as $at)
                {
                    if($at['value']!='')
                    {
                        $val.= "['".$at["display_name"]."',".$at["value"]."],";
                        
                    }
                }
                echo rtrim($val,',');
               
          
          ?>
        ]);

        var options = {
          title: 'Salary Components',
          pieHole: 0.4,
          pieSliceText: 'value-and-percentage',
          pieSliceTextStyle: {
            color: '#fff',
          },
          
           
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>


