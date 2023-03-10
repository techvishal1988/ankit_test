var chartColors = ["#ADD8E6", "#6495ED", "#4682B4", "#4169E1", "#191970", "#87CEFA", "#87CEEB", "#00BFFF", "#B0C4DE", "#1E90FF"],
    store = null,
    isLoading = !0,
    chartNames = {
        buLoc: "buLoc",
        grade: "grade",
        level: "level",
        function: "function",
        rating: "rating",
        tenure: "tenure",
        city: "city",
        country: "country",
        gender: "gender",
        businessUnit1: "businessUnit1",
        businessUnit2: "businessUnit2",
        subFunction: "subFunction",
        subSubFunction: "subSubFunction",
        education: "education",
        identifiedTalent: "identifiedTalent",
        criticalPositionHolder: "criticalPositionHolder",
        specialCategoryOne: "specialCategoryOne",
        urbanRuralClassification: "urbanRuralClassification"
    };

function getDateDiff(t) {
    return moment().diff(t, "months")
}

function getInch(t) {
    return Math.round(t / 95.999999998601)
}

function ChartPlugin() {
    Highcharts.setOptions({
        lang: {
            noData: "No data is available in the graph"
        },
        plotOptions: {
            series: {
                colorByPoint: !1,
                borderWidth: 0,
                dataLabels: {
                    enabled: !0,
                    crop: !1,
                    overflow: "none",
                    style: {
                        fontSize: "12px",
                        color: "#000",
                        fontFamily: "Century Gothic Regular",
                        textOutline: !1,
                        textShadow: !1
                    },
                    allowOverlap: !1,
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
                    color: "#000",
                    cursor: "default",
                    fontSize: "11px"
                }
            }
        },
        xAxis: {
            labels: {
                style: {
                    color: "#000",
                    cursor: "default",
                    fontSize: "11px"
                }
            }
        },
        chart: {
            style: {
                fontFamily: "Century Gothic Regular",
                color: "#000",
                fontWeight: "600"
            }
        },
        legend: {
            align: "right",
            verticalAlign: "middle",
            layout: "vertical"
        },
        exporting: exportOptions()
    })
}

function exportCharts(t) {
    var e = $("#chartNode"),
        i = getInch(e.width()),
        n = getInch(e.height());
    $("#loading").show(), window.setTimeout(function() {
        domtoimage.toPng(e[0]).then(function(t) {
            var e = new jsPDF("p", "in", [i, n]);
            e.addImage(t, "JPEG", .13, .01, i, n), e.save("salary-increase-report.pdf"), $("#loading").hide()
        })
    }, 100)
}

function exportPpts() {
    $("#loading").show();
    var t = new PptxGenJS,
        e = chartExportPptArray,
        i = 0;
    $(e).each(function(n, a) {
        setTimeout(function() {
            node = $("#" + a);
            var n = getInch(node.width()),
                s = getInch(node.height());
            domtoimage.toPng(node[0]).then(function(a) {
                var r = t.addNewSlide();
                r.back = "F1F1F1", $.when(r).done(function(t) {
                    t.addImage({
                        data: a,
                        x: 1.5,
                        y: 1.25,
                        w: n,
                        h: s
                    }), i++
                }), i == e.length && (t.save("salary-increase-report"), $("#loading").hide())
            })
        }, 1e3 * n)
    })
}

