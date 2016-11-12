<? require_once("../includes/initialize.php");


// remove all session variables
session_unset();

// destroy the session

session_destroy();
redirect_to('login.php');

?>
