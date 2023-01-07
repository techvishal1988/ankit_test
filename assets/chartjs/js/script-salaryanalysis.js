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
var chartNames = {
    'buLoc': 'buLoc',
    'grade': 'grade',
    'level': 'level',
    'function': 'function',
    'rating': 'rating',
    'tenure': 'tenure',
    'city': 'city',
    'country': 'country',
    'gender': 'gender',
    'businessUnit1': 'businessUnit1',
    'businessUnit2': 'businessUnit2',
    'subFunction' : 'subFunction',
    'subSubFunction' : 'subSubFunction',
    'education' : 'education',
    'identifiedTalent' : 'identifiedTalent',
    'criticalPositionHolder' : 'criticalPositionHolder',
    'specialCategoryOne' : 'specialCategoryOne',
    'urbanRuralClassification' : 'urbanRuralClassification',
}

function getDateDiff(d) {
    return moment().diff(d, 'years')
}

function getInch(px) {
    return Math.round(px / 95.999999998601);
}

function formatNumber(num) {
    if (!num) return 0;
   return parseFloat(Highcharts.numberFormat(num))
}

function ChartPlugin() {
	 Highcharts.setOptions({
        lang: {
            noData: 'No data is available in the graph',
        },
		 plotOptions: {
			series: {
                colorByPoint: false,
                borderWidth: 0,
				dataLabels: {
                    enabled: true,
                    crop: false,
                    overflow: 'none',
                    style: {
                        fontSize:'8px',
                        color: '#000',
                        fontFamily: 'Century Gothic Regular',
                        textOutline: false ,
                        textShadow: false
                    },
                    allowOverlap: false,
                    formatter: function() {
                        return getRoundOfNumber(this.y) + '%'
                    }
                }
            }
        },
        colors: [ 
                '#ADD8E6',
                '#6495ED',
                '#4682B4',
                '#4169E1',
                '#191970',
                '#87CEFA',
                '#87CEEB',
                '#00BFFF',
                '#B0C4DE',
                '#1E90FF',
                ],
        yAxis: {
            gridLineWidth: 0,
            minorGridLineWidth: 0,
            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px",
                     fontWeight:'600'
                }
            }
        },
        xAxis: {
            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px",
                     fontWeight:'600'
                }
            }
        },
        chart: {
                style: {
                fontFamily: 'Century Gothic Regular',
                color: "#000",
                fontWeight:'600',
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
        },
         exporting: exportOptions(), 
    });
    
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

var chartIndexes = chartExportPptArray;//['#cityChart', '#businessUnit1', '#hcByGrade', '#hcByLevel', '#hcByFunction', '#perfRating', '#genderChart']
var exportPageCount = 0;

function createPdfPages(pdf) {
    if (chartIndexes.length > exportPageCount) {
        var chart = $(chartIndexes[exportPageCount]).closest('.col-md-6'),
            w = getInch(chart.width()),
            h = getInch(chart.height())
        
        exportPageCount += 1;
        domtoimage.toPng(chart[0])
            .then(function(dataUrl) {
                pdf.addPage(w, h)
                pdf.addImage(dataUrl, 'JPEG', 0.13, 0.1, w - 0.19, h - 0.02);
                return createPdfPages(pdf)
            })
    } else {
        pdf.save('salary-analysis-dashboard.pdf')
        $('#loading').hide()
    }
}

function exportCharts(charts) {
    exportPageCount = 0;
    var node = $('#countryChart').closest('.col-md-6')
    var w = getInch(node.width())
    var h = getInch(node.height())
    $('#loading').show()
    window.setTimeout(function() {
        var doc = new jsPDF('l', 'in', [w, h + 0.5]),
            text = "Salary Analysis Dashobard"

        domtoimage.toPng(node[0])
            .then(function(dataUrl) {
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.6, w - 0.19, h - 0.19);
                createPdfPages(doc)
            })
    }, 100)
}

