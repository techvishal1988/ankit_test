var chartColors = ['#ADD8E6','#6495ED','#4682B4','#4169E1','#191970','#87CEFA','#87CEEB','#00BFFF','#B0C4DE','#1E90FF'];
var store = null;
var isLoading = true;

function getInch(px) {
    return Math.round(px / 95.999999998601);
}

function ChartPlugin() {

	Highcharts.setOptions({
        lang: {
            noData: 'No data is available in the graph',
        },
        plotOptions: {
           showInLegend: false,
            column: {
                stacking: 'percent'
			},
		series: {
                borderWidth: 0,
				dataLabels: {
                    enabled: true,
                    crop: false,
                    overflow: 'none',
                    style: {
                        fontSize:'12px',
                        color: '#000',
                        fontFamily: 'Century Gothic Regular',
                        textOutline: false ,
                        textShadow: false,
                    },
                    allowOverlap: false,
                    formatter: function() {
                        if(this.percentage) { 
                            return get_formated_percentage_common(this.percentage, 1) + '%'
                        }
                    },
                },
                animation: {
                    duration: 1000
                },
			}
        },
        colors: chartColors,
        yAxis: {
            gridLineWidth: 0,
            minorGridLineWidth: 0,
            min: 0,
            title: {
               text: null
            },
            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px",
                    fontWeight:'600'
                }
            },
            stackLabels: {
                //enabled: true,
            }
        },
        xAxis: {
            title: {
               text: null
            },
            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px",
                     fontWeight:'600'
                },
            }
        },
        chart: {
            type: 'column',
            style: {
                fontFamily: 'Century Gothic Regular',
                color: "#000",
                fontWeight:'600'
            }
        },
        exporting: exportOptions(), 
    });
}

(function(API){
    API.textCenter = function(txt, options, x, y) {
        options = options ||{};
        if( options.align == "center" ){
            var fontSize = this.internal.getFontSize();
            var pageWidth = this.internal.pageSize.width;
            txtWidth = this.getStringUnitWidth(txt)*fontSize/this.internal.scaleFactor;
            x = ( pageWidth - txtWidth ) / 2;
        }
        this.text(txt,x,y);
    }
})(jsPDF.API);

function exportCharts() {
    var node = $('#chartNode').closest('div')
    var w = getInch(node.width())
    var h = getInch(node.height()) + 1.5
    $('.loader').show()
    window.setTimeout(function() {
        domtoimage.toPng(node[0])
            .then(function (dataUrl) {
                var doc = new jsPDF('p', 'in', [w, h]),
                    text = "Servay Results Dashobard"
                doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('servay-results-dashboard.pdf')
                $('.loader').hide()
            });
    }, 100)
}

function exportCsv(data) {
    var ws = XLSX.utils.json_to_sheet(data)
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Servay Results Dashboard');
    XLSX.writeFile(wb, "servay-results-dashboard.xlsx");
}

var alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');

function getMappedChar(index) {
    return alphabets[index]
}

