<? include_once("initialize.php");
session_start();

class hrsObject {

  private $hdate;
  private $numhrs;
  private $typehrs;
  private $description;
  private $hrsid;
  private $chstatus;
  private $chdate;
  private $chdescription;

	function __construct($id) {
    global $database;
    $sql="SELECT * FROM hours WHERE numid='".$id."'";
    $result_set = $database->query($sql);
		$value = $database->fetch_array($result_set);
    $this->hrsid = $id;
    $this->numhrs = $value['numhrs'];
    $this->hrstype = $value['hrstype'];
    $this->description = $value['description'];
    $this->hdate = $value['hdate'];
    $this->chstatus = $value['chstatus'];
    $this->chdate = $value['chdate'];
    $this->chdescription = $value['chdescription'];
	}

  function get_date(){
    return $this->hdate;
  }

  function set_in_array(){
    $temp_array = array(
      'hdate'         => date('m/d/Y',$this->hdate),
      'hrstype'       => $this->hrstype,
      'numhrs'        => $this->numhrs,
      'description'   => $this->description,
      'chstatus'      => $this->chstatus,
      'chdate'        => $this->chdate,
      'chdescription' => $this->chdescription,
      'numid'         => $this->hrsid
    );
    return $temp_array;
  }

  function update_hours($info){
    global $database;
    list($month, $day, $year) = explode("/", $info['hdate']);
		$themonth = intval($month);
		$theday = intval($day);
		$theyear = intval($year);
		$date = mktime(0,0,0,$themonth,$theday,$theyear);
		$info['hdate'] = $date;
    $sql = "UPDATE hours SET ";
		$sql .= "hdate='". $info['hdate'] ."', ";
		$sql .= "hrstype='". $info['hrstype'] ."', ";
    $sql .= "numhrs='". $info['numhrs'] ."', ";
		$sql .= "description='". $info['description'] ."' ";
		$sql .= "WHERE numid='". $this->hrsid. "' ";
		$database->query($sql);
  }

  function update_hoursAdmin($info){
    global $database;
    $sql = "INSERT INTO orghours (";
	  	$sql .= "hrstype, numhrs, description, numid";
	  	$sql .= ") VALUES ('";
	  	$sql .= $this->hrstype ."', '";
      $sql .= $this->numhrs ."', '";
      $sql .= $this->description ."', '";
		  $sql .= $this->hrsid ."')";
		$database->query($sql);
    $today = date('U');

    $sql = "UPDATE hours SET ";
		$sql .= "hrstype='". $database->escape_value($info['hrstype']) ."', ";
    $sql .= "numhrs='". $database->escape_value($info['numhrs']) ."', ";
    $sql .= "description='". $database->escape_value($info['description']) ."', ";
    $sql .= "chstatus='c', ";
    $sql .= "chdate='". $today ."', ";
		$sql .= "chdescription='". $database->escape_value($info['chdescription']) ."' ";
		$sql .= "WHERE numid='". $this->hrsid. "' ";
		$database->query($sql);
  }

}
?>
