<?php

function nissan_get_role_from_table_name ($table) {
    $dict = array (
		'nissan_salesconsultants' => 'Sales Consultant',
		'nissan_salesmanagers' => 'Sales Manager',
		'nissan_serviceadvisors' => 'Service Advisor',
		'nissan_fi' => 'Finance & Insurance Manager',
		'nissan_stockcontroller' => 'Stock Controller',
		'nissan_financialcontrollers' => 'Financial Controller',
		'nissan_partsmanager' => 'Parts Manager',
		'nissan_partsrep' => 'Parts & Sales Representitive',
		'nissan_servicemanagers' => 'Service Manager'
    );
    
    return $dict[$table];
}

function nissan_get_abbr_from_table_name ($table) {
	$dict = array (
		'nissan_salesconsultants' => 'R',
		'nissan_salesmanagers' => 'M',
		'nissan_serviceadvisors' => 'SA',
		'nissan_fi' => 'I',
		'nissan_stockcontroller' => 'SC',
		'nissan_financialcontrollers' => 'C',
		'nissan_partsmanager' => 'PM',
		'nissan_partsrep' => 'PS',
		'nissan_servicemanagers' => 'SM'
	);

	return $dict[$table];
}

function nissan_get_metrics_nav_html ($user) {
	$had_multiple_roles = count($user['multiple_role_metrics']) > 1;
	$roles = array_keys($user['multiple_role_metrics']);
	
	if ($had_multiple_roles) {
		$html = '
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				Metrics <span class="caret"></span></a>
				<ul class="dropdown-menu">
		';

		foreach ($roles as $role) {
			$html .= '<li><a href="/Dashboard/Metrics/' . $role . '">' . nissan_get_role_from_table_name($role) . '</a></li>';
		}

		$html .= '
		</ul>
                </li>
		';

		return $html;
	} else {
		return '<li> <a href="/Dashboard/Metrics">Metrics</a> </li>';
	}
}

?>