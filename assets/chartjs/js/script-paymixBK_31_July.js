var backgroundColors = ["#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd", "#25a8dd"]
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
    "perfRating": "Performance_Rating_for_this_fiscal_year",
    "gender": "Gender"
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

function formatNumber(num) {
    if (!num) return 0;
   return parseFloat(parseFloat(num, 10).toFixed(2), 10)
}

function svgToPng(svg, w, h, cb) {
    var canvas = $('<canvas></canvas>'),
        ctx = canvas[0].getContext('2d')

    canvas.attr('width', w)
    canvas.attr('height', h)
    ctx.drawImage(svg, 0, 0)
    var uri = canvas[0].toDataURL('image/png')
    cb(uri)
    canvas.remove();
}

(function(API){
    API.textCenter = function(txt, options, x, y) {
        options = options || {};
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
                    text = 'Pay Mix Dashboard'
//                doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'PNG', 0.13, 0.1, w, h);
                doc.save('Paymix-dashboard.pdf')
                $('.loader').hide()
            });
    }, 100)
}

function exportCsv(data) {
    data = _.map(data, function(item) {
        var obj = {}
        _.forIn(item, function(value) {
            obj[value.name] = value.value
        })
        return obj
    })

    var ws = XLSX.utils.json_to_sheet(data)
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Paymix Dashboard');
    XLSX.writeFile(wb, "Paymix-dashboard.xlsx");
}

