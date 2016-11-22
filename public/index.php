<?php include_once("initialize.php");
include("../include/layout/header.php");

session_start();

if (isset($_SESSION['memberid'])){
  ?>
  <div="container">
  <div class="jumbotron col-sm-12 text-center">
    <h1>welcome to mgofmc</h1>
    <p className='lead'>What even is a jQuery?</p>
  </div>
  </div>
  <?
} else {
  ?>
  <div="container">
  <div class="col-sm-12 text-center">
    <h1>Master Gardeners Time Collection</h1>
      <div class="col-sm-6">
        If this is your first time using this site, please resister<br/><br/>
        <button type='button' class='btn btn-lg btn-success'>REGISTER</button>
      </div>
      <div class="col-sm-6">
        Returning users need only login<br/><br/>
        <button type='button' class='btn btn-lg btn-success'>LOGIN</button>
      </div>

  </div>
  </div>

  <?
  redirect_to('login.php');
}
?>







<? include("../includes/layouts/footer.php"); ?>
