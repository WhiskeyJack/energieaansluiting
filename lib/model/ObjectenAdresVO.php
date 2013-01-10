<?php


// ObjectenAdresDAO Value Object
class ObjectenAdresVO extends BaseVO {
	var $ObjectID;
	var $ObjectAdres;
	var $LokatieNrNetwerkBeheerder;
	var $AansluitRegisterAdres;
	var $FactuurTenaamStelling;
	var $FactuurMoment;
	var $FactuurAdres;
	var $FactuurVerzameling;
	var $BetalingsWijze;
	var $GewijzigdDoor;
	var $GewijzigdOp;
  var $EanCode;
	var $InterneCodering;
	var $ObjectNaam;

	// create a new VO
	function ObjectenAdresVO(
		$ObjectID= 0,
		$ObjectAdres= 0,
		$LokatieNrNetwerkBeheerder= "",
		$AansluitRegisterAdres= 0,
		$FactuurTenaamStelling= 0,
		$FactuurMoment= "",
		$FactuurAdres= 0,
		$FactuurVerzameling= 0,
		$BetalingsWijze= "",
		$GewijzigdDoor= 0,
		$GewijzigdOp= "",
    $EanCode = 0,
		$InterneCodering = "",
    $ObjectNaam = ""
	) {
		$this->ObjectID = $ObjectID;
		$this->ObjectAdres = $ObjectAdres;
		$this->LokatieNrNetwerkBeheerder = $LokatieNrNetwerkBeheerder;
		$this->AansluitRegisterAdres = $AansluitRegisterAdres;
		$this->FactuurTenaamStelling = $FactuurTenaamStelling;
		$this->FactuurMoment = $FactuurMoment;
		$this->FactuurAdres = $FactuurAdres;
		$this->FactuurVerzameling = $FactuurVerzameling;
		$this->BetalingsWijze = $BetalingsWijze;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
    $this->EanCode = $EanCode;
		$this->InterneCodering = $InterneCodering;
		$this->ObjectNaam = $ObjectNaam;
	}

	// compare to another VO
	function equals($vo) {
		return $this->ObjectID == $vo->ObjectID &&
			$this->ObjectAdres == $vo->ObjectAdres &&
			$this->LokatieNrNetwerkBeheerder == $vo->LokatieNrNetwerkBeheerder &&
			$this->AansluitRegisterAdres == $vo->AansluitRegisterAdres &&
			$this->FactuurTenaamStelling == $vo->FactuurTenaamStelling &&
			$this->FactuurMoment == $vo->FactuurMoment &&
			$this->FactuurAdres == $vo->FactuurAdres &&
			$this->FactuurVerzameling == $vo->FactuurVerzameling &&
			$this->BetalingsWijze == $vo->BetalingsWijze &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->ObjectID = $vo->ObjectID;
		$this->ObjectAdres = $vo->ObjectAdres;
		$this->LokatieNrNetwerkBeheerder = $vo->LokatieNrNetwerkBeheerder;
		$this->AansluitRegisterAdres = $vo->AansluitRegisterAdres;
		$this->FactuurTenaamStelling = $vo->FactuurTenaamStelling;
		$this->FactuurMoment = $vo->FactuurMoment;
		$this->FactuurAdres = $vo->FactuurAdres;
		$this->FactuurVerzameling = $vo->FactuurVerzameling;
		$this->BetalingsWijze = $vo->BetalingsWijze;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return "ObjectID: " . $this->ObjectID . "\nObjectAdres: " . $this->ObjectAdres . "\nLokatieNrNetwerkBeheerder: " . $this->LokatieNrNetwerkBeheerder . "\nAansluitRegisterAdres: " . $this->AansluitRegisterAdres . "\nFactuurTenaamStelling: " . $this->FactuurTenaamStelling . "\nFactuurMoment: " . $this->FactuurMoment . "\nFactuurAdres: " . $this->FactuurAdres . "\nFactuurVerzameling: " . $this->FactuurVerzameling . "\nBetalingsWijze: " . $this->BetalingsWijze . "\nGewijzigdDoor: " . $this->GewijzigdDoor . "\nGewijzigdOp: " . $this->GewijzigdOp;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<ObjectID>$this->ObjectID</ObjectID>\n" .
		"<ObjectAdres>$this->ObjectAdres</ObjectAdres>\n" .
		"<LokatieNrNetwerkBeheerder>$this->LokatieNrNetwerkBeheerder</LokatieNrNetwerkBeheerder>\n" .
		"<AansluitRegisterAdres>$this->AansluitRegisterAdres</AansluitRegisterAdres>\n" .
		"<FactuurTenaamStelling>$this->FactuurTenaamStelling</FactuurTenaamStelling>\n" .
		"<FactuurMoment>$this->FactuurMoment</FactuurMoment>\n" .
		"<FactuurAdres>$this->FactuurAdres</FactuurAdres>\n" .
		"<FactuurVerzameling>$this->FactuurVerzameling</FactuurVerzameling>\n" .
		"<BetalingsWijze>$this->BetalingsWijze</BetalingsWijze>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->ObjectID = $this->formHelper("ObjectID", 0);
		$this->ObjectAdres = $this->formHelper("ObjectAdres", 0);
		$this->LokatieNrNetwerkBeheerder = $this->formHelper("LokatieNrNetwerkBeheerder", "");
		$this->AansluitRegisterAdres = $this->formHelper("AansluitRegisterAdres", 0);
		$this->FactuurTenaamStelling = $this->formHelper("FactuurTenaamStelling", 0);
		$this->FactuurMoment = $this->formHelper("FactuurMoment", "");
		$this->FactuurAdres = $this->formHelper("FactuurAdres", 0);
		$this->FactuurVerzameling = $this->formHelper("FactuurVerzameling", 0);
		$this->BetalingsWijze = $this->formHelper("BetalingsWijze", "");
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->ObjectID = $this->queryHelper("ObjectID", 0);
		$this->ObjectAdres = $this->queryHelper("ObjectAdres", 0);
		$this->LokatieNrNetwerkBeheerder = $this->queryHelper("LokatieNrNetwerkBeheerder", "");
		$this->AansluitRegisterAdres = $this->queryHelper("AansluitRegisterAdres", 0);
		$this->FactuurTenaamStelling = $this->queryHelper("FactuurTenaamStelling", 0);
		$this->FactuurMoment = $this->queryHelper("FactuurMoment", "");
		$this->FactuurAdres = $this->queryHelper("FactuurAdres", 0);
		$this->FactuurVerzameling = $this->queryHelper("FactuurVerzameling", 0);
		$this->BetalingsWijze = $this->queryHelper("BetalingsWijze", "");
		$this->GewijzigdDoor = $this->queryHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->queryHelper("GewijzigdOp", "");
	}

