<? include_once("initialize.php");
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
		$sql .= "class='". $info['aclass'] ."', ";
		$sql .= "mgstatus='". $info['mgstatus'] ."', ";
		$sql .= "admin_status='". $info['adstatus'] ."' ";
		$sql .= "WHERE id='". $info['id']. "' ";
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
      $_SESSION['loginid'] = $value['id'];
      $_SESSION['memberid'] = $value['id'];
      $this->member = $value['id'];
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
			array_push($temp_array, $value);
		}
		return $temp_array;
	}

	function get_list($page=1){
		$this->set_array();
		$start = $page*20-20;
		$temp_array = [];
		for ($counter=$start; $counter< $page*20 && $counter<count($this->allmem); $counter++) {
			array_push($temp_array, $this->allmem[$counter]);
		}
		return $temp_array;
	}

	function set_array(){
		global $database;
		$this->allmem = array();
    $sql="SELECT * FROM memberinfo ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			array_push($this->allmem, $value);
		}
	}

	function get_pages(){
		$this->set_array();
		$temp_array = [];
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

  function get_memberid(){
		$temp_array = array();
		$temp_array['id']=$this->member;
    return $temp_array;
  }

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
		$_SESSION['newUser'] = true;
  }

}
?>
