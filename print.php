<?php
if (!(count($_GET) > 0) || !is_numeric($_GET["id"]))
{
	// The user can choose the entry they want to edit here
	header("Location: show.php");
	
	// So that nothing else gets executed
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="view/styles/main.css">
	<link rel="stylesheet" type="text/css" href="view/styles/print.css">
</head>

<body>
<?php
require_once("model/recipe.class.php");

$recipe = new Recipe($_GET["id"]);
echo $recipe->repr();

?>
</body>
</html>