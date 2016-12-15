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
    $this->typehrs = $value['hrstype'];
    $this->description = $value['description'];
    $this->hdate = $value['hdate'];
	}

  function set_in_array(){
    $temp_array = array(
      'hdate'       => $this->hdate,
      'typehrs'     => $this->typehrs,
      'numhrs'      => $this->numhrs,
      'description' => $this->description
    );
    return $temp_array;
  }

}
?>
