var backgroundColors = ["#00bcd4", "#00bcd4", "#00bcd4", "#00bcd4", "#00bcd4", "#00bcd4", "#00bcd4"]
var chartColors = [
    '#f4b37a',
    '#c65d60',
    '#d38f94',
    '#af9d97',
    '#babbc1',
    '#467aa8',
    '#ffe09e',
    '#9c96aa',
    '#6fb3ce',
    '#f4b37a',
    '#c65d60',
    '#d38f94',
    '#af9d97',
    '#babbc1',
    '#467aa8',
    '#ffe09e',
    '#9c96aa',
    '#6fb3ce',
    '#f4b37a',
    '#c65d60',
    '#d38f94',
    '#af9d97',
    '#babbc1',
    '#467aa8',
    '#ffe09e',
    '#9c96aa',
    '#6fb3ce',
]
var greenColor = '#00bcd4'
var fadedColor = '#eeeeee'
var store = null;
var isLoading = true;

var dataKeys = {
    "businessUnit3": "business_level_3",
    "ratio_range": "comparative_ratio_range",
    "grade": "grade",
    "level": "level",
    "function": "function",
    "perfRating": "performance_rating",
    "gender": "gender",
    "country": "country",
    "city": "city"
}

var chartNames = {
    'buLoc': 'buLoc',
    'grade': 'grade',
    'level': 'level',
    'function': 'function',
    'rating': 'rating',
    'tenure': 'tenure',
    'city': 'city',
    'country': 'country',
    'gender': 'gender'
}

function getDateDiff(d) {
    return moment().diff(d, 'years')
}

function getInch(px) {
    return Math.round(px / 95.999999998601);
}

