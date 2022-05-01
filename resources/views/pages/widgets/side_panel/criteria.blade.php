<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>Have you met criteria?</td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    @if ($currentUser->met_criteria)
                        <span class="fs-30 span-red">&#10004</span>
                    @else
                        <a href="/dashboard/MembersGuide" target="_blank">
                            <button style="background-color:#4169E1; color: #FFFFFF; width:100%; margin:0 auto; font-weight: lighter; font-size:11px;" type="button" class="btn btn-primary btn-block">
                                Compulsory at 31 March {{ config('elite.YEAR')+1 }}
                                <br>Refer Member Guide
                            </button>
                        </a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
