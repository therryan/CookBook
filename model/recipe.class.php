<?php
require_once("ingredient.class.php");

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
	
	public function __toString()
	{
		return $this->repr();
	}

	/* --- Methods --------------------------- */
	public function getRecipeByID($requestedID)
	{
		if (is_numeric($requestedID))
		{
			$db = new mysqli("127.0.0.1", "cookbook", "", "cookbook");
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

	public function repr()
	{
		return "<p>Title: ".$this->title."</p>".
		       "<p>Time required: ".$this->time." minutes</p>".
		       "<p>Ingredients: ".$this->ingr."</p>".
		       "<p>Instructions: ".$this->instr."</p>";
	}
	
	
	public function composeHTML()
	{
		$contents = $this->repr();
		$contents .= "<p><a href='edit.php?id=".$this->getID()."'>Edit this entry</a></p>\n";
		$contents .= "<p><a href='print.php?id=".$this->getID()."'>Print friendly</a></p>\n";
		
		return $contents;
	}
	
	// Returns the SQL code for inserting itself into MySQL
	public function mysqlInsert()
	{
		return "INSERT INTO recipes ".
		       "(title, time, ingredients, instructions) ".
		       "VALUES ('$this->title', $this->time, ".
		 	   "'$this->ingr', '$this->instr')";
	}
	
	/* --- Getters --------------------------- */
	public function getID() {return $this->id;}
	public function getTitle() {return $this->title;}
	public function getTimeRequired() {return $this->time;}
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