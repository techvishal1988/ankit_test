var newcode = true;//this condition apply only for tenure graph
var chartColors = ['#ADD8E6','#6495ED','#4682B4','#4169E1','#191970','#87CEFA','#87CEEB','#00BFFF','#B0C4DE','#1E90FF'];
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
    return moment().diff(d, 'months')
}


function ChartPlugin() {
 
    // Apply the theme
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
                        textShadow: false
                    },
                    allowOverlap: false,
                    formatter: function() {
                        return get_formated_amount_common(this.y) + ' ('+ get_formated_percentage_common(this.percentage,0) + '%)'
                        //return getRoundOfNumber(this.percentage) + '%'
                    }
                },
            }
        },
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
            type: 'column',
            style: {
                fontFamily: 'Century Gothic Regular',
                color: "#000",
                fontWeight:'600'
            }
        },
        colors: chartColors,
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
    $('#loading').show()
    window.setTimeout(function() {
        domtoimage.toPng(node[0])
            .then(function (dataUrl) {
                var doc = new jsPDF('p', 'in', [w, h]),
                    text = "Successor's Readyness Level Dashobard"
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('successors-readyness-level-dashboard.pdf')
                $('#loading').hide()
            });
    }, 100)
}

function exportPpts(charts) {

    if(typeof chartExportPptArray == 'undefined' || !chartExportPptArray.length) {
        return;
    }

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
                    pptx.save('successors-readyness-level-dashboard');
                    $('#loading').hide()
                }
            });
            }, 1000 * index);

	});

}

function exportCsv(data) {

    var exportArrKeys = ['employee_code', 'name', 'email', 'gender', 'country', 'city', 'business_level_1', 'business_level_2', 'business_level_3',
    'function', 'subfunction', 'sub_subfunction', 'designation', 'grade', 'level', 'education', 'critical_talent', 'critical_position', 'special_category',
    'company_joining_date', 'rating_for_current_year', 'readyness_level'];
    var dataObj = {};
    var dataObjNew = [];
    var displayNameArrKeys = Object.keys(displayName);

   $.each(data, function (key, val) {

       dataObj = {};

       $.each(val, function (key1, value) {

            if ($.inArray( key1, exportArrKeys ) !== -1) {

                $.each(dataKeys, function (displaykey, displayValue) {

                    if(key1 == displayValue) {
                        if ($.inArray(displaykey, displayNameArrKeys) !== -1 ) {
                            dataObj[displayName[displaykey].toUpperCase()] = value;
                        } else {
                            dataObj[key1.replace(/\_/g, ' ').toLowerCase().toUpperCase()] = value;
                        }
                        return false;
                    }
                });
            }
       });

       dataObjNew[key] = dataObj;

   });

    var ws = XLSX.utils.json_to_sheet(dataObjNew)
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Successorss Readyness Level Dashobard');
    XLSX.writeFile(wb, "successors-readyness-level-dashboard.xlsx");
}

