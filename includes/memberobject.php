<? include_once("initialize.php");
require_once 'vendor/autoload.php';
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
		$this->checkStatus();
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

	function set_session(){
		$_SESSION['member'] = $this->memberid;
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

	function check_full(){
		return ($this->admin === 'full');
	}

	function check_hrs(){
		return ($this->admin === 'full' || $this->admin === 'hours');
	}

	function have_registered(){
		return ($this->uname != "" && $this->pword != "");
	}

	function isTrainee(){
		return ($this->status=="A - Trainee" || $this->status=="T/NotG");
	}

	function checkStatus(){
		global $database;
		$memberhrs = new memberHrs($this->memberid);
		$total_array = $memberhrs->overallTotal();
		if (($total_array['Total'] ==1000 || $total_array['Total'] > 1000)
					&& $this->status != "Active 1000hrs"){

						$sql = "UPDATE memberinfo SET ";
						$sql .= "mgstatus='Active 1000hrs' ";
						$sql .= "WHERE id='". $this->memberid. "' ";
						$database->query($sql);
						$this->status = 'Active 1000hrs';
						$m = new PHPMailer;
						$m->From = ($this->email);
						$m->FromName = ($this->get_fullname());
						$m->addReplyTo($this->email, "Reply Address");
						$m->Subject = "Master Gardeners, Reached 1000hrs ";
						$m->Body = $this->get_fullname()." has reached 1000hrs.";
						$m->addAddress('hours@mgofmc.org');
						$m->send();

		}
		if ($total_array['Total'] < 1000 && $this->status == "Active 1000hrs"){

						$sql = "UPDATE memberinfo SET ";
						$sql .= "mgstatus='A' ";
						$sql .= "WHERE id='". $this->memberid. "' ";
						$database->query($sql);
						$this->status = 'A';
		}
	}

}
?>
