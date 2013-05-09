<?php
require('model/recipe.class.php');

// This has to be before the redirect
/* After the user has clicked on 'Submit', insert the new recipe into the database */
if (count($_POST) > 0) {
	$recipe = new Recipe();
	$recipe->setTitle($_POST['title']);
	$recipe->setIngredients($_POST['ingredients']);
	$recipe->setInstructions($_POST['instructions']);
	$recipe->setTime($_POST['time']);
	$recipe->setCategoryByID($_POST['category']);
	$recipe->setPortions($_POST['portions']);
	$recipe->DBInsert();
}

// count() is used, because when the user enters 'add.php' normally, $_GET is empty, which makes PHP unhappy
/* After the recipe has been added, redirect the user to the new recipe's page */
if (count($_GET) > 0 && $_GET['action'] == 'show') {
	$recipe = new Recipe();
	$recipe->getRecipeByTitle($_POST['title']);			// Titles have to be unique
	header('Location: show.php?id='.$recipe->getID());
}

// This has been moved here because of 'header()'
require('view/inc/head.php');

// Empty the POST array by initing it
$_POST = array();
?>
<form action='add.php?action=show' method=post>
	<div>
		<p><?php tr('Title');?>: <input type=text name=title id='title'
  <?php // If the user came to add.php from index.php, pre-populate the title
        // The extra quotes are there to make sure that multi-word titles are displayed correctly
  if (count($_GET) > 0 && strlen($_GET['title']) > 0) {
      echo 'value="'.$_GET['title'].'"'; } ?> /></p>
	</div>
	<p><?php tr('Category');?>:
	<select name=category id='category'>
		<?php
			$db = DBConnect();
			$stmt = $db->query('SELECT * FROM categories');
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			// Set the default to --- 'None'
			echo '<option value="0"></option>';
			
			// Populate the 'select' with the categories from the database
			foreach ($data as $row) {				
				echo '<option value="'.$row['id'].'">'.
				     $row['name']."</option>\n\r";
			}
		?>
	</select></p>
	<div>
		<p><?php tr('Portions:'); ?><input type=text name=portions id='portions' /></p>
		<p><?php tr('Ingredients');?>:</p> <textarea name=ingredients id='ingredients' rows=10 cols=40></textarea>
	</div>
	<div>
		<p><?php tr('Instructions');?>:</p> <textarea name=instructions id='instructions' rows=20 cols=80></textarea>
	</div>
	<div>
		<p><?php tr('Time required');?>:</p> <input type=text name=time id='time' />
		<?php tr('minutes');?> 
	</div>
	<input type=button id='emptyButton' value=<?php tr('Empty');?> />
	<input type=submit value=<?php tr('Save');?> />
</form>
</div>
<script>
$(document).ready(function() {
	function loadFromLocalStorage() {
		$('#title').val(localStorage['title']);
		$('#category').val(localStorage['category']);
		$('#ingredients').val(localStorage['ingredients']);
		$('#instructions').val(localStorage['instructions']);
		$('#time').val(localStorage['time']);
	}
	function updateLocalStorage() {		
		localStorage['title'] = $('#title').val();
		localStorage['category'] = $('#category').val();
		localStorage['ingredients'] = $('#ingredients').val();
		localStorage['instructions'] = $('#instructions').val();
		localStorage['time'] = $('#time').val();
	}
	
	// So that if the title is prepopulated, it's not erased immediately
	if ($('#title').val() != ""){
		updateLocalStorage();
	}
	
	loadFromLocalStorage();
	
	// Starts the updates
	window.setInterval(function(){ updateLocalStorage(); }, 3000);
	
	$('#emptyButton').click(function() {
		// type=text so that the buttons aren't emptied
		$('form').find('textarea, input[type*="text"], select').val('');
		$('#category').val('0');
	});
});

</script>
</body>
</html>