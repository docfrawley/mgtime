<?php require_once("../../includes/initialize.php");
session_start();

$member_admin = new memadmin();
$params = json_decode(file_get_contents('php://input'),true);

$nogood = ($params['uname']=='6853' || $params['pword']=='mgnews11');

if ($member_admin->check_username($params['uname']) && !$nogood){
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
