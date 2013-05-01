<?php

/* Connects to the specified database and returns a PDO-object
 *     Possible values for $dbType: 'sqlite', 'mysql'
 *     If $dbType == 'sqlite', then $host must be the path to the database:
 *         $db = sDBConnect("sqlite", "/var/www/project/data.db");
 *     If $dbType == 'mysql', then the remaining arguments are used as well */
function sDBConnect($dbType, $host, $username, $password) {
	if ($dbType == "sqlite") {
		try {
			$db = new PDO("sqlite:$host");
		} catch (PDOException $e) {
			die("ERROR: " . $e->getMessage());
		} 
	} else if ($dbType == "mysql") {
		try {
			// To be implemented
			//$db = new PDO("mysql:")
		} catch (PDOException $e) {
			
		}
	} else {
		sLog("", "error");
	}
	
	return $db;
}

/* Initiates the log file */
function sInitLog() {
	
}

/* Logs a message to the specified log
 *
 *     $message: 
 *     $type: How critical the item is
 *         'normal'
 *         'warning'
 *         'error'    fatal error, stop execution
 */
function sLog($message, $type) {
	// Add message to log
	
	// Execute action
	if ($type == "error") {
		exit();
	}
}

?>