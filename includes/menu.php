<? include_once("initialize.php");
session_start();

if (isset($_SESSION['memberid'])){

}
?>


<header>
  <nav class="navbar navbar-default">
    <div class="container">
      <br />
      <div class="navbar-header">

        <div>
          <a href="member.php"><h1>MGofMC Hours</h1></a>
        </div>

        <button id="navbarToggle" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <div id="collapsable-nav" class="collapse navbar-collapse">
        <ul id="nav-list" class="nav navbar-right nav-pills">
          <li >
            <a href="member.php" class="btn btn-success btn-lg" role="button">
              <span class="glyphicon glyphicon-home"></span> Member Home</a>
          </li>
          <li >
              <a href="hours.php" class="btn btn-success btn-lg" role="button">
              <span class="glyphicon glyphicon-info-sign"></span> Hours</a>
          </li>
          <li >
            <a href="memadmin.php" class="btn btn-success btn-lg" role="button">
              <span class="glyphicon glyphicon-certificate"></span>Member Admin</a>
          </li>
        </ul><!-- #nav-list -->
      </div><!-- .collapse .navbar-collapse -->
    </div><!-- .container -->
  </nav><!-- #header-nav -->
</header>
