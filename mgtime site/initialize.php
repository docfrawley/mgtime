<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)

///home/users/web/b1921/sl.tomatojo
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
	define('SITE_ROOT', DS.'home'.DS.'users'.DS.'web'.DS.'b1921'.
											DS.'sl.tomatojo'.DS.'public_html'.DS.'hours');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'database.php');
include_once(LIB_PATH.DS.'memberadmin.php');
include_once(LIB_PATH.DS.'memberobject.php');
include_once(LIB_PATH.DS.'memberhrs.php');
include_once(LIB_PATH.DS.'hrsobject.php');
?>
