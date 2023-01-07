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
    "businessUnit1": "Business_Unit_level_1_top_level_in_the_organisation",
    "businessUnit2": "Business_Unit_level_2_next_level_up_in_the_organisation",
    "businessUnit3": "Business_Unit_3_current_business_unit_of_the_employee",
    "education": "Educational_qualification_Key_skill",
    "talent": "Identified_Critical_talent",
    "position": "Identified_critical_position",
    "maternity": "Special_category_maternity_dissability_etc",
    "joiningDate": "Date_of_Joining_the_company",
    "incPurposes": "Date_of_joining_for_Increment_purposes",
    "startDate": "Start_date_for_role_for_bonus_calculation_only",
    "endDate": "End_date_of_the_role_for_bonus_calculation_only",
    "salesIncentive": "Bonus_Sales_Incentive_applicable",
    "perfRating": "Performance_Rating_for_this_fiscal_year"
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

function formatLabelName(label, length) {
    if (label.length < length) return [label];
    let splitLoc = label.indexOf(' ', length);

    if (splitLoc === -1) {
        splitLoc = label.lastIndexOf(' ', length);
    }

    if (splitLoc >= 0) {
        return [label.substr(0, splitLoc), label.substr(splitLoc + 1)];
    } else {
        return [label];
    }
}

function ceilToNearest(num) {
    let len = Math.ceil(Math.log10(Math.abs(num) + 1))
    let divisor = Math.pow(10, (len - 1) === 0 ? 1 : (len - 1))
    if (num % divisor > 0) {
        return (Math.round(num / divisor) + 1) * divisor
    }
    return Math.round(num / divisor) * divisor
}

