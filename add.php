<?php require_once("view/inc/head.php");?>

<?php
require_once("model/recipe.class.php");
require_once("model/funcs.php");

if (count($_POST) > 0)
{
	$recipe = new Recipe();

	$recipe->setTitle($_POST["title"]);
	$recipe->setIngredients($_POST["ingredients"]);
	$recipe->setInstructions($_POST["instructions"]);
	$recipe->setTime($_POST["time"]);
	
	$recipe->mysqlInsert();
	echo $recipe->repr();
}

// Empty the POST array by initing it
$_POST = array();
?>
<form action="add.php" method=post>
	<div>
		<p>Title:</p> <input type=text name=title />
	</div>
	<div>
		<p>Ingredients:</p> <textarea name=ingredients rows=10 cols=40></textarea>
	</div>
	<div>
		<p>Instructions:</p> <textarea name=instructions rows=20 cols=80></textarea>
	</div>
	<div>
		<p>Time required:</p> <input type=text name=time /> minutes
	</div>
	<input type=submit value="Submit" /> <br />
</form>
</div>
</body>
</html>