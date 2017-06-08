<?php include_once("../includes/initialize.php");
include("../includes/layouts/header.php");

session_start();

// include("../includes/menu.php");
$id = 12;
$amter = new memberHrs($id);

$blah = $amter->get_totalss();
echo json_encode($blah);




?>
