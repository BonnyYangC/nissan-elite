<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var chartEl = <?php echo json_encode($training->chart_name);?>;
    var metricData = <?php echo $training['chart_data']; ?>;
    //console.log(metricData);
    //console.log(chartEl); // not using this var to draw chart because it will be overwrited, so only last chart will be draw, leave it here just for debugging
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $training['chart_data']; ?>);
        /*var data = google.visualization.arrayToDataTable([
            ['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General',
                'Western', 'Literature', { role: 'annotation' } ],
            ['2010', 10, 24, 20, 32, 18, 5, ''],
            ['2020', 16, 22, 23, 30, 16, 9, ''],
            ['2022', 28, 19, 29, 30, 12, 13, ''],
            ['2030', 16, 22, 23, 30, 16, 9, ''],
            ['2040', 28, 19, 29, 30, 12, 13, ''],
            ['2045', 16, 22, 23, 30, 16, 9, ''],
            ['2050', 28, 19, 29, 30, 12, 13, ''],
            ['2060', 28, 19, 29, 30, 12, 13, ''],
            ['2070', 28, 19, 29, 30, 12, 13, ''],
            ['2080', 28, 19, 29, 30, 12, 13, ''],
            ['2085', 28, 19, 29, 30, 12, 13, ''],
            ['2090', 28, 19, 29, 30, 12, 13, '']
        ]);*/
        var options = {
            chartArea: {
                // leave room for y-axis labels
                width: '89%'
            },
            curveType: 'function',
            legend: { position: 'top' },
            isStacked: true,
        };
        var chart = new google.visualization.ColumnChart(document.getElementById(<?php echo json_encode($training->chart_name);?>));
        chart.draw(data, options);
    }
</script>