var Store = function() {
    function Store() {
        this.originalEmps = []
        this.employees = []
        this.allFilters = []
    }

    Store.prototype.buildData = function() {
        this.getAllowances()
        this.totalCurrentBaseSalary = this.getTotalSalary(this.employees, 'Current_Base_salary')
        this.totalCurrentTargetBonus = this.getTotalSalary(this.employees, 'Current_target_bonus')
        this.getCurrentBUDataset()
        this.getGradeDataset();
        this.getLevelDataset();
        this.getFunctionDataset()
        this.getCountryDataset()
        this.getCityDataset()
        this.getGenderDataset()
    }

    Store.prototype.getTotalSalary = function(employees, dim) {
        var sum = _.reduce(employees, function(s, d) {
            if (d[dim] && d[dim].value !== undefined) {
                return s + parseInt(d[dim].value, 10)
            } else {
                return s + 0;
            }
        }, 0)
        return sum
    }

    Store.prototype.getAllowances = function() {
        var allowances = []
        var totalSalary = []
        var self = this
        _.map(this.employees, function(d) {
            if (d['Allowance_1'] && d['Allowance_1'].value && d['Allowance_1'].value !== '0') {
                if (!allowances.includes('Allowance_1')) {
                    allowances.push('Allowance_1');
                    totalSalary.push({
                        key: 'Allowance_1',
                        value: d['Allowance_1'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_1')
                    })
                }
            }
            if (d['Allowance_2'] && d['Allowance_2'].value && d['Allowance_2'].value !== '0') {
                if (!allowances.includes('Allowance_2')) {
                    allowances.push('Allowance_2');
                    totalSalary.push({
                        key: 'Allowance_2',
                        value: d['Allowance_2'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_2')
                    })
                }
            }
            if (d['Allowance_3'] && d['Allowance_3'].value && d['Allowance_3'].value !== '0') {
                if (!allowances.includes('Allowance_3')) {
                    allowances.push('Allowance_3');
                    totalSalary.push({
                        key: 'Allowance_3',
                        value: d['Allowance_3'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_3')
                    })
                }
            }
            if (d['Allowance_4'] && d['Allowance_4'].value && d['Allowance_4'].value !== '0') {
                if (!allowances.includes('Allowance_4')) {
                    allowances.push('Allowance_4');
                    totalSalary.push({
                        key: 'Allowance_4',
                        value: d['Allowance_4'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_4')
                    })
                }
            }
            if (d['Allowance_5'] && d['Allowance_5'].value && d['Allowance_5'].value !== '0') {
                if (!allowances.includes('Allowance_5')) {
                    allowances.push('Allowance_5');
                    totalSalary.push({
                        key: 'Allowance_5',
                        value: d['Allowance_5'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_5')
                    })
                }
            }
            if (d['Allowance_6'] && d['Allowance_6'].value && d['Allowance_6'].value !== '0') {
                if (!allowances.includes('Allowance_6')) {
                    allowances.push('Allowance_6');
                    totalSalary.push({
                        key: 'Allowance_6',
                        value: d['Allowance_6'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_6')
                    })
                }
            }
            if (d['Allowance_7'] && d['Allowance_7'].value && d['Allowance_7'].value !== '0') {
                if (!allowances.includes('Allowance_7')) {
                    allowances.push('Allowance_7');
                    totalSalary.push({
                        key: 'Allowance_7',
                        value: d['Allowance_7'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_7')
                    })
                }
            }
            if (d['Allowance_8'] && d['Allowance_8'].value && d['Allowance_8'].value !== '0') {
                if (!allowances.includes('Allowance_8')) {
                    allowances.push('Allowance_8');
                    totalSalary.push({
                        key: 'Allowance_8',
                        value: d['Allowance_8'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_8')
                    })
                }
            }
            if (d['Allowance_9'] && d['Allowance_9'].value && d['Allowance_9'].value !== '0') {
                if (!allowances.includes('Allowance_9')) {
                    allowances.push('Allowance_9');
                    totalSalary.push({
                        key: 'Allowance_9',
                        value: d['Allowance_9'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_9')
                    })
                }
            }
            if (d['Allowance_10'] && d['Allowance_10'].value && d['Allowance_10'].value !== '0') {
                if (!allowances.includes('Allowance_10')) {
                    allowances.push('Allowance_10');
                    totalSalary.push({
                        key: 'Allowance_10',
                        value: d['Allowance_10'].name,
                        salary: self.getTotalSalary(self.employees, 'Allowance_10')
                    })
                }
            }
        })
        this.allCompanyAllowance = totalSalary;
    }

    Store.prototype.getCurrentBUDataset = function() {
        this.locations = this.getUniqueByKey(dataKeys.businessUnit3)
        this.buLevelThreeData = this.getBarPercentage(dataKeys.businessUnit3, this.locations);
    }

    Store.prototype.getCountryDataset = function() {
        this.countries = this.getUniqueByKey('Country')
        this.countryData = this.getBarPercentage('Country', this.countries)
    }

    Store.prototype.getCityDataset = function() {
        this.cities = this.getUniqueByKey('City')
        this.cityDataset = this.getBarPercentage('City', this.cities)
    }

    Store.prototype.getGenderDataset = function() {
        this.genders = this.getUniqueByKey(dataKeys.gender)
        this.genderData = this.getBarColumnPercentage(dataKeys.gender, this.genders)
    }

    Store.prototype.getGradeDataset = function() {
        this.grades = this.getUniqueByKey('Grade')
        this.gradeData = this.getBarColumnPercentage('Grade', this.grades, 'Grade')
    }

    Store.prototype.getLevelDataset = function() {
        this.levels = this.getUniqueByKey('Level')
        this.levelData = this.getBarColumnPercentage('Level', this.levels, 'Level')
    }

    Store.prototype.getFunctionDataset = function() {
        this.functionKeys = this.getUniqueByKey('Function')
        this.functionData = this.getBarColumnPercentage('Function', this.functionKeys)
    }

    Store.prototype.getBarPercentage = function(dim, keys, isName) {
        var self = this;
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
                    overflow: 'justify',
                    formatter: function() {
                        return this.value + '%'
                    }
                }
            },
            series: []
        }

        if (this.employees[0]) {
            var obj = this.employees[0]
            _.forIn(obj, function(val, key) {
                if (val && key === 'Current_Base_salary' && val.name) {
                    data.push({
                        name: val.name,
                        data: []
                    })
                }
                if (val && key === 'Current_target_bonus' && val.name) {
                    data.push({
                        name: val.name,
                        data: []
                    })
                }
                _.map(self.allCompanyAllowance, function(all) {
                    if (val && key === all.key && val.name) {
                        data.push({
                            name: val.name,
                            data: []
                        })
                    }
                    return all;
                })
            })
            for (var i = 0; i < keys.length; i++) {
                var totalUnitSalary = 0;
                var x = _.filter(this.employees, function(e) {
                    return e[dim] && e[dim].value === keys[i].value
                });
                var baseSalarySum = this.getTotalSalary(x, 'Current_Base_salary')
                var targetBonusSum = this.getTotalSalary(x, 'Current_target_bonus')
                totalUnitSalary += baseSalarySum + targetBonusSum;
                _.map(self.allCompanyAllowance, function(all) {
                    var tSum = self.getTotalSalary(x, all.key);
                    totalUnitSalary += tSum;
                    return all;
                })
                if (totalUnitSalary > 0) {
                    data = _.map(data.slice(), function(d) {
                        if (obj && d.name === obj['Current_Base_salary'].name) {
                            d.data.push(
                                formatNumber((baseSalarySum / totalUnitSalary) * 100)
                            )
                        }
                        if (obj && d.name === obj['Current_target_bonus'].name) {
                            d.data.push(
                                formatNumber((targetBonusSum / totalUnitSalary) * 100)
                            )
                        }
                        _.map(self.allCompanyAllowance, function(all) {
                            var tSum = self.getTotalSalary(x, all.key);
                            if (d.name === all.value) {
                                d.data.push(
                                    formatNumber((tSum / totalUnitSalary) * 100)
                                )
                            }
                            return all;
                        })
                        return d;
                    })
                }
                if (isName)
                    labels.push(keys[i].name)
                else
                    labels.push(keys[i].value)
            }
        }

        dataSet.xAxis.categories = labels;
        dataSet.series = data;

        return dataSet;
    }

    Store.prototype.getBarColumnPercentage = function(dim, keys, isName) {
        var self = this;
        var data = []
        var labels = []
        var dataSet = {
            xAxis: {
                categories: [],
                title: {
                    text: null
                },
                labels: {
                    formatter: function() {
                        if (isName)
                            return isName + '-' + this.value
                        return this.value
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify',
                    formatter: function() {
                        return this.value + '%'
                    }
                }
            },
            series: []
        }

        if (this.employees[0]) {
            var obj = this.employees[0]
            _.forIn(obj, function(val, key) {
                if (val && key === 'Current_Base_salary' && val.name) {
                    data.push({
                        name: val.name,
                        data: []
                    })
                }
                if (val && key === 'Current_target_bonus' && val.name) {
                    data.push({
                        name: val.name,
                        data: []
                    })
                }
                _.map(self.allCompanyAllowance, function(all) {
                    if (val && key === all.key && val.name) {
                        data.push({
                            name: val.name,
                            data: []
                        })
                    }
                    return all;
                })
            })
            for (var i = 0; i < keys.length; i++) {
                var totalUnitSalary = 0
                var x = _.filter(this.employees, function(e) {
                    return e[dim] && e[dim].value === keys[i].value
                });
                var baseSalarySum = this.getTotalSalary(x, 'Current_Base_salary')
                var targetBonusSum = this.getTotalSalary(x, 'Current_target_bonus')
                totalUnitSalary += baseSalarySum + targetBonusSum;
                _.map(self.allCompanyAllowance, function(all) {
                    var tSum = self.getTotalSalary(x, all.key);
                    totalUnitSalary += tSum;
                    return all;
                })
                if (totalUnitSalary > 0) {
                    data = _.map(data.slice(), function(d) {
                        if (obj && d.name === obj['Current_Base_salary'].name) {
                            d.data.push(
                                formatNumber((baseSalarySum / totalUnitSalary) * 100)
                            )
                        }
                        if (obj && d.name === obj['Current_target_bonus'].name) {
                            d.data.push(
                                formatNumber((targetBonusSum / totalUnitSalary) * 100)
                            )
                        }
                        _.map(self.allCompanyAllowance, function(all) {
                            var tSum = self.getTotalSalary(x, all.key);
                            if (d.name === all.value) {
                                d.data.push(
                                    formatNumber((tSum / totalUnitSalary) * 100)
                                )
                            }
                            return all;
                        })
                        return d;
                    })
                }
                labels.push(keys[i].value)
            }
        }

        dataSet.xAxis.categories = labels;
        dataSet.series = data;

        return dataSet;
    }

    Store.prototype.filterData = function(filters) {
        this.employees = this.originalEmps.slice();
        this.allFilters = filters;
        if (filters.length) {
            for (var x = 0; x < filters.length; x++) {
                var curF = filters[x]
                if (chartNames.buLoc === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d[dataKeys.businessUnit3] && d[dataKeys.businessUnit3].value === curF.filter
                    })
                } else if (chartNames.grade === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d['Grade'] && d['Grade'].value === curF.filter
                    })
                } else if (chartNames.level === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d['Level'] && d['Level'].value === curF.filter
                    })
                } else if (chartNames.city === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d['City'] && d['City'].value === curF.filter
                    })
                } else if (chartNames.country === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d['Country'] && d['Country'].value === curF.filter
                    })
                } else if (chartNames.function === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d['Function'] && d['Function'].value === curF.filter
                    })
                } else if (chartNames.gender === curF.type) {
                    this.employees = _.filter(this.employees.slice(), function(d) {
                        return d[dataKeys.gender] && d[dataKeys.gender].value === curF.filter
                    })
                }
            }
        }

        this.buildData();
    }

    Store.prototype.getUniqueByKey = function(key) {
        var u = []
        var loc = []
        for (var i = 0; i < this.employees.length; i++) {
            if (this.employees[i][key] &&
                this.employees[i][key].value !== undefined &&
                !u.includes(this.employees[i][key].value)) {
                u.push(this.employees[i][key].value)
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
    } else if (filter.type === chartNames.city) {
        return 'City: ' + filter.filter
    } else {
        return 'Country: ' + filter.filter
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
            text: 'Paymix by BU'
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
    buFunctionChart()
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
            text: 'Paymix by Country'
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
            text: 'Paymix by City'
        },
    }, store.cityDataset)

    cityChart = new Highcharts.Chart(chartOptions)
}

function buildGradeChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByGrade',
            type: 'bar'
        },
        plotOptions: {
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
            text: 'Paymix by Grade'
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
            text: 'Paymix by Level'
        },
    }, store.levelData)

    levelChart = new Highcharts.Chart(chartOptions)
}

function buFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'functionChart',
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
            text: 'Paymix by Function'
        },
    }, store.functionData)

    functionChart = new Highcharts.Chart(chartOptions)
}

function buildGenderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'genderChart',
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
            text: 'Paymix by Gender'
        },
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
