<?php require_once("../includes/initialize.php"); ?>
<?
session_start();

$task=isset($_GET['task']) ? $_GET['task'] : "" ;
    if (!$task) $task=isset($_POST['task']) ? $_POST['task'] : "" ;

$year=isset($_GET['year']) ? $_GET['year'] : "" ;
    if (!$year) $year=isset($_POST['year']) ? $_POST['year'] : "" ;

$member_admin = new memadmin();
switch ($task) {
  case 'ind':
    $memberhrs = new memberHrs($_SESSION['memberid']);
    $output =$memberhrs->indDownload($year);
    break;
  case 'admInd':
    $memberhrs = new memberHrs($_SESSION['member']);
    $output =$memberhrs->indDownload($year);
    break;
  case 'nclist':

    $output =$member_admin->nclistDownload($year);
    break;
  case 'slist':
    $output =$member_admin->slistDownload($year);
    break;
  case 'rdlist':
    $output =$member_admin->slistDownload($year);
    break;
  case 'l100':
    $output =$member_admin->mlistDownload('l100', $year);
    break;
  case 'l250':
    $output =$member_admin->mlistDownload('l250', $year);
    break;
  case 'l500':
    $output =$member_admin->mlistDownload('l500', $year);
    break;
  case 'l1000':
    $output =$member_admin->mlistDownload('l1000', $year);
    break;
  case 'l2500':
    $output =$member_admin->mlistDownload('l2500', $year);
    break;
  case 'l5000':
    $output =$member_admin->mlistDownload('l5000', $year);
    break;
  case 'plus5000':
    $output =$member_admin->mlistDownload('5000+', $year);
    break;
  case 'msAll':
    $output =$member_admin->mlistDownload('msAll', $year);
    break;
  case 'ATrainee':
    $output =$member_admin->rdlistDownload('A - Trainee', $year);
    break;
  case 'A':
    $output =$member_admin->rdlistDownload('A', $year);
    break;
  case 'ActiveK':
    $output =$member_admin->rdlistDownload('Active 1000hrs', $year);
    break;
  case 'contactList':
    $output =$member_admin->clistDownload();
    break;
  case 'endlist':
    $output =$member_admin->endDownload($year);
    break;
  default:
    echo "break";
    break;
}

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=download.xls");
echo $output;

?>
