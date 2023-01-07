var chartColors = ['#ADD8E6','#6495ED','#4682B4','#4169E1','#191970','#87CEFA','#87CEEB','#00BFFF','#B0C4DE','#1E90FF'];
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
    return moment().diff(d, 'months')
}

function getInch(px) {
    return Math.round(px / 95.999999998601);
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
                        fontSize:'12px',
                        color: '#000',
                        fontFamily: 'Century Gothic Regular',
                        textOutline: false ,
                        textShadow: false,
                    },
                    allowOverlap: false,
                    formatter: function() {
                        return getDataLabelOption(this.y, this.percentage)
                    }
			    }
			}
        },
        colors: chartColors,
        yAxis: {
            gridLineWidth: 0,
            minorGridLineWidth: 0,
            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px"
                }
            }
        },
        xAxis: {
            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px",
                },
            }
        },
        chart: {
                style: {
                fontFamily: 'Century Gothic Regular',
                color: "#000",
                fontWeight:'600'
            }
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
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

function exportCharts(charts) {
    var node = $('#chartNode')
    var w = getInch(node.width())
    var h = getInch(node.height())
    $('#loading').show()
    window.setTimeout(function() {
        domtoimage.toPng(node[0])
            .then(function (dataUrl) {
                var doc = new jsPDF('p', 'in', [w, h]),
                    text = "Salary Increase Budget Report"
                //doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('salary-increase-budget-report.pdf')
                $('#loading').hide()
            });
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
			    pptx.save('salary-increase-budget-report');
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
    XLSX.utils.book_append_sheet(wb, ws, 'Salary Budget');
    XLSX.writeFile(wb, "salary-increase-budget-report.xlsx");
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
        this.showTotal();
        this.showCurrency();
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
        this.countryData = this.getBarPercentage(this.countryDim, this.countries)
    }

    Store.prototype.getCityDataset = function() {
        this.cities = this.getUniqueByKey(dataKeys.city)
        this.cityDim = this.crossEmps.dimension(function(d) { return d[dataKeys.city] })
        this.cityData = this.getBarPercentage(this.cityDim, this.cities)
    }

    Store.prototype.getCurrentBUDataset = function() {
        this.buLevelThreeValues = this.getUniqueByKey(dataKeys.businessUnit3)
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getBarPercentage(this.buLevelThreeDim, this.buLevelThreeValues);
    }

    Store.prototype.getGradeData = function() {
        this.gradeKeys = this.getUniqueByKey(dataKeys.grade)
        this.gradeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.grade] })
        this.gradeData = this.getBarPercentage(this.gradeDim, this.gradeKeys)
    }

    Store.prototype.getLevelData = function() {
        this.levelKeys = this.getUniqueByKey(dataKeys.level)
        this.levelDim = this.crossEmps.dimension(function(d) { return d[dataKeys.level] })
        this.levelData = this.getBarPercentage(this.levelDim, this.levelKeys)
    }

    Store.prototype.getFunctionData = function() {
        this.functionKeys = this.getUniqueByKey(dataKeys.function)
        this.functionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.function] })
        this.functionData = this.getBarPercentage(this.functionDim, this.functionKeys)
    }

    Store.prototype.getPerRatingData = function() {
        this.prefRatingKeys = this.getUniqueByKey(dataKeys.perfRating)
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getBarPercentage(this.perfRatingDim,  this.prefRatingKeys)
    }

    Store.prototype.getGenderData = function() {
        this.genderKeys = this.getUniqueByKey(dataKeys.gender)
        this.genderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.gender] })
        this.genderData = this.getBarPercentage(this.genderDim,  this.genderKeys)
    }

    Store.prototype.getBuLevelOneData = function() {
        this.buLevelOneValues = this.getUniqueByKey(dataKeys.businessUnit1)
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] })
        this.buLevelOneData = this.getBarPercentage(this.buLevelOneDim, this.buLevelOneValues)
    }

    Store.prototype.getBuLevelTwoData = function() {
        this.buLevelTwoValues = this.getUniqueByKey(dataKeys.businessUnit2)
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] })
        this.buLevelTwoData = this.getBarPercentage(this.buLevelTwoDim, this.buLevelTwoValues)
    }

    Store.prototype.getSubFunctionData = function() {
        this.subFunctions = this.getUniqueByKey(dataKeys.subFunction)
        this.subFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subFunction] })
        this.subFunctionData = this.getBarPercentage(this.subFunctionDim, this.subFunctions)
    }

    Store.prototype.getSubSubFunctionData = function() {
        this.subSubFunctions = this.getUniqueByKey(dataKeys.subSubFunction)
        this.subSubFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subSubFunction] })
        this.subSubFunctionData = this.getBarPercentage(this.subSubFunctionDim, this.subSubFunctions)
    }

    Store.prototype.getEducationData = function() {
        this.educations = this.getUniqueByKey(dataKeys.education)
        this.educationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.education] })
        this.educationData = this.getBarPercentage(this.educationDim, this.educations)
    }

    Store.prototype.getIdentifiedTalentData = function() {
        this.identifiedTalents = this.getUniqueByKey(dataKeys.identifiedTalent)
        this.identifiedTalentDim = this.crossEmps.dimension(function(d) { return d[dataKeys.identifiedTalent] })
        this.identifiedTalentData = this.getBarPercentage(this.identifiedTalentDim, this.identifiedTalents)
    }

    Store.prototype.getCriticalPositionHolderData = function() {
        this.criticalPositionHolders = this.getUniqueByKey(dataKeys.criticalPositionHolder)
        this.criticalPositionHolderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.criticalPositionHolder] })
        this.criticalPositionHolderData = this.getBarPercentage(this.criticalPositionHolderDim, this.criticalPositionHolders)
    }

    Store.prototype.getSpecialCategoryOneData = function() {
        this.specialCategoryOnes = this.getUniqueByKey(dataKeys.specialCategoryOne)
        this.specialCategoryOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.specialCategoryOne] })
        this.specialCategoryOneData = this.getBarPercentage(this.specialCategoryOneDim, this.specialCategoryOnes)
    }

    Store.prototype.getUrbanRuralClassificationData = function() {
        this.urbanRuralClassifications = this.getUniqueByKey(dataKeys.urbanRuralClassification)
        this.urbanRuralClassificationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.urbanRuralClassification] })
        this.urbanRuralClassificationData = this.getBarPercentage(this.urbanRuralClassificationDim, this.urbanRuralClassifications)
    }

    Store.prototype.showTotal = function() {

        if(this.employees.length) {
            $(".total-emp").html(' (Total Record: ' + this.employees.length + ')');
        }

    }

    Store.prototype.showCurrency = function() {
        $(".currency-format").html(this.currency);
    }

    Store.prototype.getBarPercentage = function(dim, keys) {

        var filterKeys = ['Allocated Budget', 'Utilized Budget'];
        var data = []
        var labels = []
        var dataSet = {
            xAxis: {
                categories: [],
                title: {
                    text: null
                },
                labels: {
                //   step: 1
                }
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: null
                },
            },
            series: []
        }

        for (var i = 0; i < filterKeys.length; i++) {
            data.push({
                name: filterKeys[i],
                stack: 'post',
                data: []
            });
        }

        var allocated_budget_total  = dim.group().reduceSum(function(fact) { return fact.allocated_budget; }).top(Infinity);
        var utilized_budget_total   = dim.group().reduceSum(function(fact) { return fact.utilized_budget; }).top(Infinity);
        /* var increment_applied_on_salary_total   = dim.group().reduceSum(function(fact) { return fact.increment_applied_on_salary; }).top(Infinity);
        var previous_salary_arr     = []; */
        var allocated_budget_arr    = [];

        /*$.each(increment_applied_on_salary_total, function (incrementAppliedKey, incrementAppliedData) {

            previous_salary_arr[incrementAppliedData.key] = incrementAppliedData.value;

        });*/

        $.each(allocated_budget_total, function (allocatedBudgetKey, allocatedBudgetData) {

            allocated_budget_arr[allocatedBudgetData.key] = allocatedBudgetData.value;

        });

        for (var i = 0; i < keys.length; i++) {

            dim.filter(keys[i]);
            labels.push(keys[i]);

            $.each(allocated_budget_total, function (allocatedKey, allocatedData) {

                var percentageVal = '';

                if(allocatedData.key == keys[i]) {

                    data = _.map(data.slice(0), function(item) {

                        if (item.name === filterKeys[0]) {

                            /*if(typeof previous_salary_arr[allocatedData.key] != 'undefined' && previous_salary_arr[allocatedData.key] != null) {//calculate percentage
                                percentageVal = (allocatedData.value / previous_salary_arr[allocatedData.key] ) * 100;
                            }*/

                            item.data.push({
                                y: allocatedData.value,
                                percentage: percentageVal,
                            })
                        }
                        return item;
                    });
                }

            });

            $.each(utilized_budget_total, function (utilizedKey, utilizedData) {

                var percentageVal = '';

                if(utilizedData.key == keys[i]) {

                    data = _.map(data.slice(0), function(item) {

                        if (item.name === filterKeys[1]) {

                            if(typeof allocated_budget_arr[utilizedData.key] != 'undefined' && allocated_budget_arr[utilizedData.key] != null && allocated_budget_arr[utilizedData.key]) {//calculate percentage
                                percentageVal = (utilizedData.value / allocated_budget_arr[utilizedData.key] ) * 100;
                            }

                            item.data.push({
                                y: utilizedData.value,
                                percentage: percentageVal,
                            })
                        }
                        return item;
                    })

                }

            });
        }
        dim.filter(null);
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

    Store.titlePrefix = 'Salary increase budget allocation vs utilisation by ';

    return Store
}()

