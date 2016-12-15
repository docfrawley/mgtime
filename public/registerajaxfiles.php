<?php require_once("../includes/initialize.php");
session_start();

$member_admin = new memadmin();
$params = json_decode(file_get_contents('php://input'),true);
  $member = new memberObject($_SESSION['memberid']);
  $member->updateMember($params);
  $data = array(
    'success'=>true
  );







?>
