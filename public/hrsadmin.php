<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();

if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");

?>

  <div class="container" ng-app='HadminApp' ng-strict-di>
    <div class="row">
      <div class="col-sm-12 text-center">
        <h1>Hours Administration</h1><br/>
      </div>
    </div>
      <ui-view></ui-view>
  </div>



<?

}
include("../includes/layouts/footer.php"); ?>
