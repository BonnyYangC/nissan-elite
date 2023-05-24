<h3>Dollar Rewards and {{ config('elite.PROGRAM_AWARD_UNIT') }} <span class="no-transform">(achieve your criteria to be rewarded)</span></h3>
<div class="mt-2" >
    <table class="table dollar-rewards-table" >
        <thead class="nissan-table-header">
            <tr>
                <td align="center">COMMENDATION</td>
                <td align="center">BRONZE</td>
                <td align="center">SILVER</td>
                <td align="center">GOLD</td>
            </tr>
        </thead>
        <tr>
            <td align="center">{{ $rewards->commendation_reward }}</td>
            <td align="center">${{ $rewards->bronze_reward }}</td>
            <td align="center">${{ $rewards->silver_reward }}</td>
            <td align="center">${{ $rewards->gold_reward }}</td>
        </tr>
        <tr class="matched">
            <td align="center">{{ $rewards->commendation }}</td>
            <td align="center">{{ $rewards->bronze }}</td>
            <td align="center">{{ $rewards->silver }}</td>
            <td align="center">{{ $rewards->gold }}</td>
        </tr>
    </table>
</div>

<p style="color: #c40030;">
    <strong>Status Awards are distributed to registered members on achieving each Level throughout the program year.<br/>
    ELITE EFTPOS Rewards are distributed to registered members who have successfully completed their required criteria at 31 March.</strong>
</p>