var Store = function() {
    function Store() {
        this.originalEmps = []
        this.questions = []
        this.allFilters = []
        this.dataSet = [],
        this.quesType5Data = [];
        this.quesType4Data = [];
        this.quesType6Data = [];
        this.maxQuestionLength = 100;
        this.legendImportanceName = 'Importance';
        this.legendSatisfactionName = 'Satisfaction';
    }

    Store.prototype.buildData = function() {

        this.getquesType4Data();
        this.getquesType5Data();
        this.getquesType6Data();

    }


    Store.prototype.getquesType4Data = function(filters) {
        var self = this;
        _.forEach(this.quesType4Data, function(que, index) {

            var titleTruncated  = que.question.slice(0, self.maxQuestionLength) + (que.question.length > self.maxQuestionLength ? '...' : '');
            var chartConfig     = {};
            var data            = [];
            var labels          = [];
            var rankTitle       = 'Frequency of Rank-';

            chartConfig = {
                xAxis: {
                    categories: [],
                },
                chart: {
                    renderTo: 'chart_4_' + index,
                    animation: Highcharts.svg
                },             
                series: [],
            },

            _.forEach(que.rank_arr, function(rankVal, rankKey) {
                data.push({
                    name: rankTitle + rankVal,
                    tack: 'post',
                    color: chartColors[rankKey],
                    data: []
                })
            });

            _.forEach(que.sub_arr, function(c, mIndex) {

                var rankArr = [];
                var q_id    = 0;
                var j       = 0;

                _.forEach(c.options, function(optionVal, optionKey) {
                    q_id = optionVal.question_id;
                    rankArr[j] = optionVal.rank;
                    j++;
                });

                _.forEach(que.rank_arr, function(rVal, rKey) {

                    if($.inArray(rVal, rankArr) == -1){

                        c.options.push({
                            rank: rVal,
                            total_emps: 0,
                            question_id:q_id
                        })
                    }
                });
            });

            _.forEach(que.sub_arr, function(c, mIndex) {

                var labelTruncated  = c.sub_question.slice(0, self.maxQuestionLength) + (c.sub_question.length > self.maxQuestionLength ? '...' : '');
                    labels.push(labelTruncated);

                _.forEach(c.options, function(optVal, optKey) {

                    data = _.map(data.slice(0), function(item) {

                        if (item.name === (rankTitle + optVal.rank)) {

                            var percentage  = 0;
                            var tot_emps    = 0;

                            if(optVal.total_emps && c.total_participants && optVal.total_emps) {
                                percentage = (optVal.total_emps / c.total_participants) * 100; 
                            }

                            if(optVal.total_emps) {
                                tot_emps = Number(optVal.total_emps);
                            }

                            item.data.push({
                                y: tot_emps,
                                percentage: percentage,
                            })
                        }

                        return item;
                    })
                });
            });

            chartConfig.xAxis.categories = labels;
            chartConfig.series           = data;

            self.dataSet.push(_.assign({}, chartConfig, {
                plotOptions: {
                    column: {
                        stacking: 'percent'
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                //    handleChartClick(this.mappedLabels, this.index, index, this.name)
                                }
                            }
                        },
                    }
                },
                tooltip: {
                    formatter: function () { 
                        return chartTooltipOption(this.series.name, this.y, this.percentage);
                    },
                },
                title: {
                    useHTML: true,
                    text: '<div title="' + que.question + '">' + titleTruncated + '</div>'
                },
            }))
        })
    }

    Store.prototype.getquesType5Data = function(filters) {
        var self = this;
        _.forEach(this.quesType5Data, function(que, index) {

            var titleTruncated  = que.question.slice(0, self.maxQuestionLength) + (que.question.length > self.maxQuestionLength ? '...' : '');
            var chartConfig     = {};
            var data            = [];
            var labels          = [];
            var setOptions      = true;

            chartConfig = {
                xAxis: {
                    categories: [],
                },
                chart: {
                    renderTo: 'chart_5_' + index,
                    animation: Highcharts.svg
                },        
                series: [],
            },

            _.forEach(que.sub_arr, function(c, mIndex) {

                var labelTruncated  = c.sub_question.slice(0, self.maxQuestionLength) + (c.sub_question.length > self.maxQuestionLength ? '...' : '');
                    labels.push(labelTruncated);

                if(setOptions) {

                    var colorIndex = 0;

                    _.forEach(c.options, function(optVal, optKey) {

                        data.push({
                            name: optKey,
                            stack: 'post',
                            color: chartColors[colorIndex],
                            data: [],
                        });
                        colorIndex++;
                    });
                }

                _.forEach(c.options, function(optVal, optKey) {

                    data = _.map(data.slice(0), function(item) {
 
                        if (item.name === optKey) {

                            percentage = 0;

                            if(c.total_participants && optVal.length) {
                                percentage = (optVal.length / c.total_participants) * 100; 
                            }

                            item.data.push({
                                y: optVal.length,
                                percentage: percentage,
                            })
                        }
                        return item;
                    })

                });

                setOptions = false;
            })

            chartConfig.xAxis.categories = labels;
            chartConfig.series           = data;
            
            self.dataSet.push(_.assign({}, chartConfig, {
                plotOptions: {
                    column: {
                        stacking: 'percent'
                    },
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function() {
                                //    handleChartClick(this.mappedLabels, this.index, index, this.name)
                                }
                            }
                        },
                    }
                },
                tooltip: {
                    formatter: function () { 
                        return chartTooltipOption(this.series.name, this.y, this.percentage);
                    },
                },
                title: {
                    useHTML: true,
                    text: '<div title="' + que.question + '">' + titleTruncated + '</div>'
                },
            }))
        })
    }

    Store.prototype.getquesType6Data = function() {

        var self = this;
        _.forEach(this.quesType6Data, function(que, index) {

            var titleTruncated  = que.question.slice(0, self.maxQuestionLength) + (que.question.length > self.maxQuestionLength ? '...' : '');
            var chartConfig     = {};
            var data            = [];
            var labels          = [];
            var colorIndex      = 0;

            chartConfig = {
                xAxis: {
                    categories: [],
                },
                chart: {
                    renderTo: 'chart_6_' + index,
                    type: 'column',
                    animation: Highcharts.svg
                },
                series: [],
            },

            _.forEach(que.legend, function(legendVal, legendKey) {

                    data.push({
                        name: legendVal,
                        stack: 'post',
                        color: chartColors[colorIndex],
                        data: [],
                    });
                    colorIndex++;
            });

            _.forEach(que.sub_arr, function(c, mIndex) {

                var labelTruncated  = c.sub_question.slice(0, self.maxQuestionLength) + (c.sub_question.length > self.maxQuestionLength ? '...' : '');

                labels.push(labelTruncated);

                data = _.map(data.slice(0), function(item) {

                    if (item.name === self.legendImportanceName) {

                        percentage = 0;

                        item.data.push({
                            y: c.avg_importance,
                            percentage: percentage,
                        });

                    } else if (item.name === self.legendSatisfactionName) {
                        percentage = 0;

                        item.data.push({
                            y: c.avg_satisfaction,
                            percentage: percentage,
                        });

                        }
                    return item;
                })

            })

            chartConfig.xAxis.categories = labels;
            chartConfig.series           = data;

            self.dataSet.push(_.assign({}, chartConfig, {
            plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        stacking: ''
                    },
                    series: {
                        cursor: 'pointer',
                        colorByPoint: false,
                         borderWidth: 0,
                         dataLabels: {
                            formatter: function() {
                                if(this.y) {
                                    return get_formated_amount_common(this.y, 2);
                                }
                            },
                        },
                        point: {
                            events: {
                                click: function() {
                                //    handleChartClick(this.mappedLabels, this.index, index, this.name)
                                }
                            }
                        },
                    }
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + ':</b> ' + get_formated_amount_common(this.y, 2);
                    },
                },
                title: {
                    useHTML: true,
                    text: '<div title="' + que.question + '">' + titleTruncated + "<br><span style='font-size:14px'> Total Participants: " + que.total_participants + '</span></div>'
                },
            }))
        })
    }

    Store.prototype.filterData = function(filters) {
        this.questions = _.map(this.originalEmps, _.clone);
        this.allFilters = filters;

        if (filters.length) {
            for (var x = 0; x < filters.length; x++) {
                var currentQue = this.questions[filters[x].dataIndex];
                var currentChoice = _.filter(currentQue.choices, function(c) {
                    return c.choice === filters[x].filter;
                })[0];

                _.map(this.questions, function(que) {
                    que.choices = _.filter(que.choices, function(c) {
                        return _.filter(currentChoice.employees, function(emp) {
                            return c.employees.indexOf(emp) > -1;
                        }).length > 0
                    })
                    return que;
                })
            }
        }

        this.buildData();
    }

    return Store
}()

