<?php require_once("view/inc/head.php");?>

<?php
require_once("model/recipe.class.php");
require_once("model/funcs.php");

if (count($_GET) == 0 || empty($_GET["title"]))
{
	// Display search boxes etc...
}
else
{
	$db = mysqliConnect();
	
	$query = "SELECT id FROM recipes WHERE title LIKE '%"
		.$db->real_escape_string($_GET["title"])."%'";
		
	$data = $db->query($query);
	
	while ($row = $data->fetch_assoc())
	{
		$recipe = new Recipe($row["id"]);
		echo $recipe->titleAsLink();
		
		unset($recipe);
	}
}
?>
</body>
</html>