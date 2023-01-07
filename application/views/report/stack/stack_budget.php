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
           
           
           <label style="color: #000 !important">Performance Cycle</label>
           <select class="form-control" id="foo"  onchange="getcycle(this.value)">
               
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
<?php //echo '<pre />'; print_r($res['Grade']) ?>
</div>
<?php echo @$msg ?>
<div id="graph"></div>
<style>
   
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
    .x.axis path {
        display: none;
    }
</style>
<script src="https://d3js.org/d3.v3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-legend/1.7.0/d3-legend.min.js"></script>
<script>
 function wrap(text, width) {
        text.each(function() {
            var text = d3.select(this),
                    words = text.text().split(/\s+/).reverse(),
                    word,
                    line = [],
                    lineNumber = 0,
                    lineHeight = 1.1, // ems
                    y = text.attr("y"),
                    dy = parseFloat(text.attr("dy")),
                    tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
            while (word = words.pop()) {
                line.push(word);
                tspan.text(line.join(" "));
                if (tspan.node().getComputedTextLength() > width) {
                    line.pop();
                    tspan.text(line.join(" "));
                    line = [word];
                    tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
                }
            }
        });
    }
    dataset = [
        <?php foreach($res['Grade'] as $k) { ?>
        {label:"<?php echo $k['label'] ?>", "Actual budget":<?php echo round($k['allocated_budget']) ?>, "Actual used budget":<?php echo round($k['actual_used_budget']) ?>, "variance": <?php echo round($k['variance']) ?>},
        <?php } ?>
        
        
    ];
    var margin = {
    top: 20,
    right: 100,
    bottom: 100,
    left: 100 // change this to something larger like 100
  },
    width = 960,
    height = 450;
    var x = d3.scale.ordinal()
            .rangeRoundBands([0, width], .1,.3);
    var y = d3.scale.linear()
            .rangeRound([height, 0]);
    var colorRange = d3.scale.category20();
    var color = d3.scale.ordinal()
            .range(colorRange.range());
    var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");
    var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left")
            .tickFormat(d3.format(".2s"));
    var svg = d3.select("#graph").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    var divTooltip = d3.select("#graph").append("div").attr("class", "toolTip");
    color.domain(d3.keys(dataset[0]).filter(function(key) { return key !== "label"; }));
    dataset.forEach(function(d) {
        var y0 = 0;
        d.values = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
        d.total = d.values[d.values.length - 1].y1;
    });
    x.domain(dataset.map(function(d) { return d.label; }));
    y.domain([0, d3.max(dataset, function(d) { return d.total; })]);
    svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);
    svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 9)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("My Graph");
     svg.select('.y').transition().duration(500).delay(1300).style('opacity','1');
    var bar = svg.selectAll(".label")
            .data(dataset)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.label) + ",0)"; });
    svg.selectAll(".x.axis .tick text")
            .call(wrap, x.rangeBand());
    svg.select('.x.axis').transition().duration(300).call(xAxis);         
    var bar_enter = bar.selectAll("rect")
    .data(function(d) { return d.values; })
    .enter();

bar_enter.append("rect")
    .attr("width", x.rangeBand())
    .attr("y", function(d) { return y(d.y1); })
    .attr("height", function(d) { return y(d.y0) - y(d.y1); })
    .style("fill", function(d) { return color(d.name); });

bar_enter.append("text")
    .text(function(d) { return d3.format(".2s")(d.y1-d.y0); })
    .attr("y", function(d) { return y(d.y1)+(y(d.y0) - y(d.y1))/2; })
    .attr("x", x.rangeBand()/3)
    .style("fill", '#ffffff');
    
    bar
            .on("mousemove", function(d){
                divTooltip.style("left", d3.event.pageX+10+"px");
                divTooltip.style("top", d3.event.pageY-100+"px");
                divTooltip.style("display", "inline-block");
                var elements = document.querySelectorAll(':hover');
                l = elements.length
                l = l-1
                element = elements[l].__data__
                value = element.y1 - element.y0
                divTooltip.html((d.label)+"<br>"+element.name+"<br>"+value);
            });
    bar
            .on("mouseout", function(d){
                divTooltip.style("display", "none");
            });
    svg.append("g")
            .attr("class", "legendLinear")
            .attr("transform", "translate(0,"+(height+30)+")");
    var legend = d3.legend.color()
            .shapeWidth(height/4)
            .shapePadding(10)
            .orient('horizontal')
            .scale(color);
    svg.select(".legendLinear")
            .call(legend);


function getType(val)
 {
     
	$('#loading').show();
        <?php if($this->uri->segment(2)=='get_crr_rpt_data_rating') { ?>
            
            var urll='<?php echo base_url() ?>report/get_crr_rpt_data_rating/'+val;
            
       <?php } else { ?>
                
	var urll='<?php echo base_url() ?>report/get_crr_rpt_data_function/'+val;
        <?php } ?>
        if(val!='')
        {
          window.location.href =urll;  
        }
        else {
            $('#graph').html('<div style="text-align: center;"><span style="color:red">Rule not found.</span></div>');
        }
	
 }
 <?php if($this->uri->segment(3)=='') { ?>
$( "#foo" ).trigger( "onchange" );
 <?php } ?>
function getcycle(val)
 {
	$('#loading').show();
	
		urll='<?php echo base_url() ?>stack/budget/'+val;
	
	
        window.location.href =urll;
	
		
			
 }
</script>