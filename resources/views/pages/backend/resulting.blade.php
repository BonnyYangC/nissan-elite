@extends('layouts.backend')
@section('content')
<div class="px-5">
    <a href="{{ route('admin.dashboard') }}">Go Back</a>
    <a href="{{ route('admin.dashboard') }}" target="_blank">Go Back (new tab)</a>
    <hr>

    <div class="col-12 backend-home">
        <div class="card">
            <div class="card-body">
            @if($result['type'] == App\Helper\Defination::ACTION_TYPE_SYNC)
                <p>Synced: {{ $result['update'] }}</p>
                <p>Failed: {{ $result['wrong'] }}</p>
                <p>Ignored: {{ $result['ignore'] }}</p>
            @else
                @foreach($result as $item => $data)
                    @if($item != 'type' && $data)
                        <div>
                            <h3>{{ $data['count'] }}</h3>
                        </div>
                        <div style="overflow: scroll">
                            <table class="table table-bordered mt-2" style="float-x: scroll">
                                <thead>
                                    <tr>
                                        @foreach($data['header'] as $value)
                                            <td>{!! $value !!}</td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['data'] as $index => $row)
                                        <tr>
                                            @foreach($row as $key => $value)
                                                <td>{!! $value !!}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