function exportPpts() {

	$('#loading').show()
	var pptx = new PptxGenJS();
	var chartArray = chartExportPptArray;
	var i = 0;

	$( chartArray ).each(function( index, val ) {

		setTimeout(function() {
		  node = $('#'+val);
		 var w = getInch(node.width());
		 var h = getInch(node.height());
		  domtoimage.toPng(node[0])
		    .then(function (dataUrl) {
			var slide = pptx.addNewSlide();
			slide.back  = 'F1F1F1';
			$.when( slide ).done(function ( slide ) {
			    slide.addImage({ data:dataUrl, x:1.5, y:1.25, w:w, h:h});
			    i++;
			});

			if(i == chartArray.length) {
			    pptx.save('salary-analysis-dashboard');
			    $('#loading').hide()
			}

	 	   });
		}, 1000 * index);

	});

}

function exportCsv(data) {

    var dataObj = {};
    var dataObjNew = [];
    $.each(data, function (key, val) {

        dataObj = {};

        $.each(val, function (key1, value) {

            dataObj[key1.replace(/\_/g, ' ').toLowerCase().toUpperCase()] = value;

        });

        dataObjNew[key] = dataObj;
    });

    var ws = XLSX.utils.json_to_sheet(dataObjNew)
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Salary Analysis Dashboard');
    XLSX.writeFile(wb, "Salary-analysis-dashboard.xlsx");
}