	// extra functions here
	function getPK() {
		return $this->ObjectID;
	}

	function validate_fields() {
		global $cfg;
		// check validity of all the VO fields
		// ObjectID must be an integer
		if (!(ereg("^[0-9]+$", $this->ObjectID))) $errors["ObjectID"] = "Object ID is niet correct";
		// ObjectAdres must be an integer
		if (!(ereg("^[0-9]+$", $this->ObjectAdres)) && ($this->ObjectAdres != "-2")) $errors["ObjectAdres"] = "Adres object is niet correct";
		// AansluitRegisterAdres must be an integer
		if (!(ereg("^[0-9]+$", $this->AansluitRegisterAdres)) && $this->AansluitRegisterAdres != "-2" && $this->AansluitRegisterAdres != "-3") $errors["AansluitRegisterAdres"] = "Adres aansluitregister is niet correct";
		// FactuurTenaamStelling must be < 50 characters  
		if (strlen($this->FactuurTenaamStelling) > 50) $errors["FactuurTenaamStelling"] = "Factuur naam is niet correct";
		// FactuurAdres must be an integer
		if (!(ereg("^[0-9]+$", $this->FactuurAdres)) && $this->FactuurAdres != "-2" && $this->FactuurAdres != "-3") $errors["FactuurAdres"] = "Factuur adres is niet correct";
		// FactuurMoment must be an array key
		if (!array_key_exists($this->FactuurMoment,$cfg['values']['factuurmoment'])) $errors["FactuurMoment"] = "Factuur moment is niet correct";
		// FactuurVerzameling must be an array key
		if (!array_key_exists($this->FactuurVerzameling,$cfg['values']['factuurverzameling'])) $errors["FactuurVerzameling"] = "Verzamel factuur veld is niet correct";
		// BetalingsWijze must be an array key
		if (!array_key_exists($this->BetalingsWijze,$cfg['values']['betalingswijze'])) $errors["BetalingsWijze"] = "Betalingswijze is niet correct";
		// LokatieNrNetwerkBeheerder must be < 30 characters  
		if (strlen($this->LokatieNrNetwerkBeheerder) > 30) $errors["LokatieNrNetwerkBeheerder"] = "Lokatienr netwerkbeheerder is niet correct";	
		// GewijzigdDoor must be an integer
		if (!(ereg("^[0-9]+$", $this->GewijzigdDoor))) $errors["GewijzigdDoor"] = "Gebruiker die wijzigt is niet correct";		
		// GewijzigdOp is inserted at time of query
	
	return($errors);
	}
	
}

?>