function findMax(arr) {
    var i = 0;
    var max = -Infinity
    while(i < arr.length) {
        max = Math.max(arr[i], max)
        i += 1
    }
    return max
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

function getInch(px) {
    return Math.round(px / 95.999999998601);
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
    var h = getInch(node.height()) + 1.5
    $('.loader').show()
    window.setTimeout(function() {
        domtoimage.toPng(node[0])
            .then(function (dataUrl) {
                var doc = new jsPDF('p', 'in', [w, h]),
                    text = "Head Count Dashobard"
                //doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('head-count-dashboard.pdf')
                $('.loader').hide()
            });
    }, 100)
}

function exportCsv(data) {
    var ws = XLSX.utils.json_to_sheet(data)
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Compben Dashboard');
    XLSX.writeFile(wb, "Compben-dashboard.xlsx");
}

var Store = function() {
    function Store() {
        this.originalEmps = []
        this.employees = []
        this.crossEmps = null
        this.buLevelOneDim = {}
        this.buLevelOneData = {}
        this.buLevelTwoDim = {}
        this.buLevelTwoData = {}
        this.buLevelThreeDim = {}
        this.buLevelThreeData = {}
        this.functionDim = {}
        this.functionData = {}
        this.perfRatingDim = {}
        this.perfRatingData = {}
        this.tenureDim = {}
        this.tenureData = {}
        this.levelDim = {}
        this.levelData = {}
        this.gradeDim = {}
        this.gradeData = {}
        this.countryDim = {}
        this.countryData = {}
        this.cityDim = {}
        this.cityData = {}
        this.locations = []
        this.groups = []
        this.levelUpOrg = []
        this.grades = []
        this.levels = []
        this.functions = []
        this.perfRatings = []
        this.countries = []
        this.cities = []
        this.today = new Date()
        this.allFilters = []
    }

    Store.prototype.buildData = function() {
        this.crossEmps = crossfilter(this.employees);
        this.groups = this.getUniqueByKey(dataKeys.businessUnit1)
        this.locations = this.getUniqueByKey(dataKeys.businessUnit3)
        this.levelUpOrg = this.getUniqueByKey(dataKeys.businessUnit2)
        this.grades = this.getUniqueByKey('Grade')
        this.levels = this.getUniqueByKey('Level')
        this.functions = this.getUniqueByKey('Function')
        this.perfRatings = this.getUniqueByKey(dataKeys.perfRating)
        this.countries = this.getUniqueByKey('Country')
        this.cities = this.getUniqueByKey('City')
        this.getCurrentBUDataset()
        this.getGradeData()
        this.getLevelData()
        this.getFunctionData()
        this.getPerRatingData()
        this.getTenureData()
        this.getCountryDataset()
        this.getCityDataset()
        this.getGenderData()
    }

    Store.prototype.update = function() {
        this.buLevelThreeData = this.getBarHeadCount(this.buLevelThreeDim, this.locations);
        this.gradeData = this.getHeadCountPie(this.gradeDim, this.grades)
        this.levelData = this.getHeadCountPie(this.levelDim, this.levels)
        this.functionData = this.getHeadCount(this.functionDim, this.functions)
        this.perfRatingData = this.getHeadCount(this.perfRatingDim, this.perfRatings)
        this.tenureData = this.formatTenureData()
    }

    Store.prototype.getTenureData = function() {
        this.tenureDim = this.crossEmps.dimension(function(d) { return d[dataKeys.startDate] })
        this.tenureData = this.formatTenureData()
    }

    Store.prototype.formatTenureData = function() {
        var dataTop = this.tenureDim.top(Infinity)
        var set01 = 0
        var set13 = 0
        var set25 = 0
        var set510 = 0
        var set10 = 0
        var data = []
        var dataSet = {
            xAxis: {
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
            series: [],
        }

        for (var i = 0; i < dataTop.length; i++) {
            var startDate = dataTop[i][dataKeys.startDate]
            var diff = getDateDiff(new Date(startDate));
            if (diff >= 0 && diff < 1) {
                set01 += 1
            } else if (diff >= 1 && diff < 3) {
                set13 += 1
            } else if (diff >= 2 && diff < 5) {
                set25 += 1
            } else if (diff >= 5 && diff < 10) {
                set510 += 1
            } else {
                set10 += 1
            }
        }

        var colorIndex = _.filter(this.allFilters, function(d) {
            return d.type === chartNames.tenure
        })

        if (set01 > 0) {
            if (colorIndex.length)
                data.push({
                    name: '0-1 yrs',
                    y: set01,
                    color: chartColors[colorIndex[0].index]
                })
            else
                data.push({
                    name: '0-1 yrs',
                    y: set01
                })
        }
        if (set13 > 0) {
            if (colorIndex.length)
                data.push({
                    name: '1-3 yrs',
                    y: set01,
                    color: chartColors[colorIndex[0].index]
                })
            else
                data.push({
                    name: '1-3 yrs',
                    y: set13
                })
        }
        if (set25 > 0) {
            if (colorIndex.length)
                data.push({
                    name: '2-5 yrs',
                    y: set25,
                    color: chartColors[colorIndex[0].index]
                })
            else
                data.push({
                    name: '2-5 yrs',
                    y: set25
                })
        }
        if (set510 > 0) {
            if (colorIndex.length)
                data.push({
                    name: '5-10 yrs',
                    y: set510,
                    color: chartColors[colorIndex[0].index]
                })
            else
                data.push({
                    name: '5-10 yrs',
                    y: set510
                })
        }
        if (set10 > 0) {
            if (colorIndex.length)
                data.push({
                    name: '>10 yrs',
                    y: set10,
                    color: chartColors[colorIndex[0].index]
                })
            else
                data.push({
                    name: '>10 yrs',
                    y: set10
                })
        }

        dataSet.series.push({
            data: data
        })

        return dataSet;
    }

    Store.prototype.getBuLevelOneData = function(filter) {
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] })
        this.buLevelOneData = this.getHeadCount(this.buLevelOneDim, this.groups)
    }

    Store.prototype.getCurrentBUDataset = function(filter) {
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getBarHeadCount(this.buLevelThreeDim, this.locations);
    }

    Store.prototype.getCountryDataset = function(filter) {
        this.countryDim = this.crossEmps.dimension(function(d) { return d['Country'] })
        this.countryData = this.getBarHeadCount(this.countryDim, this.countries)
    }

    Store.prototype.getCityDataset = function(filter) {
        this.cityDim = this.crossEmps.dimension(function(d) { return d['City'] })
        this.cityData = this.getBarHeadCount(this.cityDim, this.cities)
    }

    Store.prototype.getBuLevelTwoData = function(filter) {
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] })
        this.buLevelTwoData = this.getHeadCount(this.buLevelOneDim, this.levelUpOrg)
    }

    Store.prototype.getGradeData = function(filter) {
        this.gradeDim = this.crossEmps.dimension(function(d) { return d['Grade'] })
        this.gradeData = this.getHeadCountPie(this.gradeDim, this.grades, chartNames.grade)
    }

    Store.prototype.getLevelData = function(filter) {
        this.levelDim = this.crossEmps.dimension(function(d) { return d['Level'] })
        this.levelData = this.getHeadCountPie(this.levelDim, this.levels, chartNames.level)
    }

    Store.prototype.getFunctionData = function(filter) {
        this.functionDim = this.crossEmps.dimension(function(d) { return d['Function'] })
        this.functionData = this.getHeadCount(this.functionDim, this.functions, 'Function')
    }

    Store.prototype.getPerRatingData = function(filter) {
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getHeadCount(this.perfRatingDim, this.perfRatings)
    }

    Store.prototype.getGenderData = function(filter) {
        this.genderKeys = this.getUniqueByKey('Gender')
        this.genderDim = this.crossEmps.dimension(function(d) { return d['Gender'] })
        this.genderData = this.getHeadCountPie(this.genderDim, this.genderKeys, 'Gender')
    }

    Store.prototype.getBarHeadCount = function(dim, keys, filter) {
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

        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            var dl = dim.top(Infinity).length
            if (dl > 0) {
                data.push({
                    y: dl,
                    dataLabels: {
                        y: (dl / 1.3)
                    }
                })
            }
            dim.filter(null)
        }

        dataSet.xAxis.categories = labels;
        dataSet.series.push({
            data: data,
            showInLegend: false
        })

        return dataSet;
    }

    Store.prototype.getHeadCount = function(dim, keys, filter) {
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

        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            var dl = dim.top(Infinity).length
            if (dl > 0) {
                if (filter === 'Function') {
                    data.push({
                        y: dl,
                        dataLabels: {
                            y: dl / 1.7
                        }
                    })
                } else {
                    data.push({
                        y: dl,
                        dataLabels: {
                            y: dl
                        }
                    })
                }
            }
            dim.filter(null)
        }

        dataSet.xAxis.categories = labels;
        dataSet.series.push({
            data: data,
            showInLegend: false
        })

        return dataSet;
    }

    Store.prototype.getHeadCountPie = function(dim, keys, filter) {
        var data = []
        var dataSet = {
            xAxis: {
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

        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            var dl = dim.top(Infinity).length
            if (dl > 0) {
                var colorIndex = _.filter(this.allFilters, function(d) {
                    return d.type === filter
                })
                if (colorIndex.length)
                    data.push({
                        name: keys[i],
                        y: dl,
                        color: chartColors[colorIndex[0].index]
                    })
                else
                    data.push({
                        name: keys[i],
                        y: dl
                    })
            }
        }
        dim.filter(null)

        dataSet.series.push({
            data: data
        })

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
                        return d['Grade'] === curF.filter
                    })
                } else if (chartNames.level === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d['Level'] === curF.filter
                    })
                } else if (chartNames.function === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d['Function'] === curF.filter
                    })
                } else if (chartNames.rating === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.perfRating] === curF.filter
                    })
                } else if (chartNames.gender === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d['Gender'] === curF.filter
                    })
                } else if (chartNames.tenure === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        var diff = getDateDiff(new Date(d[dataKeys.startDate]));
                        if (curF.filter === '0-1 yrs') {
                            return diff >= 0 && diff < 1
                        }
                        if (curF.filter === '1-3 yrs') {
                            return diff >= 1 && diff < 3
                        }
                        if (curF.filter === '2-5 yrs') {
                            return diff >= 2 && diff < 5
                        }
                        if (curF.filter === '5-10 yrs') {
                            return diff >= 5 && diff < 10
                        }
                        if (curF.filter === '>10 yrs') {
                            return diff >= 10
                        }
                        return []
                    })
                } else if (chartNames.country === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d['Country'] === curF.filter
                    })
                } else if (chartNames.city === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d['City'] === curF.filter
                    })
                }
            }
        }

        this.buildData();
    }

    Store.prototype.getUniqueByKey = function(key) {
        var loc = []
        for (var i = 0; i < this.employees.length; i++) {
            if (loc.indexOf(this.employees[i][key]) === -1 && this.employees[i][key]) {
                loc.push(this.employees[i][key])
            }
        }
        return loc;
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

function Provider(GRAPHAPIURL) {
    return $.get(GRAPHAPIURL)
}

var threeBarChart = null,
    gradeChart = null,
    levelChart = null,
    functionChart = null,
    ratingChart = null,
    tenureChart = null,
    countryChart = null,
    cityChart = null,
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
                    align: 'center',
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += 'Number of Employees: ' + this.y
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'HC by BU'
        },
    }, store.buLevelThreeData)

    threeBarChart = new Highcharts.Chart(chartOptions)
    updateCharts()
}

