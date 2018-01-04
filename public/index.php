<?php include_once("initialize.php");
include("../includes/layouts/header.php");

  ?>

<div class = "jumbotron">

  <div class="bg-video">
                  <video class="bg-video__content" autoplay muted loop>
                      <source src="img/Geranium.mp4" type="video/mp4">
                      <source src="img/Geranium.webm" type="video/webm">
                          Your browser is not supported
                  </video>
              </div>

  <div class="container" ng-app='LoginApp' ng-strict-di>

    <div class="row">
      <div class="col-sm-12 text-center">
        <h1>Master Gardeners Hours Collection</h1><br/>
      </div>
    </div>

    <div class="row justify-content-md-center">
      <div class="col-sm-6 col-centered">
        <div class="panel panel-default panel1">
          <div class="panel-body">
            <ui-view></ui-view>
          </div>
        </div>
      </div>
    </div>

  </div>








<? include("../includes/layouts/footer.php"); ?>
