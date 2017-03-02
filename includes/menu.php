<? include_once("initialize.php");
session_start();

if (isset($_SESSION['memberid'])){
  $member = new memberObject($_SESSION['memberid']);

?>
  <header>
    <nav id="header-nav" class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">

          <div id="header_title">
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
          <ul id="nav-list" class="nav navbar-nav navbar-right">
            <li >
              <a href="member.php"><span class="glyphicon glyphicon-dashboard">
              </span><br class="hidden-xs">Member Home</a>
            </li>
            <li >
                <a href="hours.php"><span class="glyphicon glyphicon-tree-conifer">
                </span><br class="hidden-xs">Enter Hours</a>
            </li>
            <? if ($member->check_hrs()){ ?>
                <li >
                  <a href="hrsadmin.php"><span class="glyphicon glyphicon-time">
                  </span><br class="hidden-xs">Hours Admin</a>
                </li>
            <? }
              if ($member->check_full()){ ?>
                <li >
                  <a href="memadmin.php"><span class="glyphicon glyphicon-user">
                  </span><br class="hidden-xs">Member Admin</a>
                </li>
          <?  } ?>
            <li >
              <a href="logout.php"><span class="glyphicon glyphicon-remove-circle">
              </span><br class="hidden-xs">Logout</a>
            </li>
          </ul><!-- #nav-list -->
        </div><!-- .collapse .navbar-collapse -->
      </div><!-- .container -->
    </nav><!-- #header-nav -->
  </header><?
} ?>
