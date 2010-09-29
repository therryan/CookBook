<?php
require_once("model/funcs.php");

function tr($trString, $justReturn = FALSE)
{
	$language = getconf("Language");
	
	// If the language is set to english, just return the given string
	if ($language == "english")
	{
		if ($justReturn) {return $trString;}
		else {echo $trString;}
		return;
	}
	if ($language == "finnish")
	{
		require("finnish.lang.php");
	}
	else {die("The language file for '$language' does not exist.");}	
	
	// If the string isn't translated, show the original in monospace,
	// so that the user (developer) would notice it
	if (strlen($lang[$trString]) == 0)
	{
		echo "<span style=\"font-family: monospace;\">$trString</span>";
	}
	
	if ($justReturn)
	{
		return $lang[$trString];
	}
	else
	{
		echo $lang[$trString];
	}
}

function trr($trString)
{
	return tr($trString, TRUE);
}
?>