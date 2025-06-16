<div>
    <table class="table">
        <thead class="nissan-table-header">
            <tr align="center">
                <td>
                    @if(!$mock)
                    <a href="{{ $menuName == \App\Helper\Defination::PAGE_DASHBOARD ? route('loyalty') : route('dashboard') }}">
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
                        <a href="{{ $menuName == \App\Helper\Defination::PAGE_DASHBOARD ? route('loyalty') : route('dashboard') }}">
                            <button style="font-size:20px;" type="button" class="btn nissan-button">
                                {{ number_format(floatval($historical['total']), 0) }}
                            </button>
                        </a>
                    @else
                        <button style="font-size:20px;" type="button" class="btn nissan-button">
                            {{ number_format(floatval($historical['total']), 0) }}
                        </button>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
