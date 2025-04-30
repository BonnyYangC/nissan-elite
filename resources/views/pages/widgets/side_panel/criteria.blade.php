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
                    @if ($currentUser->eligible && $currentUser->eligible->met_criteria)
                        <span class="fs-30 span-red">&#10004</span>
                    @else
                        <a href="{{ route('member_guide') }}" target="_blank">
                            <button type="button" class="btn nissan-button">
                                Compulsory at 31 March {{ config('app.theme') + 1 }}
                                <br>Refer Member Guide
                            </button>
                        </a>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
