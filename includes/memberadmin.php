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

	function get_last($filter='full', $filterwhich='full'){
		global $database;
		if ($filter=='full'){
			return $this->get_pages();
		} elseif ($filter='class') {
			$sql="SELECT COUNT(*) AS totalnum FROM memberinfo WHERE class = '".$filterwhich."'";
			$result_set = $database->query($sql);
			$value = $database->fetch_array($result_set);
		} else {
			$sql="SELECT COUNT(*) AS totalnum FROM memberinfo WHERE mgstatus = '".$filterwhich."'";
			$result_set = $database->query($sql);
			$value = $database->fetch_array($result_set);
		}
		$temp_array['last']=ceil($value['totalnum']/30);
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

}
?>
