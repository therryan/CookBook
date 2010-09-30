<?php
require("model/recipe.class.php");

if ($_GET["action"] == "show")
{
	//var_dump($_POST);
	
	$recipe = new Recipe();
	$recipe->getRecipeByTitle($_POST["title"]);
	header("Location: show.php?id=".$recipe->getID());
}

// These have been moced here because of 'header()'
require("view/inc/head.php");

if (count($_POST) > 0)
{
	$recipe = new Recipe();

	$recipe->setTitle($_POST["title"]);
	$recipe->setIngredients($_POST["ingredients"]);
	$recipe->setInstructions($_POST["instructions"]);
	$recipe->setTime($_POST["time"]);
	$recipe->setCategoryByID($_POST["category"]);
	
	// Comment the line below to prevent entries to the database when testing
	$recipe->mysqlInsert();
	echo $recipe->repr();
}

// Empty the POST array by initing it
$_POST = array();
?>
<form action="add.php?action=show" method=post>
	<div>
		<p><?php tr("Title");?>:</p> <input type=text name=title
  <?php // If the user got to add.php from index.php, pre-populate the title
        // The extra quotes are there to make sure that multi-word titles are displayed correctly
  if (strlen($_GET["title"]) > 0) {
      echo "value=\"".$_GET["title"]."\""; } ?> />
	</div>
	<p><?php tr("Category");?>:</p>
	<select name=category>
		<?php
			$db = mysqliConnect();
			$data = $db->query("SELECT * FROM categories");
			
			// Set the default to --- "None"
			echo "<option value=\"0\">---</option>\n";
			
			// Populate the 'select' with the categories from the database
			while ($row = $data->fetch_assoc())
			{				
				echo "<option value=\"".$row["id"]."\"$selected>".
				     $row["name"]."</option>\n\r";
			}
		?>
	</select>
	<div>
		<p><?php tr("Ingredients");?>:</p> <textarea name=ingredients rows=10 cols=40></textarea>
	</div>
	<div>
		<p><?php tr("Instructions");?>:</p> <textarea name=instructions rows=20 cols=80></textarea>
	</div>
	<div>
		<p><?php tr("Time required");?>:</p> <input type=text name=time />
		<?php tr("minutes");?> 
	</div>
	<input type=submit value=<?php tr("Save");?> />
</form>
</div>
</body>
</html>