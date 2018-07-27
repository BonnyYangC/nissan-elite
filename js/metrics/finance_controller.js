    google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawVisualization);
google.charts.setOnLoadCallback(drawVisualization3);
google.charts.setOnLoadCallback(drawVisualization4);
google.charts.setOnLoadCallback(drawVisualization5);
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
        ['Month', 'Frequency', 'Ontime'],
    ];
    for (var i=0;i<FINANCIAL.length;i++){
        dArray.push(FINANCIAL[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:98,top:40,bottom:40,width:'75%',height:'75%'},
        legend: 'top',

        //title : 'MATCHED OW',
        //vAxis: {title: 'Metrics'},

        // Move Legend to top
        legend: 'top',


        // Scale V Axis to maximum height
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:375
            }
            , ticks: new Array(3).fill(125).map((n, i) => n * (i + 1))
        },

        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },
        colors: ['#c40030' ],

        seriesType: 'bars'
        //,series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);


}






function drawVisualization3() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month', 'Balance', 'Submission']
    ];
    for (var i=0;i<QUALITY.length;i++){
        dArray.push(QUALITY[i]);
    }
    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:100,top:40,bottom:40,width:'75%',height:'75%'},
        // Move Legend to top
        legend: 'top',
        // Scale V Axis to maximum height
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:550
            }
            , ticks: new Array(10).fill(55).map((n, i) => n * (i + 1))
        },
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
        },


        //title : 'DLRRECOMMENDATION',
        colors: ['#999999', '#555555' ,'#c40030' ,'#c40030'],
        //vAxis: {title: 'Metrics'},      hAxis: {title: 'Month'},

        seriesType: 'bars',
        //series: {1: {type: 'line'} , 2: {type: 'line'}}

    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
    chart.draw(data, options);
}

function drawVisualization4() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month',  'Checklist', 'Meeting']
    ];
    for (var i=0;i<MANAGEMENT.length;i++){
        dArray.push(MANAGEMENT[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:90,top:40,bottom:40,width:'76%',height:'75%'},
        // Move Legend to top
        legend: 'top',
        // Scale V Axis to maximum height
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:600
            }
            , ticks: new Array(6).fill(100).map((n, i) => n * (i + 1))
        },
        animation: {
            duration: 1600,
            easing: 'out',
            startup: true
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
        ['Month', 'Online' , 'Classroom' ]
    ];
    for (var i=0;i<TRAINING.length;i++){
        dArray.push(TRAINING[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:40,top:40,bottom:40,width:'75%',height:'75%'},
        legend: 'top',
        // Scale V Axis to maximum height
        vAxis: {
            viewWindowMode: 'explicit',
            viewWindow: {
                max:450
            }
            , ticks: new Array(9).fill(50).map((n, i) => n * (i + 1))
        },
        animation: {
            duration: 2000,
            easing: 'out',
            startup:  true
        },
        //title : 'NEW VEHICLE SALES',
        colors: ['#111111', '#333333' ,'#555555','#999999' ,'#999999' , 'd2d2d2'],
        isStacked: true,
        // vAxis: {title: 'Metrics'},hAxis: {title: 'Month'},

        seriesType: 'bars'
        //series: {5: {type: 'line'}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div5'));
    chart.draw(data, options);
}
