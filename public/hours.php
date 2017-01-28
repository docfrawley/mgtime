<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();
if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");
$member = new memberObject($_SESSION['memberid']);
?>
  <div="container">
    <div class="col-sm-12 text-center">
      <h1>Time Collection for <? echo $member->get_fullname() ?></h1><br/>
      <? if (date('n')==1 && date('j')<16){
        $pyear = date('Y') -1;
        echo "<h5><span class='glyphicon glyphicon-alert' aria-hidden='true'>
              </span> Please note that hours for ".$pyear." will be archived
              on January 15th<br>such that only submissions for ".date('Y')." can be
              edited.</h5><br>";
      }
      ?>
    </div>
  </div>
  <div class="container" ng-app='HoursApp' ng-strict-di>
      <ui-view></ui-view>

    </div>


<? }
include("../includes/layouts/footer.php"); ?>