function exportCsv(t) {
    var e = {},
        i = [];
    $.each(t, function(t, n) {
        e = {}, $.each(n, function(t, i) {
            e[t.replace(/\_/g, " ").toLowerCase().toUpperCase()] = i
        }), i[t] = e
    });
    var n = XLSX.utils.json_to_sheet(i),
        a = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(a, n, "Salary increase"), XLSX.writeFile(a, "salary-increase-report.xlsx")
}
jsPDF.API.textCenter = function(t, e, i, n) {
    if ("center" == (e = e || {}).align) {
        var a = this.internal.getFontSize(),
            s = this.internal.pageSize.width;
        txtWidth = this.getStringUnitWidth(t) * a / this.internal.scaleFactor, i = (s - txtWidth) / 2
    }
    this.text(t, i, n)
};
var Store = function() {
        function t() {
            this.originalEmps = [], this.employees = [], this.allFilters = [], this.currency = "", this.crossEmps = null, this.countryDim = {}, this.countryData = {}, this.countries = [], this.cities = [], this.cityDim = {}, this.cityData = {}, this.buLevelOneValues = [], this.buLevelOneDim = {}, this.buLevelOneData = {}, this.buLevelTwoValues = [], this.buLevelTwoDim = {}, this.buLevelTwoData = {}, this.buLevelThreeValues = [], this.buLevelThreeDim = {}, this.buLevelThreeData = {}, this.gradeKeys = [], this.gradeDim = {}, this.gradeData = {}, this.levelKeys = [], this.levelDim = {}, this.levelData = {}, this.functionKeys = [], this.functionDim = {}, this.functionData = {}, this.prefRatingKeys = [], this.perfRatingDim = {}, this.perfRatingData = {}, this.genderKeys = [], this.genderDim = {}, this.genderData = {}, this.subFunctionDim = {}, this.subFunctionData = {}, this.subFunctions = [], this.subSubFunctionDim = {}, this.subSubFunctionData = {}, this.subSubFunctions = [], this.educationDim = {}, this.educationData = {}, this.educations = [], this.identifiedTalentDim = {}, this.identifiedTalentData = {}, this.identifiedTalents = [], this.criticalPositionHolderDim = {}, this.criticalPositionHolderData = {}, this.criticalPositionHolders = [], this.specialCategoryOneDim = {}, this.specialCategoryOneData = {}, this.specialCategoryOnes = [], this.urbanRuralClassificationDim = {}, this.urbanRuralClassificationData = {}, this.urbanRuralClassifications = []
        }
        return t.prototype.buildData = function() {
            this.crossEmps = crossfilter(this.employees), this.showTotal(), this.showCurrency(), this.getBuLevelOneData(), this.getBuLevelTwoData(), this.getCurrentBUDataset(), this.getGradeData(), this.getLevelData(), this.getFunctionData(), this.getSubFunctionData(), this.getPerRatingData(), this.getCountryDataset(), this.getCityDataset(), this.getGenderData(), this.getSubSubFunctionData(), this.getEducationData(), this.getIdentifiedTalentData(), this.getCriticalPositionHolderData(), this.getSpecialCategoryOneData(), this.getUrbanRuralClassificationData()
        }, t.prototype.getCountryDataset = function() {
            this.countries = this.getUniqueByKey(dataKeys.country), this.countryDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.country]
            }), this.countryData = this.getBarPercentage(this.countryDim, this.countries)
        }, t.prototype.getCityDataset = function() {
            this.cities = this.getUniqueByKey(dataKeys.city), this.cityDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.city]
            }), this.cityData = this.getBarPercentage(this.cityDim, this.cities)
        }, t.prototype.getCurrentBUDataset = function() {
            this.buLevelThreeValues = this.getUniqueByKey(dataKeys.businessUnit3), this.buLevelThreeDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.businessUnit3]
            }), this.buLevelThreeData = this.getBarPercentage(this.buLevelThreeDim, this.buLevelThreeValues)
        }, t.prototype.getGradeData = function() {
            this.gradeKeys = this.getUniqueByKey(dataKeys.grade), this.gradeDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.grade]
            }), this.gradeData = this.getBarPercentage(this.gradeDim, this.gradeKeys)
        }, t.prototype.getLevelData = function() {
            this.levelKeys = this.getUniqueByKey(dataKeys.level), this.levelDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.level]
            }), this.levelData = this.getBarPercentage(this.levelDim, this.levelKeys)
        }, t.prototype.getFunctionData = function() {
            this.functionKeys = this.getUniqueByKey(dataKeys.function), this.functionDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.function]
            }), this.functionData = this.getBarPercentage(this.functionDim, this.functionKeys)
        }, t.prototype.getPerRatingData = function() {
            this.prefRatingKeys = this.getUniqueByKey(dataKeys.perfRating), this.perfRatingDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.perfRating]
            }), this.perfRatingData = this.getBarPercentage(this.perfRatingDim, this.prefRatingKeys)
        }, t.prototype.getGenderData = function() {
            this.genderKeys = this.getUniqueByKey(dataKeys.gender), this.genderDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.gender]
            }), this.genderData = this.getBarPercentage(this.genderDim, this.genderKeys)
        }, t.prototype.getBuLevelOneData = function() {
            this.buLevelOneValues = this.getUniqueByKey(dataKeys.businessUnit1), this.buLevelOneDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.businessUnit1]
            }), this.buLevelOneData = this.getBarPercentage(this.buLevelOneDim, this.buLevelOneValues)
        }, t.prototype.getBuLevelTwoData = function() {
            this.buLevelTwoValues = this.getUniqueByKey(dataKeys.businessUnit2), this.buLevelTwoDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.businessUnit2]
            }), this.buLevelTwoData = this.getBarPercentage(this.buLevelTwoDim, this.buLevelTwoValues)
        }, t.prototype.getSubFunctionData = function() {
            this.subFunctions = this.getUniqueByKey(dataKeys.subFunction), this.subFunctionDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.subFunction]
            }), this.subFunctionData = this.getBarPercentage(this.subFunctionDim, this.subFunctions)
        }, t.prototype.getSubSubFunctionData = function() {
            this.subSubFunctions = this.getUniqueByKey(dataKeys.subSubFunction), this.subSubFunctionDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.subSubFunction]
            }), this.subSubFunctionData = this.getBarPercentage(this.subSubFunctionDim, this.subSubFunctions)
        }, t.prototype.getEducationData = function() {
            this.educations = this.getUniqueByKey(dataKeys.education), this.educationDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.education]
            }), this.educationData = this.getBarPercentage(this.educationDim, this.educations)
        }, t.prototype.getIdentifiedTalentData = function() {
            this.identifiedTalents = this.getUniqueByKey(dataKeys.identifiedTalent), this.identifiedTalentDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.identifiedTalent]
            }), this.identifiedTalentData = this.getBarPercentage(this.identifiedTalentDim, this.identifiedTalents)
        }, t.prototype.getCriticalPositionHolderData = function() {
            this.criticalPositionHolders = this.getUniqueByKey(dataKeys.criticalPositionHolder), this.criticalPositionHolderDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.criticalPositionHolder]
            }), this.criticalPositionHolderData = this.getBarPercentage(this.criticalPositionHolderDim, this.criticalPositionHolders)
        }, t.prototype.getSpecialCategoryOneData = function() {
            this.specialCategoryOnes = this.getUniqueByKey(dataKeys.specialCategoryOne), this.specialCategoryOneDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.specialCategoryOne]
            }), this.specialCategoryOneData = this.getBarPercentage(this.specialCategoryOneDim, this.specialCategoryOnes)
        }, t.prototype.getUrbanRuralClassificationData = function() {
            this.urbanRuralClassifications = this.getUniqueByKey(dataKeys.urbanRuralClassification), this.urbanRuralClassificationDim = this.crossEmps.dimension(function(t) {
                return t[dataKeys.urbanRuralClassification]
            }), this.urbanRuralClassificationData = this.getBarPercentage(this.urbanRuralClassificationDim, this.urbanRuralClassifications)
        }, t.prototype.showTotal = function() {
            this.employees.length && $(".total-emp").html(" (Total Record: " + this.employees.length + ")")
        }, t.prototype.showCurrency = function() {
            $(".currency-format").html(this.currency)
        }, t.prototype.getBarPercentage = function(t, e) {
            for (var i = ["Current Salary", "New Salary"], n = [], a = [], s = {
                    xAxis: {
                        categories: [],
                        title: {
                            text: null
                        },
                        labels: {}
                    },
                    yAxis: {
                        allowDecimals: !1,
                        min: 0,
                        title: {
                            text: null
                        }
                    },
                    series: []
                }, r = 0; r < i.length; r++) n.push({
                name: i[r],
                stack: "post",
                data: []
            });
            var o = t.group().reduceSum(function(t) {
                    return t.increment_applied_on_salary
                }).top(1 / 0),
                l = t.group().reduceSum(function(t) {
                    return t.final_salary
                }).top(1 / 0),
                c = [];
            for (r = 0; r < e.length; r++) t.filter(e[r]), a.push(e[r]), $.each(o, function(t, a) {
                a.key == e[r] && (n = _.map(n.slice(0), function(t) {
                    return t.name === i[0] && (t.data.push({
                        y: a.value,
                        percentage: ""
                    }), c[a.key] = a.value), t
                }))
            }), $.each(l, function(t, a) {
                var s = "";
                a.key == e[r] && (n = _.map(n.slice(0), function(t) {
                    return t.name === i[1] && (void 0 !== c[a.key] && null != c[a.key] && (s = (a.value - c[a.key]) / c[a.key] * 100), t.data.push({
                        y: a.value,
                        percentage: s
                    })), t
                }))
            });
            return t.filter(null), s.xAxis.categories = a, s.series = n, s
        }, t.prototype.filterData = function(t) {
            if (this.employees = this.originalEmps.slice(0), this.allFilters = t, t.length)
                for (var e = 0; e < t.length; e++) {
                    var i = t[e];
                    chartNames.buLoc === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.businessUnit3] === i.filter
                    }) : chartNames.grade === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.grade] === i.filter
                    }) : chartNames.level === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.level] === i.filter
                    }) : chartNames.function === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.function] === i.filter
                    }) : chartNames.rating === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.perfRating] === i.filter
                    }) : chartNames.gender === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.gender] === i.filter
                    }) : chartNames.country === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.country] === i.filter
                    }) : chartNames.city === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.city] === i.filter
                    }) : chartNames.businessUnit1 === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.businessUnit1] === i.filter
                    }) : chartNames.businessUnit2 === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.businessUnit2] === i.filter
                    }) : chartNames.subFunction === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.subFunction] === i.filter
                    }) : chartNames.subSubFunction === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.subSubFunction] === i.filter
                    }) : chartNames.education === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.education] === i.filter
                    }) : chartNames.identifiedTalent === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.identifiedTalent] === i.filter
                    }) : chartNames.criticalPositionHolder === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.criticalPositionHolder] === i.filter
                    }) : chartNames.specialCategoryOne === i.type ? this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.specialCategoryOne] === i.filter
                    }) : chartNames.urbanRuralClassification === i.type && (this.employees = _.filter(this.employees.slice(0), function(t) {
                        return t[dataKeys.urbanRuralClassification] === i.filter
                    }))
                }
            this.buildData()
        }, t.prototype.getUniqueByKey = function(t) {
            for (var e = [], i = 0; i < this.employees.length; i++) e.includes(this.employees[i][t]) || e.push(this.employees[i][t]);
            return e.sort()
        }, t.titlePrefix = "Overall Salary Growth by ", t
    }(),
    allFilters = [];

