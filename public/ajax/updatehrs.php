<?php require_once("../../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);
$id = $params['numid'];
  $memberhrs = new hrsObject($id);
  $memberhrs->update_hours($params);
  $data = array(
    'success'=>true
  );





echo json_encode($data);




?>