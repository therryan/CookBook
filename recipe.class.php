<?php

class Recipe
{
	/* --- Variables ------------------------- */
	private $id;
	private $title;
	private $time;
	private $ingr;
	private $instr;
	
	/* --- Representation -------------------- */
	
	public function repr()
	{
		echo "Title: " . $this->title . "<br />" .
		     "Time required: " . $this->time . "<br />" .
		     "Ingredients: " . $this->ingr . "<br />" .
		     "Instructions: " . $this->instr . "<br />";
	}
	
	public function mysqlInsert()
	{
		return "INSERT INTO recipes " . 
		       "(title, time, ingredients, instructions) " .
		       "VALUES ('$this->title', $this->time, " .
		 	   "'$this->ingr', '$this->instr')";
	}
	
	/* --- Getters --------------------------- */
	public function getID()
	{
		return $this->id;
	}
	
	public function getTitle()
	{
		return $this->title;
	}

	public function getTimeRequired()
	{
		return $this->time;
	}
	
	public function getIngredients()
	{
		return $this->ingr;
	}
	
	public function getInstructions()
	{
		return $this->instr;
	}
	
	/* --- Setters --------------------------- */
	public function setTitle($newTitle)
	{
		$this->title = $newTitle;
	}
	
	public function setTimeRequired($newTime)
	{
		$this->time = $newTime;
	}
	
	public function setIngredients($newIngr)
	{
		$this->ingr = $newIngr;
	}
	
	public function setInstructions($newInstr)
	{
		$this->instr = $newInstr;
	}
}

?>