function getDataLabelOption(t, e) {
    return t && (t = get_formated_amount_common(t)), e ? t + "<br> (" + (e = get_formated_percentage_common(e, 0)) + "%)" : t
}

function chartTooltipOption(t, e, i, n) {
    return i && (i = get_formated_amount_common(i)), n ? "<b>" + t + "</b><br/>" + e + ": " + i + " (" + (n = get_formated_percentage_common(n, 0)) + "%)" : "<b>" + t + "</b><br/>" + e + ": " + i
}

function handleChartClick(t, e, i) {
    _.isArray(t) && (t = t[0]), _.findIndex(allFilters.slice(), function(e) {
        return e.filter === t
    }) >= 0 ? allFilters = _.filter(allFilters.slice(), function(e) {
        return e.filter !== t
    }) : allFilters.push({
        type: i,
        filter: t,
        index: e
    }), store.filterData(allFilters), updateVisibleFilters(allFilters), buBarChart()
}

function removeVisibleFilter(t, e) {
    t.splice(e, 1), store.filterData(t), updateVisibleFilters(t), buBarChart()
}

function getTitleAttrib(t) {
    return t.type === chartNames.buLoc ? displayName.businessUnit3 + " : " + t.filter : t.type === chartNames.grade ? displayName.grade + " : " + t.filter : t.type === chartNames.level ? displayName.level + " : " + t.filter : t.type === chartNames.function ? displayName.function+" : " + t.filter : t.type === chartNames.rating ? displayName.perfRating + " : " + t.filter : t.type === chartNames.gender ? displayName.gender + " : " + t.filter : t.type === chartNames.businessUnit2 ? displayName.businessUnit2 + " : " + t.filter : t.type === chartNames.businessUnit1 ? displayName.businessUnit1 + " : " + t.filter : t.type === chartNames.subFunction ? displayName.subFunction + " : " + t.filter : t.type === chartNames.subSubFunction ? displayName.subSubFunction + " : " + t.filter : t.type === chartNames.education ? displayName.education + " : " + t.filter : t.type === chartNames.identifiedTalent ? displayName.identifiedTalent + " : " + t.filter : t.type === chartNames.criticalPositionHolder ? displayName.criticalPositionHolder + " : " + t.filter : t.type === chartNames.specialCategoryOne ? displayName.specialCategoryOne + " : " + t.filter : t.type === chartNames.urbanRuralClassification ? displayName.urbanRuralClassification + " : " + t.filter : t.type === chartNames.city ? displayName.city + " : " + t.filter : t.type === chartNames.country ? displayName.country + " : " + t.filter : "Tenure: " + t.filter
}

