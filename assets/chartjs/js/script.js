var report_data = [];
var newcode = true;//this condition apply only for tenure graph
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
    return moment().diff(d, 'months')
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
 
    // Apply the theme
    Highcharts.setOptions({
        lang: {
            noData: 'No data is available in the graph',
        },
		 plotOptions: {
			series: {
                colorByPoint: true,
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
                }
			}
        },
        colors: [
                '#4682B4',
                '#4169E1',
                '#ADD8E6',
                '#87CEFA',
                '#87CEEB',
                '#00BFFF',
                '#B0C4DE',
                '#1E90FF',
                '#6495ED',
                '#191970',
            ],
        yAxis: {
            gridLineWidth: 0,
            minorGridLineWidth: 0,
        },
        chart: {
                style: {
                fontFamily: 'Century Gothic Regular',
                color: "#000",
                fontWeight:'600'
            }
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
                    text = "Head Count Dashobard"
                //doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('head-count-dashboard.pdf')
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
	var chartArray = chartExportPptArray;//["countryChart", "cityChart", "businessUnit1", "hcByGrade", "hcByLevel", "hcByFunction", "perfRating", "hcByTenure", "genderChart"];
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
                    pptx.save('head-count-dashboard');
                    $('#loading').hide()
                }
            });
            }, 1000 * index);

	});

}