function ChartPlugin() {
    Highcharts.theme = {
        colors: chartColors,
        chart: {
            style: {
                fontFamily: '\'Unica One\', sans-serif'
            },
            plotBorderColor: '#e1e1e1'
        },
        title: {
            style: {
                color: '#4a4a4a',
                textTransform: 'uppercase',
                fontSize: '20px'
            }
        },
        subtitle: {
            style: {
                color: '#4a4a4a',
                textTransform: 'uppercase'
            }
        },
        xAxis: {
            gridLineColor: '#e1e1e1',
            labels: {
                style: {
                    color: '#4a4a4a'
                }
            },
            lineColor: '#e1e1e1',
            minorGridLineColor: '#e1e1e1',
            tickColor: '#e1e1e1',
            title: {
                style: {
                    color: '#4a4a4a'
                }
            }
        },
        yAxis: {
            gridLineColor: '#e1e1e1',
            labels: {
                style: {
                    color: '#4a4a4a'
                }
            },
            lineColor: '#e1e1e1',
            minorGridLineColor: '#e1e1e1',
            tickColor: '#e1e1e1',
            tickWidth: 1,
            title: {
                style: {
                    color: '#4a4a4a'
                }
            }
        },
        tooltip: {
            backgroundColor: 'rgba(255,255,255,0.8)',
            style: {
                color: '#4a4a4a'
            }
        },
        plotOptions: {
            series: {
                dataLabels: {
                    color: '#4a4a4a',
                    style: {
                        textOutline: 'none'
                    }
                },
                marker: {
                    lineColor: '#333'
                },
                borderWidth: 0
            },
            boxplot: {
                fillColor: '#505053'
            },
            candlestick: {
                lineColor: 'white'
            },
            errorbar: {
                color: 'white'
            }
        },
        legend: {
            itemStyle: {
                color: '#4a4a4a'
            },
            itemHoverStyle: {
                color: '#ccc'
            }
        },
        credits: {
            style: {
                color: '#666'
            }
        },
        labels: {
            style: {
                color: '#707073'
            }
        },
        drilldown: {
            activeAxisLabelStyle: {
                color: '#F0F0F3'
            },
            activeDataLabelStyle: {
                color: '#F0F0F3'
            }
        },
        navigation: {
            buttonOptions: {
                symbolStroke: '#DDDDDD',
                theme: {
                    fill: '#505053'
                }
            }
        },
        rangeSelector: {
            buttonTheme: {
                fill: '#505053',
                stroke: '#000000',
                style: {
                    color: '#CCC'
                },
                states: {
                    hover: {
                        fill: '#707073',
                        stroke: '#000000',
                        style: {
                            color: 'white'
                        }
                    },
                    select: {
                        fill: '#000003',
                        stroke: '#000000',
                        style: {
                            color: 'white'
                        }
                    }
                }
            },
            inputBoxBorderColor: '#505053',
            inputStyle: {
                backgroundColor: '#333',
                color: 'silver'
            },
            labelStyle: {
                color: 'silver'
            }
        },
        navigator: {
            handles: {
                backgroundColor: '#666',
                borderColor: '#AAA'
            },
            outlineColor: '#CCC',
            maskFill: 'rgba(255,255,255,0.1)',
            series: {
                color: '#7798BF',
                lineColor: '#A6C7ED'
            },
            xAxis: {
                gridLineColor: '#505053'
            }
        },
        scrollbar: {
            barBackgroundColor: '#808083',
            barBorderColor: '#808083',
            buttonArrowColor: '#CCC',
            buttonBackgroundColor: '#606063',
            buttonBorderColor: '#606063',
            rifleColor: '#FFF',
            trackBackgroundColor: '#404043',
            trackBorderColor: '#404043'
        },
        legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
        background2: '#505053',
        dataLabelsColor: '#B0B0B3',
        textColor: '#4a4a4a',
        contrastTextColor: '#F0F0F3',
        maskColor: 'rgba(255,255,255,0.3)'
    };

    // Apply the theme
    Highcharts.setOptions(Highcharts.theme);

    Highcharts.getSVG = function (charts) {
        var svgArr = [],
            top = 0,
            width = 0;

        Highcharts.each(charts, function (chart) {
            var svg = chart.getSVG(),
                svgWidth = +svg.match(
                    /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
                )[1],
                svgHeight = +svg.match(
                    /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
                )[1];

            svg = svg.replace(
                '<svg',
                '<g transform="translate(0,' + top + ')" '
            );
            svg = svg.replace('</svg>', '</g>');

            top += svgHeight;
            width = Math.max(width, svgWidth);

            svgArr.push(svg);
        })

        return '<svg height="' + top + '" width="' + width +
            '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
            svgArr.join('') + '</svg>';
    }
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

function exportCharts(charts) {
    var node = $('#chartNode')
    var w = getInch(node.width())
    var h = getInch(node.height())
    $('.loader').show()
    window.setTimeout(function() {
        domtoimage.toPng(node[0])
            .then(function (dataUrl) {
                var doc = new jsPDF('p', 'in', [w, h]),
                    text = "Composition Dashobard"
                //doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('composition-dashboard.pdf')
                $('.loader').hide()
            });
    }, 100)
}

function exportCsv(data) {
    var ws = XLSX.utils.json_to_sheet(data)
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Composition Dashboard');
    XLSX.writeFile(wb, "Composition-dashboard.xlsx");
}

var Store = function() {
    function Store() {
        this.originalEmps = []
        this.employees = []
        this.allFilters = []
    }

    Store.prototype.buildData = function() {
        this.crossEmps = crossfilter(this.employees);
        this.allRatioRange = this.getUniqueByKey(dataKeys.ratio_range)
        this.ratioRangeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.ratio_range] })
        this.getCountryDataset()
        this.getCityDataset()
        this.getCurrentBUDataset();
        this.getGradeData()
        this.getLevelData()
        this.getFunctionData()
        this.getPerRatingData()
        this.getGenderData()
    }

    Store.prototype.getCountryDataset = function() {
        this.countries = this.getUniqueByKey(dataKeys.country)
        this.countryDim = this.crossEmps.dimension(function(d) { return d[dataKeys.country] })
        this.countryData = this.getBarPercentage(this.countryDim, this.ratioRangeDim, this.countries, this.allRatioRange)
    }

    Store.prototype.getCityDataset = function() {
        this.cities = this.getUniqueByKey(dataKeys.city)
        this.cityDim = this.crossEmps.dimension(function(d) { return d[dataKeys.city] })
        this.cityData = this.getBarPercentage(this.cityDim, this.ratioRangeDim, this.cities, this.allRatioRange)
    }

    Store.prototype.getCurrentBUDataset = function(filter) {
        this.buLevelThreeValues = this.getUniqueByKey(dataKeys.businessUnit3)
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getBarPercentage(this.buLevelThreeDim, this.ratioRangeDim, this.buLevelThreeValues, this.allRatioRange);
    }

    Store.prototype.getGradeData = function(filter) {
        this.gradeKeys = this.getUniqueByKey(dataKeys.grade)
        this.gradeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.grade] })
        this.gradeData = this.getBarPercentage(this.gradeDim, this.ratioRangeDim, this.gradeKeys, this.allRatioRange)
    }

    Store.prototype.getLevelData = function(filter) {
        this.levelKeys = this.getUniqueByKey(dataKeys.level)
        this.levelDim = this.crossEmps.dimension(function(d) { return d[dataKeys.level] })
        this.levelData = this.getBarPercentage(this.levelDim, this.ratioRangeDim, this.levelKeys, this.allRatioRange)
    }

    Store.prototype.getFunctionData = function(filter) {
        this.functionKeys = this.getUniqueByKey(dataKeys.function)
        this.functionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.function] })
        this.functionData = this.getBarPercentage(this.functionDim, this.ratioRangeDim, this.functionKeys, this.allRatioRange)
    }

    Store.prototype.getPerRatingData = function(filter) {
        this.prefRatingKeys = this.getUniqueByKey(dataKeys.perfRating)
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getBarPercentage(this.perfRatingDim,  this.ratioRangeDim, this.prefRatingKeys, this.allRatioRange)
    }

    Store.prototype.getGenderData = function(filter) {
        this.genderKeys = this.getUniqueByKey(dataKeys.gender)
        this.genderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.gender] })
        this.genderData = this.getBarPercentage(this.genderDim,  this.ratioRangeDim, this.genderKeys, this.allRatioRange)
    }

    Store.prototype.getBarPercentage = function(dim, otherDim, keys, otherKeys) {
        var data = []
        var labels = []
        var dataSet = {
            xAxis: {
                categories: [],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify'
                }
            },
            series: []
        }

        for (var i = 0; i < otherKeys.length; i++) {
            data.push({
                name: otherKeys[i],
                data: []
            })
        }

        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            var dl = dim.top(Infinity).length
            if (dl > 0)
                for (var j = 0; j < otherKeys.length; j++) {
                    otherDim.filter(otherKeys[j])
                    var o = otherDim.top(Infinity).length
                    var dr = Math.round((o / dl) * 100)
                    data = _.map(data.slice(0), function(item) {
                        if (item.name === otherKeys[j]) {
                            item.data.push(dr)
                        }
                        return item
                    })
                }
            dim.filter(null)
            otherDim.filter(null)
        }

        dataSet.xAxis.categories = labels;
        dataSet.series = data;

        return dataSet;
    }

    Store.prototype.filterData = function(filters) {
        this.employees = this.originalEmps.slice(0);
        this.allFilters = filters;
        if (filters.length) {
            for (var x = 0; x < filters.length; x++) {
                var curF = filters[x]
                if (chartNames.buLoc === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.businessUnit3] === curF.filter
                    })
                } else if (chartNames.grade === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.grade] === curF.filter
                    })
                } else if (chartNames.level === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.level] === curF.filter
                    })
                } else if (chartNames.function === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.function] === curF.filter
                    })
                } else if (chartNames.rating === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.perfRating] === curF.filter
                    })
                } else if (chartNames.gender === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.gender] === curF.filter
                    })
                } else if (chartNames.country === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.country] === curF.filter
                    })
                } else if (chartNames.city === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.city] === curF.filter
                    })
                }
            }
        }

        this.buildData();
    }

    Store.prototype.getUniqueByKey = function(key) {
        var loc = []
        for (var i = 0; i < this.employees.length; i++) {
            if (!loc.includes(this.employees[i][key])) {
                loc.push(this.employees[i][key])
            }
        }
        return loc.sort();
    }

    return Store
}()

