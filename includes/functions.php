<?

function redirect_to($new_location) {
	$host = $_SERVER['HTTP_HOST'];
	  header("Location: http://$host/mgtime/public/$new_location");
	  exit;
	}

function change_status($info){
	switch ($info) {
		case 'A':
			return "Active";
			break;
		case 'A - Trainee':
			return "Active Trainee";
			break;
		case 'E':
			return "Emeritus";
			break;
		case 'IA':
			return "Inactive";
			break;
		case 'T/NotG':
			return "Trainee - Did Not Graduate";
			break;
		default:
			break;
	}
}

  ?>
