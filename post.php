<?PHP
	require("init.php");

	$action="";
	if (isset($_GET['action']) || isset($_POST['action']) )
	{
		$action = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
	}
	
	switch ($action)
	{
		case 'login':
			$trim_var_list = array(	
									'email' => 'email',
									'password' => 'password'
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
			
			if ( $database->Login( $email, $password) )
			{
				setcookie("_nissanac", $database->Data['Session'], time() + 3600, "/" );
				if ($database->Data['Count']>1)
				{
					//	More than one concurrent user
					echo '<script type="text/javascript">
							parent.MultipleLogins();
							</script>';
				}
				else
				{
					echo '<script type="text/javascript">
							parent.location="/";
						</script>';
					
				}
			}
			else
			{

				echo '<script type="text/javascript">
						parent.errorAlert("Authentication Failure", "The system is unable to authenticate you.<br>You have entered an invalid Email or Password." );
					</script>';
			}
			break;
			
		case 'logout':
			$database->Logout();
			setcookie("_nissanac", '', time() - 3600, "/");
			break;
			
		case 'UseSession':
			$database->UseSession();
			break;
		/**************************************
				APPLICATION SPECIFICS
		***************************************/

	}

?>