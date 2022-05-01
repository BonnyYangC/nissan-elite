@extends('layouts.backend')
@section('content')

    <a href="{{ route('admin.dashboard') }}">Go Back</a>
    <a href="{{ route('admin.dashboard') }}" target="_blank">Go Back (new tab)</a>
    <hr>

    <div class="col-12 backend-home">
        @if($result['type'] == App\Helper\Defination::ACTION_TYPE_SYNC)
            <div class="card">
                <div class="card-body">
                    <p>Synced: {{ $result['update'] }}</p>
                    <p>Failed: {{ $result['wrong'] }}</p>
                    <p>Ignored: {{ $result['ignore'] }}</p>
                </div>
            </div>
        @else
            @foreach($result as $item => $data)
                @if($item != 'type' && $data)
                    <div>
                        <h4>{{ $data['count'] }}</h4>
                    </div>
                    <table class="table table-bordered table-responsive display-table">
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
                @endif
            @endforeach
        @endif
    </div>
@endsection
