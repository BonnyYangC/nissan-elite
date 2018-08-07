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
    for (var i=0;i<STOCK_COVER.length;i++){
        dArray.push(STOCK_COVER[i]);
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
                max:300
            }
            , ticks: new Array(5).fill(60).map((n, i) => n * (i + 1))
        },
        //hAxis: {title: 'Month'},
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
    for (var i=0;i<OW.length;i++){
        dArray.push(OW[i]);
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
                max:275
            }
            , ticks: new Array(5).fill(55).map((n, i) => n * (i + 1))
        },

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
    for (var i=0;i<RETAIL.length;i++){
        dArray.push(RETAIL[i]);
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
        colors: ['#999999' ],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:250
            }
            , ticks: new Array(5).fill(50).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
    chart.draw(data, options);
}



function drawVisualization4() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<MATCHED.length;i++){
        dArray.push(MATCHED[i]);
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

        colors: ['#c40030'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:310
            }
            , ticks: new Array(5).fill(62).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'}, hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div4'));
    chart.draw(data, options);
}




function drawVisualization5() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<DAVO.length;i++){
        dArray.push(DAVO[i]);
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
                max:550
            }
            , ticks: new Array(10).fill(55).map((n, i) => n * (i + 1))
        },
        //vAxis: {title: 'Metrics'},      hAxis: {title: 'Month'},

        seriesType: 'bars',
        series: {1: {type: 'line'} , 2: {type: 'line'}}

    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div5'));
    chart.draw(data, options);
}




function drawVisualization6() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month','Credits' ]
    ];
    for (var i=0;i<TRAINING.length;i++){
        dArray.push(TRAINING[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:40,top:40,bottom:40,width:'75%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 2000,
            easing: 'out',
            startup:  true
        },
        //title : 'NEW VEHICLE SALES',
        colors: ['#111111', '#333333' ,'#555555','#999999' ,'#999999' , 'd2d2d2'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:1000
            }
            , ticks: new Array(5).fill(200).map((n, i) => n * (i + 1))
        },
        isStacked: true,
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div6'));
    chart.draw(data, options);
}