function exportCsv(data) {

    var exportArrKeys = ['gender', 'country', 'city', 'business_level_1', 'business_level_2', 'business_level_3',
    'function', 'subfunction', 'sub_subfunction', 'designation', 'grade', 'level', 'education', 'critical_talent', 'critical_position', 'special_category',
    'company_joining_date', 'rating_for_current_year'];//'employee_code', 'name', 'email', 'increment_purpose_joining_date', 'currency', 'current_base_salary', 'current_target_bonus', 'total_compensation', 'approver_1', 'manager_name', 'urban_rural_classification'
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

    /*Store.prototype.update = function() {
        this.buLevelThreeData = this.getBarHeadCount(this.buLevelThreeDim, this.locations);
        this.gradeData = this.getHeadCountPie(this.gradeDim, this.grades)
        this.levelData = this.getHeadCountPie(this.levelDim, this.levels)
        this.functionData = this.getHeadCount(this.functionDim, this.functions)
        this.perfRatingData = this.getHeadCount(this.perfRatingDim, this.perfRatings)
        this.tenureData = this.formatTenureData()
    }*/

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
        var dataNew = []
        var tenure_list_array = []
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

        for (var i = 0; i < dataTop.length; i++) {

            var startDate = dataTop[i][dataKeys.startDate]
            var diff = getDateDiff(new Date(startDate));

            if(newcode) {//use new code
                $.each(tenure_list, function (key, val) {

                    if (diff >= val.start_month && diff < val.end_month) {

                        if (tenure_list_array[val.id] === undefined) {

                            if(this.count === undefined) {
                                this.count = 0;
                            }

                            tenure_list_array[val.id] = {
                                'name':val.slot_no,
                                'count': this.count,
                            }
                        };

                        if (tenure_list_array[val.id]) {

                            tenure_list_array[val.id]['count'] +=  1;

                        }
                    }
                });
            } else {

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
        }

        var colorIndex = _.filter(this.allFilters, function(d) {
            return d.type === chartNames.tenure
        })

        if(newcode) {//use new code
            $.each(tenure_list_array, function (key, val) {

                if (typeof key != 'undefined' && typeof val != 'undefined') {

                    if (colorIndex.length){
                        dataNew.push({
                            name: val.name,
                            y: val.count,
                            color: chartColors[colorIndex[0].index]
                        })
                    } else {
                        dataNew.push({
                            name: val.name,
                            y: val.count
                        })
                    }
                }
            });

            dataSet.series.push({
                data:dataNew,
            });
        } else {//previous code

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
                        y: set13,
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
        }

        return dataSet;
    }

    Store.prototype.getBuLevelOneData = function(filter) {
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] })
        this.buLevelOneData = this.getHeadCountPie(this.buLevelOneDim, this.groups, chartNames.businessUnit1)
    }

    Store.prototype.getBuLevelTwoData = function(filter) {
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] })
        this.buLevelTwoData = this.getHeadCountPie(this.buLevelTwoDim, this.levelUpOrg, chartNames.businessUnit2)
    }

    Store.prototype.getCurrentBUDataset = function(filter) {
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getHeadCountPie(this.buLevelThreeDim, this.locations, chartNames.buLoc)
        //this.buLevelThreeData = this.getBarHeadCount(this.buLevelThreeDim, this.locations);
    }

    Store.prototype.getCountryDataset = function(filter) {
        this.countryDim = this.crossEmps.dimension(function(d) { return d[dataKeys.country] })
        this.countryData = this.getHeadCountPie(this.countryDim, this.countries, chartNames.country)
       // this.countryData = this.getBarHeadCount(this.countryDim, this.countries)
    }

    Store.prototype.getCityDataset = function(filter) {
        this.cityDim = this.crossEmps.dimension(function(d) { return d[dataKeys.city] })
        this.cityData = this.getHeadCountPie(this.cityDim, this.cities, chartNames.city)
       // this.cityData = this.getBarHeadCount(this.cityDim, this.cities)
    }

    Store.prototype.getGradeData = function(filter) {
        this.gradeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.grade] })
        this.gradeData = this.getHeadCountPie(this.gradeDim, this.grades, chartNames.grade)
    }

    Store.prototype.getLevelData = function(filter) {
        this.levelDim = this.crossEmps.dimension(function(d) { return d[dataKeys.level] })
        this.levelData = this.getHeadCountPie(this.levelDim, this.levels, chartNames.level)
    }

    Store.prototype.getFunctionData = function(filter) {
        this.functionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.function] })
        this.functionData = this.getHeadCountPie(this.functionDim, this.functions, chartNames.function)
        //this.functionData = this.getHeadCount(this.functionDim, this.functions, chartNames.function)
    }

    Store.prototype.getPerRatingData = function(filter) {
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getHeadCountPie(this.perfRatingDim, this.perfRatings, chartNames.rating)
        //this.perfRatingData = this.getHeadCount(this.perfRatingDim, this.perfRatings)
    }

    Store.prototype.getGenderData = function(filter) {
        this.genderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.gender] })
        this.genderData = this.getHeadCountPie(this.genderDim, this.genders, chartNames.gender)
    }
   

    Store.prototype.getSubFunctionData = function(filter) {
        this.subFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subFunction] })
        this.subFunctionData = this.getHeadCountPie(this.subFunctionDim, this.subFunctions, chartNames.subFunctions)
    }

    Store.prototype.getSubSubFunctionData = function(filter) {
        this.subSubFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subSubFunction] })
        this.subSubFunctionData = this.getHeadCountPie(this.subSubFunctionDim, this.subSubFunctions, chartNames.subSubFunction)
    }

    Store.prototype.getEducationData = function(filter) {
        this.educationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.education] })
        this.educationData = this.getHeadCountPie(this.educationDim, this.educations, chartNames.education)
    }

    Store.prototype.getIdentifiedTalentData = function(filter) {
        this.identifiedTalentDim = this.crossEmps.dimension(function(d) { return d[dataKeys.identifiedTalent] })
        this.identifiedTalentData = this.getHeadCountPie(this.identifiedTalentDim, this.identifiedTalents, chartNames.identifiedTalent)
    }

    Store.prototype.getCriticalPositionHolderData = function(filter) {
        this.criticalPositionHolderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.criticalPositionHolder] })
        this.criticalPositionHolderData = this.getHeadCountPie(this.criticalPositionHolderDim, this.criticalPositionHolders, chartNames.criticalPositionHolder)
    }

    Store.prototype.getSpecialCategoryOneData = function(filter) {
        this.specialCategoryOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.specialCategoryOne] })
        this.specialCategoryOneData = this.getHeadCountPie(this.specialCategoryOneDim, this.specialCategoryOnes, chartNames.specialCategoryOne)
    }

    Store.prototype.getUrbanRuralClassificationData = function(filter) {
        this.urbanRuralClassificationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.urbanRuralClassification] });
        this.urbanRuralClassificationData = this.getHeadCountPie(this.urbanRuralClassificationDim, this.urbanRuralClassifications, chartNames.urbanRuralClassification);
    }

    Store.prototype.showTtotal = function(employees) {

        if(employees.length) {
            $(".total-emp").html(' (Total Record: ' + employees.length + ')');
        }

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
                    overflow: 'none'
                }
            },
            series: []
        }

        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            //labels.sort();
            var dl = dim.top(Infinity).length
            if (dl > 0) {
                data.push({
                    y: dl,
                    percentage: Highcharts.numberFormat((dl / this.employees.length) * 100),
//                    dataLabels: {
//                        y: (dl / 1.3),
//                        per: 'a'
//                    }
                })
            }
            dim.filter(null)
        }

        dataSet.xAxis.categories = labels;
        dataSet.series.push({
            data: data,
            rPercentage: [1,2,3],
            showInLegend: false
        })

        return dataSet;
    }

    Store.prototype.getHeadCount = function(dim, keys, filter) {
        var data = []
        var labels = []
        //labels.sort();
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
                    overflow: 'none'
                }
            },
            series: []
        }

        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            var dl = dim.top(Infinity).length
            if (dl > 0) {
               /* if (filter === 'Function') {
                    data.push({
                        y: dl,
                        percentage: Highcharts.numberFormat((dl / this.employees.length) * 100),
//                        dataLabels: {
//                            y: dl / 1.7
//                        }
                    })
                } else { */
                    data.push({
                        y: dl,
                        percentage: Highcharts.numberFormat((dl / this.employees.length) * 100),
//                        dataLabels: {
//                            y: dl
//                        }
                    })
                }
           // }
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
                    overflow: 'none'
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

    Store.pieChartInnerSize = '50%';
    Store.pieChartdepth =  25;
    Store.pieChartshowInLegend = true;
    Store.legendItemStyle = {fontWeight: 'bold', fontSize:'11px'};
    Store.pieChartLabelFormat = '<b>{point.y}</b> ({point.percentage:.1f}%)';
    Store.titlePrefix = titlePrefix;

    return Store
}()

