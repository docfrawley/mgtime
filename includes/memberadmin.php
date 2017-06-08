<? include_once("initialize.php");
require_once 'vendor/autoload.php';
session_start();

class memadmin {

	private $allmem;
  private $username;
  private $password;
  private $member;


	function __construct() {
		$this->allmem = array();
    $this->username = "";
    $this->password = "";
    $this->member = "";
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
    $sql = "INSERT INTO memberinfo (";
	  	$sql .= "lname, fname, class, mgstatus, admin_status";
	  	$sql .= ") VALUES ('";
	  	$sql .= $database->escape_value($info['lname']) ."', '";
      $sql .= $database->escape_value($info['fname']) ."', '";
      $sql .= $database->escape_value($info['aclass']) ."', '";
			$sql .= $database->escape_value($info['mgstatus']) ."', '";
		  $sql .= $database->escape_value($info['adstatus']) ."')";
		$database->query($sql);
	}

	function editMember($info){
		global $database;
		if ($info['adstatus']=="non") {$info['adstatus']="";}
    $sql = "UPDATE memberinfo SET ";
		$sql .= "fname='". $info['fname'] ."', ";
		$sql .= "lname='". $info['lname'] ."', ";
		$sql .= "class='". $info['class'] ."', ";
		$sql .= "mgstatus='". $info['mgstatus'] ."', ";
		$sql .= "admin_status='". $info['admin_status'] ."' ";
		$sql .= "WHERE id='". $info['id']. "' ";
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
		$sql = "DELETE FROM memberinfo ";
	  	$sql .= "WHERE id=". $memberid;
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

	function get_flist(){
		global $database;
		$temp_array = array();
    $sql="SELECT * FROM memberinfo WHERE admin_status='full' ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			//$t_array = change_status($value);
			array_push($temp_array, $value);
		}
		return $temp_array;
	}

