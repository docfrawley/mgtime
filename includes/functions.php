<?
session_start();
function redirect_to($new_location) {
	$host = $_SERVER['HTTP_HOST'];
	  header("Location: http://$host/mgtime/public/$new_location");
	  exit;
	}

  ?>
