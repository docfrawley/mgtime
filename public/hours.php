<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();
if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");
$member = new memberObject($_SESSION['memberid']);

?>
  <div="container">
    <div class="col-sm-12 text-center">
      <h1>Time Collection for <? echo $member->get_fullname();?></h1><br/>
    </div>
  </div>
  <div class="container" ng-app='HoursApp' ng-strict-di>
      <ui-view></ui-view>

    </div>


<? }
include("../includes/layouts/footer.php"); ?>
