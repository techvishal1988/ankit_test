
function Candidate() {
    this.hasfocusCond = false;
    this.targetEmployeeData = {};
    this.targetEmployeeGraphData = {};
    this.peerEmployeeData = {};
    this.peerEmployeeGraphData = {};
    this.targetTitle = 'Target Pay Comparision';
    this.peerTitle = 'Peer Comparision';
    this.chartColors = ['#ADD8E6','#6495ED','#4682B4','#4169E1','#191970','#87CEFA','#87CEEB','#00BFFF','#B0C4DE','#1E90FF'];
    this.chartLineColors = ['#6495ED','#4682B4','#4169E1','#191970','#87CEFA','#87CEEB','#00BFFF','#B0C4DE','#1E90FF','#ADD8E6'];
}

Candidate.prototype.showGraph = function () {

    var candidate =	this;

    if(candidate.validateForm()) {
        candidate.disabledButton();
        candidate.getAllData();
        candidate.showPeerGraph();
        candidate.showTargetGraph();
        candidate.removeDisabledButton();
    }

}


Candidate.prototype.getAllData = function () {

    var candidate =	this;
    var formData  = $("form#candidateData").serialize();

    $.ajax({
        type: "POST",
        async: false,
        url: BASE_URL + "candidate_proposal/company_users_data/",
        data: formData,
        beforeSend: function() {
            candidate.showLoader();
        },
        error: function (jqXHR, textStatus) {
            candidate.hideLoader();
        },
        success: function(result) {
            try{
                var parseResult	=	JSON.parse(result);
                if(parseResult.status == 'success'){

                    var empData = parseResult.data;
                    candidate.peerEmployeeData      = empData.peer_graph_dtls;
                    candidate.targetEmployeeData    = empData.market_salary_graph_dtls;

                }else if(parseResult.status == 'error'){
                    console.error( parseResult.data);
                }
            }catch(e){
                console.error(e);
            }
            candidate.hideLoader();
            set_csrf_field();
        }
    });

}

/* get target graph data */
Candidate.prototype.getTargetEmployeeGraphset = function() {
    var candidate =	this;
    candidate.targetEmployeeGraphData = candidate.getSplineGraphData(candidate.targetEmployeeData, candidate.targetTitle, '', '3366cc', 'Target');
}

/* get peer graph data */
Candidate.prototype.getPeerEmployeeGraphset = function() {
    var candidate =	this;
    candidate.peerEmployeeGraphData = candidate.getSplineGraphData(candidate.peerEmployeeData, candidate.peerTitle, '', '3366cc', 'Peer');
}

/* show graph */
Candidate.prototype.chartPlugin = function() {
    var candidate =	this;
	Highcharts.setOptions({ 
        lang: {
            noData: 'No data is available in the graph',
          },        
        plotOptions: {
			series: {
                colorByPoint: false,
                borderWidth: 0,
				/*dataLabels: {
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
                        return getRoundOfNumber(this.percentage) + '%'
                    }
			    }*/
            },
            spline: {
                marker: {
                    radius: 4,
                    lineColor: candidate.chartLineColors,
                    lineWidth: 1
                }
            }
        },
        colors: candidate.chartColors,
        yAxis: {

            labels: {
                style: {
                    color:"#000",
                    cursor:"default",
                    fontSize:"11px"
                }
            },
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
        tooltip: {
        },
    });
}


/* get chart data */
Candidate.prototype.getSplineGraphData = function(graphData, graphTitle = '', graphSubTitle = '', lineColor = '', graphName = '') {

    if(!graphData) {
        dataSet.xAxis.categories = [];
        dataSet.series = [];
        return dataSet;
    }

    var data = [];
    var labels = [];
    var chartData = [];
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
                text: ''
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        title: {
            text: graphTitle,
        },
        subtitle: {
            text: graphSubTitle,
        },
        series: [],
    }

    if (!$.isEmptyObject(graphData)) {

        $.each( graphData, function( key, value ) {
            labels.push(key);
            chartData.push(value);
        });
    }

    data = [{
          name: graphName,
          marker: {
             symbol: 'circle'
          },
          data: chartData,
  
      }];

    dataSet.xAxis.categories = labels;
    dataSet.series = data;
    return dataSet;
}


/* build chart */
Candidate.prototype.buildChart = function(chartData, renderId) {
    
    var candidate =	this;
    $('#'+renderId).html('');//remove previous html
    candidate.chartPlugin();
    var chartOptions = _.assign({}, {
        chart: {
            renderTo: renderId,
            type: 'spline',
            height: 300,
        },

    }, chartData);
    new Highcharts.Chart(chartOptions)
}


/* get peer graph data */
Candidate.prototype.showPeerGraph = function () {

    var candidate =	this;
    candidate.getPeerEmployeeGraphset();
    candidate.buildChart(candidate.peerEmployeeGraphData, 'peerChart');
}

/* get target graph */
Candidate.prototype.showTargetGraph = function () {

    var candidate =	this;
    candidate.getTargetEmployeeGraphset();
    candidate.buildChart(candidate.targetEmployeeGraphData, 'targetChart');
}


