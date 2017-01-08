<? include_once("initialize.php");
session_start();

class memberHrs {

	private $memhrs;
	private $memberid;

	function __construct($id) {
    $this->memhrs =  array();
		$this->memberid = $id;
	}

	function set_hrs(){
		global $database;
    $this->memhrs =  array();
    $sql="SELECT * FROM hours WHERE memberid='".$this->memberid."' ORDER BY hdate";
    $result_set = $database->query($sql);
		while ($value = $database->fetch_array($result_set)) {
      $hrsobject = new hrsObject($value['numid']);
			$temp_array = $hrsobject->set_in_array();
			array_push($this->memhrs, $temp_array);
		}
	}

  function enter_hours($info){
    global $database;
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

	function get_hours_month($whichMonth){
		global $database;
    $month_array =  array(
			"Mercer County" 					=> 0,
			"Helpline" 								=> 0,
			"Continuing Ed" 					=> 0,
			"Compost (Trainee)" 			=> 0,
			"Other (Trainee)"   			=> 0,
			"Total"										=> 0
		);
		if ($whichMonth<10){
			$whichMonth="0".$whichMonth;
		}
		$date_range1 = $whichMonth."/01/2016";
		$date_range2 = $whichMonth."/31/2016";
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

	function get_totalss(){
		$this->set_hrs();
		$months_array = array();
		for ($month=1; $month<=12; $month++){
			array_push($months_array, $this->get_hours_month($month));
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
		array_push($months_array, $total_array);
	return $months_array;
}


	function get_totals(){
		$this->set_hrs();
		$months_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$current_month=0;
		$total = 0;
		for ($i = 0; $i < count($this->memhrs); $i++) {
			list($month, $day, $year) = explode("/", $this->memhrs[$i]['hdate']);
	    if ($month>($current_month+1)){
				$current_month = $month-1;
			}
			$months_array[$current_month] += $this->memhrs[$i]['numhrs'];
			$total += $this->memhrs[$i]['numhrs'];
		}
		array_push($months_array, $total);
		return $months_array;
	}
}
?>
