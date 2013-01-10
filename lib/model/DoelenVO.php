<?php

// Doelen Value Object
class DoelenVO extends BaseVO {
	var $DoelID;
	var $Omschrijving;
	var $GewijzigdDoor;
	var $GewijzigdOp;

	// create a new VO
	function DoelenVO(
		$DoelID= 0,
		$Omschrijving= 0,
		$GewijzigdDoor= 0,
		$GewijzigdOp= ""
	) {
		$this->DoelID = $DoelID;
		$this->Omschrijving = $Omschrijving;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
	}

	// compare to another VO
	function equals($vo) {
		return $this->DoelID == $vo->DoelID &&
			$this->Omschrijving == $vo->Omschrijving &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->DoelID = $vo->DoelID;
		$this->Omschrijving = $vo->Omschrijving;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return $this->DoelID . "," . $this->Omschrijving . "," . $this->GewijzigdDoor . "," . $this->GewijzigdOp;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<DoelID>$this->DoelID</DoelID>\n" .
		"<Omschrijving>$this->Omschrijving</Omschrijving>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->DoelID = $this->formHelper("DoelID", 0);
		$this->Omschrijving = $this->formHelper("Omschrijving", 0);
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->DoelID = $this->queryHelper("DoelID", 0);
		$this->Omschrijving = $this->queryHelper("Omschrijving", 0);
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->DoelID;
	}
}