var Store = function() {
    function Store() {
        this.originalEmps = [];
        this.employees = [];
        this.allFilters = [];
        this.crossEmps = null;

        this.countryDim = {};
        this.countryData = {};
        this.countries = [];

        this.cities = [];
        this.cityDim = {};
        this.cityData = {};

        this.buLevelOneValues = [];
        this.buLevelOneDim = {};
        this.buLevelOneData = {};

        this.buLevelTwoValues = [];
        this.buLevelTwoDim = {};
        this.buLevelTwoData = {};

        this.buLevelThreeValues = [];
        this.buLevelThreeDim = {};
        this.buLevelThreeData = {}; //Area

        this.gradeKeys = [];
        this.gradeDim = {};
        this.gradeData = {};

        this.levelKeys = [];
        this.levelDim = {};
        this.levelData = {};

        this.functionKeys = [];
        this.functionDim = {};
        this.functionData = {};

        this.prefRatingKeys = [];
        this.perfRatingDim = {};
        this.perfRatingData = {};

        this.genderKeys = [];
        this.genderDim = {};
        this.genderData = {};

       // this.tenureDim = {}
      //  this.tenureData = {}//Start date for role

        this.subFunctionDim = {};
        this.subFunctionData = {};
        this.subFunctions = [];

        this.subSubFunctionDim = {};
        this.subSubFunctionData = {};
        this.subSubFunctions = [];

        this.educationDim = {};
        this.educationData = {};
        this.educations = [];

        this.identifiedTalentDim = {};
        this.identifiedTalentData = {};
        this.identifiedTalents = [];

        this.criticalPositionHolderDim = {};
        this.criticalPositionHolderData = {};
        this.criticalPositionHolders = [];

        this.specialCategoryOneDim = {};
        this.specialCategoryOneData = {};
        this.specialCategoryOnes = [];

        this.urbanRuralClassificationDim = {};
        this.urbanRuralClassificationData = {};
        this.urbanRuralClassifications = [];
    }

    Store.prototype.buildData = function() {
        this.crossEmps = crossfilter(this.employees);
        this.allRatioRange = ['Min', 'Avg', 'Max'];

        this.showTtotal(this.employees);
        this.getBuLevelOneData();
        this.getBuLevelTwoData();
        this.getCurrentBUDataset();
        this.getGradeData();
        this.getLevelData();
        this.getFunctionData();
        this.getSubFunctionData();
        this.getPerRatingData();
        //this.getTenureData();
        this.getCountryDataset();
        this.getCityDataset();
        this.getGenderData();
        this.getSubSubFunctionData();
        this.getEducationData();
        this.getIdentifiedTalentData();
        this.getCriticalPositionHolderData();
        this.getSpecialCategoryOneData();
        this.getUrbanRuralClassificationData();
    }

    Store.prototype.getCountryDataset = function() {
        this.countries = this.getUniqueByKey(dataKeys.country)
        this.countryDim = this.crossEmps.dimension(function(d) { return d[dataKeys.country] })
        this.countryData = this.getBarPercentage(this.countryDim, this.countries, this.allRatioRange)
    }

    Store.prototype.getCityDataset = function() {
        this.cities = this.getUniqueByKey(dataKeys.city)
        this.cityDim = this.crossEmps.dimension(function(d) { return d[dataKeys.city] })
        this.cityData = this.getBarPercentage(this.cityDim, this.cities, this.allRatioRange)
    }

    Store.prototype.getCurrentBUDataset = function() {
        this.buLevelThreeValues = this.getUniqueByKey(dataKeys.businessUnit3)
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getBarPercentage(this.buLevelThreeDim, this.buLevelThreeValues, this.allRatioRange)
    }

    Store.prototype.getGradeData = function() {
        this.gradeKeys = this.getUniqueByKey(dataKeys.grade)
        this.gradeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.grade] })
        this.gradeData = this.getBarPercentage(this.gradeDim,this.gradeKeys, this.allRatioRange)
    }

    Store.prototype.getLevelData = function() {
        this.levelKeys = this.getUniqueByKey(dataKeys.level)
        this.levelDim = this.crossEmps.dimension(function(d) { return d[dataKeys.level] })
        this.levelData = this.getBarPercentage(this.levelDim,this.levelKeys, this.allRatioRange)
    }

    Store.prototype.getFunctionData = function() {
        this.functionKeys = this.getUniqueByKey(dataKeys.function)
        this.functionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.function] })
        this.functionData = this.getBarPercentage(this.functionDim,this.functionKeys, this.allRatioRange)
    }

    Store.prototype.getPerRatingData = function() {
        this.prefRatingKeys = this.getUniqueByKey(dataKeys.perfRating)
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getBarPercentage(this.perfRatingDim, this.prefRatingKeys, this.allRatioRange)
    }

    Store.prototype.getGenderData = function() {
        this.genderKeys = this.getUniqueByKey(dataKeys.gender)
        this.genderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.gender] })
        this.genderData = this.getBarPercentage(this.genderDim, this.genderKeys, this.allRatioRange)
    }

    Store.prototype.getBuLevelOneData = function() {
        this.buLevelOneValues = this.getUniqueByKey(dataKeys.businessUnit1)
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] })
        this.buLevelOneData = this.getBarPercentage(this.buLevelOneDim, this.buLevelOneValues, this.allRatioRange)
    }

    Store.prototype.getBuLevelTwoData = function() {
        this.buLevelTwoValues = this.getUniqueByKey(dataKeys.businessUnit2)
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] })
        this.buLevelTwoData = this.getBarPercentage(this.buLevelTwoDim, this.buLevelTwoValues, this.allRatioRange)
    }

    Store.prototype.getSubFunctionData = function() {
        this.subFunctions = this.getUniqueByKey(dataKeys.subFunction)
        this.subFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subFunction] })
        this.subFunctionData = this.getBarPercentage(this.subFunctionDim, this.subFunctions, this.allRatioRange)
    }

    Store.prototype.getSubSubFunctionData = function() {
        this.subSubFunctions = this.getUniqueByKey(dataKeys.subSubFunction)
        this.subSubFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subSubFunction] })
        this.subSubFunctionData = this.getBarPercentage(this.subSubFunctionDim, this.subSubFunctions, this.allRatioRange)
    }

    Store.prototype.getEducationData = function() {
        this.educations = this.getUniqueByKey(dataKeys.education)
        this.educationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.education] })
        this.educationData = this.getBarPercentage(this.educationDim, this.educations, this.allRatioRange)
    }

    Store.prototype.getIdentifiedTalentData = function() {
        this.identifiedTalents = this.getUniqueByKey(dataKeys.identifiedTalent)
        this.identifiedTalentDim = this.crossEmps.dimension(function(d) { return d[dataKeys.identifiedTalent] })
        this.identifiedTalentData = this.getBarPercentage(this.identifiedTalentDim, this.identifiedTalents, this.allRatioRange)
    }

    Store.prototype.getCriticalPositionHolderData = function() {
        this.criticalPositionHolders = this.getUniqueByKey(dataKeys.criticalPositionHolder)
        this.criticalPositionHolderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.criticalPositionHolder] })
        this.criticalPositionHolderData = this.getBarPercentage(this.criticalPositionHolderDim, this.criticalPositionHolders, this.allRatioRange)
    }

    Store.prototype.getSpecialCategoryOneData = function() {
        this.specialCategoryOnes = this.getUniqueByKey(dataKeys.specialCategoryOne)
        this.specialCategoryOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.specialCategoryOne] })
        this.specialCategoryOneData = this.getBarPercentage(this.specialCategoryOneDim, this.specialCategoryOnes, this.allRatioRange)
    }

    Store.prototype.getUrbanRuralClassificationData = function() {
        this.urbanRuralClassifications = this.getUniqueByKey(dataKeys.urbanRuralClassification)
        this.urbanRuralClassificationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.urbanRuralClassification] })
        this.urbanRuralClassificationData = this.getBarPercentage(this.urbanRuralClassificationDim, this.urbanRuralClassifications, this.allRatioRange)
    }

    Store.prototype.showTtotal = function(employees) {

        if(employees.length) {
            $(".total-emp").html(' (Total Record: ' + employees.length + ')');
        }

    }

    Store.prototype.min = function(arr, key) {
        if (!arr) return [];
        if (!arr.length) return [];

        var min = Infinity;

        for (var i = 0; i < arr.length; i++) {
            var v = parseFloat(arr[i][key]);
            if (v < min) {
                min = v;
            }
        }
        return min;
    }

    Store.prototype.max = function(arr, key) {
        if (!arr) return [];
        if (!arr.length) return [];

        var max = -Infinity;

        for (var i = 0; i < arr.length; i++) {
            var v = parseFloat(arr[i][key]);
            if (v > max) {
                max = v;
            }
        }
        return max;
    }

    Store.prototype.avg = function(arr, key, total) {
        if (!arr) return [];
        if (!arr.length) return [];

        var sum = 0;

        for (var i = 0; i < arr.length; i++) {
            sum += parseFloat(arr[i][key])
        }

        if (total > 0)
            return (sum / total)
        return sum
    }

    Store.prototype.getBarPercentage = function(dim, keys, otherKeys) {
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
            var fValues = dim.top(Infinity);
            var dl = fValues.length
            if (dl > 0) {
                var min = this.min(fValues, dataKeys.salary_increase);
                var max = this.max(fValues, dataKeys.salary_increase);
                var avg = this.avg(fValues, dataKeys.salary_increase, dl)
                data = _.map(data.slice(0), function(item) {
                    if (item.name === 'Min') {
                        item.data.push(formatNumber(min))
                    }
                    if (item.name === 'Avg') {
                        item.data.push(formatNumber(avg))
                    }
                    if (item.name === 'Max') {
                        item.data.push(formatNumber(max))
                    }
                    return item
                })
            }
            dim.filter(null)
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
                } else if (chartNames.businessUnit1 === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.businessUnit1] === curF.filter
                    })
                } else if (chartNames.businessUnit2 === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.businessUnit2] === curF.filter
                    })
                } else if (chartNames.subFunction === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.subFunction] === curF.filter
                    })
                } else if (chartNames.subSubFunction === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.subSubFunction] === curF.filter
                    })
                } else if (chartNames.education === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.education] === curF.filter
                    })
                } else if (chartNames.identifiedTalent === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.identifiedTalent] === curF.filter
                    })
                } else if (chartNames.criticalPositionHolder === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.criticalPositionHolder] === curF.filter
                    })
                } else if (chartNames.specialCategoryOne === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.specialCategoryOne] === curF.filter
                    })
                } else if (chartNames.urbanRuralClassification === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        return d[dataKeys.urbanRuralClassification] === curF.filter
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

    Store.titlePrefix = 'Salary Increase by ';
    return Store
}()

