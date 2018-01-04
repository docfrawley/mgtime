<?

function redirect_to($new_location) {
	$host = $_SERVER['HTTP_HOST'];
	  header("Location: http://$host/hours/public/$new_location");
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
			case 'Active 1000hrs':
				return "Active 1000hrs";
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
			case 'Sustaining':
				return "Sustaining";
					break;
			default:
				break;
		}
	}

  ?>
