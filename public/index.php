<?php include_once("initialize.php");
include("../includes/layouts/header.php");

  ?>

<div class = "jumbotron">


  <div class="container" ng-app='LoginApp' ng-strict-di>

    <div class="row">
      <div class="col-sm-12 text-center">
        <h1>Master Gardeners Time Collection</h1><br/>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-8 col-centered">
        <div class="panel panel-default panel1">
          <div class="panel-body">
            <ui-view></ui-view>
          </div>
        </div>
      </div>
    </div>

  </div>








<? include("../includes/layouts/footer.php"); ?>
