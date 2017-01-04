<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();

if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");
$member = new memberObject($_SESSION['memberid']);
}
?>
  <div="container">
    <div class="col-sm-12 text-center">
      <h1>Master Gardeners Time Collection</h1><br/>
    </div>
  </div>
  <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-body">
              <h2><? echo $member->get_fullname();?></h2>
              <table class="table table-condensed">
                <tr>
                  <td>
                    class year:
                  </td>
                  <td>
                    <? echo $member->get_class();?>
                  </td>
                </tr>
                <tr>
                  <td>
                    mg status:
                  </td>
                  <td>
                    <? $status = $member->get_status();
                      
                    echo change_status($status);?>
                  </td>
                </tr>
                <? if ($member->get_admin() !=""){
                  ?><tr>
                    <td>
                      Admin Level:
                    </td>
                    <td>
                      <? echo $member->get_admin();?>
                    </td>
                  </tr><?
                }?>
              </table>

            </div>
          </div>
        </div>
        <div class="col-md-7" >
          <div class="panel panel-default" >
            <div class="panel-body" ng-app='MemberApp' ng-strict-di>

              <ui-view></ui-view>

            </div>
          </div>
       </div>

      </div>
    </div>


<? include("../includes/layouts/footer.php"); ?>
