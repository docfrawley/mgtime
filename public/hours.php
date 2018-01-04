<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();
if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");

?>

    <div class="container" ng-app='HoursApp' ng-strict-di>
      <ui-view></ui-view>
    </div>


<? }
include("../includes/layouts/footer.php"); ?>
