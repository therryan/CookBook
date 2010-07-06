<?php require_once("view/inc/head.php");?>

<?php
require_once("model/recipe.class.php");
require_once("model/funcs.php");

if (count($_GET) > 0)
{
	$db = mysqliConnect();
	
	if (!empty($_GET["title"]))
	{
		$query = "SELECT id FROM recipes WHERE title LIKE '%"
		.$db->real_escape_string($_GET["title"])."%'";
	}
	elseif (!empty($_GET["all"]))
	{
		$escapedString = $db->real_escape_string($_GET["all"]);
		$query = "SELECT id FROM recipes WHERE title LIKE '%"
		.$escapedString."%' OR instructions LIKE '%"
		.$escapedString."%' OR ingredients LIKE '%"
		.$escapedString."%'";
	}
	elseif (!empty($_GET["ingredients"]))
	{
		$query = "SELECT id FROM recipes WHERE ingredients LIKE '%"
		.$db->real_escape_string($_GET["ingredients"])."%'";
	}
	
	echo $query."\n";
	
	// So we don't execute the query if none of the above were true
	if (!empty($query))
	{
		$data = $db->query($query);
	}
	
	while ($row = $data->fetch_assoc())
	{
		$recipe = new Recipe($row["id"]);
		echo $recipe->titleAsLink();
		
		unset($recipe);
	}
	
	if ($data->num_rows > 0)
	{
		echo "<p><a href=search.php>Search again</a></p>\n";
		// If we've found something, let's not show the forms
		exit();
	}
	else
	{
		echo "<p>Your search query didn't match anything. Please try again.</p>\n";
	}
}
?>
<form action="search.php" method=get>
	<div>
		<p>Search everything:</p><input type=text name=all>
	</div>
	<div>
		<p>Search titles:</p><input type=text name=title>
	</div>
	<div>
		<p>Search ingredients:</p><input type=text name=ingredients>
	</div>
	<input type=submit value="Search">
</body>
</html>