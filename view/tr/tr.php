<?php
function tr($trString, $justReturn = FALSE)
{
	// Check from config
	$language = "finnish";
	if ($language == "finnish")
	{
		require("finnish.lang.php");
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