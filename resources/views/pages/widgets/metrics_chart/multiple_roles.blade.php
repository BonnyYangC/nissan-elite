<div style="padding: 10px 0;">
    <strong>You have had multiple roles: </strong>
    <select id="metricsRoleSelect" title="Roles">
        @foreach ( $currentUser->positions() as $code => $title)
        <option value="{{ $code }}" {{ $selectedPosition->get('code') == $code ? 'selected' : null }}>{{ $title }}</option>
        @endforeach
    </select>
</div>
<script>
    let metricsRoleSelect = document.getElementById('metricsRoleSelect');
    if (metricsRoleSelect) {
        metricsRoleSelect.addEventListener('change', function (e) {
            window.location.href = '/dashboard?asPosition=' + e.target.value;
        });
    }
</script>
@include('pages.widgets.metrics_chart.single_role', [$currentUser, $stackedMetrics])
