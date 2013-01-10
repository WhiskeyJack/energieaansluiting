<?php

// Adressen Value Object
class AdressenVO extends BaseVO {
	var $AdresID;
	var $AdresRegel1;
	var $StraatNaam;
	var $Huisnummer;
	var $HuisnummerToevoeging;
	var $Postcode;
	var $Plaats;
	var $Land;
	var $GewijzigdDoor;
	var $GewijzigdOp;

	// create a new VO
	function AdressenVO(
		$AdresID= 0,
		$AdresRegel1= 0,
		$StraatNaam= "",
		$Huisnummer= 0,
		$HuisnummerToevoeging= "",
		$Postcode= "",
		$Plaats= "",
		$Land= 0,
		$GewijzigdDoor= 0,
		$GewijzigdOp= ""
	) {
		$this->AdresID = $AdresID;
		$this->AdresRegel1 = $AdresRegel1;
		$this->StraatNaam = $StraatNaam;
		$this->Huisnummer = $Huisnummer;
		$this->HuisnummerToevoeging = $HuisnummerToevoeging;
		$this->Postcode = $Postcode;
		$this->Plaats = $Plaats;
		$this->Land = $Land;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
	}

	// compare to another VO
	function equals($vo) {
		return $this->AdresID == $vo->AdresID &&
			$this->AdresRegel1 == $vo->AdresRegel1 &&
			$this->StraatNaam == $vo->StraatNaam &&
			$this->Huisnummer == $vo->Huisnummer &&
			$this->HuisnummerToevoeging == $vo->HuisnummerToevoeging &&
			$this->Postcode == $vo->Postcode &&
			$this->Plaats == $vo->Plaats &&
			$this->Land == $vo->Land &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->AdresID = $vo->AdresID;
		$this->AdresRegel1 = $vo->AdresRegel1;
		$this->StraatNaam = $vo->StraatNaam;
		$this->Huisnummer = $vo->Huisnummer;
		$this->HuisnummerToevoeging = $vo->HuisnummerToevoeging;
		$this->Postcode = $vo->Postcode;
		$this->Plaats = $vo->Plaats;
		$this->Land = $vo->Land;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return $this->AdresID . "," . $this->AdresRegel1 . "," . $this->StraatNaam . "," . $this->Huisnummer . "," . $this->HuisnummerToevoeging . "," . $this->Postcode . "," . $this->Plaats . "," . $this->Land . "," . $this->GewijzigdDoor . "," . $this->GewijzigdOp;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<AdresID>$this->AdresID</AdresID>\n" .
		"<AdresRegel1>$this->AdresRegel1</AdresRegel1>\n" .
		"<StraatNaam>$this->StraatNaam</StraatNaam>\n" .
		"<Huisnummer>$this->Huisnummer</Huisnummer>\n" .
		"<HuisnummerToevoeging>$this->HuisnummerToevoeging</HuisnummerToevoeging>\n" .
		"<Postcode>$this->Postcode</Postcode>\n" .
		"<Plaats>$this->Plaats</Plaats>\n" .
		"<Land>$this->Land</Land>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->AdresID = $this->formHelper("AdresID", 0);
		$this->AdresRegel1 = $this->formHelper("AdresRegel1", 0);
		$this->StraatNaam = $this->formHelper("StraatNaam", "");
		$this->Huisnummer = $this->formHelper("Huisnummer", 0);
		$this->HuisnummerToevoeging = $this->formHelper("HuisnummerToevoeging", "");
		$this->Postcode = $this->formHelper("Postcode", "");
		$this->Plaats = $this->formHelper("Plaats", "");
		$this->Land = $this->formHelper("Land", 0);
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->AdresID = $this->queryHelper("AdresID", 0);
		$this->AdresRegel1 = $this->queryHelper("AdresRegel1", 0);
		$this->StraatNaam = $this->queryHelper("StraatNaam", "");
		$this->Huisnummer = $this->queryHelper("Huisnummer", 0);
		$this->HuisnummerToevoeging = $this->queryHelper("HuisnummerToevoeging", "");
		$this->Postcode = $this->queryHelper("Postcode", "");
		$this->Plaats = $this->queryHelper("Plaats", "");
		$this->Land = $this->queryHelper("Land", 0);
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->AdresID;
	}
}

?>