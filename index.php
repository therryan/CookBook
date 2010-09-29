<?php require("view/inc/head.php");?>

<form action=search.php method=get>
	<input type=text name=all value="<?php tr("Search everything");?>"
	    onfocus="this.value = ''">
	<input type=submit value="<?php tr("Search");?>">
</form>

<form action=add.php method=get>
	<input type=text name=title value="<?php tr("Title for the recipe");?>"
	    onfocus="this.value = ''">
	<input type=submit value="<?php tr("Create new");?>">
</form>

</body>
</html>