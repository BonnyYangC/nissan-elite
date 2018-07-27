google.charts.load('current', {'packages':['corechart']});

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


function drawVisualization2() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month',  'Credits']
    ];
    for (var i=0;i<NFSA.length;i++){
        dArray.push(NFSA[i]);
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
                max: 2000
            }
            , ticks: new Array(8).fill(250).map((n, i) => n * (i + 1))
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
        ['Month', 'MVI', 'VPI', 'Package']
    ];
    for (var i=0;i<INSURANCE.length;i++){
        dArray.push(INSURANCE[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:73,top:40,bottom:40,width:'79%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },
        legend: 'top',


        //title : 'DLRRECOMMENDATION',
        colors: ['#999999', '#555555' ,'#c40030' ,'#c40030'],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 800
            }
            , ticks: new Array(8).fill(100).map((n, i) => n * (i + 1))
        },
        //vAxis: {title: 'Metrics'},      hAxis: {title: 'Month'},

        seriesType: 'bars'

    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
    chart.draw(data, options);
}

function drawVisualization4() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month',  'Genuine', 'Extended']
    ];
    for (var i=0;i<EMW.length;i++){
        dArray.push(EMW[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:80,top:40,bottom:40,width:'78%',height:'75%'},
        legend: 'top',
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },
        legend: 'top',
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 2000
            }
            , ticks: new Array(8).fill(250).map((n, i) => n * (i + 1))
        },

        //title : 'NEW VEHICLE SALES',

        colors: ['#555555'],

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
        ['Month', 'Credits']
    ];
    for (var i=0;i<PENETRATION.length;i++){
        dArray.push(PENETRATION[i]);
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
        colors: ['#c40030', '#555555' ,'#999999' ],
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max: 1000
            }
            , ticks: new Array(4).fill(250).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div5'));
    chart.draw(data, options);
}



function drawVisualization6() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month', 'Credits']
    ];
    for (var i=0;i<followUp.length;i++){
        dArray.push(followUp[i]);
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
            , ticks: new Array(5).fill(100).map((n, i) => n * (i + 1))
        },
        // vAxis: {title: 'Metrics'}, hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div6'));
    chart.draw(data, options);
}