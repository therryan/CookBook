<?php require_once("view/inc/head.php");?>

<?php
require_once("model/recipe.class.php");
require_once("model/ingredient.class.php");
require_once("model/funcs.php");

if (count($_GET) > 0 && array_key_exists("id", $_GET))
{
	$recipe = new Recipe($_GET["id"]);
	
	if ($recipe->isEmpty())
	{
		echo "This entry doesn't exist, please select another one.";
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

	// We need to start at 1 because the first ID is 1
	for ($i = 1; $i <= $data->num_rows; $i++)
	{
		$recipe = new Recipe($i);
		echo $recipe->titleAsLink();
	
		unset($recipe);
	}
	
	while ($row = $data->fetch_assoc())
	{
		$recipe = new Recipe($row["id"]);
		echo $recipe->titleAsLink();
		
		unset($recipe);
	}
}

$db->close();
?>

</body>
</html>