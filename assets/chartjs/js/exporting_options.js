function exportOptions() {

    var fontFamily = 'Arial';

    return exporting = {
        allowHTML: true,    
        width:600,
        chartOptions: {
            title: {
                style: {
                    fontSize: '18px',
                    fontFamily: fontFamily,
                    color: '#000',
                    fontWeight: 'normal',
                    textOutline: false ,
                    textShadow: false
                }
            },
            legend: {
                itemStyle: {fontFamily: fontFamily,fontWeight: 'normal', fontSize:'10px'},
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
              },
            chart: {
                events: {
                    load: function () {
                        Highcharts.each(this.series, function (series) {
                            series.update({
                                dataLabels: {
                                    enabled: true,				                                                 
                                    style: {
                                        fontFamily: fontFamily,
                                        fontSize: '12px',
                                        fontWeight: 'normal',
                                    }  
                                },
                            }, false);
                        });
                        this.redraw(false);
                    }
                }
            },                    
        }
    }

}