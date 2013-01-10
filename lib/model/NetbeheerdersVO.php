<?php

// Netbeheerders Value Object
class NetbeheerdersVO extends BaseVO {
	var $NetBeheerderID;
	var $NetBeheerderEAN;
	var $NetBeheerderNaam;
	var $NetBeheerderContactPersoon;
	var $NetBeheerderTelefoonNummer;
	var $GewijzigdDoor;
	var $GewijzigdOp;

	// create a new VO
	function NetbeheerdersVO(
		$NetBeheerderID= 0,
		$NetBeheerderEAN= "",
		$NetBeheerderNaam= 0,
		$NetBeheerderContactPersoon= 0,
		$NetBeheerderTelefoonNummer= 0,
		$GewijzigdDoor= 0,
		$GewijzigdOp= ""
	) {
		$this->NetBeheerderID = $NetBeheerderID;
		$this->NetBeheerderEAN = $NetBeheerderEAN;
		$this->NetBeheerderNaam = $NetBeheerderNaam;
		$this->NetBeheerderContactPersoon = $NetBeheerderContactPersoon;
		$this->NetBeheerderTelefoonNummer = $NetBeheerderTelefoonNummer;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
	}

	// compare to another VO
	function equals($vo) {
		return $this->NetBeheerderID == $vo->NetBeheerderID &&
			$this->NetBeheerderEAN == $vo->NetBeheerderEAN &&
			$this->NetBeheerderNaam == $vo->NetBeheerderNaam &&
			$this->NetBeheerderContactPersoon == $vo->NetBeheerderContactPersoon &&
			$this->NetBeheerderTelefoonNummer == $vo->NetBeheerderTelefoonNummer &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->NetBeheerderID = $vo->NetBeheerderID;
		$this->NetBeheerderEAN = $vo->NetBeheerderEAN;
		$this->NetBeheerderNaam = $vo->NetBeheerderNaam;
		$this->NetBeheerderContactPersoon = $vo->NetBeheerderContactPersoon;
		$this->NetBeheerderTelefoonNummer = $vo->NetBeheerderTelefoonNummer;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return $this->NetBeheerderID . "," . $this->NetBeheerderEAN . "," . $this->NetBeheerderNaam . "," . $this->NetBeheerderContactPersoon . "," . $this->NetBeheerderTelefoonNummer . "," . $this->GewijzigdDoor . "," . $this->GewijzigdOp;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<NetBeheerderID>$this->NetBeheerderID</NetBeheerderID>\n" .
		"<NetBeheerderEAN>$this->NetBeheerderEAN</NetBeheerderEAN>\n" .
		"<NetBeheerderNaam>$this->NetBeheerderNaam</NetBeheerderNaam>\n" .
		"<NetBeheerderContactPersoon>$this->NetBeheerderContactPersoon</NetBeheerderContactPersoon>\n" .
		"<NetBeheerderTelefoonNummer>$this->NetBeheerderTelefoonNummer</NetBeheerderTelefoonNummer>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->NetBeheerderID = $this->formHelper("NetBeheerderID", 0);
		$this->NetBeheerderEAN = $this->formHelper("NetBeheerderEAN", "");
		$this->NetBeheerderNaam = $this->formHelper("NetBeheerderNaam", 0);
		$this->NetBeheerderContactPersoon = $this->formHelper("NetBeheerderContactPersoon", 0);
		$this->NetBeheerderTelefoonNummer = $this->formHelper("NetBeheerderTelefoonNummer", 0);
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->NetBeheerderID = $this->queryHelper("NetBeheerderID", 0);
		$this->NetBeheerderEAN = $this->queryHelper("NetBeheerderEAN", "");
		$this->NetBeheerderNaam = $this->queryHelper("NetBeheerderNaam", 0);
		$this->NetBeheerderContactPersoon = $this->queryHelper("NetBeheerderContactPersoon", 0);
		$this->NetBeheerderTelefoonNummer = $this->queryHelper("NetBeheerderTelefoonNummer", 0);
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->NetBeheerderID;
	}
}

?>