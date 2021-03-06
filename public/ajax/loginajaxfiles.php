<?php require_once("../../includes/initialize.php");
session_start();

$member_admin = new memadmin();
$task=isset($_GET['task']) ? $_GET['task'] : "" ;

if ($task=='lookupMem'){
  $temp_array = $member_admin->lookupMem($_GET['lname']);
  echo json_encode($temp_array);
}

if ($task=='get_everything'){
  $memberhrs = new memberHrs($_SESSION['memberid']);
  $temp_array = $memberhrs->get_everything($_GET['year']);
  echo json_encode($temp_array);
}

if ($task=='deleteMem'){
  $member_admin->deleteMember($_GET['memberid']);
  $data = array(
    'success'=>true
  );
  echo json_encode($data);
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
  $temp_array = $member_admin->get_initial_info();
  echo json_encode($temp_array);
}

if ($task=='memlist'){
  $page = $_GET['page'];
  $filter = $_GET['filter'];
  $filterwhich=$_GET['filterwhich'];
  $temp_array = $member_admin->get_list($filter, $filterwhich, $page);
  echo json_encode($temp_array);
}

if ($task=='hrsadlist'){
  $temp_array = $member_admin->get_hlist();
  echo json_encode($temp_array);
}

if ($task=='hrsmlist'){
  $page = $_GET['page'];
  $year = $_GET['year'];
  $filter = $_GET['filter'];
  $filterwhich = $_GET['filterwhich'];
  $temp_array = $member_admin->get_hrmlist($filter, $filterwhich, $page, $year);
  echo json_encode($temp_array);
}



if ($task=='getLast'){
  $filter = $_GET['filter'];
  $filterwhich=$_GET['filterwhich'];
  $temp_array = $member_admin->get_last($filter, $filterwhich);
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
  $temp_array=array();
  $temp_array['id'] = ($status) ? $_SESSION['memberid'] : 0;
  echo json_encode($temp_array);
}

if ($task=='getinfo'){
  $member = new memberObject($_SESSION['memberid']);
  $returnArray = array(
    "username"    =>  $member->get_username(),
    "password"    =>  $member->get_password(),
    "email"       =>  $member->get_email(),
    "street"      =>  $member->get_street(),
    "town"        =>  $member->get_town(),
    "state"       =>  $member->get_state(),
    "zip"         =>  $member->get_zip(),
    "hphone"      =>  $member->get_hphone(),
    "cphone"      =>  $member->get_cphone(),
    "preferred"   =>  $member->get_preferred()

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
  $returnArray = $member->get_hours($_GET['page']);
  echo json_encode($returnArray);
}

if ($task=='getHlist'){
  $memberID = $_GET['memberID'];
  $year = $_GET['year'];
  $member = new memberHrs($memberID);
  $returnArray = $member->get_hours($_GET['page'], $year);
  echo json_encode($returnArray);
}



if ($task == 'hours_totals'){
  $member = new memberHrs($_SESSION['memberid']);
  $returnArray = $member->get_totalss();
  echo json_encode($returnArray);
}

if ($task == 'hours_pages'){
  $member = new memberHrs($_SESSION['memberid']);
  $returnArray = $member->get_num_pages();
  echo json_encode($returnArray);
}

if ($task == 'overall_totals'){
  $member = new memberHrs($_SESSION['memberid']);
  $returnArray = $member->overallTotal();
  echo json_encode($returnArray);
}

if ($task == 'hours_totals_year'){
  $member = new memberHrs($_SESSION['memberid']);
  $returnArray = $member->get_totalsYear($_GET['year']);
  echo json_encode($returnArray);
}

if ($task == 'check_email'){
  $isThere = $member_admin->check_email($_GET['email']);
  $returnArray = array(
    "success"  => $isThere
  );
  echo json_encode($returnArray);
}

if ($task=='get_numid'){
  $hdate = $_GET['hdate'];
  $numhrs = $_GET['numhrs'];
  $hrstype = $_GET['hrstype'];
  $description = $_GET['description'];
  $member = new memberHrs($_SESSION['memberid']);
  $numid = $member->get_numid($hdate, $numhrs, $hrstype, $description);
  $returnArray = array(
    "numid"=>$numid,
    "hdate"=>$hdate,
    "numhrs"=>$numhrs
  );
  echo json_encode($returnArray);
}

if ($task=='hrsReglist'){
  $all_array = $member_admin->get_total_mgs();
  $reg_array = $member_admin->get_registered();
  $hrs_array = $member_admin->get_entered_hrs();
  $returnArray = array(
      'all' => $all_array,
      'reg' => $reg_array,
      'hrs' => $hrs_array
  );
  echo json_encode($returnArray);
}

if ($task=='hrsNonlist'){
  $returnArray = $member_admin->hrsNonlist();
  echo json_encode($returnArray);
}

if ($task=='getMemInfo'){
  $memberID = $_GET['memberID'];
  $year = $_GET['year'];
  $memberInfo = new memberObject($memberID);
  $memberInfo->set_session();
  $member = new memberHrs($memberID);
  $member_array = array(
    "name"      => $memberInfo->get_fullname(),
    "class"     => $memberInfo->get_class(),
    "mgstatus"  => $memberInfo->get_status(),
    "id"        => $memberID
  );
  // $year = date('Y');
  $annual_array = $member->get_hours(1, $year);
  $total_array = $member->get_totalss($year);
  $historical_array = $member->overallTotal($year);
  $numpages = $member->get_num_pages($year);
  $returnArray = array(
    "minfo"     =>  $member_array,
    "annual"    =>  $annual_array,
    "totals"    =>  $total_array,
    "historical" =>  $historical_array,
    "numpages"  =>  $numpages
  );
  echo json_encode($returnArray);
}

if ($task == 'getWhatUndo'){
  // $numid = $_GET['numid'];
  $entry = new hrsObject($_GET['numid']);
  $returnArray = $entry->undoInfo();
  echo json_encode($returnArray);
}

if ($task == 'rlist'){
  $whichlist = $_GET['report'];
  $year = $_GET['year'];
  $page = $_GET['page'];
  $member_admin = new memadmin();
  switch ($whichlist) {
    case 'nclist':
      $returnArray =$member_admin->nclist($page, $year);
      break;
    case 'mlist':
      $returnArray =$member_admin->mlist($page, $year);
      break;
    case 'slist':
      $returnArray =$member_admin->slist($page, $year);
      break;
    case 'rdlist':
      $returnArray =$member_admin->rdlist($page, $year);
      break;
    case 'endlist':
      $returnArray =$member_admin->endlist($page, $year);
      break;
    default:
      break;
  }
  echo json_encode($returnArray);
}



?>
