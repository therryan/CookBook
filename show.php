<?php require_once("view/inc/head.php");?>

<?php
require_once("model/recipe.class.php");
require_once("model/ingredient.class.php");

if (count($_GET) > 0 && array_key_exists("id", $_GET))
{
	$recipe = new Recipe($_GET["id"]);
	echo $recipe->composeHTML();
}
else
{
	$db = new mysqli("127.0.0.1", "cookbook", "", "cookbook") or die(mysqli_error($db));
	$data = $db->query("SELECT * FROM recipes");

	// We need to start at 1 because the first ID is 1
	for ($i = 1; $i <= $data->num_rows; $i++)
	{
		$recipe = new Recipe($i);
		echo "<p><a href=show.php?id=" . $recipe->getID() . ">"
		. $recipe->getTitle() . "</a></p>\n";
	
		unset($recipe);
	}
}

$db->close();
?>

</body>
</html>