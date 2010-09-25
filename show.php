<?php require_once("view/inc/head.php");

require_once("model/recipe.class.php");
require_once("model/funcs.php");

if (count($_GET) > 0 && array_key_exists("id", $_GET))
{
	$recipe = new Recipe($_GET["id"]);
	
	if ($recipe->isEmpty())
	{
		echo tr("This entry doesn't exist, please select another one.");
	}
	else
	{
		echo $recipe->composeHTML();
	}
}
else
{

	$db = mysqliConnect();
	$data = $db->query("SELECT id FROM recipes");
	
	while ($row = $data->fetch_assoc())
	{
		$recipe = new Recipe($row["id"]);
		echo $recipe->titleAsLink();
		
		unset($recipe);
	}

	$db->close();
}
?>

</body>
</html>