<?php require_once("../../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);
$hrsInfo = new hrsObject($params['hrsid']);
$hrsInfo->delete_hoursAdmin($params);
  $data = array(
    'success'=>$params
  );

echo json_encode($data);

?>
