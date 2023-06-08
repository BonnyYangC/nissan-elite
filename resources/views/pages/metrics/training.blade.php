<div class="col-7 metric-chart">
    <h3>{{$training->order. '. ' .$training->title}}</h3>
    <div id="{{$training->chart_name}}" style="height: 400px"></div>
    @if ($training->ref)
        <p><em>{!! $training->ref !!}</em></p>
    @endif
</div>
<div class="col-5 metric-guide">
    @foreach (data_get($training, 'guides', []) as $guide)
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
                <tr class="align-center table-body">
                    @foreach ($row as $item)
                        <td class="text-nowrap">{{ $item }}</td>
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
@include('pages.metrics.training_script', [$training])
