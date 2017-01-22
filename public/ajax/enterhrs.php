<?php require_once("../../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);

$dateObject = new DateTime();
$secondDate = new DateTime("now");
$dateObject = $dateObject->sub( new DateInterval('P91D'));
$dateCompare = new DateTime($params['hdate']);
  if ($dateObject < $dateCompare && $secondDate > $dateCompare){
    $memberhrs = new memberHrs($_SESSION['memberid']);
    $memberhrs->enter_hours($params);
    $data = array(
      'success'=>true
    );
  } else {
    $data = array(
      'success'=>false
    );
  }






echo json_encode($data);




?>
