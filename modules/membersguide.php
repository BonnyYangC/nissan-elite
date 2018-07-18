<?PHP

	$page='';
	$content='';
	if (isset($_GET['page']) || isset($_POST['page']) )
	{
		$page = strtolower( isset($_GET['page']) ? $_GET['page'] : $_POST['page']);
	}
	switch ($page)
	{
		default:
			$content=read_template("membersguide.html");
			break;
	}

?>