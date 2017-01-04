<?php require_once("../../includes/initialize.php");
session_start();

$member_admin = new memadmin();
$params = json_decode(file_get_contents('php://input'),true);

if ($member_admin->check_username($params['uname'])){
  $member_admin->createLogin($params);
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
