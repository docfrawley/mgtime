<?php require_once("../../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);

list($month, $day, $year) = explode("/", $params['hdate']);
$themonth = intval($month);
$theday = intval($day);
$theyear = intval($year);
$date = mktime(0,0,0,$themonth,$theday,$theyear);

$thisYear = date('Y');
$yearlyCutoff = mktime(23,59,59,1,15,$thisYear);

$previousYear = false;
$dateObject = new DateTime();
$secondDate = new DateTime("now");
$dateObject = $dateObject->sub( new DateInterval('P91D'));
$dateCompare = new DateTime($params['hdate']);

$goodToEnter = ($dateObject < $dateCompare && $secondDate > $dateCompare);

if ($goodToEnter){
  if ($secondDate->getTimestamp() > $yearlyCutoff){
    $goodToEnter = ($theyear == $thisYear);
    if (!$goodToEnter){
      $previousYear = true;
    }
  }
}


  if ($goodToEnter){
    $memberhrs = new memberHrs($_SESSION['memberid']);
    $memberhrs->enter_hours($params);
    $data = array(
      'success'=>true
    );
  } else {
    $data = array(
      'success'=>false,
      'previousYear'=>$previousYear
    );
  }






echo json_encode($data);




?>
