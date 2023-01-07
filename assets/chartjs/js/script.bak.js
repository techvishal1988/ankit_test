var backgroundColors = ["#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd"]
var chartColors = [
    '#9e86ff',
    '#177ae1',
    '#3d4049',
    '#25a8dd',
    '#673ab7',
    '#3f51b5',
    '#2196f3',
    '#03a9f4',
    '#00bcd4',
    '#009688',
    '#4caf50',
    '#8bc34a',
    '#cddc39',
    '#ffeb3b',
    '#ffc107',
    '#ff9800',
    '#607d8b',
    '#673ab7',
    '#3f51b5',
    '#2196f3',
    '#03a9f4',
    '#00bcd4',
    '#009688',
    '#4caf50',
    '#8bc34a',
    '#cddc39',
    '#ffeb3b',
    '#ffc107',
    '#ff9800',
    '#607d8b'
]
var greenColor = '#25a8dd'
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
    Chart.plugins.register({
        afterDraw: function(chartInstance) {
            if (chartInstance.config.options.showDatapoints) {
            var helpers = Chart.helpers;
            var ctx = chartInstance.chart.ctx;
            var fontColor = helpers.getValueOrDefault(chartInstance.config.options.showDatapoints.fontColor, chartInstance.config.options.defaultFontColor);

            // render the value of the chart above the bar
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';
            ctx.fillStyle = fontColor;

            chartInstance.data.datasets.forEach(function (dataset) {
                for (var i = 0; i < dataset.data.length; i++) {
                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                var scaleMax = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                var yPos = (scaleMax - model.y) / scaleMax >= 0.93 ? model.y + 20 : model.y - 5;
                ctx.fillText(dataset.data[i], model.x, yPos);
                }
            });
            }
        }
    });
}

var ChartModule = function() {
    function ChartModule(canvas, options, onClick) {
        this.toggleClick = true
        this.options = options
        this.canvas = canvas
        if (onClick) {
            var self = this;
            this.options.options.onClick = function(e) {
                var element = this.getElementAtEvent(e)
                var data = this.getDatasetAtEvent(e)
                if (element[0] && element[0]._index !== undefined) {
                    if (backgroundColors.indexOf(fadedColor) >= 0) {
                        for (var i = 0; i < backgroundColors.length; i++) {
                            if (backgroundColors[i] === fadedColor) {
                                backgroundColors[i] = greenColor;
                            }
                        }
                    } else {
                        for (var i = 0; i < backgroundColors.length; i++) {
                            if (i !== element[0]._index) {
                                backgroundColors[i] = fadedColor;
                            } else {
                                backgroundColors[i] = greenColor;
                            }
                        }
                    }
                    onClick(data[element[0]._index]._model, self.toggleClick, this)
                    self.toggleClick = !self.toggleClick;
                }
            };
        }
        this.chart = new Chart(this.canvas.getContext('2d'), this.options)
    }

    return ChartModule;
}()

