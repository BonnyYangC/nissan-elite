<?PHP

	require("../init.php");

	$trim_var_list = array(	
							'action' => 'action',
							'id' => 'id'
							);
	
	while( list($var, $param) = @each($trim_var_list) )
	{
		if ( isset($_GET[$param]) || isset($_POST[$param]) )
		{
			$$var = ( isset($_GET[$param]) ? $_GET[$param] : $_POST[$param] );
		}
		else
		{
			$$var = '';
		}
	}

	if($action=='image')
	{
		$name=$_FILES['img']['name'];
	}
	else
	{
		$name=$_FILES['pdf']['name'];
		
	}

echo '<pre>';
print_r($_POST);
print_r($_FILES);
echo '</pre>';

?>