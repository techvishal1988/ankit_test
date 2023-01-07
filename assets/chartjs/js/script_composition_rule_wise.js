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
]
var postChartColors = ['#FADBD8', '#F5B7B1', '#F1948A', '#EC7063', '#E74C3C', '#CB4335','#B03A2E','#943126']
var preChartColors = ['#FDEBD0', '#FAD7A0', '#F8C471', '#F5B041', '#F39C12', '#D68910', '#B9770E','#9C640C']
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
    //new
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
                        //return get_formated_amount_common(this.y) + '<br> ('+ get_formated_percentage_common(this.percentage,1) + '%)'
                        return get_formated_percentage_common(this.percentage,0) + '%'
                    }
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
    $('#loading').show()
    window.setTimeout(function() {
        domtoimage.toPng(node[0])
            .then(function (dataUrl) {
                var doc = new jsPDF('p', 'in', [w, h]),
                    text = "Composition Dashobard"
                //doc.textCenter(text, { align: "center" }, 0, 0.3)
                doc.addImage(dataUrl, 'JPEG', 0.13, 0.01, w, h);
                doc.save('composition-dashboard.pdf')
                $('#loading').hide()
            });
    }, 100)
}

function exportPpts() {

	$('#loading').show()
	var pptx = new PptxGenJS();
	var chartArray = chartExportPptArray;//["countryChart", "cityChart", "businessUnit1", "hcByGrade", "hcByLevel", "hcByFunction", "perfRating", "genderChart"];
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
			    pptx.save('composition-dashboard');
			    $('#loading').hide()
			}
            });
		}, 1000 * index);

	});
}

function exportCsv(data) {

    var exportArrKeys = ['gen', 'cou', 'city', 'bl_1', 'bl_2', 'bl_3','fun', 's_fun', 's_s_fun', 'gra', 'lev', 'cri_t', 'cri_p', 's_cat', 'urb_r_c', 'edu', 'pf_rat', 'pre_c_rng', 'post_c_rng' ];
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
    XLSX.utils.book_append_sheet(wb, ws, 'Composition Dashboard');
    XLSX.writeFile(wb, "Composition-dashboard.xlsx");
}