var allFilters = [];

function handleChartClick(data, index, type) {
    if (_.isArray(data)) {
        data = data[0]
    }
    var hasFilter = _.findIndex(allFilters.slice(), function(f) { return f.filter === data })
    if (hasFilter >= 0) {
        allFilters = _.filter(allFilters.slice(), function(f) { return f.filter !== data })
    } else {
        allFilters.push({
            type: type,
            filter: data,
            index: index
        })
    }
    store.filterData(allFilters)
    updateVisibleFilters(allFilters);
    buBarChart()
}

function removeVisibleFilter(filters, index) {
    filters.splice(index, 1);
    store.filterData(filters);
    updateVisibleFilters(filters);
    buBarChart();
}

function getTitleAttrib(filter) {
    if (filter.type === chartNames.buLoc) {
        return 'BU: ' + filter.filter
    } else if (filter.type === chartNames.grade) {
        return 'Grade: ' + filter.filter
    } else if (filter.type === chartNames.level) {
        return 'Level: ' + filter.filter
    } else if (filter.type === chartNames.function) {
        return 'Function: ' + filter.filter
    } else if (filter.type === chartNames.rating) {
        return 'Rating: ' + filter.filter
    } else {
        return 'Tenure: ' + filter.filter
    }
}

function updateVisibleFilters(filters) {
    var filterElm = $('.filters')
    var appliedFilters = $('#appliedFilters')
    appliedFilters.html('')
    _.map(filters, function(item, index) {
        var div = $('<div class="filter-item"></div>')
        var cross = $('<span class="cross">&times;</span>')
        div.attr('title', getTitleAttrib(item))
        div.append(item.filter)
        div.append(cross)
        appliedFilters.append(div)
        cross.click(function() {
            removeVisibleFilter(filters, index)
        })
        return item;
    })
    // if (filters.length)
    //     filterElm.show()
    // else
    //     filterElm.hide()
}