function updateCharts() {
    buildGradeChart()
    buildCountryChart()
    buildCityChart()
    buildLevelChart()
    buildFunctionChart()
    buildPerfRatingChart()
    buildTenureChart()
    buildGenderChart()
}

function buildCountryChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'countryChart',
            type: 'column'
        },
        plotOptions: {
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
                    align: 'center',
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += 'Number of Employees: ' + this.y
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'HC by Country'
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
                    align: 'center',
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += 'Number of Employees: ' + this.y
                return s;
            }
        },
        exporting: {
            enabled: false
        },
        title: {
            text: 'HC by City'
        },
    }, store.cityData)

    cityChart = new Highcharts.Chart(chartOptions)
}

function buildGradeChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByGrade',
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: '40%',
                depth: 25,
                showInLegend: true
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.grade)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage * 100) / 100 + '%';
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.y + ' (' + Math.round(this.percentage * 100) / 100 + '%)'
                return s;
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        title: {
            text: 'HC By Grade'
        },
        exporting: {
            enabled: false
        }
    }, store.gradeData)
    gradeChart = new Highcharts.Chart(chartOptions)
}

function buildLevelChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByLevel',
            type: 'pie'
        },
        plotOptions: {
            pie: {
                innerSize: '40%',
                depth: 25,
                showInLegend: true
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.level)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage * 100) / 100 + '%';
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.y + ' (' + Math.round(this.percentage * 100) / 100 + '%)'
                return s;
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        title: {
            text: 'HC By Level'
        },
        exporting: {
            enabled: false
        }
    }, store.levelData)
    levelChart = new Highcharts.Chart(chartOptions)
}

function buildFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByFunction',
            type: 'column'
        },
        plotOptions: {
            series: {
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'center',
                },
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.function)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += 'Number of Employees: ' + this.y
                return s;
            }
        },
        title: {
            text: 'HC By Function'
        },
        exporting: {
            enabled: false
        }
    }, store.functionData)

    functionChart = new Highcharts.Chart(chartOptions)
}

function buildPerfRatingChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'perfRating',
            type: 'column'
        },
        plotOptions: {
            series: {
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    align: 'center',
                },
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.rating)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += 'Number of Employees: ' + this.y
                return s;
            }
        },
        title: {
            text: 'Performance Rating Distribution'
        },
        exporting: {
            enabled: false
        }
    }, store.perfRatingData)

    ratingChart = new Highcharts.Chart(chartOptions)
}

function buildTenureChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByTenure',
            type: 'pie'
        },
        plotOptions: {
            pie: {
                innerSize: '40%',
                depth: 25,
                showInLegend: true
            },
            series: {
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage * 100) / 100 + '%';
                    }
                },
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.tenure)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.y + ' (' + Math.round(this.percentage * 100) / 100 + '%)'
                return s;
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        title: {
            text: 'HC By Tenure'
        },
        exporting: {
            enabled: false
        }
    }, store.tenureData)
    tenureChart = new Highcharts.Chart(chartOptions)
}

function buildGenderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'genderChart',
            type: 'pie'
        },
        plotOptions: {
            pie: {
                innerSize: '40%',
                depth: 25,
                showInLegend: true
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.gender)
                        }
                    }
                },
                animation: {
                    duration: 500
                },
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage * 100) / 100 + '%';
                    },
                    style: {
                        textOutline: 'none'
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.y + ' (' + Math.round(this.percentage * 100) / 100 + '%)'
                return s;
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
        title: {
            text: 'HC By Gender'
        },
        exporting: {
            enabled: false
        }
    }, store.genderData)
    genderChart = new Highcharts.Chart(chartOptions)
}

function App(GRAPHAPIURL) {
    store = new Store();
    Provider(GRAPHAPIURL).then(function(data) {
        store.employees = data.data
        store.originalEmps = data.data
        store.buildData()
        buildCharts()
        isLoading = false
    })
}