var allFilters = [];

function getRoundOfNumber(value) {
    //get value till one decimal point
    var per = 0;

    if (Number.isInteger(value)) {//for integer
        per = Math.round(value);
    } else {//for float
        per = Math.round(value * 10) / 10 ;
    }

    return per;
}

function chartTooltipOption(name, value, percentage) {
    var per = 0;

    if (Number.isInteger(percentage)) {//for integer
        per = Math.round(percentage);
    } else {//for float
        per = Math.round(percentage * 10) / 10 ;
    }

    return '<b>' + name + '</b><br/>' + value + ': ' + per + '%';

}

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
        return displayName.businessUnit3 + ' : ' + filter.filter
    } else if (filter.type === chartNames.grade) {
        return displayName.grade + ' : ' + filter.filter;
    } else if (filter.type === chartNames.level) {
        return displayName.level + ' : ' + filter.filter;
    } else if (filter.type === chartNames.function) {
        return displayName.function + ' : ' + filter.filter;
    } else if (filter.type === chartNames.rating) {
        return displayName.perfRating + ' : ' + filter.filter;
    } else if (filter.type === chartNames.gender) {
        return displayName.gender + ' : ' + filter.filter;
    } else if (filter.type === chartNames.businessUnit2) {
        return displayName.businessUnit2 + ' : ' + filter.filter;
    } else if (filter.type === chartNames.businessUnit1) {
        return displayName.businessUnit1 + ' : ' + filter.filter;
    } else if (filter.type === chartNames.subFunction) {
        return displayName.subFunction + ' : ' + filter.filter;
    } else if (filter.type === chartNames.subSubFunction) {
        return displayName.subSubFunction + ' : ' + filter.filter;
    } else if (filter.type === chartNames.education) {
        return displayName.education + ' : ' + filter.filter;
    } else if (filter.type === chartNames.identifiedTalent) {
        return displayName.identifiedTalent + ' : ' + filter.filter;
    } else if (filter.type === chartNames.criticalPositionHolder) {
        return displayName.criticalPositionHolder + ' : ' + filter.filter;
    } else if (filter.type === chartNames.specialCategoryOne) {
        return displayName.specialCategoryOne + ' : ' + filter.filter;
    } else if (filter.type === chartNames.urbanRuralClassification) {
        return displayName.urbanRuralClassification + ' : ' + filter.filter;
    } else if (filter.type === chartNames.city) {
        return displayName.city + ' : ' + filter.filter;
    } else if (filter.type === chartNames.country) {
        return displayName.country + ' : ' + filter.filter;
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
    //return $.get('/src-white/data/data-composition.json')
    //return $.get(GRAPHAPIURL)
	$('#rpt_loading').show();
	return $.get(GRAPHAPIURL).always(function(){$('#rpt_loading').hide();});
}

