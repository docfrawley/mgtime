<? include_once("initialize.php");
require_once 'vendor/autoload.php';
session_start();

class memadmin {

	private $allmem;
  private $username;
  private $password;
  private $member;
	private $year;


	function __construct() {
		$this->allmem = array();
    $this->username = "";
    $this->password = "";
    $this->member = "";
		$this->year = date('Y');
	}

	function check_username($username){
		global $database;
    $sql="SELECT * FROM memberinfo WHERE username='".$username."'";
		$result_set = $database->query($sql);
		$value= $database->fetch_array($result_set);
		$member = new memberObject($_SESSION['memberid']);
		return ($database->num_rows($result_set)===0);
	}

	function addMember($info){
		global $database;
		if ($info['adstatus']=="non") {$info['adstatus']="";}
		$fname = $database->escape_value($info['fname']);
		$lname = $database->escape_value($info['lname']);
		$aclass = $database->escape_value($info['aclass']);
    $sql = "INSERT INTO memberinfo (";
	  	$sql .= "lname, fname, class, mgstatus, admin_status";
	  	$sql .= ") VALUES ('";
	  	$sql .= $lname ."', '";
      $sql .= $fname ."', '";
      $sql .= $aclass ."', '";
			$sql .= $database->escape_value($info['mgstatus']) ."', '";
		  $sql .= $database->escape_value($info['adstatus']) ."')";
		$database->query($sql);
		$sqla="SELECT * FROM memberinfo WHERE lname='".$lname."' AND fname='".$fname."' AND class='".$aclass."'";
		$result_seta = $database->query($sqla);
		$value= $database->fetch_array($result_seta);
		$userid = $value['id'];

		$sql = "INSERT INTO membercontact (";
			$sql .= "id, street, town, state, zip, hphone, cphone, preferred";
			$sql .= ") VALUES ('";
			$sql .= $userid ."', '";
			$sql .= $database->escape_value($info['street']) ."', '";
			$sql .= $database->escape_value($info['town']) ."', '";
			$sql .= $database->escape_value($info['state']) ."', '";
			$sql .= $database->escape_value($info['zip']) ."', '";
			$sql .= $database->escape_value($info['hphone']) ."', '";
			$sql .= $database->escape_value($info['cphone']) ."', '";
			$sql .= $database->escape_value($info['preferred']) ."')";
		$database->query($sql);

	}

	function update_info($info, $id){
		global $database;
		if ($info['admin_status']=="non") {$info['admin_status']="";}
    $sql = "UPDATE memberinfo SET ";
		$sql .= "fname='". $database->escape_value($info['fname']) ."', ";
		$sql .= "lname='". $database->escape_value($info['lname']) ."', ";
		$sql .= "class='". $database->escape_value($info['class']) ."', ";
		$sql .= "mgstatus='". $database->escape_value($info['mgstatus']) ."', ";
		$sql .= "admin_status='". $database->escape_value($info['admin_status']) ."' ";
		$sql .= "WHERE id='". $id. "' ";
		$database->query($sql);
	}

	function editMember($info){
		global $database;
		$id = $database->escape_value($info['id']);
		$this->update_info($info, $id);
		$sql = "UPDATE membercontact SET ";
		$sql .= "street='". $database->escape_value($info['street']) ."', ";
		$sql .= "town='". $database->escape_value($info['town']) ."', ";
		$sql .= "state='". $database->escape_value($info['state']) ."', ";
		$sql .= "zip='". $database->escape_value($info['zip']) ."', ";
		$sql .= "hphone='". $database->escape_value($info['hphone']) ."', ";
		$sql .= "cphone='". $database->escape_value($info['cphone']) ."', ";
		$sql .= "preferred='". $database->escape_value($info['preferred']) ."' ";
		$sql .= "WHERE id='". $id. "' ";
		$database->query($sql);
	}

	function changeToActive($group){
		global $database;
		for ($i=0; $i < count($group); $i++) {
			$sql = "UPDATE memberinfo SET ";
			$sql .= "mgstatus='A' ";
			$sql .= "WHERE id='". $group[$i]['id']. "' ";
			$database->query($sql);
		}
	}

