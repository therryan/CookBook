<?php
require_once("funcs.php");
require_once("view/tr/tr.php");

class Recipe
{
	/* --- Fields ---------------------------- */
	private $id;
	private $title;
	private $time;
	private $categoryID;
	private $ingr;
	private $instr;
	private $fav;
	private $portions;
	
	/* --- Magic Methods --------------------- */
	public function __construct($requestedID = "")
	{
		if (is_numeric($requestedID))
		{
			$this->getRecipeByID($requestedID);
		}
	}
	
	// Mostly for debugging, composeHTML should be used normally
	public function __toString()
	{
		$instr = "<ol>\n";
		foreach (explode("\n", $this->instr) as $val)
		{
			$instr .= "<li>$val</li>\n";
		}
		$instr .= "</ol>\n";
		
		$ingr = "<ul>\n";
		foreach (explode("\n", $this->ingr) as $val)
		{
			$ingr .= "<li>$val</li>\n";
		}
		$ingr .= "</ul>\n";
		
		return "<p>Title: ".$this->title."</p>".
		       "<p>Time required: ".$this->time." minutes</p>".
		       "<p>Ingredients: ".$ingr."</p>".
		       "<p>Instructions: ".$instr."</p>";
	}

	/* --- Methods --------------------------- */
	public function getRecipeByID($requestedID)
	{
		if (is_numeric($requestedID)) {
			$db = DBConnect();
			$stmt = $db->query("SELECT * FROM recipes WHERE id = $requestedID");
						
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->setID($row['id']);
			$this->setTitle($row['title']);
			$this->setCategoryByID($row['categoryID']);
			$this->setTime($row['time']);
			$this->setIngredients($row['ingredients']);
			$this->setInstructions($row['instructions']);
			$this->setFavorite($row['favorite']);
			$this->setPortions($row['portions']);

			$db = null;
		}
	}
	
	// Get the recipe by name, rather than by ID, presuming all titles are unique
	public function getRecipeByTitle($title)
	{
		$db = DBConnect();
		$stmt = $db->query("SELECT id FROM recipes WHERE title = '$title'");
		$id = $stmt->fetchColumn();	// Fetches the first column of the next row
		$this->getRecipeByID($id);
	}
	
	/* --- Database methods ------------------ */
	public function DBInsert()
	{
		//OLD
		$db = DBConnect();
		$db->query("INSERT INTO recipes ".
		           "(title, time, categoryID, ingredients, instructions, favorite) ".
		           "VALUES ('$this->title', '$this->time', ".
				   "'$this->categoryID', '$this->ingr', '$this->instr', ".
				   "'$this->fav')");
		$db = null;
	}
	
	public function DBUpdate()
	{
		//OLD
		$db = DBConnect();
		$db->query("UPDATE recipes ".
		           "SET title = '$this->title', ingredients = '$this->ingr', ".
		           "time = '$this->time', instructions = '$this->instr', ".
		           "categoryID = '$this->categoryID', favorite = '$this->fav' ".
		           "WHERE id = $this->id");
		$db = null;
	}
	
	public function DBDelete()
	{
		if (!$this->isEmpty())
		{
			$db = DBConnect();
			$db->query("DELETE FROM recipes ".
			           "WHERE id = $this->id");
			$db = null;
		}
	}	

