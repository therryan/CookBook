<?php require("view/inc/head.php");?>
	
	<form action="add.php" method=post>
		<div>
			<p>Title:</p> <input type=text name=title />
		</div>
		<div>
			<p>Ingredients:</p> <textarea name=ingredients></textarea>
		</div>
		<div>
			<p>Instructions:</p> <textarea name=instructions></textarea>
		</div>
		<div>
			<p>Time required:</p> <input type=text name=time /> minutes
		</div>
		<input type=submit value="Submit" /> <br />
	</form>
	
</body>

</html>

<?php

require("model/recipe.class.php");

$db = mysql_connect("127.0.0.1", "cookbook") or die(mysql_error());
mysql_select_db("cookbook") or die(mysql_error());

// Insert the data to MySQL by creating a new Recipe-object
$recipe = new Recipe();

$recipe->setTitle($_POST["title"]);
$recipe->setIngredients($_POST["ingredients"]);
$recipe->setInstructions($_POST["instructions"]);
$recipe->setTimeRequired($_POST["time"]);

mysql_query($recipe->mysqlInsert());

// Empty the POST array by initing it
$_POST = array();

?>