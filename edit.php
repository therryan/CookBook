<?php require_once("view/inc/head.php");?>
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
	die("This entry doesn't exist, please <a href='show.php'>select</a> another one.");
}

if ($_GET["action"] == "delete")
{
	$recipe->mysqlDelete();
	echo "Recipe '".$recipe->getTitle()."' has been deleted.\n";
	exit();
}

if (count($_POST) > 0)
{
	$recipe->setTitle($_POST["title"]);
	$recipe->setIngredients($_POST["ingredients"]);
	$recipe->setInstructions($_POST["instructions"]);
	$recipe->setTime($_POST["time"]);
	
	$recipe->mysqlUpdate();
	echo $recipe->repr();
}

?>
<form action="edit.php?id=<?php echo $recipe->getID(); ?>" method=post>
	<div>
		<p>Title:</p> <input type=text name=title
		value=<?php echo $recipe->getTitle(); ?> />
	</div>
	<div>
		<p>Ingredients:</p> <textarea name=ingredients rows=10 cols=40>
<?php echo $recipe->getIngredients(); ?></textarea>
	</div>
	<div>
		<p>Instructions:</p> <textarea name=instructions rows=20 cols=80>
<?php echo $recipe->getInstructions(); ?></textarea>
	</div>
	<div>
		<p>Time required:</p> <input type=text name=time 
		value=<?php echo $recipe->getTime(); ?> /> minutes
	</div>
	<input type=submit value="Save" /> <br />
</form>
</body>
</html>