var Store = function() {
    function Store() {
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
        this.locations = []
        this.groups = []
        this.levelUpOrg = []
        this.grades = []
        this.levels = []
        this.functions = []
        this.perfRatings = []
        this.today = new Date()
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
        this.getCurrentBUDataset()
        this.getGradeData()
        this.getLevelData()
        this.getFunctionData()
        this.getPerRatingData()
        this.getTenureData()
    }

    Store.prototype.update = function(filter) {
        this.gradeData = this.getHeadCount(this.gradeDim, this.grades, 'HC By Grade', filter, chartColors)
        this.levelData = this.getHeadCount(this.levelDim, this.levels, 'HC By Level', filter, chartColors)
        this.functionData = this.getHeadCount(this.functionDim, this.functions, 'HC By Level', filter, chartColors)
        this.perfRatingData = this.getHeadCount(this.perfRatingDim, this.perfRatings, 'Performance Rating Distribution', filter, chartColors)
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
        var params = {
            labels: [],
            datasets: []
        }
        var data = []

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

        if (set01 > 0) {
            params.labels.push('0-1 yrs')
            data.push(set01)
        }
        if (set13 > 0) {
            params.labels.push('1-3 yrs')
            data.push(set13)
        }
        if (set25 > 0) {
            params.labels.push('2-5 yrs')
            data.push(set25)
        }
        if (set510 > 0) {
            params.labels.push('5-10 yrs')
            data.push(set510)
        }
        if (set10 > 0) {
            params.labels.push('>10 yrs')
            data.push(set10)
        }

        params.datasets.push({
            label: 'Tenure',
            data: data,
            backgroundColor: chartColors,
            borderWidth: 0
        })

        return params;
    }

    Store.prototype.getBuLevelOneData = function(filter) {
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] })
        this.buLevelOneData = this.getHeadCount(this.buLevelOneDim, this.groups, 'Head Count By Next Level Up In Organisation', filter, chartColors)
    }

    Store.prototype.getCurrentBUDataset = function(filter) {
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getHeadCount(this.buLevelThreeDim, this.locations, 'Head Count By Current Business Unit', filter);
    }

    Store.prototype.getBuLevelTwoData = function(filter) {
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] })
        this.buLevelTwoData = this.getHeadCount(this.buLevelOneDim, this.levelUpOrg, 'HC By Next Level Up In Organisation', filter, chartColors)
    }

    Store.prototype.getGradeData = function(filter) {
        this.gradeDim = this.crossEmps.dimension(function(d) { return d['Grade'] })
        this.gradeData = this.getHeadCount(this.gradeDim, this.grades, 'HC By Grade', filter, chartColors)
    }

    Store.prototype.getLevelData = function(filter) {
        this.levelDim = this.crossEmps.dimension(function(d) { return d['Level'] })
        this.levelData = this.getHeadCount(this.levelDim, this.levels, 'HC By Level', filter, chartColors)
    }

    Store.prototype.getFunctionData = function(filter) {
        this.functionDim = this.crossEmps.dimension(function(d) { return d['Function'] })
        this.functionData = this.getHeadCount(this.functionDim, this.functions, 'HC By Level', filter, chartColors)
    }

    Store.prototype.getPerRatingData = function(filter) {
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getHeadCount(this.perfRatingDim, this.perfRatings, 'Performance Rating Distribution', filter, chartColors)
    }

    Store.prototype.getHeadCount = function(dim, keys, label, filter, colors) {
        var params = {
            labels: [],
            datasets: []
        }
        var data = []

        if (filter) {
            dim.filter(filter)
            data.push(dim.top(Infinity).length)
            params.labels = [filter]
        } else {
            for (var i = 0; i < keys.length; i++) {
                dim.filter(keys[i])
                var dl = dim.top(Infinity).length
                if (dl > 0) {
                    data.push(dim.top(Infinity).length)
                    params.labels.push(keys[i])
                }
            }
            dim.filter(null)
        }

        params.datasets.push({
            label: label,
            data: data,
            backgroundColor: colors ? colors : backgroundColors,
            borderWidth: 0
        })

        return params;
    }

    Store.prototype.filterData = function(filter, key) {
        if (filter)
            this.buLevelThreeDim.filter(filter)
        else
            this.buLevelThreeDim.filter()

        this.update()
    }

    Store.prototype.getUniqueByKey = function(key) {
        var loc = []
        for (var i = 0; i < this.employees.length; i++) {
            if (!loc.includes(this.employees[i][key])) {
                loc.push(this.employees[i][key])
            }
        }
        return loc;
    }

    return Store
}()

function handleBarChartClick(data, state, chart) {
    if (state && data.label) {
        store.filterData(data.label)
    } else {
        store.filterData()
    }
    chart.update()
    updateCharts()
}

function Provider() {
    return $.get('/src/js/data.json')
}

function buildCharts() {
    ChartPlugin()
    var businessUnit1 = $('#businessUnit1')[0];

    var chartOptions = {
        type: 'bar',
        data: store.buLevelThreeData,
        options: {
            title: {
                display: true,
                text: 'Head Count By BU',
                fontColor: '#ddd'
            },
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: 'easeInOutQuad',
                duration: 520
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.25)',
                        lineWidth: 1
                    },
                    ticks: {
                        fontColor: '#ddd',
                        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        autoSkip: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.28)',
                        lineWidth: 1
                    },
                    ticks: {
                        fontColor: '#ddd',
                        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        stepSize: ceilToNearest(findMax(store.buLevelThreeData.datasets[0].data) / 3),
                        autoSkip: false,
                    }
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                titleFontFamily: 'Open Sans',
                caretSize: 5,
                cornerRadius: 2,
                xPadding: 10,
                yPadding: 10
            },
            showDatapoints: true
        }
    }

    new ChartModule(businessUnit1, chartOptions, handleBarChartClick)
    updateCharts()
}

function updateCharts() {
    buildGradeChart()
    buildLevelChart()
    buildFunctionChart()
    buildPerfRatingChart()
    buildTenureChart()
}

var gradeChart, levelChart, functionChart, ratingChart, tenureChart;

