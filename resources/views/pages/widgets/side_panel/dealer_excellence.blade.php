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
                    @if ($currentUser->eligible && $currentUser->eligible->excellence_eligible)
                        <span class="fs-30 span-red">&#10004</span>
                        <p class="m-2 txt-white">1000 {{ config('elite.PROGRAM_AWARD_UNIT') }} applied to Monthly points</p>
                    @else
                        <span class="fs-30 span-red">X</span>
                    @endif
                    <p class="txt-white">
                        <a target="_blank" href="{{ route('jump_to_dealer') }}">
                            <button type="button" class="btn nissan-button">
                                View {{ theme_config('FY_WITH_YEAR') }} Rankings
                            </button>
                        </a>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
