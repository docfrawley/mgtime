<?php require_once("../includes/initialize.php"); ?>
<?
session_start();

$task=isset($_GET['task']) ? $_GET['task'] : "" ;
    if (!$task) $task=isset($_POST['task']) ? $_POST['task'] : "" ;

switch ($task) {
  case 'ind':
    $memberhrs = new memberHrs($_SESSION['memberid']);
    $output =$memberhrs->indDownload();
    break;
  case 'admInd':
    $memberhrs = new memberHrs($_SESSION['member']);
    $output =$memberhrs->indDownload();
    break;
  case 'nclist':
    $member_admin = new memadmin();
    $output =$member_admin->nclistDownload();
    break;
  case 'slist':
    $member_admin = new memadmin();
    $output =$member_admin->slistDownload();
    break;
  case 'rdlist':
    $member_admin = new memadmin();
    $output =$member_admin->slistDownload();
    break;
  case 'l100':
    $member_admin = new memadmin();
    $output =$member_admin->mlistDownload('l100');
    break;
  case 'l250':
    $member_admin = new memadmin();
    $output =$member_admin->mlistDownload('l250');
    break;
    case 'l500':
      $member_admin = new memadmin();
      $output =$member_admin->mlistDownload('l500');
      break;
    case 'l1000':
      $member_admin = new memadmin();
      $output =$member_admin->mlistDownload('l1000');
      break;
    case 'l2500':
      $member_admin = new memadmin();
      $output =$member_admin->mlistDownload('l2500');
      break;
    case 'l5000':
      $member_admin = new memadmin();
      $output =$member_admin->mlistDownload('l5000');
      break;
    case 'plus5000':
      $member_admin = new memadmin();
      $output =$member_admin->mlistDownload('5000+');
      break;
    case 'msAll':
      $member_admin = new memadmin();
      $output =$member_admin->mlistDownload('msAll');
      break;
  default:
    echo "break";
    break;
}

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=download.xls");
echo $output;

?>
