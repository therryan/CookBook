<?php

class Recipe
{
	/* --- Fields ---------------------------- */
	private $id;
	private $title;
	private $time;
	private $ingr;
	private $instr;
	
	/* --- Methods --------------------------- */
	public function __construct($requestedID)
	{
		if (is_numeric($requestedID))
		{
			$this->getRecipeByID($requestedID);
		}
	}
	
	public function getRecipeByID($requestedID)
	{
		if (is_numeric($requestedID))
		{
			$db = new mysqli("127.0.0.1", "cookbook", "", "cookbook");
			$data = $db->query("SELECT * FROM recipes WHERE id = $requestedID");

			$row = $data->fetch_assoc();
			$this->setTitle($row['title']);
			$this->setTime($row['time']);
			$this->setIngredients($row['ingredients']);
			$this->setInstructions($row['instructions']);
			
			$db->close();
		}
	}
	
	// Mainly for easy debugging
	public function repr()
	{
		echo "Title: " . $this->title . "<br />" .
		     "Time required: " . $this->time . " minutes <br />" .
		     "Ingredients: " . $this->ingr . "<br />" .
		     "Instructions: " . $this->instr . "<br />";
	}
	
	// Returns the SQL code for inserting itself into MySQL
	public function mysqlInsert()
	{
		return "INSERT INTO recipes " . 
		       "(title, time, ingredients, instructions) " .
		       "VALUES ('$this->title', $this->time, " .
		 	   "'$this->ingr', '$this->instr')";
	}
	
	/* --- Getters --------------------------- */
	public function getID() {return $this->id;}
	public function getTitle() {return $this->title;}
	public function getTimeRequired() {return $this->time;}
	public function getIngredients() {return $this->ingr;}
	public function getInstructions() {return $this->instr;}
	
	/* --- Setters --------------------------- */
	public function setTitle($newTitle) {$this->title = $newTitle;}
	public function setTime($newTime) {$this->time = $newTime;}
	public function setIngredients($newIngr) {$this->ingr = $newIngr;}
	public function setInstructions($newInstr) {$this->instr = $newInstr;}
}
?>