var allFilters = [];

function getDataLabelOption(value, percentage) {
    //round off value
    if(value) {
        value = get_formated_amount_common(value);
    }

    if(percentage) {
        percentage = get_formated_percentage_common(percentage, 0);

        return value + '<br> (' + percentage + '%)';

    } else {

        return value;
    }

}

function chartTooltipOption(key, name, value, percentage) {
    //round off value
    if(value) {
        value = get_formated_amount_common(value);
    }

    if(percentage) {
        percentage = get_formated_percentage_common(percentage, 0);

        return '<b>' + key + '</b><br/>' + name + ': ' + value + ' (' + percentage + '%)';

    } else {

        return '<b>' + key + '</b><br/>' + name + ': ' + value;
    }

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

}

function Provider(dataurl) {
	$('#rpt_loading').show();
	return $.get(dataurl).always(function(){$('#rpt_loading').hide();});
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
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            }
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
        plotOptions:{
            column: {

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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            }
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            }
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            }
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            }
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            }
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },        
        title: {
            text: Store.titlePrefix + displayName.urbanRuralClassification,
        },
    }, store.urbanRuralClassificationData)

    urbanRuralClassificationChart = new Highcharts.Chart(chartOptions)
}

function App(dataurl) {
    store = new Store();
    Provider(dataurl).then(function(data) {
		$('#countryChart').html("");
		$('#cityChart').html("");
		$('#businessUnit1').html("");
		$('#businessUnit2').html("");
		$('#businessUnit3').html("");
		$('#hcByGrade').html("");
		$('#hcByLevel').html("");
		$('#hcByFunction').html("");
		$('#perfRating').html("");
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
            store.currency = data.currency;
            if(data.data !="") {
                $('.filters').show();
                store.employees = data.data
                store.originalEmps = data.data
                store.buildData()
                buildCharts()
            }
		}
		else
		{
			custom_alert_popup("No record found.");
		}
        isLoading = false
    })
}
