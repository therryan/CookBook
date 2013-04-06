<?php
require_once("view/tr/tr.php");
getconf("Username"); // This is here so that if the conf file is missing, it gets caught here, before any CSS etc. gets applied
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Cookbook</title>
	<link rel="stylesheet" type="text/css" href="view/styles/main.css">
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
</head>

<body>
	<div id="container">
<?php
// If one doesn't want the header to show up, one can just declare '$loadheader' before including this file and the header won't show up
if (!isset($loadHeader))
{
	require("header.php");
}
?>