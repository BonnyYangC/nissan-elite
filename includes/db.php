<?PHP
class database {

	public $Data;
	public $Pagination;
	public $User;
	public $last_insert_id;
	
	protected $conn;
	protected $_user;
	public $_limit=35;

	/****************************************
				INTERNAL METHODS
	*****************************************/
	function __construct()
	{
		date_default_timezone_set('Australia/Melbourne');
		$this->_user = (isset($_COOKIE['_nissanac']) ? $_COOKIE['_nissanac'] : '');
		$this->User = array();
		if ($_SERVER['SERVER_ADDR']=='127.0.0.1' || $_SERVER['SERVER_ADDR']=='172.16.30.108')
		{
			$this->conn=mysql_connect("localhost","root","root") or die("Failed to connect to database");
			mysql_select_db("destinat_db",$this->conn);
		}
		else
		{
			$this->conn=mysql_connect("localhost","destinat",'O$Am80_g!e;W') or die("Failed to connect to database");
			mysql_select_db("destinat_db",$this->conn);
		}		
		
		if (!empty($this->_user))
		{
			if($this->fetch_current_user())
			{
				$this->User=$this->Data;

				/* Gets necessary data for working with users with multiple roles */
				$this->get_position_list();
				$this->get_data_all_positions();
			}
		}
		
	}

	protected function fnUniqueID()
	{
		$tmp= strtoupper(md5(microtime()));
		return substr($tmp,0,8) . '-' . substr($tmp,8,4) . '-' . substr($tmp,12,4)	. '-' . substr($tmp,16,4) . '-' . substr($tmp,20);
	}

	protected function fnStrip( $msg )
	{
		return str_replace("'","''",$msg);
	}			

	protected function fnCleanPhone( $msg )
	{
		$retval = str_replace("+","",$msg);
		$retval = str_replace("/","",$retval);
		$retval = str_replace(" ","",$retval);
		$retval = str_replace("-","",$retval);
		$retval = str_replace("(","",$retval);
		$retval = str_replace(")","",$retval);
		$retval = str_replace("-","",$retval);
		$retval=$this->fnStrip($retval);
		return $retval;
	}			

	protected function subval_sort($a, $subkey, $order='ASC') {
	
		if ($order=='ASC')
		{
			foreach($a as $k=>$v) {
				$b[$k] = strtolower($v[$subkey]);
			}
			asort($b);
			foreach($b as $key=>$val) {
				$c[] = $a[$key];
			}
		}
		else
		{
			foreach($a as $k=>$v) {
				$b[$k] = strtolower($v[$subkey]);
			}
			arsort($b);
			foreach($b as $key=>$val) {
				$c[] = $a[$key];
			}
		}	
		return $c;
	}
	
	/****************************************
				CORE METHODS
	*****************************************/

	/* A user may have multiple positions, this method returns an array
	of type 'string' with the names of the tables that this employee
	code is present in */
	private function get_position_list () {
		$position_list = array();

		$tables = array (
			'nissan_salesconsultants',
			'nissan_salesmanagers',
			'nissan_serviceadvisors',
			'nissan_fi',
			'nissan_stockcontroller',
			'nissan_financialcontrollers',
			'nissan_partsmanager',
			'nissan_partsrep',
			'nissan_servicemanagers'
		);

		foreach ($tables as $table) {
			$query = "SELECT * FROM " . $table . " WHERE member_id='" . $this->User['employee_code'] . "'";
			$num_rows = mysql_num_rows(mysql_query($query));
			
			if ($num_rows !== 0) {
				$position_list[] = $table;
			}
		}
		
		$this->User['positions'] = $position_list;
	}

