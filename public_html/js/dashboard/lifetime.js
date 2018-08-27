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
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var arrayToData = [['Year', 'Credits']];
    for (let i = 0; i < HISTORY.length ; i++) {
        arrayToData.push(HISTORY[i]);
    }
    var data = google.visualization.arrayToDataTable(arrayToData);

    var options = {
        colors: ['#c40030','#999999'],
        chart: {
            title: '',
            subtitle: '',
        },
        bars: 'horizontal' // Required for Material Bar Charts.
    };

    var chart = new google.charts.Bar(document.getElementById('barchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}