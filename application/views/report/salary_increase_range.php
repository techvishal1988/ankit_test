<?php 

  $l=$this->uri->segment(3);//end($this->uri->segment_array()); 
 $rpt_for = "Base";
 if($this->uri->segment(4)=="Target" or $this->uri->segment(4)=="Total")
 {
	 $rpt_for = $this->uri->segment(4);
 } 

?>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active"><?php echo $breadcrumb ?></li>
    </ol>
</div>
<div class="page-title">
    <div id="main-wrapper" class="container">
    	<div class="text-center mt-4">
              <?php
			  		$val=array(0);
                    $tooltip=getToolTip('salary-increase-range-analysis-report');
					if($tooltip)
					{
						$val=json_decode($tooltip[0]->step);
					}
                    
                    ?>
              <h3 style="margin-bottom:10px">Salary Increase Range Analysis <span style=" float: none;" type="button" class="tooltipcls" data-toggle="tooltip control-label" data-placement="bottom" title="" data-original-title="<?php echo $val[0] ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></h3>
            </div>
        <div class="row">
        	
            <div class="col-md-3">
               <div class="mailbox-content" style="background:#f5f5f5;">
                   <div class="form-group">
                       <?php
                       $l1=1;
                       $l2=$l3="";
                       if($l==1)
                       {
                           $l1='selected';
                       }
                       if($l==2)
                       {
                           $l2='selected';
                       }
                       if($l==3)
                       {
                           $l3='selected';
                       }
                       
                       ?>
                       
                       <label style="color: #000 !important">Report Type</label>
                       <select class="form-control" id="foo" onchange="getType(this.value)">
                        <option value="1" <?php echo $l1 ?>>Function & Rating</option>
                        <option value="2" <?php echo $l2 ?>>Function</option>
                        <option value="3" <?php echo $l3 ?>>Rating</option>
                        </select>
                       <p id="loading" style="display: none;">Please while loading.</p>
                   </div>
                   
                    </div>
            </div>
            <div class="col-sm-9 text-right" style="margin-top: 24px;">
                <button id="create_pdf" class="btn-default">
                    <img src="<?php echo base_url('assets/reports') ?>/icons/PDF-Icon.png" alt="download pdf">
                </button>
            </div>
            <?php /*?><div class="col-md-3" style="    margin-top: 38px;">
                    <!--<a id="download" href="#">Download</a>-->
                    <input type="button" id="create_pdf" class="btn  btn-primary" value="Generate PDF">  
                </div><?php */?>
        <?php echo @$msg ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                 <div id="datafordownload">
    <div id="graph"></div>
    <hr />
    <?php if(!isset($msg)) {  $array=['Minimum_hike','Average_hike','Maximum_hike']; //echo '<pre />'; print_r($res) ?>
    <div class="table-responsive">
        <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <?php foreach($res as $value)
                                { 
                            if(isset($value['performance_rating']) and $value['performance_rating']!='')
                            {
                                $name=$value['performance_rating'];
                            }
                            else
                            {
                                $name=$value['name'];
                            }
                                     //echo $value['Level'];
                                    echo '<th>'.$name.'</th>';
                                }
                        
                                  ?>
                        <!--<th>Total</th>-->
    
                    </thead>
                    <tbody>
                        <?php 
                        foreach($array as $key=>$val)
                        { ?>
                        <tr>
                            <td><?php if($val=='avg') {echo 'Average';} else {echo ucfirst(str_replace('_',' ',$val));} ?></td>
                            <?php   
                            $total=0;
                            foreach($res as $v)
                                { 
                                 $total+=$v[$val];
                                  ?>
                                  
                                        <td><?php echo HLP_get_formated_amount_common(($v[$val]),2) ?>%</td>
                                       
                                   
                        <?php  }?> 
                                       <?php /*?> <td><?php echo number_format($total,2) ?>%</td><?php */?>
                        </tr>
                            <?php } ?>
                    </tbody>
    
                </table>
    </div>
    <?php } ?>
    </div>
            </div>
        </div>
       
    </div>
</div>
<style>



.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {
  display: none;
}
.toolTip {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    position: absolute;
    display: none;
    width: auto;
    height: auto;
    background: none repeat scroll 0 0 white;
    border: 0 none;
    border-radius: 8px 8px 8px 8px;
    box-shadow: -3px 3px 15px #888888;
    color: black;
    font: 12px sans-serif;
    padding: 5px;
    text-align: center;
}
</style>
<script src="https://d3js.org/d3.v3.min.js"></script>
<script>

var margin = {
    top: 20,
    right: 100,
    bottom: 120,
    left: 100 // change this to something larger like 100
  },
    width = 960,
    height = 300;

