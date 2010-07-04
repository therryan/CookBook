<?php

class Ingredient
{
	/* --- Fields ---------------------------- */
	private $stuff;
	private $amount;
	private $unit;
	
	/* --- Getters --------------------------- */
	public function getstuff() {return $this->$stuff;}
	public function getAmount() {return $this->$amount;}
	public function getUnit() {return $this->$unit;}
	
	/* --- Setters --------------------------- */
	public function setStuff($newStuff) {$this->$stuff = $newStuff;}
	public function setAmount($newAmount) {$this->$amount = $newAmount;}
	public function setUnit($newUnit) {$this->$unit = $newUnit;}
}
?>