<?php require("view/inc/head.php");?>
<?php

require("model/recipe.class.php");

$db = mysql_connect("127.0.0.1", "cookbook") or die(mysql_error());
mysql_select_db("cookbook") or die(mysql_error());

$data = mysql_query("SELECT * FROM recipes");

while ($row = mysql_fetch_assoc($data))
{
	$recipe = new Recipe();
	
	$recipe->setTitle($row["title"]);
	$recipe->setTimeRequired($row["time"]);
	$recipe->setIngredients($row["ingredients"]);
	$recipe->setInstructions($row["instructions"]);

	$recipe->repr();
	echo "<br />";
	
	unset($recipe);
}

?>
</body>

</html>