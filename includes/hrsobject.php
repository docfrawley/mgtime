<? include_once("initialize.php");
session_start();

class hrsObject {

  private $hdate;
  private $numhrs;
  private $typehrs;
  private $description;
  private $hrsid;

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
	}

  function set_in_array(){
    $temp_array = array(
      'hdate'       => date('m/d/Y',$this->hdate),
      'hrstype'     => $this->hrstype,
      'numhrs'      => $this->numhrs,
      'description' => $this->description,
      'numid'       => $this->hrsid
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

}
?>
