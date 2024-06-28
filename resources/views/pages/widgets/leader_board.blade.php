<h3>LEADER BOARD</h3>
@if($currentUser->position->platinum_ranking)
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="btn-leader-board nav-link active" id="pills-status-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">STATUS</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn-leader-board nav-link" id="pills-platinum-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">PLATINUM</button>
        </li>
    </ul>
@endif

<div class="tab-content mt-2" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-status-tab">
        <table class="table leader-board-table">
            <thead class="nissan-table-header">
                <tr>
                    <td></td>
                    <td>{{ config('elite.PROGRAM_I_ELITE') }}</td>
                    <td>Dealership</td>
                    <td>State</td>
                </tr>
            </thead>
            <tbody>
            @foreach($rankings as $index => $result)
                <tr>
                    <td>{{ $result->rank }}</td>
                    <td>
                        @if($result->employee_code === $currentUser->employee_code)
                        <a href="{{ route('ranking') }}" class="matched">
                            {{ $result->firstname }} {{ $result->lastname }}
                        </a>
                        @else
                        {{ $result->firstname }} {{ $result->lastname }}
                        @endif
                    </td>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->dealer_state }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($currentUser->position->platinum_ranking)
    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-platinum-tab">
        <table class="table leader-board-table">
            <thead class="nissan-table-header">
            <tr>
                <td></td>
                <td>{{ config('elite.PROGRAM_I_ELITE') }}</td>
                <td>Dealership</td>
                <td>State</td>
            </tr>
            </thead>
            <tbody>
            @foreach($rankingsPlatinum as $index => $result)
                <tr>
                    <td>{{ $result->rank }}</td>
                    <td>
                        @if($result->employee_code === $currentUser->employee_code)
                            <a href="{{ url('/dashboard/Leaderboards') }}" class="matched">
                                {{ $result->firstname }} {{ $result->lastname }}
                            </a>
                        @else
                            {{ $result->firstname }} {{ $result->lastname }}
                        @endif
                    </td>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->dealer_state }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
