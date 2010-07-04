<?php require_once("view/inc/head.php");?>
	
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

require_once("model/recipe.class.php");

$db = new mysqli("127.0.0.1", "cookbook", "", "cookbook") or die(mysqli_error($db));

// Insert the data to MySQL by creating a new Recipe-object
$recipe = new Recipe();

$recipe->setTitle($_POST["title"]);
$recipe->setIngredients($_POST["ingredients"]);
$recipe->setInstructions($_POST["instructions"]);
$recipe->setTimeRequired($_POST["time"]);

$db->query($recipe->mysqlInsert());

// Empty the POST array by initing it
$_POST = array();

?>