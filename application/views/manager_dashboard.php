<div class="page-title">
    <div class="container">
        <div class="page-title-heading">
            <h3>Sourabh Gupta</h3>
        </div>
        <div class="page-title-controls">
            <ul>
                <li>
                    <a href="#"><i class="fa fa-circle"></i> Open</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bookmark"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-pencil"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-trash-o"></i></a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div id="main-wrapper" class="container">
	<div class="row">
        <div class="col-lg-3">
            <div class="salary-box">
                <div class="salary-box-title">
                    <h1>RS 300000</h1>
                </div>
                <div class="salary-box-title">
                    <h1><span class="salary-orange-box">75</span> %</h1>
                </div>
                <div class="salary-info">
                    <p>CURRENT</p>
                    <p>COMPARATIVE</p>
                    <p>RATIO</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="salary-big-box">
                <div class="salary-box-title">
                    <h1>Salary Increase</h1> <h1><span class="salary-blue-box">78</span> %</h1> <h1>RS 600000</h1>
                </div>
                <div class="salary-box-sub-title">
                    <h1>PREVIOUS CTC 3.0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="salary-box">
                <div class="salary-box-title">
                    <h1>RS 300000</h1>
                </div>
                <div class="salary-box-title">
                    <h1><span class="salary-green-box">78</span> %</h1>
                </div>
                <div class="salary-info">
                    <p>REVISED</p>
                    <p>COMPARATIVE</p>
                    <p>RATIO</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="chart-box">
                <div class="chart-title">
                    <h2>Salary Movement Chart</h2>
                </div>
                <div class="chart-details">
                    <div id="salary_movement_chart" class="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-box">
                <div class="chart-title">
                    <h2>Current Market Positioning</h2>
                </div>
                <div class="chart-details">
                    <div id="current_market_positioning" class="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-box">
                <div class="chart-title">
                    <h2>Comparison with Peers</h2>
                </div>
                <div class="chart-details">
                    <div id="comparison_with_peers" class="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-box">
                <div class="chart-title">
                    <h2>Comparison with Team</h2>
                </div>
                <div class="chart-details">
                    <div id="comparison_with_team" class="chart"></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawSalaryMovementChart);
        function drawSalaryMovementChart() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
                ['2004/05',  165,      938,         522,             998,           450,      614.6],
                ['2005/06',  135,      1120,        599,             1268,          288,      682],
                ['2006/07',  157,      1167,        587,             807,           397,      623],
                ['2007/08',  139,      1110,        615,             968,           215,      609.4],
                ['2008/09',  136,      691,         629,             1026,          366,      569.6]
            ]);
            var options = {
                title : 'Monthly Coffee Production by Country',
                vAxis: {title: 'Cups'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('salary_movement_chart'));
            chart.draw(data, options);
        }
        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCurrentMarketPositioning);
        function drawCurrentMarketPositioning() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
                ['2004/05',  165,      938,         522,             998,           450,      614.6],
                ['2005/06',  135,      1120,        599,             1268,          288,      682],
                ['2006/07',  157,      1167,        587,             807,           397,      623],
                ['2007/08',  139,      1110,        615,             968,           215,      609.4],
                ['2008/09',  136,      691,         629,             1026,          366,      569.6]
            ]);
            var options = {
                title : 'Monthly Coffee Production by Country',
                vAxis: {title: 'Cups'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('current_market_positioning'));
            chart.draw(data, options);
        }
        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawComparisonWithPeers);
        function drawComparisonWithPeers() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
                ['2004/05',  165,      938,         522,             998,           450,      614.6],
                ['2005/06',  135,      1120,        599,             1268,          288,      682],
                ['2006/07',  157,      1167,        587,             807,           397,      623],
                ['2007/08',  139,      1110,        615,             968,           215,      609.4],
                ['2008/09',  136,      691,         629,             1026,          366,      569.6]
            ]);
            var options = {
                title : 'Monthly Coffee Production by Country',
                vAxis: {title: 'Cups'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('comparison_with_peers'));
            chart.draw(data, options);
        }
        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawComparisonWithTeam);
        function drawComparisonWithTeam() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
                ['2004/05',  165,      938,         522,             998,           450,      614.6],
                ['2005/06',  135,      1120,        599,             1268,          288,      682],
                ['2006/07',  157,      1167,        587,             807,           397,      623],
                ['2007/08',  139,      1110,        615,             968,           215,      609.4],
                ['2008/09',  136,      691,         629,             1026,          366,      569.6]
            ]);
            var options = {
                title : 'Monthly Coffee Production by Country',
                vAxis: {title: 'Cups'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            var chart = new google.visualization.ComboChart(document.getElementById('comparison_with_team'));
            chart.draw(data, options);
        }
		
		$(window).resize(function(){
			drawSalaryMovementChart();
			drawCurrentMarketPositioning();
			drawComparisonWithPeers();
			drawComparisonWithTeam();
		});

    </script>
</div>