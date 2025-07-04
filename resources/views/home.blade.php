@extends('layouts.app', ['header' => false, 'footer' => false])

@section('content')

    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        @foreach ($rowTiles as $row)
        <div class="container">
            <div class="row justify-content-center">
                @foreach($row as $tile)
                    <div class="col-lg-2 col-md-3 col-6 mb-3">
                        @php
                        $href = '#';
                        if (!empty($tile['route_name'])) {
                            $href = route($tile['route_name'], $tile['params'] ?? []);
                        } elseif (!empty($tile['url'])) {
                            $href = url($tile['url']);
                        }

                        $target = !empty($tile['target_blank']) ? ' target="_blank" rel="noopener noreferrer"' : '';
                        @endphp
                        <a href="{{ $href }}" {!! $target !!}>
                            <img src="{{ theme_image($tile['image']) }}" class="img-fluid" alt="{{ $tile['alt'] ?? 'Tile' }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
@endsection
