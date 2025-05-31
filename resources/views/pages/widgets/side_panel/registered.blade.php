<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>Are you registered?</td>
            </tr>
        </thead>
        <tbody class="nissan-table-body-grey">
            <tr align="center">
                <td>
                    @if ($currentUser->eligible && $currentUser->eligible->registered)
                        <span class="fs-30 span-red" title="You are eligible for the {{ config('elite.PROGRAM_SHORT_NAME') }}{{ config('app.theme') }} Program">&#10004</span>
                        <p class="m-2 txt-white">250 {{ config('elite.PROGRAM_AWARD_UNIT') }} applied to Monthly points</p>
                    @else
                        <span class="fs-30 span-red">X</span>
                        <a href="{{ theme_config('eventRegisterUrl') }}" target="_blank">
                            <button type="button" class="btn nissan-button">Register Now</button>
                        </a>
                    @endif

                </td>
            </tr>
        </tbody>
    </table>
</div>
