<? include_once("initialize.php");
session_start();

class memberHrs {

	private $memhrs;
	private $memberid;

	function __construct($id) {
    $this->memhrs =  array();
		$this->memberid = $id;
	}

	function setDates(){
		global $database;
		$temp_array = array();
		$sql="SELECT * FROM hours WHERE memberid='".$this->memberid."'";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			list($month, $day, $year) = explode("/", $value['hdate']);
			$themonth = intval($month);
			$theday = intval($day);
			$theyear = intval($year);
			$date = mktime(0,0,0,$themonth,$theday,$theyear);
			$value['hdate'] = $date;
			array_push($temp_array, $value);
		}

		for ($x=0;$x<count($temp_array); $x++){
			$sqld = "UPDATE hours SET ";
			$sqld .= "hdate='". $temp_array[$x]['hdate'] ."' ";
			$sqld .= "WHERE numid='". $temp_array[$x]['numid']. "' ";
			$database->query($sqld);
		}
	}

	function set_hrs($year=2000){
		global $database;
		if ($year=2000) {$year=date("Y");}
    $this->memhrs =  array();
    $sql="SELECT * FROM hours WHERE memberid='".$this->memberid."' ORDER BY hdate ASC";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
      $hrsobject = new hrsObject($value['numid']);
			$whatYear = date('Y', $hrsobject->get_date());
			if ($year == $whatYear){
				$temp_array = $hrsobject->set_in_array();
				array_push($this->memhrs, $temp_array);
			}
		}
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

	function get_hours(){
		$this->set_hrs();
		return $this->memhrs;
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
		$date_range2 = mktime(23,59,59,$whichMonth,31,$year);
    $sql="SELECT * FROM hours WHERE memberid='".$this->memberid."'
		AND hdate>= '".$date_range1."' AND hdate <='".$date_range2."'
		ORDER BY hdate";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
			$key = $value['hrstype'];
			$month_array[$key] += $value['numhrs'];
			$month_array['Total'] +=$value['numhrs'];
		}
		return $month_array;
	}

	function get_totalss($year=2000){
		if ($year=2000){$year=date('Y');}
		$this->set_hrs($year);
		$months_array = array();
		for ($month=1; $month<=12; $month++){
			array_push($months_array, $this->get_hours_month($month, $year));
		}
		$total_array =  array(
			"Mercer County" 					=> 0,
			"Helpline" 								=> 0,
			"Continuing Ed" 					=> 0,
			"Compost (Trainee)" 			=> 0,
			"Other (Trainee)"   			=> 0,
			"Total"										=> 0
		);

		for ($i = 0; $i < count($this->memhrs); $i++) {
			$key=$this->memhrs[$i]['hrstype'];
			$total_array[$key] += $this->memhrs[$i]['numhrs'];
			$total_array['Total'] += $this->memhrs[$i]['numhrs'];
		}
		$total_array['Total']=$total_array['Total']-$total_array['Continuing Ed'];
		array_push($months_array, $total_array);
	return $months_array;
}


	function get_totals(){
		$this->set_hrs();
		$months_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$current_month=0;
		$total = 0;
		for ($i = 0; $i < count($this->memhrs); $i++) {
			$date = date('m/d/Y',$this->memhrs[$i]['hdate']);
			list($month, $day, $year) = explode("/", $date);
			if ($year == date('Y')) {
				if ($month>($current_month+1)){
					$current_month = $month-1;
				}
				$months_array[$current_month] += $this->memhrs[$i]['numhrs'];
				$total += $this->memhrs[$i]['numhrs'];
			}
		}
		array_push($months_array, $total);
		return $months_array;
	}

	function get_totalsYear($year){

	}
}
?>