function buildGradeChart() {
    var hcByGrade = $('#hcByGrade')[0]
    if (gradeChart) {
        gradeChart.chart.destroy()
    }
    var chartOptions = {
        type: 'doughnut',
        data: store.gradeData,
        options: {
            title: {
                display: true,
                text: 'HC By Grade',
                padding: 25,
                fontColor: '#ddd'
            },
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: 'easeInOutQuad',
                duration: 520
            },
            legend: {
                position: 'right'
            },
            tooltips: {
                titleFontFamily: 'Open Sans',
                caretSize: 5,
                cornerRadius: 2,
                xPadding: 10,
                yPadding: 10
            }
        }
    }
    gradeChart = new ChartModule(hcByGrade, chartOptions)
}

function buildLevelChart() {
    var hcByLevel = $('#hcByLevel')[0]
    if (levelChart) {
        levelChart.chart.destroy()
    }
    var chartOptions = {
        type: 'doughnut',
        data: store.levelData,
        options: {
            title: {
                display: true,
                text: 'HC By Level',
                padding: 25,
                fontColor: '#ddd'
            },
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: 'easeInOutQuad',
                duration: 520
            },
            legend: {
                position: 'right'
            },
            tooltips: {
                titleFontFamily: 'Open Sans',
                caretSize: 5,
                cornerRadius: 2,
                xPadding: 10,
                yPadding: 10
            }
        }
    }
    levelChart = new ChartModule(hcByLevel, chartOptions)
}

function buildFunctionChart() {
    var hcByFunction = $('#hcByFunction')[0]
    if (functionChart) {
        functionChart.chart.destroy()
    }
    var chartOptions = {
        type: 'bar',
        data: store.functionData,
        options: {
            title: {
                display: true,
                text: 'HC By Function',
                padding: 25,
                fontColor: '#ddd'
            },
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: 'easeInOutQuad',
                duration: 520
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.25)',
                        lineWidth: 1
                    },
                    ticks: {
                        fontColor: '#ddd',
                        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        autoSkip: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.28)',
                        lineWidth: 1
                    },
                    ticks: {
                        fontColor: '#ddd',
                        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        stepSize: ceilToNearest(findMax(store.gradeData.datasets[0].data) / 3),
                        autoSkip: false,
                    }
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                titleFontFamily: 'Open Sans',
                caretSize: 5,
                cornerRadius: 2,
                xPadding: 10,
                yPadding: 10
            },
            showDatapoints: true
        }
    }
    functionChart = new ChartModule(hcByFunction, chartOptions)
}

function buildPerfRatingChart() {
    var perfRating = $('#perfRating')[0]
    if (ratingChart) {
        ratingChart.chart.destroy()
    }
    var chartOptions = {
        type: 'bar',
        data: store.perfRatingData,
        options: {
            title: {
                display: true,
                text: 'Performance Rating Distribution',
                padding: 25,
                fontColor: '#ddd'
            },
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: 'easeInOutQuad',
                duration: 520
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.25)',
                        lineWidth: 1
                    },
                    ticks: {
                        fontColor: '#ddd',
                        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        autoSkip: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.28)',
                        lineWidth: 1
                    },
                    ticks: {
                        fontColor: '#ddd',
                        fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                        stepSize: ceilToNearest(findMax(store.perfRatingData.datasets[0].data) / 3),
                        autoSkip: false
                    }
                }]
            },
            legend: {
                display: false
            },
            tooltips: {
                titleFontFamily: 'Open Sans',
                caretSize: 5,
                cornerRadius: 2,
                xPadding: 10,
                yPadding: 10
            },
            showDatapoints: true
        }
    }
    ratingChart = new ChartModule(perfRating, chartOptions)
}

function buildTenureChart() {
    var hcByTenure = $('#hcByTenure')[0]
    if (tenureChart) {
        tenureChart.chart.destroy()
    }
    var chartOptions = {
        type: 'doughnut',
        data: store.tenureData,
        options: {
            title: {
                display: true,
                text: 'HC By Tenure',
                padding: 25,
                fontColor: '#ddd'
            },
            responsive: true,
            maintainAspectRatio: true,
            animation: {
                easing: 'easeInOutQuad',
                duration: 520
            },
            legend: {
                position: 'right'
            },
            tooltips: {
                titleFontFamily: 'Open Sans',
                caretSize: 5,
                cornerRadius: 2,
                xPadding: 10,
                yPadding: 10
            }
        }
    }
    tenureChart = new ChartModule(hcByTenure, chartOptions)
}

function App() {
    store = new Store();
    Provider().then(function(data) {
        store.employees = data.data
        store.buildData()
        buildCharts()
        isLoading = false
    })
}
