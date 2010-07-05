<?php
if (!(count($_GET) > 0) || !is_numeric($_GET["id"]))
{
	// The user can choose the entry they want to edit here
	header("Location: show.php");
	
	// So that nothing else gets executed
	exit();
}
// This has to be moved here because of header()
require_once("view/inc/head.php");

require_once("model/recipe.class.php");
require_once("model/ingredient.class.php");

$recipe = new Recipe($_GET["id"]);

if ($recipe->isEmpty())
{
	echo "This entry doesn't exist, please select another one.";
}
else
{
	echo $recipe->repr();
}

?>