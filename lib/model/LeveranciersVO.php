<?php

// Leveranciers Value Object
class LeveranciersVO extends BaseVO {
	var $LeverancierID;
	var $LeverancierEAN;
	var $LeverancierNaam;
	var $LeverancierContactPersoon;
	var $LeverancierTelefoonNummer;
	var $GewijzigdDoor;
	var $GewijzigdOp;

	// create a new VO
	function LeveranciersVO(
		$LeverancierID= 0,
		$LeverancierEAN= "",
		$LeverancierNaam= 0,
		$LeverancierContactPersoon= 0,
		$LeverancierTelefoonNummer= 0,
		$GewijzigdDoor= 0,
		$GewijzigdOp= ""
	) {
		$this->LeverancierID = $LeverancierID;
		$this->LeverancierEAN = $LeverancierEAN;
		$this->LeverancierNaam = $LeverancierNaam;
		$this->LeverancierContactPersoon = $LeverancierContactPersoon;
		$this->LeverancierTelefoonNummer = $LeverancierTelefoonNummer;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
	}

	// compare to another VO
	function equals($vo) {
		return $this->LeverancierID == $vo->LeverancierID &&
			$this->LeverancierEAN == $vo->LeverancierEAN &&
			$this->LeverancierNaam == $vo->LeverancierNaam &&
			$this->LeverancierContactPersoon == $vo->LeverancierContactPersoon &&
			$this->LeverancierTelefoonNummer == $vo->LeverancierTelefoonNummer &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->LeverancierID = $vo->LeverancierID;
		$this->LeverancierEAN = $vo->LeverancierEAN;
		$this->LeverancierNaam = $vo->LeverancierNaam;
		$this->LeverancierContactPersoon = $vo->LeverancierContactPersoon;
		$this->LeverancierTelefoonNummer = $vo->LeverancierTelefoonNummer;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return $this->LeverancierID . "," . $this->LeverancierEAN . "," . $this->LeverancierNaam . "," . $this->LeverancierContactPersoon . "," . $this->LeverancierTelefoonNummer . "," . $this->GewijzigdDoor . "," . $this->GewijzigdOp;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<LeverancierID>$this->LeverancierID</LeverancierID>\n" .
		"<LeverancierEAN>$this->LeverancierEAN</LeverancierEAN>\n" .
		"<LeverancierNaam>$this->LeverancierNaam</LeverancierNaam>\n" .
		"<LeverancierContactPersoon>$this->LeverancierContactPersoon</LeverancierContactPersoon>\n" .
		"<LeverancierTelefoonNummer>$this->LeverancierTelefoonNummer</LeverancierTelefoonNummer>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->LeverancierID = $this->formHelper("LeverancierID", 0);
		$this->LeverancierEAN = $this->formHelper("LeverancierEAN", "");
		$this->LeverancierNaam = $this->formHelper("LeverancierNaam", 0);
		$this->LeverancierContactPersoon = $this->formHelper("LeverancierContactPersoon", 0);
		$this->LeverancierTelefoonNummer = $this->formHelper("LeverancierTelefoonNummer", 0);
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->LeverancierID = $this->queryHelper("LeverancierID", 0);
		$this->LeverancierEAN = $this->queryHelper("LeverancierEAN", "");
		$this->LeverancierNaam = $this->queryHelper("LeverancierNaam", 0);
		$this->LeverancierContactPersoon = $this->queryHelper("LeverancierContactPersoon", 0);
		$this->LeverancierTelefoonNummer = $this->queryHelper("LeverancierTelefoonNummer", 0);
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->LeverancierID;
	}
}

?>