/* validate form */
Candidate.prototype.validateForm = function () {
  //  return true;
    var candidate   = this;
    var isValidated	= true;
    candidate.hasfocusCond  = false;

    if(!$("#candidateName").val()) {
        isValidated = false;
        $('#candidateNameErr').text('Please Enter Candidate Name');
        candidate.focusOnField('candidateName');
    } else {
        $('#candidateNameErr').text('');
    }
    
    if(!$("#country option:selected").val()) {
        isValidated = false;
        $('#countryErr').text('Please Select Country');
        candidate.focusOnField('country');
    } else {
        $('#countryErr').text('');
    }

    if(!$("#city option:selected").val()) {
        isValidated = false;
        $('#cityErr').text('Please Select City');
        candidate.focusOnField('city');
    } else {
        $('#cityErr').text('');
    }

    if(!$("#function option:selected").val()) {
        isValidated = false;
        $('#functionErr').text('Please Select function');
        candidate.focusOnField('function');
    } else {
        $('#functionErr').text('');
    }

    if(!$("#grade option:selected").val()) {
        isValidated = false;
        $('#gradeErr').text('Please Select Grade');
        candidate.focusOnField('grade');
    } else {
        $('#gradeErr').text('');
    }

    if(!$("#level option:selected").val()) {
        isValidated = false;
        $('#levelErr').text('Please Select Level');
        candidate.focusOnField('level');
    } else {
        $('#levelErr').text('');
    }
    
    if(!$("#title option:selected").val()) {
        isValidated = false;
        $('#titleErr').text('Please Select Title');
        candidate.focusOnField('title');
    } else {
        $('#titleErr').text('');
    }

    return isValidated;
}

/* focus on first error */
Candidate.prototype.focusOnField = function(fieldId=''){

	var candidate =	this;

	if(fieldId != ''){

		if(!candidate.hasfocusCond){
			$('html,body').animate({scrollTop:$('#'+fieldId).parent().offset().top - 40},"fast");
			$('#'+fieldId).focus();
			candidate.hasfocusCond = true;
		}

	}
}

/* show loader */
Candidate.prototype.showLoader = function(){
	$("#rpt_loading").show();
}

/* hide loader */
Candidate.prototype.hideLoader = function(){
    $("#rpt_loading").hide();
    $("#loading").hide();
}

/* disabled submit button */
Candidate.prototype.disabledButton = function(){
	$(".getGraphData").addClass('disabled');
}

/* remove disabled submit button */
Candidate.prototype.removeDisabledButton = function(){
	$(".getGraphData").removeClass('disabled');
}

/* save candidate Offer rule data */
Candidate.prototype.saveCandidateOfferRule = function () {

    var candidate =	this;
    var formData  = $("form#candidateOfferRule").serialize();

    $.ajax({
        type: "POST",
        async: false,
        url: BASE_URL + "candidate_proposal/save_offer_rule/",
        data: formData,
        beforeSend: function() {
            candidate.showLoader();
        },
        error: function (jqXHR, textStatus) {
            candidate.hideLoader();
        },
        success: function(result) {
            try{
                var parseResult	=	JSON.parse(result);
                var msg = '';
                var msgClass = '';

                if(parseResult.status == 'success'){
                    window.location.href = BASE_URL + 'candidate-offer-rule-setting';
                /*    msg = parseResult.msg;
                    swal({
                        title: msg,
                        //text: "You clicked the button!",
                        icon: "success",
                        button: "Ok",
                        })
                        .then((value) => {
                        window.location.href = BASE_URL + 'candidate-offer-rule-setting';
                        }) ;*/
                }else if(parseResult.status == 'error'){
                        set_csrf_field();
                  /*  msg = parseResult.msg;
                    swal({
                        title: msg,
                        // text: "You clicked the button!",
                        icon: "error",
                        button: "Ok",
                        }); */
                }

            }catch(e){
                console.error(e);
            }
            candidate.hideLoader();
        }
    });

}

Candidate.prototype.hide_list = function(obj_id)
{
    var candidate =	this;
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
                $(this).find(".fstChoiceRemove").trigger("click");
            });
            candidate.show_list(obj_id);
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}

Candidate.prototype.show_list = function(obj)
{
        var candidate =	this;
    $('#'+ obj ).siblings('.fstResults').children('.fstResultItem') .each(function(i, selected)
    {
        if($(this).html()!='All')
        {
            $(this).trigger("click");
        }
    });
}

var candidateObj	=	new Candidate();

/* Class*/

$(document).on('submit', '#candidateData', function(e) {
    e.preventDefault();
    candidateObj.showGraph();
});

$(document).on('change', '#country', function(e) {
	if($(this).val()){
		$("#countryErr").text('');
	}
});

$(document).on('change', '#city', function(e) {
	if($(this).val()){
		$("#cityErr").text('');
	}
});

$(document).on('change', '#function', function(e) {
	if($(this).val()){
		$("#functionErr").text('');
	}
});

$(document).on('change', '#grade', function(e) {
	if($(this).val()){
		$("#gradeErr").text('');
	}
});

$(document).on('change', '#level', function(e) {
	if($(this).val()){
		$("#levelErr").text('');
	}
});

$(document).on('change', '#title', function(e) {
	if($(this).val()){
		$("#titleErr").text('');
	}
});

/* save rule data */
$(document).on('submit', '#candidateOfferRule', function(e) {
    e.preventDefault();
    candidateObj.saveCandidateOfferRule();
});
/* end save rule data*/

$(document).on('change', '#offer_applied_on_elements', function(e) {
    e.preventDefault();
    candidateObj.hide_list('offer_applied_on_elements');
});

$(document).ready(function()
{
    $( "#txt_cutoff_dt, #txt_effective_dt" ).datepicker({ 
        dateFormat: 'dd/mm/yy',
        changeMonth : true,
        changeYear : true,
    });

    if( typeof useFastselect !== 'undefined' && useFastselect == true) {
        $('.multipleSelect').fastselect();
    }

});
