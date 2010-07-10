<?php
require_once("funcs.php");
require_once("view/tr/tr.php");

class Recipe
{
	/* --- Fields ---------------------------- */
	private $id;
	private $title;
	private $time;
	private $ingr;
	private $instr;
	
	/* --- Magic Methods --------------------- */
	public function __construct($requestedID)
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
		
		if (is_numeric($requestedID))
		{
			$db = mysqliConnect();
			
			$data = $db->query("SELECT * FROM recipes WHERE id = $requestedID");

			$row = $data->fetch_assoc();
			$this->setID($row["id"]);
			$this->setTitle($row["title"]);
			$this->setTime($row["time"]);
			$this->setIngredients($row["ingredients"]);
			$this->setInstructions($row["instructions"]);
		
			$db->close();
		}
	}
	
	/* --- Database methods ------------------ */
	public function mysqlInsert()
	{
		$db = mysqliConnect();
		$db->query("INSERT INTO recipes ".
		           "(title, time, ingredients, instructions) ".
		           "VALUES ('$this->title', '$this->time', ".
				   "'$this->ingr', '$this->instr')");
		$db->close();
	}
	
	public function mysqlUpdate()
	{
		$db = mysqliConnect();
		$db->query("UPDATE recipes ".
		           "SET title = '$this->title', ingredients = '$this->ingr', ".
		           "time = '$this->time', instructions = '$this->instr' ".
		           "WHERE id = $this->id");
		$db->close();
	}
	
	public function mysqlDelete()
	{
		if (!$this->isEmpty())
		{
			$db = mysqliConnect();
			$db->query("DELETE FROM recipes ".
			           "WHERE id = $this->id");
			$db->close();
		}
	}	

	/* --- Web-related methods -------------- */	
	public function composeHTML($withLinks = TRUE)
	{
		// Instructions
		$instr = "<ol>\n";
		foreach (explode("\n", $this->instr) as $val)
		{
			$instr .= "<li>$val</li>\n";
		}
		$instr .= "</ol>\n";
		
		// Ingredients
		$ingr = "<ul>\n";
		foreach (explode("\n", $this->ingr) as $val)
		{
			// So that we can cross-reference other recipes
			// with the syntax: {<ID>|<What we want to be shown>}
			$val = preg_replace("/\{(\d+)\|([a-z]+)\}/",
			"<a href=show.php?id=$1>$2</a>", $val);
			
			$ingr .= "<li>$val</li>\n";
		}
		$ingr .= "</ul>\n";
		
		// The menu
		if ($withLinks)
		{
			$menu = "<ul class=hlist style=\"float:right;\">";
			$menu .= "<li><a href='edit.php?id=".$this->getID()
			    ."'>".trr("Edit")."</a></li>\n";
			$menu .= "<li><a href='edit.php?id=".$this->getID()
			    ."&action=confirm_deletion'>".trr("Delete")."</a></li>\n";
			$menu .= "<li><a href='print.php?id=".$this->getID()
			    ."'>".trr("Print")."</a></li>\n";
			$menu .= "</ul>";
		}
		else
		{
			$menu = "";
		}
		
		// The actual code
		$contents = "<h2>".$this->title."</h2>".
		
		            "<p>".$this->time." ".trr("minutes")."</p>".$menu.
		
		            "<div class=rounded><h4>".trr("Ingredients")."</h4> "
					    .$ingr."</div>".
					
		            "<div class=rounded><h4>".trr("Instructions")."</h4>"
		                .$instr."</div>";
		
		return $contents;
	}
	
	public function titleAsLink()
	{
		return "<p><a href=show.php?id=".$this->getID().">"
		.$this->getTitle()."</a></p>\n";
	}
	
	/* --- Status Methods -------------------- */
	// We only need to check the ID, because it is set when reading from MySQL
	public function isEmpty()
	{
		if (is_null($this->id))
		{
			return true;
		}
	}
	
	/* --- Getters --------------------------- */
	public function getID() {return $this->id;}
	public function getTitle() {return $this->title;}
	public function getTime() {return $this->time;}
	public function getIngredients() {return $this->ingr;}
	public function getInstructions() {return $this->instr;}
	
	/* --- Setters --------------------------- */
	private function setID($newID) {$this->id = $newID;}
	public function setTitle($newTitle) {$this->title = $newTitle;}
	public function setTime($newTime) {$this->time = $newTime;}
	public function setIngredients($newIngr) {$this->ingr = $newIngr;}
	public function setInstructions($newInstr) {$this->instr = $newInstr;}
}
?>