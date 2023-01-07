<?php 

 $l=end($this->uri->segment_array()); 

?>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active"><?php echo $breadcrumb ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
<div class="col-md-3">
   <div class="mailbox-content">
       <div class="form-group">
           <?php
           
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
           
           <label style="color: #000 !important">Select Report Type</label>
           <select class="form-control" id="foo" onchange="getType(this.value)">
            <option value="1" <?php echo $l1 ?>>Grade</option>
            <option value="2" <?php echo $l2 ?>>Level</option>
            <option value="3" <?php echo $l3 ?>>Designation/Title</option>
            </select>
           <p id="loading" style="display: none;">Please while loading.</p>
       </div>
       
        </div>
</div>
<!--<div class="col-md-3">
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
        </div></div> -->
</div>
<?php echo @$msg ?>
<div id="graph"></div>
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
    bottom: 100,
    left: 100 // change this to something larger like 100
  },
    width = 960,
    height = 450;

var x0 = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var x1 = d3.scale.ordinal();

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x0)
    .tickSize(10)
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
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .style('font-weight','bold')
      .text("Value");

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
        divTooltip.html((d.categorie)+"<br>"+elementData.rate+"<br>"+elementData.value+"");
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
	
		
			
 }
 
 function getcycle(val)
 {
	$('#loading').show();
	
		urll='<?php echo base_url() ?>report/budget/'+val;
	
	
        window.location.href =urll;
	
		
			
 }
</script>