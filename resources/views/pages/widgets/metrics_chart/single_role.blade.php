<div id="metrics-chart" style="height: 500px"></div>
<p class="fs-12 mt-3">Registration and Dealer Excellence points are shown in above graph on month achieved. (Register Now if not showing in a past month)</p>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var monthlyMetricsData = <?php echo $metrics; ?>;
    //console.log(monthlyMetricsData);
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(monthlyMetricsData);
        /* var data = google.visualization.arrayToDataTable([
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
                width: '92%'
            },
            legend: { position: 'top', maxLines: 3 },
            isStacked: true,
            // This line makes the entire category's tooltip active.
            focusTarget: 'category',
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('metrics-chart'));
        chart.draw(data, options);
    }
</script>
