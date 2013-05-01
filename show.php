<?php require_once("view/inc/head.php");

require_once("model/recipe.class.php");
require_once("model/funcs.php");

// Show a specific recipe
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
// Show the names of all the recipes as links
else
{

	$db = DBConnect();
	$stmt = $db->query("SELECT id FROM recipes");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($data as $row)
	{
		$recipe = new Recipe($row["id"]);
		echo $recipe->titleAsLink();
		unset($recipe);
	}

	$db = null;
}
?>

</body>
</html>