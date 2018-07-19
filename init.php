<?PHP
/**
 * Switch on all PHP error if in DEV mode
 */
error_reporting(DEV_MODE ? E_ALL : 0);

set_time_limit ( 360 );

//require_once("includes/functions.php");
//require_once("includes/functions_nissan.php");
//require_once("includes/db.php");

date_default_timezone_set('Australia/Melbourne');

/**
 * database.php is loaded automatically by composer
 * BY Justin
 */
$database = new database();
$Application = array (
						"RootDirectory" => $_SERVER['DOCUMENT_ROOT'] . '/',
						"RemoteIP" => $_SERVER['REMOTE_ADDR'],
						"Template" => "default",
						"Cookie" => '' );
						
$session = (isset($_COOKIE['_nissanac']) ? $_COOKIE['_nissanac'] : '');
if (!empty($session))
{
	$Application['Session'] = $session;
	$Application['User'] = $database->User;
	setcookie("_nissanac", $session, time() + 7200, "/" );
}
else
{
	// forced log out if unable to locate user
	setcookie("_nissanac", '', time() - 3600, "/");
}

?>