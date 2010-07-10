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

$recipe = new Recipe($_GET["id"]);

// If the id given doesn't actually correspond to any entry
if ($recipe->isEmpty())
{
	die("This entry doesn't exist, please <a href='show.php'>select</a> another one.");
}

if ($_GET["action"] == "show")
{
	header("Location: show.php?id=".$recipe->getID());
}

if ($_GET["action"] == "confirm_deletion")
{
	echo "<p>".trr("Really delete")." '".$recipe->getTitle()."'?</p>\n";
	echo "<a href=edit.php?id=".$recipe->getID()
	."&action=delete>".trr("Yes")."</a>\n <br />";
	
	echo "<a href=show.php?id=".$recipe->getID().">".trr("No")."</a>\n";
	
	// So that the forms aren't shown
	exit();
}

// Deletion, should only be used from confirm_deletion
if ($_GET["action"] == "delete")
{
	$recipe->mysqlDelete();
	echo "Recipe '".$recipe->getTitle()."' has been deleted.\n";
	exit();
}

// Editing
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
<form action="edit.php?id=<?php echo $recipe->getID(); ?>&action=show" method=post>
	<div>
		<p><?php tr("Title");?>:</p> <input type=text name=title
		value=<?php echo $recipe->getTitle(); ?> />
	</div>
	<div>
		<p><?php tr("Ingredients");?>:</p> <textarea name=ingredients rows=10 cols=40>
<?php echo $recipe->getIngredients(); ?></textarea>
	</div>
	<div>
		<p><?php tr("Instructions");?>:</p> <textarea name=instructions rows=20 cols=80>
<?php echo $recipe->getInstructions(); ?></textarea>
	</div>
	<div>
		<p><?php tr("Time required");?>:</p> <input type=text name=time 
		value=<?php echo $recipe->getTime(); ?> /> <?php tr("minutes");?>
	</div>
	<input type=submit value=<?php tr("Save");?> /> <br />
</form>
</body>
</html>