function formatNumber(num) {
    if (!num) return 0;
    return parseFloat(Highcharts.numberFormat(num))
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
        this.allRatioRange = this.getUniqueByKey(dataKeys.post_ratio_range, true)
        this.allPreRatioRange = this.getUniqueByKey(dataKeys.pre_ratio_range,true);
        this.ratioRangeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.post_ratio_range] })
        this.preRatioRangeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.pre_ratio_range] })
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
        this.countryData = this.getBarPercentage(this.countryDim, this.ratioRangeDim, this.countries, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getCityDataset = function() {
        this.cities = this.getUniqueByKey(dataKeys.city)
        this.cityDim = this.crossEmps.dimension(function(d) { return d[dataKeys.city] })
        this.cityData = this.getBarPercentage(this.cityDim, this.ratioRangeDim, this.cities, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getCurrentBUDataset = function() {
        this.buLevelThreeValues = this.getUniqueByKey(dataKeys.businessUnit3)
        this.buLevelThreeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit3] })
        this.buLevelThreeData = this.getBarPercentage(this.buLevelThreeDim, this.ratioRangeDim, this.buLevelThreeValues, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange);
    }

    Store.prototype.getGradeData = function() {
        this.gradeKeys = this.getUniqueByKey(dataKeys.grade)
        this.gradeDim = this.crossEmps.dimension(function(d) { return d[dataKeys.grade] })
        this.gradeData = this.getBarPercentage(this.gradeDim, this.ratioRangeDim, this.gradeKeys, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getLevelData = function() {
        this.levelKeys = this.getUniqueByKey(dataKeys.level)
        this.levelDim = this.crossEmps.dimension(function(d) { return d[dataKeys.level] })
        this.levelData = this.getBarPercentage(this.levelDim, this.ratioRangeDim, this.levelKeys, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getFunctionData = function() {
        this.functionKeys = this.getUniqueByKey(dataKeys.function)
        this.functionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.function] })
        this.functionData = this.getBarPercentage(this.functionDim, this.ratioRangeDim, this.functionKeys, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getPerRatingData = function() {
        this.prefRatingKeys = this.getUniqueByKey(dataKeys.perfRating)
        this.perfRatingDim = this.crossEmps.dimension(function(d) { return d[dataKeys.perfRating] })
        this.perfRatingData = this.getBarPercentage(this.perfRatingDim,  this.ratioRangeDim, this.prefRatingKeys, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getGenderData = function() {
        this.genderKeys = this.getUniqueByKey(dataKeys.gender)
        this.genderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.gender] })
        this.genderData = this.getBarPercentage(this.genderDim,  this.ratioRangeDim, this.genderKeys, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getBuLevelOneData = function() {
        this.buLevelOneValues = this.getUniqueByKey(dataKeys.businessUnit1)
        this.buLevelOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit1] })
        this.buLevelOneData = this.getBarPercentage(this.buLevelOneDim, this.ratioRangeDim, this.buLevelOneValues, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getBuLevelTwoData = function() {
        this.buLevelTwoValues = this.getUniqueByKey(dataKeys.businessUnit2)
        this.buLevelTwoDim = this.crossEmps.dimension(function(d) { return d[dataKeys.businessUnit2] })
        this.buLevelTwoData = this.getBarPercentage(this.buLevelTwoDim, this.ratioRangeDim, this.buLevelTwoValues, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getSubFunctionData = function() {
        this.subFunctions = this.getUniqueByKey(dataKeys.subFunction)
        this.subFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subFunction] })
        this.subFunctionData = this.getBarPercentage(this.subFunctionDim, this.ratioRangeDim, this.subFunctions, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getSubSubFunctionData = function() {
        this.subSubFunctions = this.getUniqueByKey(dataKeys.subSubFunction)
        this.subSubFunctionDim = this.crossEmps.dimension(function(d) { return d[dataKeys.subSubFunction] })
        this.subSubFunctionData = this.getBarPercentage(this.subSubFunctionDim, this.ratioRangeDim, this.subSubFunctions, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getEducationData = function() {
        this.educations = this.getUniqueByKey(dataKeys.education)
        this.educationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.education] })
        this.educationData = this.getBarPercentage(this.educationDim, this.ratioRangeDim, this.educations, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getIdentifiedTalentData = function() {
        this.identifiedTalents = this.getUniqueByKey(dataKeys.identifiedTalent)
        this.identifiedTalentDim = this.crossEmps.dimension(function(d) { return d[dataKeys.identifiedTalent] })
        this.identifiedTalentData = this.getBarPercentage(this.identifiedTalentDim, this.ratioRangeDim, this.identifiedTalents, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getCriticalPositionHolderData = function() {
        this.criticalPositionHolders = this.getUniqueByKey(dataKeys.criticalPositionHolder)
        this.criticalPositionHolderDim = this.crossEmps.dimension(function(d) { return d[dataKeys.criticalPositionHolder] })
        this.criticalPositionHolderData = this.getBarPercentage(this.criticalPositionHolderDim, this.ratioRangeDim, this.criticalPositionHolders, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getSpecialCategoryOneData = function() {
        this.specialCategoryOnes = this.getUniqueByKey(dataKeys.specialCategoryOne)
        this.specialCategoryOneDim = this.crossEmps.dimension(function(d) { return d[dataKeys.specialCategoryOne] })
        this.specialCategoryOneData = this.getBarPercentage(this.specialCategoryOneDim, this.ratioRangeDim, this.specialCategoryOnes, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.getUrbanRuralClassificationData = function() {
        this.urbanRuralClassifications = this.getUniqueByKey(dataKeys.urbanRuralClassification)
        this.urbanRuralClassificationDim = this.crossEmps.dimension(function(d) { return d[dataKeys.urbanRuralClassification] })
        this.urbanRuralClassificationData = this.getBarPercentage(this.urbanRuralClassificationDim, this.ratioRangeDim, this.urbanRuralClassifications, this.allRatioRange, this.preRatioRangeDim, this.allPreRatioRange)
    }

    Store.prototype.showTtotal = function(employees) {

        if(employees.length) {
            $(".total-emp").html(' (Total Record: ' + employees.length + ')');
        } else {
            $(".total-emp").html(' (Total Record: ' + 0 + ')');
        }

    }

    Store.prototype.getBarPercentage = function(dim, otherDim, keys, otherKeys, preOtherDim = '', preOtherKeys = '') {

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
              /*  labels: {
                    overflow: 'justify',
                    step: 1
                } */
            },
            series: []
        }

        for (var i = 0; i < preOtherKeys.length; i++) {
            data.push({
                name: preOtherKeys[i] + ' - Pre',
                stack: 'pre',
                color: preChartColors[i],
                data: []
            });
        }

        for (var i = 0; i < otherKeys.length; i++) {
            data.push({
                name: otherKeys[i] + ' - Post',
                stack: 'post',
                color: postChartColors[i],
                data: []
            });
        }

        //for pre
        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            labels.push(keys[i])
            var dl = dim.top(Infinity).length

            if (dl > 0) {
                //for pre
                for (var a = 0; a < preOtherKeys.length; a++) {
                    preOtherDim.filter(preOtherKeys[a])
                    var o = preOtherDim.top(Infinity).length
                    var dr = formatNumber((o / dl) * 100)
                    data = _.map(data.slice(0), function(itemPre) {
                        if (itemPre.name === preOtherKeys[a] + ' - Pre') {
                            itemPre.data.push({
                                y: o,
                                percentage: dr
                            })
                        }
                        return itemPre
                    })
                }
            }
            dim.filter(null)
            preOtherDim.filter(null)
        }
        //end for pre
        //for post
        for (var i = 0; i < keys.length; i++) {
            dim.filter(keys[i])
            var dl = dim.top(Infinity).length

            if (dl > 0) {
                for (var j = 0; j < otherKeys.length; j++) {
                    otherDim.filter(otherKeys[j])
                    var o = otherDim.top(Infinity).length
                    var dr = formatNumber((o / dl) * 100)
                    data = _.map(data.slice(0), function(item) {
                        if (item.name === otherKeys[j] + ' - Post') {
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
        //end for post
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

    Store.prototype.getUniqueByKey = function(key, shortByRange = false) {

        var loc = []
        for (var i = 0; i < this.employees.length; i++) {

            if (!loc.includes(this.employees[i][key])) {
                loc.push(this.employees[i][key])
            }
        }

        if(shortByRange){
            //this is use only in case of short range
            var firstVal = '';
            var lastVal = '';
            var locNew = [];

            $.each(loc, function (key, val) {
                hasPush = true;
                if (val.search('<') != -1) {
                    firstVal = val;
                    hasPush = false;
                }

                if (val.search('>') != -1) {
                    hasPush = false;
                    lastVal = val;
                }

                if(hasPush) {
                    locNew.push(val);
                }
            });

            locNew = locNew.sort();

            if(firstVal != '') {
                locNew.unshift(firstVal);
            }

            if(lastVal != '') {
                locNew.push(lastVal);
            }

            return locNew;

        } else {
            return loc.sort();
        }
    }

    Store.titlePrefix = 'Comp Positioning by ';

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

    return '<b>' + key + '</b><br/>' + name + ': ' + value + ' (' + per + '%)';

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

function Provider(dataurl) {
    //return $.get(dataurl)
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
                }
            }
        },
        tooltip: {
          /* formatter: function () {
                var s = '<b>' + this.key + '</b><br/>';
                s += this.series.name + ': ' + this.y + ' (' + formatNumber(this.percentage) + '%)'
                return s;
            }*/
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
                stacking: 'percent'
            },
            series: {
                //stacking: 'percent',
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
                stacking: 'percent'
            },
            series: {
               // stacking: 'percent',
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
                stacking: 'percent'
            },
            series: {
                //stacking: 'percent',
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
              stacking: 'percent'
            },
            series: {
                //stacking: 'percent',
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
                stacking: 'percent'
            },
            series: {
                //stacking: 'percent',
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
                stacking: 'percent'
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
			$('.filters').show();
			store.employees = data.data;
            store.originalEmps = data.data;
			store.buildData();
			buildCharts();
		}
		else
		{
            custom_alert_popup("No record found.");
            store.employees = '';
            store.originalEmps = '';
			store.buildData();
            buildCharts();
		}
        isLoading = false
    })
}
