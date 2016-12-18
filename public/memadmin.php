<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();

if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");
$member = new memberObject($_SESSION['memberid']);
  if($member->memberAdmin()){


?>
  <div="container">
    <div class="col-sm-12 text-center">
      <h1>Member Administration</h1><br/>
    </div>
  </div>
  <div class="container" ng-app='MadminApp' ng-strict-di>
      <ui-view></ui-view>

    </div>

<?
  }
}
include("../includes/layouts/footer.php"); ?>
