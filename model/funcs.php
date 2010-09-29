<?php
// Connect to MySQL using mysqli
// Should check conf for params
function mysqliConnect()
{
	$address = getconf("Address");
	$user = getconf("Username");
	$passwd = getconf("Password");
	$default = getconf("Database");
	
	$db = new mysqli($address, $user, $passwd, $default);
	
	if ($db->connect_errno)
	{
		die($db->connect_error.": ".$_SERVER["SCRIPT_FILENAME"]."\n");
	}
	
	return $db;
}

require_once("conf.php");

?>