var allFilters = [];

function chartTooltipOption(name, value, percentage) {
    var per = 0;

    if (Number.isInteger(percentage)) {//for integer
        per = Math.round(percentage);
    } else {//for float
        per = Math.round(percentage * 10) / 10 ;
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
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.buLoc)
                        }
                    }
                }
            }
        },
        tooltip: {
            /*formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += 'Number of Employees: ' + this.y + ' (' + Math.round(this.percentage * 100) / 100 + '%)';
                return s;
            } */
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit3
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle
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
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.country)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.city)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.grade)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
        title: {
            text: Store.titlePrefix + displayName.grade
        },
        /*exporting: {
            enabled: false
        },*/
    }, store.gradeData)
    gradeChart = new Highcharts.Chart(chartOptions)
}

function buildLevelChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByLevel',
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.level)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
        title: {
            text: Store.titlePrefix+ displayName.level
        },
        /*exporting: {
            enabled: false
        },*/
    }, store.levelData)
    levelChart = new Highcharts.Chart(chartOptions)
}

function buildFunctionChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByFunction',
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.function)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.function
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
    }, store.functionData)

    functionChart = new Highcharts.Chart(chartOptions)
}

function buildPerfRatingChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'perfRating',
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.rating)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        title: {
            text: Store.titlePrefix + displayName.perfRating + ' Distribution'
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
    }, store.perfRatingData)

    ratingChart = new Highcharts.Chart(chartOptions)
}

function buildTenureChart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'hcByTenure',
            type: 'pie',
            animation: Highcharts.svg
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
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
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
        title: {
            text:  Store.titlePrefix + 'Tenure'
        },
        /*exporting: {
            enabled: false
        },*/
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
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.gender)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
        title: {
            text: Store.titlePrefix + displayName.gender
        },
        /*exporting: {
            enabled: false
        },*/
    }, store.genderData)
    genderChart = new Highcharts.Chart(chartOptions)
}


function buildBU2Chart() {
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: 'businessUnit2',
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.businessUnit2)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.businessUnit1)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.subFunction)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.subSubFunction)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.education)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.identifiedTalent)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.criticalPositionHolder)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.specialCategoryOne)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
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
            type: 'pie',
            animation: Highcharts.svg,
        },
        plotOptions: {
            pie: {
                innerSize: Store.pieChartInnerSize,
                depth: Store.pieChartdepth,
                showInLegend: Store.pieChartshowInLegend,
                dataLabels: {
                    enabled: true,
                    format: Store.pieChartLabelFormat,
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            handleChartClick(this.name, this.index, chartNames.urbanRuralClassification)
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () { 
                return chartTooltipOption(this.key, this.y, this.percentage);
            },
        },
        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical',
            itemStyle: Store.legendItemStyle,
        },
        title: {
            text: Store.titlePrefix + displayName.urbanRuralClassification
        },

    }, store.urbanRuralClassificationData)
    urbanRuralClassificationChart = new Highcharts.Chart(chartOptions)
}

/*function App(GRAPHAPIURL) {
    store = new Store();
    Provider(GRAPHAPIURL).then(function(data) {

        $.getScript( BASE_URL + data.filePath)
        .done(function( jsData, textStatus, jqxhr  ) {

            if(jqxhr.status == 200) {

                store.employees = report_data;
                store.originalEmps = report_data;
                store.buildData();
                buildCharts();
                isLoading = false;

            } else {
                alert( "Data not found." );
            }
        })
        .fail(function( jqxhr, settings, exception ) {
           alert( "Data not found." );
        });
    })
}*/

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
