<?php
require("model/recipe.class.php");

// This has to be before the redirect
if (count($_POST) > 0)
{
	$recipe = new Recipe();

	$recipe->setTitle($_POST["title"]);
	$recipe->setIngredients($_POST["ingredients"]);
	$recipe->setInstructions($_POST["instructions"]);
	$recipe->setTime($_POST["time"]);
	$recipe->setCategoryByID($_POST["category"]);
	
	// Comment the line below to prevent entries to the database when testing
	$recipe->DBInsert();
}

// count() is used, because when the user enters 'add.php' normally, $_GET is empty, which makes PHP unhappy
if (count($_GET) > 0 && $_GET["action"] == "show")
{
	$recipe = new Recipe();
	$recipe->getRecipeByTitle($_POST["title"]);
	header("Location: show.php?id=".$recipe->getID());
}

// This has been moved here because of 'header()'
require("view/inc/head.php");

// Empty the POST array by initing it
$_POST = array();
?>
<form action="add.php?action=show" method=post>
	<div>
		<p><?php tr("Title");?>:</p> <input type=text name=title
  <?php // If the user came to add.php from index.php, pre-populate the title
        // The extra quotes are there to make sure that multi-word titles are displayed correctly
  if (count($_GET) > 0 && strlen($_GET["title"]) > 0) {
      echo "value=\"".$_GET["title"]."\""; } ?> />
	</div>
	<p><?php tr("Category");?>:</p>
	<select name=category>
		<?php
			$db = DBConnect();
			$stmt = $db->query("SELECT * FROM categories");
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			// Set the default to --- "None"
			echo "<option value=\"0\">---</option>\n";
			
			// Populate the 'select' with the categories from the database
			foreach ($data as $row)
			{				
				echo "<option value=\"".$row["id"]."\">".
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