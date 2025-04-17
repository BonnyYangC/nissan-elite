<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>{{ config('theme.'.config('app.theme') . '.FY_LAST_YEAR') . ' ' . config('elite.PROGRAM_I_ELITE') }}</td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    <form target="_blank" action="{{ config('theme.'.config('app.theme') . '.LAST_YEAR_EVENT_URL') }}/../api/view-last-year" method="get">
                        @csrf
                        <input type="hidden" name="code" value="{{ $currentUser->employee_code }}" />

                        <input type="hidden" name="mock" value="true" />

                        <button style="background-color:#4169E1; color: #FFFFFF; width:100%; margin:0 auto; font-weight: lighter; font-size:11px;" type="submit" class="btn btn-primary btn-block">
                            View Previous Year
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
