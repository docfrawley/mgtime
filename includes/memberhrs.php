<? include_once("initialize.php");
session_start();

class memberHrs {

	private $memhrs;
	private $memberid;

	function __construct($id) {
    $this->memhrs =  array();
		$this->memberid = $id;
	}

	function num_entries(){
		global $database;
		$temp = 0;
		$sql="SELECT * FROM hours WHERE memberid='".$this->memberid."'";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$temp++;
		}
		return $temp;
	}

	function set_hrs($year=2000){
		global $database;
		if ($year=2000) {$year=date("Y");}
    $hrs_array =  array();
    $sql="SELECT * FROM hours WHERE memberid='".$this->memberid."' ORDER BY hdate DESC";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
      $hrsobject = new hrsObject($value['numid']);
			$whatYear = date('Y', $hrsobject->get_date());
			if ($year == $whatYear){
				$temp_array = $hrsobject->set_in_array();
				array_push($hrs_array, $temp_array);
			}
		}
		return $hrs_array;
	}

  function enter_hours($info){
    global $database;
		list($month, $day, $year) = explode("/", $info['hdate']);
		$themonth = intval($month);
		$theday = intval($day);
		$theyear = intval($year);
		$date = mktime(0,0,0,$themonth,$theday,$theyear);
		$info['hdate'] = $date;
    $sql = "INSERT INTO hours (";
	  	$sql .= "memberid, hdate, hrstype, numhrs, description";
	  	$sql .= ") VALUES ('";
	  	$sql .= $this->memberid ."', '";
	  	$sql .= $database->escape_value($info['hdate']) ."', '";
      $sql .= $database->escape_value($info['hrstype']) ."', '";
      $sql .= $database->escape_value($info['numhrs']) ."', '";
		  $sql .= $database->escape_value($info['description']) ."')";
		$database->query($sql);
  }

	function delete_hrs($numid){
		global $database;
		$sql = "DELETE FROM hours ";
	  	$sql .= "WHERE numid=". $numid;
	  	$sql .= " LIMIT 1";
	 	$database->query($sql);
	}

	function get_num_pages(){
		$the_array = $this->set_hrs();
		$numarray = count($the_array);
		$temp_array = array();
		$temp_array['entries'] = $numarray;
		$temp_array['last']=ceil($numarray/20);
		return $temp_array;
	}

	function get_hours($page=1){
		$first_array = $this->set_hrs();
		$index = 20;
		$start = $page*$index-$index;
		$temp_array = array();
		for ($counter=$start; $counter< $page*$index && $counter<count($first_array); $counter++) {
			array_push($temp_array, $first_array[$counter]);
		}
		return $temp_array;
	}

	function get_hours_month($whichMonth, $year){
		global $database;
    $month_array =  array(
			"Mercer County" 					=> 0,
			"Helpline" 								=> 0,
			"Continuing Ed" 					=> 0,
			"Compost (Trainee)" 			=> 0,
			"Other (Trainee)"   			=> 0,
			"Total"										=> 0
		);
		$date_range1 = mktime(0,0,0,$whichMonth,1,$year);
		$num_days = cal_days_in_month(CAL_GREGORIAN, $whichMonth , $year );
		$date_range2 = mktime(23,59,59,$whichMonth,$num_days,$year);
    $sql="SELECT * FROM hours WHERE memberid='".$this->memberid."'
		AND hdate>= '".$date_range1."' AND hdate <='".$date_range2."'
		ORDER BY hdate";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			if ($value['chstatus'] !='d'){
				$key = $value['hrstype'];
				$month_array[$key] += $value['numhrs'];
				if($key !="Continuing Ed"){
					$month_array['Total'] +=$value['numhrs'];
				}
			}
		}
		return $month_array;
	}

	function get_totalss($year=2000){
		if ($year=2000){$year=date('Y');}
		$totals_array = $this->set_hrs($year);
		$months_array = array();
		for ($month=1; $month<=12; $month++){
			array_push($months_array, $this->get_hours_month($month, $year));
		}
		$total_array =  array(
			"Mercer County" 					=> 0,
			"Helpline" 								=> 0,
			"Continuing Ed" 					=> 0,
			"Compost (Trainee)"				=> 0,
			"Other (Trainee)"					=> 0,
			"Total"										=> 0
		);

		for ($i = 0; $i < count($totals_array); $i++) {
			$key=$totals_array[$i]['hrstype'];
			if ($totals_array[$i]['chstatus'] !='d'){
				$total_array[$key] += $totals_array[$i]['numhrs'];
				$total_array['Total'] += $totals_array[$i]['numhrs'];
			}
		}
		$total_array['Total']=$total_array['Total']-$total_array['Continuing Ed'];
		array_push($months_array, $total_array);
	return $months_array;
}


	function get_totals(){
		$totals_array = $this->set_hrs();
		$months_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$current_month=12;
		$total = 0;
		for ($i = 0; $i < count($totals_array); $i++) {
			$date = date('m/d/Y',$totals_array[$i]['hdate']);
			list($mon, $day, $year) = explode("/", $date);
			if ($year == date('Y')) {
				$month = (int)$mon;
				if ($month<$current_month){
					$current_month = $month;
				}
				$months_array[$current_month] += $totals_array[$i]['numhrs'];
				$total += $totals_array[$i]['numhrs'];
			}
		}
		array_push($months_array, $total);
		return $months_array;
	}

	function overallTotal(){
		global $database;
		$total_array =  array(
			"Mercer County" 					=> 0.0,
			"Helpline" 								=> 0.0,
			"Continuing Ed" 					=> 0.0,
			"Compost (Trainee)"				=> 0.0,
			"Total"										=> 0.0
		);
		$sql="SELECT * FROM pretotals WHERE id='".$this->memberid."'";
    $result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
		if ($value['mercer'] != null){
			$total_array['Mercer County'] = $value['mercer'];
		}
		if ($value['conted'] != null){
			$total_array['Continuing Ed'] = $value['conted'];
		}

    $sql="SELECT * FROM hours WHERE memberid='".$this->memberid."' ORDER BY hdate ASC";
    $result_set = $database->query($sql);
		$year = 2017;
		$ceTotal = 0.0;
		while ($value = $database->fetch_array($result_set)) {
			if ($value['chstatus']!='d'){
				switch ($value['hrstype']) {
					case "Mercer County":
						$total_array['Mercer County'] += $value['numhrs'];
						break;
					case "Helpline":
						$total_array['Helpline'] += $value['numhrs'];
						break;
					case "Compost (Trainee)":
						$total_array['Compost (Trainee)'] += $value['numhrs'];
						break;
					case "Continuing Ed":
						$total_array['Continuing Ed'] += $value['numhrs'];;
						break;
					default:
						break;
				}
			}
		}
		// if ($ceTotal > 10.0){
		// 	$total_array['Continuing Ed'] += 10;
		// } else{
		// 	$total_array['Continuing Ed'] += $ceTotal;
		// }
		$total_array['Total'] = $total_array['Mercer County'] + $total_array['Helpline']+$total_array['Compost (Trainee)'];
		return $total_array;
	}

	function get_numid($hdate, $numhrs, $hrstype, $description){
		global $database;
		list($month, $day, $year) = explode("/", $hdate);
		$themonth = intval($month);
		$theday = intval($day);
		$theyear = intval($year);
		$date = mktime(0,0,0,$themonth,$theday,$theyear);
		$hdate = $date;
		$sql="SELECT * FROM hours WHERE
		memberid ='".$this->memberid."' AND
		hdate = '".$hdate."' AND
		hrstype ='".$hrstype."' AND
		numhrs ='".$numhrs."'AND
		description ='".$description."'";
    $result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
		$temp = $value['numid'];
		return $temp;
	}

	// function undoInfo($year=2000){
	// 	global $database;
	// 	$hrs_array = $this->set_hrs($year);
	// 	$changeArray = array();
	// 	$changeFromArray = array();
	// 	$deleteArray = array();
	// 	foreach ($hrs_array as $value) {
	// 		if ($value['chstatus']=='c' || $value['chstatus']=='d'){
	// 			$the_date = date('m/d/Y', $value['chdate']);
	// 			$value['chdate']=$the_date;
	// 			if ($value['chstatus']=='c'){
	// 				array_push($changeArray, $value);
	// 				$id = $value['numid'];
	// 				$sql="SELECT * FROM orghours WHERE numid='".$id."'";
	// 		    $result_set = $database->query($sql);
	// 				$valueFrom = $database->fetch_array($result_set);
	// 				$holder_array = array();
	// 				if ($value['hrstype'] != $valueFrom['hrstype']){
	// 					$temp_array=array(
	// 						"type" 	=> "hrstype",
	// 						"from" 	=> $valueFrom['hrstype'],
	// 						"to"		=> $value['hrstype']
	// 					);
	// 					array_push($holder_array, $temp_array);
	// 				}
	// 				if ($value['numhrs'] != $valueFrom['numhrs']){
	// 					$temp_array=array(
	// 						"type" 	=> "numhrs",
	// 						"from" 	=> $valueFrom['numhrs'],
	// 						"to"		=> $value['numhrs']
	// 					);
	// 					array_push($holder_array, $temp_array);
	// 				}
	// 				if ($value['description'] != $valueFrom['description']){
	// 					$temp_array=array(
	// 						"type" 	=> "description",
	// 						"from" 	=> $valueFrom['description'],
	// 						"to"		=> $value['description']
	// 					);
	// 					array_push($holder_array, $temp_array);
	// 				}
	// 				array_push($changeFromArray, $holder_array);
	// 			} else {
	// 				array_push($deleteArray, $value);
	// 			}
	// 			$returnArray = array(
	// 				"the_change"  => $changeArray,
	// 				"change_from" => $changeFromArray,
	// 				"the_delete"	=> $deleteArray
	// 			);
	// 			array_push($returnArray, $value);
	// 		}
	// 	}
	// 	return $returnArray;
	// }

}
?>
