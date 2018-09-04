document.addEventListener("DOMContentLoaded", function(event) {
    var g1 = new JustGage({
        id: 'lifetime-gauge',
        value: YEAR_TO_DATE,
        min: MIN,
        max: MAX,
        symbol: '',
        pointer: true,
        levelColors: [LEVEL_COLOR],
        formatNumber: true,
        pointerOptions: {
            toplength: -15,
            bottomlength: 10,
            bottomwidth: 12,
            color: '#8e8e93',
            stroke: '#ffffff',
            stroke_width: 3,
            stroke_linecap: 'round'
        },
        gaugeWidthScale: 0.6,
        counter: true,
        onAnimationEnd: function() {
            // console.log('animation ended');
            // var log = document.getElementById('log');
            // log.innerHTML = log.innerHTML + 'Animation just ended.<br/>';
        }
    });
});
// History Chart
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var arrayToData = [['Year', 'Credits', { role: 'style' }, { role: 'annotation' } ]];
    for (let i = 0; i < HISTORY.length ; i++) {
        var item = [
            HISTORY[i][0],
            HISTORY[i][1],
            '#c40030',
            'Credits: ' + HISTORY[i][1]
        ];
        arrayToData.push(item);
    }

    var data = google.visualization.arrayToDataTable(arrayToData);
    var view = new google.visualization.DataView(data);

    var options = {
        legend: { position: "none" },
    };

    var chart = new google.visualization.BarChart(document.getElementById('barchart_material'));

    chart.draw(view,options);
}