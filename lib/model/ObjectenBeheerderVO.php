<?php


// ObjectenBeheerder Value Object
class ObjectenBeheerderVO extends BaseVO {
	var $ObjectID;
	var $NetBeheerderID;
	var $LeverancierID;
	var $IngangsDatumLeverancier;
	var $StroomType;
	var $ContractNummerNetbeheerder;
	var $ContractNummerLeverancier;
	var $GewijzigdDoor;
	var $GewijzigdOp;
	var $EanCode;
	var $InterneCodering;
	var $ObjectNaam;
	var $LeverancierEAN;
	var $LeverancierNaam;
	var $NetbeheerderEAN;
	var $NetbeheerderNaam;

	// create a new VO
	function ObjectenBeheerderVO(
		$ObjectID= 0,
		$NetBeheerderID= 0,
		$LeverancierID= 0,
		$IngangsDatumLeverancier= "",
		$StroomType= 0,
		$ContractNummerNetbeheerder= "",
		$ContractNummerLeverancier= "",
		$GewijzigdDoor= 0,
		$GewijzigdOp= "",
		$EanCode = 0,
		$InterneCodering = "",
    $ObjectNaam = "",
    $LeverancierEAN = 0,
		$LeverancierNaam = "",
		$NetbeheerderEAN = 0,
		$NetbeheerderNaam = ""  	
	) {
		$this->ObjectID = $ObjectID;
		$this->NetBeheerderID = $NetBeheerderID;
		$this->LeverancierID = $LeverancierID;
		$this->IngangsDatumLeverancier = $IngangsDatumLeverancier;
		$this->StroomType = $StroomType;
		$this->ContractNummerNetbeheerder = $ContractNummerNetbeheerder;
		$this->ContractNummerLeverancier = $ContractNummerLeverancier;
		$this->GewijzigdDoor = $GewijzigdDoor;
		$this->GewijzigdOp = $GewijzigdOp;
		$this->EanCode = $EanCode;
		$this->InterneCodering = $InterneCodering;
		$this->ObjectNaam = $ObjectNaam;
		$this->LeverancierEAN = $LeverancierEAN;
		$this->LeverancierNaam = $LeverancierNaam;
		$this->NetbeheerderEAN = $NetbeheerderEAN;
		$this->NetbeheerderNaam = $NetbeheerderNaam;
	}

	// compare to another VO
	function equals($vo) {
		return $this->ObjectID == $vo->ObjectID &&
			$this->NetBeheerderID == $vo->NetBeheerderID &&
			$this->LeverancierID == $vo->LeverancierID &&
			$this->IngangsDatumLeverancier == $vo->IngangsDatumLeverancier &&
			$this->StroomType == $vo->StroomType &&
			$this->ContractNummerNetbeheerder == $vo->ContractNummerNetbeheerder &&
			$this->ContractNummerLeverancier == $vo->ContractNummerLeverancier &&
			$this->GewijzigdDoor == $vo->GewijzigdDoor &&
			$this->GewijzigdOp == $vo->GewijzigdOp;
	}
	// copies another VO
	function copy($vo) {
		$this->ObjectID = $vo->ObjectID;
		$this->NetBeheerderID = $vo->NetBeheerderID;
		$this->LeverancierID = $vo->LeverancierID;
		$this->IngangsDatumLeverancier = $vo->IngangsDatumLeverancier;
		$this->StroomType = $vo->StroomType;
		$this->ContractNummerNetbeheerder = $vo->ContractNummerNetbeheerder;
		$this->ContractNummerLeverancier = $vo->ContractNummerLeverancier;
		$this->GewijzigdDoor = $vo->GewijzigdDoor;
		$this->GewijzigdOp = $vo->GewijzigdOp;
	}

	// output as a string
	function toString() {
		return $this->ObjectID . "," . $this->NetBeheerderID . "," . $this->LeverancierID . "," . $this->IngangsDatumLeverancier . "," . $this->StroomType . "," . $this->ContractNummerNetbeheerder . "," . $this->ContractNummerLeverancier . "," . $this->GewijzigdDoor . "," . $this->GewijzigdOp . "," . $this->EanCode . "," . $this->InterneCodering . "," . $this->ObjectNaam;
	}

