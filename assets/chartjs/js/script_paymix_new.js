Highcharts.SVGRenderer.prototype.symbols.download = function (x, y, w, h) {
  var path = [
    // Arrow stem
    'M', x + w * 0.5, y,
    'L', x + w * 0.5, y + h * 0.7,
    // Arrow head
    'M', x + w * 0.3, y + h * 0.5,
    'L', x + w * 0.5, y + h * 0.7,
    'L', x + w * 0.7, y + h * 0.5,
    // Box
    'M', x, y + h * 0.9,
    'L', x, y + h,
    'L', x + w, y + h,
    'L', x + w, y + h * 0.9
  ];
  return path;
};

initialize = function (url) {
  _DATA = [];
  $('#rpt_loading').show();
  getData = function (url) {
    $.ajax({
      type: "GET",
      url: url
    }).always(function () {
      $('#rpt_loading').hide();
    }).done(function (apiResponse) {
      data = apiResponse.data;
      _DATA = apiResponse.data;
      ALLOWANCE_KEY_WORD = 'allowance_';
      getAllowanceKeys = function (data) {
        keys = Object.keys(data[0]);
        allowance_keys = [];
        keys.forEach(function (key) {
          if (key.indexOf(ALLOWANCE_KEY_WORD) === 0) {
            allowance_keys.push(key);
          }
        });
        return allowance_keys;
      }

      _ALLOWANCE_KEYS = getAllowanceKeys(data);

      chartIds = [];
      filters = {};

      hasSameDemographic = function (newDemographic, currentDemographic, demography) {
        return newDemographic['name'] === currentDemographic[demography];
      }

      renderFilters = function () {
        filterElement = document.getElementById('appliedFilters');
        baseTag = '';
        if (filters['country'] !== undefined) {
          baseTag += '<div class="filter-item" title="Country: ' + filters['country'] + '">' + filters['country'] + '<span class="cross">x</span></div>'
        }
        if (filters['city'] !== undefined) {
          baseTag += '<div class="filter-item" title="City: ' + filters['city'] + '">' + filters['city'] + '<span class="cross">x</span></div>'
        }
        if (filters['grade'] !== undefined) {
          baseTag += '<div class="filter-item" title="Grade: ' + filters['grade'] + '">' + filters['grade'] + '<span class="cross">x</span></div>'
        }
        if (filters['level'] !== undefined) {
          baseTag += '<div class="filter-item" title="Level: ' + filters['level'] + '">' + filters['level'] + '<span class="cross">x</span></div>'
        }
        if (filters['function'] !== undefined) {
          baseTag += '<div class="filter-item" title="Function: ' + filters['function'] + '">' + filters['function'] + '<span class="cross">x</span></div>'
        }
        if (filters['businessunit'] !== undefined) {
          baseTag += '<div class="filter-item" title="BusinessUnit: ' + filters['businessunit'] + '">' + filters['businessunit'] + '<span class="cross">x</span></div>'
        }
        filterElement.innerHTML = baseTag;
      }

      isFiltered = function (data) {
        filtered = true;
        if (filters['country'] !== undefined) {
          filtered = filtered && (data.country == filters['country']);
        }
        if (filters['city'] !== undefined) {
          filtered = filtered && (data.city == filters['city']);
        }
        if (filters['grade'] !== undefined) {
          filtered = filtered && (data.grade == filters['grade']);
        }
        if (filters['level'] !== undefined) {
          filtered = filtered && (data.level == filters['level']);
        }
        if (filters['function'] !== undefined) {
          filtered = filtered && (data.function == filters['function']);
        }
        if (filters['businessunit'] !== undefined) {
          filtered = filtered && (data['business_level_3'] == filters['businessunit']);
        }
        return filtered;
      }

      formNewDemographic = function (data, keys) {
        newDemographicValues = [];
        keys.forEach(function (key) {
          newDemographicValues[key] = Number(data[key]);
        });
        return newDemographicValues
      }

      sumDemographics = function (existingDemographic, additionalDemographic, keys) {
        newDemographicValues = [];
        newDemographicValues['name'] = existingDemographic['name'];
        keys.forEach(function (key) {
          newDemographicValues[key] = existingDemographic[key] + additionalDemographic[key];
        });
        return newDemographicValues
      }

      avgDemographic = function (existingDemographic, count, keys) {
        newDemographicValues = [];
        newDemographicValues['name'] = existingDemographic['name'];
        keys.forEach(function (key) {
          newDemographicValues[key] = existingDemographic[key] / count;
        });
        return newDemographicValues
      }


      formDemographicData = function (data, demography) {
        demographies = [];
        remainingData = data;
        while (remainingData.length > 0) {
          remaining = [];
          count = 1;
          if (!isFiltered(remainingData[0])) {
            remainingData = remainingData.slice(1);
            continue;
          }
          newDemographic = formNewDemographic(remainingData[0], _ALLOWANCE_KEYS);
          newDemographic['name'] = remainingData[0][demography];
          for (i = 1; i < remainingData.length; i++) {
            currentDemographic = remainingData[i];
            if (!isFiltered(currentDemographic)) {
              continue;
            }
            if (!hasSameDemographic(newDemographic, currentDemographic, demography)) {
              remaining.push(currentDemographic);
              continue;
            }
            count++;
            additionalDemographic = formNewDemographic(currentDemographic, _ALLOWANCE_KEYS);
            additionalDemographic['name'] = currentDemographic[demography];
            newDemographic = sumDemographics(newDemographic, additionalDemographic, _ALLOWANCE_KEYS);
          }
          newDemographic = avgDemographic(newDemographic, count, _ALLOWANCE_KEYS);
          demographies.push(newDemographic);
          remainingData = remaining;
        }
        return demographies;
      }

      getCategories = function (data) {
        categories = [];
        data.forEach(demography => {
          categories.push(demography.name);
        });
        return categories;
      }

      extractSeries = function (data, keys) {
        allowances = [];
        keys.forEach(function (key) {
          newAllowance = {
            name: key,
            data: []
          };
          allowances.push(newAllowance);
        });
        data.forEach(demography => {
          allowances.forEach(function (allowance) {
            allowance.data.push(Math.round(demography[allowance.name]));
          });
        });
        return allowances;
      }

      countryData = function () {
        return formDemographicData(_DATA, 'country');
      }
      cityData = function () {
        return formDemographicData(_DATA, 'city');
      }
      gradeData = function () {
        return formDemographicData(_DATA, 'grade');
      }
      levelData = function () {
        return formDemographicData(_DATA, 'level');
      }
      functionData = function () {
        return formDemographicData(_DATA, 'function');
      }
      buData = function () {
        return formDemographicData(_DATA, 'business_level_3');
      }

      handleFilter = function (key, value) {
        if (filters[key] === undefined) {
          filters[key] = value;
        } else {
          delete filters[key];
        }
      }

      togglePopup = function (id) {
        exists = document.getElementById(id).getAttribute("style");
        if (exists.indexOf("display: block") >= 0) {
          document.getElementById(id).setAttribute("style", "display: none");
          document.getElementById("lg-popup").setAttribute("style", "display: none");
        } else {
          document.getElementById("lg-popup").setAttribute("style", "display: block");
          document.getElementById(id).setAttribute("style", "display: block");
        }
      }

      initChart = function (id, data, demography, filter, expandId) {
        Highcharts.chart(id, {
          chart: {
            type: 'column'
          },
          title: {
            text: demography
          },
          xAxis: {
            categories: getCategories(data)
          },
          yAxis: {
            min: 0,
            title: {
              text: 'Allowances'
            }
          },
          tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
          },
          plotOptions: {
            column: {
              stacking: 'percent'
            },
            series: {
              events: {
                click: function (event) {
                  filter(event.point.category);
                  initCharts(chartIds);
                }
              }
            }
          },
          exporting: {
            buttons: {
              contextButton: {
                symbol: 'download',
                menuItems: ['printChart', 'downloadPDF',]
              },
              maximizeButton: {
                symbol: 'circle',
                symbolFill: '#B5C9DF',
                _titleKey: 'printButtonTitle',
                onclick: function () {
                  togglePopup(expandId);
                }
              }
            }
          },
          series: extractSeries(data, _ALLOWANCE_KEYS),
          colors: ['#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0', '#f032e6', '#bcf60c', '#fabebe', '#008080', '#e6beff', '#9a6324', '#fffac8', '#800000', '#aaffc3', '#808000', '#ffd8b1', '#000075', '#808080', '#ffffff', '#000000']
        });
      }

      countryFilter = function (value) {
        handleFilter('country', value);
      }

      cityFilter = function (value) {
        handleFilter('city', value);
      }

      gradeFilter = function (value) {
        handleFilter('grade', value);
      }

      functionFilter = function (value) {
        handleFilter('function', value);
      }

      levelFilter = function (value) {
        handleFilter('level', value);
      }

      buFilter = function (value) {
        handleFilter('businessunit', value);
      }

      initCountryChart = function (id, expandId) {
        initChart(id, countryData(), 'country', countryFilter, expandId);
      }

      initCityChart = function (id, expandId) {
        initChart(id, cityData(), 'city', cityFilter, expandId);
      }

      initGradeChart = function (id, expandId) {
        initChart(id, gradeData(), 'grade', gradeFilter, expandId);
      }

      initFunctionChart = function (id, expandId) {
        initChart(id, functionData(), 'function', functionFilter, expandId);
      }

      initLevelChart = function (id, expandId) {
        initChart(id, levelData(), 'level', levelFilter, expandId);
      }

      initBuChart = function (id, expandId) {
        initChart(id, buData(), 'Business Unit', buFilter, expandId);
      }

      initCharts = function (ids) {
        chartIds = ids;
        initCityChart(ids.city, ids.cityExpanded);
        initCountryChart(ids.country, ids.countryExpanded);
        initGradeChart(ids.grade, ids.gradeExpanded);
        initFunctionChart(ids.function, ids.functionExpanded);
        initLevelChart(ids.level, ids.levelExpanded);
        initBuChart(ids.businessUnit, ids.businessUnitExpanded);
        initCityChart(ids.cityExpanded, ids.cityExpanded);
        initCountryChart(ids.countryExpanded, ids.countryExpanded);
        initGradeChart(ids.gradeExpanded, ids.gradeExpanded);
        initFunctionChart(ids.functionExpanded, ids.functionExpanded);
        initLevelChart(ids.levelExpanded, ids.levelExpanded);
        initBuChart(ids.businessUnitExpanded, ids.businessUnitExpanded);
        renderFilters();
      }

      initCharts({
        country: "country-container",
        city: "city-container",
        grade: "grade-container",
        level: "level-container",
        function: "function-container",
        businessUnit: "businessunit-container",
        countryExpanded: "country-container-lg",
        cityExpanded: "city-container-lg",
        gradeExpanded: "grade-container-lg",
        levelExpanded: "level-container-lg",
        functionExpanded: "function-container-lg",
        businessUnitExpanded: "businessunit-container-lg"
      });
    });
  }
  getData(url);
}

