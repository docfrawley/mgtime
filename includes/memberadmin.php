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

	function get_list($page=1){
		$start = $page*20-20;
		$temp_array = [];
		for ($counter=$start; $counter< $page*20; $counter++) {
			$next_array = [];
			$member = new memberObject($this->allmem[$counter]['id']);
					$next_array['fname']= $member->get_fname();
					$next_array['lname']= $member->get_lname();
					$next_array['email']= $member->get_email();
					$next_array['status']= $member->get_status();
					$next_array['class']= $member->get_class();
					$next_array['admin']= $member->get_admin();
					$next_array['memberid']= $this->allmem[$counter]['id'];
					array_push($temp_array, $next_array);
		}
		return $temp_array;
	}

	function set_array(){
		global $database;
		$this->allmem = array();
    $sql="SELECT * FROM memberinfo ORDER BY lname";
		$result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			array_push($this->allmem, $value['id']);
		}
	}

	function get_pages(){
		$this->set_array();
		$temp_array = array();
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
