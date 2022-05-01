<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>{{ config('elite.PROGRAM_DEALERSHIP') }}</td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    @if ($currentUser->excellence_eligible)
                        <span class="fs-30 span-red">&#10004</span>
                        <p class="m-2 txt-white">2000 {{ config('elite.PROGRAM_AWARD_UNIT') }} applied to Monthly points</p>
                    @else
                        <span class="fs-30 span-red">X</span>
                    @endif
                    <p class="txt-white">
                        <a href="#" onclick="window.open('{{ env('dealExcellenceOverviewUrl') }}')">
                            <button style="background-color:#4169E1; width:100%; margin:0 auto; font-size:11px;"
                                    type="button" class="btn btn-primary btn-block">
                                View {{ env('FY_WITH_YEAR') }} Rankings
                            </button>
                        </a>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
