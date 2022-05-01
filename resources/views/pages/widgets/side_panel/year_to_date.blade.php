<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>YTD {{ config('elite.PROGRAM_AWARD_UNIT') }}</td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    <span class="fs-30">{{ number_format(floatval($ytd),0) }}</span><br>
                </td>
            </tr>
        </tbody>
    </table>
</div>