	// output as XML node
	function toXML() {
		return "<row>\n" .
		"<ObjectID>$this->ObjectID</ObjectID>\n" .
		"<NetBeheerderID>$this->NetBeheerderID</NetBeheerderID>\n" .
		"<LeverancierID>$this->LeverancierID</LeverancierID>\n" .
		"<IngangsDatumLeverancier>$this->IngangsDatumLeverancier</IngangsDatumLeverancier>\n" .
		"<StroomType>$this->StroomType</StroomType>\n" .
		"<ContractNummerNetbeheerder>$this->ContractNummerNetbeheerder</ContractNummerNetbeheerder>\n" .
		"<ContractNummerLeverancier>$this->ContractNummerLeverancier</ContractNummerLeverancier>\n" .
		"<GewijzigdDoor>$this->GewijzigdDoor</GewijzigdDoor>\n" .
		"<GewijzigdOp>$this->GewijzigdOp</GewijzigdOp>\n" .
		"</row>\n";
	}

	// read from an html form
	function readForm() {
		$this->ObjectID = $this->formHelper("ObjectID", 0);
		$this->NetBeheerderID = $this->formHelper("NetBeheerderID", 0);
		$this->LeverancierID = $this->formHelper("LeverancierID", 0);
		$this->IngangsDatumLeverancier = $this->formHelper("IngangsDatumLeverancier", "");
		$this->StroomType = $this->formHelper("StroomType", 0);
		$this->ContractNummerNetbeheerder = $this->formHelper("ContractNummerNetbeheerder", "");
		$this->ContractNummerLeverancier = $this->formHelper("ContractNummerLeverancier", "");
		$this->GewijzigdDoor = $this->formHelper("GewijzigdDoor", 0);
		$this->GewijzigdOp = $this->formHelper("GewijzigdOp", "");
	}

	// read from the query string
	function readQuery() {
		$this->ObjectID = $this->queryHelper("ObjectID", 0);
		$this->NetBeheerderID = $this->queryHelper("NetBeheerderID", 0);
		$this->LeverancierID = $this->queryHelper("LeverancierID", 0);
		$this->IngangsDatumLeverancier = $this->queryHelper("IngangsDatumLeverancier", "");
		$this->StroomType = $this->queryHelper("StroomType", 0);
		$this->ContractNummerNetbeheerder = $this->queryHelper("ContractNummerNetbeheerder", "");
		$this->ContractNummerLeverancier = $this->queryHelper("ContractNummerLeverancier", "");
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
				// Gebruiker must be an integer
		if (!(ereg("^[0-9]+$", $this->LeverancierID)) || $this->LeverancierID == 0) $errors["LeverancierID"] = "Leverancier is niet correct";	
		// IngangsDatumLeverancier must be a valid date (http://php.net/manual/en/function.checkdate.php)
		if  (date('Y-n-j', strtotime($this->IngangsDatumLeverancier)) != $this->IngangsDatumLeverancier) $errors["IngangsDatumLeverancier"] = "Ingangsdatum is niet correct";
		// StroomType must be an array key
		if (!array_key_exists($this->StroomType,$cfg['values']['stroomtype'])) $errors["StroomType"] = "Stroomtype is niet correct";
		// ContractNummerLeverancier must be < 250 characters and not empty 
		if (strlen($this->ContractNummerLeverancier) > 250 || $this->ContractNummerLeverancier == "") $errors["ContractNummerLeverancier"] = "Contractnummer van leverancier is niet correct";
		// NetBeheerderID must be an integer
		if (!(ereg("^[0-9]+$", $this->NetBeheerderID)) || $this->NetBeheerderID == 0) $errors["NetBeheerderID"] = "Netbeheerder is niet correct";
		// ContractNummerNetbeheerder must be < 250 characters and not empty 
		if (strlen($this->ContractNummerNetbeheerder) > 250 || $this->ContractNummerNetbeheerder == "") $errors["ContractNummerNetbeheerder"] = "Contractnummer van netbeheerder is niet correct";
		// GewijzigdDoor must be an integer
		if (!(ereg("^[0-9]+$", $this->GewijzigdDoor))) $errors["GewijzigdDoor"] = "Gebruiker die wijzigt is niet correct";		
		// GewijzigdOp is inserted at time of query
	
		return($errors);
	}
	
	
}

?>