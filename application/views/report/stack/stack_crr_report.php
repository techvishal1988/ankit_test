<?php 


 $l=$this->uri->segment(3);

?>
<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="<?php echo site_url("dashboard"); ?>">Dashboard</a></li>
        <li class="active"><?php echo $breadcrumb ?></li>
    </ol>
</div>

<div id="main-wrapper" class="container">
    <div class="row">
<?php if(count($rule)!=0) { ?>    
<div class="col-md-3">
   <div class="mailbox-content">
       <div class="form-group">
           
           
           <label style="color: #000 !important">Select Rule</label>
           <select class="form-control" id="foo" onchange='$("#rptype").trigger("onchange");'>
               <?php foreach($rule as $cl) {
                   
                   if($l==$cl['id'])
                   {
                       $sl='selected';
                   }
                   else {
                       $sl='';
                   }
                   ?>
               
               <option value="<?php echo $cl['id'] ?>" <?php echo $sl ?>> <?php echo $cl['salary_rule_name'] ?> </option>
              <?php } ?>
            </select>
           <p id="loading" style="display: none;">Please while loading.</p>
       </div>
       
        </div>
</div>
<div class="col-md-3">
   <div class="mailbox-content">
       <div class="form-group">
           
           <?php
           
           if($this->uri->segment(4)=='r')
           {
               $rat='selected';
           }
           else if($this->uri->segment(4)=='f'){
               $fun='selected';
           }
           ?>
           <label style="color: #000 !important">Select Type</label>
           <select class="form-control" id="rptype" onchange="getType(this.value)">
               <option value="f" <?php echo $fun ?> >Function</option>
               <option value="r" <?php echo $rat ?>>Rating</option>
            </select>
           <p id="loading" style="display: none;">Please while loading.</p>
       </div>
       
        </div>
    
</div>
    <div class="col-md-3" style="    margin-top: 38px;">
        <!--<a id="download" href="#">Download</a>-->
        <input type="button" id="create_pdf" class="btn  btn-primary" value="Generate PDF">  
    </div>    
<?php echo @$msg ?>
    </div>
    <div class="row">
        <div class="col-md-12">
    <div id="datafordownload">
<div id="graph"></div>
<hr />
<?php if(!isset($msg)) {  $array=['<75','75-90','90-120','>120']; //echo '<pre />'; print_r($res) ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                    <th>#</th>
                    <?php foreach($res as $value)
                            { 
                                if($value['performance_rating']!='')
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
                    <th>Total</th>

                </thead>
                <tbody>
                    <?php 
                    foreach($array as $key=>$val)
                    { ?>
                    <tr>
                        <td>CRR Range - <?php if($val=='avg') {echo 'Average';} else {echo ucfirst(str_replace('_',' ',$val));} ?></td>
                        <?php   
                        $total=0;
                        foreach($res as $v)
                            { 
                             $total+=$v[$val];
                              ?>
                              
                                    <td><?php echo HLP_get_formated_amount_common(($v[$val]),2) ?>%</td>
                                   
                               
                    <?php  }?> 
                                    <td><?php echo HLP_get_formated_amount_common($total,2) ?>%</td>
                    </tr>
                        <?php } ?>
                </tbody>

            </table>
            </div>
<?php } ?>
</div>
<?php } else echo 'Cycle rule not found'; ?>
        </div>
    </div>
</div>

<style>
   
    svg {
        width: 100%;
        height: 100%;
        position: center;
    }
    
    .toolTip {
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
        <?php foreach($res as $k=>$v) {
            
            if($v['name'] =='')
            {
                 $name=$v['performance_rating'];
            }
            else {
                $name=$v['name'];
            }
            ?>
            {label:"<?php echo $name ?>",     
            <?php 
           foreach($v as $key=>$val) 
           { if($key!=='id' && $key!='name' && $key!='performance_rating') { ?>
                <?php echo '"'.$key.'":'.'"'.$val.'",' ?> 
                   
           <?php }}
            ?>
         },
        <?php } ?>
        
        
    ];
    var margin = {
    top: 35,
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
    y.domain([0, d3.max(dataset, function(d) {return d.total; })]);
     svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis)
        .selectAll("text")	
            .style("text-anchor", "end")
            .style("font-weight", "bold")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-15)" 
                });
    svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
        .attr("x", (width / 2))             
        .attr("y", 0 - ((margin.top / 2)-0))
        .attr("text-anchor", "middle")  
        .style("font-size", "16px") 
        .style("text-decoration", "underline")  
        .text("Population Distribution on CR Range");
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
    .text(function(d) { console.log(d); return d3.format(".2s")(d.y1-d.y0)+'%'; })
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
                divTooltip.html((d.label)+"<br>CRR Range - "+element.name+"<br>"+value+"%");
            });
    bar
            .on("mouseout", function(d){
                divTooltip.style("display", "none");
            });
    svg.append("g")
            .attr("class", "legendLinear")
            .attr("transform", "translate(0,"+(height+50)+")");
    var legend = d3.legend.color()
            .shapeWidth(height/4)
            .shapePadding(10)
            .orient('horizontal')
            .scale(color);
    svg.select(".legendLinear")
            .call(legend);
 var download = d3.select("#download");
           download.on("click", function(){
            saveSvgAsPng(document.getElementsByTagName("svg")[0], "graph.png", {backgroundColor: "#FFFFFF"});
          });

function getType(val)
 {
     //alert(val);
     var rptype=$('#foo').val();
	$('#loading').show();
        var f='';
        if(val==='r')
        {
            f='get_crr_rpt_data_rating';
        }
        else if(val==='f')
        {
            f='get_crr_rpt_data_function';
        }
        <?php if($this->uri->segment(2)=='get_crr_rpt_data_rating') { ?>
            
            var urll='<?php echo base_url() ?>stack/'+f+'/'+rptype+'/'+val;
            
       <?php } else { ?>
                
	var urll='<?php echo base_url() ?>stack/'+f+'/'+rptype+'/'+val;
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
$( "#rptype" ).trigger( "onchange" );
 <?php } ?>
</script>