var threeBarChart = null,
    gradeChart = null,
    levelChart = null,
    functionChart = null,
    ratingChart = null,
    tenureChart = null,
    countryChart = null,
    cityChart = null,
    genderChart =  null;
    bu2Chart =  null;
    bu1Chart =  null;
    subFunctionChart =  null;
    subSubFunctionChart =  null;
    educationChart =  null;
    identifiedTalentChart =  null;
    criticalPositionHolderChart =  null;
    specialCategoryOneChart =  null;
    urbanRuralClassificationChart =  null;

function buildCharts() {
    ChartPlugin()

    $('#exportPdf').click(function () {
        exportCharts([threeBarChart, gradeChart]);
    });

    $('#exportPpts').click(function () {
        exportPpts();
    });

    $('#exportCsv').click(function () {
        exportCsv(store.employees);
    });

    buBarChart()
}

function buBarChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit3',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.buLoc)
                        }
                    }
                }
            }
        },
        tooltip: {
            /*formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + '%'
                return s;
            }*/
            formatter: function () {
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit3,
        },
    }, store.buLevelThreeData)

    threeBarChart = new Highcharts.Chart(chartOptions)
    updateCharts()
}

function updateCharts() {
    buildGradeChart();
    buildCountryChart();
    buildCityChart();
    buildLevelChart();
    buildFunctionChart();
    buildPerfRatingChart();
    //buildTenureChart();
    buildGenderChart();
    buildBU1Chart();
    buildBU2Chart();
    buildSubFunctionChart();
    buildSubSubFunctionChart();
	buildEducationChart();
	buildIdentifiedTalentChart();
	buildCriticalPositionHolderChart();
    buildSpecialCategoryOneChart();
	buildUrbanRuralClassificationChart();
}

function buildCountryChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'countryChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.country)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.country,
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
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.city)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.city,
        },
    }, store.cityData)

    cityChart = new Highcharts.Chart(chartOptions)
}

function buildGradeChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByGrade',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.grade)
                        }
                    }
                }
            }
        },
       tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y, true);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.grade,
        },
    }, store.gradeData)
    gradeChart = new Highcharts.Chart(chartOptions)
}

function buildLevelChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByLevel',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.level)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.level,
        },
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
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
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
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.function,
        },
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
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
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
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.perfRating,
        },
    }, store.perfRatingData)

    ratingChart = new Highcharts.Chart(chartOptions)
}

function buildGenderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'genderChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.gender)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.gender,
        },
    }, store.genderData)

    genderChart = new Highcharts.Chart(chartOptions)
}

function buildBU2Chart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit2',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.businessUnit2)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit2,
        },
    }, store.buLevelTwoData)

    bu2Chart = new Highcharts.Chart(chartOptions)
}

function buildBU1Chart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit1',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.businessUnit1)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit1,
        },
    }, store.buLevelOneData)

    bu1Chart = new Highcharts.Chart(chartOptions)
}


function buildSubFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'subFunctionChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.subFunction)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.subFunction,
        },
    }, store.subFunctionData)

    subFunctionChart = new Highcharts.Chart(chartOptions)
}


function buildSubSubFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'subSubFunctionChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.subSubFunction)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.subSubFunction,
        },
    }, store.subSubFunctionData)

    subSubFunctionChart = new Highcharts.Chart(chartOptions)
}


function buildEducationChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'educationChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.education)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.education,
        },
    }, store.educationData)

    educationChart = new Highcharts.Chart(chartOptions)
}


function buildIdentifiedTalentChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'identifiedTalentChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.identifiedTalent)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.identifiedTalent,
        },
    }, store.identifiedTalentData)

    identifiedTalentChart = new Highcharts.Chart(chartOptions)
}


function buildCriticalPositionHolderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'criticalPositionHolderChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.criticalPositionHolder)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.criticalPositionHolder,
        },
    }, store.criticalPositionHolderData)

    criticalPositionHolderChart = new Highcharts.Chart(chartOptions)
}


function buildSpecialCategoryOneChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'specialCategoryOneChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.specialCategoryOne)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.specialCategoryOne,
        },
    }, store.specialCategoryOneData)

    specialCategoryOneChart = new Highcharts.Chart(chartOptions)
}


function buildUrbanRuralClassificationChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'urbanRuralClassificationChart',
            type: 'column'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.category, this.index, chartNames.urbanRuralClassification)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.urbanRuralClassification,
        },
    }, store.urbanRuralClassificationData)

    urbanRuralClassificationChart = new Highcharts.Chart(chartOptions)
}

function App(GRAPHAPIURL) {
    store = new Store();
    Provider(GRAPHAPIURL).then(function(data) {
        $('#countryChart').html("");
		$('#cityChart').html("");
		$('#businessUnit1').html("");
		$('#businessUnit2').html("");
		$('#businessUnit3').html("");
		$('#hcByGrade').html("");
		$('#hcByLevel').html("");
        $('#hcByFunction').html("");
        $('#perfRating').html("");
		$('#hcByTenure').html("");
		$('#genderChart').html("");
		$('#subFunctionChart').html("");
		$('#subSubFunctionChart').html("");
		$('#educationChart').html("");
		$('#identifiedTalentChart').html("");
        $('#criticalPositionHolderChart').html("");
        $('#specialCategoryOneChart').html("");
        $('#urbanRuralClassificationChart').html("");

		$('.filters').hide();
		if(data.statusCode == 200 && data.data !="")
		{
			$('.filters').show();
			store.employees = data.data
			store.originalEmps = data.data
			store.buildData()
			buildCharts()
		}
		else
		{
			custom_alert_popup("No record found.");
		}
        
        isLoading = false
    })
}
