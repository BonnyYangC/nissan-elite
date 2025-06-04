<div>
  <h3>Current Loyalty Level</h3>
  <div class="mt-2">
    <img src="{{ asset('loyalty_status.png') }}" width="100%" />
  </div>
  <div class="historical-data">
    @foreach ($historical['all'] as $key => $value)
    <h3>{{ $key }} : {{ $value }} </h3>
  @endforeach
  </div>
</div>