function Provider(dataurl) {
    return $.get(dataurl)
}

var threeBarChart,
    gradeChart,
    levelChart,
    functionChart,
    ratingChart,
    tenureChart,
    countryChart,
    cityChart,
    genderChart;

function buildCharts() {
    ChartPlugin()

    $('#exportPdf').click(function () {
        exportCharts([threeBarChart, gradeChart]);
    });

    $('#exportCsv').click(function () {
        exportCsv(store.employees);
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

    buBarChart()
}

function buBarChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit1',
            type: 'column'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.buLoc)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by BU'
        },
    }, store.buLevelThreeData)

    threeBarChart = new Highcharts.Chart(chartOptions)
    updateCharts()
}

function updateCharts() {
    buildCountryChart()
    buildCityChart()
    buildGradeChart()
    buildLevelChart()
    buildFunctionChart()
    buildPerfRatingChart()
    buildGenderChart()
}

function buildCountryChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'countryChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.country)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by Country'
        },
    }, store.countryData)

    countryChart = new Highcharts.Chart(chartOptions)
}

function buildCityChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'cityChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.city)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by City'
        },
    }, store.cityData)

    cityChart = new Highcharts.Chart(chartOptions)
}

function buildGradeChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByGrade',
            type: 'bar'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.grade)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by Grade'
        },
    }, store.gradeData)
    gradeChart = new Highcharts.Chart(chartOptions)
}

function buildLevelChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByLevel',
            type: 'bar'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.level)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by Level'
        },
    }, store.levelData)
    levelChart = new Highcharts.Chart(chartOptions)
}

function buildFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByFunction',
            type: 'bar'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.function)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by Function'
        },
    }, store.functionData)

    functionChart = new Highcharts.Chart(chartOptions)
}

function buildPerfRatingChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'perfRating',
            type: 'bar'
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.rating)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by Performance Rating'
        },
    }, store.perfRatingData)

    ratingChart = new Highcharts.Chart(chartOptions)
}

function buildGenderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'genderChart',
            type: 'bar'
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.gender)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'left',
                    y: 10,
                    formatter: function() {
                        return this.y + '%'
                    }
                }
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'Comp Positioning by Gender'
        },
    }, store.genderData)

    genderChart = new Highcharts.Chart(chartOptions)
}

function App(dataurl) {
    store = new Store();
    Provider(dataurl).then(function(data) {
        store.employees = data.data
        store.originalEmps = data.data
        store.buildData()
        buildCharts()
        isLoading = false
    })
}