	private function get_data_all_positions () {
		$retrieved_data = array();

		foreach ($this->User['positions'] as $table) {
			$retrieved_data[$table] = array();

			$sql="SELECT * FROM $table WHERE member_id='" . $this->User['employee_code'] . "' ORDER by period";

			if ($rs2=mysql_query($sql, $this->conn) )
			{
				while ($data = mysql_fetch_array($rs2))
				{
					$retrieved_data[$table]['Results'][date('M-Y', strtotime($data['period']))]=$data;
					$retrieved_data[$table]['Excellence']=$data['excellence'];
				}
			}
		}

		$this->User['multiple_role_metrics'] = $retrieved_data;
	}

	public function fetch_current_user( )
	{
		$retval=false;
		
		$sql="SELECT users.*, 
					company.company_name, company.company_code, company.category, company.region,
					d.content as department_name, p.content as position_desc
				FROM sessions 
						INNER JOIN users ON users.user_id=sessions.user_id
						INNER JOIN company ON users.company_id=company.company_id
						LEFT JOIN lookups d ON (users.dept=d.code AND d.grouping='DEPT' AND d.company_id=8)
						LEFT JOIN lookups p ON (users.position=p.code AND p.grouping='POSITION' AND p.company_id=8)
				WHERE sessions.sessionid='" . $this->_user . "'
						AND users.active=1
						AND (company.parent_id=8 OR company.company_id=8)";
		if ($rs=mysql_query($sql, $this->conn) )
		{
			if ($row = mysql_fetch_array($rs))
			{
				$row['Results']=array();
				$row['Registered']='NO';
				$row['Excellence']=0;
				
				switch ($row['position'])
				{
					case 'R': 	// Retail Sales Consultants
					case 'F': 	// Fleet Sales Consultants
					case 'FM': 	// Fleet Sales manager
//						$sql="SELECT * FROM nissan_salesconsultants WHERE member_id='" . $row['employee_code'] . "' AND dealer_code='" . $row['company_code'] . "' ORDER by period";
						$sql="SELECT * FROM nissan_salesconsultants WHERE member_id='" . $row['employee_code'] . "' ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;
						
					case 'M':	// Sales Manager
						
						$sql="SELECT * FROM nissan_salesmanagers WHERE member_id='" . $row['employee_code'] . "'  ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;

					case 'SA':	// Service Advisors
						
						$sql="SELECT * FROM nissan_serviceadvisors WHERE member_id='" . $row['employee_code'] . "'  ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;

					case 'I':	// F and I
						
						$sql="SELECT * FROM nissan_fi WHERE member_id='" . $row['employee_code'] . "'  ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Excellence']=$data['excellence'];
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
							}
						}
						break;

					case 'SC':	// Stock Controller
						
						$sql="SELECT * FROM nissan_stockcontroller WHERE member_id='" . $row['employee_code'] . "' ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Excellence']=$data['excellence'];
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
							}
						}
						break;

				case 'C':	// Financial Controller
						$sql="SELECT * FROM nissan_financialcontrollers WHERE member_id='" . $row['employee_code'] . "' ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;

