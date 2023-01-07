<div id="main-wrapper" class="container">
<div class="col-md-3">
   <div class="mailbox-content">
       <div class="form-group">
           <?php $l=end($this->uri->segment_array()); 
           
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
<style>

body {

  width: 100%;
  height: 100%;
  position: relative;
}

svg {
    width: 100%;
    height: 100%;
    position: center;
}

text{
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
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

.legend {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 60%;
}

rect {
    stroke-width: 2;
}

text {
  font: 10px sans-serif;
}

.axis text {
  font: 10px sans-serif;
}

.axis path{
  fill: none;
  stroke: #000;
}

.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.axis .tick line {
  stroke-width: 1;
  stroke: rgba(0, 0, 0, 0.2);
}

.axisHorizontal path{
  fill: none;
}

.axisHorizontal line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.axisHorizontal .tick line {
  stroke-width: 1;
  stroke: rgba(0, 0, 0, 0.2);
}

.bar {
  fill: steelblue;
  fill-opacity: .9;
}

.x.axis path {
  display: none;
}

</style>
<body>
<div id="desig" style="position: absolute; margin-top: -52px"></div>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>

var margin = {top: (parseInt(d3.select('body').style('width'), 10)/10), right: (parseInt(d3.select('body').style('width'), 10)/20), bottom: (parseInt(d3.select('body').style('width'), 10)/5), left: (parseInt(d3.select('body').style('width'), 10)/20)},
    width = parseInt(d3.select('body').style('width'), 10) - margin.left - margin.right,
    height = parseInt(d3.select('body').style('height'), 10) - margin.top - margin.bottom;

var x0 = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var x1 = d3.scale.ordinal();

var y = d3.scale.linear()
    .range([height, 0]);

var colorRange = d3.scale.category20();
var color = d3.scale.ordinal()
    .range(colorRange.range());

var xAxis = d3.svg.axis()
    .scale(x0)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickFormat(d3.format(".2s"));

var divTooltip = d3.select("body").append("div").attr("class", "toolTip");


var svg = d3.select("#desig").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


var dataset = [
	<?php $str='';
	for($i=0;$i<count($res['DesignationTitle']);$i++) { ?>
	{label:"<?php echo $res['DesignationTitle'][$i]['DesignationTitle'] ?>", "Minimum":<?php echo $res['DesignationTitle'][$i]['Minimum'] ?>, "Maximum":<?php echo $res['DesignationTitle'][$i]['Maximum'] ?>, "Average": <?php echo $res['DesignationTitle'][$i]['avg'] ?>},
	<?php } ?>
    {label:"", "Minimum":15, "Maximum":30, "Average":40}
	 
];


var options = d3.keys(dataset[0]).filter(function(key) { return key !== "label"; });

dataset.forEach(function(d) {
    d.valores = options.map(function(name) { return {name: name, value: +d[name]}; });
});

x0.domain(dataset.map(function(d) { return d.label; }));
x1.domain(options).rangeRoundBands([0, x0.rangeBand()]);
y.domain([0, d3.max(dataset, function(d) { return d3.max(d.valores, function(d) { return d.value; }); })]);

svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis);

svg.append("g")
    .attr("class", "y axis")
    .call(yAxis)
    .append("text")
    .attr("transform", "rotate(-90)")
    .attr("y", 6)
    .attr("dy", ".71em")
    .style("text-anchor", "end")
    .text("");

var bar = svg.selectAll(".bar")
    .data(dataset)
    .enter().append("g")
    .attr("class", "rect")
    .attr("transform", function(d) { return "translate(" + x0(d.label) + ",0)"; });

bar.selectAll("rect")
    .data(function(d) { return d.valores; })
    .enter().append("rect")
    .attr("width", x1.rangeBand())
    .attr("x", function(d) { return x1(d.name); })
    .attr("y", function(d) { return y(d.value); })
    .attr("value", function(d){return d.name;})
    .attr("height", function(d) { return height - y(d.value); })
    .style("fill", function(d) { return color(d.name); });

bar
    .on("mousemove", function(d){
        divTooltip.style("left", d3.event.pageX+10+"px");
        divTooltip.style("top", d3.event.pageY-25+"px");
        divTooltip.style("display", "inline-block");
        var x = d3.event.pageX, y = d3.event.pageY
        var elements = document.querySelectorAll(':hover');
        l = elements.length
        l = l-1
        elementData = elements[l].__data__
        divTooltip.html((d.label)+"<br>"+elementData.name+"<br>"+elementData.value);
    });
bar
    .on("mouseout", function(d){
        divTooltip.style("display", "none");
    });


var legend = svg.selectAll(".legend")
    .data(options.slice())
    .enter().append("g")
    .attr("class", "legend")
    .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

legend.append("rect")
    .attr("x", width - 18)
    .attr("width", 18)
    .attr("height", 18)
    .style("fill", color);

legend.append("text")
    .attr("x", width - 24)
    .attr("y", 9)
    .attr("dy", ".35em")
    .style("text-anchor", "end")
    .text(function(d) { return d; });
    
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
 function getcycle(val)
 {
	$('#loading').show();
	
		urll='<?php echo base_url() ?>report/budget/'+val;
	
	
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
</script>
</body>