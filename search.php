<?php require_once('view/inc/head.php');?>

<?php
require_once('model/recipe.class.php');
require_once('model/funcs.php');

if (count($_GET) > 0) {
	$db = DBConnect();	
	
	if (!empty($_GET['title'])) {
		// The % operator can't be directly put in the statement
		$stmt = $db->prepare('SELECT id FROM recipes WHERE title LIKE :title');
		$stmt->execute(array('title' => '%'.$_GET['title'].'%'));
	}
	elseif (!empty($_GET['all'])) {
		$searchString = '%'.$_GET['all'].'%';
		
		// Note! There were some problems with using the :all several times,
		// but everything seems to be working nonetheless.
		$stmt = $db->prepare('SELECT id FROM recipes WHERE title LIKE :all
							  OR instructions LIKE :all
							  OR ingredients LIKE :all');
		$stmt->execute(array('all' => $searchString));
	}
	elseif (!empty($_GET['ingredients'])) {
		$stmt = $db->prepare('SELECT id FROM recipes WHERE ingredients LIKE :ingredients');
		$stmt->execute(array('ingredients' => '%'.$_GET['ingredients'].'%'));
	}
	
	// GET contains some unknown value, abort
	else {
		sLog('Unknown value in GET', 'error');
	}
	
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	// If we found something, display the results
	if (count($data) > 0) {
		foreach ($data as $row) {
			$recipe = new Recipe($row['id']);
			echo $recipe->titleAsLink();
			unset($recipe);
		}
		echo '<p><a href=search.php>'.trr('Search again').'</a></p>';
		// If we've found something, let's not show the forms
		exit();
	}
	else {
		echo '<p>'.trr('Your search query didn\'t match anything. Please try again.').'</p>\n';
	}
}
?>
<form action='search.php' method=get>
	<div>
		<p><?php tr('Search everything');?>:</p><input type=text name=all>
	</div>
	<div>
		<p><?php tr('Search titles');?>:</p><input type=text name=title>
	</div>
	<div>
		<p><?php tr('Search ingredients');?>:</p><input type=text name=ingredients>
	</div>
	<input type=submit value=<?php tr('Search');?>>
</body>
</html>