var x0 = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var x1 = d3.scale.ordinal();

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x0)
    .tickSize(0)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");
var divTooltip = d3.select("body").append("div").attr("class", "toolTip");
var color = d3.scale.ordinal()
    .range(["#3274B1","#f4a582","#d5d5d5","#92c5de","#0571b0"]);

var svg = d3.select('#graph').append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("<?php echo $graphurl ?>", function(error, data) {

  var categoriesNames = data.map(function(d) { return d.categorie; });
  var rateNames = data[0].values.map(function(d) { return d.rate; });

  x0.domain(categoriesNames);
  x1.domain(rateNames).rangeRoundBands([0, x0.rangeBand()]);
  y.domain([0, d3.max(data, function(categorie) { return d3.max(categorie.values, function(d) { return d.value; }); })]);

  svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis)
        .selectAll("text")	
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-30)" 
                });

  svg.append("g")
      .attr("class", "y axis")
      .style('opacity','0')
      .call(yAxis)
  .append("text")
        .attr("x", (width / 2))             
        .attr("y", 0 - ((margin.top / 2)-5))
        .attr("text-anchor", "middle")  
        .style("font-size", "16px") 
        .style("text-decoration", "underline");  
        //.text("Salary Increase Range Analysis");

  svg.select('.y').transition().duration(500).delay(1300).style('opacity','1');

  var slice = svg.selectAll(".slice")
      .data(data)
      .enter().append("g")
      .attr("class", "g")
      .attr("transform",function(d) { return "translate(" + x0(d.categorie) + ",0)"; });

  slice.selectAll("rect")
      .data(function(d) { return d.values; })
  .enter().append("rect")
      .attr("width", x1.rangeBand())
      .attr("x", function(d) { return x1(d.rate); })
      .style("fill", function(d) { return color(d.rate) })
      .attr("y", function(d) { return y(0); })
      .attr("height", function(d) { return height - y(0); })
      .on("mouseover", function(d) {
          d3.select(this).style("fill", d3.rgb(color(d.rate)).darker(2));
      })
      .on("mouseout", function(d) {
          d3.select(this).style("fill", color(d.rate));
      });

  slice.selectAll("rect")
      .transition()
      .delay(function (d) {return Math.random()*1000;})
      .duration(1000)
      .attr("y", function(d) { return y(d.value); })
      .attr("height", function(d) { return height - y(d.value); });
slice.on("mousemove", function(d){
    console.log(d);
        divTooltip.style("left", d3.event.pageX+10+"px");
        divTooltip.style("top", d3.event.pageY-25+"px");
        divTooltip.style("display", "inline-block");
        var x = d3.event.pageX, y = d3.event.pageY
        var elements = document.querySelectorAll(':hover');
        l = elements.length
        l = l-1
        elementData = elements[l].__data__
        console.log(elementData);
        divTooltip.html((d.categorie)+"<br>"+elementData.rate+"<br>"+d3.format(".2g")(elementData.value)+"%");
    });
slice.on("mouseout", function(d){
        divTooltip.style("display", "none");
    });
  //Legend
  var legend = svg.selectAll(".legend")
      .data(data[0].values.map(function(d) { return d.rate; }).reverse())
  .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d,i) { return "translate(0," + i * 20 + ")"; })
      .style("opacity","0");

  legend.append("rect")
      .attr("x", width + 50)
      .attr("width", 18)
      .attr("height", 20)
      .style("fill", function(d) { return color(d); });

  legend.append("text")
      .attr("x", width + 45)
      .attr("y", 9)
      .attr("dy", ".35em")
      .style("text-anchor", "end")
      .text(function(d) {return d; });

  legend.transition().duration(500).delay(function(d,i){ return 1300 + 100 * i; }).style("opacity","1");

});
var download = d3.select("#download");
           download.on("click", function(){
            saveSvgAsPng(document.getElementsByTagName("svg")[0], "graph.png", {backgroundColor: "#FFFFFF"});
          });

function getType(val)
 {
	$('#loading').show();
	var urll='';
	if(val==1)
	{
		urll='<?php echo base_url() ?>report/salary_increase_both/'+val;
	}
	if(val==2)
	{
		urll='<?php echo base_url() ?>report/get_salary_increase_rpt_data_function/'+val;
	}
	if(val==3)
	{
		urll='<?php echo base_url() ?>report/get_salary_increase_rpt_data_rating/'+val;
	}
        window.location.href =urll;
	
		
			
 }
 
 function getcycle(val)
 {
	$('#loading').show();
	
		urll='<?php echo base_url() ?>report/budget/'+val;
	
	
        window.location.href =urll;
	
		
			
 }
</script>