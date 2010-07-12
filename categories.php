<?php require("view/inc/head.php");?>

<?php
require("model/funcs.php");

if ($_GET["action"] == "add")
{
	if (!empty($_POST["category"]))
	{
		$db = mysqliConnect();
		$categoryName = $db->real_escape_string($_POST["category"]);
		$query = "INSERT INTO categories ".
		         "(name) VALUES ('".
		         $categoryName."')";
		$db->query($query);
		exit();
	}
}
else
{
	echo "<a href=\"categories.php?action=add\">ADD</a>";
	exit();
}

?>
<form method=post>
	<div>
		<p><?php tr("Category name");?>:</p><input type=text name=category />
	</div>
	<input type=submit value=<?php tr("Save");?> />
</body>
</html>