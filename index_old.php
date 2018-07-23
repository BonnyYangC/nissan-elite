<?php
    require_once __DIR__ . '/vendor/autoload.php';
    define(DEV_MODE, env('DEV_MODE',true));

	if ( !isset($Application['User']) ||empty($Application['User']) )
	{
		open_template("login.html");
	}
	else
	{
		/**************************************
				Choose content to display
		***************************************/
		$action='';
		if (isset($_GET['action']) || isset($_POST['action']) )
		{
			$action = strtolower( isset($_GET['action']) ? $_GET['action'] : $_POST['action']);
		}

		$displayskin = true;
		$background='background-color: #FFFFFF; padding:0 25px;';
		switch ($action)
		{
			case 'dashboard':
				include "modules/dashboard.php";
				break;
			default:
				open_template("3-brands.html");
				$displayskin=false;
				break;
		}

		if ($displayskin)
		{
			open_template("main.html", array(
					"CONTENT" => $content,
					"FIRSTNAME" => $Application['User']['firstname'],
					"LASTNAME" => $Application['User']['lastname'],
					"COMPANY-NAME" => $Application['User']['company_name'],
					"BACKGROUND" => $background,
					"METRICSNAV" => nissan_get_metrics_nav_html($Application['User'])
					));

		}

	}