<?php

class Ingredient
{
	/* --- Fields ---------------------------- */
	private $amount;
	private $unit;
	private $stuff;

	/* --- Magic Methods --------------------- */
	public function __construct($amount, $unit, $stuff)
	{
		$this->$amount = $amount;
		$this->$unit = $unit;
		$this->$stuff = $stuff;
	}
	
	public function __toString()
	{
		return "$amount $unit $substance";
	}
	
	/* --- Methods --------------------------- */
	
	/* --- Getters --------------------------- */
	public function getAmount() {return $this->amount;}
	public function getUnit() {return $this->unit;}
	public function getStuff() {return $this->stuff;}
	
	/* --- Setters --------------------------- */
	public function setAmount($newAmount) {$this->amount = $newAmount;}
	public function setUnit($newUnit) {$this->unit = $newUnit;}
	public function setStuff($newStuff) {$this->stuff = $newStuff;}
}
?>