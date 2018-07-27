    google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawVisualization);
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
        ['Month', 'Credits']
    ];
    for (var i=0;i<GRP.length;i++){
        dArray.push(GRP[i]);
    }

    var data = google.visualization.arrayToDataTable(dArray);

    var options = {
        chartArea:{left:65,top:40,bottom:40,width:'80.5%',height:'75%'},
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
                max: 2300
            }
            , ticks: new Array(10).fill(230).map((n, i) => n * (i + 1))
        },

        seriesType: 'bars'
        //,series: {5: {type: 'line'}}
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);


}



function drawVisualization6() {
    // Some raw data (not necessarily accurate)
    var dArray = [
        ['Month', 'Classroom']
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
                max: 1000
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