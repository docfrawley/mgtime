<?
function redirect_to($new_location) {
	$host = $_SERVER['HTTP_HOST'];
	  header("Location: http://$host/betanced/public/$new_location");
	  exit;
	}

  ?>
