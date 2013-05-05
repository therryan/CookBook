<?php
require_once('view/tr/tr.php');
getconf('Username'); // This is here so that if the conf file is missing, it gets caught here, before any CSS etc. gets applied
?>
<!DOCTYPE html>
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Droid+Serif|Open+Sans' rel='stylesheet' type='text/css'>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title>Cookbook</title>
	<link rel='stylesheet' type='text/css' href='view/styles/main.css'>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script type='text/javascript' src='http://code.jquery.com/jquery-2.0.0.min.js'></script>
	<script  type='text/javascript' src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>

<body>
	<div id='container'>
<?php
// If one doesn't want the header to show up, one can just declare '$loadheader' before including this file and the header won't show up
if (!isset($loadHeader)) {
	require('header.php');
}
?>