
<h3>Monthly {{ config('elite.PROGRAM_AWARD_UNIT') }}</h3>
<div id="monthly-points-chart" style="width: 95%; height: 250px"></div>
<p align="center" class="fs-12">Registration, Dealer Excellence and Incentive {{ config('elite.PROGRAM_AWARD_UNIT') }} are included in the above graph.</p>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var monthlyData = <?php echo $monthlyPoints; ?>;
    console.log(monthlyData);
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(monthlyData);
        var options = {
            colors: ['#c40030'],
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('monthly-points-chart'));
        chart.draw(data, options);
    }
</script>
