<?php include_once("initialize.php");
include("../includes/layouts/header.php");

session_start();

if (isset($_SESSION['memberid'])) {
include("../includes/menu.php");

$memAdmin = new memadmin();
$all_array = $memAdmin->get_total_mgs();
$reg_array = $memAdmin->get_registered();
$hrs_array = $memAdmin->get_entered_hrs();

?>
  <div="container">
    <div class="col-sm-12 text-center">
      <h1>Hours Administration</h1><br/>
    </div>
    <div class="col-sm-12 text-center">
      <table class="table text-left">
  <thead>
    <tr>
      <th>MG Status</th>
      <th>Total Number</th>
      <th>Total Registered</th>
      <th># Entered Hrs on Site</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Active</td>
      <td><? echo $all_array['A']; ?></td>
      <td><? echo $reg_array['A']; ?></td>
      <td><? echo $hrs_array['A']; ?></td>
    </tr>
    <tr>
      <td>Active Trainee</td>
      <td><? echo $all_array["A - Trainee"]; ?></td>
      <td><? echo $reg_array["A - Trainee"]; ?></td>
      <td><? echo $hrs_array["A - Trainee"]; ?></td>
    </tr>
    <tr>
      <td>Emeritus</td>
      <td><? echo $all_array["E"]; ?></td>
      <td><? echo $reg_array["E"]; ?></td>
      <td><? echo $hrs_array["E"]; ?></td>
    </tr>
    <tr>
      <td>Inactive</td>
      <td><? echo $all_array["IA"]; ?></td>
      <td><? echo $reg_array["IA"]; ?></td>
      <td><? echo $hrs_array["IA"]; ?></td>
    </tr>
    <tr>
      <td>Trainee - Did not Graduate</td>
      <td><? echo $all_array["T/NotG"]; ?></td>
      <td><? echo $reg_array["T/NotG"]; ?></td>
      <td><? echo $hrs_array["T/NotG"]; ?></td>
    </tr>
    <tr>
      <td>Active 1000hrs</td>
      <td><? echo $all_array["Active 1000hrs"]; ?></td>
      <td><? echo $reg_array["Active 1000hrs"]; ?></td>
      <td><? echo $hrs_array["Active 1000hrs"]; ?></td>
    </tr>
  </tbody>
</table>
    </div>
  </div>
  <div class="container" ng-app='HadminApp' ng-strict-di>
      <ui-view></ui-view>

    </div>

<?

}
include("../includes/layouts/footer.php"); ?>