	function deleteMember($memberid){
		global $database;
		$id = $database->escape_value($memberid);
		$sql = "DELETE FROM memberinfo ";
	  	$sql .= "WHERE id=". $id;
	  	$sql .= " LIMIT 1";
	 	$database->query($sql);
		$sql = "DELETE FROM membercontact";
	  	$sql .= "WHERE id=". $id;
	  	$sql .= " LIMIT 1";
	 	$database->query($sql);
	}

	function checkLogin($username, $password){
    global $database;
    $sql="SELECT * FROM memberinfo WHERE username='".$username."' AND password='".$password."'";
		$result_set = $database->query($sql);
		if($database->num_rows($result_set)>0){
      $this->username = $username;
      $this->password = $password;
      $value= $database->fetch_array($result_set);
      $_SESSION['memberid'] = $value['id'];
      $this->member = $value['id'];
			$memberhrs = new memberHrs($_SESSION['memberid']);
			//$memberhrs->setDates();
      return true;
    } else {
      return false;
    }
	}

	function addMemberContact($meminfo, $memid){
		global $database;
		$id = $database->escape_value($memid);
		$sql="SELECT * FROM membercontact WHERE id = '".$id."'";
		$result_set = $database->query($sql);
		$memcontact = $database->fetch_array($result_set);
		$return_array = array(
			"id" 						=> $id,
			"fname" 				=> $meminfo['fname'],
			"lname" 				=> $meminfo['lname'],
			"class" 				=> $meminfo['class'],
			"mgstatus" 			=> $meminfo['mgstatus'],
			"admin_status"	=> $meminfo['admin_status'],
			"street" 				=> $memcontact['street'],
			"town" 					=> $memcontact['town'],
			"state" 				=> $memcontact['state'],
			"zip" 					=> $memcontact['zip'],
			"hphone" 				=> $memcontact['hphone'],
			"cphone" 				=> $memcontact['cphone'],
			"preferred" 		=> $memcontact['preferred']
		);
		return $return_array;
	}