	function get_hlist(){
		global $database;
		$temp_array = array();
    $sql="SELECT * FROM memberinfo WHERE admin_status='hours' ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
		//	$t_array = change_status($value);
			array_push($temp_array, $value);
		}
		return $temp_array;
	}

	function get_list($filter='full', $filterwhich='full', $page=1){
		global $database;
		$temp_array = [];
		if ($filter=='full'){
			$this->set_array();
			$first_array = $this->allmem;
			$index = 20;
		} else{
			if ($filter=='class'){
				$sql="SELECT * FROM memberinfo WHERE class = '".$filterwhich."' ORDER BY lname";
			} else {
				$sql="SELECT * FROM memberinfo WHERE mgstatus = '".$filterwhich."' ORDER BY lname";
			}
			$index = 25;
			$first_array = [];
			$result_set = $database->query($sql);
			while ($value = $database->fetch_array($result_set)) {
				array_push($first_array, $value);
			}
		}
		$start = $page*$index-$index;
		for ($counter=$start; $counter< $page*$index && $counter<count($first_array); $counter++) {
			array_push($temp_array, $first_array[$counter]);
		}
		return $temp_array;
	}

	function get_hrmlist($filter='full', $filterwhich='full', $page=1){
		$initial_array = $this->get_list($filter, $filterwhich, $page);
		$temp_array = array();
		foreach ($initial_array as $value) {
			$member = new memberHrs($value['id']);
			$hours = $member->get_totalss();
			$total = $member->overallTotal();
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
			array_push($temp_array, $value);
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

	function rdlist($page){
		$this->set_array();
		$marray = $this->allmem;
		$temp_array = array();
		$year = date('Y');
		for ($counter=0; $counter< count($marray); $counter++) {
			if ($marray[$counter]['mgstatus']==$page){
				$id = $marray[$counter]['id'];
				$not_below = false;
			 	$member = new memberObject($id);
			 	$memberhrs = new memberHrs($id);
				$t_array = $memberhrs->get_totalss();
			 	$totals_array = $t_array[12];
				switch ($page) {
					case 'A - Trainee':
							$not_below =  ( $marray[$counter]['class']==$year &&
									($totals_array['Mercer County']<25 ||
									$totals_array['Helpline']<30
									|| $totals_array['Compost (Trainee)']<5 ));
						break;
					case 'A':
							$not_below = ($totals_array['Mercer County']<15 || $totals_array['Helpline']<15
									|| $totals_array['Continuing Ed']<10 );
						break;
					case 'Active 1000hrs':
							$not_below = ($totals_array['Mercer County']<25
									|| $totals_array['Continuing Ed']<10 );
						break;
					default:
						break;
				}
				if ($not_below){
					$member_array = array(
						'name'		=>	$member->get_fullname(),
						'class'		=>	$member->get_class(),
						'totals'	=>	$totals_array
					);
					array_push($temp_array, $member_array);
				}
			}
		}
		return $temp_array;
	}

	function nclist($page=1){
		global $database;
		$nc_array = $this->get_list("nclass", "A - Trainee", $page);
		$temp_array= array();
		foreach ($nc_array as $value) {
			$member = new memberObject($value['id']);
			$memberhrs = new memberHrs($value['id']);
			$totals_array = $memberhrs->overallTotal();
			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
			$year = date('Y');
			if ($member->get_class() == $year){
				$member_array = array(
					'name'		=>	$member->get_fullname(),
					'class'		=>	$member->get_class(),
					'totals'	=>	$totals_array
				);
				array_push($temp_array, $member_array);
			}
		}
		$year = date("Y");
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

	function nclistDownload(){
			$this->set_array();
			$marray = $this->allmem;
			$output = "";
		  $output .= '
				<table class="table" bordered="1">
				<tr>';
			$output .='<th>New Class Report</th></tr>';
			$output .='
				<tr>
					<th>Name</th>
					<th>Class</th>
					<th>Helpline</th>
					<th>Compost</th>
					<th>MC & Other</th>
					<th>Total H,C, MC</th>
					<th>Total CE</th>
					<th>Overall Total</th>
				</tr>';
			$year = 2017;
			 for ($counter=0; $counter< count($marray); $counter++) {
				 if (($marray[$counter]['mgstatus']=='A - Trainee') && ($marray[$counter]['class']==2017)){
					 $id = $marray[$counter]['id'];
					$member = new memberObject($id);
		 			$memberhrs = new memberHrs($id);
		 			$totals_array = $memberhrs->overallTotal();
		 			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];

					$output .= '
							 <tr>
										<td>'.$member->get_fullname().'</td>
										<td>'.$member->get_class().'</td>
										<td>'.$totals_array["Helpline"].'</td>
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

	function slistDownload(){
			$this->set_array();
			$marray = $this->allmem;
			$output = "";
		  $output .= '
				<table class="table" bordered="1">
				<tr>';
			$output .='<th>Summary Report</th></tr>';
			$output .='
				<tr>
					<th>Name</th>
					<th>Class</th>
					<th>Helpline</th>
					<th>MC & Other</th>
					<th>Total H,C, MC</th>
					<th>Total CE</th>
					<th>Overall Total</th>
				</tr>';
			$year = 2017;
			 for ($counter=0; $counter< count($marray); $counter++) {
				$id = $marray[$counter]['id'];
				$member = new memberObject($id);
	 			$memberhrs = new memberHrs($id);
	 			$totals_array = $memberhrs->overallTotal();
	 			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
				$output .= '
						 <tr>
									<td>'.$member->get_fullname().'</td>
									<td>'.$member->get_class().'</td>
									<td>'.$totals_array["Helpline"].'</td>
									<td>'.$totals_array["Mercer County"].'</td>
									<td>'.$totals_array["Total"].'</td>
									<td>'.$totals_array["Continuing Ed"].'</td>
									<td>'.$totals_array["ototal"].'</td>
						 </tr>';
			 }
		 $output .= '</table>';
		 return $output;
	}

	function slist($page=1){
		$nc_array = $this->get_list("full", "full", $page);
		$temp_array= array();
		foreach ($nc_array as $value) {
			$member = new memberObject($value['id']);
			$memberhrs = new memberHrs($value['id']);
			$totals_array = $memberhrs->overallTotal();
			$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
			$member_array = array(
				'name'		=>	$member->get_fullname(),
				'class'		=>	$member->get_class(),
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

	function mlist($milestone='l100'){
		$this->set_array();
		$returnArray = array();
		foreach ($this->allmem as $value) {
			$memberhrs = new memberHrs($value['id']);
			$totals_array = $memberhrs->overallTotal();
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
				default:
					break;
			}
			if ($put_in_array){
				$member = new memberObject($value['id']);
				$totals_array['ototal'] = $totals_array['Total']+$totals_array['Continuing Ed'];
				$member_array = array(
					'name'		=>	$member->get_fullname(),
					'class'		=>	$member->get_class(),
					'ytotal'	=>	$totals_array['Total'],
					'ototal'	=>	$ototal
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

	function mlistDownload($value='5000+'){
		$output = "";
		$output .= '<table class="table" bordered="1">';
		$year = date('Y');
		$fulldate = date('F j, Y');
		$output .='<tr><th>'.$year.' Lifetime Milestones Report </th></tr>';
		$output .='<tr><th> Report Date: '.$fulldate.' </th></tr></table>';
			$group_array = $this->mlist($value);
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
				default:
					break;
			}
			$output .='<table><tr></tr><tr><th>'.$group.' </th></tr>';
			$output .='<tr><th>Name</th><th>Class</th><th>'.$year.'</th><th>Historical</th></tr>';
		 for ($counter=0; $counter< count($group_array); $counter++) {
			$output .= '<tr><td>'.$group_array[$counter]['name'].'</td>
								<td>'.$group_array[$counter]['class'].'</td>
								<td>'.$group_array[$counter]['ytotal'].'</td>
								<td>'.$group_array[$counter]['ototal'].'</td>
					 </tr>';
		 }
		 $output .= '</table>';

	 return $output;
	}

}
?>
