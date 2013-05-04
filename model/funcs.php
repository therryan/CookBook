<?php
// For some reason relative paths don't always work, so getcwd is used instead
require_once(getcwd()."/suitelib/suitephp.php");
require_once("conf.php");

/* Connects to the database with values read from the conf file */
function DBConnect()
{
	$DBType = getconf("DBType");
	$address = getconf("Address");
	$user = getconf("Username");
	$password = getconf("Password");
	$default = getconf("Database");

	$db = sDBConnect($DBType, $address, $user, $password);
	return $db;
}
?>