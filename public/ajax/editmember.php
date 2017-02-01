<?php require_once("../../includes/initialize.php");
session_start();

$member_admin = new memadmin();
$params = json_decode(file_get_contents('php://input'),true);
$member_admin->editMember($params['values']);



$data = array(
  'success'=>true
);

echo json_encode($params);





?>
