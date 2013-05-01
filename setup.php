<?php
// This file is supposed to be used only when the configuration file is missing.

$loadHeader = FALSE; // We don't want the header
require("view/inc/head.php");

/* TODO: Settings wizard
 * For now, we'll just copy the default settings
 */

// Check that the conf file actually doesn't exit, so we're not overwriting anything
if (file_exists("cookbook.conf")) {
	// Abort
	echo "<script>location.href='index.php'</script>";
	die("Conf file exists");
} else {
	copy("cookbook.conf.sample", "cookbook.conf");
	
	// Go back to the homepage with JS
	
}

echo "<p>The configuration file is missing. Create one or contact the system administrator.</p>";
?>