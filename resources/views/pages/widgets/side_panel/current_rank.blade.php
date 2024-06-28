<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td colspan="2">Your Current State Ranking{{ $currentUser->position->platinum_ranking ? 's' : ''}}</td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
        <tr align="center">
            <td>
                <span class="fs-30">{{ $rankingStatus && $rankingStatus->rank ? \App\Helper\Utility::ordinal($rankingStatus->rank) : 'N/A' }}</span><br>
                <p>STATUS</p>
            </td>
            @if($currentUser->position->platinum_ranking)
                <td>
                    <span class="fs-30">{{ $rankingStatus && $rankingStatus->rank_platinum ? \App\Helper\Utility::ordinal($rankingStatus->rank_platinum) : 'N/A' }}</span><br>
                    <p>PLATINUM</p>
                </td>
            @endif
        </tr>
        </tbody>
    </table>
</div>
