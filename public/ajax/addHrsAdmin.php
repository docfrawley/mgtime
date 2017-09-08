<?php require_once("../../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);

$memberid = $params['id'];
$memberhrs = new memberHrs($memberid);
$memberhrs->enter_hoursAdmin($params);
$data = array(
  'success'=>$params
);
echo json_encode($data);

?>
