<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>
                    @if(!$mock)
                    <a href="{{ route('loyalty') }}">
                        Loyalty {{ config('elite.PROGRAM_AWARD_UNIT') }}
                    </a>
                    @else
                        Loyalty {{ config('elite.PROGRAM_AWARD_UNIT') }}
                    @endif
                </td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    @if(!$mock)
                    <a href="{{ route('loyalty') }}">
                        <button style="background-color:#4169E1; color: #FFFFFF; width:100%; margin:0 auto; font-weight: lighter; font-size:20px;" type="button" class="btn btn-primary btn-block">
                            {{ number_format(floatval($historical['total']) + floatval($ytd), 0) }}
                        </button>
                    </a>
                    @else
                        <button style="background-color:#4169E1; color: #FFFFFF; width:100%; margin:0 auto; font-weight: lighter; font-size:20px;" type="button" class="btn btn-primary btn-block">
                            {{ number_format(floatval($historical['total']) + floatval($ytd), 0) }}
                        </button>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
