<?php
// This file is supposed to be used only when the configuration file is missing.

$loadHeader = FALSE; // We don't want the header
require("view/inc/head.php");

echo "<p>The configuration file is missing. Create one or contact the system administrator.</p>";
?>