function formatNumber(num) {
    if (!num) return 0;
    return parseFloat(Highcharts.numberFormat(num))
}

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
        this.buLevelThreeData = {} //Area
        this.functionDim = {}
        this.functionData = {}
        this.perfRatingDim = {}
        this.perfRatingData = {}
        this.tenureDim = {}
        this.tenureData = {}//Start date for role
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
        this.genders = []

        this.subFunctionDim = {}
        this.subFunctionData = {}
        this.subFunctions = []

        this.subSubFunctionDim = {}
        this.subSubFunctionData = {}
        this.subSubFunctions = []

        this.educationDim = {}
        this.educationData = {}
        this.educations = []

        this.identifiedTalentDim = {}
        this.identifiedTalentData = {}
        this.identifiedTalents = []

        this.criticalPositionHolderDim = {}
        this.criticalPositionHolderData = {}
        this.criticalPositionHolders = []

        this.specialCategoryOneDim = {}
        this.specialCategoryOneData = {}
        this.specialCategoryOnes = []

        this.urbanRuralClassificationDim = {}
        this.urbanRuralClassificationData = {}
        this.urbanRuralClassifications = []
    }

    Store.prototype.buildData = function() {
        this.crossEmps = crossfilter(this.employees);
        this.allRatioRange = this.getUniqueByKey(dataKeys.readynessLevel).reverse();
        this.ratioRangeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.readynessLevel] })
        this.groups = this.getUniqueByKey(dataKeys.businessUnit1);
        this.levelUpOrg = this.getUniqueByKey(dataKeys.businessUnit2);
        this.locations = this.getUniqueByKey(dataKeys.businessUnit3);
        this.grades = this.getUniqueByKey(dataKeys.grade);
        this.levels = this.getUniqueByKey(dataKeys.level);
        this.functions = this.getUniqueByKey(dataKeys.function);
        this.subFunctions = this.getUniqueByKey(dataKeys.subFunction);
        this.perfRatings = this.getUniqueByKey(dataKeys.perfRating);
        this.countries = this.getUniqueByKey(dataKeys.country);
        this.cities = this.getUniqueByKey(dataKeys.city);
        this.genders = this.getUniqueByKey(dataKeys.gender);
        this.subSubFunctions = this.getUniqueByKey(dataKeys.subSubFunction);
        this.educations = this.getUniqueByKey(dataKeys.education);
        this.identifiedTalents = this.getUniqueByKey(dataKeys.identifiedTalent);
        this.criticalPositionHolders = this.getUniqueByKey(dataKeys.criticalPositionHolder);
        this.specialCategoryOnes = this.getUniqueByKey(dataKeys.specialCategoryOne);
        this.urbanRuralClassifications = this.getUniqueByKey(dataKeys.urbanRuralClassification);

        this.showTtotal(this.employees);
        this.getBuLevelOneData();
        this.getBuLevelTwoData();
        this.getCurrentBUDataset();
        this.getGradeData();
        this.getLevelData();
        this.getFunctionData();
        this.getSubFunctionData();
        this.getPerRatingData();
        this.getTenureData();
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

    Store.prototype.getTenureData = function() {
        this.tenureDim = this.crossEmps.dimension(function(d) { return d[dataKeys.startDate] })
        this.tenureData = this.formatTenureData(this.tenureDim , this.ratioRangeDim, dataKeys.startDate, this.allRatioRange);
    }

    Store.prototype.formatTenureData = function(dim, otherDim, keys, otherKeys) {
        var dataTop     = dim.top(Infinity);
        var otherKeys   = otherKeys;
        var slot_no_arr = [];
        var labels      = [];
        var dataNew     = [];
        var tenure_list_array = [];
        var tenure_list_array_new = [];
        var tenure_slot_arr = [];
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
                    overflow: 'none'
                }
            },
            series: [],
        }

        $.each(tenure_list, function (key, val) {
            tenure_slot_arr[key] = val.slot_no;
        });

        $.each(otherKeys, function (allRatioRangeKey, allRatioRangeVal) {

            tenure_list_array = [];
            slot_no_arr       = [];

            for (var i = 0; i < dataTop.length; i++) {

                var startDate = dataTop[i][dataKeys.startDate]
                var diff = getDateDiff(new Date(startDate));

                if (dataTop[i][dataKeys.readynessLevel] == allRatioRangeVal) {

                    $.each(tenure_list, function (key, val) {

                        if (diff >= val.start_month && diff < val.end_month) {

                            if (tenure_list_array[val.id] === undefined) {

                                if(this.count === undefined) {
                                    this.count = 0;
                                }

                                tenure_list_array[val.id] = {
                                    'name':val.slot_no,
                                    'count': this.count,
                                    'datakey': allRatioRangeVal,
                                }

                                slot_no_arr[key] = val.slot_no;
                            };

                            if (tenure_list_array[val.id]) {

                                tenure_list_array[val.id]['count'] +=  1;

                            }
                        }
                    });
                }
            }

            var tenure_list_array_f = [];
            var getValue = false;
            $.each(tenure_list, function (key, val) {
                getValue =  false;
                $.each(tenure_list_array, function (keyList, valList) {

                    if (typeof keyList != 'undefined' && typeof valList != 'undefined') {
                        if (val.slot_no == valList.name ) {
                            tenure_list_array_f[key] = valList;
                            getValue = true;
                        }
                    }
                });

                if(!getValue) {

                    tenure_list_array_f[key] = {
                        'name':val.slot_no,
                        'count': 0,
                        'datakey': allRatioRangeVal,
                    };
                }
            }); 

            tenure_list_array_new[allRatioRangeKey]  = tenure_list_array_f;//tenure_list_array;
        });

        var colorIndex = _.filter(this.allFilters, function(d) {
            return d.type === chartNames.tenure
        });
        var dataf = [];
        $.each(tenure_list_array_new, function (keyt, valt) {

            dataNew.push({
                name: otherKeys[keyt],
                stack: 'post',
            });

            dataf = [];
            $.each(valt, function (key, val) {

                if (typeof key != 'undefined' && typeof val != 'undefined') {

                    if ($.inArray( val.name, labels ) == -1) {
                        labels.push(val.name);
                    }

                    if (colorIndex.length){
                        dataf.push({
                            name: val.name,
                            y: val.count,
                        //   color: chartColors[colorIndex[0].index]
                        })
                    } else {
                        dataf.push({
                        name: val.name,
                            y: val.count
                        })
                    }
                }
            });

            dataNew[keyt]['data'] = dataf;

        });
        dataSet.xAxis.categories = labels;
        dataSet.series = dataNew;

        return dataSet;
    }

    Store.prototype.getBuLevelOneData = function() {
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] });
        this.buLevelOneData = this.getBarPercentage(this.buLevelOneDim, this.ratioRangeDim, this.groups, this.allRatioRange);
    }

    Store.prototype.getBuLevelTwoData = function() {
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] });
        this.buLevelTwoData = this.getBarPercentage(this.buLevelTwoDim, this.ratioRangeDim, this.levelUpOrg, this.allRatioRange);
    }

    Store.prototype.getCurrentBUDataset = function() {
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] });
        this.buLevelThreeData = this.getBarPercentage(this.buLevelThreeDim, this.ratioRangeDim, this.locations, this.allRatioRange);
    }

    Store.prototype.getCountryDataset = function() {
        this.countryDim = this.crossEmps.dimension(function(d) { return d[dataKeys.country] });
        this.countryData = this.getBarPercentage(this.countryDim, this.ratioRangeDim, this.countries, this.allRatioRange);
    }

    Store.prototype.getCityDataset = function() {
        this.cityDim = this.crossEmps.dimension(function(d) { return d[dataKeys.city] });
        this.cityData = this.getBarPercentage(this.cityDim, this.ratioRangeDim, this.cities, this.allRatioRange);
    }

    Store.prototype.getGradeData = function() {
        this.gradeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.grade] });
        this.gradeData = this.getBarPercentage(this.gradeDim, this.ratioRangeDim, this.grades, this.allRatioRange);
    }

    Store.prototype.getLevelData = function() {
        this.levelDim = this.crossEmps.dimension(function(d) { return d[dataKeys.level] });
        this.levelData = this.getBarPercentage(this.levelDim, this.ratioRangeDim, this.levels, this.allRatioRange);
    }

    Store.prototype.getFunctionData = function() {
        this.functionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.function] });
        this.functionData = this.getBarPercentage(this.functionDim, this.ratioRangeDim, this.functions, this.allRatioRange);
    }

    Store.prototype.getPerRatingData = function() {
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] });
        this.perfRatingData = this.getBarPercentage(this.perfRatingDim, this.ratioRangeDim, this.perfRatings, this.allRatioRange);
    }

    Store.prototype.getGenderData = function() {
        this.genderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.gender] });
        this.genderData = this.getBarPercentage(this.genderDim, this.ratioRangeDim, this.genders, this.allRatioRange);
    }
   

    Store.prototype.getSubFunctionData = function() {
        this.subFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subFunction] });
        this.subFunctionData = this.getBarPercentage(this.subFunctionDim, this.ratioRangeDim, this.subFunctions, this.allRatioRange);
    }

    Store.prototype.getSubSubFunctionData = function() {
        this.subSubFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subSubFunction] });
        this.subSubFunctionData = this.getBarPercentage(this.subSubFunctionDim, this.ratioRangeDim, this.subSubFunctions, this.allRatioRange);
    }

    Store.prototype.getEducationData = function() {
        this.educationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.education] });
        this.educationData = this.getBarPercentage(this.educationDim, this.ratioRangeDim, this.educations, this.allRatioRange);
    }

    Store.prototype.getIdentifiedTalentData = function() {
        this.identifiedTalentDim = this.crossEmps.dimension(function(d) { return d[dataKeys.identifiedTalent] });
        this.identifiedTalentData = this.getBarPercentage(this.identifiedTalentDim, this.ratioRangeDim, this.identifiedTalents, this.allRatioRange);
    }

    Store.prototype.getCriticalPositionHolderData = function() {
        this.criticalPositionHolderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.criticalPositionHolder] });
        this.criticalPositionHolderData = this.getBarPercentage(this.criticalPositionHolderDim, this.ratioRangeDim, this.criticalPositionHolders, this.allRatioRange);
    }

    Store.prototype.getSpecialCategoryOneData = function() {
        this.specialCategoryOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.specialCategoryOne] });
        this.specialCategoryOneData = this.getBarPercentage(this.specialCategoryOneDim, this.ratioRangeDim, this.specialCategoryOnes, this.allRatioRange);
    }

    Store.prototype.getUrbanRuralClassificationData = function() {
        this.urbanRuralClassificationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.urbanRuralClassification] });;
        this.urbanRuralClassificationData = this.getBarPercentage(this.urbanRuralClassificationDim, this.ratioRangeDim, this.urbanRuralClassifications, this.allRatioRange);
    }

    Store.prototype.showTtotal = function(employees) {

        if(employees.length) {
            $(".total-emp").html(' (Total Record: ' + employees.length + ')');
        }

    }


    Store.prototype.getBarPercentage = function(dim, otherDim, keys, otherKeys) {
        var data = []
        var labels = []
        var dataSet = {
            xAxis: {
                categories: [],
                title: {
                    text: null
                },
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
            },
            series: []
        }

        for (var i = 0; i < otherKeys.length; i++) {
            data.push({
                name: otherKeys[i],
                stack: 'post',
                data: []
            });
        }
        
        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            var fValues = dim.top(Infinity);
            var dl = dim.top(Infinity).length

            if (dl > 0) {
                for (var j = 0; j < otherKeys.length; j++) {
                    otherDim.filter(otherKeys[j])
                    var o = otherDim.top(Infinity).length
                    var dr = formatNumber((o / dl) * 100)
                    data = _.map(data.slice(0), function(item) {
                        if (item.name === otherKeys[j]) {
                            item.data.push({
                                y: o,
                                percentage: dr
                            })
                        }
                        return item
                    })
                }
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
                } else if (chartNames.tenure === curF.type) {
                    this.employees = _.filter(this.employees.slice(0), function(d) {
                        var diff = getDateDiff(new Date(d[dataKeys.startDate]));

                        if(newcode) {//use new code
                            var cond = false;
                            $.each(tenure_list, function (key, val) {

                                if (curF.filter === val.slot_no ) {

                                    if (diff >= val.start_month && diff < val.end_month) {
                                        cond = true;//diff >= val.start_month && diff < val.end_month
                                        return false;
                                    }
                                }
                            });
                            return cond;//diff >= val.start_month && diff < val.end_month

                        } else {//previous code

                            if (curF.filter === '0-1 yrs') {
                                return diff >= 0 && diff < 1
                            }
                            if (curF.filter === '1-3 yrs') {
                                return diff >= 1 && diff < 3
                            }
                            if (curF.filter === '2-5 yrs') {
                                return diff >= 3 && diff < 5
                            }
                            if (curF.filter === '5-10 yrs') {
                                return diff >= 5 && diff < 10
                            }
                            if (curF.filter === '>10 yrs') {
                                return diff >= 10
                            }
                        }
                        return []
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
            if (loc.indexOf(this.employees[i][key]) === -1 && this.employees[i][key]) {
                loc.push(this.employees[i][key])
            }
        }
        return loc.sort();
    }

    Store.titlePrefix = titlePrefix;

    return Store
}()

var allFilters = [];

function chartTooltipOption(key, name, value, percentage) {
    var per = 0;

    /*if (Number.isInteger(percentage)) {//for integer
        per = Math.round(percentage);
    } else {//for float
        per = Math.round(percentage * 10) / 10 ;
    }*/

    if(percentage){
        per   = get_formated_percentage_common(percentage,0);
    }

    if(value){
        value = get_formated_amount_common(value);
    }
    var s = '<b>' + name + '</b><br/>';
    s += 'Number of Employees: ' + value + ' (' + per + '%)';

    return s;
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

function Provider(GRAPHAPIURL) {
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

    $('#exportCsv').click(function () {
        exportCsv(store.employees);
    });

    $('#exportPpts').click(function () {
        exportPpts([threeBarChart, gradeChart]);
    });

    buBarChart()
}

function buBarChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit3',
            animation: Highcharts.svg
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
            formatter: function () { 
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit3
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
    buildTenureChart();
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
            animation: Highcharts.svg
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.country
        },
    }, store.countryData)

    countryChart = new Highcharts.Chart(chartOptions)
}

function buildCityChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'cityChart',
            animation: Highcharts.svg
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.city
        },
    }, store.cityData)

    cityChart = new Highcharts.Chart(chartOptions)
}

function buildGradeChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByGrade',
            animation: Highcharts.svg
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.grade
        },
    }, store.gradeData)
    gradeChart = new Highcharts.Chart(chartOptions)
}

function buildLevelChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByLevel',
            animation: Highcharts.svg
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix+ displayName.level
        },
    }, store.levelData)
    levelChart = new Highcharts.Chart(chartOptions)
}

function buildFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByFunction',
            animation: Highcharts.svg
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix+ displayName.function
        },
    }, store.functionData)

    functionChart = new Highcharts.Chart(chartOptions)
}

function buildPerfRatingChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'perfRating',
            animation: Highcharts.svg
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix+ displayName.perfRating
        },
    }, store.perfRatingData)

    ratingChart = new Highcharts.Chart(chartOptions)
}


function buildTenureChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByTenure',
            animation: Highcharts.svg
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
                            handleChartClick(this.category, this.index, chartNames.tenure)
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
            text:  Store.titlePrefix + 'Tenure'
        },
    }, store.tenureData)
    tenureChart = new Highcharts.Chart(chartOptions)
}

function buildGenderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'genderChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.gender
        },
    }, store.genderData)
    genderChart = new Highcharts.Chart(chartOptions)
}


function buildBU2Chart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit2',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit2
        },

    }, store.buLevelTwoData)
    bu2Chart = new Highcharts.Chart(chartOptions)
}


function buildBU1Chart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit1',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit1
        },

    }, store.buLevelOneData)
    bu1Chart = new Highcharts.Chart(chartOptions)
}


function buildSubFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'subFunctionChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.subFunction
        },

    }, store.subFunctionData)
    subFunctionChart = new Highcharts.Chart(chartOptions)
}


function buildSubSubFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'subSubFunctionChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.subSubFunction
        },

    }, store.subSubFunctionData)
    subSubFunctionChart = new Highcharts.Chart(chartOptions)
}


function buildEducationChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'educationChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.education
        },

    }, store.educationData)
    educationChart = new Highcharts.Chart(chartOptions)
}


function buildIdentifiedTalentChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'identifiedTalentChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.identifiedTalent
        },

    }, store.identifiedTalentData)
    identifiedTalentChart = new Highcharts.Chart(chartOptions)
}


function buildCriticalPositionHolderChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'criticalPositionHolderChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.criticalPositionHolder
        },

    }, store.criticalPositionHolderData)
    criticalPositionHolderChart = new Highcharts.Chart(chartOptions)
}


function buildSpecialCategoryOneChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'specialCategoryOneChart',
            animation: Highcharts.svg,
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
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.specialCategoryOne
        },

    }, store.specialCategoryOneData)
    specialCategoryOneChart = new Highcharts.Chart(chartOptions)
}


function buildUrbanRuralClassificationChart() {

    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'urbanRuralClassificationChart',
            animation: Highcharts.svg,
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
                            handleChartClick(this.category, this.index, chartNames.buLurbanRuralClassificationoc)
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
            text: Store.titlePrefix + displayName.urbanRuralClassification
        },

    }, store.urbanRuralClassificationData)
    urbanRuralClassificationChart = new Highcharts.Chart(chartOptions)
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
