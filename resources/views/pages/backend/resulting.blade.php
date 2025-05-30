@extends('layouts.backend')
@section('content')
<div class="px-5">
    <a href="{{ route('admin.dashboard') }}">Go Back</a>
    <a href="{{ route('admin.dashboard') }}" target="_blank">Go Back (new tab)</a>
    <hr>

    <div class="col-12 backend-home">
        <div class="card">
            <div class="card-body">

                @foreach($result as $item => $data)
                    @if(!in_array($item, ['type','header']) && $data)
                        <div>
                            <h3>{{ $data['count'] }}</h3>
                        </div>
                        <div style="overflow: scroll">
                            <table class="table table-bordered mt-2" style="float-x: scroll">
                                <thead>
                                    @if(isset($data['header']))
                                    <tr>
                                        @foreach($data['header'] as $value)
                                            <td>{!! $value !!}</td>
                                        @endforeach
                                    </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @if(isset($data['data']))
                                    @foreach($data['data'] as $index => $row)
                                        <tr>
                                            @foreach($row as $key => $value)
                                                <td>{!! $value !!}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