	/* --- Web-related methods -------------- */	
	public function composeHTML($withLinks = TRUE)
	{
		// Portion slider
		$portionSlider = '<div id="slider" style="width:100px"></div>'.
						 '<p><label for="portions">'.trr("Portions:").'</label>'.
						 '<input type="text" id="portions" style="width:20px; margin-left:10px"'.
						 'value="'.$this->portions.'"/></p>';
		
		// Ingredients
		$ingr = "<ul id=\"ingredientList\">\n";
		foreach (explode("\n", $this->ingr) as $val) {
			// So that we can cross-reference other recipes
			// with the syntax: {<ID>|<What we want to be shown>}
			$val = preg_replace("/\{(\d+)\|([a-zA-Z ]+)\}/",
			"<a href=show.php?id=$1>$2</a>", $val);
			
			// Empty lines (that are 1 char long for some reason (\n?))
			// shouldn't show the list marker and now they are just empty
			if (strlen($val) <= 1) {
				$ingr .= "<br />";
			}
			else {
				$ingr .= "\t<li>$val</li>\n";
			}
		}
		$ingr .= "</ul>\n";
		
		// Instructions
		$instr = "<ol>\n";
		foreach (explode("\n", $this->instr) as $val) {
			$instr .= "\t<li>$val</li>\n";
		}
		$instr .= "</ol>\n";
	
		
		// The menu
		if ($withLinks) {
			$menu = "<ul class=hlist style=\"float:right;\">";
			$menu .= "<li><a href='edit.php?id=".$this->getID()
			    ."'>".trr("Edit")."</a></li>\n";
			$menu .= "<li><a href='edit.php?id=".$this->getID()
			    ."&action=confirm_deletion'>".trr("Delete")."</a></li>\n";
			$menu .= "<li><a href='print.php?id=".$this->getID()
			    ."'>".trr("Print")."</a></li>\n";
			$menu .= "</ul>";
		}
		else {
			$menu = "";
		}
		
		// Add the 'favorite'-indicator
		if ($this->fav == TRUE) {
			$fav = "<p>".trr("Favorite")."!</p>";
		}
		else {
			$fav = "";
		}
		
		// The actual code
		$contents = '<h2 id="title">'.$this->title.'</h2>'.
		
					$portionSlider.
		
					'<p class=italic id=categoryName>'
					    .$this->getCategoryName().'</p>'.
		
		            '<p>'.$this->time.' '.trr('minutes').'</p>'.
					$menu.
					$fav.
		
		            '<div class=rounded><h4>'.trr('Ingredients').'</h4> '
					    .$ingr.'</div>'.
					
		            '<div class=rounded><h4>'.trr('Instructions').'</h4>'
		                .$instr.'</div>';
		
		return $contents;
	}
	
	public function titleAsLink()
	{
		return "<p><a href=show.php?id=".$this->getID().">".$this->getTitle()
		."</a></p>\n";
	}
	
	/* --- Status Methods -------------------- */
	// We only need to check the ID, because it is set when reading from the database
	public function isEmpty()
	{
		if (is_null($this->id)) {
			return true;
		}
	}
	
	/* --- Getters --------------------------- */
	public function getID() {return $this->id;}
	public function getTitle() {return $this->title;}
	public function getTime() {return $this->time;}	
	public function getIngredients() {return $this->ingr;}
	public function getInstructions() {return $this->instr;}
	public function isFavorite() {return $this->fav;}
	public function getPortions() {return $this->portions;}
	public function getCategoryID() {return $this->categoryID;}
	public function getCategoryName()
	{
		$db = DBConnect();
		$stmt = $db->query(	"SELECT name FROM categories ".
		                    "WHERE id = ".$this->categoryID);
		$row = $stmt->fetch();
		$db = null;
		return $row["name"];
		
	}
	
	/* --- Setters --------------------------- */
	private function setID($newID) {$this->id = $newID;}
	public function setTitle($newTitle) {$this->title = $newTitle;}
	public function setTime($newTime) {$this->time = $newTime;}	
	public function setIngredients($newIngr) {$this->ingr = $newIngr;}
	public function setInstructions($newInstr) {$this->instr = $newInstr;}
	public function setPortions($newPortions) {$this->portions = $newPortions;}
	public function setCategoryByID($newCat) {$this->categoryID = $newCat;}
	public function setCategoryByName($newCatName)
	{
		//OLD
		$db = DBConnect();
		$newCatName = $db->real_escape_string($newCatName);
		
		$data = $db->query("SELECT id FROM categories ".
		                   "WHERE name = '".$newCatName."'");
		$row = $data->fetch_assoc();
		$this->setCategoryByID($row["id"]);
	}
	
	public function setFavorite($newFav)
	{
		$newFav = intval($newFav);
		if (is_numeric($newFav))
		{
			$newFav = (boolean)$newFav;
		}
		if (is_bool($newFav))
		{
			$this->fav = $newFav;
		}
	}
}
?>