<?PHP
	require("../init.php");

	$action="";
	if (isset($_GET['action']) || isset($_POST['action']) )
	{
		$action = ( isset($_GET['action']) ) ? $_GET['action'] : $_POST['action'];
	}
	
	switch ($action)
	{
		/**************************************
				APPLICATION SPECIFICS
		***************************************/
		case 'GetRanking':
			$trim_var_list = array(	
									'role' => 'role',
									'period' => 'period',
									'region' => 'region'
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
			
			$thisdate=$database->GetPeriod($role, $period, $region);
			
			$count=0;
			$class='class="active"';
			$ranking=0;
	
			$result='<div class="table-responsive">   
						<h4 align=center>' . date("F Y", strtotime($thisdate)) . '</h4>';
			if ($database->Rankings($role, $period, $region))
			{
				$color='#000000';
				$category='';
				$tmpregion='';
				foreach($database->Data as $row)
				{
				//echo $tmpregion . '-' . $row['region'] . '-' . $role . '<br>';
					$count++;
					if ($region=='R' && $tmpregion!=$row['region'])
					{
						$tmpregion=$row['region'];
						if ($role=='F' || $role=='FM')
						{
							$result.=(empty($result) ? '' : '</table>') . '<h3> ' . ($region=="R" ?  $row['region_name']  : '') . '</h3><table class="table">
								<tr class="table-top-row">
								  <td>Rank</td>
								  <td>Name</td>
								  <td>Dealership</td>
								  <td>State</td>
								  <td>Credits</td>
								  <td>Registered</td>
								</tr>';
							$ranking=0;
						}
	
					}
							
					if(($role=='F' || $role=='FM') && $region=='N' && $ranking==0)
					{
							$tmpregion=$row['region'];
							$result.=(empty($result) ? '' : '</table>') . '<h3> ' . ($region=="R" ?  $row['region_name']  : '') . '</h3><table class="table">
								<tr class="table-top-row">
								  <td>Rank</td>
								  <td>Name</td>
								  <td>Dealership</td>
								  <td>State</td>
								  <td>Credits</td>
								  <td>Registered</td>
								</tr>';
							$ranking=0;
					}

					if ($category!=$row['category'] && !($role=='F' || $role=='FM'))
					{
						$result.=(empty($result) ? '' : '</table>') . '<h3> ' . ($region=="R" ?  $row['region_name'] . ' - ' : '') . 'Category ' . $row['category'] . '</h3><table class="table">
							<tr class="table-top-row">
							  <td>Rank</td>
							  <td>Name</td>
							  <td>Dealership</td>
							  <td>State</td>
							  <td>Credits</td>
							  <td>Registered</td>
							</tr>';
						$category=$row['category'];
						$ranking=0;

					}
						$class=($class=='class="active"' ? '' : 'class="active"');
					$ytd=$row['total'];
					switch ($role)
					{
						case 'M':
						case 'R':
						case 'F':	// Fleet Sales Consultant
						case 'FM':	// Fleet Sales Manager
							if ( $ytd>= 38000) {
								//	Premier
									$color='#B47C37';
								} elseif ($ytd>=27000) {
								//	Ambassador
								$color='#546E22';
								} elseif ($ytd >=22000) {
								//	Diplomat
									$color='#BC2628';
							} elseif ($ytd >= 12000) {
								//	Consul
									$color='#525357';
							} else {
									$color='#000000';
							}
							break;
							
						case 'SC':
							
							if ( $ytd>= 22000) {
										$color='#B47C37';
								} elseif ($ytd>=16000) {
									//	Ambassador
									$color='#546E22';
								} elseif ($ytd >=12000) {
									//	Diplomat
									$color='#BC2628';
								} elseif ($ytd >= 9000) {
									//	Consul
										$color='#525357';
								} else {
										$color='#000000';
								}
							break;
							
					case 'C':
							
							if ( $ytd>= 35000) {
										$color='#B47C37';
								} elseif ($ytd>=25000) {
									//	Ambassador
									$color='#546E22';
								} elseif ($ytd >=20000) {
									//	Diplomat
									$color='#BC2628';
								} elseif ($ytd >= 10000) {
									//	Consul
										$color='#525357';
								} else {
										$color='#000000';
								}
							break;
							
							
					case 'I':
							
							if ( $ytd>= 50000) {
										$color='#B47C37';
								} elseif ($ytd>=30000) {
									//	Ambassador
									$color='#546E22';
								} elseif ($ytd >=25000) {
									//	Diplomat
									$color='#BC2628';
								} elseif ($ytd >= 11000) {
									//	Consul
										$color='#525357';
								} else {
										$color='#000000';
								}
							break;

						case 'PS':
					case 'PM':
					case 'SA':
					case 'SM':
							
							if ( $ytd>= 33000) {
										$color='#B47C37';
								} elseif ($ytd>=22000) {
									//	Ambassador
									$color='#546E22';
								} elseif ($ytd >=13000) {
									//	Diplomat
									$color='#BC2628';
								} elseif ($ytd >= 7000) {
									//	Consul
										$color='#525357';
								} else {
										$color='#000000';
								}
							break;

							
					}
					$ranking++;
					$result.='<tr ' . $class . '>
								  <td>' . ($region=="N" ? $row['ranking'] : $ranking) . '</td>
								  <td style="font-family: \'nissan_brandbold\', Helvetica, Arial, sans-serif; color:' . $color . ';">' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
								  <td>' . $row['company_name'] . '</td>
								  <td align=center>' . $row['company_state'] . '</td>
								  <td align=center>' . number_format($row['total'], 0) . '</td>
								  <td align=center>' . ($row['registered']=="YES" ? $row['registered'] : '<span style="color: #FF0000">' . $row['registered'] . '</span>') . '</td>
								</tr>';
					
				}
			}
			
			$result.=($count==0 ? '<tr><td colspan=6 align=center><p>No Records Found</p></td></tr>' : '') . '</table><br></div>';
			echo $result;
			
			
			break;

	}

?>