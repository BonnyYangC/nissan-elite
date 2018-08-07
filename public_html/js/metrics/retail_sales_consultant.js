
google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawVisualization2);
google.charts.setOnLoadCallback(drawVisualization3);
google.charts.setOnLoadCallback(drawVisualization4);
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
                max:5000
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
    for (var i=0;i<SALES_RECOMMENDATION.length;i++){
        dArray.push(SALES_RECOMMENDATION[i]);
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


        //title : 'DLRRECOMMENDATION',
        colors: ['#999999', '#555555' ,'#c40030' ,'#c40030'],
        //vAxis: {title: 'Metrics'},      hAxis: {title: 'Month'},
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:5000
            }
            , ticks: new Array(10).fill(500).map((n, i) => n * (i + 1))
        },
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
    for (var i=0;i<FOLLOW_UP_CREDITS.length;i++){
        dArray.push(FOLLOW_UP_CREDITS[i]);
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

        colors: ['#999999', '#555555' ,'#c40030' ,'#c40030'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:60
            }
            , ticks: new Array(6).fill(10).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'}, hAxis: {title: 'Month'},

        seriesType: 'bars',
        series: {1: {type: 'line'} , 2: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div4'));
    chart.draw(data, options);
}


function drawVisualization6() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month', 'Pathway' ,'Process' , 'Classroom' ],
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
                max: 1500
            }
            , ticks: new Array(6).fill(250).map((n, i) => n * (i + 1))
        },
        isStacked: true,
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div6'));
    chart.draw(data, options);
}


