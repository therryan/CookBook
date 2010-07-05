<?php

// Connect to MySQL using mysqli
// Should check conf for params
function mysqliConnect($address = "127.0.0.1", $user = "cookbook", $passwd = "", $default = "cookbook")
{
	$db = new mysqli($address, $user, $passwd, $default);
	
	if ($db->connect_errno)
	{
		die($db->connect_error.": ".$_SERVER["SCRIPT_FILENAME"]."\n");
	}
	
	return $db;
}

?>