<?php require_once("../../includes/initialize.php");
session_start();

$params = json_decode(file_get_contents('php://input'),true);
$hrsid = $params['hrsid'];
$hrsInfo = new hrsObject($params['hrsid']);
$hrsInfo->update_hoursAdmin($params);
  $data = array(
    'success'=>$params
  );

echo json_encode($data);

?>
