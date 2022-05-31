<div class="col-7 metric-chart">
    <h3>{{$metricData->order. '. ' .$metricData->title}}</h3>
    <div id="{{$metricData->chart_name}}" style="height: 400px"></div>
    <table class="table metrics-table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td></td>
                @foreach (\App\Helper\Utility::MONTHS_SHORT as $month)
                <td>{{ $month }}</td>
                @endforeach
            </tr>
        </thead>
        @foreach ($metricData->table_data as $label => $data)
        <tr class="table-body" style="text-align: center">
            <td class="nissan-table-cell-grey">{{ $label }}</td>
            @foreach ($data as $index => $points)
            <td class="{{ $index%2 == 0 ? 'nissan-table-cell-light-grey' : 'nissan-table-cell-grey' }}">{{ $points }}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
    @if ($metricData->ref)
        <p><em>{!! $metricData->ref !!}</em></p>
    @endif
</div>
<div class="col-5 metric-guide">
    @foreach (data_get($metricData, 'guides', []) as $guide)
        <h3>{{ data_get($guide, 'title', '') }}</h3>
        <table class="table guide-table mt-2">
            @if (isset($guide['colspan']))
                <td colspan="4" align="center">
                    {{ data_get($guide, 'colspan') }}
                </td>
            @endif
            <tr class="nissan-table-header">
                @foreach (data_get($guide, 'top', []) as $item)
                    <td>{{ $item }}</td>
                @endforeach
            </tr>
            @foreach (data_get($guide, 'rows', []) as $row)
                <tr class="table-body">
                    @foreach ($row as $item)
                        <td>{{ $item }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        @if (isset($guide['note']))
            <em>
                {!! data_get($guide, 'note') !!}
            </em>
        @endif
        <br><br>
        @if (isset($guide['criteria']))
            <em>
                <span style="color:#c40030">{!! data_get($guide, 'criteria') !!}</span>
            </em>
        @endif
    @endforeach
</div>
@include('pages.metrics.metric_script', [$metricData])