				case 'PM':	// Parts Manager
						$sql="SELECT * FROM nissan_partsmanager WHERE member_id='" . $row['employee_code'] . "' ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;
				case 'PS':	// Parts Sales Rep
						$sql="SELECT * FROM nissan_partsrep WHERE member_id='" . $row['employee_code'] . "' ORDER by period";
						
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;
				case 'SM':	// Service Managers
						$sql="SELECT * FROM nissan_servicemanagers WHERE member_id='" . $row['employee_code'] . "' ORDER by period";
						if ($rs2=mysql_query($sql, $this->conn) )
						{
							while ($data = mysql_fetch_array($rs2))
							{
								$row['Results'][date('M-Y', strtotime($data['period']))]=$data;
								$row['Excellence']=$data['excellence'];
							}
						}
						break;
				}
				
				/**********************
						RANKINGS
				***********************/
				$thisperiod=date("Y-m") . "-01";
				$sql="SELECT max(nissan_rankings.period) as latest FROM nissan_rankings
						INNER JOIN users ON nissan_rankings.role=users.position
						INNER JOIN company ON users.company_id=company.company_id AND company.category=nissan_rankings.category
						WHERE " . ($row['position']=="F" || $row['position']=="FM" 
								   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
								   : "nissan_rankings.role='" . $row['position'] . "'");
				if ($rs2=mysql_query($sql, $this->conn) )
				{
					if ($data = mysql_fetch_array($rs2))
					{
						$thisperiod=date("Y-m-d", strtotime($data['latest']));
					}
				}
				
				$row['Rankings']=array();
				$sql="SELECT nissan_rankings.*, users.firstname, users.lastname, company.company_name, company.company_state FROM nissan_rankings
						INNER JOIN users ON nissan_rankings.member_id=users.employee_code
						INNER JOIN company ON users.company_id=company.company_id 
						WHERE " . ($row['position']=="F" || $row['position']=="FM" 
								   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
								   : "nissan_rankings.role='" . $row['position'] . "'") . " 
								AND nissan_rankings.period='" . $thisperiod . "'
								AND nissan_rankings.category='" . $row['category'] . "'
						ORDER by nissan_rankings.ranking";
				if ($rs2=mysql_query($sql, $this->conn) )
				{
					while ($data = mysql_fetch_array($rs2))
					{
						$row['Rankings'][]=$data;
						if ($row['employee_code']==$data['member_id'])
						{
							$row['Registered']=$data['registered'];
						}
					}
				}


				$sql="SELECT nissan_rankings.*, users.firstname, users.lastname, company.company_name, company.company_state FROM nissan_rankings
						INNER JOIN users ON nissan_rankings.member_id=users.employee_code
						INNER JOIN company ON users.company_id=company.company_id 
						WHERE " . ($row['position']=="F" || $row['position']=="FM" 
								   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
								   : "nissan_rankings.role='" . $row['position'] . "'") . "
								AND nissan_rankings.period='" . $thisperiod . "'
								AND nissan_rankings.category='" . $row['category'] . "'
								AND nissan_rankings.member_id='" . $row['employee_code'] . "'";
				if ($rs2=mysql_query($sql, $this->conn) )
				{
					if ($data = mysql_fetch_array($rs2))
					{
						$row['MyRanking']=$data;
					}
				}

				$sql="SELECT count(*) as regional_ranking
						FROM nissan_rankings
						INNER JOIN users ON nissan_rankings.member_id=users.employee_code
						INNER JOIN company ON users.company_id=company.company_id 
						WHERE " . ($row['position']=="F" || $row['position']=="FM" 
								   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
								   : "nissan_rankings.role='" . $row['position'] . "'") . "
								AND nissan_rankings.period='" . $thisperiod . "'
								AND nissan_rankings.category='" . $row['category'] . "'
								AND company.region='" . $row['region'] . "'
								AND nissan_rankings.ranking<" . $data['ranking'];
				if ($rs2=mysql_query($sql, $this->conn) )
				{
					if ($data = mysql_fetch_array($rs2))
					{
						$row['Regional']=$data['regional_ranking'] + 1;
					}
				}
				
				$row['History']=array();
				$sql="SELECT * FROM nissan_history
						WHERE member_id='" . $row['employee_code'] . "' ORDER BY period";
				if ($rs2=mysql_query($sql, $this->conn) )
				{
					while ($data = mysql_fetch_array($rs2))
					{
						if (isset($row['History'][date("Y", strtotime($data['period']))]))
						{
							$row['History'][date("Y", strtotime($data['period']))]['FF']=$data;
						}
						else
						{
							$row['History'][date("Y", strtotime($data['period']))]=$data;
						}
					}
				}

				$row['Credits']=array();
				$sql="SELECT * FROM nissan_credits
						WHERE member_id='" . $row['employee_code'] . "' AND period>='2017-04-01' AND period<='2018-03-01' ORDER BY period";
				if ($rs2=mysql_query($sql, $this->conn) )
				{
					while ($data = mysql_fetch_array($rs2))
					{
						$row['Credits'][date("M-Y", strtotime($data['period']))]=$data;
					}
				}
				
				$this->Data=$row;
				$retval=true;
			}
		}		
		
		
		//echo '<pre>';print_r($this->Data); echo '</pre>';
		
		$sql="UPDATE sessions SET datestamp='" . date("Y-m-d H:i") . "'
				WHERE sessions.sessionid='" . $this->_user . "'";
		mysql_query($sql, $this->conn);
	
		return $retval;
	}

	
	public function Login( $email='', $password='')
	{
		$retval = false;
		if ( !empty($email) && !empty($password) )
		{
			/*
					Restrict access to Destination and Gekko Only
			*/
			$sql="SELECT *
					FROM users INNER JOIN company ON users.company_id=company.company_id
					WHERE users.email='" . $this->fnStrip($email) . "'
							AND users.password='" . $this->fnStrip($password) . "'
							AND users.active=1
							AND (company.parent_id=8 OR company.company_id=8)";
			if ($rs=mysql_query($sql, $this->conn) )
			{
				if ($row = mysql_fetch_array($rs))
				{
					//
					//		Delete all the ghost sessions
					//
					$yesterday = mktime(date("H")-3,0,0,date("m"), date("d"),date("Y"));
					$sql = "DELETE FROM sessions WHERE datestamp<='" . date("Y-m-d", $yesterday) . "'";
					mysql_query($sql, $this->conn);
					//
					//	Insert a New Session for this user
					//
					$sessionid = $this->fnUniqueID();
					$this->Data['Session']=$sessionid;
					$sql = "INSERT INTO sessions (sessionid,user_id,datestamp)
							VALUES ('" . $sessionid . "','" . $row['user_id'] . "','" . date("Y-m-d H:i") . "')";
					mysql_query($sql, $this->conn);	
					//
					//		Check for concurrent users
					//
					$this->Data['Count']=0;

					$sql="SELECT count(*) as tot
							FROM sessions 
							WHERE user_id=" . $row['user_id'];
					if ($rs2=mysql_query($sql, $this->conn) )
					{
						if ($tmprow = mysql_fetch_array($rs2))
						{
							$this->Data['Count']=$tmprow['tot'];
						}
					}
					$retval=true;
				}
			}		
		}
		return $retval;
	
	}

	public function Logout ( )
	{

		$sql = "DELETE FROM sessions WHERE sessionid='" . $this->_user . "'";
		mysql_query($sql, $this->conn);
		return true;
	}

	public function UseSession ( )
	{
		$sql = "DELETE FROM sessions WHERE sessionid<>'" . $this->_user . "'
										AND user_id=" . $this->User['user_id'];
		mysql_query($sql, $this->conn);
	}
	
	public function GetPeriod( $role, $period, $region)
	{
		$thisperiod=date("Y-m") . "-01";
		$sql="SELECT max(nissan_rankings.period) as latest FROM nissan_rankings
				INNER JOIN users ON nissan_rankings.role=users.position
				INNER JOIN company ON users.company_id=company.company_id " . ($role=="F" || $role=="FM" ? "" : "AND company.category=nissan_rankings.category") . "
				WHERE " . ($role=="F" || $role=="FM" 
						   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
						   : "nissan_rankings.role='" . $role . "'");
		if ($rs2=mysql_query($sql, $this->conn) )
		{
			if ($data = mysql_fetch_array($rs2))
			{
				$thisperiod=date("Y-m-d", strtotime($data['latest']));
			}
		}
		
		if ($period=="P")
		{
			$thisperiod=date("Y-m-d", mktime(0,0,0, date("m", strtotime($thisperiod))-1, 1, date("Y", strtotime($thisperiod)) ));
		}
		
		return $thisperiod;

	}
	
	public function Rankings($role, $period, $region)
	{
		$retval=false;
		
		$thisperiod=$this->GetPeriod($role, $period, $region);
		$this->Data=array();
		if ($region=="N")
		{
			$sql="SELECT nissan_rankings.*, users.firstname, users.lastname, company.company_name, company.company_state , company.region, r.content as region_name
					FROM nissan_rankings
							INNER JOIN users ON nissan_rankings.member_id=users.employee_code
							INNER JOIN company ON users.company_id=company.company_id " . ($role=="F" || $role=="FM" ? "" : "AND company.category=nissan_rankings.category") . "
								INNER JOIN lookups r ON r.code=company.region AND r.company_id=company.parent_id
				WHERE " . ($role=="F" || $role=="FM" 
							   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
							   : "nissan_rankings.role='" . $role . "'") . " 
							AND nissan_rankings.period='" . $thisperiod . "'
					ORDER BY " . ($role=='F' || $role=='FM' ? "nissan_rankings.ranking" : "nissan_rankings.category, nissan_rankings.ranking");
		}
		else
		{
			$sql="SELECT nissan_rankings.*, users.firstname, users.lastname, company.company_name, company.company_state , company.region, r.content as region_name
					FROM nissan_rankings
							INNER JOIN users ON nissan_rankings.member_id=users.employee_code
							INNER JOIN company ON users.company_id=company.company_id " . ($role=="F" || $role=="FM" ? "" : "AND company.category=nissan_rankings.category") . "
							INNER JOIN lookups r ON r.code=company.region AND r.company_id=company.parent_id
					WHERE " . ($role=="F" || $role=="FM" 
							   ? "(nissan_rankings.role='F' OR nissan_rankings.role='FM')"
							   : "nissan_rankings.role='" . $role . "'") . " 
							AND nissan_rankings.period='" . $thisperiod . "'
					ORDER BY " . ($role=='F' || $role=='FM' ? "company.region, nissan_rankings.ranking" : "company.region, nissan_rankings.category, nissan_rankings.ranking");
					
		}
		if ($rs2=mysql_query($sql, $this->conn) )
		{
			while ($data = mysql_fetch_array($rs2))
			{
				$this->Data[]=$data;
				$retval=true;
			}
		}
		return $retval;
	}
	
	public function NissanEvents()
	{
		$retval=false;
		$this->Data=array();
		$sql="SELECT * FROM nissan_events ORDER BY datestamp";
		if ($rs2=mysql_query($sql, $this->conn) )
		{
			while ($data = mysql_fetch_array($rs2))
			{
				$this->Data[]=$data;
				$retval=true;
			}
		}
		return $retval;
		
	}
	
	public function NissanIncentives($status)
	{
		$retval=false;
		$this->Data=array();
		$threemths = mktime(0,0,0,date("m")-3,date("d"),date("Y"));
		switch ($status)
		{
			case 'CURRENT':
				$sql="SELECT * FROM nissan_incentives 
							WHERE nissan_incentives.finish>='" . date("Y-m-d") . "' 
									AND nissan_incentives.image IS NOT NULL
							ORDER BY nissan_incentives.start DESC";
				break;
			case 'FINISHED':
				$sql="SELECT * FROM nissan_incentives
						WHERE nissan_incentives.finish>='" . date("Y-m-d", $threemths) . "' 
								AND nissan_incentives.finish<'" . date("Y-m-d") . "' 
								AND nissan_incentives.image IS NOT NULL
						ORDER BY nissan_incentives.start DESC";
				break;
			default:
				$sql="SELECT * FROM nissan_incentives
						WHERE nissan_incentives.finish<'" . date("Y-m-d", $threemths) . "'
								AND nissan_incentives.image IS NOT NULL
						ORDER BY nissan_incentives.start DESC";
				break;
		}
		if ($rs2=mysql_query($sql, $this->conn) )
		{
			while ($data = mysql_fetch_array($rs2))
			{
				$this->Data[]=$data;
				$retval=true;
			}
		}
		return $retval;
	}
}
?>