var allFilters = [];

function chartTooltipOption(name, value, percentage) {

    var str = '<b>' + name + '</b><br>';

    //round off value
    if(value) {
        value = get_formated_amount_common(value);
    }

    if(percentage) {
        percentage = get_formated_percentage_common(percentage);
    }

    if (Number.isInteger(percentage)) {//for integer
        per = Math.round(percentage);
    } else {//for float
        per = Math.round(percentage * 10) / 10 ;
    }

    str += 'Number of Employees: ' + value + ' (' + percentage + '%)';

    return str;
}

function handleChartClick(data, index, type, label) {
    if (_.isArray(data)) {
        data = data[0]
    }
    var hasFilter = _.findIndex(allFilters.slice(), function(f) { return f.filter === data })
    if (hasFilter >= 0) {
        allFilters = _.filter(allFilters.slice(), function(f) { return f.filter !== data })
    } else {
        allFilters.push({
            dataIndex: type,
            filter: data,
            index: index,
            label: label
        })
    }
    store.filterData(allFilters)
    updateVisibleFilters(allFilters);
    createCharts();
}

function removeVisibleFilter(filters, index) {
    filters.splice(index, 1);
    store.filterData(filters);
    updateVisibleFilters(filters);
    createCharts();
}

function updateVisibleFilters(filters) {
    var filterElm = $('.filters')
    var appliedFilters = $('#appliedFilters')
    appliedFilters.html('')
    _.map(filters, function(item, index) {
        var div = $('<div class="filter-item"></div>')
        var cross = $('<span class="cross">&times;</span>')
        div.append(item.label + '. ' + item.filter)
        div.append(cross)
        appliedFilters.append(div)
        cross.click(function() {
            removeVisibleFilter(filters, index)
        })
        return item;
    })
}

