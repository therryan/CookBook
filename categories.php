<?php
require("view/inc/head.php");

// This is executed only after the user has ordered a new category to be added
if (isset($_GET["action"]) && $_GET["action"] == "add") {
	if (!empty($_POST["category"])) {
		$db = DBConnect();
		$stmt = $db->prepare("INSERT INTO categories (name) VALUES (:categoryName)");
		$stmt->execute(array(":categoryName" => $_POST["category"]));
		exit();
	}
}

// This is shown first
else {
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