<?php
if (!(count($_GET) > 0) || !is_numeric($_GET["id"]))
{
	// The user can choose the entry they want to edit here
	header("Location: show.php");
	
	// So that nothing else gets executed
	exit();
}

if ($_GET["action"] == "show")
{
	header("Location: show.php?id=".$_GET["id"]);
}

// This has to be moved here because of header()
require_once("view/inc/head.php");
require_once("model/recipe.class.php");

$recipe = new Recipe($_GET["id"]);

// If the id given doesn't actually correspond to any entry
if ($recipe->isEmpty())
{
	die(trr("This entry doesn't exist, please")
	."<a href='show.php'> ".trr("select")." </a> ".trr("another one"));
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
	echo trr("Recipe")." '".$recipe->getTitle()."' "
	.trr("has been deleted").".\n";
	exit();
}

// Editing
if (count($_POST) > 0)
{
	$recipe->setTitle($_POST["title"]);
	$recipe->setIngredients($_POST["ingredients"]);
	$recipe->setInstructions($_POST["instructions"]);
	$recipe->setTime($_POST["time"]);
	$recipe->setCategoryByID($_POST["category"]);
	$recipe->setFavorite($_POST["favorite"]);
		
	$recipe->mysqlUpdate();
}

?>
<form action="edit.php?id=<?php echo $recipe->getID(); ?>&action=show" method=post>
	<!-- Title -->
	<div>
		<p><?php tr("Title");?></p> <input type=text name=title
		value="<?php echo $recipe->getTitle(); ?>" />
	</div>
	
	<!-- Favorite -->
	<div>
		<input type=checkbox name=favorite value=1
		<?php
		    if ($recipe->isFavorite())
				{
					echo "checked";
				}
		?> /> <?php tr("Favorite");?>
	</div>
	
	<!-- Category -->
	<div>
		<p><?php tr("Category");?></p><select name=category>
			<?php
				$db = mysqliConnect();
				$data = $db->query("SELECT * FROM categories");
				
				// Set the default to --- "None"
				echo "<option value=\"0\">---</option>";
				
				// Populate the 'select' with the categories from the database
				while ($row = $data->fetch_assoc())
				{
					if ($row["id"] == $recipe->getCategoryID())
					{
						$selected = "selected=\"selected\"";
					}
					else
					{
						$selected = "";
					}
					$s = "<option value=\"".$row["id"]."\" $selected>".
					     $row["name"]."</option>\n";
					
					echo $s;
				}
			?>
		</select>
	</div>
	
	<!-- Ingredients -->
	<div>
		<p><?php tr("Ingredients");?></p> <textarea name=ingredients rows=10 cols=40>
<?php echo $recipe->getIngredients(); ?></textarea>
	</div>
	
	<!-- Instructions -->
	<div>
		<p><?php tr("Instructions");?></p> <textarea name=instructions rows=20 cols=80>
<?php echo $recipe->getInstructions(); ?></textarea>
	</div>
	
	<!-- Time required -->
	<div>
		<p><?php tr("Time required");?></p> <input type=text name=time 
		value=<?php echo $recipe->getTime(); ?> /> <?php tr("minutes");?>
	</div>
	
	<!-- Submit -->
	<input type=submit value=<?php tr("Save");?> /> <br />
</form>
</body>
</html>