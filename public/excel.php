<?php require_once("../includes/initialize.php"); ?>
<?


$task=isset($_GET['task']) ? $_GET['task'] : "" ;
    if (!$task) $task=isset($_POST['task']) ? $_POST['task'] : "" ;

switch ($task) {
  case 'nclist':
    $member_admin = new memadmin();
    $output =$member_admin->nclistDownload();
    break;
  case 'slist':
    $member_admin = new memadmin();
    $output =$member_admin->nclist();
    break;
  case 'rdlist':
    $member_admin = new memadmin();
    $output =$member_admin->nclist();
    break;
  case 'mlist':
    $member_admin = new memadmin();
    $output =$member_admin->nclist();
    break;
  default:
    echo "break";
    break;
}

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=download.xls");
echo $output;

?>
