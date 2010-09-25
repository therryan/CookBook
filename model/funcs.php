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

// The conf-functions form a front-end for editing and easily looking up settings in the program itself
function getconf($directive)
{
	require("cookbook.conf");
	
	// If the given parameter (e.g. "test") represents a variable is the conf file ($test), then return the value of that directive
	if (isset($$directive))
	{
		return $$directive;
	}
	else {die("Given directive $$directive does not exist. Please contact the system administrator.");}
}

function setconf($directive, $value)
{
	require_once("cookbook.conf");
}


?>