function Provider(ReportURL) {
    return $.get(ReportURL)
}

function buildCharts() {
    ChartPlugin();

    $('#exportPdf').click(function () {
        exportCharts();
    });

    $('#exportCsv').click(function () {
        exportCsv(store.questions);
    });

    Highcharts.getOptions().colors = Highcharts.map(
        Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.2).get('rgb')] // darken
                ]
            };
        }
    );

    renderCharts()
}

function createChartNode() {
    return [
        '<div class="col-md-6">',
        '<div class="card mb-4">',
        '<div class="card-body">',
        '<div id="" class="w-100" style="height: 300px"></div>',
        '</div>',
        '</div>',
        '</div>'
    ].join('')
}

function renderCharts() {

    var chartNode = $('#chartNode')
    _.forEach(store.dataSet, function(data) {
        if (store.dataSet.length === 1) {
            var node = $(createChartNode());
            node.addClass('offset-md-3');
            node.find('.w-100').attr('id', data.chart.renderTo);
            chartNode.append(node);
        } else {
            var node = $(createChartNode());
            node.find('.w-100').attr('id', data.chart.renderTo)
            chartNode.append(node);
        }
    })
    createCharts();
}

function createCharts() {
    _.forEach(store.dataSet, function(data) {
        new Highcharts.Chart(data);
    })
}

function App(ReportURL) {
    store = new Store();
    Provider(ReportURL).then(function(data) {

        if(data.statusCode == 200)
        {
            if(data.quesType4Data !="") {
                store.quesType4Data = data.quesType4Data;
            }

            if(data.quesType5Data !="") {
                store.quesType5Data = data.quesType5Data;
            }

            if(data.quesType6Data !="") {
                store.quesType6Data = data.quesType6Data;
            }

            if(data.data !="") {
                //store.questions = data.data
                //store.originalEmps = data.data
            }

            store.buildData();
            buildCharts();
		}
		else
		{
			custom_alert_popup("No record found.");
        }

        isLoading = false;
        $('.loader').hide();

    })
}
