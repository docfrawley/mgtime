<? include_once("initialize.php");
session_start();

class memberObject {

	private $fname;
  private $lname;
  private $email;
  private $pword;
  private $uname;
  private $status;
  private $class;
  private $admin;
	private $memberid;


	function __construct($memberid) {
    global $database;
    $sql="SELECT * FROM memberinfo WHERE id='".$memberid."'";
		$result_set = $database->query($sql);
    $value = $value= $database->fetch_array($result_set);
		$this->fname = $value['fname'];
    $this->lname = $value['lname'];
    $this->email = $value['email'];
    $this->pword = $value['password'];
    $this->uname = $value['username'];
    $this->class = $value['class'];
    $this->status = $value['mgstatus'];
		$this->admin = isset($value['admin_status']) ? $value['admin_status'] : "" ;
		$this->memberid = $memberid;
	}

	function get_fullname(){
    return $this->fname." ".$this->lname;
  }

	function get_fname(){
		return $this->fname;
	}

	function get_lname(){
		return $this->lname;
	}

  function get_status(){
    return $this->status;
  }

  function get_class(){
    return $this->class;
  }

  function get_admin(){
    return $this->admin;
  }

	function get_username(){
    return $this->uname;
  }

	function get_password(){
    return $this->pword;
  }

	function get_email(){
    return $this->email;
  }

	function createLogin($info){
    global $database;
    $sql = "UPDATE memberinfo SET ";
		$sql .= "username='". $info['uname'] ."', ";
		$sql .= "password='". $info['pword'] ."', ";
		$sql .= "email='". $info['email'] ."' ";
		$sql .= "WHERE id='". $this->memberid. "' ";
		$database->query($sql);
  }

	function memberAdmin(){
		return ($this->admin === 'full');
	}

	function hoursAdmin(){
		return ($this->admin === 'full' || $this->admin === 'hours');
	}

}
?>
