<?php require_once("../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);

  $memberhrs = new memberHrs($_SESSION['memberid']);
  $memberhrs->enter_hours($params);
  $data = array(
    'success'=>true
  );





echo json_encode($data);




?>
