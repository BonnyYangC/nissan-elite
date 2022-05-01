<!--<div id="metric-chart" style="width: 95%; height: 250px"></div>-->
<div class="col-7 metric-chart">
    <h3>{{$metricData['title']}}</h3>
    <div id="chart_{{ $metricData['identifier'] }}" style="height: 400px"></div>
    <table class="table metrics-table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td></td>
                @foreach (\App\Helper\Utility::MONTHS_SHORT as $month)
                <td>{{ $month }}</td>
                @endforeach
            </tr>
        </thead>
        @foreach ($metricData['table_data'] as $label => $data)
        <tr class="custom-width">
            <td class="nissan-table-cell-grey">{{ $label }}</td>
            @foreach ($data as $index => $points)
            <td class="{{ $index%2 == 0 ? 'nissan-table-cell-light-grey' : 'nissan-table-cell-grey' }}">{{ $points }}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
    @if ($metricData['ref'])
        <p><em>{{ $metricData['ref'] }}</em></p>
    @endif
</div>
<div class="col-5 metric-guide">
    @foreach ($metricData['guides'] as $guide)
    <h3>{{ $guide['title']}}</h3>
    <table class="table guide-table mt-2">
        @if (isset($guide['colspan']))
        <td colspan="4" align="center">
            {{ $guide['colspan'] }}
        </td>
        @endif
        <tr class="nissan-table-header">
            @foreach ($guide['top'] as $item)
            <td>{{ $item }}</td>
            @endforeach
        </tr>
        @foreach ($guide['rows'] as $row)
        <tr class="align-center table-body">
            @foreach ($row as $item)
                <td>{{ $item }}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
    @if (isset($guide['note']))
    <em>
        {{ $guide['note']}}
    </em>
    @endif
    <br><br>
    @if (isset($guide['criteria']))
    <em>
        <span style="color:#c40030">{{ $guide['criteria'] }}</span>
    </em>
    @endif
    @endforeach
</div>



<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var chart = <?php echo "chart_".$metricData['identifier']?>
    var metricData = <?php echo $metricData['chart_data']; ?>;
    console.log(metricData);
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable(metricData);
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
                width: '92%'
            },
            colors: ['#c40030'],
            curveType: 'function',
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById('metric-chart'));
        chart.draw(data, options);
    }
</script>
