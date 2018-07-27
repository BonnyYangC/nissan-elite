google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawVisualization);
google.charts.setOnLoadCallback(drawVisualization2);
google.charts.setOnLoadCallback(drawVisualization3);
google.charts.setOnLoadCallback(drawVisualization4);
google.charts.setOnLoadCallback(drawVisualization5);
google.charts.setOnLoadCallback(drawVisualization6);


setTimeout(function () { adjustLegendMargin(); }, 4000);

/* Moves the legend up slightly for each chart */
function adjustLegendMargin () {
    const charts = document.querySelectorAll('svg');

    for (let i = 0; i < charts.length; i++) {
        let children = charts[i].querySelector('g').querySelectorAll('*');

        for (let j = 0; j < children.length; j++) {
            children[j].setAttribute('y', children[j].getAttribute('y') - 10);
        }
    }
}

function drawVisualization() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<MATCHED_OW.length;i++){
        dArray.push(MATCHED_OW[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80%',height:'75%'},
        legend: 'top',

        //title : 'MATCHED OW',
        //vAxis: {title: 'Metrics'},
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },
        colors: ['#c40030' ],

        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 310
            }
            , ticks: new Array(5).fill(62).map((n, i) => n * (i + 1))
        },

        seriesType: 'bars'
        //,series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);


}



function drawVisualization2() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<NEW_VEHICLE_SALES.length;i++){
        dArray.push(NEW_VEHICLE_SALES[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80%',height:'75%'},
        legend: 'top',

        //title : 'MATCHED OW',
        //vAxis: {title: 'Metrics'},
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },
        colors: ['#999999' ],

        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 5000
            }
            , ticks: new Array(10).fill(500).map((n, i) => n * (i + 1))
        },
        //hAxis: {title: 'Month'},
        seriesType: 'bars'
        //,series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
    chart.draw(data, options);


}



function drawVisualization3() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<RECOMMENDATIONS.length;i++){
        dArray.push(RECOMMENDATIONS[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },


        //title : 'DLRRECOMMENDATION',
        colors: ['#999999', '#555555' ,'#c40030' ,'#c40030'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 1000
            }
            , ticks: new Array(5).fill(200).map((n, i) => n * (i + 1))
        },
        //vAxis: {title: 'Metrics'},      hAxis: {title: 'Month'},

        seriesType: 'bars',
        series: {1: {type: 'line'} , 2: {type: 'line'}}

    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
    chart.draw(data, options);
}

function drawVisualization4() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<FOLLOW_UP.length;i++){
        dArray.push(FOLLOW_UP[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },

        //title : 'NEW VEHICLE SALES',

        colors: ['#555555'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 500
            }
            , ticks: new Array(4).fill(125).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'}, hAxis: {title: 'Month'},

        seriesType: 'bars',
        series: {1: {type: 'line'} , 2: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div4'));
    chart.draw(data, options);
}

function drawVisualization5() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<MIDMTH_RETAIL.length;i++){
        dArray.push(MIDMTH_RETAIL[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80.5%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },
        //title : 'NEW VEHICLE SALES',
        colors: ['#c40030', '#555555' ,'#999999' ],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 250
            }
            , ticks: new Array(5).fill(50).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars',
        series: {1: {type: 'line'} , 2: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div5'));
    chart.draw(data, options);
}


function drawVisualization6() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month',  'Process', 'Pathway', 'Classroom'  ]
    ];
    for (var i=0;i<TRAINING.length;i++){
        dArray.push(TRAINING[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'75%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 2000,
            easing: 'out',
            startup:  true
        },
        legend: 'top',
        //title : 'NEW VEHICLE SALES',
        colors: ['#111111', '#333333' ,'#555555','#999999' ,'#999999' , 'd2d2d2'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 3000
            }
            , ticks: new Array(6).fill(500).map((n, i) => n * (i + 1))
        },
        isStacked: true,
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div6'));
    chart.draw(data, options);
}