function updateVisibleFilters(t) {
    $(".filters");
    var e = $("#appliedFilters");
    e.html(""), _.map(t, function(i, n) {
        var a = $('<div class="filter-item"></div>'),
            s = $('<span class="cross">&times;</span>');
        return a.attr("title", getTitleAttrib(i)), a.append(i.filter), a.append(s), e.append(a), s.click(function() {
            removeVisibleFilter(t, n)
        }), i
    })
}

function Provider(t) {
    return $("#rpt_loading").show(), $.get(t).always(function() {
        $("#rpt_loading").hide()
    })
}
var threeBarChart = null,
    gradeChart = null,
    levelChart = null,
    functionChart = null,
    ratingChart = null,
    tenureChart = null,
    countryChart = null,
    cityChart = null,
    genderChart = null;

function buildCharts() {
    ChartPlugin(), $("#exportPdf").click(function() {
        exportCharts([threeBarChart, gradeChart])
    }), $("#exportPpts").click(function() {
        exportPpts()
    }), $("#exportCsv").click(function() {
        exportCsv(store.employees)
    }), buBarChart()
}

function buBarChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "businessUnit3",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit3
        }
    }, store.buLevelThreeData);
    threeBarChart = new Highcharts.Chart(t), updateCharts()
}

function updateCharts() {
    buildGradeChart(), buildCountryChart(), buildCityChart(), buildLevelChart(), buildFunctionChart(), buildPerfRatingChart(), buildGenderChart(), buildBU1Chart(), buildBU2Chart(), buildSubFunctionChart(), buildSubSubFunctionChart(), buildEducationChart(), buildIdentifiedTalentChart(), buildCriticalPositionHolderChart(), buildSpecialCategoryOneChart(), buildUrbanRuralClassificationChart()
}

function buildCountryChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "countryChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.country
        }
    }, store.countryData);
    countryChart = new Highcharts.Chart(t)
}

function buildCityChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "cityChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.city
        }
    }, store.cityData);
    cityChart = new Highcharts.Chart(t)
}

function buildGradeChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "hcByGrade",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.grade
        }
    }, store.gradeData);
    gradeChart = new Highcharts.Chart(t)
}

function buildLevelChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "hcByLevel",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.level
        }
    }, store.levelData);
    levelChart = new Highcharts.Chart(t)
}

function buildFunctionChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "hcByFunction",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.function
        }
    }, store.functionData);
    functionChart = new Highcharts.Chart(t)
}

function buildPerfRatingChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "perfRating",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.perfRating
        }
    }, store.perfRatingData);
    ratingChart = new Highcharts.Chart(t)
}

function buildGenderChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "genderChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.gender
        }
    }, store.genderData);
    genderChart = new Highcharts.Chart(t)
}

function buildBU2Chart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "businessUnit2",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit2
        }
    }, store.buLevelTwoData);
    bu2Chart = new Highcharts.Chart(t)
}

function buildBU1Chart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "businessUnit1",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.businessUnit1
        }
    }, store.buLevelOneData);
    bu1Chart = new Highcharts.Chart(t)
}

function buildSubFunctionChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "subFunctionChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.subFunction
        }
    }, store.subFunctionData);
    subFunctionChart = new Highcharts.Chart(t)
}

function buildSubSubFunctionChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "subSubFunctionChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.subSubFunction
        }
    }, store.subSubFunctionData);
    subSubFunctionChart = new Highcharts.Chart(t)
}

function buildEducationChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "educationChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.education
        }
    }, store.educationData);
    educationChart = new Highcharts.Chart(t)
}

function buildIdentifiedTalentChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "identifiedTalentChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.identifiedTalent
        }
    }, store.identifiedTalentData);
    identifiedTalentChart = new Highcharts.Chart(t)
}

function buildCriticalPositionHolderChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "criticalPositionHolderChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.criticalPositionHolder
        }
    }, store.criticalPositionHolderData);
    criticalPositionHolderChart = new Highcharts.Chart(t)
}

function buildSpecialCategoryOneChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "specialCategoryOneChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.specialCategoryOne
        }
    }, store.specialCategoryOneData);
    specialCategoryOneChart = new Highcharts.Chart(t)
}

function buildUrbanRuralClassificationChart() {
    var t = _.assign({}, {
        chart: {
            renderTo: "urbanRuralClassificationChart",
            type: "column"
        },
        plotOptions: {
            column: {},
            series: {
                cursor: "pointer",
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
            formatter: function() {
                return chartTooltipOption(this.key, this.series.name, this.y, this.percentage)
            }
        },
        title: {
            text: Store.titlePrefix + displayName.urbanRuralClassification
        }
    }, store.urbanRuralClassificationData);
    urbanRuralClassificationChart = new Highcharts.Chart(t)
}

function App(t) {
    store = new Store, Provider(t).then(function(t) {
        $("#countryChart").html(""), $("#cityChart").html(""), $("#businessUnit1").html(""), $("#businessUnit2").html(""), $("#businessUnit3").html(""), $("#hcByGrade").html(""), $("#hcByLevel").html(""), $("#hcByFunction").html(""), $("#perfRating").html(""), $("#genderChart").html(""), $("#subFunctionChart").html(""), $("#subSubFunctionChart").html(""), $("#educationChart").html(""), $("#identifiedTalentChart").html(""), $("#criticalPositionHolderChart").html(""), $("#specialCategoryOneChart").html(""), $("#urbanRuralClassificationChart").html(""), $(".filters").hide(), 200 == t.statusCode ? (store.currency = t.currency, "" != t.data && ($(".filters").show(), store.employees = t.data, store.originalEmps = t.data, store.buildData(), buildCharts())) : custom_alert_popup("No record found."), isLoading = !1
    })
}
bu2Chart = null, bu1Chart = null, subFunctionChart = null, subSubFunctionChart = null, educationChart = null, identifiedTalentChart = null, criticalPositionHolderChart = null, specialCategoryOneChart = null, urbanRuralClassificationChart = null;