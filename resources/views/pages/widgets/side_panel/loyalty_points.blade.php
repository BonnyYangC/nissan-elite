<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>
                    <!--<span>Loyalty {{ config('elite.PROGRAM_AWARD_UNIT') }}</span>-->
                    <a href="#">
                        Loyalty {{ config('elite.PROGRAM_AWARD_UNIT') }}
                    </a>
                </td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    <!--<span class="fs-30">{{ number_format(floatval($historical['total']) + floatval($ytd), 0) }}</span>-->
                    <a href="#">
                        <button style="background-color:#4169E1; color: #FFFFFF; width:100%; margin:0 auto; font-weight: lighter; font-size:20px;" type="button" class="btn btn-primary btn-block">
                            {{ number_format(floatval($historical['total']) + floatval($ytd), 0) }}
                        </button>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