	function get_flist(){
		global $database;
		$temp_array = array();
    $sql="SELECT * FROM memberinfo WHERE admin_status='full' ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$mem_array = $this->addMemberContact($value, $value['id']);
			array_push($temp_array, $mem_array);
		}
		return $temp_array;
	}

	function get_hlist(){
		global $database;
		$temp_array = array();
    $sql="SELECT * FROM memberinfo WHERE admin_status='hours' ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$mem_array = $this->addMemberContact($value, $value['id']);
			array_push($temp_array, $mem_array);
		}
		return $temp_array;
	}

	function get_list($filter='full', $filterwhich='full', $page=1, $year=2000){
		global $database;
		if ($year==2000){$year = $this->year;}
		$temp_array = [];
		if ($filter=='full'){
			$this->set_array();
			$first_array = $this->allmem;
			$index = 20;
		} else{
			if ($filter=='class'){
				$sql="SELECT * FROM memberinfo WHERE class = '".$filterwhich."' ORDER BY lname";
			} elseif ($filter=='endlist') {
				$sql="SELECT * FROM memberinfo WHERE mgstatus = 'A' OR mgstatus = 'Active 1000hrs' ORDER BY lname";
			} else {
				$sql="SELECT * FROM memberinfo WHERE mgstatus = '".$filterwhich."' ORDER BY lname";
			}
			$index = 25;
			$first_array = [];
			$result_set = $database->query($sql);
			while ($value = $database->fetch_array($result_set)) {
				if ($filter!='nclass') {
					array_push($first_array, $value);
				} else {
					if ($value['class']==$year) {
						array_push($first_array, $value);
					}
				}
			}
		}
		$start = $page*$index-$index;
		for ($counter=$start; $counter< $page*$index && $counter<count($first_array); $counter++) {
			$id = $first_array[$counter]['id'];
			$mem_array = $this->addMemberContact($first_array[$counter], $id);
			array_push($temp_array, $mem_array);
		}
		return $temp_array;
	}

	function get_hrmlist($filter='full', $filterwhich='full', $page=1, $year=2000){
		if ($year==2000){$year = $this->year;}
		$initial_array = $this->get_list($filter, $filterwhich, $page, $year);
		$temp_array = array();
		foreach ($initial_array as $value) {
			$member = new memberHrs($value['id']);
			$hours = $member->get_totalss($year);
			$total = $member->overallTotal($year);
			$member_array = array(
				"name" 	=> $value['fname'].' '.$value['lname'],
				'id'		=> $value['id'],
				'status'=> $value['mgstatus'],
				'hours' => $hours,
				'total'	=> $total
			);
			array_push($temp_array, $member_array);
		}
		return ($temp_array);
	}

	function get_last($filter='full', $filterwhich='full'){
		global $database;
		if ($filter=='full'){
			return $this->get_pages();
		} elseif ($filter=='class') {
			$sql="SELECT COUNT(*) AS totalnum FROM memberinfo WHERE class = '".$filterwhich."'";
			$result_set = $database->query($sql);
			$value = $database->fetch_array($result_set);
		} else {
			$sql="SELECT COUNT(*) AS totalnum FROM memberinfo WHERE mgstatus = '".$filterwhich."'";
			$result_set = $database->query($sql);
			$value = $database->fetch_array($result_set);
		}
		$numarray = $value['totalnum'];
		$temp_array['last']=ceil($numarray/25);
		return $temp_array;
	}

	function set_array(){
		global $database;
		$this->allmem = array();
    $sql="SELECT * FROM memberinfo ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			//$t_array = change_status($value);
			array_push($this->allmem, $value);
		}
	}

	function nohours($id){
		$memberhrs = new memberHrs($id);
		$value = $memberhrs->num_entries();
		return ($value==0);
	}

	function hrsNonlist(){
		$this->set_array();
		$nonReg_array = array();
		$RegNoHrs_array = array();
		$the_array = array ("IA", "T/NotG", "E");
		foreach ($this->allmem as $value) {
			if (!in_array($value['mgstatus'], $the_array)){
				$nohours = $this->nohours($value['id']);
				if ($value['username']==''){
					array_push($nonReg_array, $value);
				} elseif ($nohours) {
					array_push($RegNoHrs_array, $value);
				}
			}
		}
		$returnArray = array(
			'nonReg' => $nonReg_array,
			'RegNoHrs' => $RegNoHrs_array
		);
		return $returnArray;
	}

	function lookupMem($lname){
		global $database;
		$temp_array = array();
    $sql="SELECT * FROM memberinfo WHERE lname='".$lname."' ORDER BY fname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$mem_array = $this->addMemberContact($value, $value['id']);
			array_push($temp_array, $mem_array);
		}
		return $temp_array;
	}

	function get_pages(){
		$this->set_array();
		$temp_array = [];
		$temp_array['last']=ceil(count($this->allmem)/20);
	  return $temp_array;
	}

	function get_initial_info(){
		global $database;
		$temp_array = [];
		$sql="SELECT * FROM memberinfo ORDER BY class ASC LIMIT 1";
		$result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
		$temp_array['firstyear'] = 1994;
		if ($value['class']>0 && $value['class'] != $temp_array['firstyear']){
			$temp_array['firstyear'] = $value['class'];
		}
		$this->set_array();
		$temp_array['last']=ceil(count($this->allmem)/20);
	  return $temp_array;
	}

  function checkMember($fname, $lname, $year){
    global $database;
    $sql="SELECT * FROM memberinfo WHERE fname='".$fname."' AND lname='".$lname."' AND class='".$year."'";
		$result_set = $database->query($sql);
		if($database->num_rows($result_set)>0){
      $value= $database->fetch_array($result_set);
      $_SESSION['memberid'] = $value['id'];
      $this->member = $value['id'];
      return true;
    } else {
      return false;
    }
  }

  // function get_memberid(){
	// 	$temp_array = array();
	// 	$temp_array['id']=$this->member;
  //   return $temp_array;
  // }

  function checkUserName($username){
    global $database;
		$sql="SELECT * FROM memberinfo WHERE username='".$username."'";
		$result_set = $database->query($sql);
		return ($database->num_rows($result_set)>0);
  }

  function createLogin($info){
    global $database;
    $sql = "UPDATE memberinfo SET ";
		$sql .= "username='". $info['uname'] ."', ";
		$sql .= "password='". $info['pword'] ."', ";
		$sql .= "email='". $info['email'] ."' ";
		$sql .= "WHERE id='". $_SESSION['memberid']. "' ";
		$database->query($sql);
		$username = $info['uname'];
		$password = $info['pword'];
		$email = $info['email'];
		$m = new PHPMailer;
		$m->From = 'hours@mgofmc.org';
		$m->FromName = "";
		$m->addReplyTo('hours@mgofmc.org', "Reply Address");
		$m->Subject = "Master Gardners Info, Part I";
		$m->Body = "Your username as: ".$username.".";
		$m->addAddress($email);
		$m->send();

		$m = new PHPMailer;
		$m->From = 'hours@mgofmc.org';
		$m->FromName = "";
		$m->addReplyTo('hours@mgofmc.org', "Reply Address");
		$m->Subject = "Master Gardners Info, Part II";
		$m->Body = "Your password as: ".$password.".";
		$m->addAddress($email);
		$m->send();
	//	$_SESSION['newUser'] = true;
  }

	function check_email($email){
		global $database;
    $sql="SELECT * FROM memberinfo WHERE email='".$email."'";
		$result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
		$isThere = ($database->num_rows($result_set)>0);
		if ($isThere){
			$username = $value['username'];
			$password = $value['password'];
			$email = $value['email'];
			$m = new PHPMailer;
			$m->From = 'hours@mgofmc.org';
			$m->FromName = "";
			$m->addReplyTo('hours@mgofmc.org', "Reply Address");
			$m->Subject = "Master Gardners Info";
			$m->Body = "Your password is: ".$password.".";
			$m->addAddress($email);
			$m->send();

			$m = new PHPMailer;
			$m->From = 'hours@mgofmc.org';
			$m->FromName = "";
			$m->addReplyTo('hours@mgofmc.org', "Reply Address");
			$m->Subject = "Master Gardners Info, Part II";
			$m->Body = "Your username is: ".$username.".";
			$m->addAddress($email);
			$m->send();
		}
		return $isThere;
	}

	function get_total_mgs(){
		$this->set_array();
		$reg_array =  array(
			"A" 							=> 0,
			"A - Trainee" 		=> 0,
			"E" 							=> 0,
			"IA" 							=> 0,
			"T/NotG"  				=> 0,
			"Active 1000hrs" 	=> 0
		);
		foreach ($this->allmem as $value) {
			$key = $value['mgstatus'];
			$reg_array[$key]++;
		}
		return $reg_array;
	}

	function get_registered(){
		$this->set_array();
		$reg_array =  array(
			"A" 							=> 0,
			"A - Trainee" 		=> 0,
			"E" 							=> 0,
			"IA" 							=> 0,
			"T/NotG"  				=> 0,
			"Active 1000hrs" 	=> 0
		);
		foreach ($this->allmem as $value) {
			if ($value['username'] != ""){
				$key = $value['mgstatus'];
				$reg_array[$key]++;
			}
		}
		return $reg_array;
	}

	function get_entered_hrs(){
		$this->set_array();
		$hrs_array =  array(
			"A" 							=> 0,
			"A - Trainee" 		=> 0,
			"E" 							=> 0,
			"IA" 							=> 0,
			"T/NotG"  				=> 0,
			"Active 1000hrs" 	=> 0
		);
		foreach ($this->allmem as $value) {
			$member = new memberHrs($value['id']);
			if ($member->num_entries() >0 ){
				$key = $value['mgstatus'];
				$hrs_array[$key]++;
			}
		}
		return $hrs_array;
	}

	function rdlist($mgstatus, $year=2000){
		global $database;
		if ($year==2000){$year = $this->year;}
		$marray = array();
    	$sql="SELECT * FROM memberinfo WHERE mgstatus = '".$mgstatus."' ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			array_push($marray, $value);
		}
		$temp_array = array();
		$howmany = count($marray);
		for ($counter=0; $counter<count($marray); $counter++) {
			$id = $marray[$counter]['id'];
			$not_below = false;
		 	$memberhrs = new memberHrs($id);
			$t_array = $memberhrs->get_totalss($year);
		 	$totals_array = $t_array[12];
			$GardenCore = $totals_array['Helpline'] + $totals_array['GardenCore'];
			$totals_array['newMC']=false;
			switch ($mgstatus) {
				case 'A - Trainee':
						$not_below =  ( $marray[$counter]['class']==$year &&
								($totals_array['Mercer County']<25 ||
								$GardenCore <30
								|| $totals_array['Compost (Trainee)']<5 ));
						if ($not_below && $GardenCore >30)	{
							$diff = ($GardenCore - 30);
							$newTotal = $totals_array['Mercer County']+$diff;
							// if ($newTotal>24.99){
							// 	$not_below = false;
							// } else{
								$newMC=$totals_array['Mercer County']."+".$diff." (from Helpline/GardenCore) = ".$newTotal;
								$totals_array['Mercer County']=$newTotal;
								$totals_array['newMC']=true;
								$totals_array['diff']=$newMC;
							// }
						}
					break;
				case 'A':
				$not_below = ($totals_array['Mercer County']<15 ||
				$GardenCore <15
				|| $totals_array['Continuing Ed']<10 );
						if ($not_below && $GardenCore >15)	{
							$diff = $GardenCore-15;
							$newTotal = $totals_array['Mercer County']+$diff;
							$newMC=$totals_array['Mercer County']."+".$diff." (from Helpline/GardenCore) = ".$newTotal;
							$totals_array['Mercer County']=$newTotal;
							$totals_array['newMC']=true;
							$totals_array['diff']=$newMC;
						}
					break;
				case 'Active 1000hrs':
					if ($year<2018) {
						$not_below = ($totals_array['Mercer County']<25
								|| $totals_array['Continuing Ed']<10 );
					} else {
						$not_below = ($totals_array['Mercer County']<20
								|| $totals_array['Continuing Ed']<10 || $GardenCore<5);
					}

					break;
				default:
					break;
			}
			if ($not_below){
				$member_array = array(
					'lname'		=>	$marray[$counter]['lname'],
					'fname'		=>	$marray[$counter]['fname'],
					'class'		=>	$marray[$counter]['class'],
					'status'	=>	$marray[$counter]['mgstatus'],
					'totals'	=>	$totals_array
				);
				array_push($temp_array, $member_array);
			}
		}
		return $temp_array;
	}

	function clistDownload(){
		$this->set_array();
		$mem_array = array('A', 'Active 1000hrs', 'A - Trainee');
		$output = "";
		$output .= '
			<table class="table" bordered="1">
			<tr>';
		$output .='<th>Master Gardeners of Mercer County Contact List</th></tr>';
		$output .='
			<tr>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Class</th>
				<th>Street</th>
				<th>Town</th>
				<th>State</th>
				<th>Zip</th>
				<th>Home Phone</th>
				<th>Cell Phone</th>
				<th>Preferred Phone</th>
				<th>Email</th>
			</tr>';
		foreach ($this->allmem as $value)  {
			if (in_array($value['mgstatus'], $mem_array)){
				$member = new memberObject($value['id']);
				$output .='<tr>
				<td>'.$member->get_lname().'</td>
				<td>'.$member->get_fname().'</td>
				<td>'.$member->get_class().'</td>
				<td>'.$member->get_street().'</td>
				<td>'.$member->get_town().'</td>
				<td>'.$member->get_state().'</td>
				<td>'.$member->get_zip().'</td>
				<td>'.$member->get_hphone().'</td>
				<td>'.$member->get_cphone().'</td>
				<td>'.$member->get_preferred().'</td>
				<td>'.$member->get_email().'</td>
				</tr>';
			}
		}
		$output .= '</table>';
		return $output;
	}

	function rdlistDownload($mgstatus, $year=2000){
		if ($year<2017){ $year = $this->year;}
		$rdlist_array = $this->rdlist($mgstatus);
		$mstatus = ($mgstatus==='A') ? "Active Members" : $mgstatus;
		$output = "";
		$output .= '
			<table class="table" bordered="1">
			<tr>';
		$output .='<th>Requirement Deficiencies Report: '.$mstatus.'</th></tr>';
		$output .='
			<tr>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Class</th>
				<th>Status</th>';
		switch ($mgstatus) {
			case 'A':
				$output .='
					<th>Mercer County (15hrs)</th>
					<th>Helpline/GardenCore (15hrs)</th>
					<th>Continuing Ed (10hrs)</th>';
				break;
			case 'A - Trainee':
				$output .='
					<th>Compost (5hrs)</th>
					<th>Mercer County (25hrs)</th>
					<th>Helpline/GardenCore (30hrs)</th>';
				break;
			case 'Active 1000hrs':
			if (date('Y') < 2018) {
				$output .='
					<th>Mercer County (25hrs)</th>
					<th>Continuing Ed (10hrs)</th>';
			} else {
				$output .='
					<th>Mercer County (20hrs)</th>
					<th>GardenCore (5hrs)</th>
					<th>Continuing Ed (10hrs)</th>';
			}

				break;
			default:
				# code...
				break;
		}
		$output .='<th>Annual Total</th></tr>';
		foreach($rdlist_array as $member){
			$GardenCore = $member['totals']['Helpline'] + $member['totals']['GardenCore'];
			$output .="<tr>
						<td>".$member['lname']."</td>
						<td>".$member['fname']."</td>
						<td>".$member['class']."</td>
						<td>".$member['status']."</td>";
			switch ($mgstatus) {
				case 'A':
					if ($member['totals']['newMC']){
						$output .="<td>".$member['totals']['diff']."</td>";
					} else {
						$output .="<td>".$member['totals']['Mercer County']."</td>";
					}
					$output .="
							<td>".$GardenCore."</td>
							<td>".$member['totals']['Continuing Ed']."</td>
							<td>".$member['totals']['Total']."</td></tr>";
					break;
				case 'A - Trainee':
					$output .="<td>".$member['totals']['Compost (Trainee)']."</td>";
					if ($member['totals']['newMC']){
						$output .="<td>".$member['totals']['diff']."</td>";
					} else {
						$output .="<td>".$member['totals']['Mercer County']."</td>";
					}
					$output .="
							<td>".$member['totals']['Helpline']."</td>
							<td>".$member['totals']['Total']."</td></tr>";
					break;
				case 'Active 1000hrs':
				if (date('Y') < 2018){
					$output .="
						<td>".$member['totals']['Mercer County']."</td>
						<td>".$member['totals']['Continuing Ed']."</td>
						<td>".$member['totals']['Total']."</td></tr>";
				} else {
					$output .="
						<td>".$member['totals']['Mercer County']."</td>
						<td>".$GardenCore."</td>
						<td>".$member['totals']['Continuing Ed']."</td>
						<td>".$member['totals']['Total']."</td></tr>";
				}

					break;
				default:
					# code...
					break;
			}
		}
	return $output;

	}

	function nclist($page=1, $year=2000){
		global $database;
		if ($year<2016){ $year = $this->year;}
		$nc_array = $this->get_list("nclass", "A - Trainee", $page, $year);
		$temp_array= array();
		foreach ($nc_array as $value) {
			$member = new memberObject($value['id']);
			$memberhrs = new memberHrs($value['id']);
			$totals_array = $memberhrs->overallTotal($year);
			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
			if ($member->get_class() == $year){
				$member_array = array(
					'lname'		=>	$member->get_lname(),
					'fname'		=>	$member->get_fname(),
					'class'		=>	$member->get_class(),
					'status'	=>	$member->get_status(),
					'totals'	=>	$totals_array
				);
				array_push($temp_array, $member_array);
			}
		}
		$sql="SELECT COUNT(*) AS totalnum FROM memberinfo WHERE mgstatus = 'A - Trainee' AND class='".$year."'";
		$result_set = $database->query($sql);
		$info = $database->fetch_array($result_set);
		$numarray = $info['totalnum'];
		$last = ceil($numarray/25);
		// $last_array = array(
		// 	'last' => $last
		// );
		$returnArray = array(
			'reportArray'	=> $temp_array,
			'last'		=> $last
		);
		return $returnArray;
	}

	function nclistDownload($year){
			if ($year<2016){ $year = $this->year;}
			$this->set_array();
			$marray = $this->allmem;
			$output = "";
		  $output .= '
				<table class="table" bordered="1">
				<tr>';
			$output .='<th>New Class Report</th></tr>';
			$output .='
				<tr>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Class</th>
					<th>Status</th>
					<th>Helpline/GardenCore</th>
					<th>Compost</th>
					<th>MC & Other</th>
					<th>Total H,C, MC</th>
					<th>Total CE</th>
					<th>Overall Total</th>
				</tr>';
			 for ($counter=0; $counter< count($marray); $counter++) {
				 if (($marray[$counter]['mgstatus']=='A - Trainee') && ($marray[$counter]['class']==$year)){
					 $id = $marray[$counter]['id'];
					$member = new memberObject($id);
		 			$memberhrs = new memberHrs($id);
		 			$totals_array = $memberhrs->overallTotal($year);
		 			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];

					$output .= '
							 <tr>
										<td>'.$member->get_lname().'</td>
										<td>'.$member->get_fname().'</td>
										<td>'.$member->get_class().'</td>
										<td>'.$member->get_status().'</td>
										<td>'.$totals_array["GardenCore"].'</td>
										<td>'.$totals_array["Compost (Trainee)"].'</td>
										<td>'.$totals_array["Mercer County"].'</td>
										<td>'.$totals_array["Total"].'</td>
										<td>'.$totals_array["Continuing Ed"].'</td>
										<td>'.$totals_array["ototal"].'</td>
							 </tr>';
				 }
			 }
		 $output .= '</table>';
		 return $output;
	}

	function slistDownload($year){
		if ($year<2016){ $year = $this->year;}
			$this->set_array();
			$marray = $this->allmem;
			$output = "";
		  $output .= '
				<table class="table" bordered="1">
				<tr>';
			$output .='<th>Summary Report: '.$year.'</th></tr>';
			$output .='
				<tr>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Class</th>
					<th>Status</th>
					<th>Helpline/GardenCore</th>
					<th>MC & Other</th>
					<th>Total H,C, MC</th>
					<th>Total CE</th>
					<th>Overall Total</th>
				</tr>';
			 for ($counter=0; $counter< count($marray); $counter++) {
				$id = $marray[$counter]['id'];
				$member = new memberObject($id);
	 			$memberhrs = new memberHrs($id);
	 			$totals_array = $memberhrs->overallTotal($year);
	 			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
				$output .= '
						 <tr>
									 <td>'.$member->get_lname().'</td>
									 <td>'.$member->get_fname().'</td>
									 <td>'.$member->get_class().'</td>
									 <td>'.$member->get_status().'</td>
									<td>'.$totals_array["GardenCore"].'</td>
									<td>'.$totals_array["Mercer County"].'</td>
									<td>'.$totals_array["Total"].'</td>
									<td>'.$totals_array["Continuing Ed"].'</td>
									<td>'.$totals_array["ototal"].'</td>
						 </tr>';
			 }
		 $output .= '</table>';
		 return $output;
	}

	function slist($page=1, $year, $endlist=false){
		if ($year<2016){ $year = $this->year;}
		if ($endlist){
			$nc_array = $this->get_list("endlist", "full", $page, $year);
		} else {
			$nc_array = $this->get_list("full", "full", $page, $year);
		}

		$temp_array= array();
		foreach ($nc_array as $value) {
			$member = new memberObject($value['id']);
			$memberhrs = new memberHrs($value['id']);
			$totals_array = $memberhrs->overallTotal($year);
			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
			$member_array = array(
				'lname'		=>	$member->get_lname(),
				'fname'		=>	$member->get_fname(),
				'class'		=>	$member->get_class(),
				'status'	=>	$member->get_status(),
				'totals'	=>	$totals_array
			);
			array_push($temp_array, $member_array);
		}
		$last = $this->get_last('full', 'full');
		$lasting = $last['last'];
		$returnArray = array(
			'reportArray'	=> $temp_array,
			'last'		=> $lasting
		);
		return $returnArray;
	}

	function endlist($page=1, $year){
		return $this->slist($page, $year, true);
	}

	function endDownload($year){
		if ($year<2016){ $year = $this->year;}
			$this->set_array();
			$marray = $this->allmem;
			$output = "";
		  $output .= '
				<table class="table" bordered="1">
				<tr>';
			$output .='<th>End of Year Report: '.$year.'</th></tr>';
			$output .='
				<tr>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Class</th>
					<th>Mercer County</th>
					<th>GardenCore</th>
					<th>CE</th>
					<th>Total</th>
					<th>Overall Total</th>
				</tr>';
			 for ($counter=0; $counter< count($marray); $counter++) {
				$id = $marray[$counter]['id'];
				$member = new memberObject($id);
				if ($member->get_mstatus()=='A' || $member->get_mstatus()=='Active 1000hrs') {
					$memberhrs = new memberHrs($id);
		 			$totals_array = $memberhrs->overallTotal($year);
		 			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
					$output .= '
							 <tr>
										 <td>'.$member->get_lname().'</td>
										 <td>'.$member->get_fname().'</td>
										 <td>'.$member->get_class().'</td>
										 <td>'.$totals_array["Mercer County"].'</td>
										<td>'.$totals_array["GardenCore"].'</td>
										<td>'.$totals_array["Continuing Ed"].'</td>
										<td>'.$totals_array["Total"].'</td>
										<td>'.$totals_array["ototal"].'</td>
							 </tr>';
				}
			 }
		 $output .= '</table>';
		 return $output;
	}

	function mlist($milestone='l100', $year){
		if ($year<2016){ $year = $this->year;}
		$this->set_array();
		$returnArray = array();
		foreach ($this->allmem as $value) {
			$memberhrs = new memberHrs($value['id']);
			$totals_array = $memberhrs->overallTotal($year);
			$ototal = $totals_array['Total']+$totals_array['Continuing Ed'];
			$put_in_array = false;
			switch ($milestone) {
				case 'l100':
						$put_in_array = ($ototal < 100);
					break;
				case 'l250':
						$put_in_array = (($ototal >99) && ($ototal <250));
					break;
				case 'l500':
						$put_in_array = ($ototal > 249 && $ototal < 500);
					break;
				case 'l1000':
						$put_in_array = ($ototal > 499 && $ototal < 1000);
					break;
				case 'l2500':
						$put_in_array = ($ototal > 999 && $ototal < 2500);
					break;
				case 'l5000':
						$put_in_array = ($ototal > 2499 && $ototal < 5000);
					break;
				case '5000+':
						$put_in_array = ($ototal > 4999);
					break;
				case 'msAll':
						$put_in_array = true;
					break;
				default:
					break;
			}
			if ($put_in_array){
				$member = new memberObject($value['id']);
				$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
				$member_array = array(
					'lname'		=>	$member->get_lname(),
					'fname'		=>	$member->get_fname(),
					'class'		=>	$member->get_class(),
					'status'	=>	$member->get_status(),

					'ce'			=>	$totals_array['Continuing Ed'],
					// 'ototal'	=>	$ototal
					'ytotal'	=>	$totals_array['Total']
				);
				array_push($returnArray, $member_array);
			}
		}
		function method1($a,$b)
	  {
	    return ($a["ototal"] >= $b["ototal"]) ? -1 : 1;
	  }
  	usort($returnArray, "method1");
		return $returnArray;
	}

	function mlistDownload($value='5000+', $year){
		if ($year<2016){ $year = $this->year;}
		$output = "";
		$output .= '<table class="table" bordered="1">';
		$fulldate = date('F j, Y');
		$output .='<tr><th>'.$year.' Lifetime Milestones Report </th></tr>';
		$output .='<tr><th> Report Date: '.$fulldate.' </th></tr></table>';
			$group_array = $this->mlist($value, $year);
			$group = (string)count($group_array);
			switch ($value) {
				case 'l100':
					$group .= ' Under 100';
					break;
				case 'l250':
					$group .= ' Between 100 & 250';
					break;
				case 'l500':
					$group .= ' Between 250 & 500';
					break;
				case 'l1000':
					$group .= ' Between 500 & 1000';
					break;
				case 'l2500':
					$group .= ' Between 1000 & 2500';
					break;
				case 'l5000':
					$group .= ' Between 2500 & 5000';
					break;
				case '5000+':
					$group .= ' With 5000 Or More';
					break;
				case 'msAll':
					$group .= ' All Members';
					break;
				default:
					break;
			}
			$output .='<table><tr></tr><tr><th>'.$group.' </th></tr>';
			$output .='<tr>
								<th>Last Name</th>
								<th>First Name</th>
								<th>Class</th>
								<th>Status</th>

								<th>Total CE</th>
								<th>Total Volunteer Hrs</th></tr>';
		 for ($counter=0; $counter< count($group_array); $counter++) {
			$output .= '<tr>
								<td>'.$group_array[$counter]['lname'].'</td>
								<td>'.$group_array[$counter]['fname'].'</td>
								<td>'.$group_array[$counter]['class'].'</td>
								<td>'.$group_array[$counter]['status'].'</td>

								<td>'.$group_array[$counter]['ce'].'</td>
								<td>'.$group_array[$counter]['ytotal'].'</td>
					 </tr>';
		 }
		 $output .= '</table>';

	 return $output;
	}

}
?>
