<?php require("view/inc/head.php");?>
	
	<form action="add.php" method=post>
		Title: <br /> <input type=text name=title /> <br />
		Ingredients: <br /> <textarea name=ingredients></textarea> <br />
		Instructions: <br /> <textarea name=instructions></textarea> <br />
		Time required: <br /> <input type=text name=time /> 
			(minutes) <br />
		<input type=submit value="Submit" /> <br />
	</form>
</body>

</html>

<?php

require("model/recipe.class.php");

$db = mysql_connect("127.0.0.1", "cookbook") or die(mysql_error());
mysql_select_db("cookbook") or die(mysql_error());

$recipe = new Recipe();

$recipe->setTitle($_POST["title"]);
$recipe->setIngredients($_POST["ingredients"]);
$recipe->setInstructions($_POST["instructions"]);
$recipe->setTimeRequired($_POST["time"]);

mysql_query($recipe->mysqlInsert());

$_POST = array();

?>