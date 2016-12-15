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

	function get_hours(){
		$this->set_hrs();
		return $this->memhrs;
	}

	function get_totals(){
		$this->set_hrs();
		$months_array = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$current_month=0;
		$total = 0;
		$first = 0;
		$second = 0;
		$third = 0;
		$fourth = 0;
		for ($i = 0; $i < count($this->memhrs); $i++) {
			list($month, $day, $year) = explode("/", $this->memhrs[$i]['hdate']);
	    if ($month>($current_month+1)){
				$current_month = $month-1;
			}
			$months_array[$current_month] += $this->memhrs[$i]['numhrs'];
			$total += $this->memhrs[$i]['numhrs'];
			switch ($month) {
				case ($month<4):
					$first += $this->memhrs[$i]['numhrs'];
					break;
				case ($month>3 && $month <7):
					$second += $this->memhrs[$i]['numhrs'];
					break;
				case ($month>6 && $month <10):
					$third += $this->memhrs[$i]['numhrs'];
					break;
				case ($month>9):
					$fourth += $this->memhrs[$i]['numhrs'];
					break;
				default:
					break;
			}
		}
		array_push($months_array, $total);
		array_push($months_array, $first);
		array_push($months_array, $second);
		array_push($months_array, $third);
		array_push($months_array, $fourth);
		return $months_array;
	}
}
?>
