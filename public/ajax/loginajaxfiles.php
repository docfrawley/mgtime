<?php require_once("../../includes/initialize.php");
session_start();

$member_admin = new memadmin();
$task=isset($_GET['task']) ? $_GET['task'] : "" ;

if ($task=='lookupMem'){
  $temp_array = $member_admin->lookupMem($_GET['lname']);
  echo json_encode($temp_array);
}

if ($task=='flist'){
  $temp_array = $member_admin->get_flist();
  echo json_encode($temp_array);
}

if ($task=='hlist'){
  $temp_array = $member_admin->get_hlist();
  echo json_encode($temp_array);
}

if ($task=='initial_info'){
  $temp_array = $member_admin->get_pages();
  echo json_encode($temp_array);
}

if ($task=='memlist'){
  $page = $_GET['page'];
  $temp_array = $member_admin->get_list($page);
  echo json_encode($temp_array);
}

if ($task=='deletehrs'){
  $numid = $_GET['numid'];
  $memberhrs = new memberHrs($_SESSION['memberid']);
  $memberhrs->delete_hrs($numid);
  $data = array(
    'success'=>true
  );
  echo json_encode($data);
}

if ($task=='check'){
  $fname=$_GET['fname'];
  $lname = $_GET['lname'];
  $year = $_GET['year'];
  $temp_array=array();
  $status = $member_admin->checkMember($fname, $lname, $year);
    if ($status){
      $memberCheck = new memberObject($_SESSION['memberid']);
      $rstatus = $memberCheck->have_registered();
      if ($rstatus){
        $temp_array['id']=-1;
      } else {
        $temp_array['id']=$_SESSION['memberid'];
      }
    } else {
      $temp_array['id']=0;
    }
  echo json_encode($temp_array);
}

if ($task=='login'){
  $uname=$_GET['uname'];
  $pword = $_GET['pword'];
  $status = $member_admin->checkLogin($uname, $pword);
    if ($status){
      $memberid = $member_admin->get_memberid();
      echo json_encode($memberid);
    } else {
      $temp_array=array();
      $temp_array['id']=0;
      echo json_encode($temp_array);
    }
}

if ($task=='getinfo'){
  $member = new memberObject($_SESSION['memberid']);
  $returnArray = array(
    "username"  => $member->get_username(),
    "password"  => $member->get_password(),
    "email"     =>  $member->get_email()
  );
  echo json_encode($returnArray);
}

if ($task=='get_status'){
  $member = new memberObject($_SESSION['memberid']);
  $returnArray = array(
    "mgstatus"  => $member->get_status()
  );
  echo json_encode($returnArray);
}

if ($task=='hours_info'){
  $member = new memberHrs($_SESSION['memberid']);
  $returnArray = $member->get_hours();
  echo json_encode($returnArray);
}

if ($task == 'hours_totals'){
  $member = new memberHrs($_SESSION['memberid']);
  $returnArray = $member->get_totalss();
  echo json_encode($returnArray);
}
?>
