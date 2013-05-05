<?php require_once('view/inc/head.php');

require_once('model/recipe.class.php');
require_once('model/funcs.php');

// Show a specific recipe
if (count($_GET) > 0 && array_key_exists('id', $_GET)) {
	$recipe = new Recipe($_GET['id']);
	
	if ($recipe->isEmpty()) {
		echo tr('This entry doesn\'t exist, please select another one.');
	}
	else {
		echo $recipe->composeHTML();
	}
}

// Show the names of all the recipes as links
else {
	$db = DBConnect();
	$stmt = $db->query('SELECT id FROM recipes');
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($data as $row) {
		$recipe = new Recipe($row['id']);
		echo $recipe->titleAsLink();
		unset($recipe);
	}

	$db = null;
}
?>
<script>
$(document).ready(function() {
	var originalSliderValue = $('#portions').val();	// To use as reference
	var $originalIngredients = $('#ingredientList').clone();
	
	// Creates the actual slider
	$('#slider').slider( {
		value: 2,
		min: 1,
		max: 10,
		step: 1,
		slide: function(event, ui) {
			$('#portions').val(ui.value);
			recalculateIngredients();
		}
	});
	
	// Number of portions can be changed from the input box as well
	$('#portions').change(function() {
		$('#slider').slider('value', $('#portions').val());
		recalculateIngredients();
	});
	
	// Set slider to the initial number of portions, as read from the database
	$('#slider').slider('value', $('#portions').val());
	
	// The function copies the original list, modifies that and then replaces
	// current list with the modified copy
	function recalculateIngredients() {
		$newIngredients = $originalIngredients.clone();
		$newIngredients.children().each(function() {
			var oldStr = $(this).text();
			// Regex: [One or more digits] [Optional period] [Optional digits]
			var newStr = oldStr.replace(/\d+\.?\d*/g, scaleNumeral);
			$(this).text(newStr);
		});
		$('#ingredientList').replaceWith($newIngredients);		
	}
	
	function scaleNumeral(match) {
		// Rounds the result to one decimal place
		return Math.round((match * ($('#portions').val() / originalSliderValue)) * 10) / 10;
	}
});
</script>
</body>
</html>