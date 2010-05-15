<!DOCTYPE>
<html>

<head>
</head>

<body>
	<form action="add.php" method=post>
		Title: <input type=text name=title /> <br />
		Ingredients: <textarea name=ingredients></textarea> <br />
		Instructions: <textarea name=instructions></textarea> <br />
		Time required: <input type=text name=time /> 
			(minutes) <br />
		<input type=submit value="Submit" /> <br />
	</form>
</body>

</html>

<?php

require("recipe.class.php");

$db = mysql_connect("127.0.0.1", "cookbook") or die(mysql_error());
mysql_select_db("cookbook") or die(mysql_error());

$recipe = new Recipe();

$recipe->setTitle($_POST["title"]);
$recipe->setIngredients($_POST["ingredients"]);
$recipe->setInstructions($_POST["instructions"]);
$recipe->setTimeRequired($_POST["time"]);

echo $recipe->mysqlInsert();
mysql_query($recipe->mysqlInsert());

$_POST = array();

?>