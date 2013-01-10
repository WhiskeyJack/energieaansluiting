<?php

// FiscaleGroepen Value Object
class FiscaleGroepenVO extends BaseVO {
	var $FiscaalGroepID;
	var $FiscaalGroupType;
	var $GewijzigdDoor;
	var $GewijzigdOp;

	// create a new VO
	function FiscaleGroepenVO(
		$FiscaalGroepID= 0,
		$FiscaalGroupType= 0,
		$GewijzigdDoor= 0,
		$GewijzigdOp= ""
	) {
		$this->FiscaalGroepID = $FiscaalGroepID;
		$this->FiscaalGroupType = $FiscaalGroupType;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
	}

	// compare to another VO
	function equals($vo) {
		return $this->FiscaalGroepID == $vo->FiscaalGroepID &&
			$this->FiscaalGroupType == $vo->FiscaalGroupType &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->FiscaalGroepID = $vo->FiscaalGroepID;
		$this->FiscaalGroupType = $vo->FiscaalGroupType;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return $this->FiscaalGroepID . "," . $this->FiscaalGroupType . "," . $this->GewijzigdDoor . "," . $this->GewijzigdOp;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<FiscaalGroepID>$this->FiscaalGroepID</FiscaalGroepID>\n" .
		"<FiscaalGroupType>$this->FiscaalGroupType</FiscaalGroupType>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->FiscaalGroepID = $this->formHelper("FiscaalGroepID", 0);
		$this->FiscaalGroupType = $this->formHelper("FiscaalGroupType", 0);
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->FiscaalGroepID = $this->queryHelper("FiscaalGroepID", 0);
		$this->FiscaalGroupType = $this->queryHelper("FiscaalGroupType", 0);
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->FiscaalGroepID;
	}
}