<?


function change_status($info){
	switch ($info['mgstatus']) {
		case 'A':
			$info['mgstatus']="Active";
			break;
		case 'A-Trainee':
			$info['mgstatus']="Active Trainee";
			break;
		case 'E':
			$info['mgstatus']="Emeritus";
			break;
		case 'IA':
			$info['mgstatus']="Inactive";
			break;
		case 'T/NotG':
			$info['mgstatus']="Trainee - Did Not Graduate";
			break;
		default:
			break;
	}
	return $info;
}

  ?>
